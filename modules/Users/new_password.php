<?php if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
if (!empty($_REQUEST['id'])||!empty($_REQUEST['p'])||!empty($_REQUEST['u'])){
?>
<div id="loginCtn" class="pageDesign">
    <div class="pagePadding">
		<form action="index.php?module=Users&action=authenticate" method="POST">
            <!-- RL Logo -->
            <div class="loginLogo"></div>
                 
            <!-- Login Input -->
            <div class="mTop15 forgotPass">
                <label class="left">New Password</label>
                <input name="password" type="password" id="password" value="" class="right"/>
            </div>
            <div class="mTop15 forgotPass">
                <label class="left">Confirm Password</label>
                <input type="password" name="confirm_password" value="" id="password" class="right"/>
            </div>
            <!-- Login Bottom -->
            <div class="login-bottom">
                <span class="mediumFont">Update your password</span>
                <input type="submit" value="Update" name="submit" class="submit loginsubmit" />
            </div>
            <input type="hidden" name="old_pass" value="<?php echo $_REQUEST['p']; ?>" />
            <input type="hidden" name="username" value="<?php echo $_REQUEST['u']; ?>" />
		</form>
    </div>
</div>
<?php
}else{
    header("Location: index.php?module=registration&action=Login");
}
?>