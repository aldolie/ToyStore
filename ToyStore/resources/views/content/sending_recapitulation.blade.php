@extends('app')

@section('content')
<div class="container" ng-controller="DocumentRecapitulationController">
	<div class="row">
        <div class="col-md-10">
            
            <div id="order-report">
                <div class="row" id="order-header-report">
                    <div class="col-md-5 ">
                        <div>
                            <span class="label-form">Search</span>
                            <span class="label-form-delimiter">:</span>
                            <span><input type="text" class="form-control large-input" style="display:inline-block;" ng-model="search" ng-init="search=''" ng-change="filterOrder()" /> </span>
                        </div>

                    </div>
                </div>
                <table class="table">
                   <thead ng-init="isReverse=false">
                       <tr>
                        <th style="max-width:50px;">Kode Invoice</th>
                        <th style="max-width:50px;">Nomor Surat Jalan</th>
                        <th style="max-width:150px;min-width:80px;">Nama</th>
                        <th style="max-width:200px;min-width:80px;">Alamat</th>
                        <th>Tracking Number</th>
                        <th>Ongkos Kirim</th>
                        
                         <th>
                            Tanggal Pembelian
                            <span class="glyphicon glyphicon-chevron-up" ng-show="isReverse" ng-click="orderDesc()"  style="cursor:pointer;"  aria-hidden="true" ></span>
                            <span class="glyphicon glyphicon-chevron-down" ng-hide="isReverse" ng-click="orderAsc()" style="cursor:pointer;"  aria-hidden="true" ></span>
                        </th>
                        <th>Action</th>
                       </tr>
                    </thead>
                    <tbody>
                        <tr ng-controller="DocumentRecapitulationDetailController" ng-repeat="document in filteredDocuments track by $index">
                            <td style="max-width:50px;">[[document.invoice]]</td>
                            <td style="max-width:50px;">[[document.id]]</td>
                            <td style="max-width:150px;min-width:80px;">[[document.destination]]</td>
                            <td style="max-width:200px;min-width:80px;">[[document.address]]</td>
                            <td><input type="text" class="form-none small" ng-model="document.tracking_number" /> </td>
                            <td><input type="text" do-numeric class="form-none small" ng-model="document.ongkos_kirim" /> </td>
                            <td>[[document.transactiondate]]</td>
                            <td><button class="btn btn-primary">Update</button></td>
                        </tr>
                    </tbody>
                </table>
    
    
            </div>
    </div>
</div>
@endsection
