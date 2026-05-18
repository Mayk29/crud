<!DOCTYPE html>
<html>
    <head>
        <title> LOGS REPORT</title>
        <link rel="stylesheet" href="<?php echo $this->base ?>/assets/plugins/bootstrap-3.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo $this->base ?>/assets/css/style.css">
    </head>
    <body ng-app="ehrms" style="background-color:white">

        <div class="row">
            <div class="text-center uppercase" style="">
                <strong>LOGS REPORT</strong>
                <br>
                <sub><i><?php echo $filters?></i></sub>
            </div>
            <div class="main col-md-12">
                <div class="col-md-12">
                    <table class="table table-bordered center">
                        <thead>
                            <tr>
                                <th class="w30px"></th>
                                <th class="text-center'">DATETIME</th>
                                <th class="text-center">USER</th>
                                <th class="text-center">ACTION</th>
                                <th class="text-center">DESCRIPTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $ctr=0;foreach($logs as $log): ?>
                            <tr>
                                <td><?php echo $ctr += 1;?></td>
                                <td class="uppercase text-center"><?php echo fdate($log['created'],'M d,Y h:i A') ?></td>
                                <td class="text-center uppercase"><?php echo $log['user'] ?></td>
                                <td class="text-center uppercase"><?php echo $log['action'] ?></td>
                                <td class="text-center uppercase"><?php echo $log['description'] ?></td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>
