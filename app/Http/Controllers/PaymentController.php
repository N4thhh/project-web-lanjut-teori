<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Tampilkan halaman pembayaran
     */
    public function show($orderId)
    {
        $order = Order::where('id', $orderId)
            ->where('users_id', Auth::id())
            ->with('payment')
            ->firstOrFail();

        // Cek apakah pesanan sudah dalam status yang bisa dibayar
        if ($order->status_pesanan === 'menunggu_penjemputan') {
            return back()->with('error', 'Pesanan belum ditimbang admin. Mohon tunggu admin menimbang cucian Anda terlebih dahulu.');
        }

        // Cek apakah total harga sudah dihitung
        if ($order->total_harga <= 0) {
            return back()->with('error', 'Total tagihan belum dihitung. Mohon tunggu admin memproses pesanan Anda.');
        }

        // Cek apakah sudah dibayar
        if ($order->status_pembayaran === 'lunas') {
            return back()->with('info', 'Pesanan ini sudah lunas.');
        }

        return view('customer.bayar', compact('order'));
    }

    /**
     * Proses upload bukti pembayaran
     */
    public function process(Request $request, $orderId)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'metode_pembayaran' => 'required|string',
        ], [
            'bukti_pembayaran.required' => 'Bukti pembayaran wajib diupload.',
            'bukti_pembayaran.image' => 'File harus berupa gambar.',
            'bukti_pembayaran.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
            'bukti_pembayaran.max' => 'Ukuran file maksimal 2MB.',
            'metode_pembayaran.required' => 'Metode pembayaran wajib dipilih.',
        ]);

        $order = Order::where('id', $orderId)
            ->where('users_id', Auth::id())
            ->firstOrFail();

        // Cek ulang status
        if ($order->status_pembayaran === 'lunas') {
            return back()->with('error', 'Pesanan ini sudah lunas.');
        }

        DB::beginTransaction();
        
        try {
            if ($request->hasFile('bukti_pembayaran')) {
                $file = $request->file('bukti_pembayaran');
                $filename = 'payment_' . $order->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('payment-proofs', $filename, 'public');

                // Hapus bukti lama jika ada
                if ($order->payment && $order->payment->bukti_pembayaran) {
                    Storage::disk('public')->delete($order->payment->bukti_pembayaran);
                }

                // Update atau buat payment record
                Payment::updateOrCreate(
                    ['order_id' => $order->id],
                    [
                        'metode_pembayaran' => $request->metode_pembayaran,
                        'jumlah_bayar' => $order->total_harga,
                        'bukti_pembayaran' => $path,
                        'status' => 'menunggu_verifikasi',
                        'tanggal_bayar' => now(),
                    ]
                );

                // Update status pembayaran order
                $order->update(['status_pembayaran' => 'sudah_bayar']);

                DB::commit();

                return redirect()->route('customer.riwayat-pesanan')
                    ->with('success', 'Bukti pembayaran berhasil diupload. Menunggu verifikasi admin.');
            }

            DB::rollBack();
            return back()->with('error', 'Gagal mengupload bukti pembayaran.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Payment upload failed', [
                'error' => $e->getMessage(),
                'order_id' => $orderId,
                'user_id' => Auth::id()
            ]);
            
            return back()->with('error', 'Terjadi kesalahan saat memproses pembayaran: ' . $e->getMessage());
        }
    }
}