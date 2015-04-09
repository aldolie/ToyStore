<?php namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\OrderHeader;
use App\Models\Payment;
use App\Models\User;
use App\Models\PurchaseHeader;
use Illuminate\Http\Request as Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash as Hash;

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


    public function getCurrentUser(Request $request){
       
        return (['status' => 200, 'result' =>['userid'=>1,'name'=>'Admin']]);
    }

    public function authenticateUser(Request $request){

        $v = Validator::make($request->all(), [
        'u' => 'required',
        'p' => 'required'
        ],[
            'u.required'=>'Username harus diisi ',
            'p.required'=>'Password harus diisi',
        ]);

        if ($v->fails())
        {
           return (['status'=>200,'isSuccess'=>false,'result'=>[],'reason'=>$v->messages()->all()]);
        }
        else{
             $username=$request->input('u');
             $password=$request->input('p');
             $user=User::requestAuthentication($username,$password);
                if($user){
                  //  return dd($request);
                    $token=Hash::make($username.'|'.$password.'|'.$request->ip().'|'.str_random(60).'|'.date_format(date_create(), 'U'));
                    return (['status'=>200,'isSuccess'=>true,'result'=>$token,'reason'=>[]]);
                }
                else
                {
                    return (['status'=>200,'isSuccess'=>false,'result'=>$user,'reason'=>['0'=>'Username dan Password tidak cocok']]);
                }
        }
    }

	public function getProductsSimpleList()
	{
		$products = Product::getProductsName();
        return (['status' => 200, 'result' => $products]);
	}
    
    public function getProductsRecapList(){
        $products = Product::getProductsRecap();
        return (['status' => 200, 'result' => $products]);
    }
    
    public function getPayment(){
        $payments=Payment::getPaymentHeader();
        return (['status' => 200, 'result' =>$payments]);
    }
    

    public function getPaymentDetail(Request $request){
        $id=$request->input('i');
        $payments=Payment::getPaymentDetail($id);
        return (['status' => 200, 'result' =>$payments]);
    }


    public function doPayment(Request $request){
          $v = Validator::make($request->all(), [
            'i' => 'required|integer',
            'd' => 'required|date',
            'p'=>'required|regex:/^\d+(\.\d+)?$/'
            ],[
                'i.required'=>'Kode Invoice tidak ditemukan',
                'i.integer' =>'Kode Invoice tidak sesuai',
                'd.required'=>'Tanggal Pembayaran harus di isi',
                'd.date'=>'Tanggal Pembayaran harus sesuai format tanggal',
                'p.required'=>'Jumlah Pembayaran harus di isi',
                'p.regex'=>'Jumlah Pembayaran harus sesuai format angka'
            ]);
            if ($v->fails())
           {
               return (['status'=>200,'isSuccess'=>false,'result'=>[],'reason'=>$v->messages()->all()]);
           }
           else{


                $id=$request->input('i');
                $date=$request->input('d');
                $paid=$request->input('p');
                $residual=Payment::getResidual($id)->residual;
                if($paid>$residual){
                    return (['status'=>200,'isSuccess'=>false,'result'=>[],'reason'=>['Pembayaran tidak bisa lebih besar dari sisa hutang']]);
                }
                else{
                    $status = Payment::doPayment(1,$id,$paid,$date);
                    if($status){
                        $totalPaid=Payment::getTotalPaid($id)->paid;
                        return (['status'=>200,'isSuccess'=>true,'reason'=>[],'result'=>$totalPaid]);
                    }
                    else{
                        return (['status'=>200,'isSuccess'=>false,'reason'=>['0'=>'Gagal Menyimpan Data']]);
                    }
                }
                
           }
    }


    public function getNewOrderId(){
        $id =OrderHeader::getLastOrderId();
        if($id==null)
            $id=1;
        else
            $id+=1;
        return (['status' => 200, 'result' => $id]);
    }

    public function getNewPurchaseOrderId(){
        $id =PurchaseHeader::getLastOrderId();
        if($id==null)
            $id=1;
        else
            $id+=1;
        return (['status' => 200, 'result' => $id]);
    }

    public function getPurchaseById(Request $request){
        $id=$request->input('id');
        $purchase=PurchaseHeader::getPurchaseById($id);
        return (['status'=>200,'result'=>$purchase]);
    }

    public function getOrders(){
        $orders=OrderHeader::getOrders();
        return (['status'=>200,'result'=>$orders]);
    }

    public function getPurchases(){
        $purchases=PurchaseHeader::getPurchase();
        return (['status'=>200,'result'=>$purchases]);
    }
    
    public function saveOrderSupplier(Request $request){
        
       $v = Validator::make($request->all(), [
            'supplier' => 'required|max:255',
            'date' => 'required|date',
            'currency'=>'required|max:50',
            'shipper' =>'required|max:255'
        ],[
            'supplier.required'=>'Nama Supplier harus diisi',
            'date.required'=>'Tanggal Pembelian harus diisi',
            'currency.required'=>'Currency harus di isi',
            'shipper.required'=>'Jasa Pengiriman harus di isi',
            'supplier.max'=>'Nama Supplier terlalu panjang',
            'date.date'=>'Tanggal Pembelian tidak sesuai format tanggal',
            'currency.max'=>'currency terlalu panjang',
            'shipper.max'=>'Nama Jasa Pengiriman terlalu panjang'
        ]);
       
       if ($v->fails())
       {
           return (['status'=>200,'isSuccess'=>false,'result'=>[],'reason'=>$v->messages()->all()]);
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
    

     public function saveOrderPurchase(Request $request){
        
       $v = Validator::make($request->all(), [
            'customer' => 'required|max:255',
            'date' => 'required|date',
            'is_sales_order'=>'required',
        ],[
            'customer.required'=>'Nama Customer  harus diisi',
            'date.required'=>'Tanggal Pembelian harus diisi',
            'is_sales_order.required'=>'Sales Order harus di isi'
        ]);
       
       if ($v->fails())
       {
           return (['status'=>200,'isSuccess'=>false,'result'=>[],'reason'=>$v->messages()->all()]);
       }
       else{


            $customer=$request->input('customer');
            $date=$request->input('date');
            $isSalesOrder=$request->input('is_sales_order');
            $discount=$request->input('discount');
            $dp=$request->input('dp');
            $isDiscount=$request->input('isDiscount');
            $isDp=$request->input('isDp');
            if(!$isDiscount)
                $discount=0;
            if(!$isDp)
                $dp=0;
            $discount=(($discount=='')?0:$discount);
            $dp=(($dp=='')?0:$dp);

            $data=$request->input('data');
            $result = PurchaseHeader::insertOrder(1,$customer,$date,$isSalesOrder,$discount,$dp,$data);

            if($result['status']==false){
                if($result['error_code']==-2){
                    return (['status'=>200,'isSuccess'=>false,'reason'=>['0'=>'Gagal Menyimpan Data']]);
                }
                else if($result['error_code']==-1)
                {
                    return (['status'=>200,'isSuccess'=>false,'reason'=>['0'=>'Barang Tidak Mencukupi'],'products'=>$result['products']]);
                }
            }
            
            else{
                return (['status'=>200,'isSuccess'=>true,'reason'=>[]]);
            }
            
       }
        
    }
    

}
