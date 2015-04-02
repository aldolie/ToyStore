<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;
use DB;

class OrderHeader extends Model {
	protected $table = 'order_supply_header';
	
    public static function getLastOrderId(){
     
        return DB::table('order_supply_header')->max('id');
    }
    

    public static function getOrders()
    {
        $orders = DB::table('order_supply_header')
            ->join('order_supply','order_supply_header.id','=','order_supply.orderid')
            ->join('product','product.id','=','order_supply.productid')
            ->select('order_supply_header.id as id','productname as nama_barang','supplier','currency','order_supply.price','order_supply.quantity','transactiondate as tanggal_transaksi')
            ->get();
        return $orders;
    }

    public static function insertOrder($userid,$supplier,$currency,$transactiondate,$shipper,$data)
	{

        DB::beginTransaction();
        try {
            
            $id = DB::table('order_supply_header')->insertGetId(['supplier' => $supplier, 'currency' => $currency,'transactiondate'=>$transactiondate,'shipped_by'=>$shipper,'created_by'=>$userid]);
           
            for($i=0;$i<count($data);$i++){
                if($data[$i]['kode_barang']==0){
                    $productid=DB::table('product')->insertGetId(['productname'=>$data[$i]['nama_barang'],'quantity'=>$data[$i]['quantity'],'price'=>0,'created_by'=>$userid]);
                    DB::table('order_supply')->insert(['orderid' => $id, 'productid' =>$productid,'price'=>$data[$i]['harga'],'quantity'=>$data[$i]['quantity'],'created_by'=>$userid]);  
                    
                }
                else{
                    DB::table('order_supply')->insert(['orderid' => $id, 'productid' => $data[$i]['kode_barang'],'price'=>$data[$i]['harga'],'quantity'=>$data[$i]['quantity'],'created_by'=>$userid]);
                    DB::table('product')->where('id', $data[$i]['kode_barang'])->increment('quantity',$data[$i]['quantity'] );
                }
                
            }
            
            DB::commit();
            return true;
            
        } catch (\Exception $e) {
            DB::rollback();
            
        }
		return false;
        
	}
    
}
