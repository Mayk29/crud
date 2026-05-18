<!DOCTYPE html>
<html>
<head>
	<title>INCOME STATEMENT REPORT</title>
	<link rel="stylesheet" href="<?php echo $this->base ?>/assets/plugins/bootstrap-3.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo $this->base ?>/assets/css/style.css">
</head>
<body>
<div>
    <?php
    // echo '<pre>';
    // print_r ($response);
    // echo '</pre>';
    ?>
  <div class="panel panel-primary">
      
      <div class="panel-body">
        <div class="col-md-12">
          <div class="text-center" style=""><?php echo $response['company'];?></div>
          <div class="text-center" style="padding:5px 0px">INCOME STATEMENT</div>
          <div class="text-center" style="padding:0px 0px 20px 0px"> as of <?php echo date("F j, Y,", strtotime($response['endDate']));?></div>
        </div>
        
        <div class="col-md-12" >
          <table class="table table-bordered">
            <tbody>
              <tr class="bg-primary">
                <th class="text-center">REVENUES</th>
                <th class="text-center" style="width:120px">TO DATE AMOUNT</th>
                <th class="text-center" style="width:120px"><?php echo date("F", strtotime($response['endDate']));?></th>
              </tr>
              <?php foreach($response['result']['hard'] as $rest): ?>
              <tr>
              <td class="uppercase"><?php echo $rest['name']?></td>
              <td class="text-right"><?php echo $rest['fix'] > 0? number_format($rest['fix'], 2): '('. number_format(abs($rest['fix']), 2).')' ?></td>
              <td class="text-right"><?php echo $rest['not'] > 0? number_format($rest['not'], 2): '('. number_format(abs($rest['not']), 2).')' ?></td>
              </tr>
              
              <?php endforeach ?>
              <tr class="bg-success">
                <th class="text-right">TOTAL REVENUES</th>
                <td class="text-right"><?php echo $response['total']['fixrev'] > 0? number_format($response['total']['fixrev'], 2): '('. number_format(abs($response['total']['fixrev']), 2).')' ?></td>
                <th class="text-right"><?php echo $response['total']['revenues'] > 0? number_format($response['total']['revenues'], 2): '('. number_format(abs($response['total']['revenues']), 2).')' ?></th>
              </tr>
              <tr>
                <td colspan="2" style="height:50px"></td>
              </tr>
            </tbody>

            <tbody>
              <tr class="bg-primary">
                <th class="text-center">EXPENSES</th>
                <th class="text-center" style="width:120px">TO DATE AMOUNT</th>
                <th class="text-center" style="width:120px"><?php echo date("F", strtotime($response['endDate']));?></th>
              
              </tr>
              <?php foreach($response['result']['hardest'] as $entry): ?>
              <tr>
              <td><?php echo $entry['name']; ?></td>
              <td class="text-right"><?php echo $entry['not'] > 0? number_format($entry['not'], 2): '('. number_format(abs($entry['not']), 2).')' ?></td>
              <td class="text-right"><?php echo $entry['fix'] > 0? number_format($entry['fix'], 2): '('. number_format(abs($entry['fix']), 2).')' ?></td>
              </tr>
              <?php endforeach ?>
              <tr class="bg-success">
                <th class="text-right">TOTAL EXPENSES</th>
                <!--<td></td>-->
                <th class="text-right"><?php echo $response['total']['fixexp'] > 0? number_format($response['total']['fixexp'], 2):'('.number_format(abs($response['total']['fixexp']), 2).')' ?></th>
                <th class="text-right"><?php echo $response['total']['expenses'] > 0? number_format($response['total']['expenses'], 2):'('.number_format(abs($response['total']['expenses']), 2).')' ?></th>
              </tr>
              <tr>
                <td colspan="2" style="height:20px"></td>
              </tr>
            </tbody>
            <tbody>
              <tr class="darken">
                <th class="text-right">TOTAL INCOME</th>
                <th class="text-right"><?php echo $response['total']['fixIncome'] > 0? number_format($response['total']['fixIncome'], 2):'('.number_format(abs($response['total']['fixIncome']), 2).')' ?></th>
                <th class="text-right"><?php echo $response['total']['netIncome'] > 0? number_format($response['total']['netIncome'], 2):'('.number_format(abs($response['total']['netIncome']), 2).')' ?></th>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
  </div>
</div>
</body>
</html>