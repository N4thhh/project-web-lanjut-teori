<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function show($orderId)
    {
        $order = Order::where('id', $orderId)
            ->where('users_id', Auth::id())
            ->with('payment')
            ->firstOrFail();

        // Cek apakah sudah ditimbang (status proses)
        if ($order->status_pesanan === 'pending') {
            return back()->with('error', 'Pesanan belum ditimbang admin.');
        }

        return view('customer.bayar', compact('order'));
    }

    public function process(Request $request, $orderId)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'metode_pembayaran' => 'required|string',
        ]);

        $order = Order::where('id', $orderId)->where('users_id', Auth::id())->firstOrFail();

        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('payment-proofs', $filename, 'public');

            Payment::updateOrCreate(
                ['order_id' => $order->id],
                [
                    'metode_pembayaran' => $request->metode_pembayaran,
                    'jumlah_bayar'      => $order->total_harga,
                    'bukti_pembayaran'  => $path,
                    'status'            => 'menunggu_verifikasi',
                    'tanggal_bayar'     => now(),
                ]
            );

            $order->update(['status_pembayaran' => 'sudah_bayar']);

            return redirect()->route('customer.riwayat-pesanan')
                ->with('success', 'Bukti berhasil diupload, menunggu verifikasi admin.');
        }

        return back()->with('error', 'Gagal upload gambar.');
    }
}