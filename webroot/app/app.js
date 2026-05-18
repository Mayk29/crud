var app = angular.module('ednc', ['ngRoute', 'ngResource', 'chieffancypants.loadingBar', 'selectize']);

  app.config(function($routeProvider) {
    $routeProvider
    .otherwise({
      redirectTo: '/dashboard'
    });
  });

  // dashboard
  app.config(function($routeProvider) {
  $routeProvider
  .when('/dashboard', {
    templateUrl: 'dashboard',
    controller: 'DashboardController'
  });

});




