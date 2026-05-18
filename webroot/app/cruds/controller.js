// ─── INDEX ────────────────────────────────────────────────────────────────────
app.controller('CrudsController', function($scope, Crud) {

  $scope.advanceSearch     = {};
  $scope.showAdvanceSearch = false;
  $scope.activeTab         = 'ALL';
  $scope.lastAdvanceParams = null;
  $scope.searchTxt         = '';

  $scope.buildParams = function(page) {
    var params = { page: page || 1 };
    if ($scope.activeTab !== 'ALL') { params.tabStatus = $scope.activeTab; }
    if ($scope.lastAdvanceParams) {
      if ($scope.lastAdvanceParams.searchName)   params.searchName   = $scope.lastAdvanceParams.searchName;
      if ($scope.lastAdvanceParams.searchAge)    params.searchAge    = $scope.lastAdvanceParams.searchAge;
      if ($scope.lastAdvanceParams.searchStatus) params.searchStatus = $scope.lastAdvanceParams.searchStatus;
    }
    if ($scope.searchTxt) { params.search = $scope.searchTxt; }
    return params;
  };

  $scope.load = function(page) {
    var params = $scope.buildParams(page);
    Crud.query(params, function(e) {
      if (e.ok) {
        $scope.cruds     = e.data;
        $scope.paginator = e.paginator;
        $scope.pages     = paginator($scope.paginator, 5);
      }
    });
  };

  $scope.load();

  $scope.search = function(search) {
    $scope.searchTxt         = search || '';
    $scope.lastAdvanceParams = null;
    $scope.load(1);
  };

  $scope.setTab = function(tab) {
    $scope.activeTab = tab;
    $scope.load(1);
  };

  $scope.toggleAdvanceSearch = function() {
    $scope.showAdvanceSearch = !$scope.showAdvanceSearch;
  };

  $scope.doAdvanceSearch = function(page) {
    $scope.lastAdvanceParams = {
      searchName:   $scope.advanceSearch.name   || '',
      searchAge:    $scope.advanceSearch.age    || '',
      searchStatus: $scope.advanceSearch.status || '',
    };
    $scope.load(page || 1);
  };

  $scope.resetAdvanceSearch = function() {
    $scope.advanceSearch     = {};
    $scope.lastAdvanceParams = null;
    $scope.searchTxt         = '';
    $scope.load(1);
  };

  $scope.print = function() {
    var params = $scope.buildParams(1);
    delete params.page;
    var qs = Object.keys(params).map(function(k) {
      return k + '=' + encodeURIComponent(params[k] || '');
    }).join('&');
    window.open(base + '/print/cruds?' + qs, '_blank');
  };

  $scope.remove = function(data) {
    bootbox.confirm('Are you sure you want to delete "' + data.name + '"?', function(c) {
      if (c) {
        Crud.remove({ id: data.id }, function(e) {
          if (e.ok) {
            $.gritter.add({ title: 'Successful!', text: e.msg });
            $scope.load();
          } else {
            $.gritter.add({ title: 'Warning!', text: e.msg });
          }
        });
      }
    });
  };

});

// ─── ADD CRUD ─────────────────────────────────────────────────────────────────
app.controller('CrudsAddController', function($scope, $http, Crud) {

  $scope.data          = { Crud: {} };
  $scope.beneficiaries = [];
  $scope.pendingFiles  = [];

  $scope.computeAge = function() {
    if (!$scope.data.Crud.birthDate) return;
    var today = new Date(), birthDate = new Date($scope.data.Crud.birthDate);
    var age   = today.getFullYear() - birthDate.getFullYear();
    var m     = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) age--;
    $scope.data.Crud.age = age;
  };

  $scope.addBeneficiary    = function() { $scope.beneficiaries.push({ name: '', birthDate: '', age: '' }); };
  $scope.removeBeneficiary = function(i) { $scope.beneficiaries.splice(i, 1); };

  $scope.computeBeneficiaryAge = function(b) {
    if (!b.birthDate) return;
    var today = new Date(), bd = new Date(b.birthDate);
    var age   = today.getFullYear() - bd.getFullYear();
    var m     = today.getMonth() - bd.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < bd.getDate())) age--;
    b.age = age;
  };

  $scope.isValidEmail = function(email) {
    if (!email) return true;
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
  };

  $scope.formatSize = function(bytes) {
    if (!bytes)          return '0 B';
    if (bytes < 1024)    return bytes + ' B';
    if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
    return (bytes / 1048576).toFixed(1) + ' MB';
  };

  $scope.onFileSelect = function(el) {
    for (var i = 0; i < el.files.length; i++) $scope.pendingFiles.push(el.files[i]);
    $scope.$apply();
    el.value = '';
  };

  $scope.removePendingFile = function(i) { $scope.pendingFiles.splice(i, 1); };

  $scope._uploadPendingFiles = function(crudId, callback) {
    if (!$scope.pendingFiles.length) { callback(); return; }
    var remaining = $scope.pendingFiles.length, errors = [];
    angular.forEach($scope.pendingFiles, function(file) {
      var fd = new FormData();
      fd.append('file', file);
      $http.post(api + 'cruds/upload_file/' + crudId + '.json', fd, {
        transformRequest: angular.identity,
        headers: { 'Content-Type': undefined }
      }).then(function(res) {
        if (!res.data.ok) errors.push(file.name + ': ' + res.data.msg);
      }, function() {
        errors.push(file.name + ': upload request failed');
      }).finally(function() {
        remaining--;
        if (remaining === 0) callback(errors.length ? errors.join('\n') : null);
      });
    });
  };

  $scope.save = function() {
    if ($scope.data.Crud.email && !$scope.isValidEmail($scope.data.Crud.email)) {
      $.gritter.add({ title: 'Warning!', text: 'Please enter a valid email address.' });
      return;
    }
    var valid = $('#form').validationEngine('validate');
    if (valid) {
      $scope.data.Beneficiary = $scope.beneficiaries;
      Crud.save($scope.data, function(e) {
        if (e.ok) {
          $scope._uploadPendingFiles(e.id || null, function(uploadErr) {
            if (uploadErr) {
              $.gritter.add({ title: 'Warning!', text: 'Record saved but some files failed:\n' + uploadErr });
            } else {
              $.gritter.add({ title: 'Successful!', text: e.msg });
            }
            window.location = '#/cruds';
          });
        } else {
          $.gritter.add({ title: 'Warning!', text: e.msg });
        }
      });
    }
  };

});

// ─── VIEW CRUD ────────────────────────────────────────────────────────────────
app.controller('CrudsViewController', function($scope, $routeParams, Crud, CrudFile) {

  $scope.id   = $routeParams.id;
  $scope.data = {};

  $scope.load = function() {
    Crud.get({ id: $scope.id }, function(e) {
      if (e.ok) {
        $scope.data = e.data;
        $scope.$apply();
      }
    });
  };

  $scope.load();

  $scope.formatSize = function(bytes) {
    if (!bytes)          return '0 B';
    if (bytes < 1024)    return bytes + ' B';
    if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
    return (bytes / 1048576).toFixed(1) + ' MB';
  };

  $scope.approve = function() {
    bootbox.confirm('Are you sure you want to APPROVE this record?', function(c) {
      if (c) {
        Crud.update({ id: $scope.id }, { Crud: { status_name: 'APPROVED' } }, function(e) {
          if (e.ok) {
            $.gritter.add({ title: 'Approved!', text: e.msg });
            $scope.load();
          } else {
            $.gritter.add({ title: 'Warning!', text: e.msg });
          }
        });
      }
    });
  };

  $scope.disapprove = function() {
    bootbox.confirm('Are you sure you want to DISAPPROVE this record?', function(c) {
      if (c) {
        Crud.update({ id: $scope.id }, { Crud: { status_name: 'DISAPPROVED' } }, function(e) {
          if (e.ok) {
            $.gritter.add({ title: 'Disapproved!', text: e.msg });
            $scope.load();
          } else {
            $.gritter.add({ title: 'Warning!', text: e.msg });
          }
        });
      }
    });
  };

  $scope.print = function() {
    if ($scope.data.status !== 'APPROVED') return;
    window.open(base + '/print/crud_view/' + $scope.id, '_blank');
  };

});

// ─── EDIT CRUD ────────────────────────────────────────────────────────────────
app.controller('CrudsEditController', function($scope, $routeParams, $http, Crud, CrudFile) {

  $scope.id            = $routeParams.id;
  $scope.data          = { Crud: {} };
  $scope.beneficiaries = [];
  $scope.existingFiles = [];
  $scope.pendingFiles  = [];

  $scope.computeAge = function() {
    if (!$scope.data.Crud.birthDate) return;
    var today = new Date(), birthDate = new Date($scope.data.Crud.birthDate);
    var age   = today.getFullYear() - birthDate.getFullYear();
    var m     = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) age--;
    $scope.data.Crud.age = age;
  };

  $scope.addBeneficiary    = function() { $scope.beneficiaries.push({ name: '', birthDate: '', age: '' }); };
  $scope.removeBeneficiary = function(i) { $scope.beneficiaries.splice(i, 1); };

  $scope.computeBeneficiaryAge = function(b) {
    if (!b.birthDate) return;
    var today = new Date(), bd = new Date(b.birthDate);
    var age   = today.getFullYear() - bd.getFullYear();
    var m     = today.getMonth() - bd.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < bd.getDate())) age--;
    b.age = age;
  };

  $scope.isValidEmail = function(email) {
    if (!email) return true;
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
  };

  $scope.formatSize = function(bytes) {
    if (!bytes)          return '0 B';
    if (bytes < 1024)    return bytes + ' B';
    if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
    return (bytes / 1048576).toFixed(1) + ' MB';
  };

  $scope.load = function() {
    Crud.get({ id: $scope.id }, function(e) {
      if (e.ok) {
        $scope.data.Crud = {
          id:        e.data.id,
          name:      e.data.name,
          email:     e.data.email,
          birthDate: e.data.birthDate,
          age:       e.data.age
        };
        $scope.beneficiaries = e.data.Beneficiary || [];
        $scope.existingFiles = e.data.CrudFile    || [];
      }
    });
  };

  $scope.load();

  $scope.onFileSelect = function(el) {
    for (var i = 0; i < el.files.length; i++) $scope.pendingFiles.push(el.files[i]);
    $scope.$apply();
    el.value = '';
  };

  $scope.removePendingFile = function(i) { $scope.pendingFiles.splice(i, 1); };

  $scope.deleteFile = function(file) {
    bootbox.confirm('Delete file "' + file.original + '"?', function(c) {
      if (c) {
        CrudFile.deleteFile({ id: file.id }, function(e) {
          if (e.ok) {
            $.gritter.add({ title: 'Deleted!', text: e.msg });
            var idx = $scope.existingFiles.indexOf(file);
            if (idx > -1) $scope.$apply(function() { $scope.existingFiles.splice(idx, 1); });
          } else {
            $.gritter.add({ title: 'Warning!', text: e.msg });
          }
        });
      }
    });
  };

  $scope._uploadPendingFiles = function(callback) {
    if (!$scope.pendingFiles.length) { callback(); return; }
    var remaining = $scope.pendingFiles.length, errors = [];
    angular.forEach($scope.pendingFiles, function(file) {
      var fd = new FormData();
      fd.append('file', file);
      $http.post(api + 'cruds/upload_file/' + $scope.id + '.json', fd, {
        transformRequest: angular.identity,
        headers: { 'Content-Type': undefined }
      }).then(function(res) {
        if (res.data.ok) {
          $scope.existingFiles.push(res.data.file);
        } else {
          errors.push(file.name + ': ' + res.data.msg);
        }
      }, function() {
        errors.push(file.name + ': upload request failed');
      }).finally(function() {
        remaining--;
        if (remaining === 0) callback(errors.length ? errors.join('\n') : null);
      });
    });
  };

  $scope.update = function() {
    if ($scope.data.Crud.email && !$scope.isValidEmail($scope.data.Crud.email)) {
      $.gritter.add({ title: 'Warning!', text: 'Please enter a valid email address.' });
      return;
    }
    var valid = $('#form-edit').validationEngine('validate');
    if (valid) {
      $scope.data.Beneficiary = $scope.beneficiaries;
      Crud.update({ id: $scope.id }, $scope.data, function(e) {
        if (e.ok) {
          $scope._uploadPendingFiles(function(uploadErr) {
            if (uploadErr) {
              $.gritter.add({ title: 'Warning!', text: 'Record updated but some files failed:\n' + uploadErr });
            } else {
              $.gritter.add({ title: 'Successful!', text: e.msg });
            }
            window.location = '#/cruds';
          });
        } else {
          $.gritter.add({ title: 'Warning!', text: e.msg });
        }
      });
    }
  };

});