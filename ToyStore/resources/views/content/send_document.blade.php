@extends('app')

@section('content')
<div class="container" ng-controller="SendDocumentController">
	<div class="row">
		<div class="col-md-10">
            
            <div id="order-form">
                <div class="row" id="send-header-form">
                    <div class="col-md-5 ">
                        <div>
                            <span class="label-form">No Invoice Penjualan</span>
                            <span class="label-form-delimiter">:</span>
                            <span>
                                <input  type="text" class="form-none small" ng-model="search" ng-disabled="isLock()" />
                                <span class="glyphicon glyphicon-search" ng-hide="isLock()" style="margin-right:10px;cursor:pointer;" ng-click="searchTransaction()" aria-hidden="true"></span>
                            </span>
                        </div>

                        <div ng-show="isLock()">
                            <span class="label-form">No Surat Jalan</span>
                            <span class="label-form-delimiter">:</span>
                            <span><input type="text"  class="form-none medium"  ng-model="form.id" /></span>
                        </div>
                    </div>

                    <div class="col-md-5 col-sm-offset-2" ng-show="isLock()">
                        <div>
                            <span class="label-form">Kepada</span>
                            <span class="label-form-delimiter">:</span>
                            <span><input type="text"  class="form-none medium"  ng-model="form.to" /></span>
                        </div>
                        <div>
                            <span class="label-form">Alamat</span>
                            <span class="label-form-delimiter">:</span>
                            <span><input type="text" class="form-none medium" ng-model="form.address"/></span>
                        </div>
                        
                    </div>
                </div>
                <table class="table table-condensed" ng-show="isLock()">
                   <thead>
                       <tr>
                        <th>#</th>
                        <th>Quantity</th>
                        <th>Nama Barang</th>
                       </tr>
                    </thead>
                    <tbody>
                        <tr ng-controller="SendDocumentDetailController" ng-repeat="order in orders track by $index">
                             <td>
                               <span class="glyphicon glyphicon-remove" ng-click="remove()" style="cursor:pointer;"  aria-hidden="true" ></span>
                             </td>
                            <td>
                                <input do-numeric  class="form-none small-input" type="text" ng-model="order.quantity" ng-change="validateQuantity([[order.quantity]])" />
                                <code>Sisa :[[order.remaining]]</code>
                            </td>
                            <td>[[order.nama_barang]]</td>
                        </tr>
                    </tbody>
                </table>
    
               

                
    
            </div>
            <div style="margin-top:20px;padding:10px;clear:both;" ng-show="isLock()">
                <button class="btn btn-warning" ng-click="saveSuratJalan()"><span class="glyphicon glyphicon-floppy-save" style="margin-right:10px;" aria-hidden="true" ></span>Simpan Surat Jalan</button>
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
                       <div class="col-md-5" style="float:left;">
                        <div>
                            <span class="label-form">No Invoice Penjualan</span>
                            <span class="label-form-delimiter">:</span>
                            <span>
                                <span class="form-none small" >[[search]]</span>
                            </span>
                        </div>

                        <div>
                            <span class="label-form">No Surat Jalan</span>
                            <span class="label-form-delimiter">:</span>
                            <span>[[form.id]]</span>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-offset-1" style="float:right;">
                        <div>
                            <span class="label-form">Kepada</span>
                            <span class="label-form-delimiter">:</span>
                            <span><span type="text" ng-model="form.to"  class="form-none medium" >[[form.to]]</span></span>
                        </div>
                        <div>
                            <span class="label-form">Alamat</span>
                            <span class="label-form-delimiter">:</span>
                            <span><span type="text" class="form-none medium" style="max-width:100px;display:inline-block;vertical-align:top;"  >[[form.address]]</span></span>
                        </div>
                        
                    </div>
                    <div style="clear:both;"></div>
                
                <table class="table table-condensed">
                   <thead>
                       <tr>
                        <th>Quantity</th>
                        <th>Nama Barang</th>
                       </tr>
                    </thead>
                    <tbody>
                        <tr ng-controller="SendDocumentDetailController" ng-repeat="order in orders track by $index">
                             <td>
                                <span  class="form-none small-input">[[order.quantity]]</span>
                            </td>
                            <td>[[order.nama_barang]]</td>
                        </tr>
                    </tbody>
                </table>  
                <div class="col-md-5" style="float:left;">
                        <div>
                            <span class="label-form">Penerima</span>
                            <div style="margin:20px 0px;">&nbsp;</div>
                            <span><input class="form-none" type="text" disabled="disabled"/></span>
                        </div>

                </div>

                <div class="col-md-5" style="float:left;">
                        <div>
                            <span class="label-form">Hormat Kami</span>
                            <div style="margin:20px 0px;">&nbsp;</div>
                            <span><input class="form-none" type="text" disabled="disabled"/></span>
                        </div>

                </div>
                <div style="clear:both;"></div>
                

              </div>
                <div>
                    <code>[[error]]</code>
                </div>
                <div style="margin-top:30px;clear:both;padding-top:20px;">
                     <button class="btn btn-primary" ng-click="submitSuratJalan()">
                             <span class="glyphicon glyphicon-floppy-save" style="margin-right:10px;" aria-hidden="true" ></span>Simpan Surat Jalan
                    </button>
                     <button class="btn btn-warning" ng-click="print()">
                            <span class="glyphicon glyphicon-print" style="margin-right:10px;" aria-hidden="true" ></span>Print SuratJalan
                    </button>
                    <button class="btn btn-danger" ng-click="cancelSuratJalan()">
                            <span class="glyphicon glyphicon-remove" style="margin-right:10px;" aria-hidden="true" ></span>Cancel Surat Jalan
                    </button>
                </div>
            </div>
		</div>

<!-- Confirmation Dialog -->

	</div>
</div>
@endsection
