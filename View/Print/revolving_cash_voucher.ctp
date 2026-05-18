<!DOCTYPE html>
<html>
<head>
	<style>
		body {
			font-family: Calibri;
		}
		.text-left {
			text-align: left;
		}
		.text-center {
			text-align: center;
		}
		.text-right {
			text-align: right;
		}
		.italic {
			font-style: italic;
		}
		.bold {
			font-weight: bold;
		}
		.underlined {
			text-decoration: underline;
		}
		.normal {
			font-weight: normal;
		}
		.table {
			border-collapse: collapse;
			width: 100%;
		}
		.table td, .table th {
			padding: 4px;
		}
		.bordered {
			border: 1px solid #000;
		}
		.padL {
			padding-left: 40px !important;
		}
		.vcenter {
			vertical-align: center;
		}
		.small-pad td {
			padding-top:0px;
			padding-bottom:0px;
		}
	</style>
</head>
<body>
	<div>
		<img src="<?php echo $this->base ?>/assets/img/logo-dhvtsu.png" style="width:90px; position:absolute;">
		<div class="text-center bold" style="padding-top:10px; font-size:14px">DHVTSU MULTI-PURPOSE COOPERATIVE</div>
		<div class="text-center bold" style="font-size:12px">BACOLOR, PAMPANGA</div>
		<div class="text-center underlined bold" style="padding-top:10px">REVOLVING CASH VOUCHER</div>
	</div>


	<div style="padding-top:50px">
		<table class="table bordered" style="font-size:13px">
			<thead>
				<tr>
					<th class="bordered">Explanation</th>
					<th class="bordered">Account Title</th>
					<th class="bordered" style="width:80px">Dr.</th>
					<th class="bordered" style="width:80px">Cr.</th>
				</tr>
			</thead>
            <tbody>
				<?php $counter = 0 ?>
				<?php foreach($entry['AccountingEntrySub'] as $sub): ?>
					<tr>
						<?php if($counter == 0): ?>
						<td rowspan="<?php echo count($entry['AccountingEntrySub']) ?>" class="text-center vcenter italic" style="border-right:1px solid #000">
							<?php echo $entry['AccountingEntry']['explanation'] ?>
						</td>
						<?php endif ?>
						<td class="italic <?php echo $sub['credit']>0? 'padL':'' ?>" style="border-right:1px solid #000"><?php echo $sub['Account']['name'] ?></td>
						<td class="text-right italic" style="border-right:1px solid #000">
							<?php echo $sub['debit']>0? number_format($sub['debit'],2):'' ?>
						</td>
						<td class="text-right italic">
							<?php echo $sub['credit']>0? number_format($sub['credit'],2):'' ?>
						</td>
					</tr>
				<?php $counter += 1 ?>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
	
	<div style="padding-top:20px; font-size:14px">
		<table class="table">
			<tr>
				<td style="width:50%">Prepared By:</td>
				<td class="italic" colspan="2">Receivied from DHVTSU MPC</td>
			</tr>
			<tr class="small-pad">
				<td style="border-bottom:1px solid #000"></td>
				<td class="padL" style="width:12%">Amount:</td>
				<td class="italic"><?php echo 'PHP ' . number_format($entry['AccountingEntry']['amount'], 2) ?></td>
			</tr>
			<tr class="small-pad">
				<td></td>
				<td class="padL">RCV #:</td>
				<td class="italic" style="width:50px"><?php echo $entry['AccountingEntry']['code'] ?></td>
			</tr>
		</table>
		
		<table class="table">
			<tr>
				<td style="width:50%">Approved By:</td>
				<td class="" style="width:50%"></td>
			</tr>
			<tr>
				<td style="border-bottom:1px solid #000"></td>
				<td class="italic">in full payment of amount described above.</td>
			</tr>
		</table>
		
		<table class="table">
			<tr class="small-pad">
				<td style="width:50%">Audited By:</td>
				<td class="padL" style="width:12%">Received By:</td>
				<td class="italic"><?php echo $entry['AccountingEntry']['name'] ?></td>
			</tr>
			<tr class="small-pad">
				<td style="width:50%;border-bottom:1px solid #000"></td>
				<td class="padL" >Date:</td>
				<td class="italic"><?php echo date('F d, Y', strtotime($entry['AccountingEntry']['date'])) ?></td>
			</tr>
			
		</table>
	</div>
</body>	
</html>