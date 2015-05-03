<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;
use DB;

class Product extends Model {
	protected $table = 'product';
    
    public static function getProductsName()
	{
		$products = DB::table('product')->select('id as kode_barang','productname as nama_barang',DB::raw('0 as harga'),'quantity')->get();
        return $products;
	}
    
    public static function getProductsRecap()
    {
        $products = DB::table('product')->select('id as kode_barang','code','productname as nama_barang','quantity',DB::raw('0 as harga'))->get();
        return $products;
    }

    public static function getROP($rop){
        $count=DB::table('product')->where('quantity','<',$rop)->count();
        return $count;
    }

    public static function updateCode($id,$code){
        DB::beginTransaction();
        try {
           
           DB::table('product')->where('id','=',$id)
                ->update(['code'=>$code]);
           DB::commit();
           return true;
            
        } catch (\Exception $e) {
            DB::rollback();
            
        }
        return false;
    }

}
