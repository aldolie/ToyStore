angular.module('app').factory('PaymentPurchaseService',['$http','$rootScope','$q','$cookies','$cookieStore','SERVICE_URI',function($http,$rootScope,$q,$cookies,$cookieStore,service){
    function PaymentPurchaseService(){
        auth($http,$cookies);
    }
    PaymentPurchaseService.prototype={
     constructor:PaymentPurchaseService, 
        loadPayments:function(){
            var deferred=$q.defer();
            var url=service+'payment/purchase/get';
            $http.get(url).success(function(data){
                deferred.resolve(data);
                $rootScope.$phase;
            });
            return deferred.promise;
        },
        loadPaymentDetail:function(id){
            var deferred=$q.defer();
            var url=service+'payment/purchase/detail/get';
            $http.post(url,{
                'id':id
            }).success(function(data){
                deferred.resolve(data);
                $rootScope.$phase;
            });
            return deferred.promise;
        },
        doPayment:function(id,form){
          var deferred=$q.defer();
            var url=service+'payment/purchase/do';
            $http.post(url,{
                'i':id,
                'p':form.paid,
                'd':form.date,
                't':form.type
            }).success(function(data){
                deferred.resolve(data);
                $rootScope.$phase;
            });
            return deferred.promise;
        },
        verifyPayment:function(i,p){
            var deferred=$q.defer();
            var url=service+'payment/purchase/verify';
            $http.post(url,{
                'i':i,
                'purchase':p
            }).success(function(data){
                deferred.resolve(data);
                $rootScope.$phase;
            });
            return deferred.promise;
        }
        ,
        deletePayment:function(i,p){
            var deferred=$q.defer();
            var url=service+'payment/purchase/delete';
            $http.post(url,{
                'i':i,
                'purchase':p
            }).success(function(data){
                deferred.resolve(data);
                $rootScope.$phase;
            });
            return deferred.promise;

        }
    
    }
    var instance=new PaymentPurchaseService();
    return instance;
}]);
