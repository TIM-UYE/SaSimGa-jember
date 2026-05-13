<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriMenuController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MenuSpecialController;
use App\Http\Controllers\MenuSpecialItemController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\TestimoniController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Owner\AnalyticsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MidtransWebhookController;


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
| MIDTRANS WEBHOOK ROUTES (NO CSRF, NO AUTH)
| IMPORTANT: Must be excluded from CSRF validation in bootstrap/app.php
|--------------------------------------------------------------------------
*/

Route::post('/midtrans/webhook', [MidtransWebhookController::class, 'handle'])
    ->name('midtrans.webhook');

Route::get('/midtrans/finish', [MidtransWebhookController::class, 'finish'])
    ->name('midtrans.finish');

Route::get('/midtrans/unfinish', [MidtransWebhookController::class, 'unfinish'])
    ->name('midtrans.unfinish');

Route::get('/midtrans/error', [MidtransWebhookController::class, 'error'])
    ->name('midtrans.error');

// Test endpoint - REMOVE IN PRODUCTION
Route::post('/midtrans/test', function (\Illuminate\Http\Request $request) {
    \Illuminate\Support\Facades\Log::info('Midtrans Test Endpoint Hit', [
        'method' => $request->method(),
        'ip' => $request->ip(),
        'headers' => $request->headers->all(),
        'payload' => $request->all(),
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Midtrans webhook endpoint is accessible and responding',
        'timestamp' => now(),
        'test_mode' => true,
    ], 200);
})->name('midtrans.test');



/*
|--------------------------------------------------------------------------
| STATIC PAGES
|--------------------------------------------------------------------------
*/

Route::get('/faq', function () {

    return view('frontend.information.faq');

})->name('frontend.faq');


Route::get('/privacy-policy', function () {

    return view('frontend.information.privacy');

})->name('frontend.privacy');


Route::get('/terms-conditions', function () {

    return view('frontend.information.terms');

})->name('frontend.terms');


Route::get('/support', function () {

    return view('frontend.information.support');

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

Route::get('/reservasi/tables', [ReservasiController::class, 'getAvailableTables'])
    ->name('reservasi.tables');


/*
|--------------------------------------------------------------------------
| CART / KERANJANG
|--------------------------------------------------------------------------
*/

Route::get('/cart', [CartController::class, 'index'])
    ->name('cart.index');

Route::post('/cart/add/{id}', [CartController::class, 'add'])
    ->name('cart.add');

Route::post('/cart/add-special/{id}', [CartController::class, 'addSpecial'])
    ->name('cart.add-special');

Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])
    ->name('cart.remove');

Route::post('/cart/increment/{id}', [CartController::class, 'increment'])
    ->name('cart.increment');

Route::post('/cart/decrement/{id}', [CartController::class, 'decrement'])
    ->name('cart.decrement');

Route::post('/cart/update/{id}', [CartController::class, 'update'])
    ->name('cart.update');

Route::post('/cart/clear', [CartController::class, 'clear'])
    ->name('cart.clear');

Route::get('/cart/count', [CartController::class, 'count'])
    ->name('cart.count');


/*
|--------------------------------------------------------------------------
| CHECKOUT
|--------------------------------------------------------------------------
*/

Route::get('/checkout', [CheckoutController::class, 'index'])
    ->name('checkout.index');

Route::post('/checkout', [CheckoutController::class, 'store'])
    ->name('checkout.store');

Route::get('/checkout/success/{kodeOrder}', [CheckoutController::class, 'success'])
    ->name('checkout.success');


/*
|--------------------------------------------------------------------------
| SNAP PAYMENT ROUTES (Midtrans Snap)
|--------------------------------------------------------------------------
*/

Route::get('/payment/snap/{kodeOrder}', [\App\Http\Controllers\PaymentController::class, 'showSnap'])
    ->name('payment.snap');

Route::get('/payment/snap/{kodeOrder}/status', [\App\Http\Controllers\PaymentController::class, 'checkStatus'])
    ->name('payment.snap.status');

Route::get('/payment/success/{kodeOrder}', [\App\Http\Controllers\PaymentController::class, 'success'])
    ->name('payment.success');


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
| OWNER ROUTES (Read-only analytics dashboard)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:owner'])
    ->prefix('owner')
    ->name('owner.')
    ->group(function () {

        Route::get('/dashboard', [AnalyticsController::class, 'index'])
            ->name('dashboard');
    });


/*
|--------------------------------------------------------------------------
| ADMIN / MANAGER ROUTES (Full access backend)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,manager'])
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
        | ORDER MANAGEMENT
        |--------------------------------------------------------------------------
        */

        Route::get('/orders', [OrderController::class, 'index'])
            ->name('orders.index');

        Route::get('/orders/stats', [OrderController::class, 'stats'])
            ->name('orders.stats');

        // API endpoint for polling - returns JSON with updated order data
        // MUST be before the {order} wildcard route to avoid conflict
        Route::get('/orders/poll/data', [OrderController::class, 'pollData'])
            ->name('orders.poll');

        Route::get('/orders/{order}', [OrderController::class, 'show'])
            ->name('orders.show');

        Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])
            ->name('orders.updateStatus');

        Route::patch('/orders/{order}/payment-status', [OrderController::class, 'updatePaymentStatus'])
            ->name('orders.updatePaymentStatus');

        Route::delete('/orders/{order}', [OrderController::class, 'destroy'])
            ->name('orders.destroy');


        /*
        |--------------------------------------------------------------------------
        | SPECIAL MENU CRUD (Manager only - sensitive)
        |--------------------------------------------------------------------------
        */

        Route::middleware('role:manager')->group(function () {

            Route::resource('menu-specials', MenuSpecialController::class)
                ->except(['show']);

            Route::post('/menu-specials/{menu_special}/items', [MenuSpecialItemController::class, 'store'])
                ->name('menu-specials.items.store');

            Route::patch('/menu-specials/{menu_special}/items/{menu_special_item}', [MenuSpecialItemController::class, 'update'])
                ->name('menu-specials.items.update');

            Route::delete('/menu-specials/{menu_special}/items/{menu_special_item}', [MenuSpecialItemController::class, 'destroy'])
                ->name('menu-specials.items.destroy');

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
            | USER CRUD (Manager only)
            |--------------------------------------------------------------------------
            */

            Route::resource('user', UserController::class);
        });


        /*
        |--------------------------------------------------------------------------
        | RESERVASI CRUD (Admin & Manager)
        |--------------------------------------------------------------------------
        */

        Route::get('/reservasi', [ReservasiController::class, 'index'])
            ->name('reservasi.index');

        Route::patch('/reservasi/{id}/status', [ReservasiController::class, 'updateStatus'])
            ->name('reservasi.updateStatus');

        Route::delete('/reservasi/{id}', [ReservasiController::class, 'destroy'])
            ->name('reservasi.destroy');
    });


/*
|--------------------------------------------------------------------------
| USER ROUTES (Public frontend users)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        Route::get('/dashboard', [HomeController::class, 'index'])
            ->name('dashboard');
    });
