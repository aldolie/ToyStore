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
                        <th style="max-width:150px;">Kode Invoice</th>
                        <th style="max-width:150px;">Nomor Surat Jalan</th>
                        <th style="max-width:150px;min-width:80px;">Nama</th>
                        <th style="max-width:300px;min-width:80px;">Alamat</th>
                        <th>Tracking Number</th>
                        <th>Ongkos Kirim</th>
                        
                         <th >
                            Tanggal Pembelian
                            <span class="glyphicon glyphicon-chevron-up" ng-show="isReverse" ng-click="orderDesc()"  style="cursor:pointer;"  aria-hidden="true" ></span>
                            <span class="glyphicon glyphicon-chevron-down" ng-hide="isReverse" ng-click="orderAsc()" style="cursor:pointer;"  aria-hidden="true" ></span>
                        </th>
                        <th style="max-width:300px;min-width:200px;" >Action</th>
                       </tr>
                    </thead>
                    <tbody>
                        <tr ng-controller="DocumentRecapitulationDetailController" ng-repeat="document in filteredDocuments track by $index">
                            <td style="max-width:150px;">[[document.invoice]]</td>
                            <td style="max-width:150px;">[[document.suratJalan]]</td>
                            <td style="max-width:150px;min-width:80px;">[[document.destination]]</td>
                            <td style="max-width:300px;min-width:80px;">[[document.address]]</td>
                            <td><input type="text" class="form-none small" ng-model="document.tracking_number" /> </td>
                            <td><input type="text" do-numeric class="form-none small" ng-model="document.ongkos_kirim" /> </td>
                            <td>[[document.transactiondate]]</td>
                            <td>
                                <button class="btn btn-primary" ng-click="update()">Update</button>
                                <button class="btn btn-danger" ng-click="delete()">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
    
    
            </div>
    </div>

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


</div>


@endsection
