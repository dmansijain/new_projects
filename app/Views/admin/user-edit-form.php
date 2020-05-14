<section id="main-content" class=" ">
    <section class="wrapper main-wrapper row" style=''>
			<div class="row">
				
				<div class="AddUserForm">
					<div id="teamsProfile" class="item tab-pane fade in active">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><h3 ng-show="productinfo.id==false" class="PageTitel">Add User</h3><h3 ng-show="productinfo.id > 0" class="PageTitel">Edit User</h3></div>
						
					<form name="editform" enctype="multipart/form-data" ng-submit="editproduct()"  id="signupform" class="team_Form">
							<div class="col-lg-12 col-md-121 col-sm-12 col-xs-12">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							
								<div ng-if="userID !='0'">
								
								<label class="label-block"><span class="label-title">Email:</span> {{productinfo.email}}</label>
								<label class="label-block"><span class="label-title">Username:</span> {{productinfo.login_id}}</label>
								
								</div>
								<label>First Name</label>
								<input class="form-control" ng-model="productinfo.first_name" name="first_name" value="" type="text" />
								<label>Last Name</label>
								<input class="form-control" ng-model="productinfo.last_name" name="last_name" value="" type="text" />
								<div ng-if="userID =='0'">
								<label>Username</label>
								<input class="form-control" ng-model="productinfo.login_id" name="email" value="" type="text" />
								<label>Email</label>
								<input class="form-control" ng-model="productinfo.email" name="email" value="" type="text" />
								</div>
								<div ng-show="productinfo.is_login == 1 || productinfo.id  == ''">
								<label>Password</label>
								<input class="form-control" ng-model="productinfo.password" name="password" value="" type="password" />
								</div>
							</div>
							
							
							
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div ng-show="productinfo.id  == ''">
							<label>User Role</label>
								<select class="form-control" name="role" ng-model="productinfo.role">
									<option value="customer">Customer</option>
									<option value="staff">Staff</option>
									<option value="admin">Administrator</option>
									<option value="event_manager">Event Manager</option>
								</select>
							</div>
						<div ng-show="productinfo.is_login == 0 || productinfo.id  == ''">
								<label>Status</label>
								<select class="form-control" name="active" ng-model="productinfo.active">
									<option value="0">Deactive</option>
									<option value="1">Active</option>
								</select>
							</div>
								<label>Profile Image</label>
								<div class="upload-btn-wrapper">
								
								  <span class="btn">Upload Image</span>
								  <input type="file" ng-model="profilepic" ng-file="profilepic" name="productinfo.profilepic" value="productinfo.profilepic" onChange="showPreview(this);"  /><span class="logo_BoX" id="targetLayer">
								  
								  <img src="<?= base_url();?>/uploads/profilepic/{{productinfo.profilepic}}" style="width:200px;" ng-show="productinfo.profilepic != ''"/>
								  <img src="<?= base_url();?>assets/images/dummy_user.jpg" style="width:200px;" ng-show="productinfo.profilepic == ''"/>
								  </span>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="save_btn_Wrapper">
								<a class="back_btn" href="#!/all-users"><i class="fa fa-chevron-left"></i> Back</a>
								<input class="save_btn" type="submit" value="Submit" />
							</div></div>					
						</div>
					</form>
					</div>
					
					
				</div>	
			</div>
			</section>
	</section>
  <!-- container section start -->