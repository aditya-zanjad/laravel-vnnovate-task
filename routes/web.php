<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;

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

Route::middleware('guest')->get('/', function () {
    return view('welcome');
})->name('welcome');

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {
    // Users Routes
    Route::prefix('users')->name('users.')->controller(UserController::class)->group(function () {
        Route::middleware('verified')->get('index', 'index')->name('index');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::patch('update', 'update')->name('update');
    });

    // Shops Routes
    Route::prefix('shops')->name('shops.')->controller(ShopController::class)->group(function () {
        Route::get('index', 'index')->name('index');
        Route::get('products/{shopID}/index', 'shopProductsIndex')->name('products.index');
    });

    // Products Routes
    Route::prefix('products')->name('products.')->controller(ProductController::class)->group(function () {
        Route::get('index', 'index')->name('index');
    });
});
