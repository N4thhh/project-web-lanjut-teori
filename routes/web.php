<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CustomerPageController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('home');
})->middleware('guest');

Route::get('/register', [AuthController::class, 'showRegisterForm'])
    ->middleware('guest')
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->middleware('guest');

Route::get('/login', [AuthController::class, 'showLoginForm'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->middleware('guest');

Route::get('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::get('/home', function() {
    if (!Auth::user()) {
        Auth::logout();
        return redirect()->route('login')->withErrors(['email' => 'Sesi Anda telah berakhir.']);
    }
    $role = Auth::user()->role;
    if ($role === 'admin') {
        return redirect()->route('admin.dashboard');
    } else if ($role === 'customer') {
        return redirect()->route('customer.dashboard');
    }
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect()->route('login')->withErrors(['email' => 'Akun Anda tidak memiliki peran yang valid.']);
})->middleware('auth')->name('home');

// ======================= ADMIN ROUTES =======================
Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
    // Dashboard admin
    Route::get('/dashboard', function() {
        return view('admin.dashboard');
    })->name('dashboard');

    // Data Pesanan (Riwayat semua pesanan untuk admin)
    Route::get('/pesanan', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/pesanan/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('/pesanan/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');

    // Data Pelanggan
    Route::get('/pelanggan', function() {
        return view('admin.pelanggan');
    })->name('pelanggan');
});

// ===================== CUSTOMER ROUTES ======================
Route::middleware('role:customer')->prefix('customer')->name('customer.')->group(function () {
    // Dashboard customer
    Route::get('/dashboard', [CustomerPageController::class, 'dashboard'])->name('dashboard');

    // Halaman layanan
    Route::get('/layanan', [CustomerPageController::class, 'layanan'])->name('layanan');

    // Riwayat pesanan milik customer yang login
    Route::get('/riwayat-pesanan', [CustomerPageController::class, 'riwayatPesanan'])->name('riwayat-pesanan');
});
