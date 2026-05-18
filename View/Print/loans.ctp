<!DOCTYPE html>
<html>
    <head>
        <title class="text-capitalize">Loans</title>
        <link rel="stylesheet" href="<?php echo $this->base ?>/assets/plugins/bootstrap-3.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo $this->base ?>/assets/css/style.css">
        <style type="text/css">
        .bottom- {
    border-bottom-style:solid;border-bottom:4px double black;
  } </style>
    </head>
    <body>
        <div class="col-md-12">
            <div class="text-center uppercase" style="padding:20px 0px 0px 0px; font-size: 16px"><strong><?php echo $this->Global->Settings('cooperative_name') ?></strong></div>
            <div class="text-center uppercase" style="padding:0px 0px 20px 0px; font-size: 12px"><strong><?php echo $this->Global->Settings('address') ?></strong></div>
            <div class="text-center uppercase" style="padding:0px 0px 20px 0px; font-size: 16px"><strong><u>LOANS REPORT</u></strong></div>

        </div>

        <div class="col-md-12">
            <table class="table table-striped center vcenter">
                <thead>
                    <tr>
                        <th style="width:30px">#</th>
                        <th>LOAN NO.</th>
                        <th>DUE DATE</th>
                        <th>BORROWER'S NAME</th>
                        <th>LOAN TYPE</th>
                        <th>AMOUNT</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $ctr = 0;
              foreach ($loans as $loan) { ?>
                    <tr>
                        <td><?php  echo $ctr +=1;?></td>
                        <td><?php  echo $loan['code']?></td>
                        <td class="uppercase"><?php  echo fdate($loan['due_date'],'m/d/Y')?></td>
                        <td class="uppercase text-left"><?php  echo $loan['full_name']?></td>
                        <td class="uppercase text-left"><?php  echo $loan['name']?></td>
                        <td class="text-right"><?php  echo fnumber($loan['amount'])?></td>
                    </tr>
                    <?php } ?>
                     <?php if (empty($loans)) {?>               
                      <tr ng-if="loans == ''">
                        <td colspan="6">No data available.</td>
                      </tr>
                     <?php } ?>
                </tbody>
                <tfoot>
                  <tr>
                        <th colspan="5" class="text-left bottom-">TOTAL</th>
                        <th  class="text-right bottom-"><?php  echo fnumber($total)?></th>
                    </tr>
                </tfoot>
            </table>
        </div>

    </body>
</html>
