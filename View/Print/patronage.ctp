<!DOCTYPE html>
<html>
    <head>
        <title>PATRONAGE REFUND</title>
        <link rel="stylesheet" href="<?php echo $this->base ?>/assets/plugins/bootstrap-3.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo $this->base ?>/assets/css/style.css">
    </head>
<body>
      <div class="col-md-12">
        <div class="text-center uppercase" style="padding:20px 0px 0px 0px; font-size: 16px"><strong><?php echo $this->Global->Settings('cooperative_name') ?></strong></div>
        <div class="text-center text-capitalize" style="padding:0px 0px 20px 0px; font-size: 12px"><?php echo $this->Global->Settings('address') ?></div>
        <div class="text-center uppercase" style="padding:0px 0px 0px 0px; font-size: 16px"><strong><u>RELEASE OF PATRONAGE REFUND</u></strong></div>
        <div class="text-center" style="padding:0px 0px 20px 0px"><sup>For the year ended <?php echo date('F d, Y') ?></sup></div>
      </div>

     <div class="col-md-12">
        <table class="table table-striped shares-table center table-condensed content-loader">
          <thead>
            <tr>
              <th rowspan="2"></th>
              <th rowspan="2">NAME OF MEMBERS</th>
              <th class="text-center uppercase" colspan="<?php echo count($types)?>">Interest paid on the ff.</th>
              <th rowspan="2">TOTAL</th>
              <th rowspan="2">x PER UNIT <br>PATRONAGE</th>
              <th rowspan="2">PATRONAGE <br>REFUND</th>
              <th rowspan="2">AMOUNT <br>DUE</th>
            </tr>
            <tr>
              <?php foreach ($types as $type) : ?>
              <th class="uppercase"><?php echo $type['name']?></th>
              <?php endforeach ?>
            </tr>
          </thead>
          <tbody>
            <?php $index=0;$total_patro = 0;
            foreach ($members as $member) : ?>
            
            <tr>
              <td><?php echo $index+=1;?></td>
              <td class="text-left uppercase"><?php echo properCase($member['full_name'])?></td>
              <?php foreach ($types as $type) : ?>
              <td class="text-right">
                <?php echo @$member[$type['name']] > 0 ? fnumber($member[$type['name']]) : '-'?>
              </td>
              <?php endforeach ?>
              <th class="text-right">
                <?php echo @$member['total_paid_interest'] > 0 ? fnumber($member['total_paid_interest']) : '-'?>
              </th>
              <td class="text-right">
                <?php echo fnumber($per_unit,4)?>
              </td>
              <th class="text-right">
                <?php echo @$member['total_paid_interest'] > 0 ? fnumber($member['total_paid_interest'] * $per_unit) : '-'?>
              </th>
              <th class="text-right">
                <?php echo @$member['total_paid_interest'] > 0 ? fnumber($member['total_paid_interest'] * $per_unit,0) : '-'?>
              </th>
            </tr>
            <?php
              if (@$member['total_paid_interest'] > 0 ) {
                $total_patro +=$member['total_paid_interest'] * $per_unit;
              }
            ?>
            <?php endforeach ?>
          </tbody>
          <tfoot>
            <tr>
              <th class="text-left border-bottom-double " colspan="<?php echo count($types) +2?>">GRAND TOTAL</th>
              <th class="text-right border-bottom-double "><?php echo fnumber($total) ?></th>
              <th class="border-bottom-double"></th>
              <th class="text-right border-bottom-double "><?php echo fnumber($total_patro) ?></th>
              <th class="text-right border-bottom-double "><?php echo fnumber($total_patro,0) ?></th>
            </tr>
          </tfoot>
        </table>
      </div>
</body>
</html>

<style>
  .shares-table {
    font-size: 11px;
  }
  .content-loader tr td {
    white-space: nowrap;
  }
  .content-loader tr th {
    white-space: nowrap;
  }
  .border-bottom-double {
    border-bottm-style:solid;
    border-bottom:4px double black;
  }
</style>