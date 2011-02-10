<?php if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point'); ?>
<div id="loginCtn" class="pageDesign">
    <div class="pagePadding">
<form action="index.php?module=Users&action=authenticate" method="POST">
            <!-- RL Logo -->
            <div class="loginLogo"></div>
      
            <!-- Error Message -->
            
        <?php
            if ($_REQUEST['err'] == 1){
                echo
                '<div class="errorMsg mTop15">' .
                    $_SESSION["login_error"] .
                '</div>';
            }else if ($_REQUEST['sessiontimeout'] == 1) {
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

            <!-- Register / Forgot Password -->
            <div class="mTop15 smallFont forgotpassword">
                <a href="index.php?module=registration&action=registration">register</a> |
                <a href="#">forgot password</a>
            </div>

            <!-- Login Bottom -->
            <div class="login-bottom">
                <span class="mediumFont">Login for customer service</span>
                <input type="submit" value="Login" name="submit" class="submit loginsubmit" />
            </div>
</form>
    </div>
</div>