<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\v1\CustomerController;

Route::prefix('v1')->group(function () {

    //  Public
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login',[AuthController::class,'login']);

    //  Authenticated
    Route::middleware('auth:sanctum')->group(function () {

        Route::get('/profile', [UserController::class,'profile']);
        Route::put('/profile',[UserController::class,'updateProfile']);
        Route::post('/change-password',[UserController::class,'changePassword']);

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
    });

});
