@extends('app')

@section('content')
<div class="container" ng-controller="OrderPurchaseController">
	<div class="row">
		<div class="col-md-10" style="margin-top:30px;">
            <h3>BACK UP</h3>
            <a class="btn btn-primary" href="{{url('/Konfigurasi/backup')}}" target="_blank">BACK UP</a>
            <h3>DELETE</h3>
            <a class="btn btn-danger" href="{{url('/Konfigurasi/delete')}}" target="_blank">DELETE</a>
            <h3>RESTORE</h3>
            <form style="margin-top:20px;" method="POST" action="{{url('/Konfigurasi/restore')}}" enctype="multipart/form-data">
                <input class="form-control" style="margin-bottom:20px;" type="file" name="file" />
                <input type="submit" class="btn btn-warning" value="RESTORE" />
            </form>
        </div>
	</div>
</div>
@endsection
