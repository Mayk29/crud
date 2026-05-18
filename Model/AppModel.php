<?php
class AppModel extends Model {

  public $recursive = -1;
  
  public function truncate() {
    $table = $this->useTable;
    if ($this->query("TRUNCATE $table"))
      return true;
    else
      return false;
  }

  public function show ($id = null) {
    $this->id = $id;
    if ($this->save(array('visible' => true)))
      $result = true;
    else
      $result = false;
    return $result;
  }
  
  public function hide ($id = null) {
    $this->id = $id;
    if ($this->save(array('visible' => false)))
      $result = true;
    else
      $result = false;
    
    return $result;
  }

  public function hideAll ($id = null) {
    $this->id = $id;
    if ($this->save(array('visible' => false)))
      $result = true;
    else
      $result = false;
    return $result;
  }

  public function existing($arr = array()) {
    $res = false; $this->recursive = -1; $data = $this->find('all', array('conditions'=>$arr));
    if(count($data) > 0) { $res = true; } else { $res = false; } return $res;
  }

  public function nextId() {
    $table = $this->useTable;
    $query = $this->query("SHOW TABLE STATUS LIKE '$table'");
    $next = $query[0]['TABLES']['Auto_increment'];
    return $next;
  }

  public function generateId($code = null) {
    $data = $this->find('first', array(
      'conditions' => array(
        'code' => $code
      )
    ));
    return empty($data)? null : $data[$this->name]['id'];
  }

  public function generateCode($pad = 4) {
    return str_pad($this->nextId(), $pad, "0", STR_PAD_LEFT);
  }

  public function visible($id = null, $value = true){
    $result = false; $this->id = $id;
    if ($this->save(array('visible'=>$value))){ $result = true; } else { $result = false; }
    return $result;
  }

}
