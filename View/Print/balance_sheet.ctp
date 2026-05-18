<!DOCTYPE html>
<html>
<head>
  <title>Balance Sheet</title>
  <link rel="stylesheet" href="<?php echo $this->base ?>/assets/plugins/bootstrap-3.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo $this->base ?>/assets/css/style.css">
</head>
<body>
  <div class="row">
    <div class="col-md-12">    
      <div class="text-center" style=""></div>
      <div class="text-center" style="padding:20px 0px"><?php echo $bal['company'] ?>  - BALANCE SHEET</div>
      <div class="text-center" style="padding:0px 0px 20px 0px"><?php echo date('F d - ',strtotime($bal['startDate'])) . date('F d, Y',strtotime($bal['endDate'])) ?></div>
    </div>

    <div class="col-md-10 col-md-offset-1">
          <table class="table table-bordered">
            <tbody>
              <tr class="bg-primary">
                <th class="text-center">ASSETS</th>
                <th style="width:120px"></th>
              </tr>

              <?php foreach($bal['result']['assets'] as $entry): ?>

              <tr>
                <td><?php echo $entry['Account']['name'] ?></td>
                <td class="text-right"><?php echo $entry[0]['total'] > 0? number_format($entry[0]['total'],2):'('.number_format(abs($entry[0]['total']),2).')'?>
              </tr>

              <?php endforeach ?>

              <tr class="darken">
                <th>TOTAL ASSETS</th>
                <th class="text-right"><?php echo $bal['total']['assets'] > 0 ? number_format($bal['total']['assets'],2):'('.number_format(abs($bal['total']['assets']),2).')'?>
                </th>
              </tr>
              <tr>
                <td colspan="2" style="height:50px"></td>
              </tr>
            </tbody>
            
            <tbody>
              <tr class="bg-primary">
                <th class="text-center">LIABILITIES</th>
                <th></th>
              </tr>

              <?php foreach($bal['result']['liabilities'] as $entry): ?>

              <tr>
                <td><?php echo $entry['Account']['name'] ?></td>
                <td class="text-right"><?php echo $entry[0]['total'] > 0? number_format($entry[0]['total'],2):'('.number_format(abs($entry[0]['total']),2).')'?>
              </tr>

              <?php endforeach ?>

              <tr class="bg-success">
                <th>TOTAL LIABILITIES</th>
                <th class="text-right"><?php echo $bal['total']['liabilities'] > 0 ? number_format($bal['total']['liabilities'],2):'('.number_format(abs($bal['total']['liabilities']),2).')'?>
                </th>
              </tr>
              <tr>
                <td colspan="2" style="height:20px"></td>
              </tr>
            </tbody>

            <tbody>
              <tr class="bg-primary">
                <th class="text-center">EQUITIES</th>
                <th></th>
              </tr>

              <?php foreach($bal['result']['equities'] as $entry): ?>

              <tr>
                <td><?php echo $entry['Account']['name'] ?></td>
                <td class="text-right"><?php echo $entry[0]['total'] > 0? number_format($entry[0]['total'],2):'('.number_format(abs($entry[0]['total']),2).')'?>
              </tr>

              <?php endforeach ?>

              <tr>
              <td>NET INCOME</td>
              <td class="text-right"><?php echo $bal['total']['netIncome'] > 0 ? number_format($bal['total']['netIncome'],2):'('.number_format(abs($bal['total']['netIncome']),2).')'?></td>
              </tr>
              <tr class="bg-success">
                <th>TOTAL EQUITY</th>
                <th class="text-right"><?php echo $bal['total']['equities'] > 0 ? number_format($bal['total']['equities'],2):'('.number_format(abs($bal['total']['equities']),2).')'?>
                </th>
              </tr>
            </tbody>
            
            <tbody>
              <tr class="darken">
                <th>TOTAL LIABILITIES AND EQUITY</th>
                <th class="text-right"><?php echo $bal['total']['liabilitiesAndEquity'] > 0 ? number_format($bal['total']['liabilitiesAndEquity'],2):'('.number_format(abs($bal['total']['liabilitiesAndEquity']),2).')'?>  
              </tr>
            </tbody>
          </table>
        </div>
  </div>
</body>
</html>



