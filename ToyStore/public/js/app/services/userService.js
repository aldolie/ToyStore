angular.module('app').factory('UserService',['$http','$rootScope','$q','$cookies','$cookieStore','SERVICE_URI',function($http,$rootScope,$q,$cookies,$cookieStore,service){
    function UserService(){
        auth($http,$cookies);
    }
    UserService.prototype={
     constructor:UserService, 
        loadCurrenctUser:function(){
            var deferred=$q.defer();
            var url=service+'user/current/id';
            $http.get(url).success(function(data){
                deferred.resolve(data);
                $rootScope.$phase;
            });
            return deferred.promise;
        },
        loadUser:function(){
            var deferred=$q.defer();
            var url=service+'user/get';
            $http.get(url).success(function(data){
                deferred.resolve(data);
                $rootScope.$phase;
            });
            return deferred.promise;
        },
        updateUser:function(id,firstname,lastname,role){
            var deferred=$q.defer();
            var url=service+'user/update';
            $http.post(url,{
                'id':id,
                'firstname':firstname,
                'lastname':lastname,
                'role':role
            }).success(function(data){
                deferred.resolve(data);
                $rootScope.$phase;
            });
            return deferred.promise;
        },
        deleteUser:function(id){
            var deferred=$q.defer();
            var url=service+'user/delete';
            $http.post(url,{
                'id':id
            }).success(function(data){
                deferred.resolve(data);
                $rootScope.$phase;
            });
            return deferred.promise;
        }
    
    }
    var instance=new UserService();
    return instance;
}]);