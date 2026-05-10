<?php

use Illuminate\Support\Facades\Route;
<<<<<<< Updated upstream
=======
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
Route::post('/cart/special-item/add/{id}', [CartController::class, 'addSpecialItem'])
    ->name('cart.special-item.add');
    
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
>>>>>>> Stashed changes

Route::get('/', function () {
    return view('welcome');
});
