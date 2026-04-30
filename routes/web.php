<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\KategoriMenuController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('frontend.pages.home');
});

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
        Route::get('/dashboard', function () {
            return view('frontend.pages.home');
        })->name('dashboard');
    });
});
