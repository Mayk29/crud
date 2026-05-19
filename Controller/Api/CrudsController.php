<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class CrudsController extends AppController {

  public $components = array('Paginator', 'RequestHandler');
  public $uses = array('Crud', 'CrudStatus', 'CrudFile');

  public function beforeFilter() {
    parent::beforeFilter();
    $this->RequestHandler->ext = 'json';
  }

  // PRIVATE HELPER: send email notification 
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

  // INDEX 
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

  // VIEW 
  // GET /api/cruds/1.json
  public function view($id = null) {
    $crud = $this->Crud->find('first', array(
      'conditions' => array('Crud.id' => $id, 'Crud.visible' => true),
      'contain'    => array('Beneficiary', 'CrudStatus', 'CrudFile')
    ));

    if (!$crud) {
      $response = array('ok' => false, 'msg' => 'Record not found.');
    } else {
      $status = !empty($crud['CrudStatus']['name']) ? $crud['CrudStatus']['name'] : 'PENDING';

      // Cast Beneficiary age fields to int (MySQL returns all columns as strings)
      $beneficiaries = array();
      if (!empty($crud['Beneficiary'])) {
        foreach ($crud['Beneficiary'] as $b) {
          $b['age'] = (int) $b['age'];
          $beneficiaries[] = $b;
        }
      }

      // Build files list with download URL
      $files = array();
      if (!empty($crud['CrudFile'])) {
        foreach ($crud['CrudFile'] as $f) {
          $files[] = array(
            'id'       => $f['id'],
            'original' => $f['original'],
            'size'     => $f['size'],
            'mime'     => $f['mime'],
            'created'  => date('m/d/Y', strtotime($f['created'])),
            'url'      => $this->request->base . '/uploads/crud_files/' . $f['filename'],
          );
        }
      }

      $response = array(
        'ok'   => true,
        'data' => array(
          'id'          => $crud['Crud']['id'],
          'name'        => $crud['Crud']['name'],
          'email'       => $crud['Crud']['email'],
          'birthDate'   => $crud['Crud']['birthDate'],
          'age'         => (int) $crud['Crud']['age'],
          'status'      => $status,
          'Beneficiary' => $beneficiaries,
          'CrudFile'    => $files,
        ),
      );
    }

    $this->set(array('response' => $response, '_serialize' => 'response'));
  }

  // ADD 
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

      $response = array('ok' => true, 'msg' => 'Record saved successfully.', 'id' => $crud_id);
    } else {
      $response = array('ok' => false, 'msg' => 'Could not save record.');
    }

    $this->set(array('response' => $response, '_serialize' => 'response'));
  }

  // EDIT 
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

  // PRINT INDEX 
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

  // DELETE 
  // DELETE /api/cruds/1.json
  public function delete($id = null) {
    if ($this->Crud->save(array('id' => $id, 'visible' => false))) {
      $response = array('ok' => true, 'msg' => 'Record deleted.');
    } else {
      $response = array('ok' => false, 'msg' => 'Could not delete record.');
    }

    $this->set(array('response' => $response, '_serialize' => 'response'));
  }

  // DELETE BENEFICIARY
  // DELETE /api/cruds/delete_beneficiary/1.json  (1 = beneficiary id)
  public function delete_beneficiary($id = null) {
    if (!$this->Crud->Beneficiary->exists($id)) {
      $response = array('ok' => false, 'msg' => 'Beneficiary not found.');
      $this->set(array('response' => $response, '_serialize' => 'response'));
      return;
    }

    if ($this->Crud->Beneficiary->delete($id)) {
      $response = array('ok' => true, 'msg' => 'Beneficiary deleted.');
    } else {
      $response = array('ok' => false, 'msg' => 'Could not delete beneficiary.');
    }

    $this->set(array('response' => $response, '_serialize' => 'response'));
  }

  public function api_delete_beneficiary($id = null) {
    return $this->delete_beneficiary($id);
  }

  // UPLOAD FILE
  // POST /api/cruds/upload_file/1.json
  public function upload_file($id = null) {
    // Verify the CRUD record exists
    $crud = $this->Crud->find('first', array(
      'conditions' => array('Crud.id' => $id, 'Crud.visible' => true),
      'contain'    => false
    ));

    if (!$crud) {
      $response = array('ok' => false, 'msg' => 'Record not found.');
      $this->set(array('response' => $response, '_serialize' => 'response'));
      return;
    }

    if (empty($_FILES['file'])) {
      $response = array('ok' => false, 'msg' => 'No file received.');
      $this->set(array('response' => $response, '_serialize' => 'response'));
      return;
    }

    $file = $_FILES['file'];

    if ($file['error'] !== UPLOAD_ERR_OK) {
      $response = array('ok' => false, 'msg' => 'File upload error (code ' . $file['error'] . ').');
      $this->set(array('response' => $response, '_serialize' => 'response'));
      return;
    }

    // 10 MB limit
    $maxSize = 10 * 1024 * 1024;
    if ($file['size'] > $maxSize) {
      $response = array('ok' => false, 'msg' => 'File exceeds 10 MB limit.');
      $this->set(array('response' => $response, '_serialize' => 'response'));
      return;
    }

    // Allowed MIME types
    $allowedMimes = array(
      'image/jpeg', 'image/png', 'image/gif', 'image/webp',
      'application/pdf',
      'application/msword',
      'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
      'application/vnd.ms-excel',
      'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
      'text/plain',
    );

    $mime = mime_content_type($file['tmp_name']);
    if (!in_array($mime, $allowedMimes)) {
      $response = array('ok' => false, 'msg' => 'File type not allowed.');
      $this->set(array('response' => $response, '_serialize' => 'response'));
      return;
    }

    // Prepare upload directory: webroot/uploads/crud_files/
    $uploadDir = WWW_ROOT . 'uploads' . DS . 'crud_files' . DS;
    if (!is_dir($uploadDir)) {
      mkdir($uploadDir, 0755, true);
    }

    // Generate unique filename preserving extension
    $ext      = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $stored   = uniqid('cf_') . ($ext ? '.' . $ext : '');
    $destPath = $uploadDir . $stored;

    if (!move_uploaded_file($file['tmp_name'], $destPath)) {
      $response = array('ok' => false, 'msg' => 'Could not save file to disk.');
      $this->set(array('response' => $response, '_serialize' => 'response'));
      return;
    }

    // Save record in DB
    $this->CrudFile->create();
    $saved = $this->CrudFile->save(array(
      'crud_id'  => $id,
      'filename' => $stored,
      'original' => $file['name'],
      'size'     => $file['size'],
      'mime'     => $mime,
    ));

    if ($saved) {
      $newFile = array(
        'id'       => $this->CrudFile->id,
        'original' => $file['name'],
        'size'     => $file['size'],
        'mime'     => $mime,
        'created'  => date('m/d/Y'),
        'url'      => $this->request->base . '/uploads/crud_files/' . $stored,
      );
      $response = array('ok' => true, 'msg' => 'File uploaded successfully.', 'file' => $newFile);
    } else {
      // Rollback the file on DB failure
      @unlink($destPath);
      $response = array('ok' => false, 'msg' => 'Could not save file record.');
    }

    $this->set(array('response' => $response, '_serialize' => 'response'));
  }

  // DELETE FILE
  // DELETE /api/cruds/delete_file/1.json  (1 = crud_file id)
  public function delete_file($id = null) {
    $crudFile = $this->CrudFile->find('first', array(
      'conditions' => array('CrudFile.id' => $id, 'CrudFile.visible' => true),
      'contain'    => false
    ));

    if (!$crudFile) {
      $response = array('ok' => false, 'msg' => 'File record not found.');
      $this->set(array('response' => $response, '_serialize' => 'response'));
      return;
    }

    // Soft-delete the record
    $saved = $this->CrudFile->save(array('id' => $id, 'visible' => false));

    if ($saved) {
      // Remove physical file
      $filePath = WWW_ROOT . 'uploads' . DS . 'crud_files' . DS . $crudFile['CrudFile']['filename'];
      if (file_exists($filePath)) {
        @unlink($filePath);
      }
      $response = array('ok' => true, 'msg' => 'File deleted.');
    } else {
      $response = array('ok' => false, 'msg' => 'Could not delete file.');
    }

    $this->set(array('response' => $response, '_serialize' => 'response'));
  }

  // Prefix-routing aliases so /api/cruds/upload_file/:id and
  // /api/cruds/delete_file/:id resolve correctly when 'api' is a
  // registered prefix in Routing.prefixes (CakePHP calls api_<action>).
  public function api_upload_file($id = null) {
    return $this->upload_file($id);
  }

  public function api_delete_file($id = null) {
    return $this->delete_file($id);
  }

}