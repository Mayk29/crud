<?php
class MainController extends AppController {
	
	public $layout = null;
	public $uses = array('User');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow(array(
			'login',
			'logout'
		));
	}
	
	public function index() {
		$base = $this->serverUrl();
		$api  = $this->serverUrl() . 'api/';
		$tmp  = $this->serverUrl() . 'template/';

		$this->set(compact(
			'base',
			'api',
			'tmp'
		));
	}
	
	public function login() {		
		// $this->User->save(array('id'=>1,'password'=>'password'));
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
			
				
				return $this->redirect(array(
				  'controller' => 'main',
				  'action'     => 'index'
        ));          
			}

		unset($this->request->data['User']['password']);

		} else {
			if ($this->Auth->loggedIn()) {
				return $this->redirect(array(
				  'controller' => 'main',
				   'action'    => 'index'
         ));
			}
		}
	}

	public function logout() {
				
		$this->Session->destroy();
		$this->Session->delete('Auth');
		return $this->redirect($this->Auth->logout());
	}
	
}