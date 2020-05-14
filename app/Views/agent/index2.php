<!doctype html>
<html lang="en-US" ng-app="SoohooAdmins">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Soohoo</title>
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>assets/css/flaticon.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>assets/css/bootstrap-slider.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery.mCustomScrollbar.min.css">
    <link href="<?php echo base_url(); ?>assets/css/stylesheet.css" rel="stylesheet" type="text/css">
	<script src = "https://code.jquery.com/jquery-2.2.4.min.js"></script>
		<script src = "<?php echo base_url(); ?>assets/angular-1.6.9/angular.min.js"></script>
		<script src = "<?php echo base_url(); ?>assets/angular-1.6.9/angular-route.min.js"></script>
		<script src = "<?php echo base_url(); ?>assets/angular-1.6.9/angular-animate.min.js"></script>
		<script src = "<?php echo base_url(); ?>assets/angular-1.6.9/angular-loader.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/angular-1.6.9/angular-sanitize.js"></script>	
		<script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/0.10.0/ui-bootstrap-tpls.min.js"></script>
		<script src = "https://cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/2.0.0/ui-bootstrap-tpls.min.js"></script>
		<script src = "https://cdnjs.cloudflare.com/ajax/libs/angular-ui-utils/0.1.1/angular-ui-utils.min.js"></script>
		<script src = "https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/js/jquery.dataTables.min.js"></script>
		<script src = "https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
        <script data-require="jquery@1.10.1" data-semver="1.10.1" src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
        <script src="//cdn.datatables.net/1.10.1/js/jquery.dataTables.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/q.js/0.9.2/q.js"></script>
        
        <script src="https://rawgithub.com/l-lin/angular-datatables/v0.6.1/dist/angular-datatables.js"></script>
        <script src="<?php echo base_url(); ?>assets/angular/appAdmin.js"></script>
        <script src="<?php echo base_url(); ?>assets/angular/controllersAdmin.js"></script>
<script>
			var BASE_URL = '<?php echo base_url(); ?>'; 
			var TOKEN = 'xZZAvva+sJzW5VJ92BhTobC7NwLdW85j9Stj3UcxKbZqeaFSoSWI10X8Fmmw5fOINqu5pWm25dcZtnko6zdI7GEN+BSjQIU3Aa5RoAMJpaiB8M8JQgWBfxuq7zGsw+ouTfv+gxRboaOxRhkG737fkA '; 
		</script>
</head>


<body>
    <div class="main-page">
        <div class="sidenav">
            <div class="logo"><a href="availability.html">Job Admin</a></div>
            <button class="toggle-nv">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <ul class="nav tabs-left">
                <!--			<li><a href="job.html">Jobs</a></li>-->
                <li class="active"><a href="availability.html">Availability</a></li>
                <li><a href="appontments.html">Appointments</a></li>
                <li><a href="dispatch.html">Dispatch</a></li>
                <li><a href="past-dues.html">Past Dues</a></li>
            </ul>
        </div>
        <div class="main_cont">
            <div class="header">
                <div class="profile-side">
                    <ul>
                        <li><i class="flaticon-notification"></i><span>5</span></li>
                        <li class="profile-pic">
                            <div>John</div>
                            <figure> <img src="images/profile-pic.jpg"> </figure>
                        </li>
                    </ul>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="body_cont">
                <div class="body-part">
                    <h1>Availability</h1>
                    <a class="createnew top15" href="javascript:void(0);" data-toggle="modal" data-target="">Check Availability</a>
                    <div class="table-notab">
                        <div class="table-style floatThead-wrapper">
                            <table id="loads-in-transit" class="table table-striped table-bordered floatThead-table">
                                <thead>
                                    <tr>
                                        <th>Job Id</th>
                                        <th>Container</th>
                                        <th>Status</th>
                                        <th>Terminal</th>
                                        <th>ETA </th>
                                        <th>LFD </th>
                                        <th>Book Appointment</th>
                                        <th>Notes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                    <tr>
                                        <td>13</td>
                                        <td>761AVD</td>
                                        <td>
                                            <ul class="text-left w-50">
                                                <li>off the vessel <i class="fa fa-check-square-o" aria-hidden="true"></i></li>
                                                <li>Customs <i class="fa fa-check-square-o" aria-hidden="true"></i></li>
                                                <li>Freight</li>
                                                <li>TMF</li>
                                            </ul>
                                        </td>
                                        <td><span class="width-100">Community Centre, 37/1, Industrial Area Phase I, Naraina, New Delhi, Delhi 110028</span></td>
                                        <td>22/04/2019 5:30pm</td>
                                        <td>5/05/2019</td>
                                        <td><a class="tbl-btn" href="#">Book Now</a></td>
                                        <td><span class="width-100">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</span></td>
                                    </tr>
                                    <tr>
                                        <td>16</td>
                                        <td>761A34</td>
                                        <td>
                                            <ul class="text-left w-50">
                                                <li>off the vessel <i class="fa fa-check-square-o" aria-hidden="true"></i></li>
                                                <li>Customs <i class="fa fa-check-square-o" aria-hidden="true"></i></li>
                                                <li>Freight <i class="fa fa-check-square-o" aria-hidden="true"></i></li>
                                                <li>TMF</li>
                                            </ul>
                                        </td>
                                        <td><span class="width-100">Community Centre, 37/1, Industrial Area Phase I, Naraina, New Delhi, Delhi 110028</span></td>
                                        <td>22/04/2019 5:30pm</td>
                                        <td>7/05/2019</td>
                                        <td><a class="tbl-btn" href="#">Book Now</a></td>
                                        <td><span class="width-100">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</span></td>
                                    </tr>
                                    <tr>
                                        <td>13</td>
                                        <td>761AVD</td>
                                        <td>
                                            <ul class="text-left w-50">
                                                <li>off the vessel <i class="fa fa-check-square-o" aria-hidden="true"></i></li>
                                                <li>Customs <i class="fa fa-check-square-o" aria-hidden="true"></i></li>
                                                <li>Freight</li>
                                                <li>TMF</li>
                                            </ul>
                                        </td>
                                        <td><span class="width-100">Community Centre, 37/1, Industrial Area Phase I, Naraina, New Delhi, Delhi 110028</span></td>
                                        <td>22/04/2019 5:30pm</td>
                                        <td>5/05/2019</td>
                                        <td><a class="tbl-btn" href="#">Book Now</a></td>
                                        <td><span class="width-100">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</span></td>
                                    </tr>
                                    <tr>
                                        <td>13</td>
                                        <td>761AVD</td>
                                        <td>
                                            <ul class="text-left w-50">
                                                <li>off the vessel <i class="fa fa-check-square-o" aria-hidden="true"></i></li>
                                                <li>Customs <i class="fa fa-check-square-o" aria-hidden="true"></i></li>
                                                <li>Freight</li>
                                                <li>TMF</li>
                                            </ul>
                                        </td>
                                        <td><span class="width-100">Community Centre, 37/1, Industrial Area Phase I, Naraina, New Delhi, Delhi 110028</span></td>
                                        <td>22/04/2019 5:30pm</td>
                                        <td>5/05/2019</td>
                                        <td><a class="tbl-btn" href="#">Book Now</a></td>
                                        <td><span class="width-100">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</span></td>
                                    </tr>
                                    <tr>
                                        <td>13</td>
                                        <td>761AVD</td>
                                        <td>
                                            <ul class="text-left w-50">
                                                <li>off the vessel <i class="fa fa-check-square-o" aria-hidden="true"></i></li>
                                                <li>Customs <i class="fa fa-check-square-o" aria-hidden="true"></i></li>
                                                <li>Freight</li>
                                                <li>TMF</li>
                                            </ul>
                                        </td>
                                        <td><span class="width-100">Community Centre, 37/1, Industrial Area Phase I, Naraina, New Delhi, Delhi 110028</span></td>
                                        <td>22/04/2019 5:30pm</td>
                                        <td>5/05/2019</td>
                                        <td><a class="tbl-btn" href="#">Book Now</a></td>
                                        <td><span class="width-100">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</span></td>
                                    </tr>
                                    <tr>
                                        <td>13</td>
                                        <td>761AVD</td>
                                        <td>
                                            <ul class="text-left w-50">
                                                <li>off the vessel <i class="fa fa-check-square-o" aria-hidden="true"></i></li>
                                                <li>Customs <i class="fa fa-check-square-o" aria-hidden="true"></i></li>
                                                <li>Freight</li>
                                                <li>TMF</li>
                                            </ul>
                                        </td>
                                        <td><span class="width-100">Community Centre, 37/1, Industrial Area Phase I, Naraina, New Delhi, Delhi 110028</span></td>
                                        <td>22/04/2019 5:30pm</td>
                                        <td>5/05/2019</td>
                                        <td><a class="tbl-btn" href="#">Book Now</a></td>
                                        <td><span class="width-100">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</span></td>
                                    </tr>
                                    <tr>
                                        <td>13</td>
                                        <td>761AVD</td>
                                        <td>
                                            <ul class="text-left w-50">
                                                <li>off the vessel <i class="fa fa-check-square-o" aria-hidden="true"></i></li>
                                                <li>Customs <i class="fa fa-check-square-o" aria-hidden="true"></i></li>
                                                <li>Freight</li>
                                                <li>TMF</li>
                                            </ul>
                                        </td>
                                        <td><span class="width-100">Community Centre, 37/1, Industrial Area Phase I, Naraina, New Delhi, Delhi 110028</span></td>
                                        <td>22/04/2019 5:30pm</td>
                                        <td>5/05/2019</td>
                                        <td><a class="tbl-btn" href="#">Book Now</a></td>
                                        <td><span class="width-100">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</span></td>
                                    </tr>
                                    <tr>
                                        <td>13</td>
                                        <td>761AVD</td>
                                        <td>
                                            <ul class="text-left w-50">
                                                <li>off the vessel <i class="fa fa-check-square-o" aria-hidden="true"></i></li>
                                                <li>Customs <i class="fa fa-check-square-o" aria-hidden="true"></i></li>
                                                <li>Freight</li>
                                                <li>TMF</li>
                                            </ul>
                                        </td>
                                        <td><span class="width-100">Community Centre, 37/1, Industrial Area Phase I, Naraina, New Delhi, Delhi 110028</span></td>
                                        <td>22/04/2019 5:30pm</td>
                                        <td>5/05/2019</td>
                                        <td><a class="tbl-btn" href="#">Book Now</a></td>
                                        <td><span class="width-100">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</span></td>
                                    </tr>

                                    <!--
                                     <tr>
                                        <td>13</td>
                                        <td>761AVD</td>
                                        <td><span class="width-100">Community Centre, 37/1, Industrial Area Phase I, Naraina, New Delhi, Delhi 110028</span></td>
                                        <td>22/04/2019 5:30pm</td>
                                        <td><a class="tbl-btn" href="#">Book Now</a></td>
                                    </tr>
-->



                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <!-- Set Reminder -->
    <div id="Setreminder" class="modal fade modal-custom" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Set Reminder</h4>
                </div>
                <div class="modal-body">
                    <div class="reminder-form">
                        <form method="post" action="">
                            <input type="text" name="reminder" id="reminder" placeholder="Click To Set Reminder" />
                            <input type="submit" value="Submit reminder" name="submit" />
                        </form>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo base_url(); ?>assets/js/jquery-2.2.4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/dataTables.bootstrap.min.js"></script>
    <script type='text/javascript' src="<?php echo base_url(); ?>assets/js/bootstrap-slider.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/custom.js"></script>
    
    <script>
//        
//        $(document).ready(function() {
//            var table = $('#loads-in-transit').DataTable({
//                fixedHeader: true
//            });
//        });

    </script>
</body>

</html>
