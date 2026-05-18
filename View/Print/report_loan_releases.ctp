<!DOCTYPE html>
<html>
<head>
  <title>LOAN RELEASES REPORT</title>
  <link rel="stylesheet" href="<?php echo $this->base ?>/assets/plugins/bootstrap-3.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo $this->base ?>/assets/css/style.css">
</head>
<body>
  <div class="row">
    <div class="col-md-12">
      <div class="text-center uppercase" style="padding:20px 0px 0px 0px; font-size: 16px"><strong><?php echo $this->Global->Settings('cooperative_name') ?></strong></div>
      <div class="text-center" style="padding:0px 0px 20px 0px; font-size: 12px"><?php echo $this->Global->Settings('address') ?></div>
      <div class="text-center uppercase" style="padding:0px 0px 0px 0px; font-size: 16px"><strong><u>LOAN RELEASES REPORT </u></strong></div>
      <div class="text-center" style="padding:0px 0px 20px 0px"><sup><?php echo $date != '' ? ($date):'' ?></sup></div>
    </div>

    <div class="col-md-12" >
      <table class="table table-striped center vcenter" style="font-size:11px">
        <thead>
          <tr>
            <th class=" text-center w30px"></th>
            <th class="text-center">CODE</th>
            <th class="text-center">NAME</th>
            <th class="text-center">LOAN</th>
            <th class="text-center">AMOUNT</th>
            <th class="text-center">GRANTED</th>
            <th class="text-center">MATURITY</th>
            <th class="text-center">TERMS</th>
            <th class="text-center">MODE</th>
          </tr>
        </thead>
        <tbody >
          <?php $ctr=0 ?>
          <?php if (!empty($datas)) { ?>
          <?php foreach($datas as $data): ?>
          <tr>
            <td><?php echo $ctr +=1;?></td>
            <td class="text-center uppercase"><?php echo $data['code'];?></td>
            <td class="text-left text-capitalize"><?php echo $data['full_name'];?></td>
            <td class="text-left text-capitalize"><?php echo $data['loan_type'];?></td>
            <td class="text-right uppercase"><?php echo fnumber($data['amount']);?></td>
            <td class="text-center uppercase"><?php echo fdate($data['released']);?></td>
            <td class="text-center uppercase"><?php echo fdate($data['due_date']);?></td>
            <td class="text-center "><?php echo $data['terms'];?> month(s)</td>
            <td class="text-center text-capitalize"><?php echo properCase($data['payment_type']);?></td>
          </tr>
          <?php endforeach; ?>
          <?php } ?>
        </tbody>
        <tfoot>
        <?php if (empty($datas)) { ?>
          <tr>
            <td colspan="9" class="text-center">No data available...</td>
          </tr>
        <?php } else { ?>  
          <tr>
            <th class="text-left bottom-" colspan="4">TOTAL</th>
            <th class="text-right bottom-"> <?php echo fnumber($total[0][0]['total']) ?></th>
            <td class="bottom-"></td>
            <td class="bottom-"></td>
            <td class="bottom-"></td>
            <td class="bottom-"></td>
          </tr>
        <?php } ?>
        </tfoot>
      </table>
      
    
    </div>
  </div>  
</body>
<footer>
      <div style="font-size: 10px">
      Date Printed: <?php echo Date('l , F d, Y h:i:s A') ?>
    </div>
</footer>
</html>


<style type="text/css">
  .bottom- {
    border-bottm-style:solid;border-bottom:4px double black;
  } 
</style>
