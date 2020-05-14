    <section id="event-banner" class="clearfix event-banner">

        <img src="<?= base_url();?>assets/frontend/img/intro-bg.jpg" style="height:300px;">
        
    </section><!-- #intro -->

    <main id="main">
<section class="section about-us bg-white" id="about-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading"> 
                        <h3 class="text-center text-bold">{{eventinfo.typenametitle}}</h3>
                        <p class="sub-heading" ng-bind-html="eventinfo.details"></p>
                    </div>
                </div>
            </div>
			<div class="row about-half flex-row-reverse">
  
                <div class="col-md-10 offset-md-1">
                    <div class="about-content about-content-tb">
<table>
                       <tr><th>Community</th><td>{{eventinfo.communitytitle}}</td></tr>
					   <tr><th>Category</th><td>{{eventinfo.cattitle}}</td></tr>
					   <tr><th>Event Type</th><td>{{eventinfo.typetitle}}</td></tr>
					   <tr><th>Event Type Name</th><td>{{eventinfo.typenametitle ? eventinfo.typenametitle : eventinfo.event_typename}}</td></tr>
					   <tr><th>Age Requirement</th><td>{{eventinfo.age_requirement}} years</td></tr>
					   <tr><th>Start Date</th><td>{{eventinfo.start_time | date:'EEEE, MMMM d, y h:mm a'}}</td></tr>
					   <tr><th>End Date</th><td>{{eventinfo.end_time | date:'EEEE, MMMM d, y h:mm a'}}</td></tr>
					   <tr><th>Price</th><td>{{eventinfo.cost ? eventinfo.currency : '' }} {{eventinfo.cost ? eventinfo.cost : "No Cost" }}</td></tr>
					   <tr><th>Minimum Deposit</th><td>{{eventinfo.min_deposit ? eventinfo.currency : ""}} {{eventinfo.min_deposit ? eventinfo.min_deposit : "No Minimum Deposite"}}</td></tr>
					 
					   <tr><th>Location</th><!--<td><a href="https://www.google.com/maps/place/{{ eventinfo.event_map_location}}/{{ eventinfo.lat}},{{ eventinfo.lng}}" target="_blank">{{eventinfo.location}}</a></td>--><td><a href="https://maps.google.com/?q={{eventinfo.location}}" target="_blank">{{eventinfo.location}}</a></td></tr>
</table>					   
                    </div>
                </div>
            </div>
            <div class="row about-half ">
                <div class="col-md-12 col-sm-12">
                    <div class="about-content">
                       <div class="p-2" style="text-align:center;">
					   <p class="validation-error"  ng-bind-html="message"></p>
														<!--<a href="javascript:void(0)" ng-click="gotocart(eventinfo)" class="btn primary-btn">
                                                                Go
                                                            </a>-->
									<a href="javascript:void(0)" ng-if="eventinfo.go_btn ==1" ng-click="gotocart(eventinfo)" class="btn primary-btn"> Go</a>
								<a href="javascript:void(0)" ng-if="eventinfo.login_btn ==1" data-toggle="modal" data-target="#loginForm" class="btn primary-btn">Login To Attend</a>
							<a href="javascript:void(0)" ng-if="eventinfo.full_btn ==1" class="btn primary-btn">Full</a>
							<a href="javascript:void(0)" ng-if="eventinfo.alreadyregister_btn ==1" class="btn primary-btn">Already Register</a>
			

											
                                                            <!--<a href="billing/{{eventinfo.typenametitle | slugify}}-{{eventinfo.id}}" class="btn primary-btn">
                                                                Go
                                                            </a>-->
                                                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row about-half vertical-center">
       
                <div class="col-md-12 col-sm-12">
                    <div class="about-content m-t">
                       
                    </div>
                </div>
            </div>
        </div>

    </section>
    </main>