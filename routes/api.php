<?php

use App\Http\Controllers\ApiCommandController;
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

Route::post("/bank/store", [ApiCommandController::class, "storeBank"]);
Route::get("/bank/update", [ApiCommandController::class, "updateBank"]);
Route::get("/bank/delete", [ApiCommandController::class, "deleteBank"]);
