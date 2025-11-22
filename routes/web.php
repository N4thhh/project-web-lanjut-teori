<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CustomerPageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminServiceController;
use App\Http\Controllers\CartController;

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
Route::middleware(['auth','role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // ==================== LAYANAN =====================
        Route::get('/layanan',        [AdminServiceController::class, 'index'])->name('layanan');
        Route::get('/layanan/create', [AdminServiceController::class, 'create'])->name('layanan.create');
        Route::post('/layanan',       [AdminServiceController::class, 'store'])->name('layanan.store');
        Route::get('/layanan/{id}/edit', [AdminServiceController::class, 'edit'])->name('layanan.edit');
        Route::put('/layanan/{id}',      [AdminServiceController::class, 'update'])->name('layanan.update');
        Route::delete('/layanan/{id}',   [AdminServiceController::class, 'destroy'])->name('layanan.destroy');

        // ==================== PESANAN =====================
        Route::get('/pesanan', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/pesanan/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::patch('/pesanan/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');

        // ==================== PELANGGAN =====================
        Route::get('/pelanggan', function () {
            return view('admin.pelanggan');
        })->name('pelanggan');
    });


// ==================== CUSTOMER ROUTES =====================
Route::middleware(['auth','role:customer'])
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {

        Route::get('/dashboard', [CustomerPageController::class, 'dashboard'])->name('dashboard');

        Route::get('/layanan', [CustomerPageController::class, 'layanan'])->name('layanan');

        Route::get('/riwayat-pesanan', [CustomerPageController::class, 'riwayatPesanan'])
            ->name('riwayat-pesanan');

        // === KERANJANG & CHECKOUT ===
        Route::post('/keranjang/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
        Route::delete('/keranjang/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
        Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
        Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');

        // ======================== PROFILE ========================
        Route::get('/profile', [CustomerPageController::class, 'profile'])->name('profile');

        Route::post('/profile/update', [CustomerPageController::class, 'updateProfile'])
            ->name('profile.update');
    });
