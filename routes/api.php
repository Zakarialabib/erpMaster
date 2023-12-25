<?php

declare(strict_types=1);

use App\Http\Controllers\Api\ProductController as ProductApi;
use App\Http\Controllers\Api\CustomerController as CustomerApi;
use App\Http\Controllers\Api\CategoryController as CategoryApi;
use App\Http\Controllers\Api\OrderController as OrderApi;
use App\Http\Controllers\Api\UserController as UserApi;
use App\Http\Controllers\Api\SupplierController as SupplierApi;
use App\Http\Controllers\Api\ExpenseController as ExpenseApi;
use App\Http\Controllers\Api\RoleController as RoleApi;
use App\Http\Controllers\Api\WarehouseController as WarehouseApi;
use App\Http\Controllers\Api\AuthController as AuthApi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Register an user and create toeken access 
Route::post('/register', [AuthApi::class, 'register']);
Route::post('/login', [AuthApi::class, 'login']);

//login the user
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user-info', [AuthApi::class, 'userProfile']);
    Route::apiResource('products', ProductApi::class);
    Route::apiResource('categories', CategoryApi::class);
    Route::apiResource('customers', CustomerApi::class);
    Route::apiResource('orders', OrderApi::class);
    Route::post('/logout', [AuthApi::class, 'logout']);
});

Route::apiResource('users', UserApi::class);
Route::apiResource('suppliers', SupplierApi::class);
Route::apiResource('expenses', ExpenseApi::class);
Route::apiResource('roles', RoleApi::class);
Route::apiResource('warehouses', WarehouseApi::class);
