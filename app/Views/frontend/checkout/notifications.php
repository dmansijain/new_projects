<!--==========================
    Intro Section
  ============================-->
    <section id="intro" class="clearfix">
        <div class="container h-100">
            <div class="row ">
                <div class="col-md-12 order-md-first order-last">
                    <header class="section-header">
                        <h1 class="border-heading text-center">sign up</h1>
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

                <div class="col-md-12 col-sm-12 p-0 white-box-container">

                    <section class="cost-slide">
                        <div id="rootwizard">
						<?php	echo view('frontend/checkout/checkoutnavigation'); ?>
                            
                             
                            <div class="tab-content cal-slider w-88">
                                  <h4 class="event-detail-heading"><b>{{eventinfo.typenametitle ? eventinfo.typenametitle : eventinfo.event_typename}} </b>on <b>{{eventinfo.start_date}}</b> for <b>{{eventinfo.cattitle}} </b> at <b>{{eventinfo.location}}</b></h4>
								 <p style="color:red;">{{message}}</p>
								 <form ng-submit="checkprocess()" name="editform" enctype="multipart/form-data"> 
<div class="tab-pane box-design active" id="tab5">
                                    <div class="col-md-12">
                                        
                                            <div class="row heading">
                                                <div class="col-md-8 p-0">
                                                    <header class="section-header">
                                                        <h1 class="border-heading text-left ml-0 f50">Notification                                             
                                                        </h1>
                                                      
                                                    </header>

                                                </div>
<!--                                                  <span class="explain">Click to receive information</span>-->
                                            </div>
                                            <a href="#step5" class="step-heading"> Notification  </a>

                                            <div class="step-container" id="step5">
                                                <div class="row radio-container">
                                                    <div class="col-md-12">
                                                        <div class="row form-group">
                                                            <div class="col-md-12 check-box left-check">
															
                                              <input type="checkbox" name="radio-group" id="" ng-model="notificationinfo.notification_check" class="agree-check" value= "true" ng-value= "true" ng-init="notificationinfo.notification_check=true">
                                                                <span class="checkmark"></span>
                                                                Get notification via email
                                                            </div>
												<span class="validation-error" ng-show="notificationinfo.notification_check_error !=''">{{notificationinfo.notification_check_error}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        
                                    </div>
                                </div>
								 <ul class="pager wizard">

                                    <li class="finish text-center"><button type="submit" class="btn primary-btn">Submit</button></li>
                                </ul>
								</form>
								</div>
                        </div>
                    </section>
                </div>
            </div>
        </section>