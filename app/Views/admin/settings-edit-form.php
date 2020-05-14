<section id="main-content" class=" ">
    <section class="wrapper main-wrapper row" style=''>
			<div class="row">
						<div class="col-md-12">
							<div class="pg_title"><h2>Web Settings </h2></div>
						</div>
					</div>
			<div class="row">
				<!--<div class="TabNavWrapper">																	
					<nav class="nav nav-tab">
						<ul>						
							<li class="active"><a data-target="#teamsProfile" data-toggle="tab"><i class="fa fa-cog"></i>Web Settings</a></li>							
							<li ng-show="message !=''" >{{message}}</li>
							<div class="clr"></div>
							
						</ul>
					</nav> 
				</div>-->
				<div class=""> 
					
					<div id="teamsProfile" class="item tab-pane fade in active">
						
						
					<form name="editform" enctype="multipart/form-data" ng-submit="editsettings()"  id="signupform" class="team_Form">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label>Title</label>
							<input class="form-control" ng-model="settingsinfo.title" name="title" value="" type="text" />
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label>Tagline</label>
							<input class="form-control" ng-model="settingsinfo.tagline" name="tagline" value="" type="text" />
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label>Website</label>
							<input class="form-control" ng-model="settingsinfo.website" name="website" value="" type="text" />
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label>Email</label>
							<input class="form-control" ng-model="settingsinfo.email" name="email" value="" type="text" />
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label>Phone Number</label>
							<input class="form-control" ng-model="settingsinfo.phone_number" name="phone_number" value="" type="text" />
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label>Copyright</label>
							<input class="form-control" ng-model="settingsinfo.copyright" name="copyright" value="" type="text" />
						</div>
						<div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
							<label>Address</label>
							<textarea class="form-control"  value="" name="address" ng-model="settingsinfo.address" /></textarea>
						</div>
						<div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
							<label>Currency</label>
							<select class="form-control" ng-model="settingsinfo.currency_id">
							  <option ng-repeat="currency in currencies" value="{{currency.currency_id}}">{{currency.currency}}</option>
							</select>
							
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label>Facebook</label>
							<input class="form-control" ng-model="settingsinfo.facebook" name="facebook" value="" type="text" />
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label>Twitter</label>
							<input class="form-control" ng-model="settingsinfo.twitter" name="twitter" value="" type="text" />
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label>Instagram</label>
							<input class="form-control" ng-model="settingsinfo.instagram" name="instagram" value="" type="text" />
						</div>
						
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label>Logo Image</label>
							<div class="upload-btn-wrapper">
							
							  <button class="btn">Upload Image</button>
							  <input type="file" ng-model="logo" ng-file="logo" name="settingsinfo.logo" value="settingsinfo.logo" onChange="showPreview(this);"  /><span class="logo_BoX" id="targetLayer"><img src="<?= base_url();?>uploads/sitelogo/{{settingsinfo.logo}}" /></span>
							</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="save_btn_Wrapper">
							<input class="save_btn" type="submit" value="Submit" />
							
						</div> </div>
					</form>
				</div>
					</div>
					
					
				</div>	
			</div>
		</section>
	</section>
  <!-- container section start -->