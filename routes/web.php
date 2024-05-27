<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BankController;
use App\Http\Controllers\OrderFileController;
use App\Http\Controllers\ApiCommandController;
use App\Http\Controllers\BankBranchController;
use App\Http\Controllers\CheckInventoryController;
use App\Http\Controllers\FormCheckController;
use App\Http\Controllers\OrderFileUploadController;
use App\Http\Controllers\ProductConfigurationController;
use App\Http\Controllers\ProductTypeController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::resource("/branches", BankBranchController::class);
Route::resource("/banks", BankController::class);
Route::resource("/check_inventories", CheckInventoryController::class);
Route::resource("/form_checks", FormCheckController::class);
Route::resource("/product_types", ProductTypeController::class);
Route::resource("/product_configurations", ProductConfigurationController::class);

Route::controller(OrderFileController::class)->group(function(){
    Route::get("/order-files/show/{id}", "show")->name("order_files.show");
});


