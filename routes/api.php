<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ContractController,
    ShippingController,
    DriverController,
    TruckController
};

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ResetPasswordController;


/**
 * Auth
 */
Route::post('/auth', [AuthController::class, 'auth']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');

/**
 * Reset Password
 */
Route::post('/forgot-password', [ResetPasswordController::class, 'sendResetLink'])->middleware('guest');
Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword'])->middleware('guest');

//Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('shippings', ShippingController::class);
    Route::apiResource('drivers', DriverController::class);
    Route::apiResource('trucks', TruckController::class);

    Route::get('/shippings/index/{quantity}', [ShippingController::class, 'index']);
    Route::get('/shippings/{shipping_id}/status', [ShippingController::class, 'status']);

    Route::get('/contracts/{shipping_id}/{driver_id}', [ContractController::class, 'create']);
    Route::delete('/contracts/{shipping_id}/{driver_id}', [ContractController::class, 'delete']);
//});

Route::get('/', function () {
    return response()->json(['message' => 'success']);
});
