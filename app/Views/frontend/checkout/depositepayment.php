 <!--==========================
    Intro Section
  ============================-->
    <section id="intro" class="clearfix">
        <div class="container h-100">
            <div class="row ">
                <div class="col-md-12 order-md-first order-last">
                    <header class="section-header">
                        <h1 class="border-heading text-center">Deposite Payment</h1>
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
                <div class="row justify-content-center goth">
                    <div class="col-md-12 p-0 d-flex justify-content-center">
                        <div class="col-lg-9 p-0" ng-if="eventorderinfo.paymentdata.gateway == 'payviacheck'">
						<form ng-submit="checkprocess()" name="depositeform">
						<input type="hidden" name="gateway" ng-model="eventorderinfo.paymentdata.gateway">
						<input type="hidden" name="payment_type" ng-model="eventorderinfo.paymentdata.payment_type">
						<input type="hidden" ng-model="eventorderinfo.depositeamount" value="{{totalamount}}">
                            <div class="">
                                <div class="row">
                                    <div class="col-md-12 p-0">

                                        <h3 class="mb50 event-heading"><strong>{{eventorderinfo.full_name}} - {{eventorderinfo.typenametitle}}, {{eventorderinfo.location}} {{eventorderinfo.start_date | date : 'MM/dd/yyyy'}}</strong> </h3>
                                        <h3 class="mb50 event-heading"><strong>Already Paid : <?php echo get_currency();?>{{eventorderinfo.paid_amount}} Deposit on {{payment_date}}</strong> </h3>
                                        <h3 class="mb50 event-heading"><strong>To Be Paid :</strong> </h3>
                                        <h3 class="mb50 event-heading"><strong><?php echo get_currency();?>{{totalamount}}</strong> 
										<a href="#" data-target="#payviacheckmodal" data-toggle="modal" class="btn view-btn" ng-click="setPrice();">Pay Total</a> 
										
										</h3>
                                        
                                    </div>
                                    
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12 p-0 text_box d-block d-sm-flex justify-content-between set-mob">
                                          <input class="form-group Searchskill" aria-label="200" type="number" placeholder="Enter Price" aria-invalid="false" ng-model="eventorderinfo.depositeamount"  value="{{eventorderinfo.depositeamount}}" ng-blur ="validatePrice();" id="deposite_pay" pattern="^[0-9]+$" ng-pattern-restrict><a href="#" class="btn view-btn"  data-target="#payviacheckmodal" data-toggle="modal">Pay Towards This</a>
										
									</div>
                                    
                                </div>
                            </div>

 <div class="modal fade" id="payviacheckmodal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="">
              
                    <div class="modal-header text-center">
                        <h4 class="modal-title w-100 font-weight-bold">Pay Via Check</h4>
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
                                    <input type="submit" value="Submit" name="submit" class="btn primary-btn" id="cardSubmitBtn" ng-click="depositeform.submitAttempt=true;">
                                </div>
                            </div>   
                    </div>
            
            </div>

        </div>
    </div>
                         </form>   
                             
						</div>
<div class="col-lg-9" ng-if="eventorderinfo.paymentdata.gateway == 'pay'">
						
						
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12 p-0">

                                        <h3 class="mb50 event-heading"><strong>{{eventorderinfo.full_name}} - {{eventorderinfo.typenametitle}}, {{eventorderinfo.location}} {{eventorderinfo.start_date | date : 'MM/dd/yyyy'}}</strong> </h3>
                                        <h3 class="mb50 event-heading"><strong>Already Paid : <?php echo get_currency();?>{{eventorderinfo.paid_amount}} Deposit on {{payment_date}}</strong> </h3>
                                        <h3 class="mb50 event-heading"><strong>To Be Paid :</strong> </h3>
                                        <h3 class="mb50 event-heading"><strong><?php echo get_currency();?>{{totalamount}}</strong> 
										   <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top" class="total_paypal_pay">
			<input type="hidden" name="rm" value="2">
<input type='hidden' name='business' value='sb-yapgm1107556@business.example.com'> 

<input type='hidden' name='item_name' value='{{eventorderinfo.typenametitle}}'> 
<input type='hidden' name='item_number' value='{{ eventorderinfo.event_order_id }}'> 
<input type='hidden' name='amount' value='{{totalamount}}'> 


<input type='hidden' name='no_shipping' value='1'> 
<input type='hidden' name='currency_code' value='USD'> 
<input type='hidden' name='cancel_return' value='<?php echo base_url();?>depositepayment/{{eventorderID | slugencry}}'>
<input type='hidden' name='return' value='<?php echo base_url();?>api/checkout/depositepaypalpayment?order_id={{eventorderID}}&event_slug={{eventorderinfo.typenametitle | slugify}}-{{eventorderinfo.event_id}}'>
<input type="hidden" name="cmd" value="_xclick">
<input type="submit" name="pay_now" id="pay_now" Value="Pay Total"  class="btn view-btn">
        </form>
                                  
										
										</h3>
                                        
                                    </div>
                                    
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12 p-0 text_box d-block d-sm-flex justify-content-between set-mob">
                                          <input class="form-group Searchskill" aria-label="200" type="text" placeholder="Enter Price" aria-invalid="false" ng-model="eventorderinfo.depositeamount" pattern="^[0-9]+$" ng-pattern-restrict ng-blur ="validatePrice();"> 
										  <div>
 

                                      <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top"  class="total_paypal_pay">
			<input type="hidden" name="rm" value="2">
<input type='hidden' name='business' value='sb-yapgm1107556@business.example.com'> 

<input type='hidden' name='item_name' value='{{eventorderinfo.typenametitle}}'> 
<input type='hidden' name='item_number' value='{{ eventorderinfo.event_order_id }}'> 
<input type='hidden' name='amount' value='{{eventorderinfo.depositeamount}}'> 


<input type='hidden' name='no_shipping' value='1'> 
<input type='hidden' name='currency_code' value='USD'> 
<input type='hidden' name='cancel_return' value='<?php echo base_url();?>depositepayment/{{eventorderID}}'>
<input type='hidden' name='return' value='<?php echo base_url();?>api/checkout/depositepaypalpayment?order_id={{eventorderID}}&event_slug={{eventorderinfo.typenametitle | slugify}}-{{eventorderinfo.event_id}}'>
<input type="hidden" name="cmd" value="_xclick">
<input type="submit" name="pay_now" id="pay_toward" Value="Pay Towards This"  class="btn view-btn">
        </form>
                                  
 </div>
										
									</div>
                                    
                                </div>
                            </div>
 
                        
						</div>						
						
						
						
						
						
						
						
						

                    </div>
                </div>
            </div>
        </section><!-- #services -->

        <!--==========================
      explore Section
    ============================-->
		