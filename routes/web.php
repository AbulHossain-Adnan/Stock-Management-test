<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Subcategory\SubcategoryController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\CustomLoginController;
use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Report\ReportController;
use App\Mail\EmailSend;
use Illuminate\Support\Facades\Mail;
use App\Models\Product;
use App\Jobs\EmailSendJob;









// custom login for admin
Route::get('/admin/login',[CustomLoginController::class, 'admin_login'])
->name('admin.login');
Route::POST('/login/post',[CustomLoginController::class, 'loginpost'])
->name('login.post');
Route::get('adminlogout', [CustomLoginController::class, 'adminlogout'])
->name('adminlogout');




Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Categories
Route::resource('category',CategoryController::Class);

// Subcategories
Route::resource('sub_category',SubcategoryController::Class);

// Products
Route::resource('product',ProductController::Class);

// Customers
Route::POST('customer/alldata', [CustomerController::class, 'alldata'])
->name('customer.alldata');
Route::get('customer/delete/{id}', [CustomerController::class, 'destroy'])->name('customer.delete');
Route::resource('customer',CustomerController::Class);



// Sales
Route::get('sales', [CartController::class, 'index'])
->name('sales.index');
Route::get('/addtocart/{id}', [CartController::class, 'addcart']);
Route::get('/cart_alldata', [CartController::class, 'cartdata']);
Route::get('/cartremove/{rowId}', [CartController::class, 'cartremove']);
Route::get('/qty_increment/{rowId}',[CartController::class,'increment']);
Route::get('/qty_decrement/{rowId}',[CartController::class,'decrement']);
Route::get('/cartcalculation',[CartController::class,'cartcalculation']);



// order
Route::get('/order',[OrderController::class,'index'])
->name('order.index');
Route::POST('/ordernow',[OrderController::class,'orderstore']);
Route::get('/paynow',[OrderController::class,'paynow']);
Route::get('order/details/{id}',[OrderController::class,'show']);
Route::DELETE('order/destroy/{id}',[OrderController::class,'destroy'])
->name('order.destroy');


// Report
Route::get('/sold_products',[ReportController::class,'sold_products']);
Route::get('/low_quantity',[ReportController::class,'low_quantity']);
Route::get('/top_customer',[ReportController::class,'topcustomer']);
Route::get('/eachproductsold',[ReportController::class,'eachproductsold']);
Route::get('/each_product_sold/view/{id}',[ReportController::class,'eachproductshow']);


Route::get('queue',function(){
	// $product=Product::first();
	 EmailSendJob::dispatch()
                    ->delay(now()->addSeconds(3));

	return "mail send properly";
});












