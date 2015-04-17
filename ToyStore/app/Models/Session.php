<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;
use DB;

class Session extends Model {
	protected $table = 'session_storage';
	
	public static function setSession($userid,$payload){
		DB::table('session_storage')->insert(['userid'=>$userid,'payload'=>$payload]);
	}

	public static function getSession($payload){
		return DB::table('session_storage')->join('user','user.id','=','session_storage.userid')->where('payload','=',$payload)->first();
	}
}
