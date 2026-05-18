<!DOCTYPE html>
<html>
<head>
  <title>Interest Incomes</title>
  <link rel="stylesheet" href="<?php echo $this->base ?>/assets/plugins/bootstrap-3.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo $this->base ?>/assets/css/style.css">
  <style>
  table.info td { padding-left: 20px} 
  body { margin: 20px 20px}
  .bggray {background-color: #D1D1D1}
  </style>
</head>
<body>
  <div class="row">
    <div class="col-md-12">    
      <div class="text-center uppercase" style="padding:20px 0px">Interest Incomes</div>
    </div>
    
    <div class="col-md-12">
      <table class="table table-bordered center vcenter">
        <thead>
          <tr>
            <th style="width:30px">#</th>
            <th>PAYER'S NAME</th>
            <th>DATE GRANTED</th>
            <th>LOAN CDV#</th>
            <th>INTEREST</th>
            <th>PAID</th>
            <th>BALANCE</th>
          </tr>
        </thead>
        <tbody>
          <?php $ctr=0 ?>
          <?php foreach($tmpData as $data): ?>
          <tr>
            <td><?php echo $ctr+=1 ?></td>
            <td class="uppercase"><?php echo $data['Member']['full_name'] ?></td>
            <td class="uppercase"><?php echo fdate($data['Loan']['date_approved'],'M d, Y') ?></td>
            <td><?php echo $data['Loan']['code'] ?></td>
            <td><?php echo fnumber($data['Loan']['interest_amount'],2) ?></td>
            <td><?php echo fnumber($data['Loan']['interest_paid'],2) ?></td>
            <td><?php echo fnumber($data['Loan']['interest_balance'],2) ?> </td>
            <td>
              <div class="btn-group btn-group-xs">
                <a href="#/loan/view/{{data.Loan.id}}" class="btn btn-success no-border-radius"><i class="fa fa-eye"></i></a>
              </div>
            </td>
          </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
    
  </div>
</body>
</html>
