<div class="user-info">
	

	<div class="user-image">
		<?php
			$image = '/assets/img/user-male.jpg';
			echo $this->Thumbnail->render($image, array('path' => '',
				'width' => '150', 'height' => '150',
				'resize' => 'crop','quality' => '100'
			), array('class' => 'img-circle img-responsive', 'alt' => ''));
		?>
	</div>
	<div class="user-name"><?php echo $currentUser['User']['first_name'] . ' ' . $currentUser['User']['last_name'] ?></div>
	<div class="user-designation uppercase"><?php echo $currentUser['Role']['name'] ?></div>
	<hr>
	
	<div class="sign-out">
		<div class="col-md-6">
			<a href="<?php echo Router::url(array('controller'=>'main', 'action'=>'logout')) ?>" class="logout">
				<i class="fa fa-sign-out"></i> SIGN OUT
			</a>
		</div>
		<div class="clearfix"></div>
	</div>
</div>