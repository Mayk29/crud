<div class="panel panel-primary">
  <div class="panel-heading"><i class="fa fa-dot-circle-o"></i> USER MANAGEMENT </div>
  <div class="panel-body">
    <div class="row">
      <div class="col-md-3">
        <a href="#/user/add" class="btn btn-primary btn-sm btn-block"><i class="fa fa-plus"></i> ADD USER</a>
      </div>
        
      <div class="col-md-4 pull-right">
    	  <input type="text" class="form-control search" placeholder="SEARCH HERE" ng-model="strSearch" ng-enter="search(strSearch)">
        <sup style="font-size:10px;color:gray">Press Enter to search</sup>
    	</div>
			
      <div class="clearfix"></div><hr>

      <div class="col-md-12">
        <table class="table table-bordered center">
          <thead>
            <tr>
              <th class='w10px'>&nbsp&nbsp&nbsp</th>
              <th>NAME</th>
              <th>USERNAME</th>
              <th>STATUS</th>
              <th>ROLE</th>
              <th class="w100px"></th>
            </tr>
          </thead>
          <tbody>
            <tr ng-repeat="data in users">
            
              <td class="text-center">{{ (paginator.page - 1) * paginator.limit +  $index + 1 }}</td>
              <td>{{ data.username }}</td>
              <td class="uppercase">{{ data.name }}</td>
              <td>{{ data.active? 'ACTIVE':'NOT ACTIVE' }}</td>
              <td class="uppercase">{{ data.role }}</td>
              <td>
                <div class="btn-group btn-group-xs">
                  <a href="#/user/view/{{ data.id }}" class="btn btn-success" title="VIEW"><i class="fa fa-eye"></i></a> 
                  <a href="#/user/edit/{{ data.id }}" class="btn btn-primary" title="EDIT"><i class="fa fa-edit"></i></a> 
                  <a href="javascript:void(0)" ng-click="remove(data)" class="btn btn-danger" title="DELETE"><i class="fa fa-trash"></i></a>

                </div>
              </td>
                
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <ul class="pagination pull-right">
      <li class="pagination-page">
        <a href="javascript:void(0)" ng-click="load({ page: 1, search: searchTxt })"><sub>&laquo;&laquo;</sub></a>
      </li>
      <li class="prevPage {{ !paginator.prevPage? 'disabled':'' }}">
        <a href="javascript:void(0)" ng-click="load({ page: paginator.page - 1, search: searchTxt })">&laquo;</a>
      </li>
      <li ng-repeat="page in pages" class="pagination-page {{ paginator.page == page.number ? 'active':''}}" >
        <a href="javascript:void(0)" class="text-center" ng-click="load({ page: page.number, search: searchTxt })">{{ page.number }}</a>
      </li>
      <li class="nextPage {{ !paginator.nextPage? 'disabled':'' }}">
        <a href="javascript:void(0)" ng-click="load({ page: paginator.page + 1, search: searchTxt })">&raquo;</a>
      </li>
      <li class="pagination-page">
        <a href="javascript:void(0)" ng-click="load({ page: paginator.pageCount, search: searchTxt })"><sub>&raquo;&raquo;</sub> </a>
      </li>
    </ul>

    <div class="clearfix"></div>
        
    <div class="pull-right" ng-show="paginator.pageCount > 0">
      <sup class="text-primary">Page {{ paginator.pageCount > 0 ? paginator.page : 0 }} out of {{ paginator.pageCount }}</sup>
    </div>
  </div>
</div>

