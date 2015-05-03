

angular.module('app').controller('ProductRecapitulationController',['$scope','filterFilter','ProductService',function($scope,filterFilter,productService){
    
	$scope.filteredProducts=[];
    $scope.products=[];
    $scope.rop='';
    $scope.error='Kode Barang duplikat';
    $scope.filterProduct=function(){
        filter();
    };
	
	(function(){
        
		productService.loadProductsforRecapitulation().then(function(data){
			$scope.products=data;
            filter();
             
		},function(){});

        productService.getROPVariable().then(function(data){
            $scope.rop=data;
        
        },function(){});


        
	})();
	
     var filter=function (){
        if($scope.type=='nama_barang')
            $scope.filteredProducts=filterFilter($scope.products,{'nama_barang':$scope.search});
        else if($scope.type=='code')
            $scope.filteredProducts=filterFilter($scope.products,{'code':$scope.search});  
    }

    $scope.updateROP=function(){
        productService.updateROPVariable($scope.rop).then(function(data){
            if(typeof data!=='undefined')
                window.location.href='/Product';
        },function(){

        });
    };

    
}]);


angular.module('app').controller('ProductRecapitulationDetailController',['$scope','ProductService',function($scope,productService){
    
	$scope.isReOrderPoint=function(){
        if($scope.product.quantity<$scope.$parent.rop)
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
	
    $scope.updateProductCode=function(){
        productService.updateProductCode($scope.product.kode_barang,$scope.product.code).then(function(data){
            if(data.isSuccess){
                console.log('SUCCESS');
            }
            else{
                 $scope.$parent.error='Kode Barang duplikat';
                 $('#modal-save-error').modal('show');
            }
        },function(){

        });
    }
    
}]);
