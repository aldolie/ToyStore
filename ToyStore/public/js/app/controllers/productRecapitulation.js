

angular.module('app').controller('ProductRecapitulationController',['$scope','filterFilter','ProductService',function($scope,filterFilter,productService){
    
	$scope.filteredProducts=[];
    $scope.products=[];
    $scope.filterProduct=function(){
        $scope.filteredProducts=filterFilter($scope.products,{'nama_barang':$scope.search});
    };
	
	(function(){
        
		productService.loadProductsforRecapitulation().then(function(data){
			$scope.products=data;
            
            $scope.filteredProducts=filterFilter($scope.products,{'nama_barang':$scope.search});
             
		},function(){});

        
	})();
	
    
}]);


angular.module('app').controller('ProductRecapitulationDetailController',['$scope','ROP',function($scope,rop){
    
	$scope.isReOrderPoint=function(){
        if($scope.product.quantity<rop)
            return true;
        else
            return false;
    }
    
    
    $scope.isAvailable=function(){
        if($scope.product.harga<1)
            return false;
        else
            return true;
    }
	
    
}]);
