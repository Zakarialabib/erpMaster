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

Route::post('/token', [
    'uses' => 'AccessTokenController@issueToken',
    'as' => 'token',
    'middleware' => 'throttle',
]);

Route::get('/authorize', [
    'uses' => 'AuthorizationController@authorize',
    'as' => 'authorizations.authorize',
    'middleware' => 'web',
]);

$guard = config('passport.guard', null);

Route::middleware(['web', $guard ? 'auth:'.$guard : 'auth'])->group(function () {
    Route::post('/token/refresh', [
        'uses' => 'TransientTokenController@refresh',
        'as' => 'token.refresh',
    ]);

    Route::post('/authorize', [
        'uses' => 'ApproveAuthorizationController@approve',
        'as' => 'authorizations.approve',
    ]);

    Route::delete('/authorize', [
        'uses' => 'DenyAuthorizationController@deny',
        'as' => 'authorizations.deny',
    ]);

    Route::get('/tokens', [
        'uses' => 'AuthorizedAccessTokenController@forUser',
        'as' => 'tokens.index',
    ]);

    Route::delete('/tokens/{token_id}', [
        'uses' => 'AuthorizedAccessTokenController@destroy',
        'as' => 'tokens.destroy',
    ]);

    Route::get('/clients', [
        'uses' => 'ClientController@forUser',
        'as' => 'clients.index',
    ]);

    Route::post('/clients', [
        'uses' => 'ClientController@store',
        'as' => 'clients.store',
    ]);

    Route::put('/clients/{client_id}', [
        'uses' => 'ClientController@update',
        'as' => 'clients.update',
    ]);

    Route::delete('/clients/{client_id}', [
        'uses' => 'ClientController@destroy',
        'as' => 'clients.destroy',
    ]);

    Route::get('/scopes', [
        'uses' => 'ScopeController@all',
        'as' => 'scopes.index',
    ]);

    Route::get('/personal-access-tokens', [
        'uses' => 'PersonalAccessTokenController@forUser',
        'as' => 'personal.tokens.index',
    ]);

    Route::post('/personal-access-tokens', [
        'uses' => 'PersonalAccessTokenController@store',
        'as' => 'personal.tokens.store',
    ]);

    Route::delete('/personal-access-tokens/{token_id}', [
        'uses' => 'PersonalAccessTokenController@destroy',
        'as' => 'personal.tokens.destroy',
    ]);
});

Route::get('/user-info', [AuthApi::class, 'userProfile']);

Route::apiResource('products', ProductApi::class);
Route::apiResource('categories', CategoryApi::class);
Route::apiResource('customers', CustomerApi::class);
Route::apiResource('orders', OrderApi::class);

Route::apiResource('users', UserApi::class);
Route::apiResource('suppliers', SupplierApi::class);
Route::apiResource('expenses', ExpenseApi::class);
Route::apiResource('roles', RoleApi::class);
Route::apiResource('warehouses', WarehouseApi::class);
