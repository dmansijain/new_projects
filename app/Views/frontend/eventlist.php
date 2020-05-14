<!--==========================
    Intro Section
  ============================-->
    <section id="intro" class="clearfix">
        <div class="container h-100">
            <div class="row ">
                <div class="col-md-12 order-md-first order-last">
                    <header class="section-header">
                        <h1 class="border-heading text-center">Event List</h1>
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
                <div class="row justify-content-center goth">
                    <div class="col-md-12 p-0 d-flex justify-content-center">
                        <div class="col-lg-10 p-0">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12 p-0">

                                        <h3 class="event-heading">Upcoming <strong>EVENTS</strong> </h3>
                                    </div>
                                    <div class="col-md-12 p-0 input-t-group  input-t-eventlist mt-0">
									<input class="form-group Searchskill" type="text" placeholder="Search By Keyword" name="Searchkeyword" ng-model="Searchkeyword" ng-keyup="getSelectedText()">
                                        <div class="filter-section FrontendFilter">
                                            <div class="dropdown">											
												<md-input-container>
												  <label>Filter By : Category</label>
												  <md-select ng-model="selectedCategory" ng-change="getSelectedText()">
													<md-optgroup label="Category">
													 <md-option value="">All</md-option>
													  <md-option ng-repeat="eventcat in eventcats" ng-value="eventcat.id">{{eventcat.title}}</md-option>
													</md-optgroup>
												  </md-select>
												  </md-input-container>
												  <md-input-container>
												  <label>Event Type :</label>
												  <md-select ng-model="selectedType" ng-change="getSelectedText()">
													<md-optgroup label="Event Type">
													<md-option value="">All</md-option>
													  <md-option ng-repeat="eventtype in eventtypes" ng-value="eventtype.id">{{eventtype.title}}</md-option>
													</md-optgroup>
												  </md-select>
												</md-input-container>
												<md-input-container>
												  <label>Sort By :</label>
												  <md-select ng-model="selectedDate" ng-change="getSelectedText()">
													<md-optgroup label="Date">
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
                                                <div class="col-lg-12 p-2">
												<div class="table-responsive table-theme-liminal all_eventlist_table">
												<p class="validation-error" ng-bind-html="message"></p>
														<table class="table table-bordered">
															<thead>
																<tr>
																	<th>Event Type Name</th>
																	<th>Event Category</th>
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
																	<td>{{eventlist.cattitle}}</td>
																	<td>{{eventlist.location}}</td>
																	<td>
																		<div class="c-t">
																		
																		
       
		<a href="javascript:void(0)" ng-if="eventlist.go_btn ==1" ng-click="gotocart(eventlist)" class="btn primary-btn">
                                                                Go
                                                            </a>
															<a href="javascript:void(0)" ng-if="eventlist.login_btn ==1" data-toggle="modal" data-target="#loginForm" class="btn primary-btn">
                                                                Login To Attend
                                                            </a>
			
			 <a href="javascript:void(0)" ng-if="eventlist.full_btn ==1" class="btn primary-btn">
                                                               Full
                                                            </a>
			
			
                     <a href="javascript:void(0)" ng-if="eventlist.alreadyregister_btn ==1" class="btn primary-btn">
                                                                Already Register
                                                            </a>
			
																		
																		
																		
																		</div>
																	</td>
																</tr>
																<tr>
																 <td colspan="3" ng-show="eventlists ==''" >Not Found</td>
																</tr>
															</tbody>
														</table>
													</div>
												
													
                                                  
                                                    
                                                     <div class="NxtPreButton">                        
												<button ng-disabled="currentPage == 0" ng-click="currentPage=currentPage-1">
														Previous
													</button>
													{{currentPage+1}}/{{numberOfPages()}}
													<button ng-disabled="currentPage >= eventlists.length/pageSize - 1" ng-click="currentPage=currentPage+1">
														Next
													</button>
													</div>
                                                </div>

                                            </div>	  </div>	

											 <div id="mapview" class="tab-pane fade">
										<div id="map"></div>
									  </div>
											</div>	

											
								
                       
  
                        </div>

                    </div>
                </div>
            </div>
        </section><!-- #services -->

      
    </main>
