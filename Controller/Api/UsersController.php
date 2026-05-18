<?php

App::uses('AppController', 'Controller');

class UsersController extends AppController {

  public $components = array('Paginator', 'RequestHandler', );

  public function beforeFilter() {

    parent::beforeFilter();

    $this->RequestHandler->ext = 'json';

  }

  public $uses = array(

    'UserPermission',

    'User'

  );

  public function index() {

    // default page 1

    $page = isset($this->request->query['page'])? $this->request->query['page'] : 1;
        
    $conditions = array();

    $conditions['role'] = '';

    if (session('roleId') != 1){

      $conditions['role'] = "AND User.roleId <> 1";

    }

    $conditions['search'] = '';

    // search conditions

    if(isset($this->request->query['search'])){

      $search = $this->request->query['search'];

      $search = strtolower($search);

      $conditions['search'] = $search;

    }
    
    // paginate data
    $this->paginate = array('User'=>array(

      'limit' => 25,

      'page'  => $page,

      'extra' => array('conditions'=>$conditions)

    ));

    $tmpData = $this->paginate('User');

    // transform data

    $users_ = array();

    if(!empty($tmpData)){

      foreach ($tmpData as $user) {

        $users_[]=array(

          'id'          =>  $user['User']['id'],
          
          'username'    =>  $user['User']['username'],
          
          'name'        =>  ucwords(strtolower($user['User']['first_name'] . ' ' . $user['User']['middle_name'] . ' ' . $user['User']['last_name'])),
          
          'firstname'   =>  properCase($user['User']['first_name']), 
          
          'lastname'    =>  properCase($user['User']['last_name']),
         
          'middlename' =>   properCase($user['User']['middle_name']),
          
          'role'        =>  $user['Role']['name'],
          
          'active'      =>  $user['User']['active'],
        
          'verified'    =>  $user['User']['verified'],

          'date_created'=>  date('m/d/Y' ,strtotime($user['User']['created']))

        );

      }

    }
    
    $response = array(

      'ok' =>   true, 

      'msg' => 'index',

      'data' => $users_,

      'paginator' => $this->request->params['paging']['User']

    );

    $this->set(array(

      'response'=>$response,

      '_serialize'=>'response'

    ));

  }

  public function add() {

    $user = $this->request->data['User'];

    $permission = $this->request->data['UserPermission'];

    $response = $this->User->validSave($user);
    
    if($response['ok']){

      $id = $this->User->getLastInsertId();

      if(!empty($permission)){

        foreach ($permission as $key => $value) {
          
          $permission[$key]['date'] = $value['date'] = isset($value['date'])? date('Y-m-d', strtotime($value['date'])):null;

          $permission[$key]['user_id'] = $id;

        }

        $this->UserPermission->saveMany($permission);
      }

    }
    $this->set(array(

      'response'=>$response,

      '_serialize'=>'response'

    ));

  }

  public function view($id = null) {

    $user = $this->User->find('first', array(

      'conditions' => array(

        'User.id' => $id,

        'User.visible' => true

      ),
    
    ));

    unset($user['User']['password']);

    $user['UserPermission'] = Set::extract('{}.UserPermission',$this->UserPermission->find('all',array(

      'conditions' => array(

        'UserPermission.visible' => true,

        'UserPermission.user_id' => $id

      ),

      'order' => array(

        'UserPermission.id' => 'ASC' 

      )

    )));

    $user['UserPermission'] = is_null($user['UserPermission']) ? array() : $user['UserPermission'];

    $response = array(

      'ok'        => true,

      'data'      => $user,

    );

    $this->set(array(

      'response'=>$response,

      '_serialize'=>'response'

    ));

  }

  public function edit($id = null) {

    $permission = $this->request->data['UserPermission'];
    
    if (isset($this->request->data['User']['password'])) {

      if ($this->request->data['User']['password'] == ''){

        unset($this->request->data['User']['password']);

      }

    }

    $user = $this->request->data['User'];

    if($this->User->save($user)) {

      if(!empty($permission)){

        foreach ($permission as $key => $value) {
          
          $permission[$key]['date'] = $value['date'] = isset($value['date'])? date('Y-m-d', strtotime($value['date'])):null;

          $permission[$key]['user_id'] = $id;

        }

        $this->UserPermission->saveMany($permission);
      }

      $response = array(

        'ok' => true, 

        'msg' => 'updated.',

        'data' => $this->request->data,

      );
    
    } else {

      $response = array(

        'ok' => false, 

        'msg' => 'not updated.',

        'data' => $this->request->data,

      ); 

    }     

    $this->set(array(

      'response'=>$response,

      '_serialize'=>'response'

    ));      
    
  }

  public function delete ($id = null) {

    if($this->User->hide($id)) {

      $response = array(

        'ok' => true, 

        'msg' => 'deleted.',

        'data' => $this->request->data,

      );

    } else {

      $response = array(

        'ok' => false, 

        'msg' => 'not deleted.',

        'data' => $this->request->data,

      );           

    }

    $this->set(array(

      'response'=>$response,

      '_serialize'=>'response'

    ));    

  }

}

