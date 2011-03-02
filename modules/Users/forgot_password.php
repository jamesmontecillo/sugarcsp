<?php if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once("snoopy.class.php");
global $portal, $sugar_config;

    $email = $_REQUEST['lost_email'];
    $portal_user_password = generatePassword(10,3);
    $team_id='1'; //global
    $server=$sugar_config['parent_site_url'];//'http://html2.com/rlsugarEnt';
//    $server='http://localhost:8080/SugarPro551';

    $contact=json_encode(
            array(
                'email_address'=>$email,
                'portal_user_password'=>$portal_user_password,
                'login'=>$sugar_config['portal_username'],
                'password'=>$sugar_config['portal_password'],
                'datafrom'=>'forgot_password'
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
                echo "Successful $ret->return_msg Contact id is: $ret->return_id";

                //////////////////////////////////////////////////////////////////////
                $urlmail = urlencode($email);
                $to = $email;
                $subject = "Remotelink Sugar Customer Service Portal\n\n\n";
                $message = "Forgot Password\n\n".
                    "Request for password reset:\n\n".
                    "Username: $email\n".
                    "Password: $portal_user_password\n".
                    "or to renew your password, visit the link below: \n".
                    "<a href='".$sugar_config['site_url']."/index.php?module=registration&action=new_password&id=$ret->return_id&u=$urlmail&p=$portal_user_password'>Click Here</a>\n".
                    "\n";

                $header = "From: ".$sugar_config['site_url'];

                $retval = mail($to,$subject,$message,$header);
                if ($retval == true)
                {
                    echo "A confirmation was sent to your email. Thank you!";
                    $_SESSION["login_error"] = "Check your email for verification \n$portal_user_password";
                    header('Location: index.php?module=Users&action=Login');
                } else {
                    echo "Opsss! Somethings Goes Wrong. Please go back and re-enter your email address\n";
                    echo $message;
                }
                //////////////////////////////////////////////////////////////////////
                
            } else {
                //Error
                echo "Error:  Return code is $ret->return_code Error message is $ret->return_msg" ;
                $_SESSION["login_error"] = "Error:  Return code is $ret->return_code Error message is $ret->return_msg" ;
            }
        }
        else
        {
            //Error
            $msg=strip_tags($snoopy->results);
            $err_str=strip_tags($snoopy->results);
            $error=true;
            echo $_SESSION["login_error"] = "Error $msg" ;
        }
    }



function generatePassword($length,$level){

   list($usec, $sec) = explode(' ', microtime());
   srand((float) $sec + ((float) $usec * 100000));

   $validchars[1] = "0123456789abcdfghjkmnpqrstvwxyz";
   $validchars[2] = "0123456789abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
   $validchars[3] = "0123456789_!@#$%&*()-=+/abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_!@#$%&*()-=+/";

   $password  = "";
   $counter   = 0;

   while ($counter < $length) {
     $actChar = substr($validchars[$level], rand(0, strlen($validchars[$level])-1), 1);

     // All character must be different
     if (!strstr($password, $actChar)) {
        $password .= $actChar;
        $counter++;
     }
   }

   return $password;

}

?>
