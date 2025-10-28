<?php

use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

Route::apiResource('customers', CustomerController::class);
Route::apiResource('products', ProductController::class);
