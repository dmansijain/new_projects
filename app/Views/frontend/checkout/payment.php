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

                <div class="col-md-12 col-sm-12 white-box-container payment-container-bx">

                    <section class="cost-slide">
                        <div id="rootwizard">
						<?php	echo view('frontend/checkout/checkoutnavigation');
						$session = \Config\Services::session();
						if($session->getFlashdata('error') != ""){
							echo $session->getFlashdata('error');
						}
						?>
                            
                              
                            <div class="tab-content cal-slider w-88">
                                 <h4 class="event-detail-heading"><b>{{eventinfo.typenametitle ? eventinfo.typenametitle : eventinfo.event_typename}} </b>on <b>{{eventinfo.start_date}}</b> for <b>{{eventinfo.cattitle}} </b> at <b>{{eventinfo.location}}</b></h4>
<div class="tab-pane active" id="tab2">
                                    <div class="col-md-12">
                                        <form ng-submit="checkprocess()" name="editform" enctype="multipart/form-data">
                                            <div class="row heading">
                                                <div class="col-md-8">
                                                    <header class="section-header">
                                                        <h1 class="border-heading text-left ml-0 f50">
                                                            PAYMENT
                                                        </h1>
                                                    </header>

                                                </div>
                                            </div>
                                            <a href="#step2" class="step-heading"> PAYMENT</a>

                                            <div class="step-container" id="step2">
                                                <div class="row radio-container">
                                                    <div class="col-md-12">
                                                        <div class="row form-group" ng-if="paymentinfo.cost">
                                                            <div class="col-md-4 p-0 p-md-3">
                                                                <input type="radio" id="test1" name="radio-group"  ng-model="paymentinfo.payment_type" value="fullpayment" checked ng-change="setGateway();">
                                                                <label for="test1">Pay Full</label>
                                                            </div>
                                                            <div class="col-md-4 p-0 p-md-3"> 
                                                                <input type="radio" id="test2"  name="radio-group" value="mindeposit" ng-model="paymentinfo.payment_type" ng-change="setGateway();">
                                                                <label for="test2">Pay Deposit</label>
                                                            </div>
															
                                                            <div class="col-md-4 p-0 p-md-3" ng-show="checkpaymentplan == '1'">
                                                                <input type="radio" id="test3" name="radio-group" value="paymentplan" ng-model="paymentinfo.payment_type" ng-change="setGateway();">
                                                                <label for="test3">Payment Plan</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row panel-box mb-50">
                                                    <div class="col-md-3 panel-heading">
                                                        <div class="align-self-center">
                                                            <h2>Price Detail</h2>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-9 panel-detail">
                                                        <div class="row inner-p-detail">
                                                            <div class="col-md-8 col-sm-12">
                                                                <p class="e-detail">Event Name : <span>{{eventinfo.typenametitle ? eventinfo.typenametitle : eventinfo.event_typename}}, {{eventinfo.location}}</span></p>
                                                                <!--<p class="e-detail">Event Discription : <span ng-bind-html="eventinfo.details"></span></p>-->
                                                                <p class="e-detail">Event Date : <span>{{eventinfo.start_date}}</span></p>
                                                            </div>
                                                            <div class="col-md-4 col-sm-12">
                                                                <div class="price" ng-show="paymentinfo.payment_type =='fullpayment' && paymentinfo.cost">
                                                                    <p>Full Pay</p>
																	 <input type="hidden" id="test1" name="radio-group"  ng-model="paymentinfo.cost" >
                                                                    <h3 class="text-center">{{eventinfo.cost}} $</h3>
                                                                </div>
																<div class="price" ng-show="paymentinfo.payment_type =='mindeposit' && paymentinfo.cost">
                                                                    <p>Deposit Pay</p>
																	<input type="hidden" id="test1" name="radio-group"  ng-model="paymentinfo.min_deposit" >
                                                                    <h3 class="text-center">{{eventinfo.min_deposit}} $</h3>
                                                                </div><div class="price" ng-show="paymentinfo.payment_type =='paymentplan' && paymentinfo.cost">
                                                                    <p>Payment Plan Pay</p>
																	<input type="hidden" id="test1" name="radio-group"  ng-model="paymentinfo.eventPaymentPlanCost" >
                                                                    <h3 class="text-center">{{paymentinfo.eventPaymentPlanCost}} $</h3>
                                                                </div>
																<div class="price" ng-show="!paymentinfo.cost">
                                                                    <p>Pay</p>
																	<input type="hidden" id="test1" name="radio-group"  ng-model="paymentinfo.nocost" >
                                                                    <h4 class="text-center">No Cost</h4>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
								<div class="row radio-container">
								<div class="col-md-12 p-0 p-md-3">
								<div class="row form-group" ng-if="paymentinfo.cost">
								
								
								<div class="col-md-6">
															
								<input type="radio"  id="payviacard" value="pay" name="gateway" ng-model="paymentinfo.gateway">
								<label for="payviacard">Pay Now</label>
								</div>
								<div class="col-md-6" ng-show="paymentinfo.payment_type !='paymentplan'">
								<input type="radio"  id="payviacheck" name="gateway" value="payviacheck" ng-model="paymentinfo.gateway" checked>

								<label for="payviacheck">Pay Via Cheque</label>
								</div>
								</div>
								</div>
								</div>
								

                                                <div class="row justify-content-center" ng-if="paymentinfo.gateway == 'payviacheck' && paymentinfo.cost">
                                                    <ul class="pager wizard">
                                                        <li class="previous  text-center">
                                                            <a href="billing/{{eventslug}}" class="btn primary-btn">Back</a></li>
															<li> <a href="#" data-target="#payviacheckmodal" data-toggle="modal" class="btn primary-btn">Submit</a></li>
															   <!--<li class="next  text-center">
                                                            <input type="submit" value="Submit" name="submit" class="btn primary-btn" id="cardSubmitBtn" ng-click="editform.submitAttempt=true;"></li>-->
                                                  </ul>
                                                </div>
											<div class="row justify-content-center" ng-if="!paymentinfo.cost">
                                                    <ul class="pager wizard">
                                                        <li class="previous  text-center">
                                                            <a href="billing/{{eventslug}}" class="btn primary-btn">Back</a></li>
															<li> <button class="btn primary-btn"  ng-click="editform.submitAttempt=true;">Submit</button></li>
															   <!--<li class="next  text-center">
                                                            <input type="submit" value="Submit" name="submit" class="btn primary-btn" id="cardSubmitBtn" ng-click="editform.submitAttempt=true;"></li>-->
                                                  </ul>
                                                </div>
                                            </div>
											 <div class="modal fade" id="payviacheckmodal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="">
              
                    <div class="modal-header text-center">
                        <h4 class="modal-title w-100 font-weight-bold">Pay Via Cheque</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" >
                        <div class="col-md-12">
                               For Cheque payment, please send your cheque promptly to {{admindata.address}}. You may also bring cheque with you to the event.
                            </div>
                          <div class="col-md-12">
                                <div class="pull-right">
                                    <input type="submit" value="Submit" name="submit" class="btn primary-btn" id="cardSubmitBtn" ng-click="editform.submitAttempt=true;">
                                </div>
                            </div>   
                    </div>
            
            </div>

        </div>
    </div>
                                        </form>
										<div class="row" id="card_section" ng-if="paymentinfo.gateway == 'pay' && paymentinfo.payment_type !='paymentplan' && paymentinfo.cost">
<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top" class="w-100">
			<input type="hidden" name="rm" value="2">
<input type='hidden' name='business' value='sb-yapgm1107556@business.example.com'> 

<input type='hidden' name='item_name' value='{{eventinfo.typenametitle}}'> 
<input type='hidden' name='item_number' value='{{ eventinfo.id }}'> 
<input type='hidden' name='amount' value='{{ eventinfo.cost }}' ng-if="paymentinfo.payment_type == 'fullpayment'"> 
<input type='hidden' name='amount' value='{{ eventinfo.min_deposit }}' ng-if="paymentinfo.payment_type == 'mindeposit'">

<input type='hidden' name='no_shipping' value='1'> 
<input type='hidden' name='currency_code' value='USD'> 
<input type='hidden' name='cancel_return' value='<?php echo base_url();?>payment/{{eventslug}}'>
<input type='hidden' name='return' value='<?php echo base_url();?>api/checkout/paypalpayment?deposite_cost={{ eventinfo.min_deposit }}&actual_cost={{ eventinfo.cost }}&actual_payment_type={{ paymentinfo.payment_type }}&actual_gateway={{ paymentinfo.gateway }}&event_slug={{eventslug}}&order_id={{orderID}}'>
<input type="hidden" name="cmd" value="_xclick">
 <div class="text-center">
  <ul class="pager wizard">
<li class="previous  text-center">
 <a href="billing/{{eventslug}}" class="btn primary-btn">Back</a></li> 
<li class="next  text-center"><input type="submit" name="pay_now" id="pay_now" Value="Submit" class="btn primary-btn"></li>
</div>
        </form>

</div>
<div class="row" id="card_section" ng-if="paymentinfo.gateway == 'pay' && paymentinfo.payment_type =='paymentplan' && paymentinfo.cost">
<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" class="w-100">
    <!-- Identify your business so that you can collect the payments -->
    <input type="hidden" name="business" value="raghavendra@business.com">
    <!-- Specify a subscriptions button. -->
    <input type="hidden" name="cmd" value="_xclick-subscriptions">
    <!-- Specify details about the subscription that buyers will purchase -->
    <input type='hidden' name='item_name' value='{{eventinfo.typenametitle}}'> 
<input type='hidden' name='item_number' value='{{ eventinfo.id }}'>
    <input type='hidden' name='currency_code' value='USD'> 
 <input type="hidden" name="custom" value="<?php echo $session->get('user_data')->ID; ?>-{{paymentinfo.payment_type}}-{{paymentinfo.gateway}}-{{eventinfo.cost}}-{{orderID}}">
    <input type="hidden" name="a3" id="paypalAmt" value="{{paymentinfo.eventPaymentPlanCost}}">
   <input type="hidden" name="p3" id="paypalValid" value="{{paymentplan.payment_division}}">
    <input type="hidden" name="t3" ng-if="paymentplan.time_period == 'Monthly'" value="M">
	<input type="hidden" name="t3" ng-if="paymentplan.time_period == 'Weekly'" value="W">
	<input type="hidden" name="t3" ng-if="paymentplan.time_period == 'Daywise'" value="D">
    <!-- Custom variable user ID -->
	<!--<input type="hidden" name="p3" id="paypalValid" value="2">
   <input type="hidden" name="t3" value="D">-->
    <!-- Specify urls -->
    <input type='hidden' name='cancel_return' value='<?php echo base_url();?>payment/{{eventslug}}'>
    <input type="hidden" name="return" value="<?php echo base_url();?>api/checkout/subscription_payment?event_slug={{eventslug}}&order_id={{orderID}}">
    <input type="hidden" name="notify_url" value="<?php echo base_url();?>api/checkout/notify_subscription_payment">
    <!-- Display the payment button -->
	 <div class="text-center">
  <ul class="pager wizard">
<li class="previous  text-center">
 <a href="billing/{{eventslug}}" class="btn primary-btn">Back</a></li> 
    <li class="next  text-center">
	<input class="buy-btn btn primary-btn" type="submit" value="Submit">
	</li>
	</ul>
</form>
</div>
                                    </div>
                                </div>
								
								</div>
                        </div>
                    </section>
                </div>
            </div>
        </section>
 