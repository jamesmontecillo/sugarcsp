<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
if (!empty($_REQUEST['id'])||!empty($_REQUEST['p'])||!empty($_REQUEST['u'])){

$user_name = urldecode ($_REQUEST['u']);
$password = $_REQUEST['p'];

global $portal, $sugar_config;

$portal->login($sugar_config['portal_username'], $sugar_config['portal_password'], $user_name, $password);

$res = $portal->getCurrentUserID();
$data = $portal->getEntry('Contacts', $res['id'], array('first_name','last_name','account_name', 'picture'));

$_SESSION['user_name'] = $user_name;
$_SESSION['user_password'] = $password;
//print_r($data);

$_SESSION['fullname'] = $data['data']['first_name'] . " " . $data['data']['last_name'];
$_SESSION['picture'] = $data['data']['picture'];
$_SESSION['account_name'] = $data['data']['account_name'];
$_SESSION['session_id'] = $res['id'];

?>
<div id="loginCtn" class="pageDesign">
    <div class="pagePadding">
		<form action="index.php?module=registration&action=submit" method="POST" name="new_password">
            <!-- RL Logo -->
            <!--<div class="loginLogo"></div>-->
            <div class="newPassCtn">
                <div class="left">
                <?php if (!empty($_SESSION['picture'])){ ?>
                <img id="img_picture"
                    name="img_picture"
                    src='<?php echo $sugar_config['parent_site_url']; ?>/cache/upload/<?php echo $_SESSION['picture']; ?>'
                    class="avatarBig">
                <?php } else {?>
                    <img src="images/profile_placeholder.png" alt="profile_pic" class="avatarBig"/>
                <?php } ?>
                </div>
                <div class="left">
                    <h3><?php echo $_SESSION['fullname']; ?></h3>
                </div>     
            </div>
            <!-- Login Input -->
            <div class="mTop15 forgotPass clear">
                <label class="left">New Password</label>
                <input name="password" type="password" id="password" value="" class="right"/>
            </div>
            <div class="mTop15 forgotPass">
                <label class="left">Confirm Password</label>
                <input type="password" name="confirm_password" value="" id="password" class="right"/>
            </div>
            <!-- Login Bottom -->
            <div class="login-bottom">
                <input type="submit" value="Update" name="submit" class="submit loginsubmit" />
                <input type="hidden" name="new_password" value="new_password" />
                <input type="hidden" name="email" value="<?php echo $user_name; ?>" />
            </div>
		</form>
    </div>
</div>
<?php
}else{
    header("Location: index.php?module=Users&action=Login");
}
///http://ec2.remotelink.com/sugarportal/index.php?module=registration&action=new_password&id=1234&u=james.montecillo%40remotelink.com&p=3Fbc/ifn
?>
