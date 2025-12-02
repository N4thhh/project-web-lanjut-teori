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
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status_pesanan' => 'required|in:menunggu_penjemputan,proses,selesai,siap_diambil,selesai_diambil,dibatalkan',
        ]);

        $order->update([
            'status_pesanan' => $request->status_pesanan
        ]);

        return redirect()->back()
            ->with('success', 'Status pesanan berhasil diperbarui.');
    }
}