angular.module('app').factory('ProductService',['$http','$rootScope','$q','$cookies','$cookieStore','SERVICE_URI',function($http,$rootScope,$q,$cookies,$cookieStore,service){
	
	function ProductService(){
           auth($http,$cookies);
	}
	
	ProductService.prototype={
		constructor:ProductService,
		loadProductsforAutoComplete:function(){
			var deferred=$q.defer();
			var url=service+'product/auto';
			$http.get(url).success(function(data){
				deferred.resolve(data.result);
				$rootScope.$phase;
			});
			return deferred.promise;
		},
        loadProductsforRecapitulation:function(){
            var deferred=$q.defer();
			var url=service+'product/recap';
			$http.get(url).success(function(data){
				deferred.resolve(data.result);
				$rootScope.$phase;
			});
			return deferred.promise;
        },
        loadROP:function(rop){
            var deferred=$q.defer();
            var url=service+'product/rop/'+rop;
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
