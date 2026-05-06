<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriMenuController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\TestimoniController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| FRONTEND ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])
    ->name('frontend.home');

Route::get('/menu', [MenuController::class, 'frontend'])
    ->name('frontend.menu');

Route::get('/about', function () {

    return view('frontend.about.index');

})->name('frontend.about');


/*
|--------------------------------------------------------------------------
| STATIC PAGES
|--------------------------------------------------------------------------
*/

Route::get('/faq', function () {

    return view('frontend.sections.faq');

})->name('frontend.faq');


Route::get('/privacy-policy', function () {

    return view('frontend.sections.privacy');

})->name('frontend.privacy');


Route::get('/terms-conditions', function () {

    return view('frontend.sections.terms');

})->name('frontend.terms');


Route::get('/support', function () {

    return view('frontend.sections.support');

})->name('frontend.support');


/*
|--------------------------------------------------------------------------
| RESERVASI
|--------------------------------------------------------------------------
*/

Route::get('/reservasi', [ReservasiController::class, 'frontend'])
    ->name('frontend.reservasi');

Route::post('/reservasi', [ReservasiController::class, 'store'])
    ->name('reservasi.store');


/*
|--------------------------------------------------------------------------
| CART / KERANJANG
|--------------------------------------------------------------------------
*/

Route::get('/cart', [CartController::class, 'index'])
    ->name('cart.index');

Route::post('/cart/add/{id}', [CartController::class, 'add'])
    ->name('cart.add');

Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])
    ->name('cart.remove');


/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

// Redirect login lama
Route::get('/login-redirect', function () {

    return redirect()->route('login');

});


// Guest only
Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLoginForm'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegisterForm'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register']);
});


// Logout
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');


/*
|--------------------------------------------------------------------------
| PROFILE ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [AuthController::class, 'showProfile'])
        ->name('profile');

    Route::put('/profile', [AuthController::class, 'updateProfile'])
        ->name('profile.update');

    Route::put('/profile/password', [AuthController::class, 'updatePassword'])
        ->name('profile.password');
});


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', function () {

            return view('admin.dashboard');

        })->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | MENU CRUD
        |--------------------------------------------------------------------------
        */

        Route::resource('menu', MenuController::class)
            ->except(['show']);

        Route::get('/menu/{menu}', [MenuController::class, 'show'])
            ->name('menu.show');


        /*
        |--------------------------------------------------------------------------
        | KATEGORI CRUD
        |--------------------------------------------------------------------------
        */

        Route::resource('kategori', KategoriMenuController::class);


        /*
        |--------------------------------------------------------------------------
        | TESTIMONI CRUD
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/testimoni/sync',
            [TestimoniController::class, 'syncGoogleMaps']
        )->name('testimoni.sync');

        Route::resource('testimoni', TestimoniController::class)
            ->except(['show']);


        /*
        |--------------------------------------------------------------------------
        | RESERVASI CRUD
        |--------------------------------------------------------------------------
        */

        Route::get('/reservasi', [ReservasiController::class, 'index'])
            ->name('reservasi.index');

        Route::patch('/reservasi/{id}/status', [ReservasiController::class, 'updateStatus'])
            ->name('reservasi.updateStatus');

        Route::delete('/reservasi/{id}', [ReservasiController::class, 'destroy'])
            ->name('reservasi.destroy');


        /*
        |--------------------------------------------------------------------------
        | USER CRUD
        |--------------------------------------------------------------------------
        */

        Route::resource('user', UserController::class);
    });


/*
|--------------------------------------------------------------------------
| USER ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        Route::get('/dashboard', [HomeController::class, 'index'])
            ->name('dashboard');
    });
