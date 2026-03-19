<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\v1\CustomerController;
use App\Http\Controllers\Api\v1\BookingController;

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
        // Route::apiResource('customers', CustomerController::class)
        //     ->middleware([
        //         'index' => 'permission:view customers',
        //         'show' => 'permission:view customers',
        //         'store' => 'permission:create customers',
        //         'update' => 'permission:update customers',
        //         'destroy' => 'permission:delete customers',
        //     ]);

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

Route::get('/customers', [CustomerController::class, 'index'])
    ->middleware('permission:view customers,web');

Route::get('/customers/{customer}', [CustomerController::class, 'show'])
    ->middleware('permission:view customers,web');

Route::post('/customers', [CustomerController::class, 'store'])
    ->middleware('permission:create customers,web');

Route::put('/customers/{customer}', [CustomerController::class, 'update'])
    ->middleware('permission:update customers,web');

Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])
    ->middleware('permission:delete customers,web');
