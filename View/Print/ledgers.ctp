<!DOCTYPE html>
<html>
<head>
  <title class="text-capitalize"><?php echo $book?> Report</title>
  <link rel="stylesheet" href="<?php echo $this->base ?>/assets/plugins/bootstrap-3.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo $this->base ?>/assets/css/style.css">
</head>
<body>
  <div class="col-md-12">
    <div class="text-center uppercase" style=""><?php echo $book?> REPORT</div>
    <?php if (isset($date)) { ?>
  		  <div class="text-center" style="padding:0px 0px 5px 0px"> <strong><?php echo $date ?></strong></div>
		  <?php } ?>
    <div class="text-center" style="padding:5px 0px"></div>
  </div>

  <div class="col-md-12">
   <table class="table table-bordered table-striped  table-hover center">
      <thead>
				<tr>
					<th colspan="6" class="text-right">TOTAL AMOUNT</th>
					<th class="text-right"><?php echo fnumber($this->Global->TotalArr($tmpData,'amount'),2)?></th>
				</tr>
        <tr>
          <th></th>
          <th style="width:100px">DATE</th>
					<th class="w80px">CODE</th>
					<th class="w80px">PB NO</th>
					<th>NAME</th>
					<th>TRANSACTION</th>
					<th>AMOUNT</th>
        </tr>
      </thead>
      <tbody>
        <?php $ctr = 0; ?>
        <?php foreach($tmpData as $entry): ?>
        
        <tr>
          <td><?php echo $ctr += 1; ?></td>
          <td class="uppercase"><?php echo fdate($entry['date'],'m/d/Y')?></td>
          <td class="uppercase"> <?php echo $entry['code']?></td>
          <td class="uppercase"> <?php echo $entry['passbook']?></td>
          <td class="uppercase"> <?php echo $entry['name']?></td>
          <td class="uppercase"> <?php echo $entry['explanation']?></td>
          <th class="text-right"> <?php echo fnumber($entry['amount'],2)?></th>
        </tr>
        
        <?php endforeach ?>
        
      </tbody>
    </table>
  </div>
</body>
</html>



