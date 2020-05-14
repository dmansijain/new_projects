<!--==========================
    Intro Section
  ============================-->
    <section id="intro" class="clearfix">
        <div class="container h-100">
            <div class="row ">
                <div class="col-md-12 order-md-first order-last">
                    <header class="section-header">
                        <h1 class="border-heading text-center">COUPLES</h1>
                    </header>

                </div>
            </div>

        </div>
    </section><!-- #intro -->

    <main id="main">

        <!--==========================
      Services Section
    ============================-->
        <section id="portfolio" class="section-bg tab-design">

            <div class="container">
                <div class="w-80">

                    <p class="content">organization that will transform and grow your community and you. We are a group of seasoned practitioners curating content and experiences for your church or </p>
                    <header class="section-header text-center">
                        <h4>Things </h4>
                        <h1 class="border-heading text-center">WE DO:</h1>
                    </header>
                    <div class="row justify-content-center goth">
                        <ul id="tabs" class="nav nav-tabs" role="tablist">
                            <li class="nav-item" ng-repeat="Typelist in Typelists">
                                <a ng-class="{active: Typelist.id == selectedType}" id="tab-A" href="javascript:void(0);" ng-click="getSelectedText(Typelist.id)" class="nav-link" data-toggle="tab" role="tab">{{Typelist.title}}</a>
                            </li>
                            <!--<li class="nav-item">
                                <a id="tab-B" href="javascript:void(0);" ng-click="getSelectedText('weekend')" class="nav-link" data-toggle="tab" role="tab">Weekends</a>
                            </li>
                            <li class="nav-item">
                                <a id="tab-C" href="javascript:void(0);" ng-click="getSelectedText('retreats')" class="nav-link" data-toggle="tab" role="tab">Retreats</a>
                            </li>-->
                        </ul>


                        <div id="content" class="tab-content" role="tablist">
                            <div id="pane-A" class="card tab-pane fade show active" role="tabpanel" aria-labelledby="tab-A">
                                
                                <div id="collapse-A" class="collapse show" role="tabpanel" aria-labelledby="heading-A">
                                    <div class="card-body">
                                        <div class="">
                                            <p class="content ">We are a group of seasoned practitioners curating content and experiences for your church or organization that will transform and grow your community and you.</p>
											
											<div class="col-md-12">
												<div class="row">
													<div class="col-md-4 p-0">
														<h3 class="event-heading">Upcoming <strong>EVENTS</strong> </h3>
													</div>
													<div class="col-md-8 p-0 input-t-group">
													<input class="form-group Searchskill" name="Searchkeyword" ng-model="Searchkeyword" ng-keyup="getSelectedText(selectedType)" type="text" placeholder="Search keyword" >
													<!--<div class="filter-section FrontendFilter">
															<div class="dropdown">	
																<md-input-container>
																<label>Search By : Skill</label>
																  <md-select aria-label="selectedSkill" ng-model="selectedSkill" name="selectedSkill" ng-change="getSelectedText()">
																	<md-optgroup label="Search by Skill">
																	<md-option value="">All</md-option>
																	  <md-option ng-repeat="skillist in skillists" ng-value="skillist.id">{{skillist.name}}</md-option>
																	</md-optgroup>
																  </md-select>
																</md-input-container>                                                
															</div>
														</div>-->
														<div class="filter-section FrontendFilter">
															<div class="dropdown">	
																<md-input-container>
																  <md-select aria-label="selectedDate" ng-model="selectedDate" name="selectedDate" ng-change="getSelectedText(selectedType)">
																	<md-optgroup label="Sort By :">
																	  <md-option ng-repeat="eventdate in eventdates" ng-value="eventdate">{{eventdate}}</md-option>
																	</md-optgroup>
																  </md-select>
																</md-input-container>                                                
															</div>
														</div>
													</div>
												</div>
											</div> 
										<ul class="nav nav-tabs view-map-tab">
										  <li class="nav-item active" id="list_view"><a data-toggle="tab" href="#listview" class="nav-link"><i class="fa fa-eye" aria-hidden="true"></i></a></li>
										  <li class="nav-item" id="map_view" data-click-count = "1"><a data-toggle="tab" href="#mapview"  class="nav-link"><i class="fa fa-map-marker" aria-hidden="true"></i></a></li>
										 
										</ul>
										<div class="tab-content">
										<div id="listview" class="tab-pane fade in active show">
									<div class=" d-flex justify-content-center">
                                                <div class="col-lg-12 p-0">
											
										
												<div class="table-responsive table-theme-liminal couples_table">
												<p class="validation-error" ng-bind-html="message"></p>
														<table class="table table-bordered">
															<thead>
																<tr>
																	<th>Event Type Name</th>
																	<th>Location</th>
																	<th>Action</th>
																</tr>
															</thead>
															<tbody>
																<tr ng-repeat="eventlist in eventlists | startFrom:currentPage*pageSize | limitTo:pageSize">
																	<td>
																		<figure class="tb-figure">
																			<img src="<?php echo base_url(); ?>assets/frontend/img/small-icon.png">
																		</figure>
																		<span class="c-t"><a href="eventdetail/{{eventlist.typenametitle ? eventlist.typenametitle :  eventlist.event_typename | slugify}}-{{eventlist.id}}">{{eventlist.typenametitle ? eventlist.typenametitle :  eventlist.event_typename}}, {{eventlist.start_date | date : 'MM/dd/yyyy'}}</a></span>
																	</td>
																	<td>{{eventlist.location}}</td>
																	<td>
																		<div class="c-t">
																		
																		
       
		<a href="javascript:void(0)" ng-if="eventlist.go_btn ==1" ng-click="gotocart(eventlist)" class="btn primary-btn"> Go</a>
				<a href="javascript:void(0)" ng-if="eventlist.login_btn ==1" data-toggle="modal" data-target="#loginForm" class="btn primary-btn">Login To Attend</a>
			<a href="javascript:void(0)" ng-if="eventlist.full_btn ==1" class="btn primary-btn">Full</a>
			<a href="javascript:void(0)" ng-if="eventlist.alreadyregister_btn ==1" class="btn primary-btn">Already Register</a>
			
																		
						</div>
																	</td>
																</tr>
																<tr>
																 <td colspan="3" ng-show="eventlists ==''" >Not Found</td>
																</tr>
															</tbody>
														</table>
													</div>
												
													
                                                  
                                                    
                                                     
                                                    <div class="btn-container text-center">
                                                        <a href="eventlist" class="btn primary-btn">
                                                                View All
                                                            </a>
                                                    </div>
                                                </div>

                                            </div>
											
											</div>
											 <div id="mapview" class="tab-pane fade">
										<div id="map"></div>
									  </div>
											</div>
										
										
										
										
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


                </div>
            </div>
        </section><!-- #services -->

       
    </main>
