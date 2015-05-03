<?php namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use DB;

class WelcomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('welcome');
	}

	public function test(){
		//DELETE
		/*try {
			
		
			$con = mysqli_connect('localhost:3306','root','','ts');
			if (!$con) return ['status'=>200,'isSuccess'=>false];
			$con->select_db('ts');
			$res = $con->query('SHOW TABLES');
			while ($row = mysqli_fetch_array($res, MYSQL_NUM))
			{	
				if($row[0]!='user')
					$res2 = $con->query("TRUNCATE TABLE `$row[0]`");
			}
			return ['status'=>200,'isSuccess'=>true];
		} catch (Exception $e) {
				
			return ['status'=>200,'isSuccess'=>false];
		}*/
		

		//BACK UP
		/*$dbhost = 'localhost:3306';
		$dbuser = 'root';
		$dbpass = '';
		$dbname='ts';

		$backup_file = 'back_up_' . date("Y-m-d-H-i-s") . '.sql';
		//exec('mysqldump -u='.$dbuser.' --host='.$dbhost.' ts > backup/'.$backup_file);
		shell_exec('C:\xampp\mysql\bin\mysqldump -u root  ts > backup/'.$backup_file);
		$file= public_path(). '\backup\\'.$backup_file;
        $headers = array(
              'Content-Type: application/octet-stream',
              "Content-Transfer-Encoding: Binary"
            );
        return Response::download($file, $backup_file, $headers);*/
	}

}
