var app=angular.module('app',['ngCookies']);
app.constant("SERVICE_URI","http://localhost:8000/api/");

app.config(function($interpolateProvider){
    $interpolateProvider.startSymbol('[[').endSymbol(']]');
});


app.directive('doNumeric', function() {
  return {
    require: 'ngModel',
    link: function (scope, element, attr, ngModelCtrl) {
      function fromUser(text) {
        var transformedInput = text.replace(/[^0-9]/g, '');
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


app.factory('AuthenticateService',['$http','$rootScope','$q','SERVICE_URI',function($http,$rootScope,$q,service){
    function AuthenticateService(){
        
    }
    AuthenticateService.prototype={
     constructor:AuthenticateService, 
        authenticate:function(form){
            var deferred=$q.defer();
            var url=service+'authenticate/user/';
            $http.post(url,{
                'u':form.username,
                'p':form.password
            }).success(function(data){
                deferred.resolve(data);
                $rootScope.$phase;
            });
            return deferred.promise;
        },
        authenticateCheck:function(payload){
            var deferred=$q.defer();
           var url=service+'authenticate/user/check/';
            $http.post(url,{
                'payload':payload
            }).success(function(data){
                deferred.resolve(data);
                $rootScope.$phase;
            });
            return deferred.promise;  
        }
    
    }
    var instance=new AuthenticateService();
    return instance;
}]);

app.controller('AuthenticateController',['$scope','$cookies','$cookieStore','AuthenticateService',function($scope,$cookies,$cookieStore,AuthenticateService){
  

    $scope.form={
        username:'',
        password:''
    };
    $scope.errors=[];

    $scope.isError=function(){
        if($scope.errors.length==0)
            return false;
        else
            return true;
    };



    $scope.authenticateUser=function(){
        AuthenticateService.authenticate($scope.form).then(function(data){
            if(data.isSuccess){
                 $cookies.authenticateApp=data.result;
                 $cookieStore.put('authenticateApp', {'token':data.result});
                 window.location.href='/';
            }
            else
            {
                $scope.errors=[];
                for(var i=0;i<data.reason.length;i++){
                    $scope.errors[i]=data.reason[i];
                }
            }
        },function(){

        });
    };
    (function(){
        var c=$cookies.authenticateApp;

        AuthenticateService.authenticateCheck(c['token']).then(function(data){
            if(data.isSuccess){
               window.location.href='/'; 
            }
        },function(){

        });
    })();

}]);
