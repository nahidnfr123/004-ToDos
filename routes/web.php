<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Route;

use Laravel\Fortify\Features;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\NewPasswordController;
use Laravel\Fortify\Http\Controllers\PasswordController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use Laravel\Fortify\Http\Controllers\VerifyEmailController;


Route::get('/welcome', function () {
    return view('welcome');
});

// Authentication ...
$limiter = config('fortify.limiters.login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware(array_filter([
        'guest',
        $limiter ? 'throttle:' . $limiter : null,
    ]))->name('login');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Fortify ....
/*if (Features::enabled(Features::registration())) {
    Route::post('/register', [RegisteredUserController::class, 'store'])->middleware(['guest']);
}*/
// Copied Code from Fortify
Route::post('/register', [RegisterController::class, 'store'])->middleware(['guest']);

// Email Verification ....
Route::get('email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    ->middleware(['auth', 'signed', 'throttle:6,1'])
    ->name('verification.verify'); // Verify and redirect user after clicking verification link ....
Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
    ->middleware(['guest'])
    ->name('password.reset');



Route::middleware(['auth', 'verified'])->group(function () {
    // Password ...
    Route::put('/user/password', [PasswordController::class, 'update'])
        ->name('user-password.update');
});

// End Fortify ...


Route::get('/', [BaseController::class, 'index'])->name('home');

Route::get('/{any}', [BaseController::class, 'index'])->where('any', '.*');


