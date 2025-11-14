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

// ==================== GUEST HOME =====================

Route::get('/', function () {
    return view('home');
})->middleware('guest');

// ==================== AUTH =====================

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::get('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ==================== HOME REDIRECT =====================

Route::get('/home', function () {
    if (!Auth::user()) {
        Auth::logout();
        return redirect()->route('login')
            ->withErrors(['email' => 'Sesi Anda telah berakhir.']);
    }

    return match (Auth::user()->role) {
        'admin'    => redirect()->route('admin.dashboard'),
        'customer' => redirect()->route('customer.dashboard'),
        default    => redirect()->route('login')
                        ->withErrors(['email' => 'Akun Anda tidak memiliki peran yang valid.']),
    };
})->middleware('auth')->name('home');

// ==================== ADMIN ROUTES =====================

Route::middleware(['auth','role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Kelola pesanan
    Route::get('/pesanan', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/pesanan/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('/pesanan/{order}/status', [OrderController::class, 'updateStatus'])
        ->name('orders.update-status');

    // Data pelanggan
    Route::get('/pelanggan', function () {
        return view('admin.pelanggan');
    })->name('pelanggan');
});

// ==================== CUSTOMER ROUTES =====================

Route::middleware(['auth','role:customer'])
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {

        Route::get('/dashboard', [CustomerPageController::class, 'dashboard'])
            ->name('dashboard');

        Route::get('/layanan', [CustomerPageController::class, 'layanan'])
            ->name('layanan');

        Route::get('/riwayat-pesanan', [CustomerPageController::class, 'riwayatPesanan'])
            ->name('riwayat-pesanan');

        // ======================== PROFILE (TIDAK ERROR LAGI) ========================

        // Halaman profil
        Route::get('/profile', [CustomerPageController::class, 'profile'])
            ->name('profile');

        // Update profil
        Route::post('/profile/update', [CustomerPageController::class, 'updateProfile'])
            ->name('profile.update');

    });

