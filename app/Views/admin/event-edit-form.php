<style>
#signupform .md-icon-button + .md-datepicker-input-container  {
	border:none !important;
	padding:0 !important;
}
</style>
<section id="main-content" class=" ">
    <section class="wrapper main-wrapper row" style=''>
			<div class="row">				
				<div class="AddUserForm">
					<div id="teamsProfile" class="item tab-pane fade in active">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div class="pg_title"><h2 ng-show="eventinfo.id==false" >Add Event</h2><h2 ng-show="eventinfo.id > 0" >Edit Event</h2></div></div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<form name="editform" enctype="multipart/form-data" ng-submit="editprofile()"  id="signupform" class="team_Form updated-form">
								<div class="form-container AddEvents">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group ">
												<label>Event Community</label>
												<md-input-container class="form-control">
        
        <md-select placeholder="Event Community" ng-model="eventinfo.event_community">
          <md-option ng-value="community.id" ng-repeat="community in allcommunity">{{community.title}}</md-option>
        </md-select>
      </md-input-container>
												
												<p class="AddNew" data-toggle="modal" data-target="#addnewcommunity">Add new community</p>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Event Catgeory</label>
												<md-input-container class="form-control">
       
        <md-select placeholder="Event Catgeory" ng-model="eventinfo.event_category" ng-change="selectCategory();">
          <md-option ng-value="category.id" ng-repeat="category in allcategory">{{category.title}}</md-option>
        </md-select>
      </md-input-container>
												
												<p class="AddNew" data-toggle="modal" data-target="#addnewevcatgeory">Add new event catgeory</p>
											</div>
										</div>
										
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group ">
												<label>Event Type</label>
												<md-input-container class="form-control">
        <md-select placeholder="Event Type" ng-model="eventinfo.event_type" md-on-open="getEventtypelist()" ng-change="getEventType()">
          <md-option ng-value="type.id" ng-repeat="type in alltype">{{type.title}}</md-option>
        </md-select>
      </md-input-container>
												
												<p class="AddNew" data-toggle="modal" data-target="#addneweventtype">Add new event type</p>								
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Event Type Name</label>
												<md-input-container class="form-control">
        <md-select placeholder="Event Type Name" ng-model="eventinfo.event_typename" md-on-open="getEventtypenamelist()">
          <md-option ng-value="typename.id" ng-repeat="typename in alltypename">{{typename.title}}</md-option>
        </md-select>
      </md-input-container>
	  
												
												<p class="AddNew" data-toggle="modal" data-target="#addneweventtypename">Add new event type name</p>
											</div>
										</div>		
										
										
									</div>
									
									<div class="row">
										<div class="col-md-6">
											<div class="form-group date">
											<label>Start Date</label>
											<md-datepicker md-min-date="date" date="true" ng-model="eventinfo.start_date" md-placeholder="Enter date"></md-datepicker>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
											<label>End Date</label>
											<md-datepicker md-min-date="eventinfo.start_date"  ng-model="eventinfo.end_date" md-placeholder="Enter date"></md-datepicker>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group ">
											<label>Start Time</label>
											<md-time-picker ng-model="eventinfo.start_time" md-placeholder="Enter date" no-meridiem no-auto-switch></md-time-picker>
										</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
											<label>End Time</label>
											<md-time-picker ng-model="eventinfo.end_time" md-placeholder="Enter date" no-meridiem no-auto-switch></md-time-picker>
										</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group ">
											<label>Cost</label>
											<input type="text" ng-model="eventinfo.cost" class="form-control w-90">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
											<label>Minimum Deposit</label>
											<input type="text" ng-model="eventinfo.min_deposit" class="form-control w-90">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group ">
												<label>Maximum Attendees:</label>
												<input type="text" ng-model="eventinfo.max_attendees" class="form-control w-90">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Maximum Staff:</label>
												<input type="text" ng-model="eventinfo.max_staff" class="form-control w-90">
											</div>
										</div>
									</div>
									<div class="row">
									
										<div class="col-md-12">
											<div class="form-group ">
											<label>Details</label>
												<textarea id="editor" name="details" ng-model="eventinfo.details" class="form-control w-90"></textarea>
											</div>
										</div>
										
										
									</div>
									
									<div class="row">
									
										<div class="col-md-12">
											<div class="form-group ">
											<label>Details Pop Up</label>
									<textarea id="details_popup" name="details_popup" ng-model="eventinfo.details_popup" class="form-control w-90"></textarea>
											</div>
										</div>
										
										
									</div>

									<div class="row">
										<div class="col-md-6">
											<div class="form-group ">
												<label>Age Requirement:</label>
												<input ng-model="eventinfo.age_requirement" type="text" class="form-control w-90" id="start-date">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Location:</label>
												<input ng-model="eventinfo.location" googleplace type="text" class="form-control w-90">
												<input ng-model="eventinfo.lat"  type="hidden" class="form-control w-90">
												<input ng-model="eventinfo.lng"  type="hidden" class="form-control w-90">
											</div>
										</div>
									</div> 
									<div class="row radio-container">
										<div class="col-md-12">
											<div class="form-group">
												<label>Security:</label>
												<div class="col-md-3">
													<div class="w-80 text-center">
														<div class="iradio_flat-green" style="position: relative;">
															<input type="radio" class="flat" name="security" ng-model="eventinfo.security" id="genderM" value="Public" checked="" required="" style="position: absolute; opacity: 0;">
														</div>
														<p class="option-text"> Public </p>
													</div>

												</div>
												<div class="col-md-3">
													<div class="w-80 text-center">
														<div class="iradio_flat-green" style="position: relative;">
															<input type="radio" class="flat" name="security" ng-model="eventinfo.security" id="genderM" value="Private - Requires Code" checked="" required="" style="position: absolute; opacity: 0;">
														</div>
														<p class="option-text"> Private - Requires Code </p>
													</div>
												</div>
												<div class="col-md-3">
													<div class="w-80 text-center">
														<div class="iradio_flat-green" style="position: relative;">
															<input type="radio" class="flat" name="security" ng-model="eventinfo.security" id="genderM" value="Public Restricted" checked="" required="" style="position: absolute; opacity: 0;">
														</div>
														<p class="option-text"> Public Restricted </p>
													</div>
												</div>
												<div class="col-md-3">
													<div class="w-80 text-center">
														<div class="iradio_flat-green checked" style="position: relative;"><input type="radio" class="flat" name="security" ng-model="eventinfo.security" id="genderM" value="Private Restricted" checked="" required="" style="position: absolute; opacity: 0;"></div>
														<p class="option-text"> Private Restricted </p>
													</div>
												</div>
											</div>
										</div>
									</div>	
								<div class="row">
								<div class="col-md-12">
								<label>Skill Required</label>
								</div>
								</div>									
									<div class="row" att="{{choice}}" data-ng-repeat="choice in choices">
									
									  
									<div class="col-md-2" ng-if="$index!=0"><div class="form-group"><select class="form-control" ng-model="eventinfo.skill_condition[$index]" name="name"><option value="OR">Or</option><option value="AND">And</option></select></div></div>
									<div class="col-md-8" ng-if="$index==0">
											<div class="form-group">
												<input type="text" style="display:none;" ng-model="eventinfo.skill_condition[$index]" value="RR" >
												<md-input-container class="form-control">
        <md-select placeholder="Skill Required" ng-model="eventinfo.skill_requirement[$index]">
		<md-option ng-value="0" >None</md-option>
          <md-option ng-value="allskill.id" ng-repeat="allskill in allskills">{{allskill.name}}</md-option>
        </md-select>
      </md-input-container>
	  </div>
											<p class="AddNew" ng-if="$index==0" data-toggle="modal" data-target="#addanotherskill">Add new skill</p>
										</div>
										<div class="col-md-6" ng-if="$index!=0">
											<div class="form-group">
												
												<md-input-container class="form-control">
        <md-select placeholder="Skill Required" ng-model="eventinfo.skill_requirement[$index]">
		<md-option ng-value="0" >None</md-option>
          <md-option ng-value="allskill.id" ng-repeat="allskill in allskills">{{allskill.name}}</md-option>
        </md-select>
      </md-input-container>
	  </div>
	  
											<p class="AddNew" ng-if="$index==0" data-toggle="modal" data-target="#addanotherskill">Add new skill</p>
										</div>	
										<div class="col-md-4">
											<div class="form-group">
											    <button type="button" class="RemoveohterSkill" ng-if="$index<=choices.length-1 && $index!=0" ng-click="removeNewChoice()">Remove</button>
												
												<p class="AddohterSkill" ng-if="$index==choices.length-1" ng-click="addNewChoice()">Add an other skill</p>
											</div>
										</div>			
										
									</div>
									<div id="OtherSkill" class="HiddenBox">
									</div>  
									 
									<div class="row">
										<div class="col-md-8">
											<div class="form-group ">
												<label>Skill Earned at Completion:
												</label>
												<md-input-container class="form-control">
        <md-select placeholder="Skill Earned at Completion" ng-model="eventinfo.skill_earned">
		<md-option ng-value="0" >None</md-option>
          <md-option ng-value="allskill.id" ng-repeat="allskill in allskills">{{allskill.name}}</md-option>
        </md-select>
      </md-input-container>
												
											</div>
										</div>
										<div class="col-md-4">
											
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group ">
												<label>Role:
												</label>
											
												<md-input-container class="form-control">
        <md-select placeholder="Role" ng-model="eventinfo.role">
          <md-option ng-value="role" ng-repeat="role in roles">{{role}}</md-option>
        </md-select>
      </md-input-container>
												
											</div>
										</div>
										
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group ">
												<label>Leader:
												</label>
												<md-input-container class="form-control">
        <md-select placeholder="Leader" ng-model="eventinfo.leader" md-on-open="getleaderlist()" multiple>
          <md-option ng-value="leader.ID" ng-repeat="leader in allleaders">{{leader.first_name}} {{leader.last_name}}</md-option>
        </md-select>
      </md-input-container>
												
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Invite Code: 6 Digits
												</label>
												<input ng-model="eventinfo.invite_code" type="text" class="form-control w-90">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<input class="btn btn-primary btn-lg" type="submit" name="submit" id="" value="Submit">
										</div>
										<div class="col-md-6">
										</div>
									</div>
								</div>
							</form>
							
							<!-- Add new community -->
										<div id="addnewcommunity" class="modal fade AddNewFilds" role="dialog">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal">&times;</button>
														<h4 class="modal-title">Add new community</h4>
													</div>
													<div class="modal-body">
														<input type="text" ng-model="submitcommunity.title" placeholder="Title" >
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-default Submit" ng-click="addcommunity()">Submit</button>
													</div>
												</div>
											</div>
										</div>
										<!-- Add new event catgeory -->
										<div id="addnewevcatgeory" class="modal fade AddNewFilds" role="dialog">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal">&times;</button>
														<h4 class="modal-title">Add new event catgeory</h4>
													</div>
													<div class="modal-body">
														<input type="text" ng-model="submitcategory.title" placeholder="Title" >
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-default Submit" ng-click="addcategory()">Submit</button>
													</div>
												</div>
											</div>
										</div>
											<!-- Add new Event Type -->
										<div id="addneweventtype" class="modal fade AddNewFilds" role="dialog">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal">&times;</button>
														<h4 class="modal-title">Add new event Type</h4>
													</div>
													<div class="modal-body">
														<label>Select event Catgeory</label>
														<md-input-container class="form-control">
        <md-select placeholder="Event Catgeory" ng-model="submittype.cat_id">
          <md-option ng-value="category.id" ng-repeat="category in allcategory">{{category.title}}</md-option>
        </md-select>
      </md-input-container>
														<input type="text" ng-model="submittype.title" placeholder="Title" >
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-default Submit" ng-click="addeventtype()">Submit</button>
													</div>
												</div>
											</div>
										</div>								
										<!-- Add new Event Type name-->
										<div id="addneweventtypename" class="modal fade AddNewFilds" role="dialog">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal">&times;</button>
														<h4 class="modal-title">Add new Event Type name</h4>
													</div>
													<div class="modal-body">
														<label>Select event Catgeory</label>
														<md-input-container class="form-control">
        <md-select placeholder="Event Catgeory" ng-model="submittypename.cat_id">
          <md-option ng-value="category.id" ng-repeat="category in allcategory">{{category.title}}</md-option>
        </md-select>
      </md-input-container>
														<label>Select event Type</label>
														<md-input-container class="form-control">
        <md-select placeholder="Event Type" ng-model="submittypename.event_type" md-on-open="getEventtypelists()">
          <md-option ng-value="type.id" ng-repeat="type in alltype">{{type.title}}</md-option>
        </md-select>
      </md-input-container>														
														<input style="margin-top:10px;" type="text" ng-model="submittypename.title" placeholder="Title" >
														
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-default Submit" ng-click="addeventtypename()">Submit</button>
													</div>
												</div>
											</div>
										</div>
										
										<!-- Add new Event Type name-->
										<div id="addanotherskill" class="modal fade AddNewFilds" role="dialog">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal">&times;</button>
														<h4 class="modal-title">Add New skill</h4>
													</div>
													<div class="modal-body">													
														<input style="margin-top:10px;" type="text" ng-model="submitskills.title" placeholder="Title" >
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-default Submit" ng-click="addskills()">Submit</button>
													</div>
												</div>
											</div>
										</div>
						</div>
					</div>
				</div>	
			</div>
		</section>
	</section>	
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment-with-locales.min.js"></script>
  <!-- container section start -->