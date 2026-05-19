<?php

// ── Shared PDF base class (header + footer on every page) ────────────────────
require_once(dirname(__FILE__) . '/Api/fpdf/fpdf.php');

class EdncPDF extends FPDF {

  public $docTitle    = 'EDNC SYSTEM';
  public $docSubtitle = '';

  function Header() {
    // Logo
    // $this->Image(APP . 'webroot/assets/img/mcp.jpg', 14, 10, 14);

    // Title block
    $this->SetFont('Helvetica', 'B', 14);
    $this->SetTextColor(30, 50, 80);
    $this->Cell(0, 7, $this->docTitle, 0, 1, 'C');

    $this->SetFont('Helvetica', 'B', 11);
    $this->Cell(0, 6, $this->docSubtitle, 0, 1, 'C');

    $this->SetFont('Helvetica', '', 8);
    $this->SetTextColor(120, 120, 120);
    $this->Cell(0, 5, 'Printed: ' . date('m/d/Y h:i A'), 0, 1, 'C');

    // Divider line
    $this->SetDrawColor(30, 50, 80);
    $this->SetLineWidth(0.4);
    $this->Line(14, $this->GetY() + 2, 196, $this->GetY() + 2);
    $this->Ln(6);

    // Reset colors for body
    $this->SetTextColor(0, 0, 0);
    $this->SetDrawColor(180, 180, 180);
    $this->SetLineWidth(0.2);
  }

  function Footer() {
    $this->SetY(-14);
    $this->SetFont('Helvetica', 'I', 8);
    $this->SetTextColor(150, 150, 150);
    $this->Cell(0, 5, 'Page ' . $this->PageNo() . ' of {nb}', 0, 0, 'C');
  }

  // Sanitize UTF-8 string to Latin-1 safe for FPDF (strips/replaces non-Latin-1 chars)
  function s($str) {
    return iconv('UTF-8', 'ISO-8859-1//TRANSLIT//IGNORE', (string)$str);
  }

  // Draw a colored section heading with a left accent bar
  function SectionTitle($label) {
    $this->Ln(3);
    $this->SetFillColor(30, 50, 80);
    $this->Rect($this->GetX(), $this->GetY(), 3, 6, 'F');
    $this->SetX($this->GetX() + 5);
    $this->SetFont('Helvetica', 'B', 10);
    $this->SetTextColor(30, 50, 80);
    $this->Cell(0, 6, $label, 0, 1, 'L');
    $this->SetTextColor(0, 0, 0);
    $this->Ln(2);
  }

  // Draw a standard table header row (navy bg, white text)
  function TableHeader($cols) {
    $this->SetFont('Helvetica', 'B', 9);
    $this->SetFillColor(30, 50, 80);
    $this->SetTextColor(255, 255, 255);
    $this->SetDrawColor(30, 50, 80);
    foreach ($cols as $col) {
      $this->Cell($col['w'], 7, $col['label'], 1, 0, isset($col['align']) ? $col['align'] : 'C', true);
    }
    $this->Ln();
    // Reset for data rows
    $this->SetDrawColor(180, 180, 180);
    $this->SetTextColor(0, 0, 0);
  }

  // Status badge cell — colored fill matching status
  function StatusCell($w, $h, $status) {
    if ($status === 'APPROVED') {
      $this->SetFillColor(92, 184, 92);
    } elseif ($status === 'DISAPPROVED') {
      $this->SetFillColor(217, 83, 79);
    } else {
      $this->SetFillColor(240, 173, 78);
    }
    $this->SetTextColor(255, 255, 255);
    $this->SetFont('Helvetica', 'B', 8);
    $this->Cell($w, $h, $status, 1, 0, 'C', true);
    $this->SetFillColor(255, 255, 255);
    $this->SetTextColor(0, 0, 0);
    $this->SetFont('Helvetica', '', 9);
  }
}


// ── Controller ───────────────────────────────────────────────────────────────
class PrintController extends AppController {
  public $uses   = array('Crud', 'Beneficiary');
  public $layout = null;


  // ── CRUDS INDEX ─────────────────────────────────────────────────────────────
  // GET /print/cruds?search=&searchName=&searchAge=&searchStatus=&tabStatus=
  public function cruds() {

    // ── 1. Fetch data (same logic as before) ──────────────────────────────────
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
        'email'     => $row['Crud']['email'],
        'birthDate' => $row['Crud']['birthDate'],
        'age'       => $row['Crud']['age'],
        'status'    => isset($row[0]['status']) ? $row[0]['status'] : 'PENDING',
      );
    }

    // Build filter label for subtitle
    $filterLabel = '';
    if (!empty($conditions['tabStatus']))    $filterLabel  = $conditions['tabStatus'] . ' Records';
    elseif (!empty($conditions['searchStatus'])) $filterLabel = 'Status: ' . $conditions['searchStatus'];
    if (!empty($conditions['searchName']))   $filterLabel .= ($filterLabel ? ' | ' : '') . 'Name: '   . $conditions['searchName'];
    if (!empty($conditions['searchAge']))    $filterLabel .= ($filterLabel ? ' | ' : '') . 'Age: '    . $conditions['searchAge'];
    if (!empty($conditions['search']))       $filterLabel .= ($filterLabel ? ' | ' : '') . 'Search: "' . $conditions['search'] . '"';

    // ── 2. Build PDF ──────────────────────────────────────────────────────────
    $pdf = new EdncPDF('P', 'mm', 'Letter');
    $pdf->AliasNbPages();
    $pdf->docTitle    = 'EDNC SYSTEM';
    $pdf->docSubtitle = $pdf->s('CRUDS INDEX' . ($filterLabel ? '  -  ' . $filterLabel : ''));
    $pdf->SetMargins(14, 14, 14);
    $pdf->SetAutoPageBreak(true, 18);
    $pdf->AddPage();

    // Table header columns
    $cols = array(
      array('w' => 10,  'label' => '#'),
      array('w' => 42,  'label' => 'NAME',       'align' => 'L'),
      array('w' => 62,  'label' => 'EMAIL',       'align' => 'L'),
      array('w' => 28,  'label' => 'BIRTH DATE'),
      array('w' => 12,  'label' => 'AGE'),
      array('w' => 28,  'label' => 'STATUS'),
    );
    $pdf->TableHeader($cols);

    // Data rows
    $pdf->SetFont('Helvetica', '', 9);
    $i = 1;
    foreach ($cruds as $row) {
      $zebra = ($i % 2 === 0);
      $pdf->SetFillColor($zebra ? 248 : 255, $zebra ? 248 : 255, $zebra ? 248 : 255);

      $status    = !empty($row['status']) ? $row['status'] : 'PENDING';
      $birthDate = !empty($row['birthDate']) ? date('m/d/Y', strtotime($row['birthDate'])) : '-';

      $pdf->Cell(10, 7, $i++,                            1, 0, 'C', $zebra);
      $pdf->Cell(42, 7, $pdf->s(strtoupper($row['name'])),        1, 0, 'L', $zebra);
      $pdf->Cell(62, 7, $pdf->s($row['email'] ?: '-'),   1, 0, 'L', $zebra);
      $pdf->Cell(28, 7, $birthDate,                      1, 0, 'C', $zebra);
      $pdf->Cell(12, 7, $row['age'],                     1, 0, 'C', $zebra);
      $pdf->StatusCell(28, 7, $status);
      $pdf->Ln();
    }

    // Total row
    $pdf->SetFont('Helvetica', 'B', 9);
    $pdf->SetFillColor(240, 240, 240);
    $pdf->Cell(154, 7, 'Total Records: ' . count($cruds), 1, 0, 'R', true);
    $pdf->Cell(28,  7, '',                                1, 1, 'C', true);

    // ── 3. Stream to browser ──────────────────────────────────────────────────
    $this->autoRender = false;
    $pdf->Output('I', 'cruds_index.pdf');
    exit;
  }


  // ── CRUD VIEW (single record + beneficiaries) ────────────────────────────────
  // GET /print/crud_view/1
  public function crud_view($id = null) {

    // ── 1. Fetch data ─────────────────────────────────────────────────────────
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
      'birthDate'   => !empty($crud['Crud']['birthDate']) ? date('m/d/Y', strtotime($crud['Crud']['birthDate'])) : '-',
      'age'         => (int) $crud['Crud']['age'],
      'status'      => $status,
      'created'     => date('m/d/Y', strtotime($crud['Crud']['created'])),
      'Beneficiary' => $crud['Beneficiary'],
    );

    // ── 2. Build PDF ──────────────────────────────────────────────────────────
    $pdf = new EdncPDF('P', 'mm', 'Letter');
    $pdf->AliasNbPages();
    $pdf->docTitle    = 'EDNC SYSTEM';
    $pdf->docSubtitle = 'CRUD RECORD';
    $pdf->SetMargins(14, 14, 14);
    $pdf->SetAutoPageBreak(true, 18);
    $pdf->AddPage();

    // ── Record details section ────────────────────────────────────────────────
    $pdf->SectionTitle('RECORD DETAILS');

    $labelW = 38;
    $valueW = 144;
    $rowH   = 8;

    $pdf->SetFont('Helvetica', 'B', 9);
    $pdf->SetFillColor(245, 245, 245);

    $fields = array(
      'ID'           => $data['id'],
      'Name'         => strtoupper($data['name']),
      'Email'        => $pdf->s($data['email'] ?: '-'),
      'Birth Date'   => $data['birthDate'],
      'Age'          => $data['age'],
      'Date Created' => $data['created'],
    );

    foreach ($fields as $label => $value) {
      // Label cell
      $pdf->SetFont('Helvetica', 'B', 9);
      $pdf->SetFillColor(245, 245, 245);
      $pdf->Cell($labelW, $rowH, $label, 1, 0, 'L', true);
      // Value cell
      $pdf->SetFont('Helvetica', '', 9);
      $pdf->SetFillColor(255, 255, 255);
      $pdf->Cell($valueW, $rowH, $value, 1, 1, 'L', false);
    }

    // Status row (colored badge)
    $pdf->SetFont('Helvetica', 'B', 9);
    $pdf->SetFillColor(245, 245, 245);
    $pdf->Cell($labelW, $rowH, 'Status', 1, 0, 'L', true);
    $pdf->StatusCell($valueW, $rowH, $data['status']);
    $pdf->Ln();

    // ── Beneficiaries section ─────────────────────────────────────────────────
    $pdf->SectionTitle('BENEFICIARIES');

    $benCols = array(
      array('w' => 10,  'label' => '#'),
      array('w' => 90,  'label' => 'NAME',       'align' => 'L'),
      array('w' => 36,  'label' => 'BIRTH DATE'),
      array('w' => 16,  'label' => 'AGE'),
    );
    $pdf->TableHeader($benCols);

    $pdf->SetFont('Helvetica', '', 9);

    if (!empty($data['Beneficiary'])) {
      $j = 1;
      foreach ($data['Beneficiary'] as $ben) {
        $zebra     = ($j % 2 === 0);
        $benDate   = !empty($ben['birthDate']) ? date('m/d/Y', strtotime($ben['birthDate'])) : '-';
        $pdf->SetFillColor($zebra ? 248 : 255, $zebra ? 248 : 255, $zebra ? 248 : 255);
        $pdf->Cell(10, 7, $j++,                       1, 0, 'C', $zebra);
        $pdf->Cell(90, 7, $pdf->s(strtoupper($ben['name'])),   1, 0, 'L', $zebra);
        $pdf->Cell(36, 7, $benDate,                   1, 0, 'C', $zebra);
        $pdf->Cell(16, 7, $ben['age'],                1, 1, 'C', $zebra);
      }
    } else {
      $pdf->SetTextColor(150, 150, 150);
      $pdf->Cell(152, 7, 'No beneficiaries on record.', 1, 1, 'C');
      $pdf->SetTextColor(0, 0, 0);
    }

    // Total row
    $pdf->SetFont('Helvetica', 'B', 9);
    $pdf->SetFillColor(240, 240, 240);
    $total = count($data['Beneficiary']);
    $pdf->Cell(152, 7, 'Total Beneficiaries: ' . $total, 1, 1, 'R', true);

    // ── 3. Stream to browser ──────────────────────────────────────────────────
    $this->autoRender = false;
    $pdf->Output('I', 'crud_record_' . $data['id'] . '.pdf');
    exit;
  }

}