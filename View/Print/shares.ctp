<!DOCTYPE html>
<html>
<head>
	<title>Share Capital Report</title>
	<link rel="stylesheet" href="<?php echo $this->base ?>/assets/plugins/bootstrap-3.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo $this->base ?>/assets/css/style.css">
	<style>
		.shares-table {
			font-size: 11px;
		}
		.bottom- {
    border-bottom-style:solid;border-bottom:4px double black;
  } 
	</style>
</head>
<body>
	<?php //echo var_dump($totalShares)?>
	<div class="row">
		<div class="col-md-12">    
	    <div class="text-center uppercase" style="padding:20px 0px 0px 0px; font-size: 16px"><strong><?php echo $this->Global->Settings('cooperative_name') ?></strong></div>
	    <div class="text-center uppercase" style="padding:0px 0px 20px 0px; font-size: 12px"><strong><?php echo $this->Global->Settings('address') ?></strong></div>
	    <div class="text-center uppercase" style="padding:0px 0px 20px 0px; font-size: 16px"><strong><u>SHARE CAPITAL REPORT</u></strong></div>
	  </div>
	  
		<div class="col-md-12">
			 <table class="table table-striped center">
			 <thead>
					<tr>
						<td class="w30px">#</td>
						<th class="w150px">MEMBER ID</th>
						<th>NAME</th>
						<th class="text-right w100px">PERCENT</th>
						<th class="text-right w150px">SHARE CAPITAL</th>
					</tr>
			 </thead>
				<tbody>
					<?php $num=0 ?>
					<?php foreach($datas as $share): ?>
					<tr>
						<td><?php echo $num+=1 ?></td>
						<td><?php echo $share['code'] ?></td>
						<td class="text-left"><?php echo properCase($share['full_name']) ?></td>
						<td class="text-right"><?php echo fnumber($share['percent'],0) ?> %</td>
						<td class="text-right "><?php echo fnumber($share['shares']) ?></td>
					</tr>
					<?php endforeach ?>
				</tbody>
				<tfoot>
					<tr>
						<th colspan="3" class="text-left bottom-">TOTAL</th>
						<th class="text-right bottom-"><?php echo !empty($datas) ? '100 %':''?></th>
						<th class="text-right bottom-"><?php echo fnumber($totalShares) ?></th>
					</tr>
				</tfoot>
				
			</table>
		</div>
		
	</div>
</body>
</html>



