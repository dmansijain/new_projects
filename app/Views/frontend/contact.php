<!--==========================
    Intro Section
  ============================-->
    <section id="intro" class="clearfix">
        <div class="container h-100">
            <div class="row ">
                <div class="col-md-12 order-md-first order-last">
                    <header class="section-header">
                        <h1 class="border-heading text-center">CONTACT</h1>
                    </header>

                </div>
            </div>

        </div>
    </section><!-- #intro -->

    <main id="main">

        <!--==========================
      Services Section
    ============================-->
        <section id="portfolio" class="section-bg tab-design">

            <div class="container">
                <div class="w-80">

                        <div class="col-md-12 col-sm-12 white-box-container">
						
                    <section class="cost-slide">
                        <div id="rootwizard">
						<p style="color:green;">{{ message }}</p>
						<p style="color:red;">{{ error }}</p>
						<form ng-submit="sendmessage()" name="editform">
						<div class="row">
						<div class="col-md-6">
						<div class="form-group">
						<label for="name">Name
                                                            </label>
						<input type="text" class="form-control" ng-model="contactinfo.name" />
						<span class="validation-error" ng-show="errors.name_error !=''">{{errors.name_error}}</span>
						</div>
						</div>
						<div class="col-md-6">
						<div class="form-group">
							<label for="email">Email
																</label>
							<input type="email" class="form-control" ng-model="contactinfo.email" />
							<span class="validation-error" ng-show="errors.email_error !=''">{{errors.email_error}}</span>
						</div>
						</div>
						<div class="col-md-12">
						<div class="form-group">
							<label for="phone">Phone Number
																</label>
							<input type="text" class="form-control" ng-model="contactinfo.phone" />
							<span class="validation-error" ng-show="errors.phone_error !=''">{{errors.phone_error}}</span>
						</div>
						</div>
						<div class="col-md-12">
						<div class="form-group">
							<label for="message">Message
																</label>
							<textarea class="form-control" ng-model="contactinfo.message" /></textarea>
							<span class="validation-error" ng-show="errors.message_error !=''">{{errors.message_error}}</span>
						</div>
						</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<button type="submit" class="btn primary-btn">Send Message</button>
							</div>
						</div>
                       </form>
                        </div>
                    </section>
                </div>
                   


                </div>
            </div>
        </section><!-- #services -->
</main>

