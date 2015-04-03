<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController'
    
]);


Route::get('/','HomeController@index');
Route::get('/Pembelian','HomeController@order_supply');
Route::get('/Pembelian/Report/','HomeController@order_supply_report');
Route::get('/Pembayaran/','HomeController@payment_supply');
Route::get('/Product/','HomeController@product_recapitulation');


Route::group(['prefix' => 'apiv1', 'after' => 'allowOrigin'], function() {
    
    
    Route::get('/product/auto/',  [ 'uses' => 'Service\AdminController@getProductsSimpleList']);
    Route::get('/product/recap/',  [ 'uses' => 'Service\AdminController@getProductsRecapList']);
    Route::post('/order/supplier/save/',  [ 'uses' => 'Service\AdminController@saveOrderSupplier']);
    Route::get('/order/supplier/id/',  [ 'uses' => 'Service\AdminController@getNewOrderId']);
 	Route::get('/order/supplier/get/',['uses'=>'Service\AdminController@getOrders']);
	Route::get('/payment/supplier/get/',['uses'=>'Service\AdminController@getPayment']);
	Route::post('/payment/supplier/detail/get/',['uses'=>'Service\AdminController@getPaymentDetail']);	 
	Route::post('/payment/supplier/do/',['uses'=>'Service\AdminController@doPayment']);  
});
