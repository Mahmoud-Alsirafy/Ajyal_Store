<?php

use App\Http\Controllers\Auth\SocialLogincontroller;
use App\Http\Controllers\Front\Auth\TwoFactorAuthenticationController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CheckOutController;
use App\Http\Controllers\Front\CurrencyConverterController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::post('/webhook/callback', function () {
    echo "webhook Called";
});

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function () {

    Route::get('/', [HomeController::class, 'index'])->middleware('auth.type:user,admin,super admin')->name('home');

    Route::get('/products', [\App\Http\Controllers\Front\ProductController::class, 'index'])->name('products.edit');
    Route::get('/products/{product:slug}', [\App\Http\Controllers\Front\ProductController::class, 'show'])->name('products.show');


    Route::get('/dashboard', function () {
        return view('Dashboard.index');
    })->middleware(['auth', 'verified',  'auth.type:admin,super admin'])->name('dashboard');

    Route::get('checkout', [CheckOutController::class, 'create'])->name('checkout');
    Route::post('checkout', [CheckOutController::class, 'store']);


    Route::resource('cart', CartController::class);

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    Route::get('auth/user/2fa', [TwoFactorAuthenticationController::class, 'index'])->name('user/2fa');

    Route::post('currency', [CurrencyConverterController::class, 'store'])->name('currency.store');
    // require __DIR__ . '/auth.php';
    require __DIR__ . '/dashboard.php';
});

Route::get('/auth/{provider}/redirect', [SocialLogincontroller::class, 'redirect'])->name('google.redirect');
Route::get('/auth/{provider}/callback', [SocialLogincontroller::class, 'callback'])->name('google.callback');
Route::get('/auth/{provider}/user', [SocialController::class, 'index']);
