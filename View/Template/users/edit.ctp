<div>
  <div class="panel panel-primary">
    <div class="panel-heading"><i class="fa fa-dot-circle-o"></i> EDIT USER </div>
    <div class="panel-body">
    	<div class="col-md-12">
    	  <form id="form">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Last Name <i class="required">*</i></label>
                <input type="text" class="form-control" ng-model="data.User.last_name" data-validation-engine="validate[required]">
              </div>
            </div>
    
             <div class="col-md-6">
              <div class="form-group">
                <label>First Name <i class="required">*</i></label>
                <input type="text" class="form-control" ng-model="data.User.first_name" data-validation-engine="validate[required]">
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label>Username <i class="required">*</i></label>
                <input type="text" class="form-control"  ng-model="data.User.username" data-validation-engine="validate[required]">
              </div>
            </div>
            
            <div class="col-md-4">
              <div class="form-group">
                <label>New Password</label>
                <input type="password" class="form-control"  ng-model="data.User.password">
              </div>
            </div>
            
            <div class="col-md-4">
              <div class="form-group">
                <label>Re-type New Password</label>
                <input type="password" class="form-control"  ng-model="confirmPassword">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Role <i class="required">*</i></label>
                <select class="form-control" ng-model="data.User.roleId" ng-options="opt.id as opt.value for opt in roles" data-validation-engine="validate[required]">
                <option value=""></option>
                </select>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label>Active <i class="required">*</i></label>
                <select class="form-control" ng-model="data.User.active" ng-options="opt.id as opt.value for opt in bool" data-validation-engine="validate[required]">
                  <option value=""></option>
                </select>
              </div>
            </div>
          
            <div class="col-md-4">
              <div class="form-group">
                <label>Verified <i class="required">*</i></label>
                <select class="form-control" ng-model="data.User.verified" ng-options="opt.id as opt.value for opt in bool" data-validation-engine="validate[required]">
                  <option value=""></option>
                </select>
              </div>
            </div>
      
            <div class="clearfix"></div><hr>

            <div class="col-md-3 pull-left">
              <a class="btn btn-warning btn-sm btn-block" id="save" ng-click="addPermission()">ADD PERMISSION</a><br/>
            </div>

            <div class="clearfix"></div>

            <div class="col-md-12">
              <table class="table table-bordered table-striped table-hover">
                <thead>
                  <tr >
                    <th class="w30px text-center">#</th>
                    <th class="text-center">PERMISSION</th>
                    <th class="text-center">DATE</th>
                    <th class="text-center">REMARKS</th>
                    <th class="text-center">AMOUNT</th>
                    <th class="w100px"></th>
                  </tr>
                </thead>
                <tbody>
                  <tr ng-repeat="datax in data.UserPermission" ng-if = "datax.visible != 0">
                    <td class="text-center">{{ datax.index }}</td>
                    <td class="text-left">{{ datax.permission }}</td>
                    <td class="text-center">{{ datax.date | date: 'MM/dd/yyyy'}}</td>
                    <td class="uppercase text-left">{{ datax.remarks }}</td>
                    <td class="uppercase text-right">{{ datax.amount | number : 2 }}</td>
                    <td class="text-center">
                      <div class="btn-group btn-group-xs">
                        <a href="javascript:void(0)" ng-click="editPermission($index,datax)" class="btn btn-success" title="EDIT"><i class="fa fa-edit"></i></a>
                        <a href="javascript:void(0)" ng-click="removePermission($index)" class="btn btn-danger" title="DELETE"><i class="fa fa-trash"></i></a>
                      </div>
                    </td>
                  </tr>
                </tbody>
                <tfoot ng-if="data.UserPermission.length > 0">
                  <tr>
                    <th class="text-left" colspan="4">TOTAL</th>
                    <th class="text-right">{{ data.User.total | number : 2 }}</th>
                    <th></th>
                  </tr>
                </tfoot>
                <tbody ng-if="data.UserPermission.length <= 0">
                  <td colspan="6" class="text-center">No data available</td>
                </tbody>          
              </table>
            </div>

          </div>  
        </form>
  			<hr>
  			<div class="row">
  				<div class="col-md-3 pull-right">
  					<button class="btn btn-primary btn-sm btn-block" ng-click="update()">UPDATE</button>
  				</div>
  			</div>
  	  </div>
    </div>
  </div>
</div>
<script>
$('#form').validationEngine('attach');
</script>

<div class="modal fade" id="add-permission-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">ADD PERMISSION </h4>
      </div>
      <div class="modal-body">
        <form id="add_permission">   

          <div class="col-md-12">
            <div class="form-group">
              <label>PERMISSION<i class="required">*</i></label>
              <select class="form-control" ng-options="opt.id as opt.value for opt in permissions" ng-model="adata.permission_id" ng-change = "getPermission(adata.permission_id)">
              </select>
            </div>
          </div> 

          <div class="col-md-12">
            <div class="form-group">
              <label> DATE <i class="required">*</i></label>
              <input type="text" class="form-control datepicker" ng-model="adata.date" data-validation-engine="validate[required]">
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label>REMARKS<i class="required">*</i></label>
              <textarea type="text" class="form-control" ng-model="adata.remarks" data-validation-engine="validate[required]"></textarea>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label>AMOUNT<i class="required">*</i></label>
              <input type="text" class="form-control" decimal = "true" ng-model="adata.amount" data-validation-engine="validate[required]">
            </div>
          </div>

        </form>
       </div>  
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm btn-min" data-dismiss="modal">CANCEL</button>
        <button type="button" class="btn btn-primary btn-sm btn-min" ng-click="savePermission(adata)">SAVE</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="edit-permission-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">EDIT PERMISSION </h4>
      </div>
      <div class="modal-body">
        <form id="edit_permission">   

          <div class="col-md-12">
            <div class="form-group">
              <label>PERMISSION<i class="required">*</i></label>
              <select class="form-control" ng-options="opt.id as opt.value for opt in permissions" ng-model="adata.permission_id" ng-change = "getPermission(adata.permission_id)">
              </select>
            </div>
          </div> 

          <div class="col-md-12">
            <div class="form-group">
              <label> DATE <i class="required">*</i></label>
              <input type="text" class="form-control datepicker" ng-model="adata.date" data-validation-engine="validate[required]">
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label>REMARKS<i class="required">*</i></label>
              <textarea type="text" class="form-control" ng-model="adata.remarks" data-validation-engine="validate[required]"></textarea>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label>AMOUNT<i class="required">*</i></label>
              <input type="text" class="form-control" decimal = "true" ng-model="adata.amount" data-validation-engine="validate[required]">
            </div>
          </div>

        </form>
       </div>  
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm btn-min" data-dismiss="modal">CANCEL</button>
        <button type="button" class="btn btn-primary btn-sm btn-min" ng-click="updatePermission(adata)">SAVE</button>
      </div>
    </div>
  </div>
</div>