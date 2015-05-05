angular.module('app').factory('PrintService',function(){
    function PrintService(){ 
    }
    PrintService.prototype={
     constructor:PrintService, 
        print:function(form){
			    var printContents = document.getElementById(form).innerHTML;
          var head=document.getElementsByTagName("head")[0].innerHTML;
          var documentString='<html><head>'+head+'</head><body onload="window.print()">';
          documentString+=printContents;
          documentString+='</html>';
          var popupWin = window.open('', '_blank', 'width=800,height=800');
          popupWin.document.open();
          popupWin.document.write(documentString);
          popupWin.document.close();
		    }
       
    }
    var instance=new PrintService();
	return instance;
});
