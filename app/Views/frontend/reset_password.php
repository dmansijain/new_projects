   <!--==========================
    Intro Section
  ============================-->
    <section id="intro" class="clearfix">
        <div class="container h-100">
            <div class="row ">
                <div class="col-md-12 order-md-first order-last">
                    <header class="section-header">
                        <h1 class="border-heading text-center">Reset Password</h1>
                    </header>

                </div>
            </div>

        </div>
    </section><!-- #intro -->
    
    <main id="main">

        <!--==========================
      Services Section
    ============================-->
        <section class="calculater-wrapper section" id="payment-container">
            <div class="container">

                <div class="col-md-12 col-sm-12 white-box-container">
                    
                    <section class="cost-slide">
                        <div id="rootwizard">
						<p style="color:green;">{{ message }}</p>
						<p style="color:red;">{{ error }}</p>
						<form ng-submit="resetpassword()" name="editform">
						<div class="row">
						<div class="col-md-12">
						<div class="form-group">
						<label for="new_password">New Password
                                                            </label>
						<input type="password" class="form-control" ng-model="resetpassword.new_password" />
						<span class="validation-error" ng-show="errors.new_password !=''">{{errors.new_password}}</span>
						</div>
						</div>
						<div class="col-md-12">
						<div class="form-group">
							<label for="new_password">Confirm Password
																</label>
							<input type="password" class="form-control" ng-model="resetpassword.confirm_password" />
							<span class="validation-error" ng-show="errors.confirm_password !=''">{{errors.confirm_password}}</span>
						</div>
						</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<button type="submit" class="btn primary-btn">Save and Continue</button>
							</div>
						</div>
                       </form>
                        </div>
                    </section>
                </div>
            </div>
        </section>