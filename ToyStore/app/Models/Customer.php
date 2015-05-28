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
    
    public static function insertCustomer($username,$addr){

    	$customer=DB::table('customer')->where('username','=',$username)->first();
    	if(!$customer){
    		DB::table('customer')->insert(['username' => $username]);
    	}
    	$address=DB::table('address')->where('address','=',$addr)->where('username','=',$username)->first();
    	if(!$address){
    		DB::table('address')->insert(['username'=>$username,'address'=>$addr]);
    	}

    }
    


}
