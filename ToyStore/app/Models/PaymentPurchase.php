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
						,DB::raw('SUM(order_purchase.price*order_purchase.quantity) as jumlah_utang')
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
        return $paid;
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

	public static function getPaymentDetail($id)
	{
		$payment = DB::table('payment_purchase')->where('purchaseid','=',$id)
					->select('paymentdate as tanggal_pembayaran','paid as jumlah_pembayaran','paymenttype as tipe_pembayaran')
					->get();
        return $payment;
	}
}
