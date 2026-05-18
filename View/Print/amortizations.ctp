<!DOCTYPE html>
<html>
<head>
  <title>Amortizations</title>
  <link rel="stylesheet" href="<?php echo $this->base ?>/assets/plugins/bootstrap-3.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo $this->base ?>/assets/css/style.css">
  <style>
  table.info td { padding-left: 20px} 
  body { margin: 20px 20px}
  .bggray {background-color: #D1D1D1}
  </style>
</head>
<body>
  <div class="row">
    <div class="col-md-12">    
	    <div class="text-center uppercase" style="padding:20px 0px">Amortizations Report</div>
	  </div>
	  
    <div class="col-md-12">
      <table class="table center">
          <tbody>
            <tr>
              <td class="w150px  text-left">Member: </td>
              <td class=" italic text-left"><?php echo properCase($member['Member']['full_name']) ?></td>
              
              <td class="w150px  text-left">Months:</td>
              <td class=" italic text-left"><?php echo properCase($query['months'] . ' month(s)')?></td>
            </tr>

            <tr>
              <td class=" text-left">Payment mode: </td>
              <td class=" italic text-left"><?php echo properCase($paymentMode) ?></td>
              
              <td class=" text-left">Interest:</td>
              <td class="  italic text-left"><?php echo $query['interest'] ?>%</td>
            </tr>

            <tr>
              <td class=" text-left">Loan amount:</td>
              <td class=" italic text-left"><?php echo number_format($query['amount'],2) ?></td>
              
              <td class=" text-left"><?php echo $query['interestType'] == 'true'?'Advanc Interest':'Add-up Interest' ?></td>
              <td class="italic text-left"><?php echo number_format($totalInterest,2) ?></td>
            </tr>
          </tbody>
      </table>
      <table class="table table-bordered center">
        <thead>
          <tr>
            <th style="width:30px">#</th>
            <th>DATE</th>                               
            <th>BALANCE</th>
            <th>PRINCIPAL</th>
            <th>INTEREST</th>
            <th>PENALTY</th>
            <th>INSTALLMENT AMT.</th>
          </tr>
        </thead>
        <tbody>
          <?php $ctr=0 ?>
          <?php foreach($datares as $data): ?>
          <tr>
            <td><?php echo $ctr+=1 ?></td>
            <td class="uppercase"><?php echo $data['date'] ?></td>
            <td><?php echo number_format($data['balance'],2) ?></td>
            <td><?php echo number_format($data['principal'],2) ?></td>
            <td><?php echo number_format($data['interest'],2) ?></td>
            <td><?php echo number_format($data['penalty'],2) ?></td>
            <td><?php echo number_format($data['installment'],2) ?></td>
          </tr>
          <?php endforeach ?>
        </tbody>
        <tfoot>
          <td></td>
          <td></td> 
          <td></td> 
          <th><?php echo number_format($sum['principal'],2) ?></th>
          <th><?php echo number_format($sum['interest'],2) ?></th>
          <th>0.00</th>
          <th><?php echo number_format($sum['installment'],2) ?></th>
        </tfoot>
      </table>
    </div>
    
  </div>
</body>
</html>



