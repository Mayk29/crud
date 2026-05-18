<html>
<head>
	<link rel="stylesheet" href="<?php echo $this->base ?>/assets/plugins/bootstrap-3.2/css/bootstrap.min.css">
</head>
<style>
	table {
		font-size: 12px;
	}
	.block {
		width: 100%;
	}

</style>
<body>
	<div class="text-center" style="font-size:20px; padding:50px 0px 0px 0px">
		DHVTSU MULTI-PURPOSE COOPERATIVE
	</div>
	<div class="text-center" style="padding:0px 0px 15px 0px">
		Bacolor, Pampanga
	</div>
	<div class="text-center" style="font-size:16px; padding:0px 0px 15px 0px">
		LOAN ACCOUNT LEDGER
	</div>
	
	<div style="padding:0px 50px">
		<table class="block" style="font-size: 13px">
			<tr>
				<td style="width:100px">Name:</td>
				<td class="text-left"><?php echo $loan['Member']['full_name'] ?></td>
				<td style="width:100px">Date Granted:</td>
				<td class="text-left"><?php echo $loan['Loan']['date_approved'] ?></td>
			</tr>	
			
			<tr>
				<td>Kind of Loan:</td>
				<td><?php echo $loan['LoanType']['name'] ?></td>
				<td>Date Due</td>
				<td><?php echo $loan['Loan']['due_date'] ?></td>
			</tr>
			<tr>
				<td>Amount of Loan:</td>
				<td><?php echo $loan['Loan']['amount'] ?></td>
				<td></td>
				<td></td>
			</tr>
		</table>
	</div>

	
	<div class="text-center" style="font-size:14px; padding:15px 0px;">
		REPAYMENT
	</div>
	
	<div style="padding:0px 50px">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th colspan="6"></th>
					<th colspan="3" class="text-center">BALANCE</th>
				</tr>
				<tr>
					<th class="text-center" style="width:100px">Date</th>
					<th class="text-center">Ref #</th>
					<th class="text-center">Amount</th>
					<th class="text-center">Principal</th>
					<th class="text-center">Interest</th>
					<th class="text-center">Penalty</th>
					<th class="text-center">Principal</th>
					<th class="text-center">Interest</th>
					<th class="text-center">Total</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($loan['LoanSub'] as $data): ?>
				<tr>
					<td class="text-center"><?php echo date('M-d-Y', strtotime($data['date'])) ?></td>
					<td></td>
					<td class="text-right"><?php echo $data['installment'] ?></td>
					<td class="text-right"><?php echo $data['principal'] ?></td>
					<td class="text-right"><?php echo $data['interest'] ?></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
	<script>
		window.print();
	</script>
</body>
</html>