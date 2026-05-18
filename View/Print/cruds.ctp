<!DOCTYPE html>
<html>
<head>
  <title>CRUDS - Print Index</title>
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
    .table > thead > tr > th,
    .table > tbody > tr > td { font-size: 11px !important; padding: 4px 6px; }
    .label-warning    { background-color: #f0ad4e !important; color: #fff !important; }
    .label-success    { background-color: #5cb85c !important; color: #fff !important; }
    .label-danger     { background-color: #d9534f !important; color: #fff !important; }
    @media print {
      body { background: white; }
      page[size="Letter"] { box-shadow: none; margin: 0; }
      .no-print { display: none !important; }
    }
  </style>
</head>
<body>
<page size="Letter">

  <div class="text-center" style="margin-bottom:20px;">
    <h3 style="margin:0">EDNC SYSTEM</h3>
    <h4 style="margin:0">
      CRUDS INDEX
      <?php if (!empty($filterLabel)): ?>
        &mdash; <?php echo htmlspecialchars($filterLabel); ?>
      <?php endif; ?>
    </h4>
    <small>Printed: <?php echo date('m/d/Y h:i A'); ?></small>
  </div>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th style="width:30px">#</th>
        <th>NAME</th>
        <th>EMAIL</th>
        <th>BIRTH DATE</th>
        <th>AGE</th>
        <th style="width:100px">STATUS</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($cruds)): ?>
        <?php $i = 1; foreach ($cruds as $row): ?>
          <tr>
            <td><?php echo $i++; ?></td>
            <td class="uppercase"><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['email'] ?? '—'); ?></td>
            <td><?php echo htmlspecialchars($row['birthDate']); ?></td>
            <td><?php echo htmlspecialchars($row['age']); ?></td>
            <td>
              <?php
                $status = !empty($row['status']) ? $row['status'] : 'PENDING';
                $cls    = ($status === 'APPROVED') ? 'success' : (($status === 'DISAPPROVED') ? 'danger' : 'warning');
              ?>
              <span class="label label-<?php echo $cls; ?>"><?php echo $status; ?></span>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr><td colspan="6" class="text-center">No records found.</td></tr>
      <?php endif; ?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="6" class="text-right"><strong>Total Records: <?php echo count($cruds); ?></strong></td>
      </tr>
    </tfoot>
  </table>

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
