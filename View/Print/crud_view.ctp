<!DOCTYPE html>
<html>
<head>
  <title>CRUD - Print View</title>
  <link rel="stylesheet" href="<?php echo $this->base ?>/assets/plugins/bootstrap-3.2/css/bootstrap.min.css">
  <style type="text/css">
    body { font-family: Arial, sans-serif; font-size: 12px; background: gray; }
    page[size="Letter"] {
      background: white;
      width: 8.5in;
      min-height: 11in;
      display: block;
      margin: 0 auto;
      box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
      padding: 0.5in;
    }
    .info-table > tbody > tr > th { width: 160px; background-color: #f5f5f5; }
    .info-table > tbody > tr > th,
    .info-table > tbody > tr > td { font-size: 12px !important; padding: 6px 10px; vertical-align: middle; }
    .table > thead > tr > th,
    .table > tbody > tr > td { font-size: 11px !important; padding: 4px 6px; }
    .label-warning  { background-color: #f0ad4e !important; color: #fff !important; }
    .label-success  { background-color: #5cb85c !important; color: #fff !important; }
    .label-danger   { background-color: #d9534f !important; color: #fff !important; }
    .section-title  { font-size: 13px; font-weight: bold; margin: 20px 0 8px; border-bottom: 2px solid #337ab7; padding-bottom: 4px; color: #337ab7; }
    @media print {
      body { background: white; }
      page[size="Letter"] { box-shadow: none; margin: 0; }
      .no-print { display: none !important; }
    }
  </style>
</head>
<body>
<page size="Letter">

  <!-- Header -->
  <div class="text-center" style="margin-bottom:24px;">
    <h3 style="margin:0;">EDNC SYSTEM</h3>
    <h4 style="margin:4px 0;">CRUD RECORD</h4>
    <small>Printed: <?php echo date('m/d/Y h:i A'); ?></small>
  </div>

  <!-- CRUD Details -->
  <div class="section-title"><i class="glyphicon glyphicon-user"></i> RECORD DETAILS</div>

  <table class="table table-bordered info-table">
    <tbody>
      <tr>
        <th>ID</th>
        <td><?php echo htmlspecialchars($crud['id']); ?></td>
      </tr>
      <tr>
        <th>Name</th>
        <td class="uppercase"><strong><?php echo htmlspecialchars($crud['name']); ?></strong></td>
      </tr>
      <tr>
        <th>Email</th>
        <td><?php echo htmlspecialchars($crud['email'] ?: '—'); ?></td>
      </tr>
      <tr>
        <th>Birth Date</th>
        <td><?php echo htmlspecialchars($crud['birthDate']); ?></td>
      </tr>
      <tr>
        <th>Age</th>
        <td><?php echo htmlspecialchars($crud['age']); ?></td>
      </tr>
      <tr>
        <th>Status</th>
        <td>
          <?php
            $status = !empty($crud['status']) ? $crud['status'] : 'PENDING';
            $cls    = ($status === 'APPROVED') ? 'success' : (($status === 'DISAPPROVED') ? 'danger' : 'warning');
          ?>
          <span class="label label-<?php echo $cls; ?>" style="font-size:11px; padding:3px 8px;">
            <?php echo $status; ?>
          </span>
        </td>
      </tr>
      <tr>
        <th>Date Created</th>
        <td><?php echo htmlspecialchars($crud['created']); ?></td>
      </tr>
    </tbody>
  </table>

  <!-- Beneficiaries -->
  <div class="section-title"><i class="glyphicon glyphicon-heart"></i> BENEFICIARIES</div>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th style="width:30px;">#</th>
        <th>NAME</th>
        <th style="width:120px;">BIRTH DATE</th>
        <th style="width:60px;">AGE</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($crud['Beneficiary'])): ?>
        <?php $i = 1; foreach ($crud['Beneficiary'] as $beneficiary): ?>
          <tr>
            <td><?php echo $i++; ?></td>
            <td class="uppercase"><?php echo htmlspecialchars($beneficiary['name']); ?></td>
            <td><?php echo htmlspecialchars($beneficiary['birthDate']); ?></td>
            <td><?php echo htmlspecialchars($beneficiary['age']); ?></td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="4" class="text-center text-muted">No beneficiaries on record.</td>
        </tr>
      <?php endif; ?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="4" class="text-right">
          <strong>Total Beneficiaries: <?php echo count($crud['Beneficiary']); ?></strong>
        </td>
      </tr>
    </tfoot>
  </table>

  <!-- Print Button -->
  <div class="text-right no-print" style="margin-top:20px;">
    <button onclick="window.print()" class="btn btn-primary btn-sm">
      <i class="glyphicon glyphicon-print"></i> PRINT
    </button>
  </div>

</page>

<script>
  window.onload = function() {
    setTimeout(function() { window.print(); }, 500);
  };
</script>
</body>
</html>
