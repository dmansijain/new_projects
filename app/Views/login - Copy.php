<!doctype html>
<html lang="en-US" ng-app="SoohooLogin">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Soohoo</title>
<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="assets/css/flaticon.css" rel="stylesheet" type="text/css">
<link href="assets/css/stylesheet.css" rel="stylesheet" type="text/css">
<script src = "https://code.jquery.com/jquery-2.2.4.min.js"></script>
		<script src = "<?php echo base_url(); ?>assets/angular-1.6.9/angular.min.js"></script>
		<script src = "<?php echo base_url(); ?>assets/angular-1.6.9/angular-route.min.js"></script>
		<script src = "<?php echo base_url(); ?>assets/angular-1.6.9/angular-animate.min.js"></script>
		<script src = "<?php echo base_url(); ?>assets/angular-1.6.9/angular-loader.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/angular-1.6.9/angular-sanitize.js"></script>	
		<script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/0.10.0/ui-bootstrap-tpls.min.js"></script>
		<script src = "https://cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/2.0.0/ui-bootstrap-tpls.min.js"></script>
		<script src = "https://cdnjs.cloudflare.com/ajax/libs/angular-ui-utils/0.1.1/angular-ui-utils.min.js"></script>
		<script src = "https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/js/jquery.dataTables.min.js"></script>
		<script src = "https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
        <script data-require="jquery@1.10.1" data-semver="1.10.1" src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
        <script src="//cdn.datatables.net/1.10.1/js/jquery.dataTables.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/q.js/0.9.2/q.js"></script>
        
        <script src="https://rawgithub.com/l-lin/angular-datatables/v0.6.1/dist/angular-datatables.js"></script>
        <script src="<?php echo base_url(); ?>assets/angular/appLogin.js"></script>
        <script src="<?php echo base_url(); ?>assets/angular/controllersLogin.js"></script>
<script>
			var BASE_URL = '<?php echo base_url(); ?>'; 
			var TOKEN = 'xZZAvva+sJzW5VJ92BhTobC7NwLdW85j9Stj3UcxKbZqeaFSoSWI10X8Fmmw5fOINqu5pWm25dcZtnko6zdI7GEN+BSjQIU3Aa5RoAMJpaiB8M8JQgWBfxuq7zGsw+ouTfv+gxRboaOxRhkG737fkA '; 
		</script>
</head>

<body>

<div class="login-pg dispetcher-login" >
	<div class="row">
    	<div style="position:relative">
				<div style="width:100%" ng-view ng-animate="{enter: 'view-enter'}"></div>
			</div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/js/jquery-2.2.4.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
<!--<script src="assets/js/custom.js"></script>-->
</body>
</html>
