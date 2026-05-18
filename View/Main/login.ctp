<!DOCTYPE html>
<html>
<head>
    <title>Login >> E D & C SOLUTIONS</title>
	<link rel="stylesheet" href="<?php echo $this->base ?>/assets/plugins/bootstrap-3.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo $this->base ?>/assets/css/login.css">
	<!--<link rel="icon" href = "<?php echo $this->base ?>/assets/img/favicon.ico">-->
	<script type="text/javascript" src="<?php echo $this->base ?>/assets/plugins/jquery/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->base ?>/assets/js/svg-icon.js"></script>
</head>
<body>
	<section id="login">
        <header>
            <h2 style="color: white; text-align: center" class="uppercase">E D & C SOLUTIONS</h2>
            <p class="uppercase"></p>
        </header>
        <div class="clearfix"></div>
    </section>
    
    <!-- Login -->
    <div style="max-width:900px;margin:auto;padding:50px 0px 20px 0px">
    	<div class="col-md-6" style="padding-top:30px">
    		<img src="<?php echo $this->base ?>/assets/img/ecms-default-logo.png" width="350" style="float:left;margin-left:20px;"> 
    		<div class="clearfix"></div>
    	</div>
    	<div class="col-md-6">
	        <?php echo $this->Form->create('User', array('url'=>array('controller'=>'main', 'action'=>'login'), 'class'=>'', 'id'=>'', 'inputDefaults'=>array('label'=>false, 'div'=>false, 'class'=>'form-control' ))) ?>
	            <h2 class="login-title">SIGN IN</h2>
	            <div class="form-group">
	            	<?php echo $this->Form->input('username', array('required'=>true, 'placeholder'=>'USERNAME', 'autofocus'=>true, 'class'=>'form-control input-form')) ?>
	            </div>
	            <div class="form-group">
	            	<?php echo $this->Form->input('password', array('required'=>true, 'placeholder'=>'PASSWORD', 'class'=>'form-control input-form')) ?>
	            </div>
	            
	            <button class="btn btn-primary pull-right btn-min">
	            	SIGN IN
	            </button>
	        </form>
    	</div>
    </div>
    
    <div class="footer">
    	<div class="copyright">COPYRIGHT &copy 2017 | ALL RIGHTS RESERVED</div>
    	<div class="poweredby">POWERED BY: <a href="http://edncsolutions.com.ph">E D & C SOLUTIONS</a></div>
    </div>
</body>
</html>