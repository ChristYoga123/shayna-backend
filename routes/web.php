<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductGalleryController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/* non Auth */

Route::get("/", function () {
    return view("welcome");
});

Route::prefix("admin")->name("admin.")->middleware("guest")->group(function () {
    Route::get("login", [AuthController::class, "index"])->name("login.index");
    Route::post("login", [AuthController::class, "login"])->name("login");
});

/* Auth */
Route::prefix("admin")->name("admin.")->middleware("auth")->group(function () {
    // Logout
    Route::post("logout", [AuthController::class, "logout"])->name("logout");
    // Dashboard
    Route::get('/', [DashboardController::class, "index"])->name("dashboard.index");
    // Product
    Route::resource("barang", ProductController::class);
    // Product Gallery
    Route::resource("galeri", ProductGalleryController::class)->only(["index", "create", "store", "destroy"]);
    // Transaction
    Route::resource('transaksi', TransactionController::class)->only(["index", "show"]);
});
