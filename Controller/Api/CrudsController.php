<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class CrudsController extends AppController {

  public $components = array('Paginator', 'RequestHandler');
  public $uses = array('Crud', 'CrudStatus');

  public function beforeFilter() {
    parent::beforeFilter();
    $this->RequestHandler->ext = 'json';
  }

  // ─── PRIVATE HELPER: send email notification ────────────────────────────────
  private function _sendEmail($to, $subject, $message) {
    try {
      $Email = new CakeEmail('default'); 
      $Email->to($to)
            ->subject($subject)
            ->send($message);
      return true;
    } catch (Exception $e) {
      CakeLog::write('error', 'Email error: ' . $e->getMessage());
      return false;
    }
  }

  // ─── INDEX ──────────────────────────────────────────────────────────────────
  // GET /api/cruds.json?page=1&search=&searchName=&searchAge=&searchStatus=&tabStatus=
  public function index() {
    $page         = isset($this->request->query['page'])         ? $this->request->query['page']         : 1;
    $search       = isset($this->request->query['search'])       ? $this->request->query['search']       : '';
    $searchName   = isset($this->request->query['searchName'])   ? $this->request->query['searchName']   : '';
    $searchAge    = isset($this->request->query['searchAge'])    ? $this->request->query['searchAge']    : '';
    $searchStatus = isset($this->request->query['searchStatus']) ? $this->request->query['searchStatus'] : '';
    $tabStatus    = isset($this->request->query['tabStatus'])    ? $this->request->query['tabStatus']    : '';

    $conditions = array(
      'search'       => $search,
      'searchName'   => $searchName,
      'searchAge'    => $searchAge,
      'searchStatus' => $searchStatus,
      'tabStatus'    => $tabStatus,
    );

    $this->paginate = array(
      'Crud' => array(
        'limit' => 25,
        'page'  => $page,
        'extra' => array('conditions' => $conditions)
      )
    );

    $tmpData = $this->paginate('Crud');

    $data = array();
    if (!empty($tmpData)) {
      foreach ($tmpData as $row) {
        $data[] = array(
          'id'        => $row['Crud']['id'],
          'name'      => $row['Crud']['name'],
          'email'     => $row['Crud']['email'],
          'birthDate' => $row['Crud']['birthDate'],
          'age'       => $row['Crud']['age'],
          'status'    => isset($row[0]['status']) ? $row[0]['status'] : 'PENDING',
          'created'   => date('m/d/Y', strtotime($row['Crud']['created'])),
        );
      }
    }

    $response = array(
      'ok'        => true,
      'msg'       => 'index',
      'data'      => $data,
      'paginator' => $this->request->params['paging']['Crud'],
    );

    $this->set(array('response' => $response, '_serialize' => 'response'));
  }

  // ─── VIEW ───────────────────────────────────────────────────────────────────
  // GET /api/cruds/1.json
  public function view($id = null) {
    $crud = $this->Crud->find('first', array(
      'conditions' => array('Crud.id' => $id, 'Crud.visible' => true),
      'contain'    => array('Beneficiary', 'CrudStatus')
    ));

    if (!$crud) {
      $response = array('ok' => false, 'msg' => 'Record not found.');
    } else {
      $status = !empty($crud['CrudStatus']['name']) ? $crud['CrudStatus']['name'] : 'PENDING';
      $response = array(
        'ok'   => true,
        'data' => array(
          'id'          => $crud['Crud']['id'],
          'name'        => $crud['Crud']['name'],
          'email'       => $crud['Crud']['email'],
          'birthDate'   => $crud['Crud']['birthDate'],
          'age'         => (int) $crud['Crud']['age'],
          'status'      => $status,
          'Beneficiary' => $crud['Beneficiary'],
        ),
      );
    }

    $this->set(array('response' => $response, '_serialize' => 'response'));
  }

  // ─── ADD ────────────────────────────────────────────────────────────────────
  // POST /api/cruds.json
  public function add() {
    $data = $this->request->data['Crud'];

    // Validate email
    if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
      $response = array('ok' => false, 'msg' => 'Invalid email address.');
      $this->set(array('response' => $response, '_serialize' => 'response'));
      return;
    }

    // Default status = PENDING (id: 1)
    $pendingStatus = $this->CrudStatus->find('first', array(
      'conditions' => array('CrudStatus.name' => 'PENDING')
    ));
    $data['crud_status_id'] = !empty($pendingStatus) ? $pendingStatus['CrudStatus']['id'] : 1;

    $this->Crud->create();

    if ($this->Crud->save($data)) {
      $crud_id = $this->Crud->id;

      // Save beneficiaries
      if (!empty($this->request->data['Beneficiary'])) {
        foreach ($this->request->data['Beneficiary'] as $beneficiary) {
          $this->Crud->Beneficiary->create();
          $beneficiary['crud_id'] = $crud_id;
          $this->Crud->Beneficiary->save($beneficiary);
        }
      }

      // Send email notification if email provided
      if (!empty($data['email'])) {
        $subject = 'EDNC - New Record Created';
        $message = "Dear " . $data['name'] . ",\n\n"
                 . "Your record has been successfully created in the EDNC System.\n\n"
                 . "Details:\n"
                 . "  Name      : " . $data['name'] . "\n"
                 . "  Email     : " . $data['email'] . "\n"
                 . "  Birth Date: " . $data['birthDate'] . "\n"
                 . "  Age       : " . $data['age'] . "\n"
                 . "  Status    : PENDING\n\n"
                 . "Your record is currently pending for approval.\n\n"
                 . "Thank you,\nEDNC System";
        $this->_sendEmail($data['email'], $subject, $message);
      }

      $response = array('ok' => true, 'msg' => 'Record saved successfully.');
    } else {
      $response = array('ok' => false, 'msg' => 'Could not save record.');
    }

    $this->set(array('response' => $response, '_serialize' => 'response'));
  }

  // ─── EDIT ───────────────────────────────────────────────────────────────────
  // PUT /api/cruds/1.json
  // Also handles approve/disapprove when Crud.status_name is passed
  public function edit($id = null) {
    $data       = $this->request->data['Crud'];
    $data['id'] = $id;

    // Validate email if present
    if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
      $response = array('ok' => false, 'msg' => 'Invalid email address.');
      $this->set(array('response' => $response, '_serialize' => 'response'));
      return;
    }

    // Resolve status_name → crud_status_id (approve/disapprove flow)
    $statusName = null;
    if (!empty($data['status_name'])) {
      $statusName   = strtoupper($data['status_name']);
      $statusRecord = $this->CrudStatus->find('first', array(
        'conditions' => array('CrudStatus.name' => $statusName)
      ));
      if ($statusRecord) {
        $data['crud_status_id'] = $statusRecord['CrudStatus']['id'];
      }
      unset($data['status_name']);
    }

    if ($this->Crud->save($data)) {

      // Replace beneficiaries only when Beneficiary key is explicitly sent
      if (isset($this->request->data['Beneficiary'])) {
        $this->Crud->Beneficiary->deleteAll(array('Beneficiary.crud_id' => $id), false);
        foreach ($this->request->data['Beneficiary'] as $beneficiary) {
          $this->Crud->Beneficiary->create();
          $beneficiary['crud_id'] = $id;
          $this->Crud->Beneficiary->save($beneficiary);
        }
      }

      // Send email notification for approve/disapprove
      if ($statusName !== null) {
        $crud = $this->Crud->find('first', array(
          'conditions' => array('Crud.id' => $id),
          'contain'    => false
        ));

        if (!empty($crud['Crud']['email'])) {
          $recipientEmail = $crud['Crud']['email'];
          $recipientName  = $crud['Crud']['name'];

          if ($statusName === 'APPROVED') {
            $subject = 'EDNC - Record Approved';
            $message = "Dear " . $recipientName . ",\n\n"
                     . "We are pleased to inform you that your record has been APPROVED.\n\n"
                     . "Details:\n"
                     . "  Name  : " . $recipientName . "\n"
                     . "  Email : " . $recipientEmail . "\n"
                     . "  Status: APPROVED\n\n"
                     . "Thank you,\nEDNC System";
          } else {
            $subject = 'EDNC - Record Disapproved';
            $message = "Dear " . $recipientName . ",\n\n"
                     . "We regret to inform you that your record has been DISAPPROVED.\n\n"
                     . "Details:\n"
                     . "  Name  : " . $recipientName . "\n"
                     . "  Email : " . $recipientEmail . "\n"
                     . "  Status: DISAPPROVED\n\n"
                     . "For further inquiries, please contact us.\n\n"
                     . "Thank you,\nEDNC System";
          }

          $this->_sendEmail($recipientEmail, $subject, $message);
        }

        $msg = 'Record has been ' . $statusName . '.';
      } else {
        $msg = 'Record updated successfully.';
      }

      $response = array('ok' => true, 'msg' => $msg);
    } else {
      $response = array('ok' => false, 'msg' => 'Could not update record.');
    }

    $this->set(array('response' => $response, '_serialize' => 'response'));
  }

  // ─── PRINT INDEX ────────────────────────────────────────────────────────────
  // GET /api/cruds/print_index.json
  public function print_index() {
    $conditions = array(
      'search'       => isset($this->request->query['search'])       ? $this->request->query['search']       : '',
      'searchName'   => isset($this->request->query['searchName'])   ? $this->request->query['searchName']   : '',
      'searchAge'    => isset($this->request->query['searchAge'])    ? $this->request->query['searchAge']    : '',
      'searchStatus' => isset($this->request->query['searchStatus']) ? $this->request->query['searchStatus'] : '',
      'tabStatus'    => isset($this->request->query['tabStatus'])    ? $this->request->query['tabStatus']    : '',
    );

    $sql  = $this->Crud->getAllCruds($conditions);
    $rows = $this->Crud->query($sql);

    $data = array();
    foreach ($rows as $row) {
      $data[] = array(
        'id'        => $row['Crud']['id'],
        'name'      => $row['Crud']['name'],
        'email'     => $row['Crud']['email'],
        'birthDate' => $row['Crud']['birthDate'],
        'age'       => $row['Crud']['age'],
        'status'    => isset($row[0]['status']) ? $row[0]['status'] : 'PENDING',
      );
    }

    $response = array('ok' => true, 'data' => $data);
    $this->set(array('response' => $response, '_serialize' => 'response'));
  }

  // ─── DELETE ─────────────────────────────────────────────────────────────────
  // DELETE /api/cruds/1.json
  public function delete($id = null) {
    if ($this->Crud->save(array('id' => $id, 'visible' => false))) {
      $response = array('ok' => true, 'msg' => 'Record deleted.');
    } else {
      $response = array('ok' => false, 'msg' => 'Could not delete record.');
    }

    $this->set(array('response' => $response, '_serialize' => 'response'));
  }

}