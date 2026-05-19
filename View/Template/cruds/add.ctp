<div class="panel panel-primary">
  <div class="panel-heading" style="color:black"><i class="fa fa-dot-circle-o"></i> ADD CRUD</div>
  <div class="panel-body">

    <form id="form">

      <!-- Row 1: Name | Email -->
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
      </div>

      <!-- Row 2: Birth Date | Age -->
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Birth Date <i class="required" style="color:red">*</i></label>
            <input type="date" class="form-control" ng-model="data.Crud.birthDate" ng-change="computeAge()"
                   data-validation-engine="validate[required,custom[date]]">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Age <i class="required" style="color:red">*</i></label>
            <input type="number" class="form-control" ng-model="data.Crud.age"
                   data-validation-engine="validate[required,custom[integer]]" placeholder="Age" readonly>
          </div>
        </div>
      </div>

      <hr>

      <h4>Beneficiaries</h4>

      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Name</th>
            <th>Birth Date</th>
            <th>Age</th>
            <th width="100"></th>
          </tr>
        </thead>
        <tbody>
          <tr ng-repeat="beneficiary in beneficiaries track by $index">
            <td>
              <input type="text" class="form-control" ng-model="beneficiary.name">
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

      <div class="clearfix"></div><hr>

      <!-- ── FILE ATTACHMENTS ────────────────────────────────────────── -->
      <h4>Attachments</h4>

      <!-- Pending files queue -->
      <table class="table table-bordered" ng-if="pendingFiles.length > 0">
        <thead>
          <tr>
            <th>#</th>
            <th>File Name</th>
            <th>Size</th>
            <th style="width:80px;"></th>
          </tr>
        </thead>
        <tbody>
          <tr ng-repeat="file in pendingFiles">
            <td>{{ $index + 1 }}</td>
            <td><i class="fa fa-file-o"></i> {{ file.name }}</td>
            <td>{{ formatSize(file.size) }}</td>
            <td>
              <button type="button" class="btn btn-danger btn-xs" ng-click="removePendingFile($index)">
                <i class="fa fa-times"></i> Remove
              </button>
            </td>
          </tr>
        </tbody>
      </table>

      <p class="text-muted" ng-if="pendingFiles.length == 0">
        <small>No files attached yet.</small>
      </p>

      <!-- File picker (hidden, triggered by button) -->
      <input type="file" id="fileInput" multiple style="display:none;"
             onchange="angular.element(this).scope().onFileSelect(this)">
      <button type="button" class="btn btn-default btn-sm"
              onclick="document.getElementById('fileInput').click()">
        <i class="fa fa-paperclip"></i> Attach File(s)
      </button>
      <small class="text-muted" style="margin-left:8px;">
        Allowed: images, PDF, Word, Excel, TXT &mdash; max 10 MB each
      </small>
      <!-- ── END FILE ATTACHMENTS ──────────────────────────────────── -->

      <div class="clearfix"></div><hr>

      <div class="row">
        <div class="col-md-2 pull-right">
          <button class="btn btn-primary btn-sm btn-block" ng-click="save()">SAVE</button>
        </div>
        <div class="col-md-2 pull-right">
          <a href="#/cruds" class="btn btn-default btn-sm btn-block">CANCEL</a>
        </div>
      </div>
    </form>

  </div>
</div>

<script>
  $('#form').validationEngine('attach');
</script>
