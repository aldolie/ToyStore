<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;
use DB;

class SendDocument extends Model {
	protected $table = 'sending_header';
	
    public static function getLastSendingId(){
     
        return DB::table('sending_header')->max('id');
    }

    public static function getHeaders(){
        $documents=DB::table('sending_header')
                    ->join('order_purchase_header','order_purchase_header.id','=','sending_header.purchaseid')
                    ->select('sending_header.id','order_purchase_header.invoice as invoice','sending_header.invoice as suratJalan','destination','sending_header.address','tracking_number','ongkos_kirim','sending_header.transactiondate')
                    ->get();
        return $documents;
    }

    public static function updateTrack($id,$tn,$ok){
        DB::beginTransaction();
        try {
            DB::table('sending_header')
            ->where('id','=',$id)
            ->update(['tracking_number'=>$tn, 'ongkos_kirim'=>$ok] );
              DB::commit();
              return ['status'=>true];
        } catch (\Exception $e) {
              DB::rollback();
              return ['status'=>false];
        }
       
    }
    
    public static function deleteTrack($id){
        DB::beginTransaction();
        try {
            DB::table('sending_header')
            ->where('id','=',$id)
            ->delete();
            DB::table('sending')
                ->where('sendingid','=',$id)
                ->delete();
              DB::commit();
              return ['status'=>true];
        } catch (\Exception $e) {
              DB::rollback();
              return ['status'=>false];
        }
       
    }

    public static function insertSendingDocument($sd,$userid,$to,$address,$date,$data,$purchaseid)
	{
        $error=[];
        DB::beginTransaction();
       try {
            
             for($i=0;$i<count($data);$i++){
                 $purchase = DB::table('order_purchase_header')
            ->join('order_purchase','order_purchase_header.id','=','order_purchase.purchaseid')
            ->join('product','product.id','=','order_purchase.productid')
            ->leftJoin(DB::Raw('(SELECT purchaseid,productid,SUM(quantity) as total FROM  sending_header INNER JOIN sending ON sending_header.id=sending.sendingid GROUP BY purchaseid,productid) as p'),function($join){
                $join->on('p.purchaseid','=','order_purchase_header.id');
                $join->on('p.productid','=','order_purchase.productid');
            })
            ->where('order_purchase_header.id','=',$purchaseid)
            ->where('product.id','=',$data[$i]['kode_barang'])
            ->select('order_purchase_header.id as id','product.id as kode_barang','productname as nama_barang','customer','order_purchase.price',DB::Raw('order_purchase.quantity- ( case when p.total is null then 0 else p.total end)   as remaining'),'transactiondate as tanggal_transaksi')
            ->first();
                if(($purchase->remaining)-$data[$i]['quantity'] <0||$data[$i]['quantity']<1){
                    $error[$i]=$product;
                }
            }
            if(count($error)>0)
            return ['status'=>false,'error_code'=>-1,'products'=>$error];

            $id = DB::table('sending_header')->insertGetId(['invoice'=>$sd,'purchaseid'=>$purchaseid,'destination' => $to, 'address' => $address,'transactiondate'=>$date,'created_by'=>$userid]);
            //Insert DP HERE
            for($i=0;$i<count($data);$i++){
                DB::table('sending')->insert(['sendingid' => $id, 'productid' => $data[$i]['kode_barang'],'quantity'=>$data[$i]['quantity'],'created_by'=>$userid]);
            }
            
            DB::commit();
            return ['status'=>true];
            
        } catch (\Exception $e) {
            DB::rollback();
            return ['status'=>false,'error_code'=>-2,'reason'=>$e];   
        }
        
	}
    
}
