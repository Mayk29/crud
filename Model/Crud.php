<?php
App::uses('AppModel', 'Model');

class Crud extends AppModel {

  public $recursive = -1;
  public $actsAs    = array('Containable');

  // PAGINATE - custom SQL query with search, advance search, and tab filter
  public function getAllCruds($conditions = array()) {
    $search        = @$conditions['search'];
    $searchName    = @$conditions['searchName'];
    $searchAge     = @$conditions['searchAge'];
    $searchStatus  = @$conditions['searchStatus'];
    $tabStatus     = @$conditions['tabStatus'];

    $where = "Crud.visible = 1";

    // Simple keyword search (includes email)
    if (!empty($search)) {
      $where .= " AND (Crud.name LIKE '%$search%' OR Crud.age LIKE '%$search%' OR Crud.email LIKE '%$search%')";
    }

    // Advance search filters
    if (!empty($searchName)) {
      $where .= " AND Crud.name LIKE '%$searchName%'";
    }
    if (!empty($searchAge)) {
      $where .= " AND Crud.age LIKE '%$searchAge%'";
    }

    // Status filter: tab filter takes priority over advance search status
    $activeStatus = !empty($tabStatus) ? $tabStatus : $searchStatus;
    if (!empty($activeStatus)) {
      $where .= " AND IFNULL(CrudStatus.name, 'PENDING') = '$activeStatus'";
    }

    return "SELECT
        Crud.*,
        IFNULL(CrudStatus.name, 'PENDING') AS status
      FROM cruds AS Crud
      LEFT JOIN crud_statuses AS CrudStatus ON CrudStatus.id = Crud.crud_status_id
      WHERE $where
      GROUP BY Crud.id
      ORDER BY Crud.id ASC
    ";
  }

  public function countAllCruds($conditions = array()) {
    $search        = @$conditions['search'];
    $searchName    = @$conditions['searchName'];
    $searchAge     = @$conditions['searchAge'];
    $searchStatus  = @$conditions['searchStatus'];
    $tabStatus     = @$conditions['tabStatus'];

    $where = "Crud.visible = 1";

    if (!empty($search)) {
      $where .= " AND (Crud.name LIKE '%$search%' OR Crud.age LIKE '%$search%' OR Crud.email LIKE '%$search%')";
    }
    if (!empty($searchName)) {
      $where .= " AND Crud.name LIKE '%$searchName%'";
    }
    if (!empty($searchAge)) {
      $where .= " AND Crud.age LIKE '%$searchAge%'";
    }
    $activeStatus = !empty($tabStatus) ? $tabStatus : $searchStatus;
    if (!empty($activeStatus)) {
      $where .= " AND IFNULL(CrudStatus.name, 'PENDING') = '$activeStatus'";
    }

    return "SELECT COUNT(*) AS total
      FROM cruds AS Crud
      LEFT JOIN crud_statuses AS CrudStatus ON CrudStatus.id = Crud.crud_status_id
      WHERE $where
    ";
  }

  public function paginate($conditions, $fields, $order, $limit, $page = 1, $recursive = null, $extra = array()) {
    $this->useTable = false;
    $sql  = $this->getAllCruds($extra['extra']['conditions']);
    $sql .= 'LIMIT ' . (($page - 1) * $limit) . ', ' . $limit;
    return $this->query($sql);
  }

  public function paginateCount($conditions = null, $recursive = 0, $extra = array()) {
    $sql     = $this->countAllCruds($extra['extra']['conditions']);
    $results = $this->query($sql);
    return $results[0][0]['total'];
  }

  public $hasMany = array(
    'Beneficiary' => array(
      'className'  => 'Beneficiary',
      'foreignKey' => 'crud_id',
      'dependent'  => true
    )
  );

  public $belongsTo = array(
    'CrudStatus' => array(
      'className'  => 'CrudStatus',
      'foreignKey' => 'crud_status_id',
    )
  );

}