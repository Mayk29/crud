<!DOCTYPE html>
<html>
<head>
  <title>Daily Payments Report</title>
  <link rel="stylesheet" href="<?php echo $this->base ?>/assets/plugins/bootstrap-3.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo $this->base ?>/assets/css/style.css">
  <style type="text/css">
  .bottom- {
    border-bottom-style:solid;border-bottom:4px double black;
  } 
  </style>
</head>
<body>
  <div class="col-md-12">
    <div class="text-center uppercase" style="padding:20px 0px 0px 0px; font-size: 16px"><strong><?php echo $this->Global->Settings('cooperative_name') ?></strong></div>
    <div class="text-center uppercase" style="padding:0px 0px 20px 0px; font-size: 12px"><strong><?php echo $this->Global->Settings('address') ?></strong></div>
    <div class="text-center uppercase" style="padding:0px 0px 0px 0px; font-size: 16px"><strong><u>DAILY PAYMENTS NOTIFICATIONS</u></strong></div>
    <div class="text-center" style="padding:0px 0px 20px 0px"><?php echo fdate($date,'F d, Y') ?></div>
  </div>

  <div class="col-md-12">
    <table class="table table-striped center">
			<thead>
				<tr>
					<th style="width:30px"></th>
					<th style="width:120px">LOAN CODE</th>
					<th>NAME</th>
					<th class="text-right">PRINCIPAL BALANCE</th>
  					<th class="text-right">INTEREST BALANCE</th>
  					<th class="text-right">PENALTY BALANCE</th>
					<th style="width:120px">STATUS</th>
				</tr>
			</thead>
			<tbody>
				<?php $index = 0;?>
			  <?php foreach($datas as $data): ?>
			  
				<tr>
					<td><?php echo $index+=1; ?></td>
					<td class="uppercase"><?php	echo $data['code']?></td>
					<td class="uppercase text-left"><?php	echo $data['loaners_name']?></td>
					<td class="text-right"><?php echo $data['principal_balance'] > 1 ? fnumber($data['principal_balance']): '0.00'?></td>
					<td class="text-right"><?php echo $data['interest_balance'] > 1 ? fnumber($data['interest_balance']): '0.00'?></td>
					<td class="text-right"><?php echo $data['penalty_balance'] > 1 ? fnumber($data['penalty_balance']): '0.00'?></td>
					<td><?php echo $data['paid'] == 1? 'PAID':'NOT PAID'?></td>
				</tr>
				
				<?php endforeach ?>
				<?php if (empty($datas)) { ?>
					<tr>
            <td colspan="7">No payments scheduled for today.</td>
          </tr>
				<?php } ?>
			</tbody>
		</table>
  </div>
</body>
</html>



