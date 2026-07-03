<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/products/low-stock', [ProductController::class, 'lowStock'])
    ->name('products.lowStock');

Route::apiResource('products', ProductController::class);

Route::post('/products/{product}/stock', [ProductController::class, 'updateStock'])
    ->name('products.updateStock');
