app.config(function($routeProvider) {
  $routeProvider
  .when('/cruds', {
    templateUrl: tmp + 'cruds__index',
    controller: 'CrudsController',
  })
  .when('/cruds/add', {
    templateUrl: tmp + 'cruds__add',
    controller: 'CrudsAddController',
  })
  .when('/cruds/edit/:id', {
    templateUrl: tmp + 'cruds__edit',
    controller: 'CrudsEditController',
  })
  .when('/cruds/view/:id', {
    templateUrl: tmp + 'cruds__view',
    controller: 'CrudsViewController',
  })
  ;

});


