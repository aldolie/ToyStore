
app.config(function($interpolateProvider){
    $interpolateProvider.startSymbol('[[').endSymbol(']]');
});


app.directive('doNumeric', function() {
  return {
    require: 'ngModel',
    link: function (scope, element, attr, ngModelCtrl) {
      function fromUser(text) {
        var transformedInput = text.replace(/[^0-9]/g, '');
       if(transformedInput !== text) {
            ngModelCtrl.$setViewValue(transformedInput);
            ngModelCtrl.$render();
        }
        return transformedInput;  // or return Number(transformedInput)
      }
      ngModelCtrl.$parsers.push(fromUser);
    }
  }; 
});


app.directive('doDecimal', function() {
  return {
    require: 'ngModel',
    link: function (scope, element, attr, ngModelCtrl) {
      function fromUser(text) {
        var transformedInput = text.replace(/[^0-9.]/g, '');
        if(transformedInput !== text) {
            ngModelCtrl.$setViewValue(transformedInput);
            ngModelCtrl.$render();
        }
        return transformedInput;  // or return Number(transformedInput)
      }
      ngModelCtrl.$parsers.push(fromUser);
    }
  }; 
});

app.factory('ProductService',['$http','$rootScope','$q','$cookies','$cookieStore','SERVICE_URI',function($http,$rootScope,$q,$cookies,$cookieStore,service){
	
	function ProductService(){
        $http.defaults.headers.get = { 'X-APP-TOKEN' : $cookieStore.get('authenticateApp')['token'] };
	}
	
	ProductService.prototype={
		constructor:ProductService,
		loadProductsforAutoComplete:function(){
			var deferred=$q.defer();
			var url=service+'product/auto/';
            console.log($cookieStore.get('authenticateApp')['token']);
			$http.get(url).success(function(data){
				deferred.resolve(data.result);
				$rootScope.$phase;
			});
			return deferred.promise;
		},
        loadProductsforRecapitulation:function(){
            var deferred=$q.defer();
			var url=service+'product/recap/';
			$http.get(url).success(function(data){
				deferred.resolve(data.result);
				$rootScope.$phase;
			});
			return deferred.promise;
        }
	}
	var instance=new ProductService();
	return instance;
}]);

app.factory('OrderService',['$http','$rootScope','$q','SERVICE_URI',function($http,$rootScope,$q,service){
    function OrderService(){
    }
    OrderService.prototype={
     constructor:OrderService, 
        saveOrderSupplier:function(form){
			var deferred=$q.defer();
			 var url=service+'order/supplier/save/';
           $http.post(url,{
               'supplier':form.supplier,
               'date':form.date,
               'currency':form.currency,
               'shipper':form.shipper,
               'data':form.data
           }).success(function(data){
             deferred.resolve(data);
             $rootScope.$phase;  
           });
			return deferred.promise;
		},
        loadOrderId:function(){
            var deferred=$q.defer();
            var url=service+'order/supplier/id/';
            $http.get(url).success(function(data){
                deferred.resolve(data.result);
                $rootScope.$phase;
            });
            return deferred.promise;
        },
        loadOrderSupplier:function(form){
            var deferred=$q.defer();
            var url=service+'order/supplier/get/';
            $http.get(url).success(function(data){
                deferred.resolve(data);
                $rootScope.$phase;
            });
            return deferred.promise;
        }
    
    }
    var instance=new OrderService();
	return instance;
}]);





app.factory('PurchaseService',['$http','$rootScope','$q','SERVICE_URI',function($http,$rootScope,$q,service){
    function PurchaseService(){
    }
    PurchaseService.prototype={
     constructor:PurchaseService, 
        saveOrderPurchase:function(form){
            var deferred=$q.defer();
             var url=service+'order/purchase/save/';
           $http.post(url,{
               'customer':form.customer,
               'date':form.date,
               'is_sales_order':form.salesOrder,
               'isDp':form.isDp,
               'isDiscount':form.isDiscount,
               'discount':form.discount,
               'dp':form.dp,
               'data':form.data
           }).success(function(data){
             deferred.resolve(data);
             $rootScope.$phase;  
           });
            return deferred.promise;
        },
        loadOrderId:function(){
            var deferred=$q.defer();
            var url=service+'order/purchase/id/';
            $http.get(url).success(function(data){
                deferred.resolve(data.result);
                $rootScope.$phase;
            });
            return deferred.promise;
        },
        loadOrderPurchase:function(){
            var deferred=$q.defer();
            var url=service+'order/purchase/get/';
            $http.get(url).success(function(data){
                deferred.resolve(data);
                $rootScope.$phase;
            });
            return deferred.promise;
        },
        loadOrderPurchaseById:function(id){
            var deferred=$q.defer();
            var url=service+'order/purchase/getId/';
            $http.post(url,{
                'id':id
            }).success(function(data){
                deferred.resolve(data);
                $rootScope.$phase;
            });
            return deferred.promise;
        },
        loadSuratJalan:function(){
            var deferred=$q.defer();
            var url=service+'surat/jalan/get/';
            $http.get(url).success(function(data){
                deferred.resolve(data);
                $rootScope.$phase;
            });
            return deferred.promise;
        },
        saveSuratJalan:function(form){
            var deferred=$q.defer();
            var url=service+'surat/jalan/save/';
            $http.post(url,{
                'id':form.purchaseId,
                'to':form.to,
                'address':form.address,
                'data':form.data
            }).success(function(data){
                deferred.resolve(data);
                $rootScope.$phase;
            });
            return deferred.promise;
        }
    
    }
    var instance=new PurchaseService();
    return instance;
}]);



app.factory('UserService',['$http','$rootScope','$q','SERVICE_URI',function($http,$rootScope,$q,service){
    function UserService(){
    }
    UserService.prototype={
     constructor:UserService, 
        loadCurrenctUser:function(){
            var deferred=$q.defer();
            var url=service+'user/current/id/';
            $http.get(url).success(function(data){
                deferred.resolve(data);
                $rootScope.$phase;
            });
            return deferred.promise;
        }
    
    }
    var instance=new UserService();
    return instance;
}]);


app.factory('PaymentService',['$http','$rootScope','$q','SERVICE_URI',function($http,$rootScope,$q,service){
    
    function PaymentService(){
        
    }
    
    PaymentService.prototype={
        constructor:PaymentService,
        loadPayments:function(){
            var deferred=$q.defer();
            var url=service+'payment/supplier/get/';
            $http.get(url).success(function(data){
                deferred.resolve(data);
                $rootScope.$phase;
            });
            return deferred.promise;
        },
        loadPaymentDetail:function(i){
            var deferred=$q.defer();
            var url=service+'payment/supplier/detail/get/';
            $http.post(url,{
                'i':i
            }).success(function(data){
                deferred.resolve(data);
                $rootScope.$phase;   
            });
            return deferred.promise;

        },
        doPayment:function(i,form){
            var deferred=$q.defer();
            var url=service+'payment/supplier/do/';
            $http.post(url,{
                'i':i,
                'p':form.paid,
                'd':form.date
            }).success(function(data){
                deferred.resolve(data);
                $rootScope.$phase;
            });
            return deferred.promise;

        }
    }
    var instance=new PaymentService();
    return instance;
}]);


/*----------------------------------------ORDER SUPPLY CONTROLLER-----------------------------------*/


app.controller('OrderSupplyController',['$scope','filterFilter','ProductService','OrderService',function($scope,filterFilter,productService,orderService){
    
    var convertDate = function(usDate) {
      var dateParts = usDate.split(/(\d{1,2})\/(\d{1,2})\/(\d{4})/);
      return dateParts[3] + "-" + (dateParts[1].length==2?dateParts[1]:('0'+dateParts[1])) + "-" + (dateParts[2].length==2?dateParts[2]:('0'+dateParts[2]));
    };

	$scope.orderId=1;
    $scope.date=convertDate(new Date().toLocaleDateString());
	$scope.orders=[{kode_barang:null,nama_barang:'',harga:null,quantity:null}];
    $scope.products=[];
    $scope.addOrder=function(){
        $scope.orders.push({kode_barang:'',nama_barang:'',harga:'',quantity:''}) ;
    };
    $scope.form={supplier:'',currency:'',shipper:'',date:$scope.date,data:[]};
    
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
        
                
        orderService.loadOrderId().then(function(data){
            $scope.orderId=data;
        },function(){});
        
		productService.loadProductsforAutoComplete().then(function(data){
			$scope.products=data;
             
		},function(){});

        
	})();
	
    
}]);


app.controller('OrderSuppyDetailController',['$scope','filterFilter',function($scope,filterFilter){
    
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





app.controller('OrderPurchaseController',['$scope','filterFilter','ProductService','PurchaseService','UserService',function($scope,filterFilter,productService,purchaseService,userService){
    
    var convertDate = function(usDate) {
      var dateParts = usDate.split(/(\d{1,2})\/(\d{1,2})\/(\d{4})/);
      return dateParts[3] + "-" + (dateParts[1].length==2?dateParts[1]:('0'+dateParts[1])) + "-" + (dateParts[2].length==2?dateParts[2]:('0'+dateParts[2]));
    };

   
    $scope.form={orderId:1,customer:'',sales:'',salesId:0,date:'',dp:0,discount:0,salesOrder:false,data:[]};
    $scope.form.date=convertDate(new Date().toLocaleDateString());
    $scope.orders=[{kode_barang:null,nama_barang:'',harga:null,quantity:null,limit:-1}];
    $scope.products=[];
    $scope.addOrder=function(){
        $scope.orders.push({kode_barang:'',nama_barang:'',harga:'',quantity:'',limit:-1}) ;
    };
    
    $scope.getGrandTotal=function(){
        var total=0;
        for(var i=0;i<$scope.orders.length;i++)
         total+=$scope.orders[i].quantity*$scope.orders[i].harga;
        return total;
    };
    
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
        else if($scope.form.dp!=0&&!$scope.form.isDp){
            $scope.error='Down Payment Harus di isi';
            $('#modal-save-error').modal('show');
            return;
        }
        else if($scope.form.discount!=0&&!$scope.form.isDiscount){
            $scope.error='Discount Harus di isi';
            $('#modal-save-error').modal('show');
            return;
        }
        else if($scope.form.discount>$scope.getGrandTotal()){
            $scope.error='Discount Tidak bisa lebih besar dari total';
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
                else if(data[i].limit<data[i].quantity){
                    $scope.error='Stock tidak mencukupi';
                    $('#modal-save-error').modal('show');
                    return;
                }
                else if(data[i].quantity<1){
                    $scope.error='Quantity minimal 1';
                    $('#modal-save-error').modal('show');
                    return;
                }
            }
            $scope.error='';
            $scope.form.data=data;

            $('#modal-save').modal('show');
        }
    };

    
    $scope.submitOrder=function(){
     
        purchaseService.saveOrderPurchase($scope.form).then(function(data){
            
            if(data.isSuccess){
               $('#modal-save').modal('hide');
                window.location.href='/Penjualan/';
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
    
    (function(){
        
                
        purchaseService.loadOrderId().then(function(data){
            $scope.form.orderId=data;
        },function(){});
        
        productService.loadProductsforAutoComplete().then(function(data){
            $scope.products=data;
            for(var i=0;i<$scope.products.length;i++){
                $scope.products[i].isSelected=false;
            }
             
        },function(){});

        userService.loadCurrenctUser().then(function(data){
            if(data.result){
                $scope.form.sales=data.result.name;
                $scope.form.salesId=data.result.userid;
                   
            }
        });
        
    })();
    
    
}]);


app.controller('OrderPurchaseDetailController',['$scope','filterFilter',function($scope,filterFilter){
    
    $scope.styleQuantity='red';

    $scope.searchProduct=function(){
        if($scope.order.nama_barang=='')
        {
           $scope.filteredProducts=[];
           return;
        }
        
        $scope.filteredProducts=filterFilter($scope.$parent.products,{'nama_barang':$scope.order.nama_barang,'isSelected':false});
       
       
    }
    
    $scope.reset=function(){
        $scope.$parent.enableProduct($scope.order.kode_barang);
        $scope.order.nama_barang='';
        $scope.order.kode_barang=null;
        $scope.order.isDisabled=false;
        $scope.order.quantity='';
        $scope.order.limit=-1;

    };

    $scope.isAvalableStock=function(){
        if($scope.order.limit==-1)
            return false;
        return true;
    };

    $scope.validateQuantity=function(before){
     
        if($scope.order.quantity==''||$scope.order.limit==-1){
            return;
        }
        else if($scope.order.quantity<1)
            $scope.order.quantity= before;
        else if($scope.order.limit<$scope.order.quantity)
           $scope.order.quantity= before;
        if(typeof $scope.order.quantity==='undefined')
            $scope.order.quantity='';
        
    };
    
    $scope.isAlreadyChoosed=function(){
        if($scope.order.kode_barang==null)
            return true;
        else 
            return false;
    }

     $scope.onClickAutoComplete=function(product){
        
        $scope.$parent.disableProduct(product.kode_barang);
        $scope.order.kode_barang=product.kode_barang;
         if($scope.order.kode_barang!=0)
        $scope.order.nama_barang=product.nama_barang;
        $scope.order.harga=product.harga;
        $scope.order.limit=product.quantity;
        $scope.filteredProducts=[];
        $scope.order.isDisabled=true;
    };
    
    $scope.remove=function(){
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


app.controller('ProductRecapitulationController',['$scope','filterFilter','ProductService',function($scope,filterFilter,productService){
    
	$scope.filteredProducts=[];
    $scope.products=[];
    $scope.filterProduct=function(){
        $scope.filteredProducts=filterFilter($scope.products,{'nama_barang':$scope.search});
    };
	
	(function(){
        
		productService.loadProductsforRecapitulation().then(function(data){
			$scope.products=data;
            
            $scope.filteredProducts=filterFilter($scope.products,{'nama_barang':$scope.search});
             
		},function(){});

        
	})();
	
    
}]);


app.controller('ProductRecapitulationDetailController',['$scope','ROP',function($scope,rop){
    
	$scope.isReOrderPoint=function(){
        if($scope.product.quantity<rop)
            return true;
        else
            return false;
    }
    
    
    $scope.isAvailable=function(){
        if($scope.product.harga<1)
            return false;
        else
            return true;
    }
	
    
}]);


app.controller('OrderRecapitulationController',['$scope','OrderService','filterFilter','orderByFilter',function($scope,orderService,filterFilter,orderByFilter){

    $scope.orders=[];
    $scope.filteredOrders=[];
    $scope.filterOrder=function(){
        $scope.filteredOrders=filterFilter($scope.orders,{'nama_barang':$scope.search});
        $scope.filteredOrders=orderByFilter($scope.filteredOrders,'tanggal_transaksi',$scope.isReverse);
    };
    $scope.orderAsc=function(){
        $scope.isReverse=true;
        $scope.filteredOrders=orderByFilter($scope.filteredOrders,'tanggal_transaksi',$scope.isReverse);
    };
    $scope.orderDesc=function(){
        $scope.isReverse=false;
        $scope.filteredOrders=orderByFilter($scope.filteredOrders,'tanggal_transaksi',$scope.isReverse);
    };

    (function(){
        orderService.loadOrderSupplier().then(function(data){
            $scope.orders=data.result;
            $scope.filteredOrders=filterFilter($scope.orders,{'nama_barang':$scope.search});
            $scope.filteredOrders=orderByFilter($scope.filteredOrders,'tanggal_transaksi',$scope.isReverse);
        },function(){});
    })();

}]);

app.controller('OrderRecapitulationDetailController',['$scope',function($scope){

}]);



app.controller('DocumentRecapitulationController',['$scope','PurchaseService','filterFilter','orderByFilter',function($scope,purchaseService,filterFilter,orderByFilter){

    $scope.documents=[];
    $scope.filteredDocuments=[];
    $scope.filterOrder=function(){
        $scope.filteredDocuments=filterFilter($scope.documents,{'id':$scope.search});
        $scope.filteredDocuments=orderByFilter($scope.filteredDocuments,'transactiondate',$scope.isReverse);
    };
    $scope.orderAsc=function(){
        $scope.isReverse=true;
        $scope.filteredDocuments=orderByFilter($scope.filteredDocuments,'transactiondate',$scope.isReverse);
    };
    $scope.orderDesc=function(){
        $scope.isReverse=false;
        $scope.filteredDocuments=orderByFilter($scope.filteredDocuments,'transactiondate',$scope.isReverse);
    };

    (function(){
        purchaseService.loadSuratJalan().then(function(data){
            $scope.documents=data.result;
            $scope.filteredDocuments=filterFilter($scope.documents,{'id':$scope.search});
            $scope.filteredDocuments=orderByFilter($scope.filteredDocuments,'transactiondate',$scope.isReverse);
        },function(){});
    })();

}]);

app.controller('DocumentRecapitulationDetailController',['$scope',function($scope){

}]);


app.controller('OrderPurchaseRecapitulationController',['$scope','PurchaseService','filterFilter','orderByFilter',function($scope,purchaseService,filterFilter,orderByFilter){

    $scope.orders=[];
    $scope.filteredOrders=[];
    $scope.filterOrder=function(){
        $scope.filteredOrders=filterFilter($scope.orders,{'customer':$scope.search});
        $scope.filteredOrders=orderByFilter($scope.filteredOrders,'tanggal_transaksi',$scope.isReverse);
    };
    $scope.orderAsc=function(){
        $scope.isReverse=true;
        $scope.filteredOrders=orderByFilter($scope.filteredOrders,'tanggal_transaksi',$scope.isReverse);
    };
    $scope.orderDesc=function(){
        $scope.isReverse=false;
        $scope.filteredOrders=orderByFilter($scope.filteredOrders,'tanggal_transaksi',$scope.isReverse);
    };

    (function(){
        purchaseService.loadOrderPurchase().then(function(data){
            $scope.orders=data.result;
            $scope.filteredOrders=filterFilter($scope.orders,{'customer':$scope.search});
            $scope.filteredOrders=orderByFilter($scope.filteredOrders,'tanggal_transaksi',$scope.isReverse);
        },function(){});
    })();

}]);

app.controller('OrderPurchaseRecapitulationDetailController',['$scope',function($scope){

}]);


app.controller('PaymentController',['$scope','filterFilter','orderByFilter','PaymentService',function($scope,filterFilter,orderByFilter,paymentService){

    $scope.payments=[];
    $scope.filteredPayments=[];
    $scope.filterPayments=function(){
        $scope.filteredPayments=filterFilter($scope.payments,{'supplier':$scope.search});
        $scope.filteredPayments=orderByFilter($scope.filteredPayments,['tanggal_pembelian','supplier'],true);
      //  cons
    };

    (function(){
        paymentService.loadPayments().then(function(data){
            $scope.payments=data.result;
            $scope.filteredPayments=filterFilter($scope.payments,{'supplier':$scope.search});
            $scope.filteredPayments=orderByFilter($scope.filteredPayments,['tanggal_pembelian','supplier'],true);
        },function(){

        });
    })();
}]);



app.controller('PaymentDetailController',['$scope','PaymentService',function($scope,paymentService){
    
    var showDatePicker=function(){
     
        $('.datepicker').datepicker({
                changeMonth: true,
                changeYear: true,
                defaultDate: new Date(),
                yearRange: '1970:2030',
                dateFormat: 'yy-mm-dd'
        });
            
    };

    var convertDate = function(usDate) {
      var dateParts = usDate.split(/(\d{1,2})\/(\d{1,2})\/(\d{4})/);
      return dateParts[3] + "-" + (dateParts[1].length==2?dateParts[1]:('0'+dateParts[1])) + "-" + (dateParts[2].length==2?dateParts[2]:('0'+dateParts[2]));
    };

    var doLoadPaymentsDetail=function(){
        paymentService.loadPaymentDetail($scope.payment.kode_invoice).then(function(data){
            $scope.paymentDetails=data.result;
            $scope.isShowDetail=true;
            showDatePicker();

        },function(){

        });
    };
    

    $scope.paymentDetails=[];
    $scope.form={
        date:convertDate(new Date().toLocaleDateString()),
        paid:''
    }



    $scope.showDetail=function(){
        doLoadPaymentsDetail();

    };





    $scope.hideDetail=function(){
       $scope.isShowDetail=false; 
    };

    $scope.isAvalable=function(){
        if($scope.paymentDetails.length>0)
            return true;
        else return false;
    }

    $scope.isNotValidPayment=function(){
        
        if(!$scope.form)
            return true;

        if(!$scope.form.paid)
            return true;

        if($scope.form.paid=='')
            return true;
        if(parseFloat($scope.form.paid)>(parseFloat($scope.payment.jumlah_utang-$scope.payment.paid).toFixed(2)))
            return true;
        return false;
    };

    $scope.doPayment=function(){
        paymentService.doPayment($scope.payment.kode_invoice,$scope.form).then(function(data){
            if(data.isSuccess){
                $scope.payment.paid=data.result;
                 doLoadPaymentsDetail();
            }
            else
            {
                // Error Message
            }
        },function(){

        });
    };

    $scope.isBase=function(){
        if((parseFloat($scope.payment.jumlah_utang-$scope.payment.paid).toFixed(2))>0)
            return false;
        return true;
    };

   

}]);

app.controller('SendDocumentController',['$scope','PurchaseService',function($scope,purchaseService){
    $scope.search='';
    $scope.form={
        id:0,
        purchaseId:-1,
        to:'',
        address:''
    };
    $scope.orders=[];
    $scope.lock=false;

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
                $scope.lock=true;
                $scope.form.purchaseId=$scope.search;
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

}]);


app.controller('SendDocumentDetailController',['$scope','PurchaseService',function($scope,purchaseService){
    $scope.validateQuantity=function(before){
        if($scope.order.quantity=='')
            return;
        if($scope.order.quantity>$scope.order.remaining)
            $scope.order.quantity=before;
    }

    $scope.remove=function(){
        $scope.$parent.orders.splice($scope.$index,1) ;
    }
}]);