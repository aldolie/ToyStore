@extends('app')

@section('content')
<div class="container" ng-controller="ProductRecapitulationController">
	<div class="row">
		<div class="col-md-10">
            <!--<div style="margin-top:30px;">
                <form ng-submit="updateROP()">
                    <span class="label-form">Update Re-Order Point</span>
                    <span class="label-form-delimiter">:</span>
                    <span>
                            <input type="text" do-numeric class="form-control large-input" style="display:inline-block;" ng-model="rop" />
                            <input type="submit" value="Update" class="btn btn-primary"/>
                    </span>
                </form>
            </div>-->
            <div id="product-report">
                <div class="row" id="product-header-report">
                    <div class="col-md-10 ">
                        <div>
                            
                            <span class="label-form">Search</span>
                            <span class="label-form-delimiter">:</span>
                            <span>
                                <select class="form-control" style="display:inline-block;width:200px;" ng-model="type" ng-init="type='nama_barang'" ng-change="filterProduct()">
                                    <option value="code">Kode Barang</option>
                                    <option value="nama_barang">Nama Barang</option>
                                </select>
                                <input type="text" class="form-control large-input" style="display:inline-block;" ng-model="search" ng-init="search=''" ng-change="filterProduct()" />
                            </span>
                        </div>

                    </div>
                </div>
                <div class="alert alert-info" style="margin-top:20px;" ng-show="filteredProducts.length==0">There is no data</div>
                <table class="table" ng-hide="filteredProducts.length==0">
                   <thead>
                       <tr>
                        <th >Kode Barang</th>
                        <th >Re Order Point</th>
                        <th>Nama Barang</th>
                        <th>Stock</th>
                       </tr>
                    </thead>
                    <tbody>
                        <tr ng-controller="ProductRecapitulationDetailController" ng-repeat="product in filteredProducts track by $index">
                            <td  width="200">
                                <input class="form-none small" type="text" ng-model="product.code" />
                                <span class="glyphicon glyphicon-pencil" style="cursor:pointer;" ng-click="updateProductCode()"></span>
                            </td>
                            <td width="200"> 
                                <input class="form-none small" type="text" ng-model="product.rop" />
                                <span class="glyphicon glyphicon-pencil" style="cursor:pointer;" ng-click="updateProductROP()"></span>
                            </td>
                            <td>[[product.nama_barang]]</td>
                            <td>[[product.quantity]] <code ng-show="isReOrderPoint()">Order</code></td>
                          
                        </tr>
                    </tbody>
                </table>
    
    
            </div>
	</div>



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

</div>




@endsection
