angular.module('app').controller('UpdatePurchaseController',['$scope','filterFilter','ProductService','PurchaseService','UserService',function($scope,filterFilter,productService,purchaseService,userService){
    
    var convertDate = function(usDate) {
      var dateParts = usDate.split(/(\d{1,2})\/(\d{1,2})\/(\d{4})/);
      return dateParts[3] + "-" + (dateParts[1].length==2?dateParts[1]:('0'+dateParts[1])) + "-" + (dateParts[2].length==2?dateParts[2]:('0'+dateParts[2]));
    };

   
    $scope.form={orderId:1,customer:'',sales:'',salesId:0,date:'',dp:0,discount:0,salesOrder:false,data:[]};
    $scope.form.date=convertDate(new Date().toLocaleDateString());
    $scope.orders=[{kode_barang:null,nama_barang:'',harga:null,quantity:null,limit:-1}];
    $scope.products=[];
    $scope.deleted=[];

    $scope.addOrder=function(){
        $scope.orders.push({kode_barang:'',nama_barang:'',harga:'',quantity:'',limit:-1}) ;
    };
    
    $scope.getGrandTotal=function(){
        var total=0;
        for(var i=0;i<$scope.orders.length;i++)
         total+=$scope.orders[i].quantity*$scope.orders[i].harga;
        return total;
    };

    $scope.getDp=function(){
        if($scope.form.isDp)
            return $scope.form.dp;
        else
            return 0;
    }

    $scope.getDiscount=function(){

         if($scope.form.isDiscount)
            return $scope.form.discount;
          else
            return 0;
    }

    $scope.getTotalAll=function(){
        return ($scope.getGrandTotal()-$scope.getDiscount());
    }
    
    $scope.saveOrder=function(){
        if($scope.form.customer==null||$scope.form.customer=='')
        {
            $scope.error='Nama Customer Harus di isi';
            $('#modal-save-error').modal('show');
            return;
        }
        else if($scope.form.date==null||$scope.form.date==''){
            $scope.error='Tanggal Harus di isi';
            $('#modal-save-error').modal('show');
            return;
        }
        else if($scope.form.isDp&&$scope.form.dp==0){
            $scope.error='Down Payment Harus di isi';
            $('#modal-save-error').modal('show');
            return;
        }

        else if($scope.form.discount==0&&$scope.form.isDiscount){
            $scope.error='Discount Harus di isi';
            $('#modal-save-error').modal('show');
            return;
        }
        else if($scope.form.discount>$scope.getGrandTotal()){
            $scope.error='Discount Tidak bisa lebih besar dari total';
            $('#modal-save-error').modal('show');
            return;
        }
        else if($scope.form.dp>$scope.getGrandTotal()-$scope.form.discount){
             $scope.error='Down Payment Tidak bisa lebih besar dari total tambah discount';
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
               /* else if(data[i].limit<data[i].quantity){
                    $scope.error='Stock tidak mencukupi';
                    $('#modal-save-error').modal('show');
                    return;
                }*/
                else if(data[i].quantity<1){
                    $scope.error='Quantity minimal 1';
                    $('#modal-save-error').modal('show');
                    return;
                }
            }
            $scope.error='';
            $scope.form.data=data;
            $scope.form.deleted=$scope.deleted;

            $('#modal-save').modal('show');
        }
    };

    
    $scope.submitOrder=function(){
     
        purchaseService.updateOrderPurchase($scope.form).then(function(data){
            
            if(data.isSuccess){
              // $('#modal-save').modal('hide');
              //  window.location.href='/Penjualan/';
            }
            else{
               for(var i=0;i<data.reason.length;i++){
                 $scope.error=data.reason[i];
                }
                if(data.products){
                    data.products.forEach(function(current,index){
                        $scope.orders[index].error='Barang tidak mencukupi';
                    });
                }
            }
        },function(){
            
            
        });
    };
    
    $scope.enableProduct=function(kdbarang){
        for(var i=0;i<$scope.products.length;i++){
                if($scope.products[i].kode_barang==kdbarang){
                    $scope.products[i].isSelected=false;
                    break;
                }
            }
    };

    $scope.disableProduct=function(kdbarang){
        for(var i=0;i<$scope.products.length;i++){
                if($scope.products[i].kode_barang==kdbarang){
                    $scope.products[i].isSelected=true;
                    break;
                }
            }
    }

    $scope.cancelOrder=function(){
        
        for(var i=0;i<$scope.orders.length;i++){
             $scope.orders[i].error='';
        }
        $('#modal-save').modal('hide');
    };

    $scope.deleteOrder=function(order){
        if(order.old)
            $scope.deleted.push(order);
    };

    $scope.init=function(){
        purchaseService.loadHeaderPurchase($scope.form.orderId).then(function(data){
            $scope.form.customer=data.result.customer;
            $scope.form.dp=data.result.dp;
            $scope.form.discount=data.result.discount;
            $scope.form.sales=data.result.lastname+' '+data.result.firstname;
            $scope.form.salesId=data.result.userid;
            $scope.form.id=data.result.id;
            if(data.result.is_sales_order==1)
                $scope.form.salesOrder=true;
            if(data.result.dp>0)
                $scope.form.isDp=true;
            if(data.result.discount>0)
                $scope.form.isDiscount=true;
            $scope.form.date=data.result.transactiondate;
  
            purchaseService.loadDetailPurchase($scope.form.orderId).then(function(data_detail){
                $scope.orders=data_detail.result;
                productService.loadProductsforAutoComplete().then(function(data){
                    $scope.products=data;
                    for(var i=0;i<$scope.products.length;i++){
                        $scope.products[i].isSelected=false;
                        for(var j=0;j<$scope.orders.length;j++){
                            if($scope.products[i].kode_barang==$scope.orders[j].kode_barang){
                                $scope.products[i].isSelected=true;
                                break;
                           }
                        }
                    }
                     
                },function(){});

            },function(){

            });
        },function(){

        });
    };
    
    
}]);


angular.module('app').controller('UpdatePurchaseDetailController',['$scope','filterFilter',function($scope,filterFilter){
    
    $scope.styleQuantity='red';

    $scope.searchProduct=function(){
        if($scope.order.nama_barang=='')
        {
           $scope.filteredProducts=[];
           return;
        }
        
        $scope.filteredProducts=filterFilter($scope.$parent.products,{'nama_barang':$scope.order.nama_barang,'isSelected':false});
       
       
    }
    
    

    $scope.isAvalableStock=function(){
        if($scope.order.limit==-1)
            return false;
        return true;
    };

    $scope.validateQuantity=function(before){
     
       /* if($scope.order.quantity==''||$scope.order.limit==-1){
            return;
        }
        else if($scope.order.quantity<1)
            $scope.order.quantity= before;
        else if($scope.order.limit<$scope.order.quantity)
           $scope.order.quantity= before;
        if(typeof $scope.order.quantity==='undefined')
            $scope.order.quantity='';
        */
    };
    
    $scope.isAlreadyChoosed=function(){
        if($scope.order.kode_barang==null)
            return true;
        else 
            return false;
    }

     $scope.onClickAutoComplete=function(product){
        
        $scope.$parent.disableProduct(product.kode_barang);
        for(var i=0;i<$scope.$parent.deleted.length;i++)
        {

            if(product.kode_barang===$scope.$parent.deleted[i].kode_barang)
            {
                var o=$scope.$parent.deleted[i];
                $scope.order.kode_barang=o.kode_barang;
                $scope.order.nama_barang=o.nama_barang;
                $scope.order.harga=o.harga;
                $scope.order.limit=product.quantity;
                $scope.order.quantity=o.quantity;
                $scope.order.old=o.old;
                $scope.$parent.deleted.splice(i,1);
                $scope.filteredProducts=[];
                $scope.order.isDisabled=true;
                return;
            }
        }
        $scope.order.kode_barang=product.kode_barang;
         if($scope.order.kode_barang!=0)
        $scope.order.nama_barang=product.nama_barang;
        $scope.order.harga=product.harga;
        $scope.order.limit=product.quantity;
        $scope.filteredProducts=[];
        $scope.order.isDisabled=true;
    };
    
    $scope.remove=function(){
        $scope.$parent.deleteOrder($scope.order);
        $scope.$parent.enableProduct($scope.order.kode_barang);
        $scope.$parent.orders.splice($scope.$index,1) ;
        $scope.order.isDisabled=false;
        if($scope.$parent.orders.length==0)
            $scope.$parent.orders.push({kode_barang:'',nama_barang:'',harga:'',quantity:''}) ;
    };
    
    $scope.isErrorQuantity=function(){
        if($scope.order.error==null||$scope.order.error=='')
            return false;
        else
            return true;
    };
    
}]);




