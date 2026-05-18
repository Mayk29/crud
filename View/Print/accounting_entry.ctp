<!DOCTYPE html>
<html>
<head>
  <title>Accounting Entry</title>
 <link rel="stylesheet" href="<?php echo $this->base ?>/assets/plugins/bootstrap-3.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo $this->base ?>/assets/css/style.css">
  <style>
  /*body { font-family: Times New Roman;}*/
  </style>
</head>
<body>
  <div class="col-md-12">    
    <div class="text-center uppercase" style="padding:20px 0px">Accounting Entry Report</div>
  </div>
	  
  <div class="col-md-12">
    <table class="table table-bordered table-condensed table-hover table-entries vcenter">
      <thead>
        <tr>
          <th class="text-center w150px">LEDGER</th>
          <th class="text-center w90px">CODE</th>
          <th class="text-center w90px">DATE</th>
          <th colspan="4" class="text-center">EXPLANATION</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th class="text-center uppercase"><?php echo $data['AccountingBook']['name'] ?></th>
          <th class="text-center uppercase"><?php echo $data['AccountingEntry']['code'] ?></th>
          <th class="text-center uppercase"><?php echo $data['AccountingEntry']['date'] ?></th>
          <th class="uppercase italic text-center" colspan="4"><?php echo $data['AccountingEntry']['explanation'] ?></th>
        </tr>
        <tr>
          <th class="text-center" colspan="5"></th>
          <th class="text-right w120px">DEBIT</th>
          <th class="text-right w120px">CREDIT</th>
        </tr>
         <?php foreach($data['AccountingEntrySub'] as $AccountingEntrySub): ?>
        <tr>
       
          <td class="text-right uppercase" colspan="5"><?php echo $AccountingEntrySub['name'] ?></td>
          <td class="text-right"><?php echo fnumber($AccountingEntrySub['debit']) ?></td>
          <td class="text-right"><?php echo fnumber($AccountingEntrySub['credit']) ?></td>
        
        </tr>
        <?php endforeach ?>
        <tr>
          <th class="text-right uppercase" colspan="5">TOTAL</th>
          <th class="text-right"><?php echo fnumber($this->Global->TotalArr($data['AccountingEntrySub'],'debit')); ?></th>
          <th class="text-right"><?php echo fnumber($this->Global->TotalArr($data['AccountingEntrySub'],'credit')); ?></th>
        </tr>
      </tbody>
    </table> 
  </div>

</body>
</html>    
    