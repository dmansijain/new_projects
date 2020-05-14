<section id="main-content" class=" ">
    <section class="wrapper main-wrapper row" style=''>
			<div class="row">
				<div class="TabNavWrapper">																	
					<nav class="nav nav-tab">
						<ul>
						
							<li class="active" ng-show="productinfo.id > 0"><a data-target="#teamsProfile" data-toggle="tab"><i class="fa fa-edit"></i>Edit User</a></li>
							<li class="active" ng-show="productinfo.id==false"><a data-target="#teamaddmember" data-toggle="tab"><i class="fa fa-plus"></i>Add User</a></li>
							<li ng-show="message !=''" >{{message}}</li>
							<div class="clr"></div>
							
						</ul>
					</nav>
				</div>
				<div class="">
					<div id="teamsProfile" class="item tab-pane fade in active">
						
					<form name="editform" enctype="multipart/form-data" ng-submit="editproduct()"  id="signupform" class="team_Form">
					<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label>Username</label>
							<input class="form-control" ng-model="productinfo.login_id" name="login_id" value="" type="text" />
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label>Email</label>
							<input class="form-control" ng-model="productinfo.email" name="email" value="" type="text" />
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label>First Name</label>
							<input class="form-control" ng-model="productinfo.first_name" name="first_name" value="" type="text" />
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label>Last Name</label>
							<input class="form-control" ng-model="productinfo.last_name" name="last_name" value="" type="text" />
						</div>
						
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label>Password</label>
							<input class="form-control" ng-model="productinfo.password" name="password" value="" type="text" />
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label>User Role</label>
							<select class="form-control" name="role" ng-model="productinfo.role">
								<option value="agent">Agent</option>
								<option value="driver">Driver</option>
								<option value="admin">Administrator</option>
							</select>
						</div>
						
						
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label>Status</label>
							<select class="form-control" name="active" ng-model="productinfo.active">
								<option value="0">Deactive</option>
								<option value="1">Active</option>
							</select>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label>Profile Image</label>
							<div class="upload-btn-wrapper">
							
							  <button class="btn">Upload Image</button>
							  <input type="file" ng-model="profilepic" ng-file="profilepic" name="productinfo.profilepic" value="productinfo.profilepic" onChange="showPreview(this);"  /><span class="logo_BoX" id="targetLayer"><img src="<?= base_url();?>/uploads/profilepic/{{productinfo.profilepic}}" style="width:200px;" /></span>
							</div>
						</div>
						<div class="save_btn_Wrapper">
							<input class="save_btn" type="submit" value="Submit" />
							
						</div>
						
						
						 
						
						</div>
					</form>
				
					</div>
					
					
				</div>	
			</div>
		</section>
	</section>
  <!-- container section start -->