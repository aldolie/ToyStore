<?php namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\OrderHeader;
use Illuminate\Http\Request as Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller {

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
	public function getProductsSimpleList()
	{
		$products = Product::getProductsName();
        return (['status' => 200, 'result' => $products]);
	}
    
    public function getProductsRecapList(){
        $products = Product::getProductsRecap();
        return (['status' => 200, 'result' => $products]);
    }
    
    
    public function getNewOrderId(){
        $id =OrderHeader::getLastOrderId();
        if($id==null)
            $id=1;
        else
            $id+=1;
        return (['status' => 200, 'result' => $id]);
    }
    
    public function saveOrderSupplier(Request $request){
        
       $v = Validator::make($request->all(), [
            'supplier' => 'required|max:255',
            'date' => 'required|date',
            'currency'=>'required|max:50',
            'shipper' =>'required'
        ]);
       
       if ($v->fails())
       {
           return (['status'=>200,'isSuccess'=>false,'result'=>[],'reason'=>$v->messages()]);
       }
       else{


            $supplier=$request->input('supplier');
            $date=$request->input('date');
            $currency=$request->input('currency');
            $shipper=$request->input('shipper');
            $data=$request->input('data');
            $status = OrderHeader::insertOrder(1,$supplier,$currency,$date,$shipper,$data);
            if($status){
             return (['status'=>200,'isSuccess'=>true,'reason'=>[]]);
            }
            else{
             return (['status'=>200,'isSuccess'=>false,'reason'=>['0'=>'Gagal Menyimpan Data']]);
            }
       }
        
    }
    
    

}
