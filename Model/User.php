<?php
App::uses('AppModel', 'Model');
class User extends AppModel {

	public $recursive = -1;
	public $actsAs = array('Containable');
	
	public $belongsTo = array(
		'Role' => array(
			'foreignKey' => 'roleId'
		)
	);
	
	public $hasMany = array(
		'UserPermission'
	);
	
	public function beforeSave($options = array()) {
		if (isset($this->data[$this->alias]['password'])) {
			$this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
		}
		return true;
	}


  public function validSave($data) {

    $result = array();
		
		// transform data

    $data['code']       = slug(@$data['name']);

    $data['last_name']  = properCase(@$data['last_name']);

    $data['first_name'] = properCase(@$data['first_name']);

    $data['branchId']   = branchId();
    
    $existingConditions = array();

    $existingConditions['username'] = $data['username'];

    $existingConditions['visible'] = true;

    $existingConditions['branchId'] = branchId();
			
    if (isset($data['id']))

      $existingConditions['id !='] = $data['id'];

    $existing = $this->existing($existingConditions);

    if ($existing) {

      $result = array(

        'ok'  => false,

        'msg' => 'User account already exists.'

      );

    } else {

      if ($this->save($data)) {

        $result = array(

          'ok'  => true,

          'msg' => 'User account has been saved.'

        );

      }

    }

    return $result;

  }
	public function findUserId($code=null) {
		$data = $this->find('first',array('conditions'=>array('User.code'=>$code))); 	
		return @$data['User']['id'];	
	}
	
  public $virtualFields = array(
    'name' => 'CONCAT(IFNULL(User.first_name,""), " ", IFNULL(User.last_name,""))'
  );

  public function getAllUsers($conditions=array()) {

    $search = @$conditions['search'];

    $role = @$conditions['role'];

    return "SELECT

        User.*,

        Role.*

      FROM

        users as User LEFT JOIN

        roles as Role ON Role.id = User.roleId

      WHERE

        User.visible = true $role AND

        (

          User.last_name    LIKE  '%$search%' OR

          User.first_name   LIKE  '%$search%' OR

          User.middle_name  LIKE  '%$search%' OR

          User.username     LIKE  '%$search%' OR

          User.active       LIKE  '%$search%' OR

          User.roleId       LIKE  '%$search%'

        )

      GROUP BY 

        User.id

      ORDER BY

        User.id ASC
        
    ";

  }

  public function countAllUsers($conditions=array()) {

    $search = @$conditions['search'];

    $role = @$conditions['role'];

    return "SELECT

       count(*) as total

      FROM

        users as User LEFT JOIN

        roles as Role ON Role.id = User.roleId

      WHERE

        User.visible = true $role AND

        (

          User.last_name    LIKE  '%$search%' OR

          User.first_name   LIKE  '%$search%' OR

          User.middle_name  LIKE  '%$search%' OR

          User.username     LIKE  '%$search%' OR

          User.active       LIKE  '%$search%' OR

          User.roleId       LIKE  '%$search%'

        )

    ";

  }

  public function paginate($conditions, $fields, $order, $limit, $page = 1, $recursive = null, $extra = array()) {

    $recursive = -1;

    // Mandatory to have

    $this->useTable = false;

    $sql = '';

    $sql .= $this->getAllUsers($extra['extra']['conditions']);

    // Adding LIMIT Clause

    $sql .= 'LIMIT ';

    $sql .= (($page - 1) * $limit) . ', ' . $limit;

    $results = $this->query($sql);

    return $results;

  }

  public function paginateCount($conditions = null, $recursive = 0, $extra = array()) {

    $sql = '';

    $sql .= $this->countAllUsers($extra['extra']['conditions']);

    $this->recursive = $recursive;

    $results = $this->query($sql);

    return $results[0][0]['total'];

  }

}
