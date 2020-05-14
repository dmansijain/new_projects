<!DOCTYPE html>
<html lang="en" ng-app="LiminalHomes">

<head>
<base href="/liminal/">
    <meta charset="utf-8">
    <title>liminal</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicons -->
    <link href="<?php echo base_url(); ?>assets/frontend/img/favicon.png" rel="icon">
    <!--  <link href="img/apple-touch-icon.png" rel="apple-touch-icon">-->

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS File -->
    <link href="<?php echo base_url(); ?>assets/frontend/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Libraries CSS Files -->
    <link href="<?php echo base_url(); ?>assets/frontend/lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/frontend/lib/animate/animate.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/frontend/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/frontend/lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <!-- Main Stylesheet File -->
    <link href="<?php echo base_url(); ?>assets/frontend/css/style.css" rel="stylesheet">
<script src = "<?php echo base_url(); ?>assets/frontend/js/jquery-2.2.4.min.js"></script>
		
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/css/angular-material.min.css">
		
</head>

<body ng-controller="navCtrl">

    <!--==========================
  Header
  ============================-->
    <header id="header">

        <div class="container-fluid">

            <div class="logo float-left">
                <!-- Uncomment below if you prefer to use an image logo -->
                <h1 class="text-light"><a href="./" class="scrollto">
                        <img src="<?= base_url();?>uploads/sitelogo/{{settingsinfo.logo}}">
                    </a></h1>
                <!-- <a href="#header" class="scrollto"><img src="img/logo.png" alt="" class="img-fluid"></a> -->
            </div>

            <nav class="main-nav float-right d-none d-lg-block" >
                <ul>
                    <li ng-class="{active: $route.current.activetab == 'churches'}"><a href="churches">Churches & Communities</a></li>
                    <li ng-class="{active: $route.current.activetab == 'mens'}"><a href="mens">Mens</a></li>
                    <li ng-class="{active: $route.current.activetab == 'womens'}"><a href="womens">Womens</a></li>
                    <li ng-class="{active: $route.current.activetab == 'couples'}"><a href="couples">Couples</a></li>
                    <li ng-class="{active: $route.current.activetab == 'about'}"><a href="about">About</a></li>
                    <li ng-class="{active: $route.current.activetab == 'contact'}"><a href="contact">Contact</a></li>
					
				<?php	$session = \Config\Services::session();
		//print_r($session->get('user_data')->role);
       if($session->get('is_logged_in')!=true )
            { ?>
            <li class="login-pop-link"><a href="#" data-toggle="modal" data-target="#loginForm"><i class="fa fa-user-circle-o" aria-hidden="true"></i> Log-in/SignUp</a></li>   
        <?php    } else { ?>
                    <li class="login-pop-link"><a href="myprofile"><i class="fa fa-user-circle-o" aria-hidden="true"></i>Hi <?php echo $session->get('user_data')->first_name; ?></a></li>
					<li class="last">
                            <a href="logout">
                                <i class="fa fa-lock"></i>
                                Logout
                            </a>
                        </li>
			<?php } ?>
                </ul>
            </nav><!-- .main-nav -->

        </div>
    </header><!-- #header -->


    

    <div id="raghav"  ng-view ng-animate="{enter: 'view-enter'}"></div>
<main id="main">
        <!--==========================
      testimonial Section
    ============================-->
        <section id="services" class="section-bg">
            <div class="container">
               <div class="w-80" ng-controller="TestimonialCtrl">
                    <header class="section-header text-center">
                        <h4>What our </h4>
                        <h1 class="border-heading text-center">CUSTOMERS SAY</h1>
                    </header>

                    <data-owl-carousel class="owl-carousel" data-options="{{owlOptionsTestimonials}}">
      <div owl-carousel-item="" ng-repeat="item in ::items1" class="item">
        <p ng-bind-html="item.description"></p>
		
                            <p><b>--{{::item.name}}</b></p>
      </div>
	  
    </data-owl-carousel>


                </div>
            </div>
        </section><!-- #testimonial -->

        <!--==========================
      explore Section
    ============================-->
        <section class="explore">
            <div class="container h-100">
                <div class="row ">
                    <div class="col-md-12 order-md-first order-last">
                        <h2 class="text-center">Take your next step. Explore what knowing
                            <br />
                            freedom could look like for you.</h2>

                    </div>
                </div>
				
                <div class="row">
                    <nav class="bottom-nav">
                        <ul>
                            <li ng-class="{active: $route.current.activetab == 'churches'}"><a href="churches">Churches & Communities</a></li>
                            <li ng-class="{active: $route.current.activetab == 'mens'}"><a href="mens">Mens</a></li>
                            <li ng-class="{active: $route.current.activetab == 'womens'}"><a href="womens">Womens</a></li>
                            <li ng-class="{active: $route.current.activetab == 'couples'}"><a href="couples">Couples</a></li>
                        </ul>
                    </nav>
                </div>

            </div>
			
        </section><!-- #explore -->
		
    </main>
	
    <!--==========================
    Footer
  ============================-->
    <section class="footer">

        <div class="container">
            <div class="row">
                <div class="social-link col-md-12  text-center">
                    <a href="{{settingsinfo.facebook}}" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                    <a href="{{settingsinfo.twitter}}" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                </div>
                <div class="email--us col-md-12 text-center">
                    <a href="mailto:{{settingsinfo.email}}">{{settingsinfo.email}}</a>
                </div>
                <div class="col-md-12 copyright  text-center">
                   {{settingsinfo.copyright}}
                </div>
            </div>
        </div>
    </section>

    <!-- #footer -->

    <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
    <!-- Uncomment below i you want to use a preloader -->
    <!-- <div id="preloader"></div> -->

    <!-- JavaScript Libraries -->
     <!--<script src="<?php echo base_url(); ?>assets/frontend/lib/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>lib/jquery/jquery-migrate.min.js"></script>-->
	<script src = "<?php echo base_url(); ?>assets/angular-1.6.9/angular.min.js"></script>
		<script src = "<?php echo base_url(); ?>assets/angular-1.6.9/angular-route.min.js"></script>
		<script src = "<?php echo base_url(); ?>assets/angular-1.6.9/angular-animate.min.js"></script>
		<script src = "<?php echo base_url(); ?>assets/angular-1.6.9/angular-loader.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/angular-1.6.9/angular-sanitize.js"></script>	
	<script src="<?php echo base_url(); ?>assets/frontend/js/ui-bootstrap-tpls.min.js"></script>
		
		<script src = "<?php echo base_url(); ?>assets/frontend/js/angular-ui-utils.min.js"></script>
		<script src = "<?php echo base_url(); ?>assets/frontend/js/jquery.dataTables.min.js"></script>
		<script src = "<?php echo base_url(); ?>assets/frontend/js/dataTables.bootstrap.min.js"></script>
        <!--<script data-require="jquery@1.10.1" data-semver="1.10.1" src="http://code.jquery.com/jquery-1.10.1.min.js"></script>-->
       
        <script src="<?php echo base_url(); ?>assets/frontend/js/q.js"></script>
        <script src="<?php echo base_url(); ?>assets/frontend/js/angular.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/frontend/js/angular-animate.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/frontend/js/angular-aria.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/frontend/js/angular-messages.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/frontend/js/angular-material.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/frontend/js/angular-datatables.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/ckeditor/ckeditor.js"></script>
        <script src="<?php echo base_url(); ?>assets/angular/appHome.js"></script>
        <script src="<?php echo base_url(); ?>assets/angular/controllersHome.js"></script>
		 
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCqjENPSK-HRRe8ia29iZLZB9fNVqC-D_M"></script>
<script>
			var BASE_URL = '<?php echo base_url(); ?>'; 
			var TOKEN = 'xZZAvva+sJzW5VJ92BhTobC7NwLdW85j9Stj3UcxKbZqeaFSoSWI10X8Fmmw5fOINqu5pWm25dcZtnko6zdI7GEN+BSjQIU3Aa5RoAMJpaiB8M8JQgWBfxuq7zGsw+ouTfv+gxRboaOxRhkG737fkA '; 
		</script>
		<script src="<?php echo base_url(); ?>assets/frontend/js/aes.js"></script>
	
    <script src="<?php echo base_url(); ?>assets/frontend/lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/frontend/js/jquery.bootstrap.wizard.js"></script>
    <script src="<?php echo base_url(); ?>assets/frontend/lib/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/frontend/lib/easing/easing.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/frontend/lib/mobile-nav/mobile-nav.js"></script>
    <script src="<?php echo base_url(); ?>assets/frontend/lib/wow/wow.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/frontend/lib/waypoints/waypoints.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/frontend/lib/owlcarousel/owl.carousel.min.js"></script>
    <!--    <script src="lib/isotope/isotope.pkgd.min.js"></script>-->
    <script src="<?php echo base_url(); ?>assets/frontend/lib/lightbox/js/lightbox.min.js"></script>
    <!-- Contact Form JavaScript File -->
    <script src="<?php echo base_url(); ?>assets/frontend/contactform/contactform.js"></script>

    <!-- Template Main Javascript File -->
    <script src="<?php echo base_url(); ?>assets/frontend/js/main.js"></script>
    <div class="modal fade" id="loginForm" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="login" ng-controller="LoginCtrl">
                <form ng-submit="validatelogin()">
                    <div class="modal-header text-center">
                        <h4 class="modal-title w-100 font-weight-bold">Login</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body mx-3"><div ng-show="message !=''"  ng-bind-html="message">{{message}}</div>
                        <div class="md-form mb-3">
                            <label for="yourname">User Name</label>
                            <input type="text" ng-model="logininfo.username" id="form3" class="form-control validate">
                        </div>
                        <div class="md-form mb-3">
                            <label for="youremail">Password</label>
                            <input type="password" ng-model="logininfo.password" id="form2" class="form-control validate">
                        </div>
						<div class="terms-check">
							<div class="container custom-checkbox check-box">
								
								<input type="checkbox" class="agree-check checkhour"  ng-model="logininfo.rememberme">
								<span class="checkmark"></span>
								Remember Me
							</div>
						</div>
                        <div class="md-form mb-3 text-right">
                            <input type="submit" value="Login" class="btn primary-btn" />
                        </div>
                    </div>
                </form>
				<div class="text-center">
				<a href="#" data-toggle="modal" data-target="#forgetpassword" class="dark text-underline forget-link" data-dismiss="loginForm">Forget Your Password</a>
				</div>
                <div class="modal-footer d-flex justify-content-center">
                    <div class="text-center">
                        <p>You don't have account? <a href="#" data-toggle="modal" data-target="#registration" class="dark text-underline regis-link" data-dismiss="loginForm">Register Now</a></p>
                    </div>
                </div>


            </div>

        </div>
    </div>
	
	  <div class="modal fade" id="forgetpassword" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="forget-password" ng-controller="ResetPassCtrl">
                <form  ng-submit="resetpassword()">
                    <div class="modal-header text-center">
                        <h4 class="modal-title w-100 font-weight-bold">Reset password</h4>
						
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body mx-3"><div ng-show="message !=''"  ng-bind-html="message"></div>
                        <div class="md-form mb-3">
                            <label for="yourname">Email</label>
                            <input type="email" ng-model="logininfo.email" id="fpas-email" class="form-control validate">
                        </div>
                        <div class="md-form mb-3">
                     
                        <div class="md-form mb-3 text-right">
                            <input type="submit" value="submit" class="btn primary-btn" />
                        </div>
                    </div>
                </form>
				 </div>
                <div class="modal-footer d-flex justify-content-center">
                    <div class="text-center">
                    <p>You have an account? <a class="dark text-underline login-link" href="#" data-toggle="modal" data-target="#loginForm">Signin</a></p>
                </div>
                </div>


           

        </div>
    </div>
	</div>
	
    <div class="modal fade modal-registration" id="registration" tabindex="-1" role="dialog">
        <div class="modal-dialog " role="document" ng-controller="RegisterCtrl">
            <div class="modal-content" id="">
                <form ng-submit="editproduct()" >
                    <div class="modal-header text-center">
                        <h4 class="modal-title w-100 font-weight-bold">Registration</h4>
						
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="step-container active mx-3 modal-body" id="step1">
                    <div ng-show="rmessage !=''"  ng-bind-html="rmessage">{{rmessage}}</div>
                            <div class="col-md-12">
                                <div class="md-form mb-3">
                                    <label for="self">First Name
                                    </label>
                                    <input type="text" ng-model="registrationinfo.first_name" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="md-form mb-3">
                                    <label for="self">Last Name
                                    </label>
                                    <input type="text" ng-model="registrationinfo.last_name" class="form-control">
                                </div>

                            </div>

                        <div class="col-md-12">
                            <div class="md-form mb-3">
                                <label for="self">Phone No
                                </label>
                                <input type="tel" ng-model="registrationinfo.phone" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="md-form mb-3">
                                <label for="self">Email
                                </label>
                                <input type="email" ng-model="registrationinfo.email" class="form-control">
                            </div>

                        </div>
                           <div class="col-md-12">
                            <div class="md-form mb-3">
                                <label for="youremail">Password</label>
                                <input type="password" ng-model="registrationinfo.password" id="form2" class="form-control validate">
                            </div>

                        </div>
                         <div class="col-md-12">
                            <div class="md-form mb-3">
                                <label for="youremail">Confirm Password</label>
                                <input type="password" ng-model="registrationinfo.confirmpassword" id="form2" class="form-control validate">
                            </div>

                        </div>
                        <div class="col-md-12">
                            <div class="md-form mb-3">
                                <label for="self">Address
                                </label>
                                <input type="tel" ng-model="registrationinfo.address" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="md-form mb-3">
                                <label for="self">City
                                </label>
                                <input type="email" ng-model="registrationinfo.city" class="form-control">
                            </div>

                        </div>
                        <div class="col-md-12">
                            <div class="md-form mb-3">
                                <label for="self">State
                                </label>
                                <input type="tel" ng-model="registrationinfo.state" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="md-form mb-3">
                                <label for="self">Zip
                                </label>
                                <input type="email" ng-model="registrationinfo.zip" class="form-control">
                            </div>

                        </div>
                        <div class="col-md-12">
                            <div class="md-form mb-3 text-right">
                                <input type="submit"  value="SignUp" class="btn primary-btn" />
                            </div>
                        </div>
                   
            </div>
            </form>
            <div class="modal-footer d-flex justify-content-center">
                <div class="text-center">
                    <p>You have an account? <a href="#" class="dark text-underline login-link">Signin</a></p>
                </div>
            </div>
        </div>

    </div>
    </div>
    <script>
		$('.forget-link').on('click', function(){
			 $('#registration').modal('hide'); // hides modal with id viewUser 
            $('#loginForm').modal('hide');
			  $('#forgetpassword').modal('show');
		});
		
        $('.login-link').on('click', function() {
			$('#forgetpassword').modal('hide');
            $('#registration').modal('hide'); // hides modal with id viewUser 
            $('#loginForm').modal('show'); // display modal with id editUser
        });
        $('.regis-link').on('click', function() {
			$('#forgetpassword').modal('hide');
            $('#loginForm').modal('hide'); // hides modal with id viewUser 
            $('#registration').modal('show'); // display modal with id editUser
        });

    </script>
</body>

</html>