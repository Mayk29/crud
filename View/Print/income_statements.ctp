<!DOCTYPE html>
<html>
<head>
	<title>INCOME STATEMENT REPORT</title>
	<link rel="stylesheet" href="<?php echo $this->base ?>/assets/plugins/bootstrap-3.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo $this->base ?>/assets/css/style.css">
</head>
<body>
 <div class="row">
	    	<div class="col-md-12">
	    		<div class="text-center" style=""></div>
	    		<div class="text-center" style="padding:5px 0px">INCOME STATEMENT</div>
	    		<div class="text-center" style="padding:0px 0px 20px 0px"> as at <?php echo $response['startDate'] ?></div>
	    	</div>

    <div class="col-md-12">
	    		<table class="table table-bordered">
	    			<tbody>
	    				<tr class="bg-primary">
	    					<th class="text-center">REVENUES</th>
	    					<th style="width:120px"></th>
	    				</tr>
	    				<?php foreach($response['result']['revenues'] as $rev): ?>
	    				<tr>
							<td><?php echo $rev['Account']['name'] ?></td>
							<td class="text-right"> <?php echo $rev[0]['total'] > 0 ? number_format($rev[0]['total'],2):'('.number_format(abs($rev[0]['total']),2).')' ?></td>
	    				</tr> <!--{{ entry[0]['total'] > 0? (entry[0]['total'] 3| number:2):'(' + ((entry[0]['total'] | abs) | number:2) + ')' }}-->
	    				
	    				<?php endforeach ?>
	    				
	    				<tr class="bg-success">
	    					<th class="text-right">TOTAL REVENUES</th>
	    					<th class="text-right"><?php echo $response['total']['revenues'] > 0 ? number_format($response['total']['revenues'],2) : '('.number_format(abs($response['total']['revenues']),2).')' ?></th>
	    				</tr> <!--{{ data.total.revenues > 0? (data.total.revenues | number:2):'(' + ((data.total.revenues | abs) | number:2) + ')' }}-->
	    				<tr>
	    					<td colspan="2" style="height:50px"></td>
	    				</tr>
	    			</tbody>

	    			<tbody>
	    				<tr class="bg-primary">
	    					<th class="text-center">EXPENSES</th>
	    					<th></th>
	    				</tr>
	    				
	    				<?php foreach($response['result']['expenses'] as $ex): ?>
	    				<tr>
							<td><?php echo $ex['Account']['name'] ?></td>
							<td class="text-right"><?php echo $ex[0]['total'] > 0 ? number_format($ex[0]['total'],2) : '('.number_format(abs($ex[0]['total']),2).')' ?></td>
	    				</tr>
	    				<?php endforeach ?>
	    				
	    				<tr class="bg-success">
	    					<th class="text-right">TOTAL EXPENSES</th>
	    					<th class="text-right"><?php echo $response['total']['expenses'] > 0 ? number_format($response['total']['expenses'],2) : '('.number_format(abs($response['total']['expenses']),2).')' ?></th>
	    				</tr>
	    				<tr>
	    					<td colspan="2" style="height:20px"></td>
	    				</tr>
	    			</tbody>
	    			<tbody>
	    				<tr class="darken">
	    					<th class="text-right">TOTAL INCOME</th>
	    					<th class="text-right"><?php echo $response['total']['netIncome'] > 0 ? number_format($response['total']['netIncome'],2) : '('.number_format(abs($response['total']['netIncome']),2).')' ?></th>
	    				</tr>
	    			</tbody>
	    		</table>
	    	</div>
  </div>
</body>
</html>



