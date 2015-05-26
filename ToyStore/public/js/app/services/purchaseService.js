angular.module('app').factory('PurchaseService',['$http','$rootScope','$q','$cookies','$cookieStore','SERVICE_URI',function($http,$rootScope,$q,$cookies,$cookieStore,service){
    function PurchaseService(){ 
         auth($http,$cookies);
    }
    PurchaseService.prototype={
     constructor:PurchaseService, 
        saveOrderPurchase:function(form){
            var deferred=$q.defer();
             var url=service+'order/purchase/save';
           $http.post(url,{
               'purchaseid':form.orderId,
               'customer':form.customer,
               'date':form.date,
               'is_sales_order':form.salesOrder,
               'isDp':form.isDp,
               'isDiscount':form.isDiscount,
               'discount':form.discount,
               'dp':form.dp,
               'address':form.address,
               'data':form.data
           }).success(function(data){
             deferred.resolve(data);
             $rootScope.$phase;  
           });
            return deferred.promise;
        },
        updateOrderPurchase:function(form){
            var deferred=$q.defer();
             var url=service+'order/purchase/update';
           $http.post(url,{
               'purchaseid':form.id,
               'customer':form.customer,
               'date':form.date,
               'is_sales_order':form.salesOrder,
               'isDp':form.isDp,
               'isDiscount':form.isDiscount,
               'discount':form.discount,
               'dp':form.dp,
               'data':form.data,
               'deleted':form.deleted
           }).success(function(data){
             deferred.resolve(data);
             $rootScope.$phase;  
           });
            return deferred.promise;
        },
        loadOrderId:function(){
            var deferred=$q.defer();
            var url=service+'order/purchase/id';
            $http.get(url).success(function(data){
                deferred.resolve(data.result);
                $rootScope.$phase;
            });
            return deferred.promise;
        },
        loadOrderPurchase:function(){
            var deferred=$q.defer();
            var url=service+'order/purchase/get';
            $http.get(url).success(function(data){
                deferred.resolve(data);
                $rootScope.$phase;
            });
            return deferred.promise;
        },
        loadPriceByCustomer:function(customer,id){
            var deferred=$q.defer();
            var url=service+'order/purchase/price/get';
            $http.post(url,{
                'customer':customer,
                'pid':id
            }).success(function(data){
                deferred.resolve(data);
                $rootScope.$phase;
            });
            return deferred.promise;
        },
        loadOrderPurchaseById:function(id){
            var deferred=$q.defer();
            var url=service+'order/purchase/getId';
            $http.post(url,{
                'id':id
            }).success(function(data){
                deferred.resolve(data);
                $rootScope.$phase;
            });
            return deferred.promise;
        },
        loadSuratJalanId:function(){
              var deferred=$q.defer();
            var url=service+'surat/jalan/id';
            $http.get(url).success(function(data){
                deferred.resolve(data.result);
                $rootScope.$phase;
            });
            return deferred.promise;
        },
        loadSuratJalan:function(){
            var deferred=$q.defer();
            var url=service+'surat/jalan/get';
            $http.get(url).success(function(data){
                deferred.resolve(data);
                $rootScope.$phase;
            });
            return deferred.promise;
        },
        saveSuratJalan:function(form){
            var deferred=$q.defer();
            var url=service+'surat/jalan/save';
            $http.post(url,{
                'sd':form.id,
                'id':form.purchaseId,
                'to':form.to,
                'address':form.address,
                'data':form.data
            }).success(function(data){
                deferred.resolve(data);
                $rootScope.$phase;
            });
            return deferred.promise;
        },
        updateSuratJalan:function(form){
              var deferred=$q.defer();
            var url=service+'surat/jalan/updatetrack';
            $http.post(url,{
                'id':form.id,
                'tn':form.tracking_number,
                'ok':form.ongkos_kirim
            }).success(function(data){
                deferred.resolve(data);
                $rootScope.$phase;
            });
            return deferred.promise;
        },
        loadHeaderPurchase:function(id){
            var deferred=$q.defer();
            var url=service+'order/purchase/header/get';
            $http.post(url,{
                'id':id,
            }).success(function(data){
                deferred.resolve(data);
                $rootScope.$phase;
            });
            return deferred.promise;
        },
        loadDetailPurchase:function(id){
            var deferred=$q.defer();
            var url=service+'order/purchase/detail/get';
            $http.post(url,{
                'id':id,
            }).success(function(data){
                deferred.resolve(data);
                $rootScope.$phase;
            });
            return deferred.promise;
        },
        deleteSuratJalan:function(id){
            var deferred=$q.defer();
            var url=service+'surat/jalan/delete';
            $http.post(url,{
                'id':id,
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
