<?php

namespace App\Http\Controllers;

use App\Models\LaundryService;
use App\Models\Order; // ⬅️ penting
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerPageController extends Controller
{
    public function dashboard()
    {
        return view('customer.dashboard', ['activeMenu' => 'dashboard']);
    }

    public function layanan()
    {
        $layanan = LaundryService::all();
        
        return view('customer.layanan', [
            'services' => $layanan,
            'activeMenu' => 'layanan'
        ]);
    }

    public function riwayatPesanan()
    {
        $orders = Order::with(['orderDetails.laundryService', 'payment'])
            ->where('users_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();

        return view('customer.riwayat_pesanan', [
            'orders' => $orders,
            'activeMenu' => 'riwayat-pesanan',
        ]);
    }
}
