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
                            <span><input type="text" class="form-none"  ng-model="form.orderId" /></span>
                        </div>

                        <div>
                            <span class="label-form">Supplier</span>
                            <span class="label-form-delimiter">:</span>
                            <span><input class="form-none" type="text" ng-model="supplier" /></span>
                        </div>

                    </div>

                    <div class="col-md-5 col-sm-offset-2">
                        <div>
                            <span class="label-form">Tanggal</span>
                            <span class="label-form-delimiter">:</span>
                            <span>
                                <input class="form-none" type="text" id="datepicker" ng-model="date"/>
                                <script>
                                (function(){
                                    var d = new Date();
                                    $('#datepicker').datepicker({
                                            changeMonth: true,
                                            changeYear: false,
                                            defaultDate: d,
                                            yearRange: '1970:2030',
                                            dateFormat: 'yy-mm-dd',
                                            stepMonths: 0
                                    });

                                })();
                                </script>
                            </span>
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
                <table class="table table-condensed">
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
                                    <ul class="content-auto-complete new-content-auto-complete">
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
            <button class="btn btn-info" ng-click="addOrder()"><span class="glyphicon glyphicon-plus" style="margin-right:10px;" aria-hidden="true" ></span>Tambah Pembelian</button>
            <button class="btn btn-warning" ng-click="saveOrder()"><span class="glyphicon glyphicon-floppy-save" style="margin-right:10px;" aria-hidden="true" ></span>Simpan Data Pembelian</button>
   
<!-- Error Dialog -->

<div id="modal-save-error" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Error Message</h4>
      </div>    
        <div class="modal-body">
            [[error]]
      </div>
    </div>
  </div>
</div>

<!-- Error Dialog -->

<!-- Confirmation Dialog -->
<div id="modal-save" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" >
              <div class="modal-dialog modal-lg" >
                <div id="modal-save-content" class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Konfirmasi</h4>
                      </div>
                     <div id="order-form-confirmation">
                        <div class="row" id="order-header-form">
                            <div class="col-md-6" style="float:left;">
                                <div>
                                    <span class="label-form">No Invoice Pembelian</span>
                                    <span class="label-form-delimiter">:</span>
                                    <span>[[form.orderId]]</span>
                                </div>

                                <div>
                                    <span class="label-form">Supplier</span>
                                    <span class="label-form-delimiter">:</span>
                                    <span><span class="form-none" >[[supplier]]</span></span>
                                </div>

                            </div>

                            <div class="col-md-4" style="float:right;">
                                <div>
                                    <span class="label-form">Tanggal</span>
                                    <span class="label-form-delimiter">:</span>
                                    <span>[[date]]</span>
                                </div>

                                <div>
                                    <span class="label-form">Mata Uang</span>
                                    <span class="label-form-delimiter">:</span>
                                    <span><span  class="form-none" >[[currency]]</span></span>
                                </div>
                                <div>
                                    <span class="label-form">Dikirim oleh</span>
                                    <span class="label-form-delimiter">:</span>
                                    <span><span class="form-none"  />[[shipper]]</span></span>
                                </div>
                            </div>
                            <div style="clear:both;"></div>
                    </div>

                    <table class="table">
                       <thead>
                           <tr>
                            <th>Quantity</th>
                            <th>Nama Barang</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                           </tr>
                        </thead>
                        <tbody>
                            <tr ng-controller="OrderSuppyDetailController" ng-repeat="order in orders track by $index">

                                <td>
                                    <div class="form-none small-input">[[order.quantity]]</div>
                                </td>
                                <td>
                                    <div class="form-none">[[order.nama_barang]] <code ng-show="isNewItem()">Baru</code></div>
                                    
                                </td>
                                <td>
                                    
                                    <div class="form-none small-input"><span>[[currency+' ']]</span>[[order.harga]]</div>
                                </td>
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
                <div>
                    <code>[[error]]</code>
                     <button class="btn btn-primary" ng-click="submitOrder()">
                             <span class="glyphicon glyphicon-floppy-save" style="margin-right:10px;" aria-hidden="true" ></span>Simpan Pembelian
                    </button>
                      <button class="btn btn-warning" ng-click="print()">
                            <span class="glyphicon glyphicon-print" style="margin-right:10px;" aria-hidden="true" ></span>Print Pembelian
                    </button>
                    <button class="btn btn-danger" ng-click="cancelOrder()">
                            <span class="glyphicon glyphicon-remove" style="margin-right:10px;" aria-hidden="true" ></span>Cancel Pembelian
                    </button>
                </div>

              </div>
            </div>
		</div>

<!-- Confirmation Dialog -->

	</div>
</div>
@endsection
