<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Halaman daftar semua pesanan
    public function index()
    {
        $orders = Order::with(['user', 'payment'])
            ->orderByDesc('created_at')
            ->get();

        return view('admin.pesanan.index', compact('orders'));
    }

    // Detail 1 pesanan
    public function show(Order $order)
    {
        $order->load(['user', 'orderDetails.laundryService', 'payment']);

        return view('admin.pesanan.show', compact('order'));
    }

    // Ubah status pesanan
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,proses,selesai,diambil,dibatalkan',
        ]);

        $order->status = $request->status;
        $order->save();

        return redirect()
            ->route('admin.orders.show', $order)
            ->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
