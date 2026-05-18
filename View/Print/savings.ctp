<!DOCTYPE html>
<html>
<head>
	<title><?php echo $type?> SAVINGS REPORT</title>
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
      <div class="text-center uppercase" style="padding:20px 0px 0px 0px; font-size: 16px"><strong><?php echo $this->Global->Settings('cooperative_name') ?></strong></div>
      <div class="text-center text-capitalize" style="padding:0px 0px 20px 0px; font-size: 12px"><?php echo $this->Global->Settings('address') ?></div>
      <div class="text-center uppercase" style="padding:0px 0px 20px 0px; font-size: 16px"><strong><u><?php echo $type?> SAVINGS REPORT </u></strong></div>
    </div>

  		<div class="col-md-12">
  			<table class="table table-condensed table-striped table-hover center vcenter">
          <thead>
            <tr>
              <th style="width:30px"></th>
              <th class="w100px">ACCT #</th>
              <th>MEMBER ID</th>
              <th>NAME</th>
              <th>BALANCE</th>
            </tr>
          </thead>
          <tbody>
            
            <?php $num=0 ?>
  				  <?php foreach($data as $saving): ?>
            <tr>
              <td><?php echo $num+=1 ?></td>
              <td><?php echo $saving['code'] ?></td>
              <td class="uppercase text-center"><?php echo $saving['member_code'] ?></td>
              <td class="uppercase text-left"><?php echo $saving['name'] ?></td>
              <td class="text-right"><?php echo fnumber($saving['amount'],2) ?></td>
            </tr>
            <?php endforeach ?>
             <?php if ($data == null) { ?>
            <tr>
              <td colspan="6">No data available.</td>
            </tr>
            <?php } ?>
          </tbody>
          <tfoot>
            <tr>
              <th colspan="4" class="text-left border-bottom-double">TOTAL</th>
              <th class="text-right border-bottom-double"><?php echo fnumber($total,2); ?></th>
            </tr>
          </tfoot>
        </table>  
		</div>
		
	</div>
</body>
</html>



<style type="text/css">
  .border-bottom-double {
    border-bottm-style:solid;
    border-bottom:4px double black;
  }
</style>