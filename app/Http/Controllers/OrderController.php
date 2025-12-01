<?php

namespace App\Http\Controllers;
use App\Models\OrderStatusHistory;
use Illuminate\Support\Facades\Auth;
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
    $order->load([
        'user',
        'orderDetails.laundryService',
        'payment',
        'histories.user', // tambahkan ini
    ]);

    return view('admin.pesanan.show', compact('order'));
    }

    // Ubah status pesanan
    public function updateStatus(Request $request, Order $order)
    {
    $request->validate([
        'status'  => 'required|in:pending,proses,selesai,diambil,dibatalkan',
        'catatan' => 'nullable|string|max:255',
    ]);

    // 1. simpan status lama
    $statusLama = $order->status;
    $statusBaru = $request->status;

    // 2. update status di tabel orders
    $order->status = $statusBaru;
    $order->save();

    // 3. simpan catatan ke tabel order_status_histories
    OrderStatusHistory::create([
        'order_id'    => $order->id,
        'status_lama' => $statusLama,
        'status_baru' => $statusBaru,
        'catatan'     => $request->catatan,   // bisa kosong
        'changed_by'  => 0,          
    ]);

    return redirect()
        ->route('admin.orders.show', $order)
        ->with('success', 'Status pesanan berhasil diperbarui.');
    }

}
