

angular.module('app').controller('ProductRecapitulationController',['$scope','filterFilter','ProductService',function($scope,filterFilter,productService){
    
	$scope.filteredProducts=[];
    $scope.products=[];
    $scope.filterProduct=function(){
        filter();
    };
	
	(function(){
        
		productService.loadProductsforRecapitulation().then(function(data){
			$scope.products=data;
            filter();
             
		},function(){});

        
	})();
	
     var filter=function (){
        if($scope.type=='nama_barang')
            $scope.filteredProducts=filterFilter($scope.products,{'nama_barang':$scope.search});
        else if($scope.type=='kode_barang')
            $scope.filteredProducts=filterFilter($scope.products,{'kode_barang':$scope.search});  
    }

    
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
