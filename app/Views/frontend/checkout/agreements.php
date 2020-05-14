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
<div class="tab-pane login active" id="tab3">
                                    <div class="col-md-12">
                                        <form ng-submit="checkprocess()" name="editform" enctype="multipart/form-data">
                                            <div class="row heading">
                                                <div class="col-md-8 p-0">
                                                    <header class="section-header">
                                                        <h1 class="border-heading text-left ml-0 f50">master
                                                            agreements
                                                        </h1>
                                                    </header>

                                                </div>
                                            </div>
                                            <a href="#step3" class="step-heading"> master
                                                agreements</a>

                                            <div class="step-container" id="step3">
                                                <div class="row radio-container">
                                                    <div class="col-md-12">
                                                        <div class="row form-group">
                                                            <div class="col-md-9 p-0 agree-section-wapper" >
                                                                <div class="agree-section" id="agree-section1"  data-target="#eventagreement" data-toggle="modal">
                                                                    An Event Agreement
                                                                </div>
                                                                <p>Please read an event agreement document properly, Then agree by clicking checkbox</p>
																<span class="validation-error" ng-show="agreement.financial_agreed_error !=''">{{agreement.event_agreed_error}}</span>
                                                            </div>
                                                            <div class="col-md-3 check-box" >
                                                                Agreed
                                                                <input type="checkbox" ng-model="agreementinfo.event_agreed" class="agree-check checkhour" ng-value="true" data-target="#eventagreement" data-toggle="modal">
                                                                <span class="checkmark"></span>


                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row radio-container">
                                                    <div class="col-md-12">
                                                        <div class="row form-group">
                                                            <div class="col-md-9 p-0 agree-section-wapper">
                                                                <div class="agree-section" id="agree-section2"  data-target="#financialagreement" data-toggle="modal">
                                                                    A Financial Agreement
                                                                </div>
                                                                <p>Please read an financial agreement document properly, Then agree by clicking checkbox</p>
																<span class="validation-error" ng-show="agreement.financial_agreed_error !=''">{{agreement.financial_agreed_error}}</span>
                                                            </div>
                                                            <div class="col-md-3 check-box">
															
                                                                Agreed
                                                                <input type="checkbox" ng-model="agreementinfo.financial_agreed" class="agree-check" ng-value="true" data-target="#financialagreement" data-toggle="modal">
                                                                <span class="checkmark"></span>


                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row radio-container">
                                                    <div class="col-md-12">
                                                        <div class="row form-group">
                                                            <div class="col-md-9 p-0 agree-section-wapper">
                                                                <div class="agree-section" id="agree-section3"  data-target="#copyrightagreement" data-toggle="modal">
                                                                    A Copyright Agreement
                                                                </div>
                                                                <p>Please read an copyright agreement document properly, Then agree by clicking checkbox</p>
																<span class="validation-error" ng-show="agreement.financial_agreed_error !=''">{{agreement.copyright_agreed_error}}</span>
                                                            </div>
                                                            <div class="col-md-3 check-box">
                                                                Agreed
                                                                <input type="checkbox" ng-model="agreementinfo.copyright_agreed" class="agree-check" ng-value="true" data-target="#copyrightagreement" data-toggle="modal">
                                                                <span class="checkmark"></span>


                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                
												
												
                                                <div class="row justify-content-center">
												
                                                    <ul class="pager wizard">
                                                        
                                                        <li class="next text-center"><button type="submit" class="btn primary-btn">Save & Continue</button></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
								
								</div>
                        </div>
                    </section>
                </div>
            </div>
        </section>
		
		  <div class="modal fade" id="eventagreement" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="">
              
                    <div class="modal-header text-center">
                        <h4 class="modal-title w-100 font-weight-bold">An Event Agreement</h4>
						<button class="btn btn-print" ng-click="printDiv('event_agreement_content');"><i class="fa fa-print" aria-hidden="true"></i></button>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
						
                    </div>
                    <div class="modal-body" >
                        <div class="col-md-12" id="event_agreement_content" ng-bind-html="agreementlist.eventagreements">
                               
                            </div>
                             <div class="col-md-12">
                                <div class="pull-right">
                                    <button type="submit" value="SignUp" class="btn primary-btn checkall" ng-click="eventAgreed()" data-dismiss="modal">Agree</button>
                                </div>
                            </div>
                    </div>
            
            </div>

        </div>
    </div>
	
	  <div class="modal fade" id="financialagreement" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="">
              
                    <div class="modal-header text-center">
                        <h4 class="modal-title w-100 font-weight-bold">An Financial Agreement</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
						<button class="btn btn-print" ng-click="printDiv('financial_agreement_content');"><i class="fa fa-print" aria-hidden="true"></i></button>
                    </div>
                    <div class="modal-body" >
                       
					        <div class="col-md-12" id="financial_agreement_content" ng-bind-html="agreementlist.financialagreements">
                               
                            </div>
                            <div class="col-md-12">
                                <div class="pull-right">
                                    <button type="submit" value="SignUp" class="btn primary-btn " ng-click="financialAgreed()" data-dismiss="modal">Agree</button>
                                </div>
                            </div>
                    </div>
            
            </div>

        </div> 
    </div>
	
	  <div class="modal fade" id="copyrightagreement" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="">
              
                    <div class="modal-header text-center">
                        <h4 class="modal-title w-100 font-weight-bold">An Copyright Agreement</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
						<button class="btn btn-print" ng-click="printDiv('copyright_agreement_content');"><i class="fa fa-print" aria-hidden="true"></i></button>
                    </div>
                    <div class="modal-body" >
                            <div class="col-md-12" id="copyright_agreement_content" ng-bind-html="agreementlist.copyrightagreements">
                                
                            </div>
                             <div class="col-md-12">
                                <div class="pull-right">
                                    <button type="submit" value="SignUp" class="btn primary-btn" ng-click="copyrightAgreed()" data-dismiss="modal">Agree</button>
                                </div>
                            </div>
                    </div>
            
            </div>

        </div>
    </div>