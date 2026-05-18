// Standard CRUD operations
app.factory('Crud', function($resource) {
  return $resource(api + 'cruds/:id.json', { id: '@id' }, {
    query:  { method: 'GET',    isArray: false },
    update: { method: 'PUT',    isArray: false },
    remove: { method: 'DELETE', isArray: false },
  });
});

// File operations for CRUD module
app.factory('CrudFile', function($resource) {
  return $resource(api + 'cruds/:action/:id.json', { id: '@id' }, {
    deleteFile: { method: 'DELETE', isArray: false, params: { action: 'delete_file' } },
  });
});