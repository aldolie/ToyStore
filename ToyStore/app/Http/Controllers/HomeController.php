<?php namespace App\Http\Controllers;


use Illuminate\Http\Request as Request;
use Illuminate\Support\Facades\Session as Session;
use Illuminate\Support\Facades\Response;
use App\Models\Session as SessionTable;
use App\Models\PurchaseHeader;


class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */

	public function configuration(){
		$user=SessionTable::getSession(Session::get('user'));
		if($user->role!='admin')
			return view('404',$this->getData($user));
		else
			return view('content/configuration',$this->getData($user));
	}

	public function backup(){
		$user=SessionTable::getSession(Session::get('user'));
		if($user->role!='admin')
			return view('404',$this->getData($user));
		else{
			//BACK UP
			$dbhost = 'localhost:3306';
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
	        return Response::download($file, $backup_file, $headers);
		}
	}

	public function delete(){
		$user=SessionTable::getSession(Session::get('user'));
		if($user->role!='admin')
			return view('404',$this->getData($user));
		else{
			try {

				$dbhost = 'localhost:3306';
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
	       

				$con = mysqli_connect('localhost:3306','root','','ts');
				if (!$con) return ['status'=>200,'isSuccess'=>false];
				$con->select_db('ts');
				$res = $con->query('SHOW TABLES');
				while ($row = mysqli_fetch_array($res, MYSQL_NUM))
				{	
					if($row[0]!='user'&&$row[0]!='session_storage')
						$res2 = $con->query("TRUNCATE TABLE `$row[0]`");
				}
				 return Response::download($file, $backup_file, $headers);
			} catch (Exception $e) {
					
				return 'FAILED';
			}
		}
	}

	public function restore(Request $request){
		$user=SessionTable::getSession(Session::get('user'));
		if($user->role!='admin')
			return view('404',$this->getData($user));
		else
		{
			$file = $request->file('file');
			if(!$file->isValid()){
				return $file->getError();
			}
			if($file->getClientOriginalExtension()!='sql'){
				dd($file->getClientOriginalExtension());
			}
			else{

				shell_exec('C:\xampp\mysql\bin\mysql -u root  ts < '.$file->getPathName());
				return redirect('/Konfigurasi');
	        	
			}
		}
	}

	private function getData($user){
		return ['role'=>$user->role,'name'=>$user->lastname];
	}

	public function index()
	{
		$user=SessionTable::getSession(Session::get('user'));
		if($user->role!='admin'&&$user->role!='sales')
			return view('404');
		else
			return view('home',$this->getData($user));
	}
   
   	public function signin(){
   		return view('login');
   	}
    
    public function order_supply()
	{
		$user=SessionTable::getSession(Session::get('user'));
		if($user->role!='admin')
			return view('404',$this->getData($user));
		else
			return view('content/order_supply',$this->getData($user));
	}
    
	public function order_supply_report(){
		$user=SessionTable::getSession(Session::get('user'));
		if($user->role!='admin')
			return view('404',$this->getData($user));
		else
			return view('content/order_recapitulation',$this->getData($user));
	}


	public function payment_supply(){
		$user=SessionTable::getSession(Session::get('user'));
		if($user->role!='admin')
			return view('404',$this->getData($user));
		else
			return view('content/payment_supply',$this->getData($user));
	}
    
     public function product_recapitulation()
	{
		$user=SessionTable::getSession(Session::get('user'));
		if($user->role!='admin'&&$user->role!='sales')
			return view('404',$this->getData($user));
		else
			return view('content/product_recapitulation',$this->getData($user));
	}


	public function order_purchase(){
		$user=SessionTable::getSession(Session::get('user'));
		if($user->role!='sales')
			return view('404',$this->getData($user));
		else
			return view('content/order_purchase',$this->getData($user));
	}


	public function update_purchase(Request $request){
		

		$user=SessionTable::getSession(Session::get('user'));
		if($user->role!='sales')
			return view('404',$this->getData($user));
		else{
			if($request->input('search')==null||$request->input('search')=='')
				return view('404',$this->getData($user));
			else{
				$data=$this->getData($user);
				$data['id']=$request->input('search');
				$data['isFound']='false';
				$purchase=PurchaseHeader::getPurchaseHeaderById($request->input('search'));
				if($purchase)
					return redirect('/Penjualan/Search/'.str_replace('/', '_', $data['id']));
				else
					return view('content/update_purchase',$data);
				
			}
		}
	}

	public function update_purchaseView(Request $request){

		$user=SessionTable::getSession(Session::get('user'));
		if($user->role!='sales')
			return view('404',$this->getData($user));
		else{
			$data=$this->getData($user);
			$data['id']=str_replace('_', '/',$request->route('invoice'));
			$data['isFound']='true';
			$purchase=PurchaseHeader::getPurchaseHeaderById($data['id']);
			if(!$purchase)
				$data['isFound']='false';
			return view('content/update_purchase',$data);	
			
		}
	}

	public function order_purchase_report(){
		$user=SessionTable::getSession(Session::get('user'));
		if($user->role!='admin'&&$user->role!='sales')
			return view('404',$this->getData($user));
		else
			return view('content/order_purchase_recapitulation',$this->getData($user));
	}

	public function send_document(){
		$user=SessionTable::getSession(Session::get('user'));
		if($user->role!='sales')
			return view('404',$this->getData($user));
		else
			return view('content/send_document',$this->getData($user));
	}

	public function send_document_report(){
		$user=SessionTable::getSession(Session::get('user'));
		if($user->role!='admin'&&$user->role!='sales')
			return view('404',$this->getData($user));
		else
			return view('content/sending_recapitulation',$this->getData($user));
	}

	public function payment_purchase(){
		$user=SessionTable::getSession(Session::get('user'));
		if($user->role!='sales')
			return view('404',$this->getData($user));
		else
			return view('content/payment_purchase',$this->getData($user));
	}

	public function logout(){
		Session::forget('user');
		return redirect('signin');
	}

}
