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

                    <div class="row justify-content-center goth" >
				<?php	echo view('frontend/profilenavigation'); ?>
                      
                        <div id="content" class="tab-content" role="tablist">
                            <div id="pane-A" class="card tab-pane fade show active" role="tabpanel" aria-labelledby="tab-A">
                                <div class="card-header" role="tab" id="heading-A">
                                    <h5 class="mb-0">
                                        <a class="" data-toggle="collapse" href="#collapse-A" data-parent="#content" aria-expanded="true" aria-controls="collapse-A">

                                            Profile

                                        </a>
                                    </h5>
                                </div>
                                <div id="collapse-A" class="collapse show" role="tabpanel" aria-labelledby="heading-A">
                                    <div class="card-body ">
                                        <form enctype="multipart/form-data" ng-submit="editprofile()">
                                            <div class="row flex-row-reverse">
                                                <div class="col-md-4">
                                                    <div class="user-profile-btn">
												    <span class="btn-user-file"><span class="upload-text">Upload Image</span><input type="file" ng-model="profilepic" ng-file="profilepic" name="profileinfo.profilepic" value="profileinfo.profilepic" onChange="showPreview(this);"  /></span>
                                                    <div class="profile-img text-right">
													
                                                       <span class="logo_BoX" id="targetLayer"> <img src='<?= base_url();?>/uploads/profilepic/{{profileinfo.profilepic}}'></span>
                                                    </div>
</div>
                                                </div>
                                                <div class="col-md-8">
                                                    <header class="section-header">
                                                        <h1 class="border-heading text-left ml-0">ME</h1>               
                                                    </header>
                                                    <div class="form-group">
                                                        <label for="self">Tell us about yourself
                                                        </label>
                                                        <textarea class="form-control" ng-model="profileinfo.bio"></textarea>
                                                    </div>
              
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="self">First Name
                                                        </label>
                                                        <input type="text" ng-model="profileinfo.first_name" class="form-control" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="self">Last Name
                                                        </label>
                                                        <input type="text" ng-model="profileinfo.last_name" class="form-control" />
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="self">Phone No
                                                        </label>
                                                        <input type="number" ng-model="profileinfo.phone" class="form-control" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="self">Email
                                                        </label>
                                                        <input disabled type="email" ng-model="profileinfo.email" class="form-control" />
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="self">Address
                                                        </label>
                                                        <input type="text" ng-model="profileinfo.address" class="form-control" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="self">City
                                                        </label>
                                                        <input type="text" ng-model="profileinfo.city" class="form-control" />
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group"> 
                                                        <label for="self">State
                                                        </label>
                                                        <input type="text" ng-model="profileinfo.state" class="form-control" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="self">Zip
                                                        </label>
                                                        <input type="text" ng-model="profileinfo.zip" class="form-control" />
                                                    </div>

                                                </div>
                                            </div>
											<div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group clearfix"> 
                                                      <div ng-show="message !=''"  ng-bind-html="message">{{message}}</div> 
                                                        <input class="save_btn btn primary-btn" type="submit" value="Submit" />
														<a href="myprofile/changepassword" class="change-password-link"><i class="fa fa-key" aria-hidden="true"></i> Change Password</a>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                            
                            
                        </div>
                    </div>


                </div>
            </div>
        </section><!-- #services -->



    </main>