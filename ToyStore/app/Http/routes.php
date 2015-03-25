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
	'password' => 'Auth\PasswordController',
]);


Route::get('/','HomeController@index');
Route::get('/Pembelian','HomeController@order_supply');

Route::group(['prefix' => 'apiv1', 'after' => 'allowOrigin'], function() {
    
    Route::get('/order/{id}', function ($id) {
        $orders = App\Models\Order::find($id);
        return Response::json(['status' => 200, 'result' => $orders->toArray()]);
    });
    
     Route::get('/product/', function () {
        $products = App\Models\Product::getProductsName();
        return Response::json(['status' => 200, 'result' => $products]);
    });

 
   
});
