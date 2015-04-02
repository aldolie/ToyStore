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
					->select('order_supply_header.id as kode_invoice','order_supply_header.supplier'
						,DB::raw('SUM(order_supply.price*order_supply.quantity) as jumlah_utang')
						,'order_supply_header.transactiondate as tanggal_pembelian'
						,'currency'
						,DB::raw('case when p.paid is null then 0 else p.paid end as paid'))
					->groupBy('order_supply_header.transactiondate','order_supply_header.supplier','order_supply_header.id','currency')
					->get();
        return $payment;
	}


	public static function getPaymentDetail($id)
	{
		$payment = DB::table('payment')->where('orderid','=',$id)
					->select('paymentdate as tanggal_pembayaran','paid as jumlah_pembayaran')
					->get();
        return $payment;
	}
}
