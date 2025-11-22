<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::where('user_id', Auth::id())->with('service')->get();
        return view('customer.cart', compact('carts'));
    }

    public function addToCart($serviceId)
    {
        $userId = Auth::id();

        // Cek apakah item sudah ada?
        $cartItem = Cart::where('user_id', $userId)
                        ->where('service_id', $serviceId)
                        ->first();

        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            Cart::create([
                'user_id' => $userId,
                'service_id' => $serviceId,
                'quantity' => 1
            ]);
        }

        return redirect()->back()->with('success', 'Layanan berhasil masuk keranjang!');
    }

    public function destroy($id)
    {
        Cart::where('id', $id)->where('user_id', Auth::id())->delete();
        return redirect()->back()->with('success', 'Item dihapus dari keranjang.');
    }

    public function checkout()
    {
        $user = Auth::user();
        $carts = Cart::where('user_id', $user->id)->with('service')->get();

        if ($carts->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang kosong.');
        }

        $order = Order::create([
            'user_id' => $user->id,
            'status_pesanan' => 'menunggu_penjemputan',
            'status_pembayaran' => 'belum_bayar',
            'total_harga' => 0, 
        ]);

        foreach ($carts as $cart) {
            OrderDetail::create([
                'order_id' => $order->id,
                'laundry_service_id' => $cart->service_id,
                'harga_per_kg' => $cart->service->harga, 
                'jumlah' => 0,
                'subtotal' => 0
            ]);
        }

        Cart::where('user_id', $user->id)->delete();

        return redirect()->route('customer.riwayat-pesanan')
            ->with('success', 'Pesanan berhasil dibuat! Kurir kami akan segera menjemput cucian Anda.');
    }
}