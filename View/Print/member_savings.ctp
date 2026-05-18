<!DOCTYPE html>
<html>
<head>
	<title>Member Savings</title>
	<link rel="stylesheet" href="<?php echo $this->base ?>/assets/plugins/bootstrap-3.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo $this->base ?>/assets/css/style.css">
  <style type="text/css">
  body { font-family: Times New Roman; font-size: 17px;}
  .content { outline: 1px solid black; height: 500px; width: 624px;}
  </style>

</head>
<body>
  <div class="row">
    <div class="col-md-12">
      <div class="text-right pull-right">
        <table>
          <tr>
            <th colspan="2">SAVINGS LEDGER</th>
          </tr>
          <tr>
            <td class="text-left w80px">ACCT NO</td>
            <td class="text-center" style="border-bottom: 1px solid black"><?php  echo $savings['Savings']['code'];?></td>
          </tr>
        </table>
      </div>
      
      <div class="text-left pull-left">    
        <table>
          <tr>
            <td><strong>NAME:</strong></td>
            <td style="border-bottom: 1px solid black;"><?php  echo $savings['Savings']['name'];?></td>
          </tr>
          <tr>
            <td><strong>ADDRESS:</strong></td>
            <td style="border-bottom: 1px solid black;"><?php  echo $savings['Savings']['address'];?></td>
          </tr>
        </table>  
      </div>  

      <div class="clearfix"></div>

      <br><br>
      <table style="width: 100%" border="1" >
        <tr>
          <th class="text-center p10px w150px">DATE</th>
          <th class="text-center p10px">OR/CDV NO</th>
          <th class="text-center p10px">MEMBER SAVINGS</th>
          <th class="text-center p10px">INTEREST</th>
          <th class="text-center p10px">WITHDRAWAL</th>
          <th class="text-center p10px">BALANCE</th>
        </tr>
          
          <?php foreach($savings['SavingSubs'] as $sub): ?>    
          <tr>
            <td class="text-center"><?php echo fdate($sub['date'],'m/d/Y')?></td>
            <td class="text-center"><?php echo @$sub['code']?></td>
            <td class="text-center"><?php if (@$sub['type']) { echo @fnumber($sub['amount']);}?></td>
            <td class="text-center"><?php echo $savings['Savings']['saving_type_id'] !=2 ? @fnumber($sub['interest']):( $sub['type']? fnumber($savings['Savings']['newInterest']) : '');?></td>
            <td class="text-center"><?php if (@!$sub['type']) echo @fnumber($sub['amount']);?></td>
            <td class="text-center"><?php echo @fnumber($sub['balance']);?></td>
          </tr>
          <?php endforeach ?>
      </table>

    </div>  
  </div> 
</body>
</html>

