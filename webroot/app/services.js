app.factory("Select", function($resource) {
  return $resource( api + 'select', {}, { 
    query: { method: 'GET', isArray: false },
    update: { method: 'PUT' }
    });
});
