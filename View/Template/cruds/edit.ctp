<div class="panel panel-primary">
  <div class="panel-heading" style="color:black"><i class="fa fa-dot-circle-o"></i> EDIT CRUD</div>
  <div class="panel-body">

    <form id="form-edit">

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
          <tr ng-repeat="beneficiary in beneficiaries track by $index" ng-class="{'danger': beneficiary._toDelete}">
            <td>
              <input type="text" class="form-control" ng-model="beneficiary.name" placeholder="Beneficiary Name" ng-disabled="beneficiary._toDelete">
            </td>
            <td>
              <input type="date" class="form-control" ng-model="beneficiary.birthDate" ng-change="computeBeneficiaryAge(beneficiary)" ng-disabled="beneficiary._toDelete">
            </td>
            <td>
              <input type="number" class="form-control" ng-model="beneficiary.age" readonly>
            </td>
            <td>
              <button type="button" class="btn btn-danger btn-sm" ng-click="removeBeneficiary($index)" ng-if="!beneficiary._toDelete">Delete</button>
              <button type="button" class="btn btn-default btn-sm" ng-click="beneficiary._toDelete = false" ng-if="beneficiary._toDelete"><i class="fa fa-undo"></i> Undo</button>
            </td>
          </tr>
        </tbody>
      </table>

      <button type="button" class="btn btn-primary btn-sm" ng-click="addBeneficiary()">Add Beneficiary</button>

      <div class="clearfix"></div><hr>

      <!-- ── FILE ATTACHMENTS ────────────────────────────────────────── -->
      <h4>Attachments</h4>

      <!-- Already-saved files -->
      <table class="table table-bordered" ng-if="existingFiles.length > 0">
        <thead>
          <tr>
            <th style="width:30px;">#</th>
            <th>File Name</th>
            <th>Size</th>
            <th>Uploaded</th>
            <th style="width:160px;">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr ng-repeat="file in existingFiles" ng-class="{'danger': file._toDelete}">
            <td>{{ $index + 1 }}</td>
            <td><i class="fa fa-file-o"></i> <span ng-style="file._toDelete && {'text-decoration':'line-through'}">{{ file.original }}</span></td>
            <td>{{ formatSize(file.size) }}</td>
            <td>{{ file.created }}</td>
            <td>
              <div class="btn-group btn-group-xs" style="display:inline-flex;flex-wrap:nowrap;gap:3px;">
                <a href="{{ file.url }}" target="_blank" download="{{ file.original }}"
                   class="btn btn-info btn-xs" title="Download" ng-if="!file._toDelete">
                  <i class="fa fa-download"></i> Download
                </a>
                <button type="button" class="btn btn-danger btn-xs" ng-click="deleteFile(file)" title="Delete" ng-if="!file._toDelete">
                  <i class="fa fa-trash"></i> Delete
                </button>
                <button type="button" class="btn btn-default btn-xs" ng-click="file._toDelete = false" title="Undo" ng-if="file._toDelete">
                  <i class="fa fa-undo"></i> Undo
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>

      <p class="text-muted" ng-if="existingFiles.length == 0 && pendingFiles.length == 0">
        <small>No attachments yet.</small>
      </p>

      <!-- Pending (new) files queue -->
      <div ng-if="pendingFiles.length > 0">
        <p><strong>Files to be uploaded on save:</strong></p>
        <table class="table table-bordered table-condensed">
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
              <td><i class="fa fa-file-o text-warning"></i> {{ file.name }}</td>
              <td>{{ formatSize(file.size) }}</td>
              <td>
                <button type="button" class="btn btn-danger btn-xs" ng-click="removePendingFile($index)">
                  <i class="fa fa-times"></i> Remove
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- File picker -->
      <input type="file" id="fileInputEdit" multiple style="display:none;"
             onchange="angular.element(this).scope().onFileSelect(this)">
      <button type="button" class="btn btn-default btn-sm"
              onclick="document.getElementById('fileInputEdit').click()">
        <i class="fa fa-paperclip"></i> Attach File(s)
      </button>
      <small class="text-muted" style="margin-left:8px;">
        Allowed: images, PDF, Word, Excel, TXT &mdash; max 10 MB each
      </small>
      <!-- ── END FILE ATTACHMENTS ──────────────────────────────────── -->

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
