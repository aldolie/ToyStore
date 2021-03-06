
angular.module('app').controller('PaymentSupplyController',['$scope','filterFilter','orderByFilter','PaymentService','PrintService',function($scope,filterFilter,orderByFilter,paymentService,printService){
    $scope.realPayments=[];
    var convertDate = function(usDate) {
      var dateParts = usDate.split(/(\d{1,2})\/(\d{1,2})\/(\d{4})/);
      return dateParts[3] + "-" + (dateParts[1].length==2?dateParts[1]:('0'+dateParts[1])) + "-" + (dateParts[2].length==2?dateParts[2]:('0'+dateParts[2]));
    };

    $scope.payments=[];
    $scope.filteredPayments=[];

    var filterSearch=function (){
         if($scope.type=='supplier')
            $scope.filteredPayments=filterFilter($scope.payments,{'supplier':$scope.search});
        else if($scope.type=='kode_invoice')
            $scope.filteredPayments=filterFilter($scope.payments,{'kode_invoice':$scope.search});
        
    }

    $scope.filterPayments=function(){
        filterSearch();
        $scope.filteredPayments=orderByFilter($scope.filteredPayments,['tanggal_pembelian','supplier'],true);
      //  cons
    };

    $scope.print=function(){
        printService.print("payment_supply");
    };

    $scope.loadPaymentsHeader=function(){
        paymentService.loadPayments().then(function(data){
            $scope.realPayments=data.result;
            $scope.payments=[];
            for(var i=0;i<$scope.realPayments.length;i++){
                if($scope.realPayments[i].tanggal_pembelian>=$scope.fromDate&&$scope.realPayments[i].tanggal_pembelian<=$scope.toDate){
                    $scope.payments.push($scope.realPayments[i]);
                }
            }
            filterSearch();
            $scope.filteredPayments=orderByFilter($scope.filteredPayments,['tanggal_pembelian','supplier'],true);
        },function(){

        });
    };

    (function(){
            var d=new Date();
            $scope.toDate=convertDate(d.toLocaleDateString());
            d.setDate(d.getDate()-30);
            $scope.fromDate=convertDate(d.toLocaleDateString());
            $scope.loadPaymentsHeader();
        
    })();
}]);



angular.module('app').controller('PaymentSupplyDetailController',['$scope','PaymentService',function($scope,paymentService){
    
    var showDatePicker=function(){
     
        $('.datepicker').datepicker({
                changeMonth: true,
                changeYear: false,
                defaultDate: new Date(),
                yearRange: '1970:2030',
                dateFormat: 'yy-mm-dd'
        });
            
    };

     var convertDate = function(usDate) {
      var dateParts = usDate.split(/(\d{1,2})\/(\d{1,2})\/(\d{4})/);
      return dateParts[3] + "-" + (dateParts[1].length==2?dateParts[1]:('0'+dateParts[1])) + "-" + (dateParts[2].length==2?dateParts[2]:('0'+dateParts[2]));
    };

    var doLoadPaymentsDetail=function(){
        paymentService.loadPaymentDetail($scope.payment.id).then(function(data){
            $scope.paymentDetails=data.result;
            $scope.isShowDetail=true;
            showDatePicker();

        },function(){

        });
    };
    

    $scope.paymentDetails=[];
    $scope.form={
        date:convertDate(new Date().toLocaleDateString()),
        paid:''
    }



    $scope.showDetail=function(){
        doLoadPaymentsDetail();

    };

    $scope.hideDetail=function(){
       $scope.isShowDetail=false; 
    };

    $scope.isAvalable=function(){
        if($scope.paymentDetails.length>0)
            return true;
        else return false;
    }

    $scope.isNotValidPayment=function(){
        
        if(!$scope.form)
            return true;

        if(!$scope.form.paid)
            return true;

        if($scope.form.paid=='')
            return true;
        if(parseFloat($scope.form.paid)>(parseFloat($scope.payment.jumlah_utang-$scope.payment.paid).toFixed(2)))
            return true;
        return false;
    };

    $scope.doPayment=function(){
        paymentService.doPayment($scope.payment.id,$scope.form).then(function(data){
            if(data.isSuccess){
                $scope.payment.paid=data.result;
                 doLoadPaymentsDetail();
            }
            else
            {
                // Error Message
            }
        },function(){

        });
    };

    $scope.isBase=function(){
        if((parseFloat($scope.payment.jumlah_utang-$scope.payment.paid).toFixed(2))>0)
            return false;
        return true;
    };

   

}]);