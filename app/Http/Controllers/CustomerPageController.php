<?php

namespace App\Http\Controllers;

use App\Models\LaundryService;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;


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
    public function profile()
    {
    $user = Auth::user();

    // Tentukan status akun dari kolom yang umum
    $accountStatus = 'aktif';
    if (Schema::hasColumn('users', 'is_active')) {
        $accountStatus = $user->is_active ? 'aktif' : 'non-aktif';
    } elseif (Schema::hasColumn('users', 'status')) {
        $val = strtolower((string) $user->status);
        $accountStatus = in_array($val, ['1','true','aktif','active']) ? 'aktif' : 'non-aktif';
    } elseif (Schema::hasColumn('users', 'active')) {
        $accountStatus = $user->active ? 'aktif' : 'non-aktif';
    }

    return view('customer.profile', [
        'user'          => $user,
        'accountStatus' => $accountStatus,
        'activeMenu'    => 'profile',
    ]);
    }

    public function updateProfile(Request $request)
    {
    $user = Auth::user();

    // Validasi sederhana
    $validator = Validator::make($request->all(), [
        'name'  => ['required', 'string', 'max:100'],
        'email' => ['nullable', 'email', 'max:255'],
    ]);

    $validated = $validator->validate();

    $user->name = $validated['name'];

    // Kalau email diisi, update; kalau kosong, biarkan email lama
    if (!empty($validated['email'])) {
        $user->email = $validated['email'];
    }

    $user->save();

    return back()->with('success', 'Akun berhasil diperbarui.');
    }

}
