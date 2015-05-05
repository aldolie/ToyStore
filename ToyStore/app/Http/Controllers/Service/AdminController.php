<?php namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\OrderHeader;
use App\Models\Payment;
use App\Models\User;
use App\Models\SendDocument;
use App\Models\Session as SessionTable;
use App\Models\PurchaseHeader;
use App\Models\PaymentPurchase;
use Illuminate\Http\Request as Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash as Hash;
use Illuminate\Support\Facades\Session as Session;
use Illuminate\Support\Facades\Storage as Storage;

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
       
        $token=Session::get('user');
        $user=SessionTable::getSession($token);
        return (['status' => 200, 'result' =>['userid'=>$user->id,'name'=>$user->lastname.' '.$user->lastname]]);
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
                    $token=Hash::make($username.'|'.$password.'|'.$request->ip().'|'.str_random(60).'|'.date_format(date_create(), 'U'));
                    SessionTable::setSession($user->id,$token);
                    Session::put('user',$token);
                    return (['status'=>200,'isSuccess'=>true,'result'=>$token,'reason'=>[]]);
                }
                else
                {
                    return (['status'=>200,'isSuccess'=>false,'result'=>$user,'reason'=>['0'=>'Username dan Password tidak cocok']]);
                }
        }
    }

    public function authenticateUserCheck(Request $request){
        $v = Validator::make($request->all(), [
        'payload' => 'required'
        ],[
            'payload.required'=>'Payload Required'
        ]);

        if ($v->fails())
        {
           return (['status'=>200,'isSuccess'=>false]);
        }
        else{
             $payload=$request->input('payload');
             $session=Session::getSession($payload);
             if($session)
                return (['status'=>200,'isSuccess'=>true]);
            else
                return (['status'=>200,'isSuccess'=>false]);
        }
    }

	public function getProductsSimpleList()
	{
		$products = Product::getProductsName();
        return (['status' => 200, 'result' => $products]);
	}

    public function getLastestPrice(Request $request){
        if($request->input('customer')!=null&&$request->input('pid')!=null){
            $customername=$request->input('customer');
            $pid=$request->input('pid');
            $price=PurchaseHeader::getLastestPrice($customername,$pid);
            return (['status'=>200,'result'=>$price]);
        }
        return ['status'=>200,'result'=>0];
    }

    public function getROP()
    {
        if(!Storage::disk('local')->exists('rop.txt'))
            Storage::disk('local')->put('rop.txt', '5');
        $rop = Storage::disk('local')->get('rop.txt');
        $counts=Product::getROP($rop);
        return (['status'=>200,'result'=>$counts]);
    }
    
    public function getProductsRecapList(){
        $products = Product::getProductsRecap();
        return (['status' => 200, 'result' => $products]);
    }
    
    public function getPayment(){
        $payments=Payment::getPaymentHeader();
        return (['status' => 200, 'result' =>$payments]);
    }

    public function getPaymentPurchase(){
        $payments=PaymentPurchase::getPaymentHeader();
        return (['status' => 200, 'result' =>$payments]);
    }

    public function getPaymentPurchaseDetail(Request $request){
        $id=$request->input('id');
        $payments=PaymentPurchase::getPaymentDetail($id);
        return (['status'=>200,'result'=>$payments]);
    }


    public function deletePaymentPurchase(Request $request){
        $id=$request->input('i');
        $purchase=$request->input('purchase');
        $status=PaymentPurchase::deletePayment($id);
        $totalPaid=PaymentPurchase::getTotalPaid($purchase);
        return ['status'=>200,'isSuccess'=>$status,'result'=>$totalPaid];

    }

    public function doPaymentPurchase(Request $request){
         $v = Validator::make($request->all(), [
            'i' => 'required|integer',
            'd' => 'required|date',
            'p'=>'required|regex:/^\d+(\.\d+)?$/',
            't'=>'required'
            ],[
                'i.required'=>'Kode Invoice tidak ditemukan',
                'i.integer' =>'Kode Invoice tidak sesuai',
                'd.required'=>'Tanggal Pembayaran harus di isi',
                'd.date'=>'Tanggal Pembayaran harus sesuai format tanggal',
                'p.required'=>'Jumlah Pembayaran harus di isi',
                'p.regex'=>'Jumlah Pembayaran harus sesuai format angka',
                't.required'=>'Tipe Pembayaran harus di pilih',
            ]);
            if ($v->fails())
           {
               return (['status'=>200,'isSuccess'=>false,'result'=>[],'reason'=>$v->messages()->all()]);
           }
           else{


                $id=$request->input('i');
                $date=$request->input('d');
                $paid=$request->input('p');
                $type=$request->input('t');
                $residual=PaymentPurchase::getResidual($id)->residual;
                if($paid>$residual){
                    return (['status'=>200,'isSuccess'=>false,'result'=>[],'reason'=>['Pembayaran tidak bisa lebih besar dari sisa hutang']]);
                }
                else{

                    $token=Session::get('user');
                    $user=SessionTable::getSession($token);
                    $status = PaymentPurchase::doPayment($user->id,$id,$paid,$date,$type);
                    if($status){
                        $totalPaid=PaymentPurchase::getTotalPaid($id);
                        return (['status'=>200,'isSuccess'=>true,'reason'=>[],'result'=>$totalPaid]);
                    }
                    else{
                        return (['status'=>200,'isSuccess'=>false,'reason'=>['0'=>'Gagal Menyimpan Data']]);
                    }
                }
                
           }
    }
    

    public function getPaymentDetail(Request $request){
        $id=$request->input('i');
        $payments=Payment::getPaymentDetail($id);
        return (['status' => 200, 'result' =>$payments]);
    }

    public function getSuratJalan(){
        $documents=SendDocument::getHeaders();
        return (['status'=>200,'result'=>$documents]);
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

                    $token=Session::get('user');
                    $user=SessionTable::getSession($token);
                    $status = Payment::doPayment($user->id,$id,$paid,$date);
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
        $date=date("Y/m/d/s");
        return (['status' => 200, 'result' => 'PS'.(string)$date.(string)$id]);
    }

    public function getNewPurchaseOrderId(){
        $id =PurchaseHeader::getLastOrderId();
        if($id==null)
            $id=1;
        else
            $id+=1;
        $date=date("Y/m/d/s");
        return (['status' => 200, 'result' => 'PC'.(string)$date.(string)$id]);
    }

     public function getNewSendId(){
        $id =SendDocument::getLastSendingId();
        if($id==null)
            $id=1;
        else
            $id+=1;
        $date=date("Y/m/d/s");
        return (['status' => 200, 'result' => 'SD'.(string)$date.(string)$id]);
    }

    public function getPurchaseById(Request $request){
        $id=$request->input('id');
        $purchase=PurchaseHeader::getPurchaseById($id);
        return (['status'=>200,'result'=>$purchase]);
    }

    public function getPurchaseHeader(Request $request){
        $id=$request->input('id');
        $purchase=PurchaseHeader::getPurchaseHeaderById($id);
        return ['status'=>200,'result'=>$purchase];
    }


    public function getPurchaseDetail(Request $request){
        $id=$request->input('id');
        $purchase=PurchaseHeader::getPurchaseDetailById($id);
        return ['status'=>200,'result'=>$purchase];
    }

    public function getOrders(){
        $orders=OrderHeader::getOrders();
        return (['status'=>200,'result'=>$orders]);
    }

    public function getPurchases(){
        $purchases=PurchaseHeader::getPurchase();
        return (['status'=>200,'result'=>$purchases]);
    }
    
    public function saveSuratJalan(Request $request){
        $v = Validator::make($request->all(), [
            'sd' =>'required',
            'id' => 'required',
            'to' => 'required|max:50',
            'address'=>'required|max:255'
        ],[
            'sd.required'=>'ID harus ditentukan',
            'id.required'=>'Id harus ditentukan',
            'to.required'=>'Tujuan harus diisi',
            'address.required'=>'Alamat tujuan harus disi'
        ]);
       
       if ($v->fails())
       {
           return (['status'=>200,'isSuccess'=>false,'result'=>[],'reason'=>$v->messages()->all()]);
       }
       else{


            $id=$request->input('id');
            $to=$request->input('to');
            $address=$request->input('address');
            $data=$request->input('data');
            $date=date("Y-m-d");
            $sd=$request->input('sd');

            $token=Session::get('user');
            $user=SessionTable::getSession($token);
            $result = SendDocument::insertSendingDocument($sd,$user->id,$to,$address,$date,$data,$id);
            if($result['status']==false){
                if($result['error_code']==-2){
                    return (['status'=>200,'isSuccess'=>false,'reason'=>['0'=>$result['reason']]]);
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

    public function updatetrack(Request $request){
      $v = Validator::make($request->all(), [
            'id' =>'required',
            'tn' => 'required',
            'ok' => 'required|numeric'
        ],[
            'id.required'=>'Id harus ditentukan',
            'tn.required'=>'Tracking Number harus diisi',
            'ok.required'=>'Ongkir harus disi'
        ]);
       
       if ($v->fails())
       {
           return (['status'=>200,'isSuccess'=>false,'result'=>[],'reason'=>$v->messages()->all()]);
       }
       else{


            $id=$request->input('id');
            $tn=$request->input('tn');
            $ok=$request->input('ok');
            $result = SendDocument::updateTrack($id,$tn,$ok);
            if($result['status']==false){
                 return (['status'=>200,'isSuccess'=>false,'reason'=>['0'=>'Gagal Menyimpan Data']]);
            }
            
            else{
                return (['status'=>200,'isSuccess'=>true,'reason'=>[]]);
            }
            
       }
    
    }

    public function saveOrderSupplier(Request $request){
        
       $v = Validator::make($request->all(), [
            'supplier' => 'required|max:255',
            'date' => 'required|date',
            'currency'=>'required|max:50',
            'shipper' =>'required|max:255',
            'orderid'=>'required'
        ],[
            'supplier.required'=>'Nama Supplier harus diisi',
            'date.required'=>'Tanggal Pembelian harus diisi',
            'currency.required'=>'Currency harus di isi',
            'shipper.required'=>'Jasa Pengiriman harus di isi',
            'orderid.required'=>'Order Id Harus di isi',
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
            $orderid=$request->input('orderid');

            $token=Session::get('user');
            $user=SessionTable::getSession($token);
            $status = OrderHeader::insertOrder($orderid,$user->id,$supplier,$currency,$date,$shipper,$data);
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
            'purchaseid'=>'required'
        ],[
            'purchaseid.required'=>'Purchaseid harus diisi',
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
            $purchaseid=$request->input('purchaseid');
            if(!$isDiscount)
                $discount=0;
            if(!$isDp)
                $dp=0;
            $discount=(($discount=='')?0:$discount);
            $dp=(($dp=='')?0:$dp);

            $data=$request->input('data');

            $token=Session::get('user');
            $user=SessionTable::getSession($token);
            $result = PurchaseHeader::insertOrder($purchaseid,$user->id,$customer,$date,$isSalesOrder,$discount,$dp,$data);

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
    
    public function loadROP(){
        if(!Storage::disk('local')->exists('rop.txt'))
            Storage::disk('local')->put('rop.txt', '5');
        $rop = Storage::disk('local')->get('rop.txt');
        return ['status'=>200,'rop'=>$rop];
    }

     public function editROP(Request $request){
        if($request->input('rop')!=null){
            $r=$request->input('rop');
            Storage::disk('local')->put('rop.txt', $r);
            $rop = Storage::disk('local')->get('rop.txt');
            return ['status'=>200,'rop'=>$rop];
       }
    }

    public function updateProductCode(Request $request){
        if($request->input('id')!=null&&$request->input('code')!=null){
            $id=$request->input('id');
            $code=$request->input('code');
            $status=Product::updateCode($id,$code);
            return ['status'=>200,'isSuccess'=>$status];
        }
    }



    public function updateOrderPurchase(Request $request){
        
       $v = Validator::make($request->all(), [
            'customer' => 'required|max:255',
            'date' => 'required|date',
            'is_sales_order'=>'required',
            'purchaseid'=>'required'
        ],[
            'purchaseid.required'=>'Purchaseid harus diisi',
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
            $purchaseid=$request->input('purchaseid');
            if(!$isDiscount)
                $discount=0;
            if(!$isDp)
                $dp=0;
            $discount=(($discount=='')?0:$discount);
            $dp=(($dp=='')?0:$dp);

            $data=$request->input('data');
            $deleted=$request->input('deleted');

            $token=Session::get('user');
            $user=SessionTable::getSession($token);
            $result = PurchaseHeader::updateOrder($purchaseid,$user->id,$customer,$date,$isSalesOrder,$discount,$dp,$data,$deleted);

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
