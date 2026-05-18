<!DOCTYPE html>
<html>
<head>
  <title>Schedule of Savings and Time Deposits</title>
 <link rel="stylesheet" href="<?php echo $this->base ?>/assets/plugins/bootstrap-3.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo $this->base ?>/assets/css/style.css">
</head>
<body>
	<div class="col-md-12">    
    <div style="padding:20px 0px; font-weight: bold;" class = "text-center">CUPANG WEST MULTI-PURPOSE COOPERATIVE<br>Balanga City, Bataan<br></div>
    <div style = "padding: 20px 0px; font-weight: bold;" class = "text-center">SCHEDULE OF SAVINGS AND TIME DEPOSIT<br><u>As of <?php echo date('F d, Y', strtotime($response['current_'])); ?></u></div>
  </div>
    
  <div class="row">
    <div class="col-md-12">
     <table class="table table-bordered table-striped shares-table center table-condensed">
      <thead>
        <tr>
          <th rowspan="2"></th>
          <th rowspan="2">SAVINGS <br>ACCOUNT NO.</th>
          <th rowspan="2"><u>NAME OF DEPOSITORS</u></th>
          <th rowspan="2" class = "w80px"><?php echo date('m/d/Y', strtotime($response['past'])); ?><br>TOTAL<br> AMOUNT</th>
          <th rowspan="2">DEPOSIT <br>AMOUNT</th>
          <th rowspan="2">WITHDRAWAL <br>AMOUNT</th>
          <th rowspan="2">INTEREST<br> AMOUNT</th>
          <th rowspan="2" class = "w80px"><?php echo date('m/d/Y', strtotime($response['current_'])); ?><br>TOTAL <br>AMOUNT</th>
        </tr>
      </thead>
      <tbody>
        <?php 
          $x = 1;
          foreach($response['savings']['data'] as $data) { ?>
        <tr>
          <td><?php echo $x; ?></td>
          <td class="text-center "><?php echo $data['code']; ?></td>
          <td class= "text-left uppercase"><?php echo $data['name']; ?></td>
          <td class = "text-right"><?php echo $data['total_last_month'] > 0 ? (number_format($data['total_last_month'],2)) : '-'; ?></td>
          <td class="text-right"><?php echo $data['total_deposit'] > 0 ? (number_format($data['total_deposit'],2)) : ''; ?></td>
          <td class="text-right"><?php echo $data['total_withdraw'] > 0 ? ( number_format($data['total_withdraw'], 2)) : ''; ?></td>
          <td class="text-right"><?php echo $data['total_interest'] > 0 ? (number_format($data['total_interest'], 2)) : ''; ?></td>
          <td class="text-right"><?php echo number_format($data['amount'], 2); ?></td>
        </tr>
        <?php
          $x += 1;
          } 
        ?>
      </tbody>
      <tbody>
        <th colspan = "3" class ="text-center">TOTAL</th>
        <th class ="text-right"><?php echo $response['savings']['past'] > 0 ? (number_format($response['savings']['past'],2)) : '-'; ?></th>
        <th class ="text-right"><?php echo $response['savings']['deposit'] > 0 ? (number_format($response['savings']['deposit'],2)) : '-'; ?></th>
        <th class ="text-right"><?php echo $response['savings']['withdraw'] > 0 ? (number_format($response['savings']['withdraw'],2)) : '-'; ?></th>
        <th class ="text-right"><?php echo $response['savings']['interest'] > 0 ? (number_format($response['savings']['interest'],2)) : '-'; ?></th>
        <th class ="text-right"><?php echo $response['savings']['current_'] > 0 ? (number_format($response['savings']['current_'],2)) : '-'; ?></th>
      </tbody>
      <tbody>
        <tr>
          <th rowspan="2"></th>
          <th rowspan="2">TIME DEPOSIT <br>ACCOUNT NO.</th>
          <th rowspan="2"><u>NAME OF DEPOSITORS</u></th>
          <th rowspan="2" class = "w80px"><?php echo date('m/d/Y', strtotime($response['past'])); ?><br>TOTAL<br> AMOUNT</th>
          <th rowspan="2">DEPOSIT <br>AMOUNT</th>
          <th rowspan="2">WITHDRAWAL <br>AMOUNT</th>
          <th rowspan="2">INTEREST<br> AMOUNT</th>
          <th rowspan="2" class = "w80px"><?php echo date('m/d/Y', strtotime($response['current_'])); ?><br>TOTAL <br>AMOUNT</th>
        </tr>
      </tbody>
      <tbody>
      <tbody>
        <?php 
          $x = 1;
          foreach($response['time_depo']['data'] as $data) { ?>
        <tr>
          <td><?php echo $x; ?></td>
          <td class="text-center "><?php echo $data['code']; ?></td>
          <td class= "text-left uppercase"><?php echo $data['name']; ?></td>
          <td class = "text-right"><?php echo $data['total_last_month'] > 0 ? (number_format($data['total_last_month'],2)) : '-'; ?></td>
          <td class="text-right"><?php echo $data['total_deposit'] > 0 ? (number_format($data['total_deposit'],2)) : ''; ?></td>
          <td class="text-right"><?php echo $data['total_withdraw'] > 0 ? ( number_format($data['total_withdraw'], 2)) : ''; ?></td>
          <td class="text-right"><?php echo $data['total_interest'] > 0 ? (number_format($data['total_interest'], 2)) : ''; ?></td>
          <td class="text-right"><?php echo number_format($data['amount'], 2); ?></td>
        </tr>
        <?php
          $x += 1;
          } 
        ?>
      </tbody>
      <tbody>
        <th colspan = "3" class ="text-center">TOTAL</th>
        <th class ="text-right"><?php echo $response['time_depo']['past'] > 0 ? (number_format($response['time_depo']['past'],2)) : '-'; ?></th>
        <th class ="text-right"><?php echo $response['time_depo']['deposit'] > 0 ? (number_format($response['time_depo']['deposit'],2)) : '-'; ?></th>
        <th class ="text-right"><?php echo $response['time_depo']['withdraw'] > 0 ? (number_format($response['time_depo']['withdraw'],2)) : '-'; ?></th>
        <th class ="text-right"><?php echo $response['time_depo']['interest'] > 0 ? (number_format($response['time_depo']['interest'],2)) : '-'; ?></th>
        <th class ="text-right"><?php echo $response['time_depo']['current_'] > 0 ? (number_format($response['time_depo']['current_'],2)) : '-'; ?></th>
      </tbody>
      <tbody>
        <th colspan = "3">GRAND TOTAL</th>
        <th class = "text-right"><?php echo number_format($response['grandtotal']['grand_total_past'],2); ?></th>
        <th class = "text-right"><?php echo number_format($response['grandtotal']['grand_deposit'],2); ?></th>
        <th class = "text-right"><?php echo number_format($response['grandtotal']['grand_withdraw'],2); ?></th>
        <th class = "text-right"><?php echo number_format($response['grandtotal']['grand_interest'],2); ?></th>
        <th class = "text-right"><?php echo number_format($response['grandtotal']['grand_total'],2); ?></th>
      </tbody>
  </table>
	</div>
  </div>
</body>
</html>    
    