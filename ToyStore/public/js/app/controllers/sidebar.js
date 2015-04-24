angular.module('app').controller('SideBarController',['$scope','ProductService','ROP',function($scope,productService,rop){
    $scope.rop=0;
    $scope.isROP=function(){
        if($scope.rop<1)
            return false;
        return true;
    };

    (function(){
        productService.loadROP(rop).then(function(data){
            $scope.rop=data;
        },function(){

        });
    })();
}]);