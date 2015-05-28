@extends('app')

@section('content')
<div class="container" ng-controller="PaymentSupplyController">
	<div class="row">
        <div class="col-md-10">
            
          <div id="payment-form">

               <div class="row" id="payment-header-form">
                    <div class="col-md-8" style="margin-bottom:20px;padding-bottom:10px">
                        <div>
                            <span class="label-form">Filter From</span>
                            <span class="label-form-delimiter">:</span>
                            <span>
                               <input class="form-none" type="text" id="datepicker" ng-model="fromDate"/>
                                <script>
                                (function(){
                                    var d = new Date();
                                    $('#datepicker').datepicker({
                                            changeMonth: true,
                                            changeYear: true,
                                            defaultDate: d,
                                            yearRange: '2000:2030',
                                            dateFormat: 'yy-mm-dd',
                                            stepMonths:true
                                    });

                                })();
                                </script>
                            </span>
                            <span>To : </span>
                             <span>
                               <input class="form-none" type="text" id="datepicker" ng-model="toDate"/>
                                <script>
                                (function(){
                                    var d = new Date();
                                    $('#datepicker').datepicker({
                                            changeMonth: true,
                                            changeYear: true,
                                            defaultDate: d,
                                            yearRange: '2000:2030',
                                            dateFormat: 'yy-mm-dd',
                                            stepMonths:true
                                    });

                                })();
                                </script>
                            </span>
                            <span>
                              <button class="btn btn-primary" ng-click="loadPaymentsHeader()">Filter</button>
                            </span>
                            <span>
                              <button class="btn btn-default" ng-click="print()">Print</button>
                            </span>
                        </div>

                    </div>

                    <div class="col-md-8 ">
                        <div>
                            <span class="label-form">Search</span>
                            <span class="label-form-delimiter">:</span>
                            <span>
                               <select class="form-control" style="display:inline-block;width:200px;" ng-model="type" ng-init="type='kode_invoice'" ng-change="filterPayments()">
                                    <option value="kode_invoice">Kode Invoice</option>
                                    <option value="supplier">Supplier</option>
                                </select>
                              <input type="text" class="form-control large-input" style="display:inline-block;" ng-model="search" ng-init="search=''" ng-change="filterPayments()" />
                            </span>
                        </div>

                    </div>
                </div>
                <div id="payment_supply">
                <table  class="table table-condensed" >
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
                    <tbody ng-controller="PaymentSupplyDetailController" ng-repeat="payment in filteredPayments" ng-init="isShowDetail=false">
                        <tr>
                          <td>
                            <span class="glyphicon glyphicon-chevron-up" ng-show="isShowDetail" ng-click="hideDetail()"   style="cursor:pointer;"  aria-hidden="true" ></span>
                            <span class="glyphicon glyphicon-chevron-down" ng-hide="isShowDetail" ng-click="showDetail()"  style="cursor:pointer;"  aria-hidden="true" ></span>
                          </td>
                          <td>[[payment.kode_invoice]]</td>
                          <td>[[payment.supplier]]</td>
                          <td>[[payment.currency]]&nbsp; [[payment.jumlah_utang | number:2]]</td>
                          <td>[[payment.currency]]&nbsp; [[payment.paid | number:2]]</td>
                          <td>
                            <span ng-hide="isBase()">[[payment.currency]]&nbsp; [[payment.jumlah_utang-payment.paid | number:2]]</span>
                            <code ng-show="isBase()">LUNAS</code>
                          </td>
                          <td>[[payment.tanggal_pembelian]]</td>
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
                                </tr>
                              </thead>
                              <tbody>
                                <tr ng-repeat="detail in paymentDetails">
                                  <td>[[detail.tanggal_pembayaran]]</td>
                                  <td>[[payment.currency]]&nbsp; [[detail.jumlah_pembayaran|currency:'']]</td>
                                </tr>
                              </tbody>
                            </table>
                            <div class="alert alert-info"  ng-show="isBase()" role="alert">Sudah Lunas</div>
                            <form ng-hide="isBase()" ng-submit="doPayment()">
                                <div class="form-group">
                                    <div>
                                    <label for="date">Tanggal Pembayaran</label>
                                      <input type="text" class="form-control datepicker"   name="date_paid" ng-model="form.date" />
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
</div>

@endsection
