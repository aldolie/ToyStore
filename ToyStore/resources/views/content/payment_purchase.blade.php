@extends('app')

@section('content')
<div class="container" ng-controller="PaymentPurchaseController">
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
                <table class="table table-condensed" >
                    <thead >
                       <tr>
                        <th>#</th>
                        <th>Tanggal Invoice</th>
                        <th>Kode Invoice</th>
                        <th>Jumlah</th>
                        <th>Ongkos Kirim</th>
                        <th>Sisa Hutang</th>
                        <th>Customer</th>
                       </tr>
                    </thead>
                    <tbody ng-controller="PaymentPurchaseDetailController" ng-repeat="payment in filteredPayments" ng-init="isShowDetail=false">
                        <tr>
                          <td>
                            <span class="glyphicon glyphicon-chevron-up" ng-show="isShowDetail" ng-click="hideDetail()"   style="cursor:pointer;"  aria-hidden="true" ></span>
                            <span class="glyphicon glyphicon-chevron-down" ng-hide="isShowDetail" ng-click="showDetail()"  style="cursor:pointer;"  aria-hidden="true" ></span>
                          </td>
                          <td>[[payment.tanggal_penjualan]]</td>
                          <td>[[payment.kode_invoice]]</td>
                          <td>[[payment.jumlah_utang | currency:'Rp.']]</td>
                          <td>[[payment.ongkos_kirim | currency:'Rp.']]</td>
                          <td><code ng-show="isBaseVerified()">LUNAS</code><span ng-hide="isBaseVerified()">[[payment.jumlah_utang+payment.ongkos_kirim-payment.paid_verify | currency:'Rp.']]</span></td>
                          <td>[[payment.customer]]</td>
                        </tr>
                        <tr ng-show="isShowDetail">
                          <td></td>
                          <td></td>
                          <td></td>
                          <td colspan="4">
                            <div class="alert alert-info"  ng-hide="isAvalable()" role="alert">Belum Ada Pembayaran</div>
                            <table class="table" ng-show="isAvalable()">
                              <thead>
                                <tr>
                                  <th>Tanggal Bayar</th>
                                  <th>Jumlah Bayar</th>
                                  <th>Tipe Pembayaran</th>
                                  @if($role=='admin')
                                    <th>Verifikasi</th>
                                  @else
                                    <th>Status</th>
                                  @endif
                                  <th>Delete</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr ng-repeat="detail in paymentDetails track by $index" ng-controller="PaymentController">
                                  <td>[[detail.tanggal_pembayaran]]</td>
                                  <td>[[detail.jumlah_pembayaran | currency:'Rp.']]</td>
                                  <td>[[detail.tipe_pembayaran]]</td>
                                  @if($role=='admin')
                                    <td><button class="btn btn-warning" ng-show="detail.tipe_pembayaran!='Down Payment'&&detail.status==0" ng-click="verifyPayment()">Verifikasi</button></td>
                                  @else
                                    <td>
                                      <span ng-show="detail.status==0">Not Verified</span>
                                      <span ng-show="detail.status==1">Verified</span>
                                    </td>
                                  @endif
                                  @if($role=='admin')
                                  <td><button class="btn btn-danger" ng-show="detail.tipe_pembayaran!='Down Payment'" ng-click="deletePayment()">Delete</button></td>
                                  @else
                                  <td><button class="btn btn-danger" ng-show="detail.tipe_pembayaran!='Down Payment'&&detail.status==0" ng-click="deletePayment()">Delete</button></td>
                                  @endif
                                </tr>
                              </tbody>
                            </table>
                            <div class="alert alert-info"  ng-show="isBaseVerified()" role="alert">Sudah Lunas</div>
                            <form ng-hide="isBase()" ng-submit="doPayment()">
                                <div class="form-group">
                                    <div>
                                    <label for="date">Tanggal Pembayaran</label>
                                      <input type="text" class="form-control datepicker"   name="date_paid" ng-model="form.date" />
                                    </div>

                                     <div class="form-group">
                                      <label for="type">Tipe Pembayaran</label>
                                      <input type="text" class="form-control" ng-model="form.type" name="type" />
                                    </div>
                                   
                                    <div class="form-group">
                                      <label for="paid">Jumlah Bayar</label>
                                      <input type="text" do-decimal class="form-control" name="paid"  ng-model="form.paid" />
                                    </div>

                                   
                                    <button type="submit" ng-disabled="isNotValidPayment()"  class="btn btn-primary">Lakukan pembayaran</button>
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
