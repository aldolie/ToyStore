<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>D' PURCHASING, INVENTORY AND SELLING SYSTEM</title>
    <link href="{{ asset('/css/jquery-ui.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/simple-sidebar.css') }}" rel="stylesheet" >
    <link href="{{ asset('/css/view.css') }}" rel="stylesheet" >
    <style type="text/css">
    [ng\:cloak], [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak {
      display: none !important;
    }
    </style>
	<!-- Fonts -->
	<link href='{{ asset('/css/font.css') }}' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

    <script src="{{ asset('/js/jquery.js') }}"></script>
    <script src="{{ asset('/js/jquery-ui.js') }}"></script>
</head>
<body ng-app="app">
<nav class="navbar navbar-inverse navbar-fixed-top" style="margin:0px;">
		  <div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" onclick="slide()" style="cursor:pointer;">D'PISS</a>
                    <script>
                        
                        function slide(){
                            var slider=document.getElementById('sidebar-wrapper');
                            if(slider.style.width=='250px') 
                                slider.style.width="0px";
                            else
                              slider.style.width="250px";  
                           
                        }
                    </script>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="{{ url('/') }}">Home</a></li>
				</ul>

				<ul class="nav navbar-nav navbar-right">
                   @if(Session::has('user'))
					<li><a href="{{ url('/logout/') }}">Logout</a></li>
                   @endif 
				</ul>
			</div>
		  </div>
	</nav>
    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper" ng-controller="SideBarController">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="#">
                    </a>
                </li>
                 @if($role=='admin')
                <li>
                    <a href="{{ url('/Pembelian/') }}"><span class="glyphicon glyphicon-import" style="margin-right:10px;" aria-hidden="true"></span>Pembelian</a>
                </li>
                
                <li>
                    <a href="{{ url('/Pembayaran/') }}"><span class="glyphicon glyphicon-saved" style="margin-right:10px;" aria-hidden="true"></span>Pembayaran Piutang</a>
                </li>

                @endif 
                @if($role=='sales')
                <li>
                    <a href="{{ url('/Penjualan/') }}"><span class="glyphicon glyphicon-export" style="margin-right:10px;" aria-hidden="true"></span>Penjualan</a>
                </li>

               <li>
                    <a href="{{ url('/Surat/Jalan/') }}"><span class="glyphicon glyphicon-envelope" style="margin-right:10px;" aria-hidden="true"></span>Surat Jalan</a>
                </li>
                 @endif 
               
               <li>
                    <a href="{{ url('/Product/') }}"><span class="glyphicon glyphicon-folder-close" style="margin-right:10px;" aria-hidden="true"></span>Stock Barang
                        <code class="ng-cloak" ng-cloak ng-show="isROP()">[[rop]]</code>
                    </a>
                </li>
                 @if($role=='sales')
                 <li>
                    <a href="{{ url('/Tagihan/') }}"><span class="glyphicon glyphicon-check" style="margin-right:10px;" aria-hidden="true"></span>Tagihan Pembayaran</a>
                </li>
                 @endif
                 @if($role=='admin') 
				 <li>
                    <a href="{{ url('/Pembelian/Report/') }}"><span class="glyphicon glyphicon-book" style="margin-right:10px;" aria-hidden="true"></span>Laporan Pembelian</a>
                </li>
                 @endif
                   <li>
                    <a href="{{ url('/Penjualan/Report/') }}"><span class="glyphicon glyphicon-book" style="margin-right:10px;" aria-hidden="true"></span>Laporan Penjualan</a>
                </li>
                
				<li>
                    <a href="{{ url('/Surat/Jalan/Report/') }}"><span class="glyphicon glyphicon-book" style="margin-right:10px;" aria-hidden="true"></span>Laporan Pengiriman</a>
                </li>
               
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper" ng-cloak  >
		  @yield('content')
        </div>
        <!-- /#page-content-wrapper -->

    </div>


	<!-- Scripts -->
   
	<script src="{{ asset('/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/js/angular.min.js') }}"></script>
    <script src="{{ asset('/js/angular-cookies.min.js') }}"></script>
    <script>
        var app=angular.module('app',['ngCookies']);
        app.constant("ROP",10);
        app.constant("SERVICE_URI","http://localhost:8000/apiv1/");
    </script>
    <script src="{{ asset('/js/app/directives/decimalDirective.js') }}"></script>
    <script src="{{ asset('/js/app/directives/numericDirective.js') }}"></script>
    <script src="{{ asset('/js/app/services/orderService.js') }}"></script>
    <script src="{{ asset('/js/app/services/paymentPurchaseService.js') }}"></script>
    <script src="{{ asset('/js/app/services/paymentService.js') }}"></script>
    <script src="{{ asset('/js/app/services/productService.js') }}"></script>
    <script src="{{ asset('/js/app/services/purchaseService.js') }}"></script>
    <script src="{{ asset('/js/app/services/userService.js') }}"></script>
    <script src="{{ asset('/js/app/controllers/documentRecapitulation.js') }}"></script>
    <script src="{{ asset('/js/app/controllers/orderPurchase.js') }}"></script>
    <script src="{{ asset('/js/app/controllers/orderPurchaseRecapitulation.js') }}"></script>
    <script src="{{ asset('/js/app/controllers/orderRecapitulation.js') }}"></script>
    <script src="{{ asset('/js/app/controllers/orderSupplier.js') }}"></script>
    <script src="{{ asset('/js/app/controllers/payment.js') }}"></script>
    <script src="{{ asset('/js/app/controllers/paymentPurchase.js') }}"></script>
    <script src="{{ asset('/js/app/controllers/productRecapitulation.js') }}"></script>
    <script src="{{ asset('/js/app/controllers/sendDocument.js') }}"></script>
    <script src="{{ asset('/js/app/controllers/updatePurchase.js') }}"></script>
    <script src="{{ asset('/js/app/controllers/sidebar.js') }}"></script>
    <script src="{{ asset('/js/app/app.js') }}"></script>
</body>
</html>
