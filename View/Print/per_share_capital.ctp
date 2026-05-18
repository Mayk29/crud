<!DOCTYPE html>
<html>
<head>
	<title>SHARE CAPITALS REPORT</title>
	<link rel="stylesheet" href="<?php echo $this->base ?>/assets/plugins/bootstrap-3.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo $this->base ?>/assets/css/style.css">
</head>
<body>
	<div class = "container">
	<div class="row">
		<div class="col-md-12">
      <div class="text-center uppercase" style="padding:20px 0px 0px 0px; font-size: 16px"><strong><?php echo $this->Global->Settings('cooperative_name') ?></strong></div>
      <div class="text-center uppercase" style="padding:0px 0px 20px 0px; font-size: 12px"><strong><?php echo $this->Global->Settings('address') ?></strong></div>
      <div class="text-center uppercase" style="padding:0px 0px 20px 0px; font-size: 16px"><strong><u>SHARE CAPITAL REPORT OF <i><?php echo $member; ?></i></u></strong></div>

		</div>
	  
	  <br><br> 
	  
		<div class="col-md-12">
			<table class="table table-striped">
  			<thead>
  				<tr>
            <th class="w30px">#</th>
  					<th class="text-center">DATE </th>
  					<th class="text-center">REFERENCE NO </th>
  					<th class="text-center">AMOUNT</th>
  				</tr>
  			</thead>
  			<tbody>		
  				<?php $index = 0; foreach($datas as $data): ?>
  				<tr ng-repeat="share in data">
            <td><?php echo $index+=1; ?></td>
            <td class="uppercase text-center"><?php echo fdate($data['date']) ?></td>
            <td class="text-center"><?php echo $data['code'] ?></td>
            <td class="uppercase text-center"><?php echo fnumber($data['amount']) ?></td>
          </tr>
  				<?php endforeach ?>
  				<tr>
					  <th class="bottom-" colspan="3">TOTAL</th>
					  <th class="uppercase text-center bottom-"><?php echo fnumber($total) ?></th>
					</tr>
  				<?php if (empty($datas)) { ?>
					<tr>
    					<td colspan="4" class="text-center">No data available ...</td>
    				</tr>
    			<?php } ?>
  			</tbody>
  		</table>
		</div>
		
	</div>
</div>
</body>
</html>


<style type="text/css">
  .bottom- {
    border-bottom-style:solid;border-bottom:4px double black;
  } 
</style>
