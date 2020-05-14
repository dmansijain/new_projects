<!--==========================
    Intro Section
  ============================-->
    <section id="intro" class="clearfix">
        <div class="container h-100">
            <div class="row ">
                <div class="col-md-12 order-md-first order-last">
                    <header class="section-header">
                        <h1 class="border-heading text-center">PROFILE</h1>
                    </header>

                </div>
            </div>

        </div>
    </section><!-- #intro -->

        <main id="main">

        <!--==========================
      Services Section
    ============================-->
        <section id="profile-tab" class="section section-bg tab-design">

            <div class="container">
                <div class="w-80">

                    <div class="row justify-content-center goth" >
				<?php	echo view('frontend/profilenavigation'); ?>
                      
                        <div class="col-md-12 col-sm-12 white-box-container">
						
                    <section class="cost-slide">
                        <div id="rootwizard">
						<p style="color:green;">{{ message }}</p>
						<p style="color:red;">{{ error }}</p>
						<form ng-submit="changepassword()" name="editform">
						<div class="row">
						<div class="col-md-12">
						<div class="form-group">
						<label for="new_password">New Password
                                                            </label>
						<input type="password" class="form-control" ng-model="profileinfo.new_password" />
						<span class="validation-error" ng-show="errors.new_password !=''">{{errors.new_password}}</span>
						</div>
						</div>
						<div class="col-md-12">
						<div class="form-group">
							<label for="new_password">Confirm Password
																</label>
							<input type="password" class="form-control" ng-model="profileinfo.confirm_password" />
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


                </div>
            </div>
        </section><!-- #services -->


        <!--==========================
      explore Section
    ============================-->
        <section class="explore ">
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
                            <li><a href="#">Churches & Communities</a></li>
                            <li class="active"><a href="#">Mens</a></li>
                            <li><a href="#">Womens</a></li>
                            <li><a href="#">Couples</a></li>
                        </ul>
                    </nav>
                </div>

            </div>
        </section><!-- #explore -->
    </main>