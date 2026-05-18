app.controller('UsersController', function($scope, User) {
  
  // load data

  $scope.load = function(options) {

    options = typeof options !== 'undefined' ?  options : {};

    User.query(options, function(e) {

      if (e.ok) {

        $scope.users = e.data;
        
        //pagination

        $scope.paginator = e.paginator;

        $scope.pages = paginator($scope.paginator, 5);

      }

    });

  }

  $scope.load();
  
  //search

  $scope.search = function(search) {

    search = typeof search !== 'undefined' ? search : '';

    if (search.length > 0){

      $scope.load({

        search: search

      });

    }else{

      $scope.load();
    
    }

  }
    
  // remove

  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to delete ' + data.name +' ?', function(c) {

      if (c) {

        User.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            $scope.load();

          }

        });

      }

    });

  }

});

app.controller('UsersAddController', function($scope, User, Select) {

  $('#form').validationEngine('attach');

  $('.datepicker').datepicker({

    format:    'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

  $scope.bool = [{ id: true, value: 'Yes' }, { id: false, value: 'No' }];

  $scope.data = {

    User : {},

    UserPermission : []

  }
  // get session

  Select.get({code: 'session'}, function(e){

    $scope.roleId = e.data.roleId;

  });

  // get roles

  Select.get({code: 'roles'}, function(e){

    $scope.roles = e.data;

  });

  // get permissions

  Select.get({code: 'permissions'}, function(e){

    $scope.permissions = e.data;

  });

  $scope.compute = function(){

    amount = 0;

    if($scope.data.UserPermission.length > 0){

      $.each($scope.data.UserPermission,function(key,val){

        amount += parseFloat(val['amount']);

      });

    }

    $scope.data.User.total = amount;

  }

  $scope.getPermission = function(id){

    if($scope.permissions.length > 0){

      $.each($scope.permissions,function(key,val){

        if(id == val.id){

          $scope.adata.permission = val.value;

        }

      });

    }
  
  }

  $scope.addPermission = function() {

    $('#add_permission').validationEngine('attach');

    $scope.adata = {};

    $('#add-permission-modal').modal('show');  

  }

  $scope.savePermission = function(data){

    valid = $('#add_permission').validationEngine('validate');

    if(valid){

      data.amount = number_format(data.amount, 2, '.', ''); 

      $scope.data.UserPermission.push(data);

      $scope.compute();

      $('#add-permission-modal').modal('hide');  

    }
    
  }

  $scope.editPermission = function(index,data) {

    $('#edit_permission').validationEngine('attach');

    data.index = index;

    $scope.adata = data;

    $('#edit-permission-modal').modal('show');  

  }

  $scope.updatePermission = function(data,index) {

    valid = $('#edit_permission').validationEngine('validate');

    if(valid){

      data.amount = number_format(data.amount, 2, '.', ''); 

      $scope.data.UserPermission[data.index] = data;

      $scope.compute();

      $('#edit-permission-modal').modal('hide');  

    }

  }

  $scope.removePermission = function(index){

    $scope.data.UserPermission.splice(index,1);

    $scope.compute();

  }

  $scope.save = function() {

    valid = $("#form").validationEngine('validate');
    
    if (valid) {

      if ($scope.data.User.password != $scope.confirmPassword) {

        $.gritter.add({

          title: 'Warning!',

          text:  'Password does not match.'

        });

      } else {

        User.save($scope.data, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = '#/users';

          } else {

            $.gritter.add({

              title: 'Warning!',

              text:  e.msg,

            });

          }

        });

      }  

    }

  }

});

app.controller('UsersViewController', function($scope, $routeParams, DeleteSelected, User, Select, UserPermission) {

  modalMaxHeight();

  $scope.id = $routeParams.id;

  $scope.data = {};

  $scope.data.PermissionSelection = [];

  $scope.data.UserPermission = [];
  
  // load 

  $scope.load = function() {

    User.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

      $scope.permissions_temp = $scope.data.PermissionSelection;

      $scope.compute();
      
    });

  }

  $scope.load();
  
  $scope.compute = function(){

    amount = 0;

    if($scope.data.UserPermission.length > 0){

      $.each($scope.data.UserPermission,function(key,val){

        if(val.visible != 0){

          amount += parseFloat(val['amount']);

        }

      });

    }

    $scope.data.User.total = amount;

  }

  $scope.removeselected = function() {
    
    $('.deletePermission').attr('disabled',true);

    permissiondelete = [];

    for (i in $scope.data.UserPermission) {

      if ($scope.data.UserPermission[i].selected) {

        permissiondelete.push({

          user_id:       $scope.id,

          permission_id: $scope.data.UserPermission[i].id

        });

      }

    }

   if (permissiondelete.length <= 0) {

      $.gritter.add({

        title: 'Warning!',

        text: 'Please select permission to delete.',

      });

      $('.deletePermission').attr('disabled',false);

    } else {

      bootbox.confirm('Are you sure you want to delete your selected permission ?', function(c) {

        if (c) {

          DeleteSelected.save({ permissiondelete : permissiondelete }, function(e) {

            $('.deletePermission').attr('disabled',false);

            if (e.ok) {

              $.gritter.add({

                title: 'Successful!',

                text: e.msg

              });

              $scope.load();

            } else {

              $.gritter.add({

                title: 'Warning!',

                text: e.msg

              });

            }

          });

        } else {

          $('.deletePermission').attr('disabled',false);

        }

      });

    }

  }
  
  // remove 

  $scope.remove = function(data) {

    bootbox.confirm('Are you sure you want to remove '+ data.name +' ?', function(c) {

      if (c) {

        User.remove({ id: data.id }, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = "#/users";

          }

        });

      }

    });

  } 

  // add permission

  $scope.addPermission = function() {

    $('.savePermission').attr('disabled',false);

    $('#add-permission-modal').modal('show');

  }

  $scope.selectall = function() {

    if ($scope.selectAll) {

      bool = true;

    } else {

      bool = false;

    }

    for (i in $scope.data.PermissionSelection) {

      $scope.data.PermissionSelection[i].selected = bool;

    }

  }
  
  $scope.selectalldelete = function() {

    if ($scope.selectAlldelete) {

      bool = true;

    } else {

      bool = false;

    }

    for (i in $scope.data.UserPermission) {

      $scope.data.UserPermission[i].selected = bool;

    }

  }
    
  $scope.savePermission = function() {

    $('.savePermission').attr('disabled',true);

    permissions = [];

    for (i in $scope.data.PermissionSelection) {

      if ($scope.data.PermissionSelection[i].selected) {

        permissions.push({

          user_id:       $scope.id,

          permission_id: $scope.data.PermissionSelection[i].id

        });

      }

    }

    if (permissions.length <= 0) {

      $.gritter.add({

        title: 'Warning!',

        text: 'Please select permission to save.',

      });

      $('.savePermission').attr('disabled',false);

    } else {

      $('.savePermission').attr('disabled',true);

      UserPermission.save({ UserPermission: permissions }, function(e) {

        $('.savePermission').attr('disabled',true);

        if (e.ok) {

          $.gritter.add({

            title: 'Successful!',

            text: e.msg

          });

          $scope.load();

          $('#add-permission-modal').modal('hide');

        } else {

          $.gritter.add({

            title: 'Warning!',

            text: e.msg

          });

        }

      });

    }

  }

  // remove user

  $scope.removePermission = function (permission) {

    bootbox.confirm('Are you sure you want to delete "' + permission.module + '-' + permission.action + '"?', function(c) {

      if (c) {

        UserPermission.remove({ id:permission.id }, function(e){

          if(e.ok){

            $.gritter.add({ title: 'Successful!', text: e.msg });

            $scope.load();

          }

        }); 

      }

    }); 

  };
  
  $scope.filterPermission = function (search) {

    temp = [];

    if (search.module) {

      angular.forEach($scope.permissions_temp, function(value, key) {

        if (value.module == search.module) {

          temp.push(value);

        }

      });

    }else if (search.action) {

      angular.forEach($scope.permissions_temp, function(value, key) {

        if (value.action == search.action) {

          temp.push(value);

        }

      });

    } 

    $scope.data.PermissionSelection = temp;

  }

});

app.controller('UsersEditController', function($scope, $routeParams, User, Select) {
  
  $scope.data = {};
  
  $scope.bool = [{ id: true, value: 'Yes' }, { id: false, value: 'No' }];

  $('.datepicker').datepicker({

    format:    'mm/dd/yyyy',

    autoclose: true,

    todayHighlight: true,

  });

  // get session

  Select.get({code: 'session'}, function(e){

    $scope.roleId = e.data.roleId;

  });

  // get roles

  Select.get({code: 'roles'}, function(e){

    $scope.roles = e.data;

  });

  // get branches

  Select.get({code: 'branch'}, function(e){

    $scope.branches = e.data;

  });
  
  // get permissions

  Select.get({code: 'permissions'}, function(e){

    $scope.permissions = e.data;

  });

  $scope.id = $routeParams.id;

  $("#form").validationEngine('attach');
  
  // load 

  $scope.load = function() {

    User.get({ id: $scope.id }, function(e) {

      $scope.data = e.data;

      $scope.data.User.password = '';

      $scope.confirmPassword = '';

      $scope.putIndex();

    });

  }

  $scope.load();

  $scope.compute = function(){

    amount = 0;

    if($scope.data.UserPermission.length > 0){

      $.each($scope.data.UserPermission,function(key,val){

        if(val.visible != 0){

          amount += parseFloat(val['amount']);

        }

      });

    }

    $scope.data.User.total = amount;

  }

  $scope.getPermission = function(id){

    if($scope.permissions.length > 0){

      $.each($scope.permissions,function(key,val){

        if(id == val.id){

          $scope.adata.permission = val.value;
          
        }

      });

    }
  
  }

  $scope.putIndex = function(){

    if($scope.data.UserPermission.length > 0){

      index = 0;

      $.each($scope.data.UserPermission,function(key,val){

        if(val.visible != 0){

          index += 1;

          $scope.data.UserPermission[key].index = index;
          
        }

      });

    }

  }

  $scope.addPermission = function() {

    $('#add_permission').validationEngine('attach');

    $scope.adata = {};

    $('#add-permission-modal').modal('show');  

  }

  $scope.savePermission = function(data){

    valid = $('#add_permission').validationEngine('validate');

    if(valid){

      data.amount = number_format(data.amount, 2, '.', ''); 

      $scope.data.UserPermission.push(data);

      $scope.compute();

      $scope.putIndex();

      $('#add-permission-modal').modal('hide');  

    }
    
  }

  $scope.editPermission = function(index,data) {

    $('#edit_permission').validationEngine('attach');

    data.index = index;

    $scope.adata = data;

    $('#edit-permission-modal').modal('show');  

  }

  $scope.updatePermission = function(data,index) {

    valid = $('#edit_permission').validationEngine('validate');

    if(valid){

      data.amount = number_format(data.amount, 2, '.', ''); 

      $scope.data.UserPermission[data.index] = data;

      $scope.compute();

      $scope.putIndex();

      $('#edit-permission-modal').modal('hide');  

    }

  }

  $scope.removePermission = function(index){

    $scope.data.UserPermission[index].visible = 0;

    $scope.compute();

    $scope.putIndex();

  }

  $scope.update = function() {

    valid = $("#form").validationEngine('validate');

    if (valid) {

      if ($scope.data.User.password != $scope.confirmPassword) {

        $.gritter.add({

          title: 'Warning!',

          text: 'Password does not match'

        });

      } else {

        User.update({id:$scope.id}, $scope.data, function(e) {

          if (e.ok) {

            $.gritter.add({

              title: 'Successful!',

              text:  e.msg,

            });

            window.location = '#/users';

          } else {

            $.gritter.add({

              title: 'Warning!',

              text:  e.msg,

            });

          }

        });

      }  

    }
    
  }

}); 
