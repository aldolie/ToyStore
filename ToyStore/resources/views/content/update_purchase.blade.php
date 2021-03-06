@extends('app')

@section('content')
<div class="container" ng-controller="UpdatePurchaseController">
	<div class="row">

		<div class="col-md-10" ng-init="isFound={{$isFound}}">
            
            <div id="order-form">
                    <form method="POST" action="{{url('/Penjualan')}}">
                        <span class="label-form">Search Form</span>
                        <span class="label-form-delimiter">:</span>
                        <span>
                            <input  type="text" class="form-none small" name="search" />
                            <button type="submit" style="background:transparent;border:none;" >
                                <span class="glyphicon glyphicon-search" style="margin-right:10px;cursor:pointer;" aria-hidden="true"></span>
                            </button>
                        </span>
                    </form>  
                
                <div class="row" id="order-header-form" ng-show="isFound">

                    <div class="col-md-5 ">
                        
                        <div>
                            <span class="label-form">No Invoice Penjualan</span>
                            <span class="label-form-delimiter">:</span>
                            <span ng-init="form.orderId='{{$id}}'" >[[form.orderId]]</span>
                        </div>
                        <div ng-init="init()">
                            <span class="label-form">Customer</span>
                            <span class="label-form-delimiter">:</span>
                            <span>
                                <div class="container-auto-complete" style="display:inline-block;" >
                                    <input class="form-none" type="text" ng-model="form.customer" ng-change="searchCustomer()" />
                                    <ul class="content-auto-complete">
                                        <li ng-repeat="customer in filteredCustomers track by $index" ng-click="onClickAutoCompleteCustomer(customer)">[[customer.username]]</li>
                                    </ul>
                                </div>
                            </span>
                        </div>
                        

                        <div>
                            <span class="label-form">Salesman</span>
                            <span class="label-form-delimiter">:</span>
                            <span>[[form.sales]]</span>
                        </div>

                    </div>

                    <div class="col-md-5 col-sm-offset-2">
                        <div>
                            <span class="label-form">Tanggal</span>
                            <span class="label-form-delimiter">:</span>
                            <span>
                                <input class="form-none" type="text" id="datepicker" ng-model="form.date"/>
                                <script>
                                (function(){
                                    var d = new Date();
                                    $('#datepicker').datepicker({
                                            changeMonth: true,
                                            changeYear: true,
                                            defaultDate: d,
                                            yearRange: '1970:2030',
                                            dateFormat: 'yy-mm-dd'
                                    });

                                })();
                                </script>
                            </span>
                        </div>
                        <div>
                            <span class="label-form">Alamat</span>
                            <span class="label-form-delimiter">:</span>
                            <span>
                                <div class="container-auto-complete" style="display:inline-block;" >
                                    <input class="form-none" type="text" ng-model="form.address" ng-change="searchAddress()" />
                                    <ul class="content-auto-complete">
                                        <li ng-repeat="address in filteredAddresses track by $index" ng-click="onClickAutoCompleteAddress(address)">[[address.address]]</li>
                                    </ul>
                                </div>
                            </span>
                        </div>
                        <div>
                            <span class="label-form"></span>
                            <span class="label-form-delimiter"></span>
                            <span></span>
                        </div>
                        <div>
                            <span class="label-form"></span>
                            <span class="label-form-delimiter"><input type="checkbox" ng-model="form.salesOrder"/></span>
                            <span>Sales Order</span>
                        </div>
                        <div>
                            <span class="label-form"></span>
                            <span class="label-form-delimiter"><input type="checkbox" ng-model="form.isDp"/></span>
                            <span>Down Payment</span>
                        </div>
                        <div>
                            <span class="label-form"></span>
                            <span class="label-form-delimiter"><input type="checkbox" ng-model="form.isDiscount"/></span>
                            <span>Discount</span>
                        </div>
                    </div>
                </div>
                <table class="table table-condensed" ng-show="isFound">
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
                        <tr ng-controller="UpdatePurchaseDetailController" ng-repeat="order in orders track by $index">
                             <td>
                               <span class="glyphicon glyphicon-remove" ng-click="remove()" style="cursor:pointer;"  aria-hidden="true" ></span>
                             </td>
                            <td>
                                <input do-numeric  class="form-none small-input" type="text" ng-model="order.quantity"  ng-change="validateQuantity([[order.quantity]])" ng-disabled="isAlreadyChoosed()" />
                                <span ng-show="isAvalableStock()"><code>Stock: [[order.limit+order.old-order.quantity]] </code></span>
                            </td>
                            <td>
                                <div class="container-auto-complete">
                                    <input class="form-none large-input" ng-init="order.isDisabled=false" ng-disabled="order.isDisabled" type="text" ng-model="order.nama_barang" ng-change="searchProduct()" />
                                    <ul class="content-auto-complete">
                                        <li ng-repeat="product in filteredProducts track by $index" ng-click="onClickAutoComplete(product)">[[product.kode_barang+'-'+product.nama_barang]]</li>
                                    </ul>
                                </div>
                            </td>
                            <td><span>Rp. </span><input do-numeric  class="form-none medium-input" type="text" ng-model="order.harga" /></td>
                            <td><span>Rp. </span>[[ (order.quantity*order.harga) ]]</td>
                        </tr>
                    </tbody>
                </table>
    
                  <div class="col-md-5 col-sm-offset-7" ng-show="form.isDp">
                        <div>
                            <span class="label-form">Down Payment</span>
                            <span class="label-form-delimiter">:</span>
                            <span>Rp. <input do-numeric  class="form-none medium-input" type="text" ng-model="form.dp" /></span>
                        </div>

                </div>

                <div class="col-md-5 col-sm-offset-7" ng-show="form.isDiscount">
                        <div>
                            <span class="label-form">Discount</span>
                            <span class="label-form-delimiter">:</span>
                            <span><span>Rp. </span><input do-numeric  class="form-none medium-input" type="text" ng-model="form.discount" /></span>
                        </div>

                </div>

                <div class="col-md-5 col-sm-offset-7">
                        <div>
                            <span class="label-form">Total</span>
                            <span class="label-form-delimiter">:</span>
                            <span>Rp.  [[ getGrandTotal() ]]</span>
                        </div>
                </div>

                 <div class="col-md-5 col-sm-offset-7">
                        <div>
                            <span class="label-form">Grand Total</span>
                            <span class="label-form-delimiter">:</span>
                            <span>Rp.  [[ getGrandTotal()-form.discount-form.dp ]]</span>
                        </div>
                </div>
    
            </div>
            <div ng-show="isFound">
                <button class="btn btn-info" ng-click="addOrder()"><span class="glyphicon glyphicon-plus" style="margin-right:10px;" aria-hidden="true" ></span>Tambah Penjualan</button>
                <button class="btn btn-warning" ng-click="saveOrder()"><span class="glyphicon glyphicon-floppy-save" style="margin-right:10px;" aria-hidden="true" ></span>Simpan Data Penjualan</button>
            </div>
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
<div id="modal-save" class="modal fade bs-example-modal-lg"  role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" >
              <div class="modal-dialog modal-lg" >
                <div id="modal-save-content" class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Konfirmasi</h4>
                      </div>
                     <div id="order-form-confirmation">
                        <div class="row" id="order-header-form">
                            <div class="col-md-6" style="float:left;">
                                   <div>
                                        <span class="label-form">No Invoice Penjualan</span>
                                        <span class="label-form-delimiter">:</span>
                                        <span>[[form.orderId]]</span>
                                    </div>

                                    <div>
                                        <span class="label-form">Customer</span>
                                        <span class="label-form-delimiter">:</span>
                                        <span>[[form.customer]]</span>
                                    </div>

                                    <div>
                                        <span class="label-form">Salesman</span>
                                        <span class="label-form-delimiter">:</span>
                                        <span>[[form.sales]]</span>
                                    </div>
                            </div>

                            <div class="col-md-6" style="float:right;">
                                <div>
                                    <span class="label-form">Tanggal</span>
                                    <span class="label-form-delimiter">:</span>
                                    <span>[[form.date]]</span>
                                </div>
                                 <div>
                                    <span class="label-form">Alamat</span>
                                    <span class="label-form-delimiter">:</span>
                                    <span>
                                         [[form.address]]
                                    </span>
                                </div>
                                <div>
                                    <span class="label-form"></span>
                                    <span class="label-form-delimiter">

                                        <input type="checkbox" ng-show="form.salesOrder"   checked="checked" ng-disabled="true"/>
                                    </span>
                                    <span ng-show="form.salesOrder">Sales Order</span>
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
                            <tr ng-controller="OrderPurchaseDetailController" ng-repeat="order in orders track by $index">

                                <td>
                                    <div class="form-none small-input">[[order.quantity]]</div>
                                </td>
                                <td>
                                    <div class="form-none">[[order.nama_barang]] <code ng-show="isErrorQuantity()">[[order.error]]</code></div>
                                    
                                </td>
                                <td>
                                    
                                    <div class="form-none small-input"><span></span>[[order.harga|currency:'Rp.']]</div>
                                </td>
                                <td><span></span>[[ (order.quantity*order.harga)|currency:'Rp.' ]]</td>
                            </tr>
                        </tbody>
                    </table>
                    

                         <div class="col-md-5 col-sm-offset-7" ng-show="form.isDp">
                        <div>
                            <span class="label-form">Down Payment</span>
                            <span class="label-form-delimiter">:</span>
                            <span>[[form.dp |currency:'Rp.']]</span>
                        </div>

                </div>

                <div class="col-md-5 col-sm-offset-7" ng-show="form.isDiscount">
                        <div>
                            <span class="label-form">Discount</span>
                            <span class="label-form-delimiter">:</span>
                            <span><span>[[form.discount |currency:'Rp.']]</span>
                        </div>

                </div>

                <div class="col-md-5 col-sm-offset-7">
                        <div>
                            <span class="label-form">Total</span>
                            <span class="label-form-delimiter">:</span>
                            <span> [[ getGrandTotal() |currency:'Rp.' ]]</span>
                        </div>
                </div>

                 <div class="col-md-5 col-sm-offset-7">
                        <div>
                            <span class="label-form">Grand Total</span>
                            <span class="label-form-delimiter">:</span>
                            <span>[[ getGrandTotal()-form.discount-form.dp|currency:'Rp.' ]]</span>
                        </div>
                </div>
                    
                    <code>[[error]]</code>
                </div>
                <div>
                     <button class="btn btn-primary" ng-click="submitOrder()">
                             <span class="glyphicon glyphicon-floppy-save" style="margin-right:10px;" aria-hidden="true" ></span>Simpan Penjualan
                    </button>
                    <button class="btn btn-warning" ng-click="print()">
                            <span class="glyphicon glyphicon-print" style="margin-right:10px;" aria-hidden="true" ></span>Print Penjualan
                    </button>
                      <button class="btn btn-default" ng-click="printStruk()">
                            <span class="glyphicon glyphicon-print" style="margin-right:10px;" aria-hidden="true" ></span>Print Struk Penjualan
                    </button>
                    <button class="btn btn-danger" ng-click="cancelOrder()">
                            <span class="glyphicon glyphicon-remove" style="margin-right:10px;" aria-hidden="true" ></span>Cancel Penjualan
                    </button>
                </div>

              </div>
            </div>
		</div>

<!-- Confirmation Dialog -->

	</div>





<div style="display:none;">
    <div id="order-form-struk">
                        <div class="row" id="order-header-form">
                            <div class="col-md-6 ">
                                   <div>
                                        <span class="label-form">No Invoice Penjualan</span>
                                        <span class="label-form-delimiter">:</span>
                                        <span>[[form.orderId]]</span>
                                    </div>

                                    <div>
                                        <span class="label-form">Customer</span>
                                        <span class="label-form-delimiter">:</span>
                                        <span>[[form.customer]]</span>
                                    </div>

                                    <div>
                                        <span class="label-form">Salesman</span>
                                        <span class="label-form-delimiter">:</span>
                                        <span>[[form.sales]]</span>
                                    </div>
                                    <div>
                                        <span class="label-form">Tanggal</span>
                                        <span class="label-form-delimiter">:</span>
                                        <span>[[form.date]]</span>
                                    </div>
                                    <div>
                                        <span class="label-form"></span>
                                        <span class="label-form-delimiter"></span>
                                        <span></span>
                                    </div>
                                    <div>
                                        <span class="label-form"></span>
                                        <span class="label-form-delimiter">

                                            <input type="checkbox" ng-show="form.salesOrder"   checked="checked" ng-disabled="true"/>
                                        </span>
                                        <span ng-show="form.salesOrder">Sales Order</span>
                                    </div>
                            </div>

                    </div>
                        <div style="border-top:1px solid #666;width:100%;margin:5px 0px;" >&nbsp;</div>
                            <div ng-controller="OrderPurchaseDetailController" ng-repeat="order in orders track by $index" style="margin-bottom:8px;">
                                <div class="col-xs-12" style="font-weight:bold;letter-spacing:2px;">[[order.nama_barang]]</div>
                                    <div class="small-input col-xs-1 col-xs-offset-1">[[order.quantity]]</div>
                                    <div class="small-input col-xs-1">X</div>
                                    <div class="small-input col-xs-3"><span></span>[[order.harga |currency:'Rp.']]</div>
                                    <div style="text-align:right;">[[ (order.quantity*order.harga) |currency:'Rp.']]</div>
                            </div>
                       <div style="clear:both;"></div> 
                    <div style="border-top:1px solid #666;width:100%;margin:5px 0px;" >&nbsp;</div>
                <div class="col-md-5 col-sm-offset-7" ng-show="form.isDp">
                    <div>
                        <span class="label-form">Down Payment</span>
                        <span class="label-form-delimiter">:</span>
                        <span>[[form.dp |currency:'Rp.']]</span>
                    </div>

                </div>

                <div class="col-md-5 col-sm-offset-7" ng-show="form.isDiscount">
                        <div>
                            <span class="label-form">Discount</span>
                            <span class="label-form-delimiter">:</span>
                            <span><span>[[form.discount |currency:'Rp.']]</span>
                        </div>

                </div>

                <div class="col-md-5 col-sm-offset-7">
                        <div>
                            <span class="label-form">Total</span>
                            <span class="label-form-delimiter">:</span>
                            <span>[[ getGrandTotal() |currency:'Rp.']]</span>
                        </div>
                </div>

                 <div class="col-md-5 col-sm-offset-7">
                        <div>
                            <span class="label-form">Grand Total</span>
                            <span class="label-form-delimiter">:</span>
                            <span> [[ getGrandTotal()-form.discount-form.dp |currency:'Rp.']]</span>
                        </div>
                </div>
                </div>
              </div>
  </div>





</div>
@endsection
