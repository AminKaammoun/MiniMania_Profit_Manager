<?php

use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TypeController;
use App\Models\Transaction;

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

Route::middleware('api')->group(function () {
    Route::resource('inventories', InventoryController::class);
 });

 Route::middleware('api')->group(function () {
    Route::resource('items', ItemController::class);
 });

 Route::middleware('api')->group(function () {
    Route::resource('transactions', TransactionController::class);
 });

 Route::middleware('api')->group(function () {
   Route::resource('types', TypeController::class);
});

Route::middleware('api')->group(function () {
   Route::resource('categories', CategoryController::class);
});