<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\KategoriMenuController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\TestimoniController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('frontend.home');
Route::get('/menu', [MenuController::class, 'frontend'])->name('frontend.menu');
Route::get('/about', function () {
    return view('frontend.about.index');
})->name('frontend.about');

// Reservasi - Frontend (public)
Route::post('/reservasi', [ReservasiController::class, 'store'])->name('reservasi.store');

// Default route - redirect to login
Route::get('/login', function () {
    return redirect()->route('login');
});

// Guest routes (accessible without authentication)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Logout route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Profile settings
Route::middleware('auth')->group(function () {
    Route::get('/profile', [AuthController::class, 'showProfile'])->name('profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [AuthController::class, 'updatePassword'])->name('profile.password');
});

// Protected routes - redirect to appropriate dashboard if already authenticated
Route::middleware('auth')->group(function () {
    // Admin routes (admin only)
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // Menu CRUD
        Route::resource('menu', MenuController::class)->except(['show']);
        Route::get('/menu/{menu}', [MenuController::class, 'show'])->name('menu.show');

        // Kategori Menu CRUD
        Route::resource('kategori', KategoriMenuController::class);

        // Testimoni CRUD
        Route::post('testimoni/sync', [TestimoniController::class, 'syncGoogleMaps'])->name('testimoni.sync');
        Route::resource('testimoni', TestimoniController::class)->except(['show']);

        // Reservasi CRUD
        Route::get('/reservasi', [ReservasiController::class, 'index'])->name('reservasi.index');
        Route::patch('/reservasi/{id}/status', [ReservasiController::class, 'updateStatus'])->name('reservasi.updateStatus');
        Route::delete('/reservasi/{id}', [ReservasiController::class, 'destroy'])->name('reservasi.destroy');

        // User CRUD
        Route::resource('user', UserController::class);
    });

    // User routes (user only)
    Route::middleware('user')->prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    });
});
