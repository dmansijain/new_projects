<section id="main-content" class=" ">
    <section class="wrapper main-wrapper row" style=''>
			<div class="row">
						<div class="col-md-12">
							<div class="pg_title"><h2>Payment Plan Settings</h2></div>
						</div>
					</div>
			<div class="row">
				<!--<div class="TabNavWrapper">																	
					<nav class="nav nav-tab">
						<ul>						
							<li class="active"><a data-target="#teamsProfile" data-toggle="tab"><i class="fa fa-cog"></i>Web Settings</a></li>							
							<li ng-show="message !=''" >{{message}}</li>
							<div class="clr"></div>
							
						</ul>
					</nav> 
				</div>-->
				<div class=""> 
					<div id="teamsProfile" class="item tab-pane fade in active">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<form name="editform" enctype="multipart/form-data" ng-submit="editpaymentsettings()"  id="signupform" class="team_Form">
					    <p>{{message}}</p>
						<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<label>Time period</label>
							<select class="form-control" ng-model="settingsinfo.time_period" ng-options="y for (x, y) in timeperiods" name="time_period">
							</select>
						</div>
						</div>
						<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<label>Payment divided into</label>
							<input class="form-control" ng-model="settingsinfo.payment_division" name="payment_division" type="number" value="{{settingsinfo.payment_division}}"/>
						</div>
						</div>
						<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="save_btn_Wrapper">
							<input class="save_btn" type="submit" value="Submit" />
							</div>
						</div> </div>
					</form>
				</div>
					</div>
					
					
				</div>	
			</div>
		</section>
	</section>
  <!-- container section start -->