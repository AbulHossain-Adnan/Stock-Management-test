<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Stock\StockController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CustomLoginController;







Route::get('adminlogout', [CustomLoginController::class, 'adminlogout'])
->name('adminlogout');

// defult routes 
Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

// Products
Route::post('product/bulkdelete', [ProductController::class, 'bulkdelete']);
Route::resource('product',ProductController::Class);

// Stock 
Route::post('stock/bulkdelete', [StockController::class, 'bulkdelete']);
Route::resource('stock',StockController::Class);

// localization 
Route::get('local/{local}',[HomeController::class,'switch']);


Route::group(['domain' => 'domain1.test'], function () {

    Route::get('/test', function () {
       return "hello work";
    });

   
});









