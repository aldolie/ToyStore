angular.module('app').controller('UserController',['$scope','UserService','filterFilter',function($scope,UserService,filterFilter){
	
	$scope.users=[];
	$scope.filteredUsers=[];
	$scope.error=[];
	$scope.form={
		username:'',
		firstname:'',
		lastname:'',
		role:''
	};
	$scope.load=function(){
		UserService.loadUser().then(function(data){
			$scope.users=data.result;
			$scope.filteredUsers=filterFilter($scope.users,{'username':$scope.search});
		},function(){});
	};
	$scope.load();
	$scope.changeError=function(error){
		$scope.error=error;
		setTimeout(function(){
			$scope.error=[];
		},2000);
	};
	$scope.filterUser=function(){
		$scope.filteredUsers=filterFilter($scope.users,{'username':$scope.search});
	};
	$scope.showDialog=function(){
		$("#modal-create").modal('show');
	};
	$scope.createNewUser=function(){
		if($scope.form.username.trim()==''){
			$scope.changeError(['Username harus di isi']);
		}
		else if($scope.form.firstname.trim()==''){

			$scope.changeError(['Firstname harus di isi']);
		}
		else if($scope.form.lastname.trim()==''){

			$scope.changeError(['Lastname harus di isi']);
		}
		else if($scope.form.role!='admin'&&$scope.form.role!='sales'){

			$scope.changeError(['Role tidak sesuai']);
		}
		else
		{
			UserService.createNewUser($scope.form.username,$scope.form.firstname,$scope.form.lastname,$scope.form.role).then(function(data){
				if(data.isSuccess){
					$("#modal-create").modal('hide');
					$scope.load();
					$scope.form={
						username:'',
						firstname:'',
						lastname:'',
						role:'sales'
					};
				}
				else
				{
					$scope.changeError(data.reason);
				}
			},function(){

			})
		}
	};
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
	$scope.resetPassword=function(){
		UserService.resetPassword($scope.user.id).then(function(data){
			if(data.isSuccess){

			}
			else{

			}
		},function(){

		})

	};
}]);

angular.module('app').controller('PasswordController',['$scope','UserService',function ($scope,UserService){
	$scope.form={id:0,oldpassword:'',password:'',cpassword:''};
	$scope.error=[];
	$scope.info='';
	$scope.changePassword=function(){

		UserService.changePassword($scope.form.id,$scope.form.password,$scope.form.cpassword,$scope.form.oldpassword).then(function(data){
			if(data.isSuccess){
				$scope.info='Pergantian Password berhasil';
				$scope.form.oldpassword='';
				$scope.form.password='';
				$scope.form.cpassword='';
				setTimeout(function(){
					$scope.info='';
				},2000);

			}
			else{
				$scope.error=data.reason;
				setTimeout(function(){
					$scope.error=[];
				},2000);
			}
		},function(){

		});
	};
}]);