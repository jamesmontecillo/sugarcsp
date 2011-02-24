<?php
    require_once("snoopy.class.php");
    global $portal, $sugar_config;
    //$salutation = $_REQUEST[''];
    $first_name = $_REQUEST['first_name'];
    $last_name = $_REQUEST['last_name'];
    //$phone_work = $_REQUEST[''];
    $phone_mobile = $_REQUEST['phone'];
    //$phone_home = $_REQUEST[''];
    //$do_not_call = $_REQUEST[''];
    $email_address = $_REQUEST['email'];
    //$email2 = $_REQUEST[''];
    //$email_opt_out = $_REQUEST[''];
    //$title = $_REQUEST[''];
    //$department = $_REQUEST[''];
    //$account_name =
    $address = $_REQUEST['street_add1'] . " " . $_REQUEST['street_add2'];
    $add_city = $_REQUEST['city'];
    $add_state = $_REQUEST['state'];
    $add_postcode = $_REQUEST['zip'];
    $add_country = $_REQUEST['country'];

    $portal_user_password = $_REQUEST['password'];

//    $first_name='Bob';
//    $last_name='Smith';
//    $email_address="jmsmontecillo@gmail.com";
//    $portal_user_password='bobistheman';
    $login=$sugar_config['portal_username'];//'spadmin';
    $password=$sugar_config['portal_password'];//'3Fbc/ifn';
    $team_id='1'; //global
    $server=$sugar_config['parent_site_url'];//'http://html2.com/rlsugarEnt';
//    $server='http://localhost:8080/SugarPro551';
       
    $contact=json_encode(
            array(
                'first_name'=>$first_name,
                'last_name'=>$last_name,
                'email_address'=>$email_address,
                'phone_mobile'=>$phone_mobile,
                'primary_address_street'=>$address,
	        'primary_address_city'=>$add_city,
	        'primary_address_state'=>$add_state,
	        'primary_address_postalcode'=>$add_postcode,
	        'primary_address_country'=>$add_country,
                'portal_user_password'=>$portal_user_password,
                'login'=>$login,
                'password'=>$password,
                'team_id'=>$team_id,
                'datafrom'=>'reg'
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
                echo "$ret->return_msg Contact id is: $ret->return_id";          
                $_SESSION["login_error"] = "Successful $ret->return_msg";
                header('Location: index.php?module=Users&action=Login');
            } else {
                //Error
                echo "Error:  Return code is $ret->return_code Error message is $ret->return_msg" ;
            }
        }
        else
        {
            //Error
            $msg=strip_tags($snoopy->results);
            $err_str=strip_tags($snoopy->results);
            $error=true;
            echo "Error $msg" ;
        }
    }
    
    

?>