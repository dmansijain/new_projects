
        <div id="login" class="login loginpage col-lg-offset-4 col-md-offset-3 col-sm-offset-3 col-xs-offset-0 col-xs-12 col-sm-6 col-lg-4">
		<h1><a href="#" title="Login Page" tabindex="-1"></a></h1>
<div ng-show="message !=''"  ng-bind-html="message">{{message}}</div>
            <div class="login-dtl">
        		<a href="#!/" class="back"><i class="flaticon-left-arrow"></i></a>
                <div class="clearfix"></div>
                <h2>Reset password</h2>
                <p>Lost your password? Please enter your email address. You will receive a link to create a new password via email.</p>
                <div class="login-frm reset-password-form">
				<div ng-show="message !=''"  ng-bind-html="message">{{message}}</div>
                    <form name="loginform" ng-submit="resetpassword()">
                        <div class="form-field">
                            <label>Email Id</label>
                            <input type="text" ng-model="logininfo.email" name="email" placeholder="Email" />
                        </div>
                        <div class="form-field">
                        <input type="submit" name="submit" class="btn btn-accent btn-block" value="Send" />
                        </div>
                    </form> 
                </div>
            </div>
        </div>