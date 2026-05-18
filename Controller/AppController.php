<?php
class AppController extends Controller {
	 
  public $layout = null;

  public $components = array(
    'Session',
    'Auth' => array(
      'loginAction' => array(
        'controller' => 'main',
        'action'     => 'login'
      ),
      'logoutRedirect' => array(
        'controller' => 'main',
        'action'     => 'login'
      ),
      'authenticate' => array(
        'Form' => array(
          'scope' => array(
            'User.verified' => true,
            'User.visible'  => true,
            'User.active'   => true
          )
        ),
      )
    ),
    'Paginator',
    'RequestHandler',
    'Thumbnail',
    'Global'
  );
  
  public $uses = array('User');

	public function beforeFilter() {
		if($this->name == 'CakeError')
      $this->layout = 'error';

    $serverUrl = $this->serverUrl();
    $currentUser = array();
  
  if ($this->Session->check('Auth.User.id')) {
      // current user
      $currentUser = $this->User->find('first', array(
        'contain' => array(
          'Role'
        ),
        'conditions' => array(
          'User.id' => $this->Session->read('Auth.User.id')
        )
      ));
      
      // transform user permission
      // foreach ($currentUser['UserPermission'] as $k => $permission) {
      //   $currentUser['UserPermission'][$k] = $permission['Permission']['module'] .  '/' . $permission['Permission']['action'];
      // }
      
    }

    $this->set(compact('serverUrl','currentUser'));
	}

  public function serverUrl() {
    // check secure connection
    $secureConnection = false;
    if(isset($_SERVER['HTTPS']))
      if ($_SERVER['HTTPS'] == "on")
        $secureConnection = true;
    
    $secureConnection = $secureConnection? 'https':'http';
    $server = $secureConnection. '://'. $_SERVER['SERVER_NAME'].$this->base . '/';

    return $server;
  }

  public function fDate($str) {
    if (!empty($str))
      return date('m/d/Y', strtotime($str));
    else
      return null;
  }

  public function mDate($str) {
    if (!empty($str))
      return date('Y-m-d', strtotime($str));
    else
      return null;
  }

  public function rrmdir($dir) { 
   if (is_dir($dir)) {
     $objects = scandir($dir); 
     foreach ($objects as $object) { 
       if ($object != "." && $object != "..") { 
         if (filetype($dir."/".$object) == "dir")
          $this->rrmdir($dir."/".$object);
         else
          unlink($dir . "/" . $object); 
       } 
     } 
     reset($objects); 
     rmdir($dir); 
   } 
 }
		
}
