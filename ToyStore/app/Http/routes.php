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
Route::get('/Pembelian/','HomeController@order_supply');
Route::get('/Pembelian/Report/','HomeController@order_supply_report');
Route::get('/Penjualan/','HomeController@order_purchase');
Route::get('/Pembayaran/','HomeController@payment_supply');
Route::get('/Product/','HomeController@product_recapitulation');
Route::get('/signin/','HomeController@signin');
Route::get('/Penjualan/Report/','HomeController@order_purchase_report');
Route::get('/Surat/Jalan/','HomeController@send_document');
Route::get('/Surat/Jalan/Report','HomeController@send_document_report');
Route::post('/signin/action','HomeController@doSignin');


Route::group(['prefix' => 'apiv1', 'after' => 'allowOrigin'], function() {
    
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
    header('Access-Control-Allow-Credentials: true');
    Route::get('/product/auto/',  [ 'uses' => 'Service\AdminController@getProductsSimpleList']);
    Route::get('/product/recap/',  [ 'uses' => 'Service\AdminController@getProductsRecapList']);
    Route::post('/order/supplier/save/',  [ 'uses' => 'Service\AdminController@saveOrderSupplier']);
    Route::get('/order/supplier/id/',  [ 'uses' => 'Service\AdminController@getNewOrderId']);
 	Route::get('/order/supplier/get/',['uses'=>'Service\AdminController@getOrders']);
	Route::get('/payment/supplier/get/',['uses'=>'Service\AdminController@getPayment']);
	Route::post('/payment/supplier/detail/get/',['uses'=>'Service\AdminController@getPaymentDetail']);	 
	Route::post('/payment/supplier/do/',['uses'=>'Service\AdminController@doPayment']);  
    Route::get('/order/purchase/id/',  [ 'uses' => 'Service\AdminController@getNewPurchaseOrderId']);
    Route::post('/order/purchase/save/',  [ 'uses' => 'Service\AdminController@saveOrderPurchase']);
    Route::get('/order/purchase/get/',['uses'=>'Service\AdminController@getPurchases']);
    Route::get('/user/current/id/',['uses'=>'Service\AdminController@getCurrentUser']);
    Route::post('/order/purchase/getId/',['uses'=>'Service\AdminController@getPurchaseById']);
    Route::post('/surat/jalan/save/',['uses'=>'Service\AdminController@saveSuratJalan']);
    Route::get('/surat/jalan/get/',['uses'=>'Service\AdminController@getSuratJalan']);
   
});

Route::group(['prefix'=>'api','after'=>'allowOrigin'],function(){
	header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
    header('Access-Control-Allow-Credentials: true');
    Route::post('authenticate/user/',['uses'=>'Service\AdminController@authenticateUser']);
});