<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;
use DB;

class User extends Model {
	protected $table = 'user';
	
	public static function requestAuthentication($username,$password){
		$user=DB::table('user')
				->where('username','=',$username)
				->where('password','=',md5($password))
				->where('active','=',1)
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


	public static function getUsers(){
		$user=DB::table('user')
				->where('active','=',1)
				->select('id','username','role','firstname','lastname')->get();
		return $user;
	}
	public static function updateUser($id,$firstname,$lastname,$role){
		DB::beginTransaction();
        try {
            
           DB::table('user')
           	->where('id','=',$id)
           	->update([
           		'firstname'=>$firstname,
           		'lastname'=>$lastname,
           		'role'=>$role
           		]);
            
            DB::commit();
            return true;
            
        } catch (\Exception $e) {
            DB::rollback();
            
        }
		return false;
        
	}

	public static function deleteUser($id){
		DB::beginTransaction();
        try {
            
           DB::table('user')
           	->where('id','=',$id)
           	->update([
           		'active'=>0
           		]);
            
            DB::commit();
            return true;
            
        } catch (\Exception $e) {
            DB::rollback();
            
        }
		return false;
        
	}

}
