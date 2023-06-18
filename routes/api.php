<?php

use App\Http\Controllers\API\CheckoutController;
use App\Http\Controllers\API\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("produk", [ProductController::class, "index"]);
Route::get("transaksi/{transaction}", [CheckoutController::class, "index"]);
Route::post("transaksi", [CheckoutController::class, "store"]);
Route::get("payment/success", [CheckoutController::class, "midtransCallback"]);
Route::post("payment/success", [CheckoutController::class, "midtransCallback"]);
