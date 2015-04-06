<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;
use DB;

class User extends Model {
	protected $table = 'user';
	
	public static function requestAuthentication($username,$password){
		$user=DB::table('user')
				->where('username','=',$username)
				->where('password','=',md5($password))
				->first();
		if($user)
		{
			if($user->username==$username&&$user->password==md5($password)){
				return $user;
			}
			else
			{
				return null;
			}

		}
		else
		{
			return null;
		}
	}
}
