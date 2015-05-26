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
use App\Models\Customer;
use Illuminate\Http\Request as Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash as Hash;
use Illuminate\Support\Facades\Session as Session;
use Illuminate\Support\Facades\Storage as Storage;
use phpmailer\PHPMailerAutoload;

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

    public function resetPassword(Request $request){
        if($request->input('id')!=null){
            $id=$request->input('id');
            $status=User::resetPassword($id);
            return (['status'=>200,'isSuccess'=>$status,'result'=>[],'reason'=>[]]);
        }
    }

    public function changePassword(Request $request){
        $v = Validator::make($request->all(), [
        'id' => 'required',
        'password' => 'required',
        'cpassword'=>'required',
        'oldpassword'=>'required'
        ],[
        'id.required'=>'Id tidak ditemukan',
        'password.required'=>'Password harus diisi',
        'cpassword.required'=>'Konfirmasi Password harus diisi',
        'oldpassword.required'=>'Password harus di isi']);
        if($v->fails()){
            return (['status'=>200,'isSuccess'=>false,'result'=>[],'reason'=>$v->messages()->all()]);
        }
        else{
            $id=$request->input('id');
            $password=$request->input('password');
            $cpassword=$request->input('cpassword');
            $oldpassword=$request->input('oldpassword');
            $user=User::getUserById($id);
            if($user){
                if($password!=$cpassword){
                    return (['status'=>200,'isSuccess'=>false,'result'=>[],'reason'=>['0'=>'Password dan Konfirmasi Password tidak sesuai']]);
                }
                else if($user->password!=md5($oldpassword)){
                    return (['status'=>200,'isSuccess'=>false,'result'=>[],'reason'=>['0'=>'Password lama tidak sesuai']]);    
                }
                else{
                    $status=User::changePassword($id,$password);
                    return (['status'=>200,'isSuccess'=>$status,'result'=>[],'reason'=>[]]);
                }
            }
            else{
                 return (['status'=>200,'isSuccess'=>false,'result'=>[],'reason'=>['0'=>'User tidak ditemukan']]);
            }
        }
    }

    public function updateUser(Request $request){
        $v = Validator::make($request->all(), [
        'id' => 'required',
        'firstname' => 'required',
        'lastname'=>'required',
        'role'=>'required'
        ],[
        'id.required'=>'Id tidak ditemukan',
        'firstname.required'=>'Firstname harus diisi',
        'lastname.required'=>'Lastname harus diisi',
        'role.required'=>'Role tidak ditemukan']);
        if ($v->fails())
        {
           return (['status'=>200,'isSuccess'=>false,'result'=>[],'reason'=>$v->messages()->all()]);
        }
        else{
            $id=$request->input('id');
            $firstname=$request->input('firstname');
            $lastname=$request->input('lastname');
            $role=$request->input('role');
            if($role!='admin'&&$role!='sales'){
                return (['status'=>200,'isSuccess'=>false,'result'=>[],'reason'=>['0'=>'Role tidak sesuai']]);
            }
            else{
                $status=User::updateUser($id,$firstname,$lastname,$role);
                return (['status'=>200,'isSuccess'=>$status,'result'=>[],'reason'=>[]]);
            }
        }
    }

    public function createUser(Request $request){
     $v = Validator::make($request->all(), [
        'username' => 'required',
        'firstname' => 'required',
        'lastname'=>'required',
        'role'=>'required'
        ],[
        'username.required'=>'Username harus diisi',
        'firstname.required'=>'Firstname harus diisi',
        'lastname.required'=>'Lastname harus diisi',
        'role.required'=>'Role tidak ditemukan']);
        if ($v->fails())
        {
           return (['status'=>200,'isSuccess'=>false,'result'=>[],'reason'=>$v->messages()->all()]);
        }
        else{
            $username=$request->input('username');

            $firstname=$request->input('firstname');
            $lastname=$request->input('lastname');
            $role=$request->input('role');
            if(User::getUser($username)){
                return (['status'=>200,'isSuccess'=>false,'result'=>[],'reason'=>['0'=>'Username sudah ada,pilih yang lain']]);
            }
            else if($role!='admin'&&$role!='sales'){
                return (['status'=>200,'isSuccess'=>false,'result'=>[],'reason'=>['0'=>'Role tidak sesuai']]);
            }
            else{
                $status=User::createUser($username,$firstname,$lastname,$role);
                return (['status'=>200,'isSuccess'=>$status,'result'=>[],'reason'=>[]]);
            }
        }
    }

    public function deleteUser(Request $request){
        if($request->input('id')!=null){
            $id=$request->input('id');
            $status=User::deleteUser($id);
            return ['status'=>200,'isSuccess'=>$status];
        }
    }


    public function getUsers(){
        $user=User::getUsers();
        return ['status'=>200,'result'=>$user];
    }

    public function getCurrentUser(Request $request){
       
        $token=Session::get('user');
        $user=SessionTable::getSession($token);
        return (['status' => 200, 'result' =>['userid'=>$user->id,'name'=>$user->firstname.' '.$user->lastname]]);
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
        /*if(!Storage::disk('local')->exists('rop.txt'))
            Storage::disk('local')->put('rop.txt', '5');
        $rop = Storage::disk('local')->get('rop.txt');*/
        $counts=Product::getROP();
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
        $totalPaidVerify=PaymentPurchase::getTotalPaidVerify($purchase);
        return ['status'=>200,'isSuccess'=>$status,'result'=>['paid'=>$totalPaid,'paid_verify'=>$totalPaidVerify]];

    }


    public function verifyPaymentPurchase(Request $request){
        $id=$request->input('i');
        $purchase=$request->input('purchase');
        $status=PaymentPurchase::verifyPayment($id);
        $totalPaid=PaymentPurchase::getTotalPaidVerify($purchase);
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
    

    public function deleteSuratJalan(Request $request){
        $id=$request->input('id');
        $status=SendDocument::deleteTrack($id);
        return ['status'=>200,'isSuccess'=>$status];
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
            'purchaseid'=>'required',
            'address'=>'required'
        ],[
            'purchaseid.required'=>'Purchaseid harus diisi',
            'customer.required'=>'Nama Customer  harus diisi',
            'date.required'=>'Tanggal Pembelian harus diisi',
            'is_sales_order.required'=>'Sales Order harus di isi',
            'address.required'=>'Alamat harus diisi'
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
            $address=$request->input('address');
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
                Customer::insertCustomer($customer,$address);
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

    public function updateROP(Request $request){
        if($request->input('rop')!=null&&$request->input('id')!=null){
            $r=$request->input('rop');
            $i=$request->input('id');
            $status=Product::updateROP($i,$r);
            return ['status'=>200,'isSuccess'=>$status];
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
                $pr=PurchaseHeader::getInvoice($purchaseid);
                $invoice=$pr->invoice;
                try {
                    $this->email($invoice,$user->username);
                } catch (Exception $e) {
                    
                }
                return (['status'=>200,'isSuccess'=>true,'reason'=>[]]);
            }
            
       }
        
    }


    public function getCustomers(){
        $customer = Customer::getCustomersName();
        return (['status' => 200, 'result' => $customer]);
    }

    public function getCustomerAddresses($username){
        $addresses=Customer::getCustomerAddresses($username);
        return (['status' => 200, 'result' => $addresses]);
    }


     public function getPurchaseSales(Request $request){
        $fromDate=$request->input('fromDate');
        $toDate=$request->input('toDate');
        $purchase=PurchaseHeader::getPurchaseSales($fromDate,$toDate);
        return (['status' => 200, 'result' => $purchase]);
    }

    public function email($kd,$user){
        $mail = new \PHPMailer(true);
      //  $mail->SMTPDebug = 3;                               // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'ssl://smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'myvalz94@gmail.com';                 // SMTP username
        $mail->Password = 'L3g3nD4ddy';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465;                                    // TCP port to connect to

        $mail->From = 'myvalz94@gmail.com';
        $mail->FromName = 'D\'Piss APPLICATION MAILER';
        $mail->addAddress('aldo.lie@outlook.com', 'Aldo');     // Add a recipient
        //$mail->addAddress('ellen@example.com');               // Name is optional
        $mail->addReplyTo('myvalz94@gmail.com', 'Aldo');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = 'Notification from D\'Piss Application';
        $mail->Body    = '<div style="width:300px;min-height:200px;border:1px solid #666;padding:10px;box-shadow:1px 1px 1px #000000;">Terdapat perubahan pada penjualan dengan kode <b>'.$kd.'</b> oleh user <b>'.$user.'</b></div>';
        $mail->AltBody = 'Terdapat perubahan pada penjualan dengan kode '.$kd.' oleh '.$user;

        if(!$mail->send()) {
          //  echo 'Message could not be sent.';
           // echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
           // echo 'Message has been sent';
        }
    }
    


}
