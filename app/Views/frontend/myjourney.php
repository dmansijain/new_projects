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
        <section id="profile-tab" class="section section-bg tab-design">

            <div class="container">
                <div class="w-80">

                    <div class="row justify-content-center goth">
                       <?php	echo view('frontend/profilenavigation'); ?>


                        <div id="content" class="tab-content" role="tablist">
                            
                            <div id="pane-B" class="card tab-pane fade show active" role="tabpanel" aria-labelledby="tab-B">
                                <header class="section-header text-center">
                                    <h1 class="border-heading text-center">MY JOURNEY</h1>
                                </header>


                                <p class="content text-center">
                                    Unlock skills as you do more work and gain access to new growth opportunities. Here are the skills you’ve earned so far:

                                </p>
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
																	
																</tr>
															</thead>
															<tbody>
																<tr ng-repeat="eventlist in eventlists | startFrom:currentPage*pageSize | limitTo:pageSize">
																	<td>
																		<figure class="tb-figure">
																			<img src="<?php echo base_url(); ?>assets/frontend/img/small-icon.png">
																		</figure>
																		<span class="c-t"><a href="eventdetail/{{eventlist.typenametitle ? eventlist.typenametitle : eventlist.event_typename | slugify}}-{{eventlist.id}}">{{eventlist.typenametitle ? eventlist.typenametitle : eventlist.event_typename}}, {{eventlist.start_date | date : 'MM/dd/yyyy'}}</a></span>
																	</td>
																	<td>{{eventlist.cattitle}}</td>
																	<td>{{eventlist.location}}</td>
																	
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

                                            </div>

                            </div>
                            
                            
                        </div>
                    </div>


                </div>
            </div>
        </section><!-- #services -->


     
    </main>