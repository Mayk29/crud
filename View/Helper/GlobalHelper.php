<?php
App::uses('Helper', 'View');
App::uses('SessionHelper', 'View/Helper');
class GlobalHelper extends Helper {

	public $components = array('Session');
	  
    public function Settings($setting){
        $this->Setting = ClassRegistry::init('Setting');
        $data = $this->Setting->find('first', array(
			'conditions'=>array(
				'Setting.code'=>$setting
			)
		));
        if(count($data) > 0) {
            return $data['Setting']['value'];
        }
        else { return null; }
    }


  public function TotalArr($arrs = array(), $field){
    $total = 0;
    foreach($arrs as $arr){
      $total += $arr[$field];
    }
    return $total;
  }

}