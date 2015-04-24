angular.module('app').controller('PaymentPurchaseController',['$scope','PaymentPurchaseService','filterFilter','orderByFilter',function($scope,PaymentPurchaseService,filterFilter,orderByFilter){
    
    $scope.payments=[];
    $scope.filteredPayments=[];
    (function(){
        PaymentPurchaseService.loadPayments().then(function(data){
            $scope.payments=data.result;
            $scope.filteredPayments=filterFilter($scope.payments,{'customer':$scope.search});
        },function(){

        });
    })();
}]);

angular.module('app').controller('PaymentPurchaseDetailController',['$scope','PaymentPurchaseService',function($scope,paymentPurchaseService){
   
    var showDatePicker=function(){
     
        $('.datepicker').datepicker({
                changeMonth: true,
                changeYear: true,
                defaultDate: new Date(),
                yearRange: '1970:2030',
                dateFormat: 'yy-mm-dd'
        });
            
    };

    var convertDate = function(usDate) {
      var dateParts = usDate.split(/(\d{1,2})\/(\d{1,2})\/(\d{4})/);
      return dateParts[3] + "-" + (dateParts[2].length==2?dateParts[2]:('0'+dateParts[2])) + "-" + (dateParts[1].length==2?dateParts[1]:('0'+dateParts[1]));
    };


    $scope.form={
        date:convertDate(new Date().toLocaleDateString()),
        paid:'',
        type:'Cash'
    };

    $scope.isShowDetail=false;
    $scope.paymentDetails=[];

    

    var loadPaymentDetail=function(id){
        paymentPurchaseService.loadPaymentDetail(id).then(function(data){
            $scope.paymentDetails=data.result;
            showDatePicker();
        },function(){

        });
    };

    $scope.showDetail=function(){
        $scope.isShowDetail=true;
        loadPaymentDetail($scope.payment.id);
    };
    $scope.hideDetail=function(){
        $scope.isShowDetail=false;
    };

    $scope.isAvalable=function(){
        if($scope.paymentDetails.length>0)
            return true;
        else return false;
    };

   $scope.isNotValidPayment=function(){
        
        if(!$scope.form)
            return true;
        if(!$scope.form.paid)
            return true;
        if($scope.form.paid=='')
            return true;
        if($scope.form.paid=='')
            return true;
        if($scope.form.type!='Cash'&&$scope.form.type!='Voucher')
            return true;
        if(parseFloat($scope.form.paid)>(parseFloat($scope.payment.jumlah_utang+$scope.payment.ongkos_kirim-$scope.payment.paid).toFixed(2)))
            return true;
        return false;
    };

    $scope.doPayment=function(){
        paymentPurchaseService.doPayment($scope.payment.id,$scope.form).then(function(data){
            if(data.isSuccess){
                $scope.payment.paid=data.result;
                 loadPaymentDetail($scope.payment.id);
            }
            else
            {
                // Error Message
            }
        },function(){

        });
    }
  


}]);

