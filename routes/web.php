<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CustomerPageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminServiceController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==================== GUEST HOME =====================
Route::get('/', function () {
    return view('home');
})->middleware('guest');

// ==================== AUTH (GUEST) =====================
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// ==================== AUTH (LOGGED IN) =====================
Route::middleware('auth')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // === VERIFIKASI OTP ===
    Route::get('/verify-otp', [AuthController::class, 'verifyNotice'])->name('verification.notice');
    Route::post('/verify-otp', [AuthController::class, 'verifyProcess'])->name('verification.verify');
});

// ==================== HOME REDIRECT =====================
Route::get('/home', function () {
    $user = Auth::user();

    if (!$user) {
        Auth::logout();
        return redirect()->route('login')->withErrors(['email' => 'Sesi Anda telah berakhir.']);
    }

    if ($user->email_verified_at == null) {
        return redirect()->route('verification.notice');
    }

    return match ($user->role) {
        'admin'    => redirect()->route('admin.dashboard'),
        'customer' => redirect()->route('customer.dashboard'),
        default    => redirect()->route('login')->withErrors(['email' => 'Akun Anda tidak memiliki peran valid.']),
    };
})->middleware('auth')->name('home');

// ==================== ADMIN ROUTES =====================
Route::middleware(['auth','role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminServiceController::class, 'dashboard'])->name('dashboard');

        // Layanan
        Route::get('/layanan', [AdminServiceController::class, 'index'])->name('layanan');
        Route::get('/layanan/create', [AdminServiceController::class, 'create'])->name('layanan.create');
        Route::post('/layanan', [AdminServiceController::class, 'store'])->name('layanan.store');
        Route::get('/layanan/{id}/edit', [AdminServiceController::class, 'edit'])->name('layanan.edit');
        Route::put('/layanan/{id}', [AdminServiceController::class, 'update'])->name('layanan.update');
        Route::delete('/layanan/{id}', [AdminServiceController::class, 'destroy'])->name('layanan.destroy');

        // Pesanan
        Route::get('/pesanan', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/pesanan/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::get('/pesanan/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
        Route::patch('/pesanan/{order}', [OrderController::class, 'update'])->name('orders.update');
        Route::patch('/pesanan/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::post('/pesanan/{order}/verify-payment', [OrderController::class, 'verifyPayment'])->name('orders.verify-payment');

        // Pelanggan
        Route::get('/pelanggan', function () {
            return view('admin.pelanggan');
        })->name('pelanggan');
    });

// ==================== CUSTOMER ROUTES =====================
Route::middleware(['auth','role:customer'])
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [CustomerPageController::class, 'dashboard'])->name('dashboard');

        // Layanan
        Route::get('/layanan', [CustomerPageController::class, 'layanan'])->name('layanan');

        // Riwayat Pesanan
        Route::get('/riwayat-pesanan', [CustomerPageController::class, 'riwayatPesanan'])
            ->name('riwayat_pesanan'); // <-- pastikan pakai underscore agar sama dengan Blade

        // Detail Pesanan
        Route::get('/pesanan/{id}', [CustomerPageController::class, 'orderDetail'])->name('order.detail');

        // Keranjang
        Route::post('/keranjang/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
        Route::delete('/keranjang/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
        Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');

        // Checkout
        Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');

        // Pembayaran
        Route::get('/pesanan/{id}/bayar', [PaymentController::class, 'show'])->name('payment.show');
        Route::post('/pesanan/{id}/bayar', [PaymentController::class, 'process'])->name('payment.process');

        // Profil
        Route::get('/profile', [CustomerPageController::class, 'profile'])->name('profile');
        Route::post('/profile/update', [CustomerPageController::class, 'updateProfile'])->name('profile.update');
    });
