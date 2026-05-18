// ─── INDEX ────────────────────────────────────────────────────────────────────
app.controller('CrudsController', function($scope, Crud) {

  $scope.advanceSearch     = {};
  $scope.showAdvanceSearch = false;
  $scope.activeTab         = 'ALL';
  $scope.lastAdvanceParams = null;
  $scope.searchTxt         = '';

  // Build params object from current state
  $scope.buildParams = function(page) {
    var params = { page: page || 1 };

    // Tab filter
    if ($scope.activeTab !== 'ALL') {
      params.tabStatus = $scope.activeTab;
    }

    // Advance search fields
    if ($scope.lastAdvanceParams) {
      if ($scope.lastAdvanceParams.searchName)   params.searchName   = $scope.lastAdvanceParams.searchName;
      if ($scope.lastAdvanceParams.searchAge)    params.searchAge    = $scope.lastAdvanceParams.searchAge;
      if ($scope.lastAdvanceParams.searchStatus) params.searchStatus = $scope.lastAdvanceParams.searchStatus;
    }

    // Simple search
    if ($scope.searchTxt) {
      params.search = $scope.searchTxt;
    }

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

  // Simple search
  $scope.search = function(search) {
    $scope.searchTxt         = search || '';
    $scope.lastAdvanceParams = null;
    $scope.load(1);
  };

  // Tab switching
  $scope.setTab = function(tab) {
    $scope.activeTab = tab;
    $scope.load(1);
  };

  // Toggle advance search panel
  $scope.toggleAdvanceSearch = function() {
    $scope.showAdvanceSearch = !$scope.showAdvanceSearch;
  };

  // Run advance search
  $scope.doAdvanceSearch = function(page) {
    $scope.lastAdvanceParams = {
      searchName:   $scope.advanceSearch.name   || '',
      searchAge:    $scope.advanceSearch.age    || '',
      searchStatus: $scope.advanceSearch.status || '',
    };
    $scope.load(page || 1);
  };

  // Reset advance search
  $scope.resetAdvanceSearch = function() {
    $scope.advanceSearch     = {};
    $scope.lastAdvanceParams = null;
    $scope.searchTxt         = '';
    $scope.load(1);
  };

  // Print — passes current tab/search filters so the print page is filtered too
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
app.controller('CrudsAddController', function($scope, Crud) {

  $scope.data = { Crud: {} };
  $scope.beneficiaries = [];

  $scope.computeAge = function() {
    if (!$scope.data.Crud.birthDate) return;
    var today     = new Date();
    var birthDate = new Date($scope.data.Crud.birthDate);
    var age       = today.getFullYear() - birthDate.getFullYear();
    var m         = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) age--;
    $scope.data.Crud.age = age;
  };

  $scope.addBeneficiary = function() {
    $scope.beneficiaries.push({ name: '', birthDate: '', age: '' });
  };

  $scope.removeBeneficiary = function(index) {
    $scope.beneficiaries.splice(index, 1);
  };

  $scope.computeBeneficiaryAge = function(beneficiary) {
    if (!beneficiary.birthDate) return;
    var today     = new Date();
    var birthDate = new Date(beneficiary.birthDate);
    var age       = today.getFullYear() - birthDate.getFullYear();
    var m         = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) age--;
    beneficiary.age = age;
  };

  // Client-side email format check
  $scope.isValidEmail = function(email) {
    if (!email) return true; // empty is allowed (not required)
    var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
  };

  $scope.save = function() {
    // Email validation before submitting
    if ($scope.data.Crud.email && !$scope.isValidEmail($scope.data.Crud.email)) {
      $.gritter.add({ title: 'Warning!', text: 'Please enter a valid email address.' });
      return;
    }

    var valid = $('#form').validationEngine('validate');
    if (valid) {
      $scope.data.Beneficiary = $scope.beneficiaries;
      Crud.save($scope.data, function(e) {
        if (e.ok) {
          $.gritter.add({ title: 'Successful!', text: e.msg });
          window.location = '#/cruds';
        } else {
          $.gritter.add({ title: 'Warning!', text: e.msg });
        }
      });
    }
  };

});

// ─── VIEW CRUD ────────────────────────────────────────────────────────────────
app.controller('CrudsViewController', function($scope, $routeParams, Crud) {

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

  // Approve — uses standard PUT /api/cruds/:id.json with status_name payload
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

  // Disapprove — uses standard PUT /api/cruds/:id.json with status_name payload
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

});

// ─── EDIT CRUD ────────────────────────────────────────────────────────────────
app.controller('CrudsEditController', function($scope, $routeParams, Crud) {

  $scope.id            = $routeParams.id;
  $scope.data          = { Crud: {} };
  $scope.beneficiaries = [];

  $scope.computeAge = function() {
    if (!$scope.data.Crud.birthDate) return;
    var today     = new Date();
    var birthDate = new Date($scope.data.Crud.birthDate);
    var age       = today.getFullYear() - birthDate.getFullYear();
    var m         = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) age--;
    $scope.data.Crud.age = age;
  };

  $scope.addBeneficiary = function() {
    $scope.beneficiaries.push({ name: '', birthDate: '', age: '' });
  };

  $scope.removeBeneficiary = function(index) {
    $scope.beneficiaries.splice(index, 1);
  };

  $scope.computeBeneficiaryAge = function(beneficiary) {
    if (!beneficiary.birthDate) return;
    var today     = new Date();
    var birthDate = new Date(beneficiary.birthDate);
    var age       = today.getFullYear() - birthDate.getFullYear();
    var m         = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) age--;
    beneficiary.age = age;
  };

  // Client-side email format check
  $scope.isValidEmail = function(email) {
    if (!email) return true;
    var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
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
      }
    });
  };

  $scope.load();

  $scope.update = function() {
    // Email validation before submitting
    if ($scope.data.Crud.email && !$scope.isValidEmail($scope.data.Crud.email)) {
      $.gritter.add({ title: 'Warning!', text: 'Please enter a valid email address.' });
      return;
    }

    var valid = $('#form-edit').validationEngine('validate');
    if (valid) {
      $scope.data.Beneficiary = $scope.beneficiaries;
      Crud.update({ id: $scope.id }, $scope.data, function(e) {
        if (e.ok) {
          $.gritter.add({ title: 'Successful!', text: e.msg });
          window.location = '#/cruds';
        } else {
          $.gritter.add({ title: 'Warning!', text: e.msg });
        }
      });
    }
  };

});