<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
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

/* Auth */

Route::prefix("admin")->name("admin.")->group(function () {
    Route::get('/', [DashboardController::class, "index"]);
});

/* non Auth */
Route::prefix("admin")->name("admin.")->group(function () {
    Route::get("login", [AuthController::class, "index"])->name("login.index");
});
