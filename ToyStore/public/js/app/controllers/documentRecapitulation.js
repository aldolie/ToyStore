


angular.module('app').controller('DocumentRecapitulationController',['$scope','PurchaseService','filterFilter','orderByFilter',function($scope,purchaseService,filterFilter,orderByFilter){

    $scope.documents=[];
    $scope.filteredDocuments=[];
    $scope.filterOrder=function(){
        $scope.filteredDocuments=filterFilter($scope.documents,{'suratJalan':$scope.search});
        $scope.filteredDocuments=orderByFilter($scope.filteredDocuments,'transactiondate',$scope.isReverse);
    };
    $scope.orderAsc=function(){
        $scope.isReverse=true;
        $scope.filteredDocuments=orderByFilter($scope.filteredDocuments,'transactiondate',$scope.isReverse);
    };
    $scope.orderDesc=function(){
        $scope.isReverse=false;
        $scope.filteredDocuments=orderByFilter($scope.filteredDocuments,'transactiondate',$scope.isReverse);
    };

    $scope.loadData=function(){
       purchaseService.loadSuratJalan().then(function(data){
            $scope.documents=data.result;
            $scope.filteredDocuments=filterFilter($scope.documents,{'suratJalan':$scope.search});
            $scope.filteredDocuments=orderByFilter($scope.filteredDocuments,'transactiondate',$scope.isReverse);
        },function(){});
    };

    (function(){
        $scope.loadData();
    })();

    $scope.fillError=function(error){
        $scope.error=error;
    };

}]);

angular.module('app').controller('DocumentRecapitulationDetailController',['$scope','PurchaseService',function($scope,purchaseService){
    $scope.update=function(){
        purchaseService.updateSuratJalan($scope.document).then(function(data){
            if(data.isSuccess){
                $scope.fillError('Success');
                $('#modal-save-error').modal('show');

            }
            else{
                $scope.fillError(data.reason);
                $('#modal-save-error').modal('show');
                
            }
        },function(){

        });
    };

    $scope.delete=function (){

        purchaseService.deleteSuratJalan($scope.document.id).then(function(data){
            if(data.isSuccess){
                $scope.$parent.loadData();
            }
            else{
                $scope.fillError(data.reason);
                $('#modal-save-error').modal('show');
                
            }
        },function(){

        });
    }

}]);
