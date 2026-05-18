// Standard CRUD operations
app.factory('Crud', function($resource) {
  return $resource(api + 'cruds/:id.json', { id: '@id' }, {
    query:  { method: 'GET',    isArray: false },
    update: { method: 'PUT',    isArray: false },
    remove: { method: 'DELETE', isArray: false },
  });
});