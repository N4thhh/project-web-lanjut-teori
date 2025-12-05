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

        // Kolom status pesanan yang BENAR pada tabel orders
        $statusColumn = 'status_pesanan';

        // Total pesanan
        $totalOrders = Order::where('users_id', $userId)->count();

        // Pesanan aktif
        $activeOrders = Order::where('users_id', $userId)
            ->whereIn($statusColumn, [
                'menunggu_penjemputan',
                'diproses',
                'siap-diambil',
                'dikirim'
            ])
            ->count();

        // Pesanan selesai
        $completedOrders = Order::where('users_id', $userId)
            ->where($statusColumn, 'selesai')
            ->count();

        // 3 pesanan terbaru
        $latestOrders = Order::where('users_id', $userId)
            ->orderByDesc('created_at')
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
        $layanan = LaundryService::all();

        return view('customer.layanan', [
            'services' => $layanan,
            'activeMenu' => 'layanan'
        ]);
    }

    // ==============================
    //  RIWAYAT PESANAN
    // ==============================
    public function riwayatPesanan()
    {
        $orders = Order::with(['orderDetails.laundryService', 'payment'])
            ->where('users_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();

        return view('customer.riwayat_pesanan', [
            'orders' => $orders,
            'activeMenu' => 'riwayat_pesanan',
        ]);
    }

    // ==============================
    //  DETAIL PESANAN (TAMBAHAN)
    // ==============================
    public function orderDetail($id)
    {
        // Tidak menampilkan detail — langsung arahkan ke riwayat
        return redirect()->route('customer.riwayat_pesanan');
    }

    // ==============================
    //  PROFILE
    // ==============================
    public function profile()
    {
        $user = Auth::user();

        // Status akun → default aktif
        $accountStatus = 'aktif';

        return view('customer.profile', [
            'user'          => $user,
            'accountStatus' => $accountStatus,
            'activeMenu'    => 'profile',
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
