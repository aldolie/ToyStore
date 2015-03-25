@extends('app')

@section('content')
<div class="container" ng-controller="OrderSupplyController">
	<div class="row">
		<div class="col-md-10">
            
            <div id="order-form">
                <div class="row" id="order-header-form">
                    <div class="col-md-5 ">
                        <div>
                            <span class="label-form">No Invoice Pembelian</span>
                            <span class="label-form-delimiter">:</span>
                            <span>[[orderId]]</span>
                        </div>

                        <div>
                            <span class="label-form">Supplier</span>
                            <span class="label-form-delimiter">:</span>
                            <span><input class="form-none" type="numeric" ng-model="supplier" /></span>
                        </div>

                    </div>

                    <div class="col-md-5 col-sm-offset-2">
                        <div>
                            <span class="label-form">Tanggal</span>
                            <span class="label-form-delimiter">:</span>
                            <span>[[date]]</span>
                        </div>

                        <div>
                            <span class="label-form">Mata Uang</span>
                            <span class="label-form-delimiter">:</span>
                            <span><input class="form-none" type="numeric" ng-model="currency" /></span>
                        </div>
                        <div>
                            <span class="label-form">Dikirim oleh</span>
                            <span class="label-form-delimiter">:</span>
                            <span><input class="form-none" type="numeric" ng-model="shipper" /></span>
                        </div>
                    </div>
                </div>
                <table class="table">
                   <thead>
                       <tr>
                        <th>#</th>
                        <th>Quantity</th>
                        <th>Nama Barang</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                       </tr>
                    </thead>
                    <tbody>
                        <tr ng-controller="OrderSuppyDetailController" ng-repeat="order in orders track by $index">
                             <td>
                               <span class="glyphicon glyphicon-remove" ng-click="remove()" style="cursor:pointer;"  aria-hidden="true" ></span>
                             </td>
                            <td>
                                <input do-numeric  class="form-none small-input" type="text" ng-model="order.quantity" /></td>
                            <td>
                                <div class="container-auto-complete">
                                    
                                    <input class="form-none large-input" ng-init="order.isDisabled=false" ng-disabled="order.isDisabled" type="text" ng-model="order.nama_barang" ng-change="searchProduct()" />
                                    <span ng-click="reset()" ng-show="order.isDisabled" class="glyphicon glyphicon-trash  "  aria-hidden="true" ></span>
                                    <ul class="content-auto-complete">
                                        <li ng-repeat="product in filteredProducts track by $index" ng-click="onClickAutoComplete(product)">[[product.kode_barang+'-'+product.nama_barang]]</li>
                                    </ul>
                                </div>
                            </td>
                            <td><span>[[currency+' ']]</span></span><input do-decimal  class="form-none medium-input" type="text" ng-model="order.harga" /></td>
                            <td><span>[[currency+' ']]</span>[[ (order.quantity*order.harga) | number:2]]</td>
                        </tr>
                    </tbody>
                </table>
    
                <div class="col-md-4 col-sm-offset-8">
                        <div>
                            <span class="label-form">Grand Total</span>
                            <span class="label-form-delimiter">:</span>
                            <span>[[currency+' ']] [[ getGrandTotal() | number:2]]</span>
                        </div>

                        
                </div>
    
            </div>
            <button class="btn btn-primary" ng-click="addOrder()"><span class="glyphicon glyphicon-plus" style="margin-right:10px;" aria-hidden="true" ></span>Tambah Pembelian</button>
            <button class="btn btn-warning" ng-click="saveOrder()"><span class="glyphicon glyphicon-floppy-save" style="margin-right:10px;" aria-hidden="true" ></span>Simpan Data Pembelian</button>

		</div>
	</div>
</div>
@endsection
