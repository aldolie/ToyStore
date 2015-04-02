@extends('app')

@section('content')
<div class="container" ng-controller="PaymentController">
	<div class="row">
        <div class="col-md-10">
            
          <div id="payment-form">
               <div class="row" id="payment-header-form">
                    <div class="col-md-5 ">
                        <div>
                            <span class="label-form">Search</span>
                            <span class="label-form-delimiter">:</span>
                            <span><input type="text" class="form-control large-input" style="display:inline-block;" ng-model="search" ng-init="search=''" ng-change="filterPayments()" /> </span>
                        </div>

                    </div>
                </div>
                <table class="table" >
                    <thead >
                       <tr>
                        <th>#</th>
                        <th>Kode Invoice</th>
                        <th>Supplier</th>
                        <th>Jumlah Hutang</th>
                        <th>Jumlah Bayar</th>
                        <th>Sisa</th>
                        <th>Tanggal Pembelian</th>
                       </tr>
                    </thead>
                    <tbody ng-controller="PaymentDetailController" ng-repeat="payment in filteredPayments" ng-init="isShowDetail=false">
                        <tr>
                          <td>
                            <span class="glyphicon glyphicon-chevron-up" ng-show="isShowDetail" ng-click="hideDetail()"   style="cursor:pointer;"  aria-hidden="true" ></span>
                            <span class="glyphicon glyphicon-chevron-down" ng-hide="isShowDetail" ng-click="showDetail()"  style="cursor:pointer;"  aria-hidden="true" ></span>
                          </td>
                          <td>[[payment.kode_invoice]]</td>
                          <td>[[payment.supplier]]</td>
                          <td>[[payment.currency]]&nbsp; [[payment.jumlah_utang]]</td>
                          <td>[[payment.currency]]&nbsp; [[payment.paid]]</td>
                          <td>[[payment.currency]]&nbsp; [[payment.jumlah_utang-payment.paid]]</td>
                          <td>[[payment.tanggal_pembelian]]</td>
                        </tr>
                        <tr ng-show="isShowDetail">
                          <td></td>
                          <td></td>
                          <td></td>
                          <td colspan="4">
                            <div class="alert alert-info" role="alert">Belum Ada Pembayaran</div>
                            <table class="table" ng-show="isAvalable()">
                              <thead>
                                <tr>
                                  <th>Tanggal Bayar</th>
                                  <th>Jumlah Bayar</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr ng-repeat="detail in paymentDetails">
                                  <td>[[detail.tanggal_pembayaran]]</td>
                                  <td>[[detail.jumlah_pembayaran]]</td>
                                </tr>
                              </tbody>
                            </table>
                            <form>
                                <div class="form-group">
                                    <div>
                                    <label for="date">Tanggal Pembayaran</label>
                                      <input type="text" class="form-control" name="date_paid" ng-model="form.date" >
                                    </div>
                                    <div class="form-group">
                                      <label for="paid">Jumlah Bayar</label>
                                      <input type="text" do-decimal class="form-control" name="paid"  ng-model="form.paid">
                                    </div>
                                   
                                    <button type="submit" class="btn btn-primary">Lakukan pembayaran</button>
                            </form>
                          </td>

                        </tr>
                    </tbody>
                </table>

          </div>
              
    
    
         </div>
    </div>
</div>
@endsection
