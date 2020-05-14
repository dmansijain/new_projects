<section id="main-content" class=" ">
    <section class="wrapper main-wrapper row" style=''>
			<div class="row">
				
				<div class="AddUserForm">
					<div id="teamsProfile" class="item tab-pane fade in active">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div class="pg_title"><h2 ng-show="groupinfo.id==false" >Add Group</h2><h2 ng-show="groupinfo.id > 0" >Edit Group</h2></div></div>
						<div class=" ">
					<form name="editform" enctype="multipart/form-data" ng-submit="editgroup()"  id="signupform" class="team_Form">
					<div class="form-container">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label>Group name</label>
							<input class="form-control" ng-model="groupinfo.group_name" name="title" value="" type="text" />
						</div>
						
						<div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
							<label>Community</label>
							<input class="form-control" ng-model="groupinfo.community" name="community" value="" type="text" />
						</div>
						<div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
							<label>Description</label>
							<textarea id="editor"  ng-model="groupinfo.description"></textarea> 
						</div>
						
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="save_btn_Wrapper">
							<input class="save_btn" type="submit" value="Submit" />
							<a class="back_btn" href="#!/all-groups"><i class="fa fa-chevron-left"></i>Back</a>
						</div>
						</div>
						</div>
					</form>
				</div>
					</div>
					
					
				</div>	
			</div>
		</section>
	</section>
  <!-- container section start -->