<!DOCTYPE html>
<html>
<head>
  <title>DIVIDENDS</title>
  <link rel="stylesheet" href="<?php echo $this->base ?>/assets/plugins/bootstrap-3.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo $this->base ?>/assets/css/style.css">
</head>
<body>
  <div class="col-md-12">
    <div class="text-center uppercase" style="padding:20px 0px 0px 0px; font-size: 16px"><strong><?php echo $this->Global->Settings('cooperative_name') ?></strong></div>
    <div class="text-center text-capitalize" style="padding:0px 0px 20px 0px; font-size: 12px"><?php echo $this->Global->Settings('address') ?></div>
    <div class="text-center uppercase" style="padding:0px 0px 0px 0px; font-size: 16px"><strong><u>DIVIDENDS REPORT </u></strong></div>
    <div class="text-center" style="padding:0px 0px 20px 0px"><sup><?php echo $date != '' ? ('As Of ' . fdate($date,'F d, Y')):'' ?></sup></div>
  </div>
  	<div class="row">
  		
    	<div class="col-md-12">
        <div style="width:100%; height:100%;">
  			 <table class="table  table-striped shares-table center table-condensed">
	  				<thead>
	      			<tr>
	              <th rowspan="2"></th>
	              <th rowspan="2">NAME OF MEMBERS</th>
	              <th rowspan="2">SHARE CAPITAL</th>
	  						<th rowspan="2">PERCENT</th>
	  						<th rowspan="2">DIVIDENDS</th>
	  						<th rowspan="2">AMOUNT DUE</th>
	            </tr>
	  				</thead>
	  				<tbody>
	  				  <?php $index=0;
	              foreach ($shareCapital as $mydata) {
	                 $index++;
	    					echo "<tr>";
	    					echo "<td>".$index."</td>";
	    					echo "<td class='text-left uppercase'>".$mydata["name"]."</td>";
	    					echo "<td class='text-right'>".fnumber($mydata['amount'])."</td>";
	    					echo "<td class='text-right'>".fnumber($mydata['percent'])."%</td>";
	    					echo "<td class='text-right'>".fnumber($mydata['dividend'])."</td>";
	    					echo "<td class='text-right'>".fnumber($mydata['dividend'],0)."</td>";
	    					echo "</tr>";
	            } ?>

	  					<tr>
	  						<th class="text-left uppercase border-bottom-double" colspan="2">TOTAL</th>
	  						<th class="text-right border-bottom-double"><?php echo fnumber($allShare,2) ?></th>
	  						<th class="text-right border-bottom-double"><?php echo fnumber($allPercent,2) ?>%</th>
	  						<th class="text-right border-bottom-double"><?php echo fnumber($allDividends,2) ?></th>
	  						<th class="text-right border-bottom-double"><?php echo fnumber($allDividends,0) ?></th>
	  					</tr>
	  				</tbody>
  				</table>
      	</div>
      <div style="font-size: 10px;bottom:0px">
        Date Printed: <?php echo Date('l , F d, Y h:i:s A') ?>
      </div>
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