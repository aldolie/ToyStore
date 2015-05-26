
angular.module('app').controller('OrderPurchaseRecapitulationController',['$scope','PurchaseService','filterFilter','orderByFilter',function($scope,purchaseService,filterFilter,orderByFilter){

    $scope.orders=[];
    $scope.filteredOrders=[];
    $scope.filterOrder=function(){
        var searchBy=$scope.searchBy;
        if(searchBy=='customer')
            $scope.filteredOrders=filterFilter($scope.orders,{'customer':$scope.search});
        else if(searchBy=='nama_barang')
            $scope.filteredOrders=filterFilter($scope.orders,{'nama_barang':$scope.search});
        
        $scope.filteredOrders=orderByFilter($scope.filteredOrders,'tanggal_transaksi',$scope.isReverse);
    };
    $scope.orderAsc=function(){
        $scope.isReverse=true;
        $scope.filteredOrders=orderByFilter($scope.filteredOrders,'tanggal_transaksi',$scope.isReverse);
    };
    $scope.orderDesc=function(){
        $scope.isReverse=false;
        $scope.filteredOrders=orderByFilter($scope.filteredOrders,'tanggal_transaksi',$scope.isReverse);
    };

    (function(){
        purchaseService.loadOrderPurchase().then(function(data){
            $scope.orders=data.result;
            $scope.filteredOrders=filterFilter($scope.orders,{'customer':$scope.search});
            $scope.filteredOrders=orderByFilter($scope.filteredOrders,'tanggal_transaksi',$scope.isReverse);
        },function(){});
    })();

}]);

angular.module('app').controller('OrderPurchaseRecapitulationDetailController',['$scope',function($scope){

}]);