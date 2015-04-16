<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;
use DB;

class Payment extends Model {
	protected $table = 'payment';

	 public static function getPaymentHeader()
	{
		$payment = DB::table('order_supply_header')
					->join('order_supply','order_supply.orderid','=','order_supply_header.id')
					->leftJoin(DB::raw('(select  orderid ,sum(paid) as paid from payment group by orderid) as p '),'p.orderid','=','order_supply.orderid')
					->select('order_supply_header.id as id','order_supply_header.invoice as kode_invoice','order_supply_header.supplier'
						,DB::raw('SUM(order_supply.price*order_supply.quantity) as jumlah_utang')
						,'order_supply_header.transactiondate as tanggal_pembelian'
						,'currency'
						,DB::raw('case when p.paid is null then 0 else p.paid end as paid'))
					->groupBy('order_supply_header.transactiondate','order_supply_header.supplier','order_supply_header.id','currency','order_supply_header.invoice')
					->get();
        return $payment;
	}


	public static function getResidual($id)
	{
		$residual = DB::table('order_supply_header')
					->join('order_supply','order_supply.orderid','=','order_supply_header.id')
					->leftJoin(DB::raw('(select  orderid ,sum(paid) as paid from payment group by orderid) as p '),'p.orderid','=','order_supply.orderid')
					->where('order_supply_header.id','=',$id)
					->select(DB::raw('SUM(order_supply.price*order_supply.quantity)-(case when p.paid is null then 0 else p.paid end) as residual'))
					->groupBy('order_supply_header.id')
					->first();
        return $residual;
	}

	public static function getTotalPaid($id)
	{
		$paid = DB::table('payment')
					->where('orderid','=',$id)
					->select(DB::raw('sum(paid) as paid'))
					->groupBy('orderid')
					->first();
        return $paid;
	}

	public static function doPayment($userid,$id,$paid,$date){
		DB::beginTransaction();
        try {
           
           DB::table('payment')->insert(['orderid'=>$id,'paymentdate'=>$date,'paid'=>$paid,'created_by'=>$userid]); 
           DB::commit();
           return true;
            
        } catch (\Exception $e) {
            DB::rollback();
            
        }
		return false;
	}

	public static function getPaymentDetail($id)
	{
		$payment = DB::table('payment')->where('orderid','=',$id)
					->select('paymentdate as tanggal_pembayaran','paid as jumlah_pembayaran')
					->get();
        return $payment;
	}
}
