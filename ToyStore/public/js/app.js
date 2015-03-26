
app.config(function($interpolateProvider){
    $interpolateProvider.startSymbol('[[').endSymbol(']]');
});


app.directive('doNumeric', function() {
  return {
    require: 'ngModel',
    link: function (scope, element, attr, ngModelCtrl) {
      function fromUser(text) {
        var transformedInput = text.replace(/[^0-9]/g, '');
        //console.log(transformedInput);
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

app.factory('ProductService',['$http','$rootScope','$q','SERVICE_URI',function($http,$rootScope,$q,service){
	
	function ProductService(){
		
	}
	
	ProductService.prototype={
		constructor:ProductService,
		loadProductsforAutoComplete:function(){
			var deferred=$q.defer();
			var url=service+'product/auto/';
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
            var url=service+'order/supplier/id';
            $http.get(url).success(function(data){
                deferred.resolve(data.result);
                $rootScope.$phase;
            });
            return deferred.promise;
        }
    
    }
    var instance=new OrderService();
	return instance;
}]);


app.controller('OrderSupplyController',['$scope','filterFilter','ProductService','OrderService',function($scope,filterFilter,productService,orderService){
    
	$scope.orderId=1;
    $scope.date=new Date().toLocaleDateString();
	$scope.orders=[{kode_barang:null,nama_barang:'',harga:null,quantity:null}];
    $scope.products=[{kode_barang:1,nama_barang:'Playstasion'},{kode_barang:2,nama_barang:'Playstation 2'}];
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
              $scope.error='<ul>';
              for(var i=0;i<data.reason.length;i++){
                 $scope.error+='<li>'+data[i]+'</li>';
                 
              }
              $scope.error+='</ul>';
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
        if($scope.product.quantity<10)
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