<section id="main-content" class=" ">
    <section class="wrapper main-wrapper row" style=''>
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="TopBtn_box">
						<div class="pg_title"><h2>Manage Events <a class="contentTop_left" href="#!/event-edit/0"><i class="fa fa-plus"></i> Add New Event</a></h2></div>
					</div>
					
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="well bg-default search-well">
							
								<div class="row">
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
										<div class="form-inline  text-right">
											<div class="form-group">
												<label for="date">Date</label>
												<div class="input-group date" id="FromDate">
												<md-datepicker md-min-date="date" date="true" class="form-date-control" ng-model="eventinfo.start_date" md-placeholder="From -"></md-datepicker>
													<!--<input type="text" class="form-control dt-select" placeholder="From -">
													<span class="input-group-addon">
													   <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>
													</span>-->
												</div>
												<div class="input-group date" id="ToDate">
												<md-datepicker md-min-date="eventinfo.start_date" class="form-date-control"  ng-model="eventinfo.end_date" md-placeholder="To -"></md-datepicker>
													<!--<input type="text" class="form-control dt-select" placeholder="To -">
													<span class="input-group-addon">
													   <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>
													</span>-->
												</div>
												<span class="input-search">
													<input type="button" name="search" value="Search" ng-click="dtInstance.changeData(newSource)" class="btn btn-primary">
												</span>
											</div>
										</div> 
									</div>
	
								</div>
						
						</div>
						</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="Team_Wrapper AllUserTop">
					
					<table datatable
       dt-options="dtOptions" 
       dt-columns="dtColumns" dt-instance="dtInstance"  class="table table-bordered bordered table-striped table-condensed datatable all-event-table">
    </table>
					</div>
				</div>				
				
			</div>
		</section>
	</section> 