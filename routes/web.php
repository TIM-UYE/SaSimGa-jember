<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\KategoriMenuController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('frontend.home');
Route::get('/menu', [MenuController::class, 'frontend'])->name('frontend.menu');
Route::get('/about', function () {
    return view('Frontend.About.index');
})->name('frontend.about');

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

        // User CRUD
        Route::resource('user', UserController::class);
    });

    // User routes (user only)
    Route::middleware('user')->prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    });
});
