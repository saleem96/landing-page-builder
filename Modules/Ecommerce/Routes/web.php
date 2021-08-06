<?php

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


if (Module::find('Saas')) {
	Route::group(['middleware' => ['Modules\Saas\Http\Middleware\Billing','throttle:60,1']], function() {
		Route::post('order-submission/{item}', 'OrdersController@orderSubmission')->name('order-submission');
	});
}
else{
	Route::group(['middleware' => ['throttle:60,1']], function() {
		Route::post('order-submission/{item}', 'OrdersController@orderSubmission')->name('order-submission');
	});
}
Route::get('order-submission/{payment_order}/return', 'OrdersController@gateway_return')->name('order-submission.gateway.return');
Route::get('order-submission/{payment_order}/cancel', 'OrdersController@gateway_cancel')->name('order-submission.gateway.cancel');
Route::get('order-submission/{payment_order}/notify', 'OrdersController@gateway_notify')->name('order-submission.gateway.notify');


Route::middleware('auth')->group(function () {
	// ecommerce
	Route::prefix('ecommerce')->group(function() {
		Route::resource('products', 'ProductsController')->except('show');
		Route::prefix('products')->group(function() {
			Route::get('getproducts', 'ProductsController@getProducts')->name('products.getproducts');
		});

		Route::get('orders', 'OrdersController@index')->name('orders.index');
		Route::post('orders/{id}/{status}', 'OrdersController@updateStatus')->name('orders.updatestatus');
		Route::delete('orders/{id}/delete', 'OrdersController@delete')->name('orders.delete');

	});
	
	
});