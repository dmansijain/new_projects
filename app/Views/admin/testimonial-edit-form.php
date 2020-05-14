<section id="main-content" class=" ">
    <section class="wrapper main-wrapper row" style=''>
			<div class="row">
				
				<div class="AddUserForm">
					<div id="teamsProfile" class="item tab-pane fade in active">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><h3 ng-show="testimonialinfo.id==false" class="PageTitel">Add Testimonial</h3><h3 ng-show="testimonialinfo.id > 0" class="PageTitel">Edit Testimonial</h3></div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<form name="editform" enctype="multipart/form-data" ng-submit="editprofile()"  id="signupform" class="team_Form">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label>Name</label>
							<input class="form-control" ng-model="testimonialinfo.name" name="name" value="" type="text" />
						</div>
						
						<div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
							<label>Description</label>
							<textarea id="editor" ng-model="testimonialinfo.description" name="description"></textarea>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label>Status</label>
							<select class="form-control" name="is_active" ng-model="testimonialinfo.is_active">
								<option value="0">Deactive</option>
								<option value="1">Active</option>
							</select>
						</div>
						<!--<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label>User Image</label>
							<div class="upload-btn-wrapper">
							
							  <span class="btn">Upload Image</span>
							  <input type="file" ng-model="user_image" ng-file="user_image" name="testimonialinfo.user_image" value="testimonialinfo.user_image" onChange="showPreview(this);"  />
							  <span class="logo_BoX" id="targetLayer">
							  <img src="<?php //base_url();?>uploads/testimonialImages/{{testimonialinfo.user_image}}" ng-show="testimonialinfo.user_image != ''"/>
							   <img src="<?php//  base_url();?>assets/images/dummy_user.jpg" style="width:200px;" ng-show="testimonialinfo.user_image == ''"/>
							  </span>
							</div>
						</div>-->
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="save_btn_Wrapper">
							<input class="save_btn" type="submit" value="Submit" />
							<a class="back_btn" href="#!/all-testimonials"><i class="fa fa-chevron-left"></i>Back</a>
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