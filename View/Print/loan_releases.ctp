<!DOCTYPE html>
<html>
<head>
	<title>LOAN RELEASES</title>
	<link rel="stylesheet" href="<?php echo $this->base ?>/assets/plugins/bootstrap-3.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo $this->base ?>/assets/css/style.css">
</head>
<body>
	<div class="row">
    
    <div class="col-md-12">
			<div class="text-center" style="padding:5px 0px"><strong>LOAN RELEASES</strong></div>
  		<br>
  		<?php if (isset($date)) { ?>
  		  <div class="text-center" style="padding:0px 0px 5px 0px"> <strong><?php echo $date ?></strong></div>
		  <?php } ?>
		</div>
	  
	  <br><br>  	
	  
		<div class="col-md-12">
			<table class="table table-bordered">
  			<thead>
          <tr>
            <th class="text-center">CODE</th>
            <th class="text-center">NAME</th>
    				<th class="text-center">LOAN</th>
    				<th class="text-center">AMOUNT</th>
    				<th class="text-center">RES</th>
    				<th class="text-center">REF</th>
    				<th class="text-center">DOC #</th>
    				<th class="text-center">DATE</th>
    				<th class="text-center">CHECK #</th>
    				<th class="text-center">GRANTED</th>
    				<th class="text-center">MATURITY</th>
    				<th class="text-center">MODE</th>
    				<th class="text-center">PAYMENT</th>
            </tr>
  			</thead>
              <?php 
                if (!empty($loan_type_id)) {
                // $ctr = 0;  
                foreach($loan_type_id as $type): ?>
              
                <tbody>
                  <?php foreach($data as $datas): if ($datas['loan_type_id'] == $type){?>
                  <tr>
                    <!--<td><?php //echo $ctr +=1; ?></td>-->
                    <td><?php echo $datas['id'] ?></td>
                    <td class="uppercase"><?php echo $datas['full_name'] ?></td>
                    <td class="uppercase"><?php echo $datas['loan_type'] ?></td>
                    <td class="uppercase"><?php echo fnumber($datas['amount'],2) ?></td>
                    <td class="uppercase"></td>
                    <td class="uppercase">CV</td>
                    <td class="uppercase"><?php echo $datas['code'] ?></td>
                    <td class="uppercase"><?php echo fdate($datas['date_approved'],'m/d/Y') ?></td>
                    <td class="uppercase"></td>
                    <td class="uppercase"><?php echo fdate($datas['date_approved'],'m/d/Y') ?></td>
                    <td class="uppercase"><?php echo fdate($datas['due_date'],'m/d/Y') ?></td>
                    <td class="uppercase"><?php echo $datas['payment_type'] ?></td>
                    <td class="uppercase"><?php echo $datas['total_paid_principal'] ?></td>
                  </tr>
                  <?php } endforeach; ?>
                  
                  <?php foreach($total as $totals): if($totals['total']['type'] == $type){?> 
                  <tr>
                    <?php  ?>
                        <th colspan="3" class="uppercase text-left">TOTAL</th>
                        <th colspan="10" class="uppercase text-left"><?php echo fnumber($totals['total']['total_amount'],2) ?></th>
                  </tr>
                  <?php } endforeach; ?>
                  
                  
                  
                  
                  
                </tbody>
                
              <?php endforeach; } ?>
  		</table>
		</div>
		
	</div>
</body>
</html>



