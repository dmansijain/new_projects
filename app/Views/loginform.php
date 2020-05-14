<div id="login" class="login loginpage col-lg-offset-4 col-md-offset-3 col-sm-offset-3 col-xs-offset-0 col-xs-12 col-sm-6 col-lg-4">
            <h1><a href="#" title="Login Page" tabindex="-1"></a></h1>
<div ng-show="message !=''"  ng-bind-html="message">{{message}}</div>
            <form name="loginform" id="loginform" ng-submit="validatelogin()" method="post">
                <p>
                    <label for="user_login">Username<br />
					<input type="text" ng-model="logininfo.username" value="<?php if(get_cookie('remember_user',TRUE)!=null) {echo $this->input->cookie('remember_user',TRUE);}?>" name="username" class="input" placeholder="Username" />
                        </label>
                </p>
                <p>
                    <label for="user_pass">Password<br />
					<input type="password" value="<?php if(get_cookie('remember_password',TRUE)!=null) {echo $this->input->cookie('remember_password',TRUE);}?>" ng-model="logininfo.password" name="password" class="input" placeholder="Password" />
                        </label>
                </p>
                <p class="forgetmenot">
                    <label class="icheck-label form-label" for="rememberme"><input name="rememberme" type="checkbox" id="rememberme" password="remember" class="icheck-minimal-aero" checked> Remember me</label>
                </p>



                <p class="submit">
                    <input type="submit" name="wp-submit" id="wp-submit" class="btn btn-accent btn-block" value="Login" />
                </p>
            </form>

            <p id="nav">
                <a class="pull-left" href="#!/reset-password/" title="Password Lost and Found">Forgot password?</a>
                
            </p>


        </div>