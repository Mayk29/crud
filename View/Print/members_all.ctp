<!DOCTYPE html>
<html>
<head>
  <title>MEMBERS</title>
 <link rel="stylesheet" href="<?php echo $this->base ?>/assets/plugins/bootstrap-3.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo $this->base ?>/assets/css/style.css">
  <style>
  /*body { font-family: Times New Roman;}*/
  </style>
</head>
<body>
  <div class="col-md-12">    
    <div class="text-center uppercase" style="padding:20px 0px 0px 0px; font-size: 16px"><strong><?php echo $this->Global->Settings('cooperative_name') ?></strong></div>
    <div class="text-center uppercase" style="padding:0px 0px 20px 0px; font-size: 12px"><strong><?php echo $this->Global->Settings('address') ?></strong></div>
    <div class="text-center uppercase" style="padding:0px 0px 20px 0px; font-size: 16px"><strong><u>MEMBER'S MASTERLIST REPORT</u></strong></div>

  </div>
	  
  <div class="col-md-12">
    <table class="table table-striped vcenter">
          <thead>
            <tr>
              <th class="w30px"></th>
							<th class="w120px text-center">ID NO.</th>
							<th class="text-center">NAME</th>
              <th class="w200px text-center">MEMBERSHIP TYPE</th>
            </tr>
          </thead>
          <tbody>
            <?php 
              $num = 0;   
            ?>
				    <?php foreach($members as $member): ?>            
  						<tr>
  							<td><?php echo $num+=1 ?></td>
  							<td class="text-center"><?php echo $member[0]['code'] ?></td>
                <td class="uppercase text-left"><?php echo $member[0]['full_name'] ?></td>
                <td class="uppercase text-center"><?php echo $member['MembershipType']['name'] ?></td>
  						</tr>
					  <?php endforeach ?>
					</tbody>
    </table>
  </div>

</body>
</html>    
    