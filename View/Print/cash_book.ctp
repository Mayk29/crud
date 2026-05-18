<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="<?php echo $this->base ?>/assets/plugins/bootstrap-3.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo $this->base ?>/assets/css/style.css">
	
</head>
<body>
	<h3 class="text-center">CASH BOOK FOR <i style="font-weight:300; font-size:16px" class="uppercase"><?php echo date('M-d-Y', strtotime($_GET['date'])) ?></i></h3>
	<div class="col-md-12">
		<table class="table table-bordered table-striped center" style="font-family:'Open Sans'; font-size:12px">
			<thead>
				<tr>
					<th colspan="6" class="text-right">BEGINNING BALANCE</th>
					<th class="text-right"><?php echo fnumber($response['yesterday']) ?></th>
				</tr>
				<tr>
					<th class="text-center">DATE</th>
					<th>PARTICULARS</th>
					<th class="text-center">OR #</th>
					<th class="text-right">AMOUNT</th>
					<th class="text-center">CDV #</th>
					<th class="text-right">AMOUNT</th>
					<th class="text-right">BALANCE</th>
				</tr>
			</thead>
			<tbody>
				<?php $endBalance = 0 ?>
				<?php foreach($response['result'] as $data): ?>
				<tr>
					<td class="text-center"><?php echo $data['date'] ?></td>
					<td><?php echo $data['particulars'] ?></td>
					<td class="text-center"><?php echo $data['or_number'] ?></td>
					<td class="text-right"><?php echo fnumber($data['or_amount']) ?></td>
					<td class="text-center"><?php echo $data['cdv_number'] ?></td>
					<td class="text-right"><?php echo fnumber($data['cdv_amount']) ?></td>
					<td class="text-right"><?php echo fnumber($data['balance']) ?></td>
				</tr>
				<?php $endBalance = fnumber($data['balance']) ?>
				<?php endforeach ?>
				<tr>
					<th colspan="6" class="text-right">ENDING BALANCE</th>
					<th class="text-right"><?php echo $endBalance ?></th>
				</tr>
			</tbody>
		</table>
	</div>	
</body>
</html>