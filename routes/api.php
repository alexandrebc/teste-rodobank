<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShippingController;

Route::apiResource('shippings', ShippingController::class);




Route::get('/', function () {
    return response()->json(['message' => 'success']);
});
