@extends('app')

@section('content')
<div class="container" ng-controller="UserController">
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
                               <!-- <select class="form-control" style="display:inline-block;width:200px;" ng-model="type" ng-init="type='nama_barang'" ng-change="filterProduct()">
                                    <option value="code">Kode Barang</option>
                                    <option value="nama_barang">Nama Barang</option>
                                </select>-->
                                <input type="text" class="form-control large-input" style="display:inline-block;" ng-model="search" ng-init="search=''" ng-change="filterUser()" />
                            </span>
                        </div>

                    </div>
                </div>
                <div class="alert alert-info" style="margin-top:20px;" ng-show="filteredUsers.length==0">There is no data</div>
                <table class="table" ng-hide="filteredUsers.length==0">
                   <thead>
                       <tr>
                        <th>Username</th>
                        <th>Firstname</th>
                        <th>Lastname</th>
                        <th>Role</th>
                        <th>Action</th>
                       </tr>
                    </thead>
                    <tbody>
                        <tr ng-controller="UserDetailController" ng-repeat="user in filteredUsers track by $index">
                          <td>[[user.username]]</td>  
                          <td><input type="text" class="form-none large" ng-model="user.firstname"  /></td>  
                          <td><input type="text" class="form-none large" ng-model="user.lastname" /></td>  
                          <td>
                          <select ng-model="user.role" class="form-control" ng-disabled="user.id=='{{$userid}}'">
                              <option value="admin">Admin</option>
                              <option value="sales">Sales</option>
                          </select>
                          </td>  
                          <td>
                              <button class="btn btn-primary" ng-click="updateUser()">Update</button>
                              <button class="btn btn-danger" ng-click="deleteUser()" ng-show="user.id!='{{$userid}}'">Delete</button>
                          </td>
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
        <div class="alert alert-danger">
            <ul>
                <li ng-repeat="err in error">[[err]]</li>
            </ul>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Error Dialog -->

</div>




@endsection
