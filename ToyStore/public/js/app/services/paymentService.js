

angular.module('app').factory('PaymentService',['$http','$rootScope','$q','$cookies','$cookieStore','SERVICE_URI',function($http,$rootScope,$q,$cookies,$cookieStore,service){
    
    function PaymentService(){
      auth($http,$cookies); auth($http,$cookies);
    }
    
    PaymentService.prototype={
        constructor:PaymentService,
        loadPayments:function(){
            var deferred=$q.defer();
            var url=service+'payment/supplier/get';
            $http.get(url).success(function(data){
                deferred.resolve(data);
                $rootScope.$phase;
            });
            return deferred.promise;
        },
        loadPaymentDetail:function(i){
            var deferred=$q.defer();
            var url=service+'payment/supplier/detail/get';
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
            var url=service+'payment/supplier/do';
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
