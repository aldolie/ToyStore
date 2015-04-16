<?php namespace App\Http\Controllers;


use Illuminate\Http\Request as Request;

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
	public function index()
	{
		return view('home');
	}
   
   	public function signin(){
   		return view('login');
   	}
    
    public function order_supply()
	{
		return view('content/order_supply');
	}
    
	public function order_supply_report(){
		return view('content/order_recapitulation');
	}


	public function payment_supply(){
		return view('content/payment_supply');
	}
    
     public function product_recapitulation()
	{
		return view('content/product_recapitulation');
	}


	public function order_purchase(){
		return view('content/order_purchase');
	}

	public function order_purchase_report(){
		return view('content/order_purchase_recapitulation');
	}

	public function send_document(){
		return view('content/send_document');
	}

	public function send_document_report(){
		return view('content/sending_recapitulation');
	}

	public function payment_purchase(){
		return view('content/payment_purchase');
	}

	public function doSignin(Request $request){
		
	}

}
