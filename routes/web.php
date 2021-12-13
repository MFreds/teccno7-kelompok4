<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ShowcaseController;
use App\Http\Controllers\BundleController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('test')->group(function () {
    Route::get('showcase', [ShowcaseController::class, 'testThreeJs']);
});

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['is_admin'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('home', [HomeController::class, 'AdminHome'])->name('home');
        Route::get('item/data', [HomeController::class, 'itemData'])->name('item.data');
        Route::get('bundle/data', [HomeController::class, 'bundleData'])->name('bundle.data');
    });

    Route::prefix('service')->name('service.')->group(function () {
        Route::get('create', [ServiceController::class, 'createForm']);
        Route::post('create', [ServiceController::class, 'create'])->name('create');
    });

    Route::prefix('bundle')->name('bundle.')->group(function () {
        Route::get('create', [BundleController::class, 'createForm']);
        Route::post('create', [BundleController::class, 'create'])->name('create');
    });

    Route::prefix('item')->name('item.')->group(function () {
        Route::get('create', [ItemController::class, 'createForm']);
        Route::post('create', [ItemController::class, 'create'])->name('create');
    });

});

// bundle
Route::prefix('catalog')->name('catalog.')->group(function () {
    Route::get('/',  [CatalogController::class, 'getCatalogList'])->name('list');
});

// bundle
Route::prefix('bundle')->name('bundle.')->group(function () {
    Route::get('details/{uuid}', [BundleController::class, 'showBundle'])->name('show');

    Route::get('custom', [BundleController::class, 'customForm']);
    Route::post('custom', [BundleController::class, 'customCreate'])->name('custom.create');

    Route::get('list',  [BundleController::class, 'getBundles'])->name('list');
});

Route::prefix('item')->name('item.')->group(function () {
    Route::get('list',  [ItemController::class, 'getItems'])->name('list');

    Route::get('list',  [ItemController::class, 'getItemsv2'])->name('listv2');
    Route::get('{id}/edit',  [ItemController::class, 'edit'])->name('editv2');
    Route::put('{id}',  [ItemController::class, 'update'])->name('updatev2');
    Route::post('{id}/delete',  [ItemController::class, 'destroy'])->name('destroyv2');
});

Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'show'])->name('show');
    Route::post('cart/add/custom', [CartController::class, 'addCustomBundle'])->name('add.custom');
});

Route::prefix('order')->name('order.')->group(function () {
    Route::get('list', [OrderController::class, 'getOrder'])->name('list');
    Route::post('penjualan', [OrderController::class, 'getPejualanData'])->name('getPejualanData');

    Route::post('new', [OrderController::class, 'newOrder'])->name('new');
    Route::get('{id}', [OrderController::class, 'show'])->name('show');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');
