<!DOCTYPE html>
<html>
<head>
  <title>Trial Balances Report</title>
  <link rel="stylesheet" href="<?php echo $this->base ?>/assets/plugins/bootstrap-3.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo $this->base ?>/assets/css/style.css">
</head>
<body>
  <div class="col-md-12">
    <div class="text-center uppercase" style=""></div>
    <div class="text-center" style="padding:5px 0px">TRIAL BALANCE</div>
    <div class="text-center" style="padding:0px 0px 20px 0px"><?php echo fdate($trial['endDate'],'F d, Y') ?></div>
  </div>

  <div class="col-md-12">
    <table class="table table-bordered table-striped table-hover">
      <thead>
        <tr>
          <th class="text-center">ACCOUNT NAME</th>
          <th class="text-center" style="width:120px">DEBIT</th>
          <th class="text-center" style="width:120px">CREDIT</th>
        </tr>
      </thead>
      <tbody>

        <?php foreach($trial['result']['assets'] as $entry): ?>

        <tr>
          <td class="uppercase"><?php echo $entry['Account']['name'] ?></td>
          <td class="text-right"><?php echo $entry[0]['total'] > 0? (fnumber($entry[0]['total'])):'('.fnumber(abs($entry[0]['total'])).')' ?></td>
          <td class="text-right"></td>
        </tr>
        <?php endforeach ?>
        <?php foreach($trial['result']['liabilities'] as $entry): ?>
        <tr>
          <td class="uppercase"><?php echo $entry['Account']['name'] ?></td>
          <td class="text-right"></td>
          <td class="text-right"><?php echo $entry[0]['total'] > 0? (fnumber($entry[0]['total'])):'('.fnumber(abs($entry[0]['total'])).')' ?></td>
        </tr>
        <?php endforeach ?>
        <?php foreach($trial['result']['equities'] as $entry): ?>
        <tr>
          <td class="uppercase"><?php echo $entry['Account']['name'] ?></td>
          <td class="text-right"></td>
          <td class="text-right"><?php echo $entry[0]['total'] > 0? (fnumber($entry[0]['total'])):'('.fnumber(abs($entry[0]['total'])).')' ?></td>
        </tr>
        <?php endforeach ?>
        <?php foreach($trial['result']['revenues'] as $entry): ?>
        <tr>
          <td class="uppercase"><?php echo $entry['Account']['name'] ?></td>
          <td class="text-right"></td>
          <td class="text-right"><?php echo $entry[0]['total'] > 0? (fnumber($entry[0]['total'])):'('.fnumber(abs($entry[0]['total'])).')' ?></td>
        </tr>
        <?php endforeach ?>
        <?php foreach($trial['result']['expenses'] as $entry): ?>
        <tr>
          <td class="uppercase"><?php echo $entry['Account']['name'] ?></td>
          <td class="text-right"><?php echo $entry[0]['total'] > 0? (fnumber($entry[0]['total'])):'('.fnumber(abs($entry[0]['total'])).')' ?></td>
          <td class="text-right"></td>
        </tr>
        <?php endforeach ?>
      </tbody>
      <tfoot>
        <tr>
          <th class="text-right">TOTAL</th>
          <th class="text-right"><?php echo $trial['debit'] > 0 ? (fnumber($trial['debit'])):'('+fnumber(abs($trial['debit']))+')'?></th>
          <th class="text-right"><?php echo $trial['credit'] > 0 ? (fnumber($trial['credit'])):'('+fnumber(abs($trial['credit']))+')'?></th>
        </tr>
      </tfoot>
    </table>
  </div>
</body>
</html>



