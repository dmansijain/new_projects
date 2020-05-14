<section id="main-content" class=" ">
    <section class="wrapper main-wrapper row" style=''>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="TopBtn_box">
					<div class="row">
						<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
							<div class="pg_title"><h2>Event Detail</h2></div>
						</div>					
					</div>
											
				</div>
								
			</div>
			
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 tab-inside-table">
				<div class="manage-skill-content UserSkillsList">
					<table class="roster-dtl-tb" width="100%" border="0" cellspacing="10">
					
						<tr>
							<td>Community</td>
							<td>{{eventinfo.communitytitle}}</td>
						</tr>
						<tr>								
							<td>Category</td>
							<td>{{eventinfo.cattitle}}</td>					
						</tr>
						<tr>								
							<td>Event Type</td>
							<td>{{eventinfo.typetitle}}</td>					
						</tr>
						<tr>								
							<td>Event Type Name</td>
							<td>{{eventinfo.typenametitle ? eventinfo.typenametitle : eventinfo.event_typename}}</td>					
						</tr>
						<tr>								
							<td>Location</td>
							<td>{{eventinfo.location}}</td>					
						</tr>
						<tr>								
							<td>Start Date</td>
							<td>{{eventinfo.start_time | date:'EEEE, MMMM d, y h:mm a'}}</td>					
						</tr>
						<tr>								
							<td>End Date</td>
							<td>{{eventinfo.end_time | date:'EEEE, MMMM d, y h:mm a'}}</td>					
						</tr>
						
						<tr>								
							<td>Price</td>
							<td>{{eventinfo.cost ? eventinfo.currency : '' }} {{eventinfo.cost ? eventinfo.cost : "No Cost" }}</td>					
						</tr>
						
						<tr>								
							<td>Minimum Deposite</td>
							<td>{{eventinfo.min_deposit ? eventinfo.currency : ""}} {{eventinfo.min_deposit ? eventinfo.min_deposit : "No Minimum Deposite"}}</td>					
						</tr>
						<tr>								
							<td>Age Requirement</td>
							<td>{{eventinfo.age_requirement}} years</td>					
						</tr>
						
					</table>							
				</div>
				

			</div>
		</div>
	</section>
</section>  
