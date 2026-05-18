<!-- angularjs library -->
<script type="text/javascript" src="<?php echo $serverUrl ?>assets/plugins/angular/angular.min.js"></script>
<script type="text/javascript" src="<?php echo $serverUrl ?>assets/plugins/angular/angular-route.min.js"></script>
<script type="text/javascript" src="<?php echo $serverUrl ?>assets/plugins/angular/angular-resource.min.js"></script>
<script type="text/javascript" src="<?php echo $serverUrl ?>assets/plugins/angular-loading/loading-bar.js"></script>
<script type="text/javascript" src="<?php echo $serverUrl ?>assets/plugins/angular/angular-selectize.js"></script>

<!-- angularjs app -->
<script type="text/javascript" src="<?php echo $serverUrl ?>app/app.js?version=<?php echo time() ?>"></script>
<script type="text/javascript" src="<?php echo $serverUrl ?>app/directives.js?version=<?php echo time() ?>"></script>
<script type="text/javascript" src="<?php echo $serverUrl ?>app/filters.js?version=<?php echo time() ?>"></script>
<script type="text/javascript" src="<?php echo $serverUrl ?>app/services.js?version=<?php echo time() ?>"></script>
<script type="text/javascript" src="<?php echo $serverUrl ?>app/controllers.js?version=<?php echo time() ?>"></script>

<?php
  // Add new modules here as you build them
  $scripts = array(
    'users', 'cruds',
  );
?>

<?php foreach ($scripts as $script): ?>
  <script type="text/javascript" src="<?php echo $serverUrl ?>app/<?php echo $script ?>/service.js?version=<?php echo time() ?>"></script>
  <script type="text/javascript" src="<?php echo $serverUrl ?>app/<?php echo $script ?>/route.js?version=<?php echo time() ?>"></script>
  <script type="text/javascript" src="<?php echo $serverUrl ?>app/<?php echo $script ?>/controller.js?version=<?php echo time() ?>"></script>
<?php endforeach ?>
