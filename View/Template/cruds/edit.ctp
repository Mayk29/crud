<div class="panel panel-primary">
  <div class="panel-heading"><i class="fa fa-dot-circle-o"></i> EDIT CRUD</div>
  <div class="panel-body">

    <form id="form-edit">
      <div class="row">

        <div class="col-md-6">
          <div class="form-group">
            <label>Name <i class="required" style="color:red">*</i></label>
            <input type="text" class="form-control" ng-model="data.Crud.name"
                   data-validation-engine="validate[required]" placeholder="Name">
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control" ng-model="data.Crud.email"
                   data-validation-engine="validate[custom[email]]" placeholder="Email Address">
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label>Age <i class="required" style="color:red">*</i></label>
            <input type="number" class="form-control" ng-model="data.Crud.age"
                   data-validation-engine="validate[required,custom[integer]]" placeholder="Age">
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label>Birth Date <i class="required" style="color:red">*</i></label>
            <input type="date" class="form-control" ng-model="data.Crud.birthDate" ng-change="computeAge()"
                   data-validation-engine="validate[required,custom[date]]" placeholder="Birth Date">
          </div>
        </div>

      </div>

      <div class="clearfix"></div><hr>

      <h4>Beneficiaries</h4>

      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Name</th>
            <th>Birth Date</th>
            <th>Age</th>
            <th width="120">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr ng-repeat="beneficiary in beneficiaries">
            <td>
              <input type="text" class="form-control" ng-model="beneficiary.name" placeholder="Beneficiary Name">
            </td>
            <td>
              <input type="date" class="form-control" ng-model="beneficiary.birthDate" ng-change="computeBeneficiaryAge(beneficiary)">
            </td>
            <td>
              <input type="number" class="form-control" ng-model="beneficiary.age" readonly>
            </td>
            <td>
              <button type="button" class="btn btn-danger btn-sm" ng-click="removeBeneficiary($index)">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>

      <button type="button" class="btn btn-primary btn-sm" ng-click="addBeneficiary()">Add Beneficiary</button>

      <br><br>

      <div class="row">
        <div class="col-md-2 pull-right">
          <button class="btn btn-primary btn-sm btn-block" ng-click="update()">UPDATE</button>
        </div>
        <div class="col-md-2 pull-right">
          <a href="#/cruds" class="btn btn-default btn-sm btn-block">CANCEL</a>
        </div>
      </div>
    </form>

  </div>
</div>

<script>
  $('#form-edit').validationEngine('attach');
</script>
