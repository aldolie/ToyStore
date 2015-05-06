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


Route::get('/test','WelcomeController@test');

Route::group(['prefix'=>'/','middleware'=>'authpagesignin'],function(){

    Route::post('/signin/action','HomeController@doSignin');
    Route::get('/signin/','HomeController@signin');
});



Route::group(['prefix'=>'/','middleware'=>'authpage'],function(){

    Route::get('/','HomeController@index');
    Route::get('/Pembelian/','HomeController@order_supply');
    Route::get('/Pembelian/Report/','HomeController@order_supply_report');
    Route::get('/Penjualan/','HomeController@order_purchase');
    Route::post('/Penjualan/','HomeController@update_purchase');
    Route::get('/Penjualan/Search/{invoice}','HomeController@update_purchaseView');

    Route::get('/Pembayaran/','HomeController@payment_supply');
    Route::get('/Tagihan/','HomeController@payment_purchase');
    Route::get('/Product/','HomeController@product_recapitulation');
    Route::get('/Penjualan/Report/','HomeController@order_purchase_report');
    Route::get('/Surat/Jalan/','HomeController@send_document');
    Route::get('/Surat/Jalan/Report/','HomeController@send_document_report');
    Route::get('/Konfigurasi/','HomeController@configuration');
    Route::get('/User/','HomeController@user');
    Route::get('/Konfigurasi/backup','HomeController@backup');
    Route::get('/Konfigurasi/delete','HomeController@delete');
    Route::post('/Konfigurasi/restore','HomeController@restore');
    Route::get('/logout/','HomeController@logout');

});


Route::group(['prefix' => 'apiv1', 'after' => 'allowOrigin'], function() {
    
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
    header('Access-Control-Allow-Credentials: true');


    Route::get('/product/rop',  [ 'uses' => 'Service\AdminController@getROP']);
    Route::get('/product/rop/load',  [ 'uses' => 'Service\AdminController@loadROP']);
    Route::post('/product/rop/save',  [ 'uses' => 'Service\AdminController@editROP']);
    Route::post('/product/rop/update',  [ 'uses' => 'Service\AdminController@updateROP']);
    
    Route::get('/product/auto/',  [ 'uses' => 'Service\AdminController@getProductsSimpleList']);
    Route::get('/product/recap',  [ 'uses' => 'Service\AdminController@getProductsRecapList']);
    Route::post('product/code/update',['uses'=>'Service\AdminController@updateProductCode']);


    Route::post('/order/supplier/save',  [ 'uses' => 'Service\AdminController@saveOrderSupplier']);
    Route::get('/order/supplier/id',  [ 'uses' => 'Service\AdminController@getNewOrderId']);
 	Route::get('/order/supplier/get',['uses'=>'Service\AdminController@getOrders']);   
   
    Route::get('/payment/supplier/get',['uses'=>'Service\AdminController@getPayment']);
    Route::post('/payment/supplier/detail/get',['uses'=>'Service\AdminController@getPaymentDetail']);
    Route::post('/payment/supplier/do',['uses'=>'Service\AdminController@doPayment']);  

    Route::get('/payment/purchase/get',['uses'=>'Service\AdminController@getPaymentPurchase']);
    Route::post('/payment/purchase/detail/get',['uses'=>'Service\AdminController@getPaymentPurchaseDetail']);
    Route::post('/payment/purchase/do',['uses'=>'Service\AdminController@doPaymentPurchase']); 
    Route::post('/payment/purchase/delete',['uses'=>'Service\AdminController@deletePaymentPurchase']);  
    
    
    Route::get('/order/purchase/id',  [ 'uses' => 'Service\AdminController@getNewPurchaseOrderId']);
    Route::post('/order/purchase/save',  [ 'uses' => 'Service\AdminController@saveOrderPurchase']);
    Route::post('/order/purchase/update',  [ 'uses' => 'Service\AdminController@updateOrderPurchase']);
    Route::post('/order/purchase/price/get',['uses'=>'Service\AdminController@getLastestPrice']);
    
    Route::post('/order/purchase/header/get',['uses'=>'Service\AdminController@getPurchaseHeader']);
    Route::post('/order/purchase/detail/get',['uses'=>'Service\AdminController@getPurchaseDetail']);
   
    Route::get('/order/purchase/get',['uses'=>'Service\AdminController@getPurchases']);
        

    Route::get('/user/current/id',['uses'=>'Service\AdminController@getCurrentUser']);
    Route::post('/order/purchase/getId',['uses'=>'Service\AdminController@getPurchaseById']);
    Route::post('/surat/jalan/save',['uses'=>'Service\AdminController@saveSuratJalan']);
    Route::get('/surat/jalan/get',['uses'=>'Service\AdminController@getSuratJalan']);
    Route::get('/surat/jalan/id',['uses'=>'Service\AdminController@getNewSendId']);
    Route::post('/surat/jalan/updatetrack',['uses'=>'Service\AdminController@updatetrack']);
    Route::post('/surat/jalan/delete',['uses'=>'Service\AdminController@deleteSuratJalan']);
    


    Route::post('/authenticate/user',['uses'=>'Service\AdminController@authenticateUser']);
    Route::post('/authenticate/user/check',['uses'=>'Service\AdminController@authenticateUserCheck']);
    Route::get('/user/get',['uses'=>'Service\AdminController@getUsers']);
    Route::post('/user/update',['uses'=>'Service\AdminController@updateUser']);
    Route::post('/user/delete',['uses'=>'Service\AdminController@deleteUser']);

   
});

Route::group(['prefix'=>'api','after'=>'allowOrigin'],function(){
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
    header('Access-Control-Allow-Credentials: true');
});