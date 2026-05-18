<!DOCTYPE html>
<html>
<head>
  <title>Collection Report</title>
  <link rel="stylesheet" href="<?php echo $this->base ?>/assets/plugins/bootstrap-3.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo $this->base ?>/assets/css/style.css">
</head>
<body>
  <div class="col-md-12">
    <div class="text-center uppercase" style=""></div>
    <div class="text-center" style="padding:5px 0px"><strong> COLLECTION REPORT </strong></div>
    <div class="text-center" style="padding:0px 0px 20px 0px"><?php echo fdate($date,'F d, Y') ?></div>
  </div>

  <div class="col-md-12">
		<table class="table table-bordered center vcenter">
      <tr>
        <th>DATE</th>
        <th>O.R NO</th>
        <th>PB NO</th>
        <th>MEMBER</th>
        <?php foreach($datas['account_ids'] as $ids): ?>
        	<th class="uppercase"><?php echo $ids['value']?></th>
        <?php endforeach ?>
      </tr>
      
      <?php foreach($datas['data'] as $data): ?>
      
      <tr>
        <td><?php echo fdate($data['AccountingEntry']['date'])?></td>
        <td><?php echo $data['AccountingEntry']['code']?></td>
        <td><?php echo $data['Member']['code']?></td>
        <td class="uppercase"><?php echo $data[0]['full_name']?></td>
        
        <?php foreach($datas['account_ids'] as $sub): ?>
        <?php $entryId = $data['AccountingEntry']['id']; $subId = $sub['id'];?>
        
        <td>
        	<?php echo fnumber($datas['AccountingEntrySub'][$entryId .'-'.$subId]['debit']>0?$datas['AccountingEntrySub'][$entryId .'-'.$subId]['debit'] : $datas['AccountingEntrySub'][$entryId .'-'.$subId]['credit'])?>
        </td>
        
        <?php endforeach ?>
      </tr>
      
      <?php endforeach ?>
      
    </table>
  </div>
</body>
</html>



