<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        $deleted = Cart::where('id', $id)->where('user_id', Auth::id())->delete();
        
        if ($deleted) {
            return redirect()->back()->with('success', 'Item dihapus dari keranjang.');
        }
        
        return redirect()->back()->with('error', 'Item tidak ditemukan.');
    }

    public function checkout(Request $request)
    {
        $user = Auth::user();
        
        // Validasi
        $request->validate([
            'address' => 'required|string|min:10|max:500',
        ], [
            'address.required' => 'Alamat penjemputan wajib diisi!',
            'address.min' => 'Alamat minimal 10 karakter.',
            'address.max' => 'Alamat maksimal 500 karakter.',
        ]);

        $address = trim($request->address);
        
        if (empty($address)) {
            return redirect()->back()
                ->withErrors(['address' => 'Alamat tidak boleh kosong atau hanya berisi spasi.'])
                ->withInput();
        }

        // Cek keranjang
        $carts = Cart::where('user_id', $user->id)->with('service')->get();
        if ($carts->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang kosong. Silakan tambahkan layanan terlebih dahulu.');
        }

        DB::beginTransaction();
        
        try {
            // Update alamat user
            $user->update([
                'address' => $address
            ]);

            // Buat order
            $order = Order::create([
                'users_id' => $user->id,
                'status_pesanan' => 'menunggu_penjemputan',
                'status_pembayaran' => 'belum_bayar',
                'total_harga' => 0,
                'alamat' => $address,
            ]);

            // Buat order details - CHANGED: jumlah -> berat
            foreach ($carts as $cart) {
                $hargaPerKg = $cart->service->harga;
                
                OrderDetail::create([
                    'order_id' => $order->id,
                    'laundry_service_id' => $cart->service_id,
                    'harga_per_kg' => $hargaPerKg,
                    'harga_satuan' => $hargaPerKg,
                    'berat' => 0,
                    'subtotal' => 0
                ]);
            }

            // Hapus cart
            Cart::where('user_id', $user->id)->delete();

            DB::commit();

            return redirect()->route('customer.riwayat-pesanan')
                ->with('success', 'Pesanan berhasil dibuat! Kurir kami akan segera menjemput cucian Anda.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Checkout failed', [
                'error' => $e->getMessage(),
                'user_id' => $user->id
            ]);
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat membuat pesanan: ' . $e->getMessage())
                ->withInput();
        }
    }
}