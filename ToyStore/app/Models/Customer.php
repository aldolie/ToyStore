<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;
use DB;

class Customer extends Model {
	protected $table = 'customer';
    
    public static function getCustomersName()
	{
		$customer = DB::table('customer')->select('username')->get();
        return $customer;
	}

	public static function getCustomerAddresses($username)
	{
		$customer = DB::table('address')->select('address')
						->where('username','=',$username)->get();
        return $customer;
	}
    
    


}
