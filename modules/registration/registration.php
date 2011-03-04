<?php if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point'); ?>
<div id="regCtn" class="pageDesign">
    <div class="pagePadding">
        <div class="loginLogo"></div>
        <div class="err"></div>
        <form action="index.php?module=registration&action=submit" method="POST" id="regForm">

            <!-- Reg Input Left -->
            <div class="regInput mTop15">
                <div class="mTop15">
                    <label>First Name</label>
                    <input name="first_name" type="text" id="title7" value="" tabindex="1" class="required" />
                </div>
                <div class="mTop15">
                    <label>Last Name</label>
                    <input name="last_name" type="text" id="title" value="" tabindex="2" class="required" />
                </div>
                <div class="mTop15">
                    <label>Email Address / Username</label>
                    <input name="email" type="text" id="title" value="" tabindex="3" class="required" />
                </div>
                <div class="mTop15">
                    <label>Email Opt Out: </label>
                    <input type='checkbox' class='checkbox' name='email_opt_out' size='' value='1' tabindex="4" />
                </div>
                <div class="mTop15">
                    <label>Password</label>
                    <input id="password" name="password" type="password" value="" class="required" tabindex="5" />
                </div>
                <div class="mTop15">
                    <label>Password Confirm</label>
                    <input name="password_confirm" type="password" value="" tabindex="6" class="required" />
                </div>
            </div>
            <!-- Reg Bottom -->
            <div class="reg-bottom">
				<input type="submit" value="Register" name="submit" class="submit regsubmit" />
                <span class="mediumFont">Already a member? <a href="index.php?module=Users&action=Login">Login Here</a></span>
            </div>
            <div class="mTop15">
            	
            </div>
        </form>
    </div>
</div>