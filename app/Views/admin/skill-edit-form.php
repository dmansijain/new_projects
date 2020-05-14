<section id="main-content" class=" ">
    <section class="wrapper main-wrapper row" style=''>
			<div class="row">
				
				<div class="AddUserForm">
					<div id="teamsProfile" class="item tab-pane fade in active">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div class="pg_title"><h2 ng-show="skillinfo.id==false" >Add skill</h2><h2 ng-show="skillinfo.id > 0" >Edit Skill</h2></div></div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<form name="editform" enctype="multipart/form-data" ng-submit="editprofile()"  id="signupform" class="team_Form">
						<div class="form-container">
						 
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group ">
                                                <label>SKill Name
                                                </label>
                                                <input type="text" ng-model="skillinfo.name" class="form-control w-90">
                                            </div>
                                        </div>
                                        
                                    </div>
                                    
                                    

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group ">
                                                <label>Description:
                                                </label>
                                                <textarea ng-model="skillinfo.description" class="form-control w-90"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
											<label>Status</label>
								<select class="form-control w-90" name="active" ng-model="skillinfo.is_active">
									<option value="0">Deactive</option>
									<option value="1">Active</option>
								</select>
                                               
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
				</div>
					</div>
					
					
				</div>	
			</div>
		</section>
	</section>
  <!-- container section start -->