<?php
class PrintController extends AppController {
  public $uses = array('Crud');
  public $layout = null;

  // Print CRUDS index 
  // GET /print/cruds?search=&searchName=&searchAge=&searchStatus=&tabStatus=
  public function cruds() {
    $conditions = array(
      'search'       => isset($this->request->query['search'])       ? $this->request->query['search']       : '',
      'searchName'   => isset($this->request->query['searchName'])   ? $this->request->query['searchName']   : '',
      'searchAge'    => isset($this->request->query['searchAge'])    ? $this->request->query['searchAge']    : '',
      'searchStatus' => isset($this->request->query['searchStatus']) ? $this->request->query['searchStatus'] : '',
      'tabStatus'    => isset($this->request->query['tabStatus'])    ? $this->request->query['tabStatus']    : '',
    );

    $sql  = $this->Crud->getAllCruds($conditions);
    $rows = $this->Crud->query($sql);

    $cruds = array();
    foreach ($rows as $row) {
      $cruds[] = array(
        'id'        => $row['Crud']['id'],
        'name'      => $row['Crud']['name'],
        'birthDate' => $row['Crud']['birthDate'],
        'age'       => $row['Crud']['age'],
        'status'    => isset($row[0]['status']) ? $row[0]['status'] : 'PENDING',
      );
    }

    // Filter label for the print header
    $filterLabel = '';
    if (!empty($conditions['tabStatus'])) {
      $filterLabel = $conditions['tabStatus'] . ' Records';
    } elseif (!empty($conditions['searchStatus'])) {
      $filterLabel = 'Status: ' . $conditions['searchStatus'];
    }
    if (!empty($conditions['searchName'])) {
      $filterLabel .= ($filterLabel ? ' | ' : '') . 'Name: ' . $conditions['searchName'];
    }
    if (!empty($conditions['searchAge'])) {
      $filterLabel .= ($filterLabel ? ' | ' : '') . 'Age: ' . $conditions['searchAge'];
    }
    if (!empty($conditions['search'])) {
      $filterLabel .= ($filterLabel ? ' | ' : '') . 'Search: "' . $conditions['search'] . '"';
    }

    $this->set('cruds', $cruds);
    $this->set('filterLabel', $filterLabel);
  }

}