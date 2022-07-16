<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ShippingController,
    DriverController,
    TruckController
};

Route::apiResource('shippings', ShippingController::class);
Route::apiResource('drivers', DriverController::class);
Route::apiResource('trucks', TruckController::class);


Route::get('/', function () {
    return response()->json(['message' => 'success']);
});
