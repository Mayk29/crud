app.config(function($routeProvider) {
  $routeProvider
  .when('/users', {
    templateUrl: tmp + 'users__index',
    controller: 'UsersController',
  })
  .when('/user/add', {
    templateUrl: tmp + 'users__add',
    controller: 'UsersAddController',
  })
  .when('/user/edit/:id', {
    templateUrl: tmp + 'users__edit',
    controller: 'UsersEditController',
  })
  .when('/user/view/:id', {
    templateUrl: tmp + 'users__view',
    controller: 'UsersViewController',
  })
  ;

});


