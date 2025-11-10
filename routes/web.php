<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CustomerPageController;

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

Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function() {
        return 'Ini Dashboard Admin';
    })->name('dashboard');
});

Route::middleware('role:customer')->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [CustomerPageController::class, 'dashboard'])->name('dashboard');
    Route::get('/layanan', [CustomerPageController::class, 'layanan'])->name('layanan');
});
