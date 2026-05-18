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

    <!-- ── ATTACHMENTS ────────────────────────────────────────────── -->
    <h4>Attachments</h4>

    <table class="table table-bordered" ng-if="data.CrudFile && data.CrudFile.length > 0">
      <thead>
        <tr>
          <th style="width:30px;">#</th>
          <th>File Name</th>
          <th>Size</th>
          <th>Uploaded</th>
          <th style="width:100px;">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr ng-repeat="file in data.CrudFile">
          <td>{{ $index + 1 }}</td>
          <td><i class="fa fa-file-o"></i> {{ file.original }}</td>
          <td>{{ formatSize(file.size) }}</td>
          <td>{{ file.created }}</td>
          <td>
            <a href="{{ file.url }}" target="_blank" download="{{ file.original }}"
               class="btn btn-success btn-xs">
              <i class="fa fa-download"></i> Download
            </a>
          </td>
        </tr>
      </tbody>
    </table>

    <p class="text-muted" ng-if="!data.CrudFile || data.CrudFile.length == 0">
      <small>No attachments found.</small>
    </p>
    <!-- ── END ATTACHMENTS ──────────────────────────────────────── -->

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

      <!-- Print — enabled only when APPROVED -->
      <div class="col-md-2">
        <button class="btn btn-warning btn-sm btn-block"
                ng-click="print()"
                ng-disabled="data.status != 'APPROVED'"
                title="{{ data.status != 'APPROVED' ? 'Only APPROVED records can be printed' : 'Print this record' }}">
          <i class="fa fa-print"></i> PRINT
        </button>
      </div>

    </div>

  </div>
</div>
