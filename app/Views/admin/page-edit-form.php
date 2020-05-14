<section id="main-content" class=" ">
    <section class="wrapper main-wrapper row" style=''>
			<div class="row">
				
				<div class="AddUserForm">
					<div id="teamsProfile" class="item tab-pane fade in active">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div class="pg_title"><h2 ng-show="pageinfo.id==false" >Add Page</h2><h2 ng-show="pageinfo.id > 0" >Edit Page</h2></div></div>
						<div class=" ">
					<form name="editform" enctype="multipart/form-data" ng-submit="editprofile()"  id="signupform" class="team_Form">
					<div class="form-container">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label>Title</label>
							<input class="form-control" ng-model="pageinfo.title" name="title" value="" type="text" />
						</div>
						
						<div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
							<label>Short Description</label>
							<textarea  value="" name="short_description" ng-model="pageinfo.short_description" /></textarea>
						</div>
						<div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
							<label>Description</label>
							<textarea id="editor"  ng-model="pageinfo.description"></textarea> 
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label>Status</label>
							<select class="form-control" name="is_active" ng-model="pageinfo.is_active">
								<option value="0">Deactive</option>
								<option value="1">Active</option>
							</select>
						</div>
						<div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
							<label>Banner Image</label>
							<div class="upload-btn-wrapper">
							
							  <span class="btn">Upload Image</span>
							  <input type="file" ng-model="banner_image" ng-file="banner_image" name="pageinfo.banner_image" value="pageinfo.banner_image" onChange="showPreview(this);"  /><span class="logo_BoX" id="targetLayer">
							  <img src="<?= base_url();?>uploads/bannerimg/{{pageinfo.banner_image}}" ng-show="pageinfo.banner_image != ''"/>
							  <img src="<?= base_url();?>assets/images/dummy.jpg" ng-show="pageinfo.banner_image == ''" />
							  </span>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="save_btn_Wrapper">
							<input class="save_btn" type="submit" value="Submit" />
							<a class="back_btn" href="#!/all-pages"><i class="fa fa-chevron-left"></i>Back</a>
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