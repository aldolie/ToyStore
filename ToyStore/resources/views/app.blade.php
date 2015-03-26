<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Laravel</title>

	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/simple-sidebar.css') }}" rel="stylesheet" >
    <link href="{{ asset('/css/view.css') }}" rel="stylesheet" >

	<!-- Fonts -->
	<link href='{{ asset('/css/font.css') }}' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
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
				<a class="navbar-brand" href="#">Toy Store</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="{{ url('/') }}">Home</a></li>
				</ul>

				<ul class="nav navbar-nav navbar-right">
					@if (Auth::guest())
						<li><a href="{{ url('/auth/login') }}">Login</a></li>
						<li><a href="{{ url('/auth/register') }}">Register</a></li>
					@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{ url('/auth/logout') }}">Logout</a></li>
							</ul>
						</li>
					@endif
				</ul>
			</div>
		  </div>
	</nav>
    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="#">
                        Divine
                    </a>
                </li>
                <li>
                    <a href="{{ url('/Pembelian') }}"><span class="glyphicon glyphicon-folder-close" style="margin-right:10px;" aria-hidden="true"></span>Pembelian</a>
                </li>
                
               
                <li>
                    <a href="{{ url('/auth/login') }}"><span class="glyphicon glyphicon-user" style="margin-right:10px;" aria-hidden="true"></span>Pembayaran Piutang</a>
                </li>
                <li>
                    <a href="{{ url('/auth/login') }}"><span class="glyphicon glyphicon-unchecked" style="margin-right:10px;" aria-hidden="true"></span>Penjualan</a>
                </li>
               <li>
                    <a href="{{ url('/auth/login') }}"><span class="glyphicon glyphicon-check" style="margin-right:10px;" aria-hidden="true"></span>Surat Jalan</a>
                </li>
                
                 <li>
                    <a href="{{ url('/auth/login') }}"><span class="glyphicon glyphicon-book" style="margin-right:10px;" aria-hidden="true"></span>Tagihan Pembayaran</a>
                </li>
                <li>
                    <a href="{{ url('/Product/') }}"><span class="glyphicon glyphicon-book" style="margin-right:10px;" aria-hidden="true"></span>Stock Barang</a>
                </li>
				 <li>
                    <a href="{{ url('/auth/login') }}"><span class="glyphicon glyphicon-book" style="margin-right:10px;" aria-hidden="true"></span>Laporan Pembelian</a>
                </li>
                   <li>
                    <a href="{{ url('/auth/login') }}"><span class="glyphicon glyphicon-book" style="margin-right:10px;" aria-hidden="true"></span>Laporan Penjualan</a>
                </li>
                
				<li>
                    <a href="{{ url('/auth/login') }}"><span class="glyphicon glyphicon-book" style="margin-right:10px;" aria-hidden="true"></span>Laporan Pengiriman</a>
                </li>
               
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper"  >
		  @yield('content')
        </div>
        <!-- /#page-content-wrapper -->

    </div>


	<!-- Scripts -->
	<script src="{{ asset('/js/jquery.js') }}"></script>
	<script src="{{ asset('/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/js/angular.min.js') }}"></script>
    <script>
        var app=angular.module('app',[]);
        app.constant("CSRF_TOKEN", "{!! csrf_token() !!}");
        app.constant("ROP",10);
        app.constant("SERVICE_URI","http://localhost:8000/apiv1/");
    </script>
    <script src="{{ asset('/js/app.js') }}"></script>
</body>
</html>
