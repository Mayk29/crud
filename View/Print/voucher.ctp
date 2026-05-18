<!DOCTYPE html>
<html>
<head>
	<title>VOUCHER</title>
	<link rel="stylesheet" href="<?php echo $this->base ?>/assets/plugins/bootstrap-3.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo $this->base ?>/assets/css/style.css">
	
	  <style>
      body { font-family: Courier New;}
      .table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td{    
        border-top: 0px !important;
        padding: 3px  !important;
      }
      .table2 >thead {
        border: 1px solid #333  !important;
        margin-top: -20px  !important;
      }
      .table2 >tfoot {
        border: 1px solid #333  !important;
      }
  </style>
  
</head>
<body>
	<div class="row">
		<div class="col-md-12">
			<div class="text-center" style="padding:5px 0px"><strong><?php echo $this->Global->Settings('cooperative_name') ?></strong></div>
			<div class="text-center uppercase" style="padding:10px 0px 0px 0px"><strong><?php echo $entry['AccountingBook']['name']; ?> VOUCHER</strong></div>
		</div>
		  
		  <div class="col-md-6 col-md-offset-3">
		    
        <table class="table vcenter">
          <tr>
            <td class="w100px">NAME </td>
            <td>: <?php echo $entry['Member']['full_name'];?></td>
          </tr>
          <tr>
            <td class="w100px">PARTICULARS </td>
            <td>: <?php echo $entry['AccountingEntry']['explanation'];?></td>
          </tr>
          <tr>
            <td class="w100px">VOUCHER NO </td>
            <td>: <?php echo $entry['AccountingEntry']['code'];?></td>
          </tr>
          <tr>
            <td class="w100px">ENTRY DATE</td>
            <td>: <?php echo fdate($entry['AccountingEntry']['date']);?></td>
          </tr>
          <tr>
            <td class="w100px">PRINT DATE</td>
            <td>: <?php echo date('m/d/Y');?></td>
          </tr>
        </table>
         <table class="table vcenter table2" style="margin-top: -20px">
           <thead>
             <tr>
               <td class="w80px text-left">CODE</td>
               <td class="text-left">DESCRIPTION</td>
               <td class="w100px text-right">DEBIT</td>
               <td class="w100px text-right">CREDIT</td>
             </tr>
            </thead>
            <tbody>
              <?php foreach($entry['AccountingEntrySub'] as $sub): ?>
              <tr>
                 <td><?php echo $sub['Account']['code']?></td>
                 <td class="text-left uppercase"><?php echo $sub['Account']['name']?></td>
                 <td class="text-right"><?php echo $sub['debit'] > 0 ? fnumber($sub['debit']) : ''?></td>
                 <td class="text-right"><?php echo $sub['credit'] > 0 ? fnumber($sub['credit']) : ''?></td>
              </tr>
              <?php endforeach ?>
            </tbody>
            <tfoot>
             <tr>
               <td class="text-left">TOTAL</td>
               <td></td>
               <td class="w100px text-right"><?php echo fnumber($this->Global->TotalArr($entry['AccountingEntrySub'],'debit'))?></td>
               <td class="w100px text-right"><?php echo fnumber($this->Global->TotalArr($entry['AccountingEntrySub'],'credit'))?></td>
             </tr>
            </tfoot>        
          </table>
		  </div>

	</div>
</body>
</html>



