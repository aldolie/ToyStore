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
        loadROP:function(){
            var deferred=$q.defer();
            var url=service+'product/rop';
            $http.get(url).success(function(data){
                deferred.resolve(data.result);
                $rootScope.$phase;
            });
            return deferred.promise;
        },
        getROPVariable:function(){
        	var deferred=$q.defer();
            var url=service+'product/rop/load';
            $http.get(url).success(function(data){
                deferred.resolve(data.rop);
                $rootScope.$phase;
            });
            return deferred.promise;
        },
        updateROPVariable:function(rop){
        	var deferred=$q.defer();
            var url=service+'product/rop/save';
            $http.post(url,{
            	'rop':rop
            }).success(function(data){
                deferred.resolve(data.rop);
                $rootScope.$phase;
            });
            return deferred.promise;
        },
        updateProductCode:function(id,code){
        	var deferred=$q.defer();
            var url=service+'product/code/update';
            $http.post(url,{
            	'id':id,
            	'code':code
            }).success(function(data){
                deferred.resolve(data);
                $rootScope.$phase;
            });
            return deferred.promise;
        },
        updateProductROP:function(id,rop){
            var deferred=$q.defer();
            var url=service+'product/rop/update';
            $http.post(url,{
                'id':id,
                'rop':rop
            }).success(function(data){
                deferred.resolve(data);
                $rootScope.$phase;
            });
            return deferred.promise;
        }
	}
	var instance=new ProductService();
	return instance;
}]);
