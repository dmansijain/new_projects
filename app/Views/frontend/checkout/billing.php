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
								<p class="returncustomer"  ng-if="!billinginfo.ID">Returning customer? <a href="#" data-toggle="modal" data-target="#loginForm">Click here to login</a></p>
                                <div class="tab-pane active" id="tab1" >
                                    <div class="col-md-12 p-0">
                                        <form ng-submit="checkprocess()" name="editform" enctype="multipart/form-data">
                                            <div class="row heading">
                                                 
                                                <div class="col-md-8">
                                                    <header class="section-header">
                                                        <h1 class="border-heading text-left ml-0 f50">Billing
                                                            Information:
                                                        </h1>
                                                    </header>

                                                </div>
                                            </div>
                                         
                                            <a href="#step1" class="step-heading active">Billing Information:</a>

                                            <div class="step-container active" id="step1">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="self">First Name
                                                            </label>
															<span class="validation-error" ng-show="billing.firstname_error !=''">{{billing.firstname_error}}</span>
                                                            <input type="text" class="form-control" ng-model="billinginfo.first_name"/>
															
															<input type="hidden" class="form-control" ng-model="billinginfo.event_id" value="{{eventinfo.id}}" />
                                                        </div>
                                                    </div> 
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="self">Last Name
                                                            </label>
															<span class="validation-error" ng-show="billing.lastname_error !=''">{{billing.lastname_error}}</span>
                                                            <input type="text" class="form-control" ng-model="billinginfo.last_name"  value="{{ profileinfo.last_name }}"/>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="self">Phone No
                                                            </label>
															<span class="validation-error" ng-show="billing.phone_error !=''">{{billing.phone_error}}</span>
                                                            <input type="tel" class="form-control" ng-model="billinginfo.phone_number"  value="{{ profileinfo.phone_number }}"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="self">Email
                                                            </label>
															<span class="validation-error" ng-show="billing.email_error !=''">{{billing.email_error}}</span>
                                                            <input type="email" class="form-control" ng-model="billinginfo.email"  value="{{ profileinfo.email }}"/>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="self">Address
                                                            </label>
															<span class="validation-error" ng-show="billing.address_error !=''">{{billing.address_error}}</span>
                                                            <input type="text" class="form-control" ng-model="billinginfo.address"  value="{{ profileinfo.address }}"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="self">City
                                                            </label>
															<span class="validation-error" ng-show="billing.city_error !=''">{{billing.city_error}}</span>
                                                            <input type="text" class="form-control" ng-model="billinginfo.city"  value="{{ profileinfo.city }}"/>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="self">State
                                                            </label>
															<span class="validation-error" ng-show="billing.state_error !=''">{{billing.state_error}}</span>
                                                            <input type="text" class="form-control" ng-model="billinginfo.state"  value="{{ profileinfo.state }}"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="self">Zip
                                                            </label>
															<span class="validation-error" ng-show="billing.zip_error !=''">{{billing.zip_error}}</span>
                                                            <input type="text" class="form-control" ng-model="billinginfo.zip_code"  value="{{ profileinfo.zip }}"/>
                                                        </div>

                                                    </div>
                                                </div>
												<!--<div class="row heading mt-50">
                                                    <div class="col-md-8">
                                                        <header class="section-header">
                                                            <h1 class="border-heading text-left ml-0 f50">Attendee Information
                                                            </h1>
                                                        </header>

                                                    </div>
                                                    <span class="explain"><input type="checkbox" ng-model="billinginfo.different_attende" value="1">  if different than billing</span>
                                                    
                                                </div>-->
												<div ng-show="billinginfo.different_attende ==1">
                                                 <h1 class="small-hide
 border-heading text-left ml-0 f50 mb-50 mt-50">Attendee Information
                                                            </h1>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="self">First Name
                                                            </label>
															<span class="validation-error" ng-show="attende.firstname_error !=''">{{attende.firstname_error}}</span>
                                                            <input type="text" class="form-control" ng-model="attendeinfo.first_name" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="self">Last Name
                                                            </label>
															<span class="validation-error" ng-show="attende.lastname_error !=''">{{attende.lastname_error}}</span>
                                                            <input type="text" class="form-control" ng-model="attendeinfo.last_name" />
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="self">Phone No
                                                            </label>
															<span class="validation-error" ng-show="attende.phone_error !=''">{{attende.phone_error}}</span>
                                                            <input type="tel" class="form-control" ng-model="attendeinfo.phone_number" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="self">Email
                                                            </label>
															<span class="validation-error" ng-show="attende.email_error !=''">{{attende.email_error}}</span>
                                                            <input type="text" class="form-control" ng-model="attendeinfo.email" />
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="self">Address
                                                            </label>
															<span class="validation-error" ng-show="attende.address_error !=''">{{attende.address_error}}</span>
                                                            <input type="text" class="form-control" ng-model="attendeinfo.address" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="self">City
                                                            </label>
															<span class="validation-error" ng-show="attende.city_error !=''">{{attende.city_error}}</span>
                                                            <input type="text" class="form-control" ng-model="attendeinfo.city" />
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="self">State
                                                            </label>
															<span class="validation-error" ng-show="attende.state_error !=''">{{attende.state_error}}</span>
                                                            <input type="text" class="form-control" ng-model="attendeinfo.state" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="self">Zip
                                                            </label>
															<span class="validation-error" ng-show="attende.zip_error !=''">{{attende.zip_error}}</span>
                                                            <input type="text" class="form-control" ng-model="attendeinfo.zip_code" />
                                                        </div>

                                                    </div>
                                                </div>
                                               
												</div>
                                                <div class="row justify-content-center">
												<ul class="validation-error">
<li ng-repeat="error in message">{{error}}</li>
</ul>
                                                    <ul class="pager wizard">
                                                        <!--			<li class="previous first"><a href="javascript:;">First</a></li>-->
                                                        <!--                                <li class="previous"><a href="javascript:;">Previous</a></li>-->
                                                        <!--			<li class="next last"><a href="javascript:;">Last</a></li>-->
                                                       <p class="validation-error" ng-show="billing.register_validate !=''">{{billing.register_validate}}</p>
                                                           
                                                        <li class="next text-center">
														<button type="submit" class="btn primary-btn">Save and Continue</button>
														</li>
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