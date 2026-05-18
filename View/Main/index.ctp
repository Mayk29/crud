<!DOCTYPE html>
<html>
<head>
	<title>E D & C SOLUTIONS</title>
	<link rel="stylesheet" href="<?php echo $this->base ?>/assets/plugins/bootstrap-3.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo $this->base ?>/assets/plugins/scrollbar/jquery.mCustomScrollbar.css">
	<link rel="stylesheet" href="<?php echo $this->base ?>/assets/plugins/angular-loading/loading-bar.css">
	<!--<link rel="icon" href = "<?php echo $this->base ?>/assets/img/favicon.ico">-->
	<link rel="stylesheet" href="<?php echo $this->base ?>/assets/css/style.css">
  <script>
    var base = '<?php echo $base ?>';
    var api  = '<?php echo $api  ?>';
    var tmp  = '<?php echo $tmp  ?>';
  </script>
	<script type="text/javascript" src="<?php echo $this->base ?>/assets/plugins/jquery/jquery.min.js"></script>

	<base href="<?php echo $this->base ?>/">
</head>
<body ng-app="ednc">
	<?php echo $this->element('navbar') ?>
	<div class="main">
		<div class="col-md-3">
			<?php echo $this->element('user') ?>
		</div>
		<div class="col-md-9">
			<div ng-view></div>
		</div>
	</div>

  <?php echo $this->element('angularjs') ?>
  <?php echo $this->element('scripts') ?>
	<?php echo $this->fetch('extrajs') ?>
  
</body>
</html>
