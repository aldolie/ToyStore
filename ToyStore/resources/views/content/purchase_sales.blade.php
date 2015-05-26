@extends('app')

@section('content')
<div class="container" ng-controller="PurchaseSalesRecapitulationController">

        <div class="col-md-10">
             
            <div id="order-report">
                <div class="row" id="order-header-report">
                    <div class="col-md-8">
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
                              <button class="btn btn-primary" ng-click="generate()">Filter</button>
                            </span>
                            </div>

                    </div>
                </div>
                <div class="row">

                <div class="alert alert-info" style="margin-top:20px;" ng-show="filteredOrders.length==0">There is no data</div>
                <table class="table" ng-hide="filteredOrders.length==0">
                   <thead ng-init="isReverse=false">
                       <tr>
                        <th>Sales</th>
                        <th>Penjualan</th>
                       </tr>
                    </thead>
                    <tbody>
                        <tr  ng-repeat="order in orders track by $index">
                            <td>[[order.firstname+' '+order.lastname]]</td>
                            <td>[[order.penjualan | currency:'Rp.']]</td>
                        
                        </tr>
                    </tbody>
                </table>
    
    
            </div>
    </div>
</div>
@endsection
