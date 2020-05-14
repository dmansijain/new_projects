<!DOCTYPE html>
<html class="" ng-app="LiminalAdmins">
    
<!-- Mirrored from jaybabani.com/complete-admin/v5.1/preview/ by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 05 Mar 2018 09:13:40 GMT -->
<head>
        <!-- 
         * @Package: Complete Admin - Responsive Theme
         * @Subpackage: Bootstrap
         * @Version: 2.0
         * This file is part of Complete Admin Theme.
        -->
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <meta charset="utf-8" />
        <title>Liminal Admin : Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta content="" name="description" />
        <meta content="" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        
        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/admin/assets/images/favicon.png" type="image/x-icon" />    <!-- Favicon -->
        
        <link href="<?php echo base_url(); ?>assets/admin/assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="<?php echo base_url(); ?>assets/admin/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/admin/assets/plugins/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/admin/assets/fonts/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/admin/assets/css/animate.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/admin/assets/plugins/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" type="text/css"/>
        <!-- CORE CSS FRAMEWORK - END -->

        <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START --> 
        <link href="<?php echo base_url(); ?>assets/admin/assets/plugins/jvectormap/jquery-jvectormap-2.0.1.css" rel="stylesheet" type="text/css" media="screen"/>        <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END --> 

<link href="<?php echo base_url(); ?>assets/js/gritter/css/jquery.gritter.css" rel="stylesheet" type="text/css"/>
 <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/vendor/datatables-tabletools/css/dataTables.tableTools.css">       
<script src = "<?php echo base_url(); ?>assets/frontend/js/jquery-2.2.4.min.js"></script>
		<script src = "<?php echo base_url(); ?>assets/angular-1.6.9/angular.min.js"></script>
		<script src = "<?php echo base_url(); ?>assets/angular-1.6.9/angular-route.min.js"></script>
		<script src = "<?php echo base_url(); ?>assets/angular-1.6.9/angular-animate.min.js"></script>
		<script src = "<?php echo base_url(); ?>assets/angular-1.6.9/angular-loader.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/angular-1.6.9/angular-sanitize.js"></script>	
		<script src="<?php echo base_url(); ?>assets/frontend/js/ui-bootstrap-tpls.min.js"></script>
		
		<script src = "<?php echo base_url(); ?>assets/frontend/js/angular-ui-utils.min.js"></script>
		<script src = "<?php echo base_url(); ?>assets/frontend/js/jquery.dataTables.min.js"></script>
		<script src = "<?php echo base_url(); ?>assets/frontend/js/dataTables.bootstrap.min.js"></script>
       <!-- <script data-require="jquery@1.10.1" data-semver="1.10.1" src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
        <script src="//cdn.datatables.net/1.10.1/js/jquery.dataTables.js"></script>-->
        <script src="<?php echo base_url(); ?>assets/frontend/js/q.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/css/angular-material.min.css">
		<link rel="stylesheet" href="https://cdn.rawgit.com/classlinkinc/angular-material-time-picker/master/dist/md-time-picker.css">
        <script src="<?php echo base_url(); ?>assets/frontend/js/angular-datatables.js"></script>
		 <script src="<?php echo base_url(); ?>assets/frontend/js/angular.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/frontend/js/angular-animate.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/frontend/js/angular-aria.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/frontend/js/angular-messages.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/frontend/js/angular-material.min.js"></script>
		<script src="https://cdn.rawgit.com/classlinkinc/angular-material-time-picker/master/dist/md-time-picker.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/ckeditor/ckeditor.js"></script>
		<script src="<?php echo base_url(); ?>assets/admin/vendor/datatables-tabletools/js/dataTables.tableTools.js"></script>
        <script src="<?php echo base_url(); ?>assets/admin/vendor/angular-datatables/dist/plugins/tabletools/angular-datatables.tabletools.min.js"></script>
		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyCqjENPSK-HRRe8ia29iZLZB9fNVqC-D_M"></script>
		<script type="text/javascript" src="https://cdn.rawgit.com/wpalahnuk/ngAutocomplete/master/src/ngAutocomplete.js"></script>
		
		
        <script src="<?php echo base_url(); ?>assets/angular/appAdmin.js"></script>
        <script src="<?php echo base_url(); ?>assets/angular/controllersAdmin.js"></script>
		<!-- CORE CSS TEMPLATE - START -->
        <link href="<?php echo base_url(); ?>assets/admin/assets/css/style.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/admin/assets/css/responsive.css" rel="stylesheet" type="text/css"/>
        <!-- CORE CSS TEMPLATE - END -->
<script>
			var BASE_URL = '<?php echo base_url(); ?>'; 
			var TOKEN = 'xZZAvva+sJzW5VJ92BhTobC7NwLdW85j9Stj3UcxKbZqeaFSoSWI10X8Fmmw5fOINqu5pWm25dcZtnko6zdI7GEN+BSjQIU3Aa5RoAMJpaiB8M8JQgWBfxuq7zGsw+ouTfv+gxRboaOxRhkG737fkA '; 
		</script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js"></script>
    </head>
    <!-- END HEAD -->

    <!-- BEGIN BODY -->
    <body class=" "><!-- START TOPBAR -->
<div class='page-topbar '>
    <div class='logo-area'>

    </div>
    <div class='quick-area'>
        <div class='pull-left'>
            <ul class="info-menu left-links list-inline list-unstyled">
                <li class="sidebar-toggle-wrap">
                    <a href="javascript:void();" data-toggle="sidebar" class="sidebar_toggle">
                        <i class="fa fa-bars"></i>
                    </a>
                </li>
                
                
               <!-- <li class="hidden-sm hidden-xs searchform">
                    <form action="http://jaybabani.com/complete-admin/v5.1/preview/ui-search.html" method="post">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-search"></i>
                            </span>
                            <input type="text" class="form-control animated fadeIn" placeholder="Search & Enter">
                        </div>
                        <input type='submit' value="">
                    </form>
                </li>-->
            </ul>
        </div>		<?php $session = \Config\Services::session(); ?>
        <div class='pull-right'>
            <ul class="info-menu right-links list-inline list-unstyled">
                <li class="profile">
                    <a href="javascript:void();" data-toggle="dropdown" class="toggle">
                        <img src="<?php echo base_url(); ?>uploads/profilepic/<?php echo $session->get('user_data')->profilepic; ?>" alt="user-image" class="img-circle img-inline">
                        <span><?php echo $session->get('user_data')->first_name; ?> <i class="fa fa-angle-down"></i></span>
                    </a>
                    <ul class="dropdown-menu profile animated fadeIn">
                        <!--<li>
                            <a href="#!/web-settings">
                                <i class="fa fa-wrench"></i>
                                Settings
                            </a>
                        </li>-->
                        <li>
                            <a href="#!/user-edit/<?php echo $session->get('user_data')->ID; ?>">
                                <i class="fa fa-user"></i>
                                Profile
                            </a>
                        </li>
                        <!--<li>
                            <a href="#help">
                                <i class="fa fa-info"></i>
                                Help
                            </a>
                        </li>-->
                        <li class="last">
                            <a href="<?php echo base_url().'login/logout'; ?>">
                                <i class="fa fa-lock"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                </li>
               
            </ul>			
        </div>		
    </div>

</div>
<!-- END TOPBAR -->
<!-- START CONTAINER -->
<div class="page-container row-fluid container-fluid">

    <!-- SIDEBAR - START -->

<div class="page-sidebar pagescroll">

    <!-- MAIN MENU - START -->
    <div class="page-sidebar-wrapper" id="main-menu-wrapper"> 

        <!-- USER INFO - START -->
        <div class="profile-info row">

            <div class="profile-image col-xs-4">
               
                    <img alt="" src="<?php echo base_url(); ?>uploads/profilepic/<?php echo $session->get('user_data')->profilepic; ?>" class="img-responsive img-circle">
                
            </div>

            <div class="profile-details col-xs-8">

                <h3>
                    <?php echo $session->get('user_data')->first_name; ?>

                    <!-- Available statuses: online, idle, busy, away and offline -->
                    <span class="profile-status online"></span>
                </h3>

                <p class="profile-title"><?php echo $session->get('user_data')->role; ?></p>

            </div>

        </div>
        <!-- USER INFO - END -->



        <ul class='wraplist' ng-controller="navCtrl">	
			<li ng-class="{open: $route.current.activetab == 'dashboard'}"> 
				<a href="#!/">
				<i class="fa fa-dashboard"></i>
				<span class="title">Dashboard</span>
				</a>
			</li>
			<li ng-class="{open: $route.current.activetab == 'all-rosters'}"> 
				<a href="#!/all-rosters/0">
				<i class="fa fa-calendar-o"></i>
				<span class="title">Manage Rosters</span>
				</a>
			</li>
			
			<li ng-class="{open: $route.current.activetab == 'all-events'}"> 
				<a href="#!/all-events">
				<i class="fa fa-calendar"></i>
				<span class="title">Manage Events</span>
				</a>
			</li>
			<?php if( $session->get('user_data')->role == 'admin') { ?>
			<li ng-class="{open: $route.current.activetab == 'all-users'}"> 
				<a href="#!/all-users">
				<i class="fa fa-user"></i>
				<span class="title">Manage users</span>
				</a>
			</li>
			<li ng-class="{open: $route.current.activetab == 'all-groups'}"> 
				<a href="#!/all-groups">
				<i class="fa fa-users"></i>
				<span class="title">Group Management</span>
				</a>
			</li>
			<li ng-class="{open: $route.current.activetab == 'all-skills'}"> 
				<a href="#!/all-skills">
				<i class="fa fa-cogs"></i>
				<span class="title">Skills Management</span>
				</a>
			</li>
			<li ng-class="{open: $route.current.activetab == 'all-pages'}"> 
				<a href="#!/all-pages">
				<i class="fa fa-bolt"></i>
				<span class="title">CMS Management</span>
				</a>
			</li>
			<li ng-class="{open: $route.current.activetab == 'all-testimonials'}"> 
				<a href="#!/all-testimonials">
				<i class="fa fa-quote-left"></i>
				<span class="title">All Testimonials</span>
				</a>
			</li>
			
			<li ng-class="{open: $route.current.activetab == 'web-settings'}"> 
				<a href="#!/web-settings">
				<i class="fa fa-cog"></i>
				<span class="title">Web Settings</span>
				</a>
			</li>
			<li ng-class="{open: $route.current.activetab == 'payment-plan-settings'}"> 
				<a href="#!/payment-plan-settings">
				<i class="fa fa-money"></i>
				<span class="title">Payment Plan Settings</span>
				</a>
			</li>
			<?php } ?>
        </ul>
    </div>
    <!-- MAIN MENU - END -->
</div>
<!--  SIDEBAR - END -->
    <!-- START CONTENT -->

				<div  ng-view ng-animate="{enter: 'view-enter'}"></div>
			
    <!-- END CONTENT -->
<div class="chatapi-windows ">




</div>    </div>
    <!-- END CONTAINER -->
<!-- LOAD FILES AT PAGE END FOR FASTER LOADING -->


<!-- CORE JS FRAMEWORK - START --> 
<script src="<?php echo base_url(); ?>assets/admin/assets/js/jquery-1.11.2.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url(); ?>assets/admin/assets/js/jquery.easing.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url(); ?>assets/admin/assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url(); ?>assets/admin/assets/plugins/pace/pace.min.js" type="text/javascript"></script>  
<script src="<?php echo base_url(); ?>assets/admin/assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url(); ?>assets/admin/assets/plugins/viewport/viewportchecker.js" type="text/javascript"></script>  
<script>window.jQuery||document.write('<script src="assets/js/jquery-1.11.2.min.js"><\/script>');</script>
<!-- CORE JS FRAMEWORK - END --> 



<!-- CORE TEMPLATE JS - START --> 
<script src="<?php echo base_url(); ?>assets/admin/assets/js/scripts.js" type="text/javascript"></script> 
<!-- END CORE TEMPLATE JS - END --> 
<script src="<?php echo base_url(); ?>assets/admin/js/custom.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/gritter/js/jquery.gritter.js" type="text/javascript"></script>
<!-- General section box modal start -->
<div class="modal" id="section-settings" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog animated bounceInDown">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Section Settings</h4>
            </div>
            <div class="modal-body">

                Body goes here...

            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                <button class="btn btn-success" type="button">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!-- modal end -->
</body>

<!-- Mirrored from jaybabani.com/complete-admin/v5.1/preview/ by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 05 Mar 2018 09:16:03 GMT -->
</html>



