<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;
use DB;

class PurchaseHeader extends Model {
	protected $table = 'order_purchase_header';
	
    public static function getLastOrderId(){
     
        return DB::table('order_purchase_header')->max('id');
    }
    
/*
    public static function getOrders()
    {
        $orders = DB::table('order_supply_header')
            ->join('order_supply','order_supply_header.id','=','order_supply.orderid')
            ->join('product','product.id','=','order_supply.productid')
            ->select('order_supply_header.id as id','productname as nama_barang','supplier','currency','order_supply.price','order_supply.quantity','transactiondate as tanggal_transaksi')
            ->get();
        return $orders;
    }

    */
    public static function insertOrder($userid,$customer,$transactiondate,$isSalesOrder,$discount,$dp,$data)
	{
        $isSalesOrder=($isSalesOrder?1:0);
        $error=[];
        DB::beginTransaction();
        try {
            
             for($i=0;$i<count($data);$i++){
                $product=DB::table('product')->where('id', $data[$i]['kode_barang'])
                        ->select('id as kode_barang','quantity')->first();
                if(($product->quantity)-$data[$i]['quantity'] <0){
                    $error[$i]=$product;
                    
                }
            }
            if(count($error)>0)
            return ['status'=>false,'error_code'=>-1,'products'=>$error];

            $id = DB::table('order_purchase_header')->insertGetId(['customer' => $customer, 'is_sales_order' => $isSalesOrder,'transactiondate'=>$transactiondate,'discount'=>$discount,'created_by'=>$userid]);
            //Insert DP HERE
            for($i=0;$i<count($data);$i++){
                DB::table('order_purchase')->insert(['purchaseid' => $id, 'productid' => $data[$i]['kode_barang'],'price'=>$data[$i]['harga'],'quantity'=>$data[$i]['quantity'],'created_by'=>$userid]);
                DB::table('product')->where('id', $data[$i]['kode_barang'])->decrement('quantity',$data[$i]['quantity'] );
            }
            
            DB::commit();
            return ['status'=>true];
            
        } catch (\Exception $e) {
            DB::rollback();
            
        }
		return ['status'=>false,'error_code'=>-2];
        
	}
    
}
