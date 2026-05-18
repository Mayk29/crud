<?php
class Permission extends AppModel {

	public $recursive = -1;
	public $actsAs = array('Containable');

  public $hasMany = array(
    'UserPermission' => array(
      'foreignKey' => 'permissionId'
    )
  );

  public function validSave($data) {
    $result = array();

    $module = strtolower($data['module']);
    //$controller = str_replace(' ', '-', strtolower($data['controller']));
    $action = strtolower($data['action']);

    $existingConditions = array();
    $existingConditions['visible'] = true;
    $existingConditions['OR'] = array(
      //'name' => $data['name'],
      "module LIKE '$module' AND action LIKE '$action'",
    );
    
    
    if (isset($data['id']))
      $existingConditions['id !='] = $data['id'];

    $existing = $this->existing($existingConditions);

    if (!isset($data['module'])) {
      $result = array(
        'ok'  => false,
        'msg' => 'Module field is required.'
      );
    // } elseif (!isset($data['controller'])) {
    //   $result = array(
    //     'ok'  => false,
    //     'msg' => 'Controller field is required.'
    //   );
    } elseif (!isset($data['action'])) {
      $result = array(
        'ok'  => false,
        'msg' => 'Action field is required.'
      );
    } elseif ($existing) {
      $result = array(
        'ok'  => false,
        'msg' => 'Permission already exists.'
      );
    } else {
     // $data['name'] = strtolower($data['name']);
      $data['module'] = strtolower($data['module']);
      //$data['controller'] = str_replace(' ', '-', strtolower($data['controller']));
      $data['action'] = strtolower($data['action']);
      if ($this->save($data)) {
        $result = array(
          'ok'  => true,
          'msg' => 'Permission has been saved.'
        );
      }
    }
    return $result;
  }
}
