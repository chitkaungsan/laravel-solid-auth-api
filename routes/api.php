<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\v1\CustomerController;
use App\Http\Controllers\Api\v1\BookingController;
use App\Http\Controllers\Api\v1\TourController;

Route::prefix('v1')->group(function () {

    //  Public
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    //  Authenticated
    Route::middleware('auth:sanctum')->group(function () {

        Route::get('/profile', [UserController::class, 'profile']);
        Route::put('/profile', [UserController::class, 'updateProfile']);
        Route::post('/change-password', [UserController::class, 'changePassword']);

        Route::post('/assign-role', [UserController::class, 'assignRole']);

        //  Customer CRUD with permission per action
        Route::apiResource('customers', CustomerController::class)
            ->middleware([
                'index' => 'permission:view customers',
                'show' => 'permission:view customers',
                'store' => 'permission:create customers',
                'update' => 'permission:update customers',
                'destroy' => 'permission:delete customers',
            ]);

        Route::apiResource('bookings', BookingController::class)
            ->middleware([
                'index' => 'permission:view bookings',
                'show' => 'permission:view bookings',
                'store' => 'permission:create bookings',
                'update' => 'permission:update bookings',
                'destroy' => 'permission:delete bookings',
            ]);
    });
});

Route::prefix('v1')->group(function () {
    Route::post('/tours', [TourController::class, 'store']);
});

Route::prefix('v1')->group(function () {
    Route::get('/tours', [TourController::class, 'index']);
});
