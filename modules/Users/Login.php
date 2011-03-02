<?php if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point'); ?>
<div id="loginCtn" class="pageDesign">
    <div class="pagePadding">
		<form action="index.php?module=Users&action=authenticate" method="POST">
            <!-- RL Logo -->
            <div class="loginLogo"></div>
      
            <!-- Error Message -->
            
        <?php
            if ($_REQUEST['err'] == 1){
                if (!empty($_SESSION["login_error"])) {
                echo
                '<div class="errorMsg mTop15">' .
                    $_SESSION["login_error"] .
                '</div>';
                }
            }else if ($_REQUEST['sessiontimeout'] == 1) {
                if (!empty($_SESSION["login_error"])) {
                echo
                '<div class="errorMsg mTop15">' .
                    $_SESSION["login_error"] .
                '</div>';
                }
            }else if (!empty($_SESSION["login_error"])) {
                echo
                '<div class="errorMsg mTop15">' .
                    $_SESSION["login_error"] .
                '</div>';
            }
        ?>
            

            <!-- Login Input -->
            <div class="mTop15 loginInput">
                <label class="left">User Name</label>
                <input name="user_name" type="text" id="user_name" value="" class="right"/>
            </div>
            <div class="mTop15 loginInput">
                <label class="left">Password</label>
                <input type="password" name="password" value="" id="password" class="right"/>
            </div>
            <!-- Login Bottom -->
            <div class="login-bottom">
                <span class="mediumFont">Login for customer service</span>
                <input type="submit" value="Login" name="submit" class="submit loginsubmit" />
            </div>
		</form>
        
        <!-- Register / Forgot Password -->
        <form action="index.php?module=Users&action=forgot_password" method="POST" id="forgot_password">
            <div class="mTop15 forgotpassword">
                <a href="index.php?module=registration&action=registration" class="smallFont">register</a> |
                <a href="#" class="forgotLink smallFont">forgot password</a>
                <!-- hide -->
                <div class="forgotP">
                    <!--
                    <div class="mTop15 loginInput">
                        <label class="left">Username</label>
                        <input name="lost_username" type="text" id="user_name" value="" class="right"/>
                    </div>-->
                    <div class="mTop15">
                        <label class="left mediumFont">Email Address</label>
                        <br />
                        <input type="text" name="lost_email" value="" id="user_name" style="width:320px;"/>
                    </div>
                    <div class="login-bottom">
                        <input type="submit" value="Submit" name="submit" class="submit loginsubmit" />
                    </div>
            	</div>
            </div>
		</form>
    </div>
</div>