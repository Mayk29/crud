<!DOCTYPE html>
<html>
<head>
  <title>MEMBER'S PROFILE</title>
 <link rel="stylesheet" href="<?php echo $this->base ?>/assets/plugins/bootstrap-3.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo $this->base ?>/assets/css/style.css">
  <style type="text/css">
    body {font-family: 'Open Sans';font-size:12px;background:gray;}
    .table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td
    {
      border-bottom: 1px solid #7E7E7E;
      border-top: 0px !important;
      font-size:10px !important;
    }
    th, td {
    padding: 1px;
    text-align: left;
}
    table {border-collapse: separate !important; }
    td {border-bottom: 1px solid;border-color:#7E7E7E;}
    .tdleft {border-bottom: 0px;}
    #photo {
      position: absolute;
      /*border: 1px solid black;*/
      top:0px;
      z-index:1000;
      right:0px;
    }
    
    page[size="Letter"] {
  background: white;
  width: 8.5in;
  height: 11in;
  display: block;
  margin: 0 auto;
  box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
}

  </style>
</head>
<body>
<page size="Letter">
  <div class="col-md-12">    
    <div class="text-center uppercase" style="padding:20px 0px 0px 0px; font-size: 16px"><strong><?php echo $this->Global->Settings('cooperative_name') ?></strong></div>
    <div class="text-center uppercase" style="padding:0px 0px 20px 0px; font-size: 12px"><strong><?php echo $this->Global->Settings('address') ?></strong></div>
    <div class="text-center uppercase" style="padding:0px 0px 20px 0px; font-size: 16px"><strong><u>MEMBER'S PROFILE</u></strong></div>
    <img src="<?php echo $member['Member']['image'];?>" id="photo" width="150" height="150">
  </div>
  
  <div class="row">
    <?php
    $alpha = 'a';
    ?>
    <div class="col-md-12">
      <table width="100%"  cellpadding="50">
        <tr>
          <th style="width:100px">Member ID</th>
          <td colspan="3">: <?php echo $member['Member']['code']?></td>
        </tr>
        <tr>
          <th >Name</th>
          <td colspan="3">: <?php echo $member['Member']['full_name']?></td>
        </tr>
      </table>  
      <table width="100%"  cellpadding="50">
        <tr>
          <th style="width:100px">TIN No</th>
          <td style="width:300px">: <?php echo $member['Member']['tinNo']?></td>

          <th style="width:80px">SSS No</th>
          <td>: <?php echo $member['Member']['sss']?></td>
        </tr>
      </table>  
      
      <br>
      <p><strong>&emsp;I.&emsp;<u>Membership Information</u></strong></p>

      <div style="margin-left:10px">
      <table  width="100%"  cellpadding="50">
        <tr>
          <td class="w30px tdleft"><?php echo $alpha ?>.</td>
          <td style="width:220px" class="tdleft">Membership Date</td>
          <td colspan="3">: <?php echo !is_null($member['MemberMembership']['membership_Date']) ? fdate($member['MemberMembership']['membership_Date']):''?>
          </td>
        </tr>
         <tr>
          <td class="w30px tdleft"><?php echo ++$alpha ?>.</td>
          <td class="tdleft">Type/Kind of Membership</td>
          <td colspan="3">: <?php echo $member['MemberMembership']['MembershipType']['name']?></td>
        </tr>
        <tr>
          <td class="w30px tdleft"><?php echo ++$alpha ?>.</td>
          <td class="tdleft">Initial Capital Subscription</td>
          <td colspan="3"></td>
        </tr>
        <tr>
          <td class="tdleft"></td>
          <td class="tdleft">&emsp;1.&emsp;Number of Share</td>
          <td colspan="3">: <?php echo !is_null($member['MemberMembership']['number_of_share_subscribed']) ? fnumber($member['MemberMembership']['number_of_share_subscribed'],0):''?></td>
        </tr>
        <tr>
          <td class="tdleft"></td>
          <td class="tdleft">&emsp;2.&emsp;Amount</td>
          <td colspan="3">: <?php echo !is_null($member['MemberMembership']['amount_of_share_subscribed']) ? fnumber($member['MemberMembership']['amount_of_share_subscribed']):''?></td>
        </tr>
        
      </table>  
      </div>  
      <br>
      <p><strong>&emsp;II.&emsp;<u>Membership Profile</u></strong></p>
      
      <div style="margin-left:10px">
      <table  width="100%"  cellpadding="50">
        <tr>
          <td class="w30px tdleft"><?php echo ++$alpha ?>.</td>
          <td  class="tdleft" style="width:220px">Address</td>
          <td colspan="3">: <?php echo $member['Member']['address']?></td>
        </tr>
        <tr>
          <td class="w30px tdleft"><?php echo ++$alpha ?>.</td>
          <td  class="tdleft">Birthday</td>
          <td colspan="3">: <?php echo !is_null($member['Member']['birth_Date']) ? fdate($member['Member']['birth_Date']):''?></td>
        </tr>
        <tr>
          <td class="w30px tdleft"><?php echo ++$alpha ?>.</td>
          <td  class="tdleft">Age</td>
          <td colspan="3">: <?php echo $member['Member']['age']?></td>
        </tr>
        <tr>
          <td class="w30px tdleft"><?php echo ++$alpha ?>.</td>
          <td  class="tdleft">Civil Status</td>
           <td colspan="3">: <?php echo $member['CivilStatus']['name']?></td>
        </tr>
        <tr>
          <td class="w30px tdleft"><?php echo ++$alpha ?>.</td>
          <td  class="tdleft">Gender</td>
           <td colspan="3">: <?php echo $member['Member']['gender']?></td>
        </tr>
        <tr>
          <td class="w30px tdleft"><?php echo ++$alpha ?>.</td>
          <td  class="tdleft">Educational Attainment</td>
          <td colspan="3">: <?php echo properCase($member['Member']['education'])?></td>
        </tr>
        <tr>
          <td class="w30px tdleft"><?php echo ++$alpha ?>.</td>
          <td  class="tdleft">Contact Number</td>
          <td colspan="3">: <?php echo $member['Member']['contactNo']?></td>
        </tr>
        <tr>
          <td class="w30px tdleft"><?php echo ++$alpha ?>.</td>
          <td  class="tdleft">Father</td>
          <td colspan="3">: <?php echo $member['Member']['fatherName']?></td>
        </tr>
        <tr>
          <td class="w30px tdleft"><?php echo ++$alpha ?>.</td>
          <td  class="tdleft">Mother</td>
          <td colspan="3">: <?php echo $member['Member']['motherName']?></td>
        </tr>
        <tr>
          <td class="w30px tdleft"><?php echo ++$alpha ?>.</td>
          <td  class="tdleft">Spouse Name</td>
          <td colspan="3">: <?php echo $member['Member']['spouseName']?></td>
        </tr>
        <tr>
          <td class="w30px tdleft"><?php echo ++$alpha ?>.</td>
          <td  class="tdleft">Spouse Age</td>
          <td colspan="3">: <?php echo $member['Member']['spouseAge']?></td>
        </tr>
        <tr>
          <td class="w30px tdleft"><?php echo ++$alpha ?>.</td>
          <td  class="tdleft">Spouse Address</td>
          <td colspan="3">: <?php echo $member['Member']['spouseAddress']?></td>
        </tr>
        <tr>
          <td class="w30px tdleft"><?php echo ++$alpha ?>.</td>
          <td  class="tdleft">Spouse Occupation</td>
          <td colspan="3">: <?php echo $member['Member']['spouseOccupation']?></td>
        </tr>
        <tr>
          <td class="w30px tdleft"><?php echo ++$alpha ?>.</td>
          <td  class="tdleft">Spouse Monthly Income</td>
          <td colspan="3">: <?php echo fnumber($member['Member']['spouseMonthlyIncome'])?></td>
        </tr>
        <tr>
          <td class="w30px tdleft"><?php echo ++$alpha ?>.</td>
          <td  class="tdleft">Occupation</td>
          <td colspan="3">: <?php echo $member['Member']['occupation']?></td>
        </tr>
        <tr>
          <td class="w30px tdleft"><?php echo ++$alpha ?>.</td>
          <td  class="tdleft">Monthly Income</td>
          <td colspan="3">: <?php echo fnumber($member['Member']['monthlyIncome'])?></td>
        </tr>
        <tr>
          <td class="w30px tdleft"><?php echo ++$alpha ?>.</td>
          <td  class="tdleft">Employer Name</td>
          <td colspan="3">: <?php echo $member['Member']['employer']?></td>
        </tr>
        <tr>
          <td class="w30px tdleft"><?php echo ++$alpha ?>.</td>
          <td  class="tdleft">Employer Address</td>
          <td colspan="3">: <?php echo $member['Member']['employerAddress']?></td>
        </tr>
        </tr>
       
      </table>  
       </div>  
      <br>
      <p><strong>&emsp;III.&emsp;<u>Termination of Membership</u></strong></p>
      
      <div style="margin-left:10px">
      <table width="100%"  cellpadding="50">
        <tr>
          <td class="w30px tdleft"><?php echo ++$alpha ?>.</td>
          <td   class="tdleft"style="width:220px">BOD Resolution Number</td>
          <td colspan="3">:</td>
        </tr>
        <tr>
          <td class="w30px tdleft"><?php echo ++$alpha ?>.</td>
          <td  class="tdleft">Date</td>
          <td colspan="3">:</td>
        </tr>
      </table>  
      </div>
    </div>
  </div>  

</page>
  
</body>
</html>    
    