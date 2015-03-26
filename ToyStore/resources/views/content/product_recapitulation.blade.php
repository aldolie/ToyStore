@extends('app')

@section('content')
<div class="container" ng-controller="ProductRecapitulationController">
	<div class="row">
		<div class="col-md-10">
            
            <div id="product-report">
                <div class="row" id="product-header-report">
                    <div class="col-md-5 ">
                        <div>
                            <span class="label-form">Search</span>
                            <span class="label-form-delimiter">:</span>
                            <span><input type="text" class="form-control large-input" style="display:inline-block;" ng-model="search" ng-init="search=''" ng-change="filterProduct()" /> </span>
                        </div>

                    </div>
                </div>
                <table class="table">
                   <thead>
                       <tr>
                        <th>Nama Barang</th>
                        <th>Stock</th>
                        <th>Harga Jual</th>
                       </tr>
                    </thead>
                    <tbody>
                        <tr ng-controller="ProductRecapitulationDetailController" ng-repeat="product in filteredProducts track by $index">
                            
                            <td>[[product.nama_barang]]</td>
                            <td>[[product.quantity]] <code ng-show="isReOrderPoint()">Order</code></code></td>
                            <td>
                                <span ng-show="isAvailable()">[[product.harga | currency:'Rp.']]</span>
                                <code ng-hide="isAvailable()">Belum Ada Transaksi</code>
                            </td>
                        </tr>
                    </tbody>
                </table>
    
    
            </div>
	</div>
</div>
@endsection
