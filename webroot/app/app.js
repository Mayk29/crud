var app = angular.module('ednc', ['ngRoute', 'ngResource', 'chieffancypants.loadingBar', 'selectize']);

  app.run(function($rootScope) {
    $rootScope.$on('$routeChangeSuccess', function() {
      var hash = window.location.hash.replace('#/', '');
      document.querySelectorAll('.flux-nav-link').forEach(function(link) {
        link.classList.remove('active');
        var route = link.getAttribute('data-route');
        if (route && hash.indexOf(route) === 0) {
          link.classList.add('active');
          var label = link.querySelector('.flux-nav-label');
          if (label) {
            document.getElementById('fluxPageTitle').textContent = label.textContent;
          }
        }
      });
    });
  });

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