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
                            
                             <div id="pane-C" class="card tab-pane fade show active" role="tabpanel" aria-labelledby="tab-C">
                                <header class="section-header text-center">
                                    <h1 class="border-heading text-center">My GROUP</h1>
                                </header>
                                <p class="content text-center">
                                    Groups are one of the best long-term ways to maintain your growth edge.


                                </p>

                              <div class=" d-flex justify-content-center">
                                                <div class="col-lg-12 p-2">
												<div class="table-responsive table-theme-liminal all_eventlist_table">
												
												<p class="validation-error" ng-bind-html="message"></p>
														<table class="table table-bordered">
															<thead>
																<tr>
																	<th>Group Name</th>
																	<th>Group Email</th>
																	<th>Members</th>
																	<th>Community</th>
																	<th>Action</th>
																</tr>
															</thead>
															<tbody>
																<tr ng-repeat="grouplist in grouplists | startFrom:currentPage*pageSize | limitTo:pageSize">
																	<td>
																		<!--<figure class="tb-figure">
																			<img src="<?php //echo base_url(); ?>assets/frontend/img/small-icon.png">
																		</figure>-->
																		<span class="c-t">{{grouplist.group_name}}</span>
																	</td>
																	<td>{{grouplist.group_email}}</td>
																	<td>{{grouplist.members_count}}</td>
																	<td>{{grouplist.title}}</td>
																	<td><div class="c-t"><a href="<?php echo base_url();?>mygroup/send_mail/{{grouplist.encrypted}}" class="btn primary-btn"title="Send Mail"><i class="fa fa-envelope"></i></a></div></td>
																	
																</tr>
																<tr>
																 <td colspan="3" ng-show="grouplists ==''" >Not Found</td>
																</tr>
															</tbody>
														</table>
													</div>
												
													
                                                  
                                                    
                                                     <div class="NxtPreButton">                        
												<button ng-disabled="currentPage == 0" ng-click="currentPage=currentPage-1">
														Previous
													</button>
													{{currentPage+1}}/{{numberOfPages()}}
													<button ng-disabled="currentPage >= grouplists.length/pageSize - 1" ng-click="currentPage=currentPage+1">
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


        <!--==========================
      explore Section
    ============================-->
       
    </main>