<?php
class PrintController extends AppController {
  public $uses = array('Crud', 'Beneficiary');
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

  // Print CRUD view (single record + beneficiaries) — APPROVED only
  // GET /print/crud_view/1
  public function crud_view($id = null) {
    $crud = $this->Crud->find('first', array(
      'conditions' => array('Crud.id' => $id, 'Crud.visible' => true),
      'contain'    => array('Beneficiary', 'CrudStatus')
    ));

    if (!$crud) {
      throw new NotFoundException('Record not found.');
    }

    $status = !empty($crud['CrudStatus']['name']) ? $crud['CrudStatus']['name'] : 'PENDING';

    $data = array(
      'id'          => $crud['Crud']['id'],
      'name'        => $crud['Crud']['name'],
      'email'       => $crud['Crud']['email'],
      'birthDate'   => $crud['Crud']['birthDate'],
      'age'         => (int) $crud['Crud']['age'],
      'status'      => $status,
      'created'     => date('m/d/Y', strtotime($crud['Crud']['created'])),
      'Beneficiary' => $crud['Beneficiary'],
    );

    $this->set('crud', $data);
  }

}