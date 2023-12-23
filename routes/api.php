<?php

use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InventoryItemController;

use App\Models\Transaction;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserInventoryController;
use App\Http\Controllers\UserTransactionController;
use App\Models\ItemInventor;

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

Route::middleware('api')->group(function () {
   Route::resource('users', UserController::class);
});


Route::middleware('api')->group(function () {
   Route::resource('roles', RoleController::class);
});


Route::middleware('api')->group(function () {
   Route::resource('inventoryitems', InventoryItemController::class);
});

Route::get('/profile/{id}', [ProfileController::class, 'show']);

Route::middleware('api')->group(function () {
   Route::resource('inventory', UserInventoryController::class);
});


Route::middleware('api')->group(function () {
   Route::resource('transaction', UserTransactionController::class);
});




Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [RegisterController::class, 'register']);
Route::middleware('auth:sanctum')->post('/logout', [LoginController::class,'logout']);



Route::middleware(['role:user'])->group(function () {
   // Your editor routes here
});