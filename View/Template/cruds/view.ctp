<div class="panel panel-primary">
  <div class="panel-heading"><i class="fa fa-dot-circle-o"></i> VIEW CRUD</div>
  <div class="panel-body">

    <table class="table table-bordered">
      <tr>
        <th style="width:180px">ID</th>
        <td>{{ data.id }}</td>
      </tr>
      <tr>
        <th>Name</th>
        <td class="uppercase">{{ data.name }}</td>
      </tr>
      <tr>
        <th>Email</th>
        <td>{{ data.email || '—' }}</td>
      </tr>
      <tr>
        <th>Age</th>
        <td>{{ data.age }}</td>
      </tr>
      <tr>
        <th>Birth Date</th>
        <td>{{ data.birthDate }}</td>
      </tr>
      <tr>
        <th>Status</th>
        <td>
          <span class="label label-{{ data.status == 'APPROVED' ? 'success' : (data.status == 'DISAPPROVED' ? 'danger' : 'warning') }}"
                style="font-size:13px; padding:5px 10px;">
            {{ data.status || 'PENDING' }}
          </span>
        </td>
      </tr>
    </table>

    <hr>

    <h4>Beneficiaries</h4>

    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Name</th>
          <th>Birth Date</th>
          <th>Age</th>
        </tr>
      </thead>
      <tbody>
        <tr ng-repeat="beneficiary in data.Beneficiary">
          <td>{{ beneficiary.name }}</td>
          <td>{{ beneficiary.birthDate }}</td>
          <td>{{ beneficiary.age }}</td>
        </tr>
        <tr ng-if="!data.Beneficiary || data.Beneficiary.length == 0">
          <td colspan="3" class="text-center">No beneficiaries found.</td>
        </tr>
      </tbody>
    </table>

    <hr>

    <div class="row">
      <!-- Back -->
      <div class="col-md-2">
        <a href="#/cruds" class="btn btn-default btn-sm btn-block">
          <i class="fa fa-arrow-left"></i> BACK
        </a>
      </div>

      <!-- Edit — disabled when APPROVED or DISAPPROVED -->
      <div class="col-md-2">
        <a href="{{ (data.status == 'APPROVED' || data.status == 'DISAPPROVED') ? 'javascript:void(0)' : '#/cruds/edit/' + data.id }}"
           class="btn btn-primary btn-sm btn-block {{ (data.status == 'APPROVED' || data.status == 'DISAPPROVED') ? 'disabled' : '' }}">
          <i class="fa fa-edit"></i> EDIT
        </a>
      </div>

      <!-- Approve — shown only when PENDING -->
      <div class="col-md-2" ng-show="data.status == 'PENDING' || !data.status">
        <button class="btn btn-success btn-sm btn-block" ng-click="approve()">
          <i class="fa fa-check"></i> APPROVE
        </button>
      </div>

      <!-- Disapprove — shown only when PENDING -->
      <div class="col-md-2" ng-show="data.status == 'PENDING' || !data.status">
        <button class="btn btn-danger btn-sm btn-block" ng-click="disapprove()">
          <i class="fa fa-times"></i> DISAPPROVE
        </button>
      </div>
    </div>

  </div>
</div>
