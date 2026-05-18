app.directive('number', function() {
  return {
    restrict: 'A',
    require: 'ngModel',
    link: function(scope, element, attr, ngModel) {
      element.on('keypress', function(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        if ((charCode  < 48 || charCode > 57))
          return false;
        return true;
      });

      element.on('blur', function(evt) {
        if (ngModel.$viewValue == '' || isNaN(ngModel.$viewValue))
          result = 0;
        else
          result = parseInt(ngModel.$viewValue);
        return scope.$apply(function() {
          $(element).val(result);
          return ngModel.$setViewValue(result);
        });
      });
    }
  };
});


app.directive('icheck', function($timeout, $parse) {
  return {
    require: 'ngModel',
    link: function($scope, element, $attrs, ngModel) {
      return $timeout(function() {
        var value;
        value = $attrs['value'];

        $scope.$watch($attrs['ngModel'], function(newValue){
          $(element).iCheck('update');
        });
        return $(element).iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue'

        }).on('ifChanged', function(event) {
          if ($(element).attr('type') === 'checkbox' && $attrs['ngModel']) {
            $scope.$apply(function() {
              return ngModel.$setViewValue(event.target.checked);
            });
          }
          if ($(element).attr('type') === 'radio' && $attrs['ngModel']) {
            return $scope.$apply(function() {
              return ngModel.$setViewValue(value);
            });
          }
        });
      });
    }
  };
});

app.directive('ngEnter', function () {
    return function (scope, element, attrs) {
        element.bind("keydown keypress", function (event) {
            if(event.which === 13) {
                scope.$apply(function (){
                    scope.$eval(attrs.ngEnter);
                });
 
                event.preventDefault();
            }
        });
    };
});

app.directive('decimal', function() {

  return {

    require: "ngModel",

    link: function (scope, elem, attr, ctrl) {

      $(elem).inputmask({

        alias: 'decimal'

        , groupSeparator: ','

        , autoGroup: true

        , rightAlign: false

      });
      elem.on('keyup', function () 
        {
          scope.$apply(function()
            {
              ctrl.$setViewValue(elem.val());
            });
        });
      }
  };
});
