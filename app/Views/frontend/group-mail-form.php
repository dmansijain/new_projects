<!--==========================
    Intro Section
  ============================-->
    <section id="intro" class="clearfix">
        <div class="container h-100">
            <div class="row ">
                <div class="col-md-12 order-md-first order-last">
                    <header class="section-header">
                        <h1 class="border-heading text-center">Group Mail</h1>
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
                      
                        <div id="content" class="tab-content" role="tablist">
                            <div id="pane-A" class="card tab-pane fade show active" role="tabpanel" aria-labelledby="tab-A">
                                <div class="card-header" role="tab" id="heading-A">
                                    <h5 class="mb-0">
                                        <a class="" data-toggle="collapse" href="#collapse-A" data-parent="#content" aria-expanded="true" aria-controls="collapse-A">

                                            Group Mail

                                        </a>
                                    </h5>
                                </div>
                                <div id="collapse-A" class="collapse show" role="tabpanel" aria-labelledby="heading-A">
                                    <div class="card-body ">
                                        <form ng-submit="sendmail()">
                                          
                                            <div class="row">
											<div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="self">To
                                                        </label>
                                                        <input type="text" ng-model="groupinfo.to" class="form-control" readonly="readonly"/>
														
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="self">Subject
                                                        </label>
                                                        <input type="text" ng-model="groupinfo.subject" class="form-control" />
														
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="self">Message
                                                        </label>
                                                         <textarea class="form-control" ng-model="groupinfo.message"></textarea>
														
                                                    </div>

                                                </div>
                                            </div>
                                           
											<div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group clearfix"> 
                                                      <div ng-show="message !=''"  ng-bind-html="message">{{message}}</div> 
													   <div  class="validation-error" ng-show="errors !=''"  ng-bind-html="errors">{{errors}}</div> 
                                                        <input class="save_btn btn primary-btn" type="submit" value="Submit" />
													
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                            
                            
                        </div>
                    </div>


                </div>
            </div>
        </section><!-- #services -->



    </main>