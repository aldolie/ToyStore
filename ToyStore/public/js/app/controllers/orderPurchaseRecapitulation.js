
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


angular.module('app').controller('PurchaseSalesRecapitulationController',['$scope','PurchaseService','filterFilter','orderByFilter',function($scope,purchaseService,filterFilter,orderByFilter){
    var convertDate = function(usDate) {
      var dateParts = usDate.split(/(\d{1,2})\/(\d{1,2})\/(\d{4})/);
      return dateParts[3] + "-" + (dateParts[1].length==2?dateParts[1]:('0'+dateParts[1])) + "-" + (dateParts[2].length==2?dateParts[2]:('0'+dateParts[2]));
    };
    $scope.orders=[];
    $scope.generate=function(){
         purchaseService.loadPurchaseSales($scope.fromDate,$scope.toDate).then(function(data){
            $scope.orders=data.result;
       },function(){});
    };

     (function(){
            var d=new Date();
            $scope.toDate=convertDate(d.toLocaleDateString());
            d.setDate(d.getDate()-30);
            $scope.fromDate=convertDate(d.toLocaleDateString());
            $scope.generate();
        
    })();

}]);


angular.module('app').controller('OrderPurchaseRecapitulationDetailController',['$scope',function($scope){

}]);