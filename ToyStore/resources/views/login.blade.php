<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Laravel</title>
    <link href="{{ asset('/css/jquery-ui.css') }}" rel="stylesheet">
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

    <script src="{{ asset('/js/jquery.js') }}"></script>
    <script src="{{ asset('/js/jquery-ui.js') }}"></script>
</head>
<body ng-app="app">
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Login</div>
				<div class="panel-body" ng-controller="AuthenticateController">
				

					<form class="form-horizontal"  ng-submit="authenticateUser()">
						

						<div class="form-group">
							<label class="col-md-4 control-label">Username</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="username" ng-model="form.username">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Password</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password" ng-model="form.password">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4 alert-danger" ng-show="isError()" style="padding:10px;">
								<div ng-repeat="error in errors">[[error]]</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">Login</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
	<script src="{{ asset('/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/js/angular.min.js') }}"></script>
    <script src="{{ asset('/js/angular-cookies.min.js') }}"></script>
    <script src="{{ asset('/js/authenticate.js') }}"></script>
    
</body>
</html>
