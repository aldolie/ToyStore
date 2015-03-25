<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;
use DB;

class Product extends Model {
	protected $table = 'product';
    
    public static function getProductsName()
	{
		$products = DB::table('product')->select('id as kode_barang','productname as nama_barang')->get();
        return $products;
	}
}
