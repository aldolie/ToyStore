@extends('app')

@section('content')
<div class="container" ng-controller="PasswordController">
	<div class="row">
		<div class="col-md-10" style="margin-top:30px;">
           <h3>Change Password</h3>
            <form style="margin-top:20px;" ng-init="form.id={{$userid}}" ng-submit="changePassword()">
                <label for="oldpassword">Password Lama</label>
                <input class="form-control" style="margin-bottom:20px;" type="password" ng-model="form.oldpassword" name="oldpassword" />
                <label for="password">Password Baru</label>
                <input class="form-control" style="margin-bottom:20px;" type="password" ng-model="form.password" name="password" />
                <label for="cpassword">Konfirmasi Password</label>
                <input class="form-control" style="margin-bottom:20px;" type="password" ng-model="form.cpassword" name="cpassword" />
                <div class="alert alert-danger" ng-show="error.length>0">
                    <div><b>Terdapat input yang salah</b></div>
                    <ul>
                        <li ng-repeat="err in error">[[err]]</li>
                    </ul>
                </div>
                <div class="alert alert-info" ng-hide="info==''">
                    [[info]]
                </div>
                <input type="submit" class="btn btn-primary" value="Change Password" />
            </form>
        </div>
	</div>
</div>
@endsection
