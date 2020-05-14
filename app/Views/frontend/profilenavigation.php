<ul id="tabs" class="nav nav-tabs" role="tablist" ng-controller="navCtrl">
                            <li class="nav-item">
                                <a href="myprofile" class="nav-link " ng-class="{active: $route.current.activetab == 'myprofile'}" data-toggle="tab" role="tab">Profile</a>
                            </li>
							<li class="nav-item">
                                <a href="myprofile/skills" class="nav-link " ng-class="{active: $route.current.activetab == 'myskills'}" data-toggle="tab" role="tab">My Skills</a>
                            </li>
							<li class="nav-item">
                                <a href="myprofile/event" class="nav-link " ng-class="{active: $route.current.activetab == 'myevent'}" data-toggle="tab" role="tab">My Event</a>
                            </li>
							<li class="nav-item">
                                <a href="myprofile/healthinfo" class="nav-link " ng-class="{active: $route.current.activetab == 'myhealthinfo'}" data-toggle="tab" role="tab">My Healthinfo</a>
                            </li>
                            <li class="nav-item">
                                <a href="myprofile/journey" class="nav-link" ng-class="{active: $route.current.activetab == 'myjourney'}" data-toggle="tab" role="tab">My Past Events</a>
                            </li>
							<li class="nav-item">
                                <a href="myprofile/rewards" class="nav-link" ng-class="{active: $route.current.activetab == 'myrewards'}" data-toggle="tab" role="tab">My Rewards</a>
                            </li>
                            <li class="nav-item">
                                <a href="myprofile/group" class="nav-link" ng-class="{active: $route.current.activetab == 'mygroup'}" data-toggle="tab" role="tab">My Group</a>
                            </li>
                            <li class="nav-item">
                                <a href="myprofile/results" class="nav-link" ng-class="{active: $route.current.activetab == 'myresults'}" data-toggle="tab" role="tab"> Heart, Soul, Mind, Strength</a>
                            </li>
                            <!-- 
                            <li class="nav-item">
                                <a id="tab-C" href="#pane-C" class="nav-link" data-toggle="tab" role="tab">About Me</a>
                            </li>
-->
                        </ul>