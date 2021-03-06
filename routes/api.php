<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\api;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('app/product')->name('api.product.')->group(function () {
    Route::post('/getAllServices', [api\serviceApiController::class, 'getAllServices'])->name('getAllServices');
    Route::post('/getAllPromoHampers', [api\bundleApiController::class, 'getPromoBundles'])->name('getPromoBundles');
});

Route::prefix('app/item')->name('api.item.')->group(function() {
    Route::post('/getAllItem', [api\itemApiController::class, 'getAllItem'])->name('getAllItem');
    Route::get('/getSingleItem/{id}', [api\itemApiController::class, 'getSingleItem'])->name('getSingleItem');
});

Route::prefix('app/cart')->name('api.cart.')->group(function () {
    Route::post('/addItemToCart', [api\cartApiController::class, 'addItemToCart'])->name('addItemToCart');
});
