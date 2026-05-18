<!DOCTYPE html>
<html>
<head>
  <title>Loan Account Ledger</title>
  <link rel="stylesheet" href="<?php echo $this->base ?>/assets/plugins/bootstrap-3.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo $this->base ?>/assets/css/style.css">
  <style>
  body { font-family: Courier New;font-size:12px;background: gray}
  #amort td,#amort th, #deductions td,#deductions th, {padding: 3px !important;}
  page[size="Letter"] {
    background: white;
    width: 8.5in;
    /*height: 11in;*/
    display: block;
    margin: 0 auto;
    box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
    }
  </style>
</head>
<body>
<page size="Letter">
  <div>    
  <div class="text-center" style="padding:0px 0px;font-size:17px"><strong><?php echo $this->Global->Settings('cooperative_name') ?></strong></div>
  <div class="text-center" style="font-size:12px; margin-top:-8px"><?php echo $this->Global->Settings('address') ?></div>
  <div class="text-center" style="margin-top:-4px;font-size:12px"><?php echo $this->Global->Settings('registration_no') ?></div>
    <div class="text-center uppercase" style="font-size:14px;margin-top: 20px"><strong><label style="border-bottom:1px solid black; ">Loan Account Ledger</label></strong></div>

    <table width="50%" border="0" style="float:left">
        <tr>
          <td class="w120px">LOAN NO. </td>
          <td>: <?php echo $data['Loan']['code'] ?></td>
        </tr>
        <tr>
          <td class="w120px">MEMBER </td>
          <td>:  <?php echo properCase($data['Member']['complete_name']) ?></td>
        </tr>
        <tr>
          <td class="w120px">LOAN PURPOSE </td>
          <td>:  <?php echo $data['Loan']['loan_purpose'] ?></td>
        </tr>
        <tr>
          <td class="w120px">DATE APPLIED</td>
          <td>:  <?php echo fdate($data['Loan']['date_applied']) ?></td>
        </tr>
        <tr>
          <td class="w120px">DATE APPROVED</td>
          <td>:  <?php echo fdate($data['Loan']['date_approved']) ?></td>
        </tr>
        <tr>
          <td class="w120px">FIRST PAYMENT</td>
          <td>:  <?php echo fdate($data['Loan']['amortization_date']) ?></td>
        </tr>
        <tr>
          <td class="w120px">DUE DATE</td>
          <td>:  <?php echo fdate($data['Loan']['due_date']) ?></td>
        </tr>
    </table>
    <table width="50%" border="0" style="float:right">
        <tr>
          <td class="w120px">LOAN TYPE </td>
          <td>: <?php echo properCase($data['LoanType']['name']) ?></td>
        </tr>
        <tr>
          <td class="w120px">LOAN AMOUNT</td>
          <td>: <?php echo fnumber($data['Loan']['amount']) ?></td>
        </tr>
        <tr>
          <td class="w120px">INTEREST TYPE </td>
          <td>: <?php echo $data['Loan']['advance_interest']? 'ADVANCE':'ADD-UP' ?></td>
        </tr>
        <tr>
          <td class="w120px">INTEREST RATE</td>
          <td>: <?php echo floatval($data['Loan']['interest']) ?> %</td>
        </tr>
        <tr>
          <td class="w120px">TERMS (MONTHS)</td>
          <td>: <?php echo intval($data['Loan']['months']) ?></td>
        </tr>
        <?php if ($data['Loan']['advance_interest']) { ?>        
        <tr>
          <td class="w120px">INTEREST</td>
          <td>: <?php echo fnumber(floatval($data['Loan']['amount'])*($data['Loan']['interest']*$data['Loan']['months'])) ?></td>
        </tr>  
        <?php } ?>       
        <tr>
          <td class="w120px">PAYMENT MODE</td>
          <td>: <?php echo properCase($data['LoanPaymentType']['name']) ?></td>
        </tr>
    </table>
    
    <div class="clearfix"></div>        
    <?php if (!empty($data['LoanSubFee'])) { ?>
    <table border="0" width="25%" id="deductions" style="margin-top:10px">
      <thead>
        <tr>
          <th class="text-left">LOAN FEES</th>                               
          <th class="w100px text-right">AMOUNT</th>
        </tr>
      </thead>
      <tbody>
        <?php $total = 0;foreach($data['LoanSubFee'] as $fee): ?>
        <tr>
          <td class="text-left"><?php echo $fee['LoanFee']['name'] ?></td>
          <td class="text-right"><?php echo fnumber($fee['amount']) ?></td>
        </tr>
        <?php $total+= floatval($fee['amount']);endforeach ?> 
      </tbody>
      <tfoot>
        <th class="text-left">TOTAL</th>
        <th class="text-right"><?php echo fnumber($total) ?></th> 
      </tfoot>
    </table>
    <?php } ?>

    <div class="clearfix"></div>

    <table border="1" width="100%" id="amort" style="margin-top:10px">
      <thead>
        <tr>
          <th class="text-center" style="width:20px;">#</th>
          <th class="w100px text-center">DATE</th>                               
          <th class="w100px text-center">PRINCIPAL</th>
          <th class="w100px text-center">INTEREST</th>
          <th class="w100px text-center">PENALTY</th>
          <th class="w100px text-center">INSTALLMENT</th>
          <th class="w100px text-center">BALANCE</th>
        </tr>
      </thead>
      <tbody>
        <?php $ctr=0 ?>
        <?php foreach($data['LoanSub'] as $sub): ?>
        <tr>
          <td class="text-center"><?php echo $ctr+=1 ?></td>
          <td class="uppercase text-center"><?php echo fdate($sub['date']) ?></td>
          <td class="text-right"><?php echo fnumber($sub['amount']['principal']) ?></td>
          <td class="text-right"><?php echo fnumber($sub['amount']['interest']) ?></td>
          <td class="text-right"><?php echo fnumber($sub['amount']['penalty']) ?></td>
          <td class="text-right"><?php echo fnumber($sub['amount']['principal'] + $sub['amount']['interest']) ?></td>
          <td class="text-right"><?php echo fnumber($sub['balance']['total']) ?></td>
        </tr>
        <?php endforeach ?>
      </tbody>
    </table>
   </div>
  </page>
</body>
</html>



