
angular.module('app').controller('SendDocumentController',['$scope','PurchaseService','PrintService','CustomerService','filterFilter',function($scope,purchaseService,printService,customerService,filterFilter){
    $scope.search='';
    $scope.form={
        id:'',
        purchaseId:-1,
        to:'',
        address:''
    };
    $scope.orders=[];
    $scope.lock=false;

    $scope.print=function(){
        printService.print("order-form-confirmation");
    };

    $scope.searchTransaction=function(){

         
        purchaseService.loadOrderPurchaseById($scope.search).then(function(data){
            if(!data.result)
            {
                $scope.lock=false;
                 $scope.error='Penjualan yang aktif tidak ditemukan';
                $("#modal-save-error").modal("show");
            }
            else if(data.result.length==0){
                $scope.lock=false;
                $scope.error='Penjualan yang aktif tidak ditemukan';
                $("#modal-save-error").modal("show");
            }
            else{
                $scope.orders=data.result;
                $scope.form.to=data.result[0].customer;
                $scope.form.address=data.result[0].address;
                $scope.form.purchaseId=data.result[0].id;
                $scope.lock=true;
                customerService.loadAddressCustomerforAutoComplete( $scope.form.to).then(function(data){
                    $scope.addresses=data;
                     
                },function(){});
               /* purchaseService.loadSuratJalanId().then(function(data){
                     $scope.form.id=data;
                    
                     
                },function(){});*/
            }
        },function(){});
    };

    $scope.saveSuratJalan=function(){
            if($scope.form.to==''){
                $scope.error='Tujuan harus diisi';
                $("#modal-save-error").modal("show");
                return;
            }
            else if($scope.form.address=='')
            {
                $scope.error='Alamat tujuan harus diisi';
                $("#modal-save-error").modal("show");
                return;
            }
            else{

                if($scope.orders.length==0)
                {

                    $scope.error='Tidak Ada Barang yang di pilih';
                    $("#modal-save-error").modal("show");
                    return;
                }

                for(var i=0;i<$scope.orders.length;i++){
                    if(typeof $scope.orders[i].quantity ==='undefined')
                    {
                        return;
                    }
                    else if($scope.orders[i].quantity>$scope.orders[i].remaining)
                    {

                        $scope.error='Quantity melebihi batasan pesanan';
                        $("#modal-save-error").modal("show");
                        return;
                    }
                }

                $scope.error='';
                $scope.form.data=$scope.orders;
                $('#modal-save').modal('show');
            }
    };

    $scope.cancelSuratJalan=function(){
        $('#modal-save').modal('hide');
    };

    $scope.isLock=function(){
        return $scope.lock;
    };

    $scope.submitSuratJalan=function(){
        purchaseService.saveSuratJalan($scope.form).then(function(data){
            if(data.isSuccess){
               $('#modal-save').modal('hide');
                window.location.href='/Surat/Jalan/';
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
    }

    $scope.searchCustomer=function(){
        
        if($scope.form.to=='')
        {
           $scope.filteredCustomers=[];
           return;
        }

        $scope.filteredCustomers=filterFilter($scope.customers,{'username':$scope.form.to});  
    };


    $scope.onClickAutoCompleteCustomer=function(customer){
        
        $scope.form.customer=customer.username;
        customerService.loadAddressCustomerforAutoComplete(customer.username).then(function(data){
            $scope.addresses=data;
             
        },function(){});
        $scope.filteredAddresses=$scope.addresses;
        $scope.filteredCustomers=[];
    };



    $scope.searchAddress=function(){
        $scope.filteredAddresses=filterFilter($scope.addresses,{'address':$scope.form.address});  
    };


    $scope.onClickAutoCompleteAddress=function(address){
        
        $scope.form.address=address.address;
        $scope.filteredAddresses=[];
    };

    (function(){
        customerService.loadCustomerforAutoComplete().then(function(data){
            $scope.customers=data;
             
        },function(){});

    })();
    

}]);


angular.module('app').controller('SendDocumentDetailController',['$scope','PurchaseService',function($scope,purchaseService){
    $scope.validateQuantity=function(before){
        
        if($scope.order.quantity==''){
            return;
        }
        else if($scope.order.quantity<1)
            $scope.order.quantity= before;
        else if(parseInt($scope.order.remaining)<parseInt($scope.order.quantity))
           $scope.order.quantity= before;
        if(typeof $scope.order.quantity==='undefined')
            $scope.order.quantity='';
    }

    $scope.remove=function(){
        $scope.$parent.orders.splice($scope.$index,1) ;
    }
}]);
