<!--==========================
    Intro Section
  ============================-->
    <section id="intro" class="clearfix">
        <div class="container h-100">
            <div class="row ">
                <div class="col-md-12 order-md-first order-last">
                    <header class="section-header">
                        <h1 class="border-heading text-center">PROFILE</h1>
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
                <div class="row justify-content-center goth">
				 <?php	echo view('frontend/profilenavigation'); ?>
                    <div class="col-md-12 d-flex justify-content-center updated-block-n p-0">
                        <div class="col-lg-12">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-8 pl-0">
										<header class="section-header">
											<h1 class="border-heading text-left ml-0">UPCOMING EVENTS</h1>               
										</header>
                                    </div>
                                    <div class="col-md-4 pr-0 justify-content-end d-flex" ng-show="eventlists !=''">

                                        <div class="view_btn">
                                            <a href="<?php echo base_url('myprofile/eventlist/upcoming'); ?>" class="btn primary-btn1">
                                               View More
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
							
							
                            <div class="event-list upcomimg-event-media-o" ng-repeat="eventlist in eventlists | startFrom:currentPage*pageSize | limitTo:pageSize">
                                <div class="media">
									<div class="media-left-ic align-self-center">
										<img src="<?php echo base_url(); ?>assets/frontend/img/small-icon.png" style="width:60px">
									</div>
									<div class="media-body">
										 <a href="eventdetail/{{eventlist.title ? eventlist.title : eventlist.event_typename | slugify}}-{{eventlist.id}}"><h4>{{eventlist.title ? eventlist.title : eventlist.event_typename}}</h4></a>
										<p class="location-c"><i class="fa fa-map-marker" aria-hidden="true"></i> {{eventlist.location}}</p>
										<p class="location-date"><i class="fa fa-calendar" aria-hidden="true"></i> {{eventlist.start_date | date : 'MM/dd/yyyy'}}</p>
										
									</div>
									<p class="text-right mt-3"><a href="<?php echo base_url().'depositepay/';?>{{eventlist.unique_event_order}}" ng-if="eventlist.is_pay !=0" class="btn primary-btn">Pay</a>
									<a href="<?php echo base_url().'agreements/';?>{{eventlist.title ? eventlist.title : eventlist.event_typename | slugify}}-{{eventlist.id}}/{{eventlist.unique_event_order}}" ng-if="eventlist.is_incomplete == 'agreement'" class="btn primary-btn">More</a>
									<a href="<?php echo base_url().'healthinfo/';?>{{eventlist.title ? eventlist.title : eventlist.event_typename | slugify}}-{{eventlist.id}}/{{eventlist.unique_event_order}}" ng-if="eventlist.is_incomplete == 'healthinfo'" class="btn primary-btn">More</a>
									<a href="<?php echo base_url().'notifications/';?>{{eventlist.title ? eventlist.title : eventlist.event_typename | slugify}}-{{eventlist.id}}/{{eventlist.unique_event_order}}" ng-if="eventlist.is_incomplete == 'notificationinfo'" class="btn primary-btn">More</a>
									</p>
								</div>
                            </div>
							 <div class="nt-fount-msg" ng-show="eventlists ==''" >Not Found</div>
						</div>
                    </div>
                </div> 
				</div>
            </div>
            
            
            <div class="container mt-5">
			<div class="w-80">
                <div class="row justify-content-center goth">
                    <div class="col-md-12 d-flex justify-content-center updated-block-n p-0">
                        <div class="col-lg-12">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-8 pl-0">
										<header class="section-header">
											<h1 class="border-heading text-left ml-0">TRAINING & STAFFING</h1>               
										</header>
                                    </div>
                                    <div class="col-md-4 pr-0 justify-content-end d-flex" ng-show="skillsevents !=''">

                                        <div class="view_btn">
                                            <a href="<?php echo base_url('myprofile/eventlist/skills'); ?>" class="btn primary-btn1">
                                               View More
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
							
							
                            <div class="event-list upcomimg-event-media-o" ng-repeat="skilleventlist in skillsevents | startFrom:skillscurrentPage*skillspageSize | limitTo:skillspageSize">
                                <div class="media">
									<div class="media-left-ic align-self-center">
										<img src="<?php echo base_url(); ?>assets/frontend/img/small-icon.png" style="width:60px">
									</div>
									<div class="media-body">
										<a href="eventdetail/{{skilleventlist.title ? skilleventlist.title : skilleventlist.event_typename | slugify}}-{{skilleventlist.id}}"><h4>{{skilleventlist.title ? skilleventlist.title : skilleventlist.event_typename}}</h4></a>
										<p class="location-c"><i class="fa fa-map-marker" aria-hidden="true"></i> {{skilleventlist.location}}</p>
										<p class="location-date"><i class="fa fa-calendar" aria-hidden="true"></i> {{skilleventlist.start_date | date : 'MM/dd/yyyy'}}</p>
									</div>
								</div>
                            </div>
							<div class="nt-fount-msg" ng-show="skillsevents ==''" >Not Found</div>
							

                        </div>

                    </div>
                </div> </div>
            </div>
            
            
            <div class="container mt-5">
			<div class="w-80">
                <div class="row justify-content-center goth">
                    <div class="col-md-12 d-flex justify-content-center updated-block-n p-0">
                        <div class="col-lg-12">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-8 pl-0">
										<header class="section-header">
											<h1 class="border-heading text-left ml-0">RECONNECT</h1>               
										</header>
                                    </div>
                                    <div class="col-md-4 pr-0 justify-content-end d-flex" ng-show="reconnectevents !=''">

                                        <div class="view_btn">
                                            <a href="<?php echo base_url('myprofile/eventlist/reconnect'); ?>" class="btn primary-btn1">
                                               View More
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
							
							
                            <div class="event-list upcomimg-event-media-o" ng-repeat="reconnect in reconnectevents | startFrom:reconnectcurrentPage*reconnectpageSize | limitTo:reconnectpageSize">
                                <div class="media">
									<div class="media-left-ic align-self-center">
										<img src="<?php echo base_url(); ?>assets/frontend/img/small-icon.png" style="width:60px">
									</div>
									<div class="media-body">
										<a href="eventdetail/{{reconnect.title ? reconnect.title : reconnect.event_typename | slugify}}-{{reconnect.id}}"><h4>{{reconnect.title ? reconnect.title : reconnect.event_typename}}</h4></a>
										<p class="location-c"><i class="fa fa-map-marker" aria-hidden="true"></i> {{reconnect.location}}</p>
										<p class="location-date"><i class="fa fa-calendar" aria-hidden="true"></i> {{reconnect.start_date | date : 'MM/dd/yyyy'}}</p>
									</div>
								</div>
                            </div>
							<p class="nt-fount-msg" ng-show="reconnectevents ==''" >Not Found</p>
							
						 </div>

                    </div>
                </div> </div>
            </div>
        </section><!-- #services -->
       


  
    </main>