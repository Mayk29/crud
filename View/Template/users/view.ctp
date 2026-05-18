<div class="panel panel-primary">
  <div class="panel-heading"><i class="fa fa-dot-circle-o"></i> VIEW</div>
  <div class="panel-body">
    <div class="row">
      <div class="col-md-6">
        <dl class="dl-horizontal dl-data dl-bordered">
          <dt>Name:</dt>
          <dd class="uppercase">{{ data.User.name }}</dd>

          <dt>Username:</dt>
          <dd>{{ data.User.username }}</dd>
          
        </dl>
      </div> 
      
      <div class="col-md-6">
        <dl class="dl-horizontal dl-data dl-bordered">
          <dt>Status:</dt>
          <dd class="uppercase"><span class="label label-{{ data.User.active? 'success':'danger'}}">{{ data.User.active? 'ACTIVE':'NOT ACTIVE' }}</span></dd>
          
          <dt>Verified:</dt>
          <dd class="uppercase"><span class="label label-{{ data.User.verified? 'primary':'danger'}}">{{ data.User.verified? 'YES':'NO' }}</span></dd>
        </dl>
      </div> 

      <div class="clearfix"></div>

      <div class="col-md-12">
        <table class="table table-bordered table-striped table-hover">
          <thead>
            <tr class="bg-info">
              <th colspan="5">USER OTHER DATAS</th>
            </tr>
            <tr >
              <th class="w30px text-center">#</th>
              <th class="text-center">PERMISSION</th>
              <th class="text-center">DATE</th>
              <th class="text-center">REMARKS</th>
              <th class="text-center">AMOUNT</th>
            </tr>
          </thead>
          <tbody>
            <tr ng-repeat="datax in data.UserPermission">
              <td class="text-center">{{ $index + 1 }}</td>
              <td class="text-left">{{ datax.permission }}</td>
              <td class="text-center">{{ datax.date | date: 'MM/dd/yyyy'}}</td>
              <td class="uppercase text-left">{{ datax.remarks }}</td>
              <td class="uppercase text-right">{{ datax.amount | number : 2 }}</td>
            </tr>
          </tbody>
          <tfoot ng-if="data.UserPermission != ''">
            <tr>
              <th class="text-left" colspan="4">TOTAL</th>
              <th class="text-right">{{ data.User.total | number : 2 }}</th>
            </tr>
          </tfoot>
          <tbody ng-if="data.UserPermission == ''">
            <td colspan="5" class="text-center">No data available</td>
          </tbody>          
        </table>
      </div>


    </div>

    <div class="clearfix"></div>
    <hr>

    <div class="row">
      <div class="col-md-12">
        <div class="btn-group btn-group-sm pull-right btn-min">

          <a href="#/user/edit/{{ data.User.id }}" class="btn btn-primary btn-min"><i class="fa fa-edit"></i> EDIT</a> 
          <button class="btn btn-danger btn-min" ng-click="remove(data.User)"><i class="fa fa-trash"></i> DELETE</button>

        </div> 
      </div>
    </div>
  </div>
</div>


<style>
  .table-wrapper{
    width:100%;
    height:500px;
    overflow-y:auto;
  }
</style>