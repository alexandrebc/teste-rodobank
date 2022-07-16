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

Route::middleware(['auth:sanctum'])->group(function () {
    /**
     * get('/model') => index
     * post('/model') => store
     * get('/model/{model_id}') => show
     * put('/model/{model_id}') => update
     * delete('/model/{model_id}') => delete
     */

    Route::apiResource('shippings', ShippingController::class);
    Route::apiResource('drivers', DriverController::class);
    Route::apiResource('trucks', TruckController::class);

    /**
     * Listagem de cada model com paginação definida pelo usuário
     */

    Route::get('/shippings/index/{quantity}', [ShippingController::class, 'index']);
    Route::get('/drivers/index/{quantity}', [DriverController::class, 'index']);
    Route::get('/trucks/index/{quantity}', [TruckController::class, 'index']);

    /**
     * Mudança de status da Transportadora
     */

    Route::get('/shippings/{shipping_id}/status', [ShippingController::class, 'status']);

    /**
     * Criação e destruição do vínculo entre motorista e transportadora
     */
    Route::get('/contracts/{shipping_id}/{driver_id}', [ContractController::class, 'create']);
    Route::delete('/contracts/{shipping_id}/{driver_id}', [ContractController::class, 'delete']);
});

Route::get('/', function () {
    return response()->json(['message' => 'success']);
});
