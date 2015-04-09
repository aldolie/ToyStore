<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;
use DB;

class Product extends Model {
	protected $table = 'product';
    
    public static function getProductsName()
	{
		$products = DB::table('product')->select('id as kode_barang','productname as nama_barang','price as harga','quantity')->get();
        return $products;
	}
    
    public static function getProductsRecap()
    {
        $products = DB::table('product')->select('id as kode_barang','productname as nama_barang','quantity','price as harga')->get();
        return $products;
    }
}
