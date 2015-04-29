angular.module('app').controller('OrderRecapitulationController',['$scope','OrderService','filterFilter','orderByFilter',function($scope,orderService,filterFilter,orderByFilter){

    $scope.orders=[];
    $scope.filteredOrders=[];
    $scope.filterOrder=function(){
        $scope.filteredOrders=filterFilter($scope.orders,{'nama_barang':$scope.search});
        $scope.filteredOrders=orderByFilter($scope.filteredOrders,['tanggal_transaksi','supplier'],$scope.isReverse);
    };
    $scope.orderAsc=function(){
        $scope.isReverse=true;
        $scope.filteredOrders=orderByFilter($scope.filteredOrders,['tanggal_transaksi','supplier'],$scope.isReverse);
    };
    $scope.orderDesc=function(){
        $scope.isReverse=false;
        $scope.filteredOrders=orderByFilter($scope.filteredOrders,['tanggal_transaksi','supplier'],$scope.isReverse);
    };

    (function(){
        orderService.loadOrderSupplier().then(function(data){
            $scope.orders=data.result;
            $scope.filteredOrders=filterFilter($scope.orders,{'nama_barang':$scope.search});
            $scope.filteredOrders=orderByFilter($scope.filteredOrders,['tanggal_transaksi','supplier'],$scope.isReverse);
        },function(){});
    })();

}]);

angular.module('app').controller('OrderRecapitulationDetailController',['$scope',function($scope){

}]);
