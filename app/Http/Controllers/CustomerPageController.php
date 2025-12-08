<?php

namespace App\Http\Controllers;

use App\Models\LaundryService;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CustomerPageController extends Controller
{
    // ==============================
    //  DASHBOARD
    // ==============================
    public function dashboard()
    {
        $userId = Auth::id();
        $statusColumn = 'status_pesanan';

        $totalOrders = Order::where('users_id', $userId)->count();

        $activeOrders = Order::where('users_id', $userId)
            ->whereIn($statusColumn, [
                'menunggu_penjemputan',
                'diproses',
                'siap_diambil',
                'dikirim'
            ])
            ->count();

        $completedOrders = Order::where('users_id', $userId)
            ->where($statusColumn, 'selesai')
            ->count();

        $latestOrders = Order::where('users_id', $userId)
            ->latest()
            ->take(3)
            ->get();

        return view('customer.dashboard', [
            'activeMenu'      => 'dashboard',
            'totalOrders'     => $totalOrders,
            'activeOrders'    => $activeOrders,
            'completedOrders' => $completedOrders,
            'latestOrders'    => $latestOrders,
        ]);
    }

    // ==============================
    //  LAYANAN
    // ==============================
    public function layanan()
    {
        $layanan = LaundryService::orderBy('created_at', 'desc')->get();

        return view('customer.layanan', [
            'services'   => $layanan,
            'activeMenu' => 'layanan'
        ]);
    }

    // ==============================
    //  RIWAYAT PESANAN
    // ==============================
    public function riwayatPesanan()
    {
        $orders = Order::with([
                'orderDetails.laundryService',
                'payment',
            ])
            ->where('users_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();

        return view('customer.riwayat_pesanan', [
            'orders'     => $orders,
            'activeMenu' => 'riwayat_pesanan',
        ]);
    }

    // ==============================
    //  DETAIL PESANAN
    // ==============================
    public function orderDetail($id)
    {
        $order = Order::with([
                'orderDetails.laundryService',
                'payment',
            ])
            ->where('users_id', Auth::id())
            ->where('id', $id)
            ->first();

        if (!$order) {
            return redirect()->route('customer.riwayat_pesanan')
                ->with('error', 'Pesanan tidak ditemukan.');
        }

        return view('customer.order_detail', [
            'order'      => $order,
            'activeMenu' => 'riwayat_pesanan'
        ]);
    }

    // ==============================
    //  PROFILE
    // ==============================
    public function profile()
    {
        return view('customer.profile', [
            'user'        => Auth::user(),
            'accountStatus' => 'aktif',
            'activeMenu'  => 'profile',
        ]);
    }

    // ==============================
    //  UPDATE PROFILE
    // ==============================
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name'  => ['required', 'string', 'max:100'],
            'email' => ['nullable', 'email', 'max:255'],
        ]);

        $validated = $validator->validate();

        $user->name = $validated['name'];

        if (!empty($validated['email'])) {
            $user->email = $validated['email'];
        }

        $user->save();

        return back()->with('success', 'Akun berhasil diperbarui.');
    }
}
