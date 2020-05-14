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
                        <div class="col-lg-10">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12 p-0">

                                        <h3 class="mb50 event-heading" ng-show="eventType == 'upcoming'">Upcoming <strong>EVENTS</strong> </h3>
										<h3 class="mb50 event-heading" ng-show="eventType == 'reconnect'">Reconnect <strong>EVENTS</strong> </h3>
                                    </div>
                                    <div class="col-md-12 p-0 input-t-group  input-t-eventlist">
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
							
							<div class=" d-flex justify-content-center">
                                                <div class="col-lg-12 p-0">
												<div class="table-responsive table-theme-liminal profile_event_listing">
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
																		<span class="c-t"><a href="eventdetail/{{eventlist.title ? eventlist.title : eventlist.event_typename | slugify}}-{{eventlist.id}}">{{eventlist.title ? eventlist.title : eventlist.event_typename}}, {{eventlist.start_date | date : 'MM/dd/yyyy'}}</a></span>
																	</td>
																	<td>{{eventlist.cattitle}}</td>
																	<td>{{eventlist.location}}</td>
																	<td>
																	
																		<div class="c-t">
																	<a href="<?php echo base_url().'depositepay/';?>{{eventlist.unique_event_order}}" ng-if="eventlist.is_pay !=0" class="btn primary-btn">Pay</a>
									<a href="<?php echo base_url().'agreements/';?>{{eventlist.title ? eventlist.title : eventlist.event_typename | slugify}}-{{eventlist.id}}/{{eventlist.unique_event_order}}" ng-if="eventlist.is_incomplete == 'agreement'" class="btn primary-btn">More</a>
									<a href="<?php echo base_url().'healthinfo/';?>{{eventlist.title ? eventlist.title : eventlist.event_typename | slugify}}-{{eventlist.id}}/{{eventlist.unique_event_order}}" ng-if="eventlist.is_incomplete == 'healthinfo'" class="btn primary-btn">More</a>
									<a href="<?php echo base_url().'notifications/';?>{{eventlist.title ? eventlist.title : eventlist.event_typename | slugify}}-{{eventlist.id}}/{{eventlist.unique_event_order}}" ng-if="eventlist.is_incomplete == 'notificationinfo'" class="btn primary-btn">More</a>
																		</div>
																	</td>
																</tr>
																<tr>
																 <td colspan="4" ng-show="eventlists ==''" >Not Found</td>
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

                                            </div>		
							
						
  
                        </div>

                    </div>
                </div>
            </div>
        </section><!-- #services -->

      
    </main>
