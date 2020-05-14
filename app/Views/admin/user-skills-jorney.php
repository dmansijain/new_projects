<section id="main-content" class=" ">
    <section class="wrapper main-wrapper row" style=''>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="TopBtn_box">
					<div class="row">
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
							<div class="pg_title"><h2>Skills & Journey of {{productinfo.first_name}} {{productinfo.last_name}}</</h2></div>
						</div>					
					</div>
					<!--<div class="row">
						<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
							<li role="presentation" class="active">
								<a href="javascript:void()" ng-click="skillsofuser()" role="tab" id="" data-toggle="tab" aria-expanded="true">Manage Skills</a>
							</li>
						<li role="presentation" class="">
								<a href="javascript:void()" ng-click="journeyofuser()" id="" role="tab" data-toggle="tab" aria-expanded="false">Manage journey</a>
							</li>
						</ul>
					</div>-->						
				</div>
				<div class="TopBtn_box" style="margin-top:20px;">	
					<!--<a class="contentTop_left" ng-if="addjourney==true" href="javascript:void()" data-toggle="modal" data-target="#Addnewjourny"><i class="fa fa-plus"></i> Add New Journey</a>-->
					<a class="contentTop_left" ng-if="addskill==true" href="javascript:void()" data-toggle="modal" data-target="#AddnewSkills"><i class="fa fa-plus"></i> Add New Skills</a>
				</div>				
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="manage-skill-content UserSkillsList" ng-if="allskills !=''">
					<table width="100%" border="0" cellspacing="10">
						<tr>
							<th width="70%">Skill Name</th>
							<th width="30%">Action</th>
						</tr>
						<tr ng-repeat="allskill in allassignskills">								
							<td>
								<img src="<?php echo base_url(); ?>assets/frontend/img/small-icon.png" alt="Initiial Staffing" />
								{{allskill.name}}
							</td>
							<td>
								<div class="input-group skill-list">
									<button ng-click="decrement(allskill)" class='qtyminus' ng-disabled="allskill.id <=0">-</button>
									<input type='text' name='quantity' ng-value="1" class='qty' />
									<button ng-click="increment(allskill)">+</button>
								</div>
							</td>						
						</tr>
					</table>							
				</div>
				<div class="manage-skill-content liminal-data-table UserSkillsList" ng-if="alljourneys !=''">
					<table width="100%" border="0" cellspacing="10">
						<tr>
							<th width="70%">Event Name</th>
							<th width="30%">Action</th>
						</tr>							
						<tr ng-repeat="allskill in alljourneys">
							<td>
								<img src="<?php echo base_url(); ?>assets/frontend/img/small-icon.png" alt="Initiial Staffing" />
								{{allskill.event_name}}
							</td>
							<td>
								<div class="skill-list">
									<a href="javascript:void()" class="btn btn-primary btn-lg"> Go</a>
								</div>
							</td>
						</tr>
					</table>					
				</div>					
			</div>
		</div>
	</section>
</section> 


<!-- Modal Add new Skill -->
<div id="AddnewSkills" class="modal fade AddNewFilds" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Add new Skill to User</h4>
			</div>
			<form action="">
				<div class="modal-body">
				<md-input-container class="form-control">
        <md-select placeholder="Select Skill" ng-model="assignskilltouser.skill_id">
          <md-option ng-value="allskill.id" ng-repeat="allskill in allskills">{{allskill.name}}</md-option>
        </md-select>
      </md-input-container>
										
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default Submit" ng-click="addskilltouser()">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Modal Add new journey -->
<div id="Addnewjourny" class="modal fade AddNewFilds" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Add new journey</h4>
			</div>
			<form action="">
				<div class="modal-body">
				<md-input-container class="form-control">
        <md-select placeholder="Select Event" ng-model="eventinfo.skill_requirement[$index]">
          <md-option ng-value="journey.id" ng-repeat="journey in alljourneys">{{journey.event_name}}</md-option>
        </md-select>
      </md-input-container>
										
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default Submit">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>