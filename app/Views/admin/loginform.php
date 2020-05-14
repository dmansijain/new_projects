<div class="col-md-7 col-sm-7 loginimg">
            <h1>LIMINAL</h1>
        </div>
        <div class="col-md-5 col-sm-5 login-section">
            <div class="login-dtl">
            	<h1>LIMINAL</h1>
                <h2>Log into Your Account</h2>
                <div class="login-frm">
				<div ng-show="message !=''"  ng-bind-html="message">{{message}}</div>
							<div class="clr"></div>
                    <form name="loginform" ng-submit="validatelogin()"  id="signupform">
                        <div class="form-field">
                            <label>Email Id</label>
                            <input type="text" ng-model="logininfo.username" value="<?php if(get_cookie('remember_user',TRUE)!=null) {echo $this->input->cookie('remember_user',TRUE);}?>" name="username" placeholder="Username" />
                        </div>
                        <div class="form-field">
                            <label>Password</label>
                            <input type="password" value="<?php if(get_cookie('remember_password',TRUE)!=null) {echo $this->input->cookie('remember_password',TRUE);}?>" ng-model="logininfo.password" name="password" placeholder="Password" />
                        </div>
                        <div class="terms-check">
                            <label>Remember Me
                              <input type="checkbox" ng-model="logininfo.rememberme">
                              <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="form-field">
                        <input type="submit"  value="Login" />
                        </div>
                    </form>
                    <a href="#!/reset-password/">Reset Password</a>
                </div>
            </div>
        </div>
    