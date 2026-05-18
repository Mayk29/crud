 app.factory("User", function($resource) {
  return $resource( api + "users/:id", { id: '@id', search: '@search' }, {
    query: { method: 'GET', isArray: false },
    update: { method: 'PUT' },
    search: { method: 'GET' },
  });
});

app.factory("UserPermission", function($resource) {
  return $resource( api + 'user-permissions/:id', {id:'@id'}, {
    query: { method: 'GET', isArray: false },
    update: { method: 'PUT' }
  });
});

app.factory("DeleteSelected", function($resource) {
  return $resource( api + 'user_permissions/deleteSelected/:id', {id:'@id'}, {
    query: { method: 'GET', isArray: false },
    update: { method: 'PUT' }
  });
});

