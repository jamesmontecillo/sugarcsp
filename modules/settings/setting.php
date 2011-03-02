<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
if (!isset($_SESSION['session_id'])){
    $_SESSION["login_error"] = 'Session Timed Out';
    header('Location: index.php?module=Users&action=Login&sessiontimeout=1');
}
require_once("snoopy.class.php");
global $portal, $sugar_config;
$response = $portal->login($sugar_config['portal_username'], $sugar_config['portal_password'], $_SESSION['user_name'], $_SESSION['user_password']);

$res = $portal->getCurrentUserID();
$data = $portal->getEntry('Contacts', $res['id'], 
        array(
            'first_name',
            'last_name',
            'email1',
            'email_opt_out',
            'phone_mobile',
            'primary_address_street',
            'primary_address_city',
            'primary_address_state',
            'primary_address_postalcode',
            'primary_address_country',
            'portal_user_password'
            )
        );

//print_r($data);
$session_id = $response['id'];

    $login=$sugar_config['portal_username'];//'spadmin';
    $password=$sugar_config['portal_password'];//'3Fbc/ifn';
    $server=$sugar_config['parent_site_url'];//'http://html2.com/rlsugarEnt';
//    $server='http://localhost:8080/SugarPro551';

    $contact=json_encode(
    array(
        'email_address'=>$data['data']['email1'],
        'login'=>$login,
        'password'=>$password,
        'datafrom'=>'setting'
        )
    );


    $submit_vars['ContactData'] = $contact;
    $submit_url = "$server/index.php?module=Contacts&entryPoint=customPortalUserCreate";
    $snoopy = new Snoopy;

    if ($snoopy->submit($submit_url,$submit_vars))
    {
        $ret = json_decode($snoopy->results);
        if (isset($ret))
        {
            $return_code=$ret->return_code;
            if($return_code=='0'){
                //Successful
//                echo "$ret->return_msg Contact id is: $ret->return_id";
//                $_SESSION["login_error"] = "$ret->return_msg";
//                print_r($ret);
           



//$dataarray = array(
//    array('name' => 'id', 'value' => $res['id']),
//    array('name' => 'description', 'value' => 'Pogi'),
//);
//print_r($portal->getFields('Contacts'));
?>
<!-- SETTING EDIT -->
<form action="index.php?module=settings&action=update" method="POST">
    <div class="settingInput left mTop15">
        <div class="mTop15">
            <label>First Name</label>
            <input name="first_name" type="text" id="title7" value="<?php echo $data['data']['first_name']; ?>" />
        </div>
        <div class="mTop15">
            <label>Email Name</label>
            <input name="email" type="text" id="title" value="<?php echo $data['data']['email1']; ?>" />
        </div>
        <div class="mTop15">
            <label>Email Opt Out: </label>
            <input type='checkbox' class='checkbox' name='email_opt_out' size='' value='1' tabindex="4" <?php if(!empty($ret->return_id)) {echo "CHECKED";} ?> >
        </div>
        <div class="mTop15">
            <label>Street 1</label>
            <input name="street_add1" type="text" id="title" value="<?php echo $data['data']['primary_address_street']; ?>" />
        </div>
        <div class="mTop15">
            <label>City</label>
            <input name="city" type="text" id="title" value="<?php echo $data['data']['primary_address_city']; ?>" />
        </div>
        <div class="mTop15">
            <label>Zip</label>
            <input name="zip" type="text" id="title" value="<?php echo $data['data']['primary_address_postalcode']; ?>" />
        </div>      
    </div>

    <!-- Reg Input Right -->
    <div class="settingInput right mTop15">
        <div class="mTop15">
            <label>Last Name</label>
            <input name="last_name" type="text" id="title" value="<?php echo $data['data']['last_name']; ?>" />
        </div>
        <div class="mTop15">
            <label>Phone</label>
            <input name="phone" type="text" id="title" value="<?php echo $data['data']['phone_mobile']; ?>" />
        </div>
        <!--
        <div class="mTop15">
            <label>Street 2</label>
            <input name="street_add2" type="text" id="title" value="<?php echo $data['data']['email1']; ?>" />
        </div>-->
        <div class="mTop15">
            <label>State</label>
            <input name="state" type="text" id="title" value="<?php echo $data['data']['primary_address_state']; ?>" />
        </div>
        <div class="mTop15">
            <label>Country</label>
            <input name="country" type="text" id="title" value="<?php echo $data['data']['primary_address_country']; ?>" />
        </div>
        <!--
        <div class="mTop15">
            <label>Password</label>
            <input name="password" type="password" id="title" value="<?php echo $data['data']['email1']; ?>" />
        </div>
        <div class="mTop15">
            <label>Password Confirm</label>
            <input name="password_confirm" type="password" id="title" value="<?php echo $data['data']['email1']; ?>" />
        </div>-->
    </div>

    <!-- Reg Bottom -->
    <div class="reg-bottom left">
        <input type="submit" value="Update" name="submit" class="submit regsubmit" />
    </div>
</form>
<?php

 } else {
                //Error
                echo "Error:  Return code is $ret->return_code Error message is $ret->return_msg" ;
//                $_SESSION["login_error"] = "$ret->return_msg";
            }
        }
        else
        {
            //Error
            $msg=strip_tags($snoopy->results);
            $err_str=strip_tags($snoopy->results);
            $error=true;
            echo "Error $msg" ;
            $_SESSION["login_error"] = "Error $msg";
        }
    }
?>