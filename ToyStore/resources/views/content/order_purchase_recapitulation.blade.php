@extends('app')

@section('content')
<div class="container" ng-controller="OrderPurchaseRecapitulationController">
	<div class="row">
        <div class="col-md-10">
            
            <div id="order-report">
                <div class="row" id="order-header-report">
                    <div class="col-md-5 ">
                        <div>
                            <span class="label-form">Search By Customer</span>
                            <span class="label-form-delimiter">:</span>
                            <span><input type="text" class="form-control large-input" style="display:inline-block;" ng-model="search" ng-init="search=''" ng-change="filterOrder()" /> </span>
                        </div>

                    </div>
                </div>
                <table class="table">
                   <thead ng-init="isReverse=false">
                       <tr>
                        <th>Kode Invoice Penjualan</th>
                        <th>Nama Barang</th>
                        <th>Customer</th>
                        <th>Harga</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>
                            Tanggal Pembelian
                            <span class="glyphicon glyphicon-chevron-up" ng-show="isReverse" ng-click="orderDesc()"  style="cursor:pointer;"  aria-hidden="true" ></span>
                            <span class="glyphicon glyphicon-chevron-down" ng-hide="isReverse" ng-click="orderAsc()" style="cursor:pointer;"  aria-hidden="true" ></span>
                        </th>
                       </tr>
                    </thead>
                    <tbody>
                        <tr ng-controller="OrderPurchaseRecapitulationDetailController" ng-repeat="order in filteredOrders track by $index">
                            <td>[[order.id]]</td>
                            <td>[[order.nama_barang]]</td>
                            <td>[[order.customer]]</td>
                            <td>[[order.price]] </td>
                            <td>[[order.quantity]] </td>
                            <td>[[order.price*order.quantity]]</td>
                            <td>[[order.tanggal_transaksi]]</td>
                        </tr>
                    </tbody>
                </table>
    
    
            </div>
    </div>
</div>
@endsection