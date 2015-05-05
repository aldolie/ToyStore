<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;
use DB;

class PaymentPurchase extends Model {
	protected $table = 'payment_purchase';

	 public static function getPaymentHeader()
	{
		$payment = DB::table('order_purchase_header')
					->join('order_purchase','order_purchase.purchaseid','=','order_purchase_header.id')
					->leftJoin(DB::raw('(select  purchaseid ,sum(paid) as paid from payment_purchase group by purchaseid) as p '),'p.purchaseid','=','order_purchase_header.id')
					->leftJoin(DB::raw('(select  purchaseid ,sum(ongkos_kirim) as ongkos_kirim from sending_header group by purchaseid) as s '),'s.purchaseid','=','order_purchase_header.id')
					->select('order_purchase_header.id as id','order_purchase_header.invoice as kode_invoice','order_purchase_header.customer'
						,DB::raw('SUM(order_purchase.price*order_purchase.quantity)-order_purchase_header.discount as jumlah_utang')
						,'order_purchase_header.transactiondate as tanggal_penjualan'
						,DB::raw('case when ongkos_kirim is null then 0 else ongkos_kirim end as ongkos_kirim')
						,DB::raw('case when p.paid is null then 0 else p.paid end +order_purchase_header.dp as paid'))
					->groupBy('order_purchase_header.transactiondate','order_purchase_header.customer','order_purchase_header.id','order_purchase_header.invoice')
					->get();
        return $payment;
	}


	public static function getResidual($id)
	{
		$residual = DB::table('order_purchase_header')
					->join('order_purchase','order_purchase.purchaseid','=','order_purchase_header.id')
					->leftJoin(DB::raw('(select  purchaseid ,sum(paid) as paid from payment_purchase group by purchaseid) as p '),'p.purchaseid','=','order_purchase_header.id')
					->leftJoin(DB::raw('(select  purchaseid ,sum(ongkos_kirim) as ongkos_kirim from sending_header group by purchaseid) as s '),'s.purchaseid','=','order_purchase_header.id')
					->where('order_purchase_header.id','=',$id)
					->select(DB::raw('SUM(order_purchase.price*order_purchase.quantity)+(case when ongkos_kirim is null then 0 else ongkos_kirim end)-(case when p.paid is null then 0 else p.paid end) as residual'))
					->groupBy('order_purchase_header.id')
					->first();
        return $residual;
	}

	public static function getTotalPaid($id)
	{
		$paid = DB::table('payment_purchase')
					->where('purchaseid','=',$id)
					->select(DB::raw('sum(paid) as paid'))
					->groupBy('purchaseid')
					->first();
		$dp=DB::table('order_purchase_header')
				->where('id','=',$id)
				->select('dp')
				->first();
		$down=$dp->dp;
		if($paid)
			$down+=$paid->paid;
        return $down;
	}

	public static function doPayment($userid,$id,$paid,$date,$type){
		DB::beginTransaction();
        try {
           
           DB::table('payment_purchase')->insert(['purchaseid'=>$id,'paymentdate'=>$date,'paid'=>$paid,'paymenttype'=>$type,'created_by'=>$userid]); 
           DB::commit();
           return true;
            
        } catch (\Exception $e) {
            DB::rollback();
            
        }
		return false;
	}


	public static function deletePayment($id){
		DB::beginTransaction();
        try {
           
           DB::table('payment_purchase')->where('id','=',$id)->delete(); 
           DB::commit();
           return true;
            
        } catch (\Exception $e) {
            DB::rollback();
            
        }
		return false;
	}




	public static function getPaymentDetail($id)
	{
				
        $dp=DB::table('order_purchase_header')->where('order_purchase_header.id','=',$id)
        		->where('dp','>',0)
        		->select(DB::raw('0 as id'),'order_purchase_header.created_at as tanggal_pembayaran','order_purchase_header.dp as jumlah_pembayaran'
        		,DB::raw("'Down Payment' as tipe_pembayaran"))->first();
        		
        $payment = DB::table('payment_purchase')->where('payment_purchase.purchaseid','=',$id)
					->select('payment_purchase.id','payment_purchase.paymentdate as tanggal_pembayaran','payment_purchase.paid as jumlah_pembayaran','payment_purchase.paymenttype as tipe_pembayaran')->get();
        if($dp)
        	array_unshift($payment,$dp);
		return $payment;
        
	}
}
