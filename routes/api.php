<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\v1\CustomerController;
use App\Http\Controllers\Api\v1\TourController;
use App\Http\Controllers\Api\v1\BookingController;

// Public routes
Route::prefix('v1')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

// Authenticated routes
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {

    // User profile
    Route::prefix('profile')->group(function () {
        Route::get('/', [UserController::class, 'profile']);
        Route::put('/update-profile', [UserController::class, 'updateProfile']);
        Route::post('/change-password', [UserController::class, 'changePassword']);
    });

    // Assign role
    Route::post('/assign-role', [UserController::class, 'assignRole']);

    // Customer routes
    Route::prefix('customers')->name('customer.')->group(function () {
        Route::get('/', [CustomerController::class, 'index'])->middleware('permission:view customers')->name('index');
        Route::get('/{customer}', [CustomerController::class, 'show'])->middleware('permission:view customers')->name('show');
        Route::post('/', [CustomerController::class, 'store'])->middleware('permission:create customers')->name('store');
        Route::put('/{customer}', [CustomerController::class, 'update'])->middleware('permission:update customers')->name('update');
        Route::delete('/{customer}', [CustomerController::class, 'destroy'])->middleware('permission:delete customers')->name('destroy');
    });

    // Tour routes
    Route::prefix('tours')->name('tour.')->group(function () {
        Route::get('/', [TourController::class, 'index'])->middleware('permission:view tours,sanctum')->name('index');
        Route::get('/{tour}', [TourController::class, 'show'])->middleware('permission:view tours,sanctum')->name('show');
        Route::post('/', [TourController::class, 'store'])->middleware('permission:create tours,sanctum')->name('store');
        Route::put('/{tour}', [TourController::class, 'update'])->middleware('permission:update tours,sanctum')->name('update');
        Route::delete('/{tour}', [TourController::class, 'destroy'])->middleware('permission:delete tours,sanctum')->name('destroy');
    });

        Route::prefix('bookings')->name('booking.')->group(function () {
        Route::get('/', [BookingController::class, 'index'])->middleware('permission:view bookings')->name('index');
        Route::get('/{booking}', [BookingController::class, 'show'])->middleware('permission:view bookings')->name('show');
        Route::post('/', [BookingController::class, 'store'])->middleware('permission:create bookings')->name('store');
        Route::put('/{booking}', [BookingController::class, 'update'])->middleware('permission:update bookings')->name('update');
        Route::delete('/{booking}', [BookingController::class, 'destroy'])->middleware('permission:delete bookings')->name('destroy');
    });
});
