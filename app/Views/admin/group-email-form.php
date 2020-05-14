<section id="main-content" class=" ">
    <section class="wrapper main-wrapper row" style=''>
			<div class="row">
				
				<div class="AddUserForm">
					<div id="teamsProfile" class="item tab-pane fade in active">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div class="pg_title"><h2>Send Mail</h2></div></div>
					
						<div class=" ">
					<form name="editform" enctype="multipart/form-data" ng-submit="sendmail()"  id="signupform" class="team_Form updated-form">
								<div class="form-container AddEvents">
									<div class="row">
									<div class="col-md-12">
											<div class="form-group ">
												<label>To</label>
												<input type="text" ng-model="groupinfo.to" readonly="readonly">
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group ">
												<label>Subject</label>
												<input type="text" ng-model="groupinfo.subject">
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label>Message</label>
												<textarea ng-model="groupinfo.message" row="7"></textarea>
												
												
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
																	
										
									
					
				</div>
					</div>
					
					
				</div>	
			</div>
		</section>
	</section>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment-with-locales.min.js"></script>
  <!-- container section start -->