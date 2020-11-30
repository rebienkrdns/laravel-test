<?php

use App\Http\Controllers\apis\BuyersController;
use App\Http\Controllers\apis\SellersController;
use App\Http\Controllers\apis\ProductsController;
use App\Http\Controllers\Auth\AuthController;
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

Route::group(['prefix' => 'auth'], function () {
  Route::post('signup', [AuthController::class, 'signUp']);
  Route::post('login', [AuthController::class, 'login'])->name('login');

  Route::get('logout', [AuthController::class, 'logout'])
    ->middleware('auth:api');
});

Route::group(['middleware' => 'auth:api'], function () {
  Route::get('buyers', [BuyersController::class, 'list']);
  Route::get('buyers/{id}', [BuyersController::class, 'listOneBuyer']);

  Route::get('sellers', [SellersController::class, 'list']);
  Route::get('sellers/{id}', [SellersController::class, 'listOneSeller']);
  Route::post('sellers/product', [SellersController::class, 'storeProduct']);

  Route::get('products', [ProductsController::class, 'list']);
  Route::post('products/{id}/buy', [ProductsController::class, 'buy']);
});
