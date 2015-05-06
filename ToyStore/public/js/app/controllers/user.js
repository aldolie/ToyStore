angular.module('app').controller('UserController',['$scope','UserService','filterFilter',function($scope,UserService,filterFilter){
	
	$scope.users=[];
	$scope.filteredUsers=[];
	$scope.error=[];
	$scope.load=function(){
		UserService.loadUser().then(function(data){
			$scope.users=data.result;
			$scope.filteredUsers=filterFilter($scope.users,{'username':$scope.search});
		},function(){});
	};
	$scope.load();
	$scope.changeError=function(error){
		$scope.error=error;
	}
	$scope.filterUser=function(){
		$scope.filteredUsers=filterFilter($scope.users,{'username':$scope.search});
	}
}]);


angular.module('app').controller('UserDetailController',['$scope','UserService',function($scope,UserService){
	$scope.updateUser=function(){
		UserService.updateUser($scope.user.id,$scope.user.firstname,$scope.user.lastname,$scope.user.role).then(function(data){
			
			if(data.isSuccess){
			}
			else
			{

				
				$scope.$parent.changeError(data.reason);
				$("#modal-save-error").modal('show');
			}
		})
	};
	$scope.deleteUser=function(){
		UserService.deleteUser($scope.user.id).then(function(data){
			if(data.isSuccess){
				$scope.$parent.load();
			}
			else
			{

				$scope.$parent.changeError(data.reason);
				$("#modal-save-error").modal('show');
			}
		});
	};
}]);