angular.module('app').factory('CustomerService',['$http','$rootScope','$q','$cookies','$cookieStore','SERVICE_URI',function($http,$rootScope,$q,$cookies,$cookieStore,service){
    
	function CustomerService(){
           auth($http,$cookies);
	}
	
	CustomerService.prototype={
		constructor:CustomerService,
		loadCustomerforAutoComplete:function(){
			var deferred=$q.defer();
			var url=service+'customer/auto';
			$http.get(url).success(function(data){
				deferred.resolve(data.result);
				$rootScope.$phase;
			});
			return deferred.promise;
		},
		loadAddressCustomerforAutoComplete:function(username){
			var deferred=$q.defer();
			var url=service+'customer/address/auto/'+username;
			$http.get(url).success(function(data){
				deferred.resolve(data.result);
				$rootScope.$phase;
			});
			return deferred.promise;
		}
	}
	var instance=new CustomerService();
	return instance;
}]);
