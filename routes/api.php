<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ContractController,
    ShippingController,
    DriverController,
    TruckController
};

Route::apiResource('shippings', ShippingController::class);
Route::apiResource('drivers', DriverController::class);
Route::apiResource('trucks', TruckController::class);

Route::get('/contracts/{shipping_id}/{driver_id}', [ContractController::class, 'create']);
Route::delete('/contracts/{shipping_id}/{driver_id}', [ContractController::class, 'delete']);

Route::get('/', function () {
    return response()->json(['message' => 'success']);
});
