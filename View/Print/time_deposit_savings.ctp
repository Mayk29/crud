<!DOCTYPE html>
<html>
<head>
	<title>Time Deposit Savings Report</title>
	<link rel="stylesheet" href="<?php echo $this->base ?>/assets/plugins/bootstrap-3.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo $this->base ?>/assets/css/style.css">
	<style>
		.shares-table {
			font-size: 11px;
		}
	</style>
</head>
<body>
	<div class="row">
  		<div class="col-md-12">    
  	    <div class="text-center uppercase" style="padding:20px 0px"><strong>Time Deposit Savings Report</strong></div>
  	  </div>
  	  
  		<div class="col-md-12">
  			<table class="table table-bordered table-condensed table-striped table-hover center vcenter">
          <thead>
            <tr>
              <th style="width:30px"></th>
              <th class="w100px">SSD NO.</th>
              <th>MEMBER ID</th>
              <th>NAME</th>
              <th>INTEREST</th>
              <th>BALANCE</th>
            </tr>
          </thead>
          <tbody>
            
            <?php $num=0; $balance = 0;?>
  				  <?php foreach($savings as $saving): ?>
            <tr>
              <td><?php echo $num+=1 ?></td>
              <td><?php echo $saving['code'] ?></td>
              <td><?php echo $saving['member_code'] ?></td>
              <td class="uppercase text-left"><?php echo $saving['name'] ?></td>
              <td class="text-right"><?php echo fnumber($saving['interest'],2) ?></td>
              <td class="text-right"><?php echo fnumber($saving['balance'],2) ?></td>
            </tr>
            <?php $balance+=$saving['balance'];endforeach ?>
            <?php if (empty($savings)) {?>
              <tr>
                <td colspan="7">No data available..</td>
              </tr>
            <?php } ?>
          </tbody>
          <tfoot>
            <tr>
              <th colspan="5" class="text-left">TOTAL</th>
              <th class="text-right"><?php echo fnumber($balance,2); ?></th>
            </tr>
          </tfoot>
        </table>  
		</div>
		
	</div>
</body>
</html>



