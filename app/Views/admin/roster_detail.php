<section id="main-content" class=" ">
    <section class="wrapper main-wrapper row" style=''>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="TopBtn_box">
					<div class="row">
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
							<div class="pg_title"><h2>Roster Detail</h2></div>
						</div>					
					</div>
					<div class="row">
						<ul id="myTab" class="nav nav-tabs bar_tabs roaster_tab" role="tablist">
							<li role="presentation" class="active">
								<a href="javascript:void()" ng-click="biilinginfo()" role="tab" id="" data-toggle="tab" aria-expanded="true">Billing Info </a>
							</li>
							<li role="presentation" class="">
								<a href="javascript:void()" ng-click="attendeeinfo()" id="" role="tab" data-toggle="tab" aria-expanded="false">Attendee Info</a>
							</li>
							<li role="presentation" class="">
								<a href="javascript:void()" ng-click="paymentinfo()" id="" role="tab" data-toggle="tab" aria-expanded="false">Payment Info</a>
							</li>
							<li role="presentation" class="">
								<a href="javascript:void()" ng-click="agreementinfo()" id="" role="tab" data-toggle="tab" aria-expanded="false">Agreement Info</a>
							</li>
							<li role="presentation" class="">
								<a href="javascript:void()" ng-click="healthinfo()" id="" role="tab" data-toggle="tab" aria-expanded="false">health Info</a>
							</li>
							<li role="presentation" class="">
								<a href="javascript:void()" ng-click="notificationinfo()" id="" role="tab" data-toggle="tab" aria-expanded="false">Notification Info</a>
							</li>
						</ul>
					</div>						
				</div>
								
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="h4 highlight-text"><span>Order Id</span>  0000{{event_order.event_order_id}}</div>
				<div class="h4 highlight-text"><span>Event Name</span>  {{event_order.typenametitle ? event_order.typenametitle : event_order.event_typename}}</div>
				<div class="h4 highlight-text"><span>User Name</span>  {{event_order.full_name}}</div>
				<div class="h4 highlight-text"><span>User Type</span>  {{usertype}}</div>
				<div class="h4 highlight-text"><span>Event Cost</span>  {{event_order.cost != 0 ? event_order.currency : ""}}{{event_order.cost != 0 ? event_order.cost : "No Cost"}}</div>
				<div class="h4 highlight-text" ng-if="event_order.payment_plan_time_period"><span>Payment Plan Time period</span>  {{event_order.payment_plan_time_period}}</div>
				<div class="h4 highlight-text" ng-if="event_order.payment_division"><span>Payment Division</span>  {{event_order.payment_division}}</div>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 tab-inside-table">
				<div class="manage-skill-content UserSkillsList" ng-if="billinginfo !=''">
					<table class="roster-dtl-tb" width="100%" border="0" cellspacing="10">
					
						<tr>
							<td>First Name</td>
							<td>{{ billinginfo.first_name }}</td>
						</tr>
						<tr>								
							<td>Last Name</td>
							<td>{{ billinginfo.last_name }}</td>					
						</tr>
						<tr>								
							<td>Phone Number</td>
							<td>{{ billinginfo.phone_number }}</td>					
						</tr>
						<tr>								
							<td>Email</td>
							<td>{{ billinginfo.email }}</td>					
						</tr>
						<tr>								
							<td>Address</td>
							<td>{{ billinginfo.address }}</td>					
						</tr>
						<tr>								
							<td>City</td>
							<td>{{ billinginfo.city }}</td>					
						</tr>
						<tr>								
							<td>State</td>
							<td>{{ billinginfo.state }}</td>					
						</tr>
						<tr>								
							<td>Zip Code</td>
							<td>{{ billinginfo.zip_code }}</td>					
						</tr>
					</table>							
				</div>
				<div class="manage-skill-content liminal-data-table UserSkillsList" ng-if="allattendee !=''">
					<table class="attendee-info" width="100%" border="0" cellspacing="10">
						<tr>
							<td>First Name</td>
							<td>{{ allattendee.first_name }}</td>
						</tr>
						<tr>								
							<td>Last Name</td>
							<td>{{ allattendee.last_name }}</td>					
						</tr>
						<tr>								
							<td>Phone Number</td>
							<td>{{ allattendee.phone_number }}</td>					
						</tr>
						<tr>								
							<td>Email</td>
							<td>{{ allattendee.email }}</td>					
						</tr>
						<tr>								
							<td>Address</td>
							<td>{{ allattendee.address }}</td>					
						</tr>
						<tr>								
							<td>City</td>
							<td>{{ allattendee.city }}</td>					
						</tr>
						<tr>								
							<td>State</td>
							<td>{{ allattendee.state }}</td>					
						</tr>
						<tr>								
							<td>Zip Code</td>
							<td>{{ allattendee.zip_code }}</td>					
						</tr>
					</table>					
				</div>	
				<div class="manage-skill-content liminal-data-table UserSkillsList" ng-if="payment_infos !=''">
					<table class="t-payment-info" width="100%" border="0" cellspacing="10" ng-repeat="payment_info in payment_infos">
						<tr ng-if="payment_info.gateway != 'payviacheck' && payment_info.transaction_id != ''">								
							<td>Transaction ID</td>
							<td>{{ payment_info.transaction_id ?  payment_info.transaction_id : "-"}}</td>					
						</tr>
						<tr>
							<td>Payment Type</td>
							<td ng-show ="payment_info.payment_type == 'mindeposit'">{{ "Deposite Payment" }}</td>
							<td ng-show ="payment_info.payment_type == 'fullpayment'">{{ "Full Payment" }}</td>
							<td ng-show ="payment_info.payment_type == 'paymentplan'">{{ "Payment Plan" }}</td>
						</tr>
						<tr>								
							<td>Gateway</td>
							<td>{{ payment_info.gateway == "pay" ?  "Online Payment" : "Cheque Payment"}}</td>					
						</tr>
						<tr>								
							<td>Amount</td>
							<td>{{payment_info.amount != 0 ? payment_info.currency : ""}} {{ payment_info.amount != 0 ? payment_info.amount : "NO COST"}}</td>					
						</tr>
						
						<tr>								
							<td>Payment Status</td>
							<td>{{ payment_info.payment_status }}</td>					
						</tr>
						
						<tr>								
							<td>Payment Date</td>
							<td>{{ payment_info.payment_date | date : 'MM/dd/yyyy' }}</td>					
						</tr>
						
					</table>					
				</div>
				<div class="manage-skill-content liminal-data-table UserSkillsList" ng-if="agreement_info !=''">
					<table class="t-agreement-info" width="100%" border="0" cellspacing="10">
						<tr>								
							<td>Event Agreement</td>
							<td ng-if="agreement_info.event_agreed == 1"><i class="fa fa-check" aria-hidden="true"></i>Agree</td>	
							<td ng-if="agreement_info.event_agreed != 1"><i class="fa fa-times" aria-hidden="true"></i>Not Agree</td>
														
						</tr>
						<tr>
							<td>Financial Agreement</td>
							<td ng-if="agreement_info.financial_agreed == 1"><i class="fa fa-check" aria-hidden="true"></i>Agree</td>	
							<td ng-if="agreement_info.financial_agreed != 1"><i class="fa fa-times" aria-hidden="true"></i>Not Agree</td>
							
						</tr>
						<tr>								
							<td>Copyright Agreement</td>
							<td ng-if="agreement_info.copyright_agreed == 1"><i class="fa fa-check" aria-hidden="true"></i>Agree</td>	
							<td ng-if="agreement_info.copyright_agreed != 1"><i class="fa fa-times" aria-hidden="true"></i>Not Agree</td>							
						</tr>
						
						
					</table>					
				</div>
				
				<div class="manage-skill-content liminal-data-table UserSkillsList" ng-if="health_info !=''">
					<table class="health-info-table" width="100%" border="0" cellspacing="10">
						
						<tr>								
							<td>Full Name</td>
							<td>{{ (health_info.full_name != null) && health_info.full_name || '-'}}</td>					
						</tr>
						<tr>
							<td>Birth Date</td>
							<td>{{ (health_info.birth_date != null) && health_info.birth_date || '-' }}</td>
						</tr>
						<tr>								
							<td>address 1</td>
							<td>{{ (health_info.address_1 != null) && health_info.address_1 || '-' }}</td>					
						</tr>
						<tr>								
							<td>address 2</td>
							<td>{{ (health_info.address_2 != null) && health_info.address_2 || '-' }}</td>					
						</tr>
						<tr>								
							<td>City</td>
							<td>{{ (health_info.city != null) && health_info.city || '-' }}</td>					
						</tr>
						<tr>
							<td>State</td>
							<td>{{ (health_info.state != null) && health_info.state || '-'  }}</td>
						</tr>
						<tr>								
							<td>Zip Code</td>
							<td>{{ (health_info.zipcode != null) && health_info.zipcode || '-'  }}</td>					
						</tr>
						<tr>								
							<td>Emergency Contact Name</td>
							<td>{{ (health_info.em_contactname != null) && health_info.em_contactname || '-' }}</td>					
						</tr>
						<tr>								
							<td>Emergency Contact Address</td>
							<td>{{ (health_info.em_contactaddress != null) && health_info.em_contactaddress || '-' }}</td>					
						</tr>
						<tr>
							<td>Emergency contact relation to you</td>
							<td>{{ (health_info.em_relation_withyou != null) && health_info.em_relation_withyou || '-' }}</td>
						</tr>
						<tr>								
							<td>Emergency Contact Phone number</td>
							<td>{{ (health_info.em_phone_number != null) && health_info.em_phone_number || '-' }}</td>					
						</tr>
						<tr>								
							<td>Health Insurance Company</td>
							<td>{{ (health_info.health_insure_company != null) && health_info.health_insure_company || '-'}}</td>					
						</tr>
						<tr>								
							<td>Health Insurance Company Phone</td>
							<td>{{ (health_info.health_insure_phone != null) && health_info.health_insure_phone || '-'}}</td>					
						</tr>
						<tr>
							<td>Insurance Primary Holder</td>
							<td>{{ (health_info.insure_primary_holder != null) && health_info.insure_primary_holder || '-' }}</td>
						</tr>
						<tr>								
							<td>Insurance Group Number</td>
							<td>{{ (health_info.insure_group_number != null) && health_info.insure_group_number || '-' }}</td>					
						</tr>
						<tr>								
							<td>Insurance Member/Identification number</td>
							<td>{{ (health_info.insure_idnumber != null) && health_info.insure_idnumber || '-'}}</td>					
						</tr>
						<tr>								
							<td>Primary Care Physician</td>
							<td>{{ (health_info.primary_physician != null) && health_info.primary_physician || '-' }}</td>					
						</tr>
						<tr>								
							<td>Physician Address</td>
							<td>{{ (health_info.physician_address != null) && health_info.physician_address || '-'}}</td>					
						</tr>
						<tr>								
							<td>Physician Phone Number</td>
							<td>{{ (health_info.physician_phone != null) && health_info.physician_phone || '-'}}</td>					
						</tr>
						<tr>
							<td>List ALL medications, dosage and the conditions for which they are prescribed</td>
							<td>{{ (health_info.list_all_medications != null) && health_info.list_all_medications || '-' }}</td>
						</tr>
						<tr>								
							<td>List any medical or psychiatric conditions or concerns which might negatively impact your ability to fully participate in the weekend:</td>
							<td>{{ (health_info.list_any_psychiatric != null) && health_info.list_any_psychiatric || '-' }}</td>					
						</tr>
						<tr>								
							<td>List any orthopedic (bone, joint, muscle) or neurological condition which may negatively impact your ability to endure long periods of sitting or standing or physical strain:</td>
							<td>{{ (health_info.list_any_orthopedic != null) && health_info.list_any_orthopedic || '-' }}</td>					
						</tr>
						<tr>
							<td>Is your personal safety currently at risk from self or from others? If so, explain:</td>
							<td>{{ (health_info.your_personal_safety != null) && health_info.your_personal_safety || '-' }}</td>
						</tr>
						<tr>								
							<td>Do you suffer from HIV(AIDS), hepatitis B (HBV),
								or chronic hepatitis (HCV)? If so, list them:</td>
							<td>{{ (health_info.suffer_from_hiv != null) && health_info.suffer_from_hiv || '-' }}</td>					
						</tr>
						<tr>								
							<td>Are you currently addicted to alcohol, tobacco, prescription pain killers or illicit drugs? If so, list each one and describe your needs or concerns around this addiction over the weekend.</td>
							<td>{{ (health_info.addicted_to_alcohol != null) && health_info.addicted_to_alcohol || '-' }}</td>					
						</tr>
						
						
						<tr>								
							<td>The medic for the weekend is able to dispense the following OTC medications: Aspirin, Tylenol (Acetaminophen), Advil (Ibuprofen), Aleve (Naproxen), Benadryl (Diphenhydramine), and Imodium (Loperamide Hcl). Are you willing to accept responsibility in the event that you request to take one of these medications? Indicate Yes or No (Explain).</td>
							<td>{{ (health_info.otc_medications != null) && health_info.otc_medications || '-'}}</td>					
						</tr>
						<tr>
							<td>List any other contact allergies</td>
							<td>{{ (health_info.other_contact_allergies != null) && health_info.other_contact_allergies || '-' }}</td>
						</tr>
						<tr>								
							<td>Are you allergic to striped stinging insects, spiders or scorpions? If so, do you carry an epi pen?</td>
							<td>{{ (health_info.allergic_to_striped != null) && health_info.allergic_to_striped || '-' }}</td>					
						</tr>
						
						<tr>								
							<td>List all food allergies and intolerances (e.g. dairy, gluten, nuts, etc.):</td>
							<td>{{ (health_info.list_food_allergies != null) && health_info.list_food_allergies || '-'}}</td>					
						</tr>
						<tr>								
							<td>
								Are you willing to allow the staff medic to review this information and discuss it with you?</td>
							<td>{{ (health_info.allow_staffmedic_review != null) && health_info.allow_staffmedic_review || '-'}}</td>					
						</tr>
						<tr>								
							<td>Signature (Retype Name)</td>
							<td>{{ (health_info.signature != null) && health_info.signature || '-'}}</td>					
						</tr>
						<tr>								
							<td>Date</td>
							<td>{{ (health_info.date_added != null) && health_info.date_added || '-' }}</td>					
						</tr>
					
						
					</table>					
				</div>
				<div class="manage-skill-content liminal-data-table UserSkillsList" ng-if="notification_info !=''">
					<table class="t-notification-info" width="100%" border="0" cellspacing="10">
						
						<tr>								
							<td>Get Notification Via Mail</td>
							<td>{{ (notification_info.notification_check == 1) && "Yes" || 'No' }}</td>					
						</tr>
						
					
						
					</table>					
				</div>
			</div>
		</div>
	</section>
</section> 