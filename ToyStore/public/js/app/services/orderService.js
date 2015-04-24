angular.module('app').factory('OrderService',['$http','$rootScope','$q','$cookies','$cookieStore','SERVICE_URI',function($http,$rootScope,$q,$cookies,$cookieStore,service){
    function OrderService(){ 
         auth($http,$cookies);
    }
    OrderService.prototype={
     constructor:OrderService, 
        saveOrderSupplier:function(form){
			var deferred=$q.defer();
			 var url=service+'order/supplier/save';
           $http.post(url,{
               'orderid':form.orderId,
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
        },
        loadOrderSupplier:function(form){
            var deferred=$q.defer();
            var url=service+'order/supplier/get';
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
