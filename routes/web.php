<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Stock\StockController;











Route::get('adminlogout', [App\Http\Controllers\CustomLoginController::class, 'adminlogout'])
->name('adminlogout');

// defult routes 
Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Products
Route::post('product/bulkdelete', [App\Http\Controllers\Product\ProductController::class, 'bulkdelete']);
Route::resource('product',ProductController::Class);

// Stock 
Route::post('stock/bulkdelete', [App\Http\Controllers\Stock\StockController::class, 'bulkdelete']);
Route::resource('stock',StockController::Class);

// localization 
Route::get('local/{local}',[App\Http\Controllers\HomeController::class,'switch']);










