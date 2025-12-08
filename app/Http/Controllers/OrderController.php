<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // eager load sampai layanan
        $ordersQuery = Order::with(['user', 'payment', 'orderDetails.laundryService'])
            ->orderByDesc('created_at');

        if (!empty($search)) {
            $searchSlug = str_replace(' ', '_', strtolower($search));

            $ordersQuery->where(function ($query) use ($search, $searchSlug) {
                $query
                    // ID pesanan
                    ->where('id', 'like', "%{$search}%")

                    // Nama pelanggan
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })

                    // Tanggal
                    ->orWhere('created_at', 'like', "%{$search}%")

                    // Status pesanan
                    ->orWhere('status_pesanan', 'like', "%{$searchSlug}%")

                    // Total harga
                    ->orWhere('total_harga', 'like', "%{$search}%")

                    // Status & jumlah pembayaran
                    ->orWhereHas('payment', function ($q) use ($search, $searchSlug) {
                        $q->where('status', 'like', "%{$searchSlug}%")
                        ->orWhere('jumlah_bayar', 'like', "%{$search}%");
                    })

                    // 🔥 Nama layanan (dari LaundryService)
                    // 🔥 Nama layanan (dari LaundryService)
                    ->orWhereHas('orderDetails.laundryService', function ($q) use ($search) {
                        $q->where('nama_layanan', 'like', "%{$search}%");
                    });

            });
        }

        $orders = $ordersQuery->get();

        return view('admin.pesanan.index', [
            'orders' => $orders,
            'search' => $search,
        ]);
    }

    public function show(Order $order)
    {
        $order->load(['user', 'orderDetails.laundryService', 'payment']);
        return view('admin.pesanan.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $order->load(['user', 'orderDetails.laundryService', 'payment']);
        return view('admin.pesanan.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string',
            'details.*.berat' => 'nullable|numeric|min:0',
        ]);

        $current = $order->status_pesanan ?? 'menunggu_penjemputan';
        $new     = $request->status;

        $allowedFlow = [
            'menunggu_penjemputan' => ['menunggu_penjemputan', 'proses_penimbangan', 'dibatalkan'],
            'proses_penimbangan'   => ['proses_penimbangan', 'menunggu_pembayaran', 'dibatalkan'],
            'menunggu_pembayaran'  => ['menunggu_pembayaran', 'proses_pencucian', 'dibatalkan'],
            'proses_pencucian'     => ['proses_pencucian', 'pengiriman', 'selesai', 'dibatalkan'],
            'pengiriman'           => ['pengiriman', 'selesai'],
            'selesai'              => ['selesai', 'diambil'],
            'diambil'              => ['diambil'],
            'dibatalkan'           => ['dibatalkan'],
            'pending' => ['menunggu_penjemputan', 'proses_penimbangan', 'dibatalkan'],
            'proses'  => ['proses_penimbangan', 'menunggu_pembayaran'],
        ];

        if (! isset($allowedFlow[$current])) {
            $current = 'menunggu_penjemputan';
        }

        if (! in_array($new, $allowedFlow[$current], true)) {
            $currText = ucwords(str_replace('_', ' ', $current));
            $newText  = ucwords(str_replace('_', ' ', $new));
            
            return back()
                ->withErrors([
                    'status' => "Status tidak bisa diubah dari '$currText' ke '$newText'.",
                ])
                ->withInput();
        }

        $order->status_pesanan = $new;
        $order->save();

        if ($request->has('details')) {
            foreach ($request->input('details') as $detailId => $detailData) {
                $detail = $order->orderDetails()->whereKey($detailId)->first();
                if ($detail && isset($detailData['berat'])) {
                    $detail->berat = $detailData['berat'];
                    if (! is_null($detail->harga_satuan)) {
                        $detail->subtotal = $detail->harga_satuan * (float) $detail->berat;
                    }
                    $detail->save();
                }
            }

            if ($order->relationLoaded('orderDetails')) {
                $order->load('orderDetails');
            }
            $totalHarga = $order->orderDetails->sum('subtotal');
            $order->total_harga = $totalHarga;

            if ($totalHarga > 0 && in_array($order->status_pesanan, ['menunggu_penjemputan', 'proses_penimbangan'])) {
                $order->status_pesanan = 'menunggu_pembayaran';
            }

            $order->save();

            if ($totalHarga > 0) {
                $payment = Payment::firstOrNew(['order_id' => $order->id]);
                
                $payment->jumlah_bayar = $totalHarga;

                if (! $payment->exists) {
                    $payment->status = 'belum_bayar';
                    $payment->metode_pembayaran = 'belum_dipilih'; 
                }

                $payment->save();
            }
        }

        return redirect()
            ->route('admin.orders.show', $order)
            ->with('success', 'Pesanan berhasil diperbarui');
    }

    public function editWeights(Order $order)
    {
        $order->load(['user', 'orderDetails.laundryService']);
        return view('admin.pesanan.edit-weights', compact('order'));
    }

    public function updateWeights(Request $request, Order $order)
    {
        $request->validate([
            'jumlah' => 'required|array',
            'jumlah.*' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $totalHarga = 0;
            foreach ($request->jumlah as $detailId => $jumlah) {
                $detail = OrderDetail::findOrFail($detailId);
                $subtotal = $jumlah * $detail->harga_per_kg;
                $detail->update(['berat' => $jumlah, 'subtotal' => $subtotal]);
                $totalHarga += $subtotal;
            }

            $order->update([
                'total_harga' => $totalHarga,
                'status_pesanan' => 'menunggu_pembayaran', 
            ]);

            Payment::updateOrCreate(
                ['order_id' => $order->id],
                [
                    'jumlah_bayar' => $totalHarga,
                    'status' => 'belum_bayar',
                    'metode_pembayaran' => 'belum_dipilih', 
                ]
            );

            DB::commit();
            return redirect()->route('admin.pesanan.show', $order)->with('success', 'Berat diupdate. Menunggu pembayaran customer.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function verifyPayment(Order $order)
    {
        $order->load('payment');
        if (!$order->payment) return back()->with('error', 'Data pembayaran tidak ditemukan.');

        $order->payment->update(['status' => 'lunas', 'tanggal_bayar' => now()]);
        
        $order->update([
            'status_pembayaran' => 'lunas',
            'status_pesanan' => 'proses_pencucian' 
        ]);

        return back()->with('success', 'Pembayaran diverifikasi LUNAS. Status lanjut ke Proses Pencucian.');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|string']);
        $order->status_pesanan = $request->status;
        $order->save();
        return redirect()->route('admin.orders.show', $order)->with('success', 'Status updated');
    }
}