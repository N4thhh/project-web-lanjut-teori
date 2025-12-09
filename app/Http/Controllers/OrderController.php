<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'payment'])
            ->orderByDesc('created_at')
            ->get();

        return view('admin.pesanan.index', compact('orders'));
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
        // 1. Validasi Input
        $request->validate([
            'status' => 'required|string',
            'details.*.berat' => 'nullable|numeric|min:0',
        ]);

        // 2. Ambil status lama (DB) dan baru (Form)
        $current = $order->status_pesanan ?? 'menunggu_penjemputan';
        $new     = $request->status;

        // 3. Aturan Alur Status
        $allowedFlow = [
            'menunggu_penjemputan' => ['menunggu_penjemputan', 'proses_penimbangan', 'dibatalkan'],
            'proses_penimbangan'   => ['proses_penimbangan', 'menunggu_pembayaran', 'dibatalkan'],
            'menunggu_pembayaran'  => ['menunggu_pembayaran', 'proses_pencucian', 'dibatalkan'],
            'proses_pencucian'     => ['proses_pencucian', 'pengiriman', 'selesai', 'dibatalkan'],
            'pengiriman'           => ['pengiriman', 'selesai'],
            'selesai'              => ['selesai', 'diambil'],
            'diambil'              => ['diambil'],
            'dibatalkan'           => ['dibatalkan'],
            // Fallback (Data Lama)
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

        $estimasiTotal = 0;
        if ($request->has('details')) {
            foreach ($request->input('details') as $detailId => $detailData) {
                $detail = $order->orderDetails()->whereKey($detailId)->first();
                if ($detail) {
                    $beratInput = $detailData['berat'] ?? 0;
                    $hargaSatuan = $detail->harga_satuan ?? 0;
                    $estimasiTotal += ($beratInput * $hargaSatuan);
                }
            }
        } else {
            $estimasiTotal = $order->total_harga;
        }

        $statusWajibBayar = [
            'menunggu_pembayaran',
            'proses_pencucian',
            'pengiriman',
            'selesai',
            'diambil'
        ];

        if (in_array($new, $statusWajibBayar) && $estimasiTotal <= 0) {
            return back()
                ->withErrors([
                    'status' => 'Gagal mengubah status! Berat cucian belum diinput. Silakan input berat terlebih dahulu.',
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

            // Update status otomatis ke 'menunggu_pembayaran'
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