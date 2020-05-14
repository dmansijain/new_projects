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
<div class="tab-pane box-design active" id="tab4">
                                    <div class="col-md-12 p-0">
                                        <form ng-submit="checkprocess()" name="editform" enctype="multipart/form-data"> 
                                            <div class="row heading">
                                                <div class="col-md-8">
                                                    <header class="section-header">
                                                        <h1 class="border-heading text-left ml-0 f50">Health
                                                            Informations
                                                        </h1>
                                                    </header>

                                                </div>
                                            </div>
                                            <a href="#step4" class="step-heading"> Health
                                                Informations</a>
												
                                            <div class="step-container" id="step4">
                                                <div class="row align-items-baseline">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
														
                                                            <label for="self">Full Name
                                                            </label>
															<input type="text" ng-model="healthinfo.full_name" class="form-control" ng-if="healthinfo.user_id" readonly="readonly"/>
                                                            <input type="text" ng-model="healthinfo.full_name" class="form-control" ng-if="!healthinfo.user_id"/>
															<span class="validation-error" ng-show="health.full_name_error !=''">{{health.full_name_error}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="self">Birth Date
                                                            </label>
                                                            <input type="date" ng-model="healthinfo.birth_date" class="form-control"   ng-model-options="{timezone: '0100'}"/>
															<span class="validation-error" ng-show="health.birth_date_error !=''">{{health.birth_date_error}}</span>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="row align-items-baseline">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="self">Address line 1
                                                            </label>
                                                            <input type="tel" ng-model="healthinfo.address_1" class="form-control" ng-if="healthinfo.user_id" readonly="readonly"/><input type="tel" ng-model="healthinfo.address_1" class="form-control"  ng-if="!healthinfo.user_id"/>
															<span class="validation-error" ng-show="health.address_1_error !=''">{{health.address_1_error}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="self">Address line2
                                                            </label>
                                                            <input type="text" ng-model="healthinfo.address_2" class="form-control" ng-if="healthinfo.user_id" readonly="readonly"/> 
															<input type="text" ng-model="healthinfo.address_2" class="form-control" ng-if="!healthinfo.user_id"/>
															<span class="validation-error" ng-show="health.address_2_error !=''">{{health.address_2_error}}</span>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="row align-items-baseline">

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="self">City
                                                            </label>
															<input type="text" ng-model="healthinfo.city" class="form-control" ng-if="healthinfo.user_id" readonly="readonly"/>
                                                            <input type="text" ng-model="healthinfo.city" class="form-control" ng-if="!healthinfo.user_id"/>
															<span class="validation-error" ng-show="health.city_error !=''">{{health.city_error}}</span>
                                                        </div>

                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="self">State
                                                            </label> 
															<input type="text" ng-model="healthinfo.state" class="form-control" ng-if="healthinfo.user_id" readonly="readonly"/>
                                                            <input type="text" ng-model="healthinfo.state" class="form-control" ng-if="!healthinfo.user_id"/>
															<span class="validation-error" ng-show="health.state_error !=''">{{health.state_error}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row align-items-baseline">

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="self">Zip
                                                            </label>
                                                            <input type="text" ng-model="healthinfo.zipcode" class="form-control" ng-if="healthinfo.user_id" readonly="readonly"/>
															<input type="text" ng-model="healthinfo.zipcode" class="form-control" ng-if="!healthinfo.user_id"/>
															<span class="validation-error" ng-show="health.zipcode_error !=''">{{health.zipcode_error}}</span>
                                                        </div>

                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">Emergency Contact Name
                                                            </label>
                                                            <input type="text" ng-model="healthinfo.em_contactname" class="form-control" />
															<span class="validation-error" ng-show="health.em_contactname_error !=''">{{health.em_contactname_error}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row align-items-baseline">

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="self">Emergency Contact Address
                                                            </label>
                                                            <input type="text" ng-model="healthinfo.em_contactaddress" class="form-control" />
															<span class="validation-error" ng-show="health.em_contactaddress_error !=''">{{health.em_contactaddress_error}}</span>
                                                        </div>

                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">Emergency Contact Relationship to you
                                                            </label>
                                                             <select ng-model="healthinfo.em_relation_withyou"  class="form-control">
													<option value="">Select</option>
													<option value="Spouse">Spouse</option>
													<option value="Child">Child</option>
													<option value="Father">Father</option>
													<option value="Mother">Mother</option>
													<option value="Other Relative">Other Relative</option><option value="Friend">Friend</option>
													
												  <select>
												  <span class="validation-error" ng-show="health.em_relation_withyou_error !=''">{{health.em_relation_withyou_error}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row align-items-baseline">

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="self">Emergency Contact Phone Number
                                                            </label>
                                                            <input type="text" ng-model="healthinfo.em_phone_number" class="form-control" />
															<span class="validation-error" ng-show="health.em_phone_number_error !=''">{{health.em_phone_number_error}}</span>
                                                        </div>

                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">Health Insurance Company
                                                            </label>
                                                            <input type="text" ng-model="healthinfo.health_insure_company" class="form-control" />
															<span class="validation-error" ng-show="health.health_insure_company_error !=''">{{health.health_insure_company_error}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row align-items-baseline">

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="self">Health Insurance Company Phone
                                                            </label>
                                                            <input type="text" ng-model="healthinfo.health_insure_phone" class="form-control" />
															<span class="validation-error" ng-show="health.health_insure_phone_error !=''">{{health.health_insure_phone_error}}</span>
                                                        </div>

                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">Insurance Primary Holder
                                                            </label>
                                                            <input type="text" ng-model="healthinfo.insure_primary_holder" class="form-control" />
															<span class="validation-error" ng-show="health.insure_primary_holder_error !=''">{{health.insure_primary_holder_error}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row align-items-baseline">

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="self">Insurance Group Number
                                                            </label>
                                                            <input type="text" ng-model="healthinfo.insure_group_number" class="form-control" />
															<span class="validation-error" ng-show="health.insure_group_number_error !=''">{{health.insure_group_number_error}}</span>
                                                        </div>

                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">Insurance Member/Identification number
                                                            </label>
                                                            <input type="text" ng-model="healthinfo.insure_idnumber" class="form-control" />
															<span class="validation-error" ng-show="health.insure_idnumber_error !=''">{{health.insure_idnumber_error}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row align-items-baseline">

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="self">Primary Care Physician
                                                            </label>
                                                            <input type="text" ng-model="healthinfo.primary_physician" class="form-control" />
															<span class="validation-error" ng-show="health.primary_physician_error !=''">{{health.primary_physician_error}}</span>
                                                        </div>

                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">Physician Address
                                                            </label>
                                                            <input type="text" ng-model="healthinfo.physician_address" class="form-control" />
															<span class="validation-error" ng-show="health.physician_address_error !=''">{{health.physician_address_error}}</span>
                                                        </div>
                                                    </div>
                                                </div>
												<div class="row">

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="self">Physician Phone
                                                            </label>
                                                            <input type="text" class="form-control" ng-model="healthinfo.physician_phone">
															<span class="validation-error" ng-show="health.physician_phone_error !=''">{{health.physician_phone_error}}</span>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="row">

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="self">List ALL medications, dosage and the conditions for which they are prescribed:
                                                            </label>
                                                            <textarea class="form-control" ng-model="healthinfo.list_all_medications"></textarea>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="row">

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="self">List any medical or psychiatric conditions or concerns which might negatively
                                                                impact your ability to fully participate in the weekend:
                                                            </label>
                                                            <textarea class="form-control" ng-model="healthinfo.list_any_psychiatric"></textarea>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="row">

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="self">List any orthopedic (bone, joint, muscle) or neurological condition which may negatively impact your ability to endure long periods of sitting or standing or physical strain:
                                                            </label>
                                                            <textarea class="form-control" ng-model="healthinfo.list_any_orthopedic"></textarea>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="row">

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="self">Is your personal safety currently at risk from self or from others? If so, explain:
                                                            </label>
                                                            <textarea class="form-control" ng-model="healthinfo.your_personal_safety"></textarea>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="row">

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="self">Do you suffer from HIV(AIDS), hepatitis B (HBV),<br />
                                                                or chronic hepatitis (HCV)? If so, list them:
                                                            </label>
                                                            <textarea class="form-control" ng-model="healthinfo.suffer_from_hiv"></textarea>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="row">

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="self">Are you currently addicted to alcohol, tobacco, prescription pain killers or illicit drugs? If so, list each one and describe your needs or concerns around this addiction over the weekend.
                                                            </label>
                                                            <textarea class="form-control" ng-model="healthinfo.addicted_to_alcohol"></textarea>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="row">

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="self">The medic at your event will have the following OTC medicine available:  Aspirin, Tylenol (Acetaminophen), Advil (Ibuprofen), Aleve (Naproxen), Benadryl (Diphenhydramine), and Imodium (Loperamide Hcl). <strong>Are you willing to accept responsibility in the event that you request to take one of these medications? Indicate Yes or No.</strong>
                                                            </label>
                                                           <select ng-model="healthinfo.otc_medications"  class="form-control">
													<option value="">Select</option>
													<option value="yes">Yes</option>
													<option value="no">No</option>
													
													
												  <select>
												  <span class="validation-error" ng-show="health.otc_medications_error !=''">{{health.otc_medications_error}}</span>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="row">

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="self">List any other non-food related allergies you have that we should be aware of?
                                                            </label>
                                                            <textarea class="form-control" ng-model="healthinfo.other_contact_allergies"></textarea>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="row">

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="self">Are you allergic to anything that may cause you to go into anaphylactic shock?  If so, do you carry an epi pen?
                                                            </label>
                                                            <textarea class="form-control" ng-model="healthinfo.allergic_to_striped"></textarea>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="row">

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="self">List all food allergies and intolerances (e.g. dairy, gluten, nuts, etc.):
                                                            </label>
                                                            <textarea class="form-control" ng-model="healthinfo.list_food_allergies"></textarea>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="row">

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="self">Are you willing to allow the staff medic to review this information and discuss it with you?
                                                            </label>
                                                           <select ng-model="healthinfo.allow_staffmedic_review"  class="form-control">
														<option value="">Select</option>
														<option value="yes">Yes</option>
														<option value="no">No</option>
														
														
													  <select>
													  <span class="validation-error" ng-show="health.allow_staffmedic_review_error !=''">{{health.allow_staffmedic_review_error}}</span>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="row align-items-baseline">

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="self">Signature (Retype Name)
                                                            </label>
                                                            <input type="text" class="form-control" ng-model="healthinfo.signature" />
															<span class="validation-error" ng-show="health.signature_error !=''">{{health.signature_error}}</span>
                                                        </div>

                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">Date
                                                            </label>
															<input type="date" class="form-control" ng-model="healthinfo.signature_date"  ng-model-options="{timezone: '0100'}"/>
															<span class="validation-error" ng-show="health.signature_date_error !=''">{{health.signature_date_error}}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row justify-content-center">
												<p style="color:red;">{{error_message}}</p>
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