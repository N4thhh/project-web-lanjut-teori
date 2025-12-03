<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class   OrderController extends Controller
{
    /**
     * Halaman daftar semua pesanan
     */
    public function index()
    {
        $orders = Order::with(['user', 'payment'])
            ->orderByDesc('created_at')
            ->get();

        return view('admin.pesanan.index', compact('orders'));
    }

    /**
     * Detail 1 pesanan
     */
    public function show(Order $order)
    {
        $order->load(['user', 'orderDetails.laundryService', 'payment']);

        return view('admin.pesanan.show', compact('order'));
    }

    public function edit(Order $order)
{
    $order->load([
        'user',
        'orderDetails.laundryService',
        'payment',
    ]);

    return view('admin.pesanan.edit', compact('order'));
}

public function update(Request $request, Order $order)
{
    // validasi dasar
    $request->validate([
        'status' => 'required|string',
        'details.*.berat' => 'nullable|numeric|min:0',
    ]);

    $current = $order->status ?? 'pending';
    $new     = $request->status;

    // aturan alur status
    $allowedFlow = [
        'pending'    => ['pending', 'proses', 'dibatalkan'],
        'proses'     => ['proses', 'selesai', 'dibatalkan'],
        'selesai'    => ['selesai', 'diambil'],
        'diambil'    => ['diambil'],
        'dibatalkan' => ['dibatalkan'],
    ];

    if (! isset($allowedFlow[$current])) {
        $current = 'pending';
    }

    // CEK: status tidak boleh mundur / lompat sembarangan
    if (! in_array($new, $allowedFlow[$current], true)) {
        return back()
            ->withErrors([
                'status' => 'Status tidak bisa diubah dari ' . ucfirst($current) . ' ke ' . ucfirst($new) . '.',
            ])
            ->withInput();
    }

    // update status
    $order->status = $new;
    $order->save();

    // update BERAT per detail (kalau ada di form)
    if ($request->has('details')) {
        foreach ($request->input('details') as $detailId => $detailData) {
            $detail = $order->orderDetails()->whereKey($detailId)->first();
            if (! $detail) continue;

            if (isset($detailData['berat'])) {
                $detail->berat = $detailData['berat'];

                // kalau ada harga_satuan, hitung ulang subtotal
                if (! is_null($detail->harga_satuan)) {
                    $detail->subtotal = $detail->harga_satuan * (float) $detail->berat;
                }

                $detail->save();
            }
        }

        // hitung ulang total_harga (opsional, kalau kolom ini ada)
        if ($order->relationLoaded('orderDetails')) {
            $order->load('orderDetails');
        }
        $order->total_harga = $order->orderDetails->sum('subtotal');
        $order->save();
    }

    return redirect()
        ->route('admin.orders.show', $order)
        ->with('success', 'Pesanan berhasil diperbarui');
}

    /**
     * Halaman form untuk update jumlah cucian (setelah penimbangan)
     */
    public function editWeights(Order $order)
    {
        $order->load(['user', 'orderDetails.laundryService']);

        return view('admin.pesanan.edit-weights', compact('order'));
    }

    /**
     * Update jumlah cucian dan hitung total (setelah penimbangan)
     */
    public function updateWeights(Request $request, Order $order)
    {
        // Validasi input
        $request->validate([
            'jumlah' => 'required|array',
            'jumlah.*' => 'required|numeric|min:0',
        ], [
            'jumlah.*.required' => 'Jumlah harus diisi untuk semua item.',
            'jumlah.*.numeric' => 'Jumlah harus berupa angka.',
            'jumlah.*.min' => 'Jumlah tidak boleh negatif.',
        ]);

        DB::beginTransaction();

        try {
            $totalHarga = 0;

            // Update setiap order detail
            foreach ($request->jumlah as $detailId => $jumlah) {
                $detail = OrderDetail::findOrFail($detailId);
                
                // Hitung subtotal
                $subtotal = $jumlah * $detail->harga_per_kg;
                
                // Update detail
                $detail->update([
                    'jumlah' => $jumlah,
                    'subtotal' => $subtotal,
                ]);

                $totalHarga += $subtotal;
            }

            // Update total harga order
            $order->update([
                'total_harga' => $totalHarga,
                'status_pesanan' => 'proses', // Ubah status jadi proses setelah ditimbang
            ]);

            // Buat atau update payment record
            Payment::updateOrCreate(
                ['order_id' => $order->id],
                [
                    'jumlah_bayar' => $totalHarga,
                    'status' => 'belum_bayar',
                ]
            );

            DB::commit();

            return redirect()->route('admin.pesanan.show', $order)
                ->with('success', 'Jumlah cucian dan total harga berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Ubah status pesanan
     */
/**
 * Ubah status pesanan
 */
public function updateStatus(Request $request, Order $order)
{
    $request->validate([
        'status' => 'required|string',
    ]);

    $current = $order->status;       // status sekarang di DB
    $new     = $request->status;     // status yang diminta

    // Aturan alur status:
    // - pending  -> pending, proses, dibatalkan
    // - proses   -> proses, selesai, dibatalkan
    // - selesai  -> selesai, diambil
    // - diambil  -> diambil (final)
    // - dibatalkan -> dibatalkan (final)
    $allowedFlow = [
        'pending'    => ['pending', 'proses', 'dibatalkan'],
        'proses'     => ['proses', 'selesai', 'dibatalkan'],
        'selesai'    => ['selesai', 'diambil'],
        'diambil'    => ['diambil'],
        'dibatalkan' => ['dibatalkan'],
    ];

    // kalau status sekarang tidak dikenal, anggap pending
    if (! isset($allowedFlow[$current])) {
        $current = 'pending';
    }

    // CEK: apakah status baru diizinkan dari status sekarang?
    if (! in_array($new, $allowedFlow[$current], true)) {
        return back()->withErrors([
            'status' => 'Status tidak bisa diubah dari ' . ucfirst($current) . ' ke ' . ucfirst($new) . '.',
        ]);
    }

    // kalau status sama, ga usah update apa-apa
    if ($current === $new) {
        return back()->with('success', 'Status pesanan tidak berubah.');
    }

    // update order
    $order->status = $new;
    $order->save();

    return redirect()
        ->route('admin.orders.show', $order)
        ->with('success', 'Status pesanan berhasil diperbarui');
}

}