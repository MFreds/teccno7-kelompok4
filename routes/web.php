<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ShowcaseController;
use App\Http\Controllers\BundleController;
use App\Http\Controllers\ItemController;

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

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware(['is_admin'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('home', [HomeController::class, 'AdminHome'])->name('home');
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
Route::prefix('bundle')->name('bundle.')->group(function () {
    Route::get('details/{uuid}', [BundleController::class, 'showBundle'])->name('show');

    Route::get('list',  [BundleController::class, 'getBundles'])->name('list');
});
