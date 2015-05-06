
angular.module('app').controller('OrderSupplyController',['$scope','filterFilter','ProductService','OrderService','PrintService',function($scope,filterFilter,productService,orderService,printService){
    
    var convertDate = function(usDate) {
      var dateParts = usDate.split(/(\d{1,2})\/(\d{1,2})\/(\d{4})/);
      return dateParts[3] + "-" + (dateParts[1].length==2?dateParts[1]:('0'+dateParts[1])) + "-" + (dateParts[2].length==2?dateParts[2]:('0'+dateParts[2]));
    };

	$scope.orderId='';
    $scope.date=convertDate(new Date().toLocaleDateString());
	$scope.orders=[{kode_barang:null,nama_barang:'',harga:null,quantity:null}];
    $scope.products=[];
    $scope.addOrder=function(){
        $scope.orders.push({kode_barang:'',nama_barang:'',harga:'',quantity:''}) ;
    };
    $scope.form={orderId:'',supplier:'',currency:'',shipper:'',date:$scope.date,data:[]};
    $scope.print=function(){
        printService.print("order-form-confirmation");
    };
    $scope.getGrandTotal=function(){
        var total=0;
        for(var i=0;i<$scope.orders.length;i++)
         total+=$scope.orders[i].quantity*$scope.orders[i].harga;
        return total;
    };
    
    $scope.saveOrder=function(){
        if($scope.supplier==null||$scope.supplier=='')
        {
            $scope.error='Nama Supplier Harus di isi';
            $('#modal-save-error').modal('show');
            return;
        }
        else if($scope.date==null||$scope.date==''){
            $scope.error='Tanggal Harus di isi';
            $('#modal-save-error').modal('show');
            return;
        }
        else if($scope.currency==null||$scope.currency=='')
        {
            $scope.error='Mata Uang Harus di isi';
            $('#modal-save-error').modal('show');
            return;
        }
        else if($scope.shipper==null||$scope.shipper==''){
            
            $scope.error='Jasa Pengirimian Harus di isi';
            $('#modal-save-error').modal('show');
            
            return;   
        }
        else{
        
            
            var data=$scope.orders;
            for(var i=0;i<data.length;i++){
                if(data[i].kode_barang==null||data[i].nama_barang==''||data[i].harga==''||data[i].quantity==''){
                    $scope.error='Data Order Harus Lengkap';
                    $('#modal-save-error').modal('show');
                    return;
                
                }
            }
            $scope.error='';
            

            $scope.form.supplier=$scope.supplier;
            $scope.form.date=$scope.date;
            $scope.form.currency=$scope.currency;
            $scope.form.shipper=$scope.shipper;
            $scope.form.data=data;
            $('#modal-save').modal('show');
        }
    };

    
    $scope.submitOrder=function(){
     
        orderService.saveOrderSupplier($scope.form).then(function(data){
			
            if(data.isSuccess){
               $('#modal-save').modal('hide');
                window.location.href='/Pembelian/';
            }
            else{
              $scope.error='';
              for(var i=0;i<data.reason.length;i++){
                 $scope.error+=''+data.reason[i]+'';
                 
              }
              $scope.error+='';
            }
		},function(){
            
            
        });
    };
    
    $scope.cancelOrder=function(){
        
        $('#modal-save').modal('hide');
    };
	
	(function(){
        
                
        /*orderService.loadOrderId().then(function(data){
          //  $scope.orderId=data;
           // $scope.form.orderId=$scope.orderId;
        },function(){});*/
        
		productService.loadProductsforAutoComplete().then(function(data){
			$scope.products=data;
           
             
		},function(){});

        
	})();
	
    
}]);


angular.module('app').controller('OrderSuppyDetailController',['$scope','filterFilter',function($scope,filterFilter){
    
    $scope.searchProduct=function(){
        if($scope.order.nama_barang=='')
        {
           $scope.filteredProducts=[];
           return;
        }
        
        $scope.filteredProducts=filterFilter($scope.$parent.products,{'nama_barang':$scope.order.nama_barang});
        $scope.filteredProducts.push({kode_barang:0,nama_barang:'Tambah Barang Baru'});
       
    }
    
    $scope.reset=function(){
        $scope.order.nama_barang='';
        $scope.order.kode_barang=null;
        $scope.order.isDisabled=false;
    };
    
     $scope.onClickAutoComplete=function(product){
        
        $scope.order.kode_barang=product.kode_barang;
         if($scope.order.kode_barang!=0)
        $scope.order.nama_barang=product.nama_barang;
        $scope.filteredProducts=[];
        $scope.order.isDisabled=true;
    };
    
    $scope.remove=function(){
        $scope.$parent.orders.splice($scope.$index,1) ;
         $scope.order.isDisabled=false;
        if($scope.$parent.orders.length==0)
            $scope.$parent.orders.push({kode_barang:'',nama_barang:'',harga:'',quantity:''}) ;
    };
    
    $scope.isNewItem=function(){
        if($scope.order.kode_barang==0)
            return true;
        else
            return false;
    };
    
}]);


