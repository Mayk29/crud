app.filter('total', function () {
  return function (input, property) {
    var i = input instanceof Array ? input.length : 0;
    if (typeof property === 'undefined' || i === 0) {
      return i;
    } else if (isNaN(input[0][property])) {
      throw 'filter total can count only numeric values';
    } else {
      var total = 0;
      while (i--)
        total += parseFloat(input[i][property]);
      return total;
    }
  };
});

app.filter('dateFormat', function() {
  return function(input, format){
    return new Date(input).toString(format);
  };
});

app.filter('abs', function() {
  return function(input) {
    return Math.abs(input);
  }  
});