<?php

use App\Http\Controllers\Api\TodosController;
use App\Http\Controllers\Auth\SocialAuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use Laravel\Fortify\Features;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\ConfirmablePasswordController;
use Laravel\Fortify\Http\Controllers\ConfirmedPasswordStatusController;
use Laravel\Fortify\Http\Controllers\EmailVerificationNotificationController;
use Laravel\Fortify\Http\Controllers\EmailVerificationPromptController;
use Laravel\Fortify\Http\Controllers\NewPasswordController;
use Laravel\Fortify\Http\Controllers\PasswordController;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;
use Laravel\Fortify\Http\Controllers\ProfileInformationController;
use Laravel\Fortify\Http\Controllers\RecoveryCodeController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController;
use Laravel\Fortify\Http\Controllers\TwoFactorQrCodeController;
use Laravel\Fortify\Http\Controllers\VerifyEmailController;


// Social Login ...
Route::prefix('social-login')->group(function () {
    Route::get('/{provider}', [SocialAuthController::class, 'redirectToProvider'])
        ->middleware(['guest']);

    Route::get('/callback/{provider}', [SocialAuthController::class, 'handleProviderCallback'])
        ->middleware(['guest']);
});

// Get User ... data ...
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


// Email Verification ...
Route::prefix('email')->middleware(['auth:sanctum',])->group(function () {
    Route::get('/verify', [EmailVerificationPromptController::class, '__invoke'])
        ->name('verification.notice');

    /*Route::get('/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');*/

    Route::post('/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware(['throttle:6,1'])
        ->name('verification.send');
});
if (Features::enabled(Features::resetPasswords())) {
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->middleware(['guest'])
        ->name('password.email');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->middleware(['guest'])
        ->name('password.update');
}


// Main app URLs ...
Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::prefix('todos')->group(function () {
        Route::post('/addTask', [TodosController::class, 'addTask']);
        Route::put('/updateTask/{taskId}', [TodosController::class, 'updateTask']);
        Route::delete('/deleteTask/{taskId}', [TodosController::class, 'deleteTask']);
        Route::put('/move/{todoId}', [TodosController::class, 'moveTodo']);
        Route::apiResource('/', TodosController::class);
    });



//    Route::group(['middleware' => config('fortify.middleware', ['web'])], function () {
//        $enableViews = config('fortify.views', true);

    // Authentication...
    /*if ($enableViews) {
        Route::get('/login', [AuthenticatedSessionController::class, 'create'])
            ->middleware(['guest'])
            ->name('login');
    }*/


    // Password Reset...
//        if (Features::enabled(Features::resetPasswords())) {
//            if ($enableViews) {
//                Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
//                    ->middleware(['guest'])
//                    ->name('password.request');
//
//                Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
//                    ->middleware(['guest'])
//                    ->name('password.reset');
//            }
//
//            Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
//                ->middleware(['guest'])
//                ->name('password.email');
//
//            Route::post('/reset-password', [NewPasswordController::class, 'store'])
//                ->middleware(['guest'])
//                ->name('password.update');
//        }
//
//        // Registration...
//        if (Features::enabled(Features::registration())) {
//            if ($enableViews) {
//                Route::get('/register', [RegisteredUserController::class, 'create'])
//                    ->middleware(['guest'])
//                    ->name('register');
//            }
//
//            Route::post('/register', [RegisteredUserController::class, 'store'])
//                ->middleware(['guest']);
//        }
//
//        // Email Verification...
//        if (Features::enabled(Features::emailVerification())) {
//            if ($enableViews) {
//                Route::get('/email/verify', [EmailVerificationPromptController::class, '__invoke'])
//                    ->middleware(['auth'])
//                    ->name('verification.notice');
//            }
//
//            Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
//                ->middleware(['auth', 'signed', 'throttle:6,1'])
//                ->name('verification.verify');
//
//            Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
//                ->middleware(['auth', 'throttle:6,1'])
//                ->name('verification.send');
//        }
//
//        // Profile Information...
//        if (Features::enabled(Features::updateProfileInformation())) {
//            Route::put('/user/profile-information', [ProfileInformationController::class, 'update'])
//                ->middleware(['auth'])
//                ->name('user-profile-information.update');
//        }
//
//        // Passwords...
//        if (Features::enabled(Features::updatePasswords())) {
//            Route::put('/user/password', [PasswordController::class, 'update'])
//                ->middleware(['auth'])
//                ->name('user-password.update');
//        }
//
//        // Password Confirmation...
//        if ($enableViews) {
//            Route::get('/user/confirm-password', [ConfirmablePasswordController::class, 'show'])
//                ->middleware(['auth'])
//                ->name('password.confirm');
//
//            Route::get('/user/confirmed-password-status', [ConfirmedPasswordStatusController::class, 'show'])
//                ->middleware(['auth'])
//                ->name('password.confirmation');
//        }
//
//        Route::post('/user/confirm-password', [ConfirmablePasswordController::class, 'store'])
//            ->middleware(['auth']);
//
//        // Two Factor Authentication...
//        if (Features::enabled(Features::twoFactorAuthentication())) {
//            if ($enableViews) {
//                Route::get('/two-factor-challenge', [TwoFactorAuthenticatedSessionController::class, 'create'])
//                    ->middleware(['guest'])
//                    ->name('two-factor.login');
//            }
//
//            Route::post('/two-factor-challenge', [TwoFactorAuthenticatedSessionController::class, 'store'])
//                ->middleware(['guest']);
//
//            $twoFactorMiddleware = Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword')
//                ? ['auth', 'password.confirm']
//                : ['auth'];
//
//            Route::post('/user/two-factor-authentication', [TwoFactorAuthenticationController::class, 'store'])
//                ->middleware($twoFactorMiddleware);
//
//            Route::delete('/user/two-factor-authentication', [TwoFactorAuthenticationController::class, 'destroy'])
//                ->middleware($twoFactorMiddleware);
//
//            Route::get('/user/two-factor-qr-code', [TwoFactorQrCodeController::class, 'show'])
//                ->middleware($twoFactorMiddleware);
//
//            Route::get('/user/two-factor-recovery-codes', [RecoveryCodeController::class, 'index'])
//                ->middleware($twoFactorMiddleware);
//
//            Route::post('/user/two-factor-recovery-codes', [RecoveryCodeController::class, 'store'])
//                ->middleware($twoFactorMiddleware);
//        }
    //});
});

