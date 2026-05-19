<div class="panel panel-primary">
  <div class="panel-heading"><i class="fa fa-dot-circle-o"></i> CRUDS MANAGEMENT</div>
  <div class="panel-body">

    <!-- TOP BUTTONS + SEARCH -->
    <div class="row">
      <div class="col-md-2">
        <a href="#/cruds/add" class="btn btn-primary btn-sm btn-block"><i class="fa fa-plus"></i> ADD CRUD</a>
      </div>
      <div class="col-md-2">
        <button class="btn btn-warning btn-sm btn-block" ng-click="toggleAdvanceSearch()">
          <i class="fa fa-search"></i> ADVANCE SEARCH
        </button>
      </div>
      <div class="col-md-2">
        <button class="btn btn-success btn-sm btn-block" ng-click="print()">
          <i class="fa fa-print"></i> PRINT
        </button>
      </div>
      <div class="col-md-4 pull-right">
        <input type="text" class="form-control search" placeholder="SEARCH HERE"
               ng-model="strSearch" ng-enter="search(strSearch)">
        <sup style="font-size:10px;color:gray">Press Enter to search</sup>
      </div>
    </div>

    <!-- ADVANCE SEARCH PANEL -->
    <div class="row" ng-show="showAdvanceSearch" style="margin-top:15px;">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading"><i class="fa fa-filter"></i> Advance Search</div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Name</label>
                  <input type="text" class="form-control input-sm" placeholder="Search by name"
                         ng-model="advanceSearch.name">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Age</label>
                  <input type="number" class="form-control input-sm" placeholder="Search by age"
                         ng-model="advanceSearch.age">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Status</label>
                  <select class="form-control input-sm" ng-model="advanceSearch.status">
                    <option value="">-- All Status --</option>
                    <option value="PENDING">PENDING</option>
                    <option value="APPROVED">APPROVED</option>
                    <option value="DISAPPROVED">DISAPPROVED</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 text-right">
                <button class="btn btn-default btn-sm" ng-click="resetAdvanceSearch()">
                  <i class="fa fa-times"></i> RESET
                </button>
                &nbsp;
                <button class="btn btn-primary btn-sm" ng-click="doAdvanceSearch()">
                  <i class="fa fa-search"></i> SEARCH
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="clearfix"></div><br>

    <!-- STATUS TABS -->
    <ul class="nav nav-tabs" style="margin-bottom:15px;">
      <li ng-class="{ active: activeTab == 'ALL' }">
        <a href="javascript:void(0)" ng-click="setTab('ALL')">All</a>
      </li>
      <li ng-class="{ active: activeTab == 'PENDING' }">
        <a href="javascript:void(0)" ng-click="setTab('PENDING')">
          <span class="label label-warning">PENDING</span>
        </a>
      </li>
      <li ng-class="{ active: activeTab == 'APPROVED' }">
        <a href="javascript:void(0)" ng-click="setTab('APPROVED')">
          <span class="label label-success">APPROVED</span>
        </a>
      </li>
      <li ng-class="{ active: activeTab == 'DISAPPROVED' }">
        <a href="javascript:void(0)" ng-click="setTab('DISAPPROVED')">
          <span class="label label-danger">DISAPPROVED</span>
        </a>
      </li>
    </ul>

    <!-- TABLE -->
    <div class="col-md-12">
      <table class="table table-bordered center">
        <thead>
          <tr>
            <th class="w10px">&nbsp;&nbsp;&nbsp;</th>
            <th>NAME</th>
            <th>EMAIL</th>
            <th>AGE</th>
            <th>BIRTH DATE</th>
            <th>STATUS</th>
            <th class="w100px">ACTION</th>
          </tr>
        </thead>
        <tbody>
          <tr ng-repeat="data in cruds">
            <td class="text-center">{{ (paginator.page - 1) * paginator.limit + $index + 1 }}</td>
            <td class="uppercase">{{ data.name }}</td>
            <td>{{ data.email || '—' }}</td>
            <td>{{ data.age }}</td>
            <td>{{ data.birthDate | date:'MM/dd/yyyy' }}</td>
            <td class="text-center">
              <span class="label label-{{ data.status == 'APPROVED' ? 'success' : (data.status == 'DISAPPROVED' ? 'danger' : 'warning') }}">
                {{ data.status || 'PENDING' }}
              </span>
            </td>
            <td>
              <div class="btn-group btn-group-xs" style="display:inline-flex;flex-wrap:nowrap;gap:3px;">
                <!-- VIEW — blue/info: neutral read action -->
                <a href="#/cruds/view/{{ data.id }}" class="btn btn-info" title="VIEW">
                  <i class="fa fa-eye"></i>
                </a>
                <!-- EDIT — amber/warning: modify action, disabled when locked -->
                <a href="{{ (data.status == 'APPROVED' || data.status == 'DISAPPROVED') ? 'javascript:void(0)' : '#/cruds/edit/' + data.id }}"
                   class="btn btn-warning {{ (data.status == 'APPROVED' || data.status == 'DISAPPROVED') ? 'disabled' : '' }}"
                   title="EDIT">
                  <i class="fa fa-edit"></i>
                </a>
                <!-- DELETE — red/danger: destructive action, disabled when locked -->
                <a href="javascript:void(0)"
                   ng-click="(data.status == 'APPROVED' || data.status == 'DISAPPROVED') ? null : remove(data)"
                   class="btn btn-danger {{ (data.status == 'APPROVED' || data.status == 'DISAPPROVED') ? 'disabled' : '' }}"
                   title="DELETE">
                  <i class="fa fa-trash"></i>
                </a>
              </div>
            </td>
          </tr>
          <tr ng-if="cruds.length == 0">
            <td colspan="7" class="text-center">No records found.</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- PAGINATOR -->
    <ul class="pagination pull-right">
      <li>
        <a href="javascript:void(0)" ng-click="load(1)"><sub>&laquo;&laquo;</sub></a>
      </li>
      <li class="prevPage {{ !paginator.prevPage ? 'disabled' : '' }}">
        <a href="javascript:void(0)" ng-click="load(paginator.page - 1)">&laquo;</a>
      </li>
      <li ng-repeat="page in pages"
          class="pagination-page {{ paginator.page == page.number ? 'active' : '' }}">
        <a href="javascript:void(0)" ng-click="load(page.number)">{{ page.number }}</a>
      </li>
      <li class="nextPage {{ !paginator.nextPage ? 'disabled' : '' }}">
        <a href="javascript:void(0)" ng-click="load(paginator.page + 1)">&raquo;</a>
      </li>
      <li>
        <a href="javascript:void(0)" ng-click="load(paginator.pageCount)"><sub>&raquo;&raquo;</sub></a>
      </li>
    </ul>

    <div class="clearfix"></div>
    <div class="pull-right" ng-show="paginator.pageCount > 0">
      <sup class="text-primary">
        Page {{ paginator.pageCount > 0 ? paginator.page : 0 }} out of {{ paginator.pageCount }}
      </sup>
    </div>

  </div>
</div>
