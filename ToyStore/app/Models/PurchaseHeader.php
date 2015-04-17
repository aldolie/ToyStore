<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;
use DB;

class PurchaseHeader extends Model {
	protected $table = 'order_purchase_header';
	
    public static function getLastOrderId(){
     
        return DB::table('order_purchase_header')->max('id');
    }
    

    public static function getPurchase()
    {
        $purchase = DB::table('order_purchase_header')
            ->join('order_purchase','order_purchase_header.id','=','order_purchase.purchaseid')
            ->join('product','product.id','=','order_purchase.productid')
            ->select('order_purchase_header.invoice','order_purchase_header.id as id','productname as nama_barang','customer','order_purchase.price','order_purchase.quantity','transactiondate as tanggal_transaksi')
            ->get();
        return $purchase;
    }

    public static function getPurchaseById($id){
        $purchase = DB::table('order_purchase_header')
            ->join('order_purchase','order_purchase_header.id','=','order_purchase.purchaseid')
            ->join('product','product.id','=','order_purchase.productid')
            ->leftJoin(DB::Raw('(SELECT purchaseid,productid,SUM(quantity) as total FROM  sending_header INNER JOIN sending ON sending_header.id=sending.sendingid GROUP BY purchaseid,productid) as p'),function($join){
                $join->on('p.purchaseid','=','order_purchase_header.id');
                $join->on('p.productid','=','order_purchase.productid');
            })
            ->where('order_purchase_header.invoice','=',$id)
            ->where(DB::Raw('order_purchase.quantity- ( case when p.total is null then 0 else p.total end)'),'>',0)
            ->select('order_purchase_header.invoice','order_purchase_header.id as id','product.id as kode_barang','productname as nama_barang','customer','order_purchase.price',DB::Raw('order_purchase.quantity- ( case when p.total is null then 0 else p.total end)   as remaining'),'transactiondate as tanggal_transaksi')
            ->get();
        return $purchase;
    }
    
    public static function insertOrder($purchaseid,$userid,$customer,$transactiondate,$isSalesOrder,$discount,$dp,$data)
	{
        $isSalesOrder=($isSalesOrder?1:0);
        $error=[];
        DB::beginTransaction();
        try {
            
            for($i=0;$i<count($data);$i++){
                $product=DB::table('product')->where('id', $data[$i]['kode_barang'])
                        ->select('id as kode_barang','quantity')->first();
                if(($product->quantity)-$data[$i]['quantity'] <0||$data[$i]['quantity']<1){
                    $error[$i]=$product;
                }
            }
            if(count($error)>0)
            return ['status'=>false,'error_code'=>-1,'products'=>$error];
            
            $id = DB::table('order_purchase_header')->insertGetId(['invoice'=>$purchaseid,'customer' => $customer, 'is_sales_order' => $isSalesOrder,'transactiondate'=>$transactiondate,'dp'=>$dp,'discount'=>$discount,'created_by'=>$userid]);
            //Insert DP HERE
            for($i=0;$i<count($data);$i++){
                DB::table('order_purchase')->insert(['purchaseid' => $id, 'productid' => $data[$i]['kode_barang'],'price'=>$data[$i]['harga'],'quantity'=>$data[$i]['quantity'],'created_by'=>$userid]);
                DB::table('product')->where('id', $data[$i]['kode_barang'])->decrement('quantity',$data[$i]['quantity'] );
                DB::table('product')->where('id','=',$data[$i]['kode_barang'])
                    ->whereRaw('(price='.$data[$i]['harga'].' or price=0)')->update(['price'=>$data[$i]['harga']]);
            }
            
            DB::commit();
            return ['status'=>true];
            
        } catch (\Exception $e) {
            DB::rollback();
            
        }
		return ['status'=>false,'error_code'=>-2];
        
	}
    
}
