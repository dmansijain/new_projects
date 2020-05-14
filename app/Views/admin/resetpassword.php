<div class="col-md-7 col-sm-7 loginimg">
            <h1>S<span>oo</span>H<span>oo</span></h1>
        </div>
        <div class="col-md-5 col-sm-5 login-section reset-pasword">
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
                            <input type="text" ng-model="logininfo.email" name="email" placeholder="Username" />
                        </div>
                        <div class="form-field">
                        <input type="submit" name="submit" value="Send" />
                        </div>
                    </form> 
                </div>
            </div>
        </div>