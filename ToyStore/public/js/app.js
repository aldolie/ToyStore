var app=angular.module('app',[]);
app.config(function($interpolateProvider){
    $interpolateProvider.startSymbol('[[').endSymbol(']]');
});


app.directive('doNumeric', function() {
  return {
    require: 'ngModel',
    link: function (scope, element, attr, ngModelCtrl) {
      function fromUser(text) {
        var transformedInput = text.replace(/[^0-9]/g, '');
        //console.log(transformedInput);
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
        //console.log(transformedInput);
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

app.controller('OrderSupplyController',['$scope','filterFilter',function($scope,filterFilter){
    $scope.orderId=1;
    $scope.date=new Date().toLocaleDateString();
	$scope.orders=[{kode_barang:null,nama_barang:'',harga:null,quantity:null}];
    $scope.products=[{kode_barang:1,nama_barang:'Playstasion'},{kode_barang:2,nama_barang:'Playstation 2'}];
    
    $scope.addOrder=function(){
        $scope.orders.push({kode_barang:'',nama_barang:'',harga:'',quantity:''}) ;
    };
    
    $scope.getGrandTotal=function(){
        var total=0;
        for(var i=0;i<$scope.orders.length;i++)
         total+=$scope.orders[i].quantity*$scope.orders[i].harga;
        return total;
    };
    
    $scope.saveOrder=function(){
        var data=filterFilter($scope.orders,{'isDisabled':true});
        for(var i=0;i<data.length;i++){
            if(data[i].kode_barang==null||data[i].nama_barang==''||data[i].harga==''||data[i].quantity=='')
                return;
        }
        // if valid data
    };
    
}]);


app.controller('OrderSuppyDetailController',['$scope','filterFilter',function($scope,filterFilter){
    
    $scope.searchProduct=function(){
        if($scope.order.nama_barang=='')
        {
           $scope.filteredProducts=[];
           return;
        }
        
        $scope.filteredProducts=filterFilter($scope.$parent.products,{'nama_barang':$scope.order.nama_barang});
        $scope.filteredProducts.push({kode_barang:0,nama_barang:'Tambah Barang Baru'});
       
    }
    
    $scope.reset=function(){
        $scope.order.nama_barang='';
        $scope.order.kode_barang=null;
        $scope.order.isDisabled=false;
    };
    
     $scope.onClickAutoComplete=function(product){
        
        $scope.order.kode_barang=product.kode_barang;
         if($scope.order.kode_barang!=0)
        $scope.order.nama_barang=product.nama_barang;
        $scope.filteredProducts=[];
        $scope.order.isDisabled=true;
    };
    
    $scope.remove=function(){
        $scope.$parent.orders.splice($scope.$index,1) ;
         $scope.order.isDisabled=false;
        if($scope.$parent.orders.length==0)
            $scope.$parent.orders.push({kode_barang:'',nama_barang:'',harga:'',quantity:''}) ;
    };
    
}]);