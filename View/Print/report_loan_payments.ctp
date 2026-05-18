<!DOCTYPE html>
<html>
<head>
  <title>LOAN PAYMENTS REPORT</title>
  <link rel="stylesheet" href="<?php echo $this->base ?>/assets/plugins/bootstrap-3.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo $this->base ?>/assets/css/style.css">
</head>
<body>
  <div class="row">
    <div class="col-md-12">
      <div class="text-center uppercase" style="padding:20px 0px 0px 0px; font-size: 16px"><strong><?php echo $this->Global->Settings('cooperative_name') ?></strong></div>
      <div class="text-center" style="padding:0px 0px 20px 0px; font-size: 12px"><?php echo $this->Global->Settings('address') ?></div>
      <div class="text-center uppercase" style="padding:0px 0px 0px 0px; font-size: 16px"><strong><u>LOAN PAYMENTS REPORT </u></strong></div>
      <div class="text-center" style="padding:0px 0px 20px 0px"><sup><?php echo $date != '' ? ($date):'' ?></sup></div>
    </div>

    <div class="col-md-12" >    
      <table class="table table-striped vcenter">
        <thead>
          <tr>
            <th class=" text-center w30px"></th>
            <th class="text-center">MEMBER</th>
            <th class="text-center">LOAN ID</th>
            <th class="text-center">REFERENCE NO.</th>
            <th class="text-center">DATE</th>
            <th class="text-center">PRINCIPAL</th>
            <th class="text-center">INTEREST</th>
            <th class="text-center">PENALTY</th>
          </tr>
        </thead>
        <tbody>
          <?php $ctr=0 ?>
          <?php if (!empty($datas)) { ?>
          <?php foreach($datas as $data): ?>
          <tr>
            <td><?php echo $ctr +=1;?></td>
            <td class="text-left text-capitalize"><?php echo $data['full_name'];?></td>
            <td class="text-center uppercase"><?php echo $data['code'];?></td>
            <td class="text-center uppercase"><?php echo $data['or_number'];?></td>
            <td class="text-center uppercase"><?php echo fdate($data['date']);?></td>
            <td class="text-right"><?php echo fnumber($data['principal']);?></td>
            <td class="text-right"><?php echo fnumber($data['interest']);?></td>
            <td class="text-right"><?php echo fnumber($data['penalty']);?></td>
          </tr>
          <?php endforeach; ?>
          <?php } else { ?>
          <tr>
            <td colspan="8" class="text-center">No data available...</td>
          </tr>
          <?php } ?>
        </tbody>
        <?php if (!empty($datas)) {?>
        <tfoot>
          <tr>
            <th class="text-left bottom-" colspan="5">TOTAL</th>
            <th class="text-right bottom-"><?php echo fnumber($total[0][0]['principal']);?></th>
            <th class="text-right bottom-"><?php echo fnumber($total[0][0]['interest']);?></th>
            <th class="text-right bottom-"><?php echo fnumber($total[0][0]['penalty']);?></th>
          </tr>
        </tfoot>
        <?php } ?>
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