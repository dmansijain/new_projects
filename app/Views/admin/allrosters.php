<section id="main-content" class=" ">
    <section class="wrapper main-wrapper row" style=''>
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="TopBtn_box">
					<div class="clearfix">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="pg_title"><h2>Manage Roster {{ current_event_name }}</h2></div>
						</div>
						
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pl-0">
							<div class="form-inline  text-left form-filter-tp form-filter-tp-full">
											<div class="form-group form-event-filter">
											<label for="event_filter">Event Filter</label>
											
											
											<select onfocus='this.size=5;' onblur='this.size=1;' class="form-control" ng-model= "eventID" ng-change="eventFilter()">
											  <option ng-repeat="event in eventlists" value="{{event.id}}">{{event.typenametitle ? event.typenametitle :  event.event_typename}}, {{event.location}} ,{{event.start_date | date : 'MM/dd/yyyy'}}</option>
											 
											</select>
												<!--<label for="date">Date</label>
												<div class="input-group date" id="FromDate">
												<md-datepicker md-min-date="date" date="true" class="form-date-control" ng-model="eventinfo.start_date" md-placeholder="From -"></md-datepicker>-->
													<!--<input type="text" class="form-control dt-select" placeholder="From -">
													<span class="input-group-addon">
													   <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>
													</span>-->
												<!--</div>
												<div class="input-group date" id="ToDate">
												<md-datepicker md-min-date="eventinfo.start_date" class="form-date-control"  ng-model="eventinfo.end_date" md-placeholder="To -"></md-datepicker>
													<input type="text" class="form-control dt-select" placeholder="To -">
													<span class="input-group-addon">
													   <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>
													</span>-->
												</div>
												
												
											</div>
										</div> 
							<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-right">
							<div class="iblock-input">
								<div class="form-group frm-group-sall">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" ng-model="selectAll" ng-click="checkAll()" id="invalidCheck" required>
								<label class="form-check-label">Select All</label>
							</div>
							</div>
								<button class="btn btn-primary" ng-click="completeRoster()">Complete Selected</button>
								</div>
								
							</div>
										</div>
						</div>
						</div>
					</div>
					
				</div>
				<p style="color:red">{{error_message}}</p>
				<!--<div class="well bg-default search-well">
							
								<div class="row">
									<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
										
									</div>
									<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
										
									</div>
									<!--<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
										<input style="float: right;" type="button" name="search" value="Search" ng-click="dtInstance.changeData(newSource)" class="btn btn-primary">
									</div>-->
								<!--</div>
						
						</div>-->
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" ng-show="event_detail != ''">
					<div class="Team_Wrapper AllUserTop admin-responsive-table-scroll">
					
					<table class="table table-bordered bordered table-striped table-condensed datatable all-roster-table">
					<thead>
					<tr>
					<th class="sorting">Event Category</th>
					<th class="sorting">Event Type</th>
					<th class="sorting">Event Type Name</th>
					<th class="sorting">Price</th>
					<th class="sorting">Date</th>
					<th class="sorting">Location</th>
					<th class="sorting">Participants Signed Up</th>
					</tr>
					</thead>
					<tbody>
					<tr>
					 <td>{{ event_detail.cattitle }}</td> 
					 <td>{{ event_detail.typetitle }}</td> 
					 <td>{{ event_detail.typenametitle ? event_detail.typenametitle :  event_detail.event_typename }}</td> 
					 <td><?php echo get_currency();?> {{ event_detail.cost }}</td> 
					 <td>{{ event_detail.start_date }}</td>
					 <td>{{ event_detail.location }}</td>
					 <td>{{ rostercount }}</td>
					</tr>
					</tbody>
					</table>
					</div>
					
				</div>
					
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="Team_Wrapper AllUserTop admin-responsive-table set-w-selt">
					<table datatable
					   dt-options="dtOptions" 
					   dt-columns="dtColumns" dt-instance="dtInstance"  class="table table-bordered bordered table-striped table-condensed datatable all-roster-table1">
					</table>
					</div>
				</div>				
				
			</div>
		</section>
	</section> 
<script>
/* function sendEmailNotification(EventOrderId) {
	$.ajax({
		type: "POST",
		url: "<?php echo base_url()?>api/roster/send_notification_mail",
		data: {event_order_id: EventOrderId},
		beforeSend: function () {
		
		},
		success: function (response) {

			
		},
		complete: function () {
		
		},
		error: function () {
		}
	});
} */
</script>