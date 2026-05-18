<!DOCTYPE html>
<html>
<head>
  <title>Payment Notifications Report</title>
  <link rel="stylesheet" href="<?php echo $this->base ?>/assets/plugins/bootstrap-3.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo $this->base ?>/assets/css/style.css">
</head>
<body>
   <div class="col-md-12">
    <div class="text-center uppercase" style="padding:20px 0px 0px 0px; font-size: 16px"><strong><?php echo $this->Global->Settings('cooperative_name') ?></strong></div>
    <div class="text-center uppercase" style="padding:0px 0px 20px 0px; font-size: 12px"><strong><?php echo $this->Global->Settings('address') ?></strong></div>
    <div class="text-center uppercase" style="padding:0px 0px 0px 0px; font-size: 16px"><strong><u>PAYMENT NOTIFICATIONS</u></strong></div>
    <div class="text-center" style="padding:0px 0px 20px 0px"><?php echo fdate($date,'F d, Y') ?></div>
  </div>

  <div class="col-md-12">
    <table class="table table-striped center">
      <thead>
        <tr>
          <th class="w30px"></th>
          <th>LOAN CODE </th>
          <th>NAME</th>
          <th>AMOUNT </th>
          <th>BALANCE </th>
          <th>DUE DATE </th>
          <th>PAST DUE DAY(S) </th>
        </tr>
      </thead>
      <tbody>
        <?php $ctr = 0; if (!empty($data) ) { foreach($data as $dat): ?>
        <tr>
          <td><?php echo $ctr +=1; ?></td>
          <td><?php echo $dat['code'] ?></td>
          <td class="uppercase text-left"><?php echo $dat['name'] ?></td>
          <td class="text-right"><?php echo number_format($dat['amount'],2) ?></td>
          <td class="text-right"><?php echo number_format($dat['balance'],2) ?></td>
          <td class="text-right"><?php echo date('m/d/Y',strtotime($dat['dueDate'])) ?></td>
          <td class="text-right"><?php echo $dat['totalDays'] ?></td>
        </tr>
        <?php endforeach; } ?>
        <?php if (empty($data)) { ?>
          <tr>
            <td colspan="7">No data available.</td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</body>
</html>



