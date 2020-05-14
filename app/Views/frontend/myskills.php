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
											<h1 class="border-heading text-left ml-0">My skills</h1>               
										</header>
                                    </div>
                                    
                                </div>
                            </div>
							
							<div class="event-list upcomimg-event-media-o" ng-repeat="skill in skills | startFrom:currentPage*pageSize | limitTo:pageSize">
                                <div class="media">
									<div class="media-left-ic align-self-center">
										<img src="<?php echo base_url(); ?>assets/frontend/img/small-icon.png" style="width:60px">
									</div>
									<div class="media-body">
										 <h4>{{skill.name}}</h4>
										
										
									</div>
									<p class="text-right mt-3">
									<span class="badge skill_counting">{{skill.skill_count}}</span>
									</p>
								</div>
                            </div>
							 <div class="nt-fount-msg" ng-show="skills ==''" >Not Found</div>
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
            
     
        </section><!-- #services -->
       


   
    </main>