<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;
use DB;

class PurchaseHeader extends Model {
	protected $table = 'order_purchase_header';
	
    public static function getLastOrderId(){
     
        return DB::table('order_purchase_header')->max('id');
    }
    
    public static function getPurchaseHeaderById($id)
    {
        $purchase = DB::table('order_purchase_header')
            ->join('user','user.id','=','order_purchase_header.created_by')
            ->where('invoice','=',$id)
            ->select('customer','dp','discount','order_purchase_header.id','is_sales_order',
                'firstname','lastname',
                'user.id as userid','transactiondate')
            ->first();
        return $purchase;
    }


    public static function getLastestPrice($customername,$id)
    {
        $purchase = DB::table('order_purchase_header')
            ->join('order_purchase','order_purchase.purchaseid','=','order_purchase_header.id')
            ->where('customer','=',$customername)
            ->where('productid','=',$id)
            ->orderBy('order_purchase_header.created_at', 'desc')
            ->select('price','order_purchase_header.created_at')
            ->first();
        if($purchase)
            return $purchase->price;
        else
            return 0;
    }

    public static function getPurchaseDetailById($id){
        //  $scope.orders=[{kode_barang:null,nama_barang:'',harga:null,quantity:null,limit:-1}];
        $purchase = DB::table('order_purchase')
            ->join('order_purchase_header','order_purchase_header.id','=','order_purchase.purchaseid')
            ->join('product','product.id','=','order_purchase.productid')
            ->where('invoice','=',$id)
            ->select('order_purchase.productid as kode_barang','product.productname as nama_barang','order_purchase.price as harga','order_purchase.quantity',DB::raw('true as isDisabled'),'order_purchase.quantity as old','product.quantity as limit')
            ->get();
        return $purchase;
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
            
            /*for($i=0;$i<count($data);$i++){
                $product=DB::table('product')->where('id', $data[$i]['kode_barang'])
                        ->select('id as kode_barang','quantity')->first();
                if(($product->quantity)-$data[$i]['quantity'] <0||$data[$i]['quantity']<1){
                    $error[$i]=$product;
                }
            }
            if(count($error)>0)
            return ['status'=>false,'error_code'=>-1,'products'=>$error];
            */
            
            $id = DB::table('order_purchase_header')->insertGetId(['invoice'=>$purchaseid,'customer' => $customer, 'is_sales_order' => $isSalesOrder,'transactiondate'=>$transactiondate,'dp'=>$dp,'discount'=>$discount,'created_by'=>$userid]);
            //Insert DP HERE
            for($i=0;$i<count($data);$i++){

                if($data[$i]['kode_barang']==0){
                    $productid=DB::table('product')->insertGetId(['productname'=>$data[$i]['nama_barang'],'quantity'=>0,'price'=>0,'created_by'=>$userid]);
                    DB::table('order_purchase')->insert(['purchaseid' => $id, 'productid' => $productid,'price'=>$data[$i]['harga'],'quantity'=>$data[$i]['quantity'],'created_by'=>$userid]);
                    DB::table('product')->where('id', $productid)->decrement('quantity',$data[$i]['quantity'] );
                  /*  DB::table('product')->where('id','=',$productid)
                    ->whereRaw('(price='.$data[$i]['harga'].' or price=0)')->update(['price'=>$data[$i]['harga']]);*/
                 }
                else{
                    DB::table('order_purchase')->insert(['purchaseid' => $id, 'productid' => $data[$i]['kode_barang'],'price'=>$data[$i]['harga'],'quantity'=>$data[$i]['quantity'],'created_by'=>$userid]);
                    DB::table('product')->where('id', $data[$i]['kode_barang'])->decrement('quantity',$data[$i]['quantity'] );
                    /*DB::table('product')->where('id','=',$data[$i]['kode_barang'])
                    ->whereRaw('(price='.$data[$i]['harga'].' or price=0)')->update(['price'=>$data[$i]['harga']]);*/
                }
                
            }
            
            DB::commit();
            return ['status'=>true];
            
        } catch (\Exception $e) {
            DB::rollback();
            
        }
		return ['status'=>false,'error_code'=>-2];
        
	}


    public static function updateOrder($purchaseid,$userid,$customer,$transactiondate,$isSalesOrder,$discount,$dp,$data,$deleted)
    {
        $isSalesOrder=($isSalesOrder?1:0);
        $error=[];
        DB::beginTransaction();
        try {
            
            DB::table('order_purchase_header')->where('id','=',$purchaseid)
                    ->update(['customer' => $customer, 'is_sales_order' => $isSalesOrder,'transactiondate'=>$transactiondate,'dp'=>$dp,'discount'=>$discount,
                        'updated_by'=>$userid
                        ,'updated_at'=> date("Y-m-d H:i:s")]);
            $flag=false;
            for($i=0;$i<count($data);$i++){
                if(isset($data[$i]['old']))
                {
                    DB::table('order_purchase')
                             ->where('productid',$data[$i]['kode_barang'])
                             ->where('purchaseid',$purchaseid)
                             ->update(['price'=>$data[$i]['harga'],'quantity'=>$data[$i]['quantity'],'updated_by'=>$userid]);
                    if($data[$i]['old']!=$data[$i]['quantity'])
                        $flag=true;

                    DB::table('product')->where('id', $data[$i]['kode_barang'])->increment('quantity',$data[$i]['old'] );
                    DB::table('product')->where('id', $data[$i]['kode_barang'])->decrement('quantity',$data[$i]['quantity']);
                    DB::table('product')->where('id','=',$data[$i]['kode_barang'])
                    ->whereRaw('(price='.$data[$i]['harga'].' or price=0)')->update(['price'=>$data[$i]['harga']]);
                }
                else
                {

                    $flag=true;
                    if($data[$i]['kode_barang']==0){
                         $productid=DB::table('product')->insertGetId(['productname'=>$data[$i]['nama_barang'],'quantity'=>0,'price'=>0,'created_by'=>$userid]);
                         DB::table('order_purchase')->insert(['purchaseid' => $purchaseid, 'productid' => $productid,'price'=>$data[$i]['harga'],'quantity'=>$data[$i]['quantity'],'created_by'=>$userid]);
                         DB::table('product')->where('id', $productid)->decrement('quantity',$data[$i]['quantity'] );
                  

                    }
                    else{
                        DB::table('order_purchase')->insert(['purchaseid' => $purchaseid, 'productid' => $data[$i]['kode_barang'],'price'=>$data[$i]['harga'],'quantity'=>$data[$i]['quantity'],'created_by'=>$userid]);
                        DB::table('product')->where('id', $data[$i]['kode_barang'])->decrement('quantity',$data[$i]['quantity'] );
                        DB::table('product')->where('id','=',$data[$i]['kode_barang'])
                        ->whereRaw('(price='.$data[$i]['harga'].' or price=0)')
                        ->update(['price'=>$data[$i]['harga']]);
                    }

                }
               
            }

            for($i=0;$i<count($deleted);$i++){
                 $flag=true;
                 DB::table('order_purchase')
                         ->where('productid','=',$deleted[$i]['kode_barang'])
                         ->where('purchaseid','=',$purchaseid)
                         ->delete();
                 DB::table('product')->where('id', $deleted[$i]['kode_barang'])->increment('quantity',$deleted[$i]['old'] );
                   
            }
            if($flag){
                DB::table('payment_purchase')
                    ->where('purchaseid','=',$purchaseid)
                    ->delete();
                DB::table('sending')
                    ->join('sending_header','sending_header.id','=','sending.sendingid')
                    ->where('sending_header.purchaseid','=',$purchaseid)
                    ->delete();
                DB::table('sending_header')
                ->where('sending_header.purchaseid','=',$purchaseid)
                ->delete();
            }
            DB::commit();
            return ['status'=>true];
            
        } catch (\Exception $e) {
            DB::rollback();
            
        }
        return ['status'=>false,'error_code'=>-2];
        
    }
    
}
