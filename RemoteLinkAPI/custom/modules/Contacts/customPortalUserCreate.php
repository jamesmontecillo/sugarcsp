<?php   
    /* this fucntion performs the folloiwng logic
    1) search for a particular email address though all of the contacts
    2) if no match, strip the domain name off of the email, and search the website field in the account object over SOAP for a "LIKE" match with the domain name of the email
    2.1) if no match, quit with a "no account configured" error
    2.2) if match, then save accountid/account for later association
    2.3) create a contact record associated to that account with first name, lastname, email address passed as input

    3) so now you have a contact record, either one that matched the query in step (1) or one that you created new in step (2.3). If more than one match is found, return error for "more than one match for email"
    3.1) add the portal username and password and set portal active flag for that contact record and save the information. The username will be the email address and the password will be supplied as the input
    3.2 return status

    The following fields must be passed in a JSON array
    first_name
    last_name
    email_address
    portal_user_password
    login
    password
    The Login/Password will be used to validate the user for this function since security is not used natively
    * 
    *   The folliwng information is returned in a JSON array
    *   return_code = set to "0" if it worked successfully
    *   return_msg = "status message"
    *   return_id = the id of the contact that was either created or updated
    * 
    *   Return codes are:
    *  0 : Worked fine
    * -1 : required fields are missing
    * -25 : Badly formatted email address
    * -98 : Could not find account with domain of the email address
    * -97 : Multiple matching email domains found
    * -99 : could not validate user login 
    */

    if(!defined('sugarEntry'))define('sugarEntry', true);  
    require_once('include/entryPoint.php');  
    require_once("modules/Contacts/Contact.php");


    $ContactData = $_POST['ContactData'];
    $pattern='/&quot;/';
    $replacement='"';
    $ContactData = preg_replace($pattern,$replacement,$ContactData);

    $ContactData = json_decode($ContactData);
    $GLOBALS['log']->debug("CustomPortaluserCreate:  Contact Data is " . print_r($ContactData,true));

    $return_msg='';
    $return_code='';
    $return_id='';
    $err=false;
    if ($ContactData->datafrom == 'reg'){
        $required_fields=array("last_name","first_name","email_address","portal_user_password","login","password","team_id");
    }else if ($ContactData->datafrom == 'forgot_password'){
        $required_fields=array("email_address");
    }else if ($ContactData->datafrom == 'setting'){
        $required_fields=array("email_address");
    }
    
    foreach ($required_fields as $required_field){
        if (empty($ContactData->$required_field)){
            $err=true;
            $return_code="-1";
            $return_msg = "Field $required_field Not Set.";
        }
    }

    //Validate the email address
    if(!filter_var($ContactData->email_address, FILTER_VALIDATE_EMAIL)) {
        $err=true;
        $return_code="-25";
        $return_msg = 'Email address is not a valid format';
    }

    if(!$err){
        //Validate the login

        $user_hash=md5($ContactData->password);
        $q = "select id from users where status='Active' and user_name='$ContactData->login' and user_hash='$user_hash'"; 
        $results = $GLOBALS['db']->query($q,true,"Error validating user in CustomPortaluserCreate");
        if ($row = $GLOBALS['db']->fetchByAssoc($results)) {
            $userid = $row['id'];
            //Check for email address for contact
            $email = strtolower($ContactData->email_address)  ;
            $q = "select contacts.id, email_addresses.opt_out from contacts
            inner join email_addr_bean_rel on bean_id = contacts.id and bean_module='Contacts' and email_addr_bean_rel.deleted = 0
            inner join email_addresses on email_addresses.id = email_addr_bean_rel.email_address_id and 
            email_addresses.email_address='$email' and email_addresses.deleted=0
            where contacts.deleted=0";
            $results = $GLOBALS['db']->limitQuery($q,0,1,true, "Error finding contact email address");  
            if ($row = $GLOBALS['db']->fetchByAssoc($results))   {
                //Found a contact with that email address
                //Upate the info
                if ($ContactData->datafrom == 'reg'){
                $c = new Contact;
                $c->retrieve($row['id']);
		$c->id = $row['id'];
	        $c->first_name = $ContactData->first_name;
	        $c->last_name = $ContactData->last_name;
	        $c->email1 = $ContactData->email_address;
                $c->email_opt_out = $ContactData->email_opt_out;
                $c->phone_mobile = $ContactData->phone_mobile;
	        $c->primary_address_street = $ContactData->primary_address_street;
	        $c->primary_address_city = $ContactData->primary_address_city;
	        $c->primary_address_state = $ContactData->primary_address_state;
	        $c->primary_address_postalcode = $ContactData->primary_address_postalcode;
	        $c->primary_address_country = $ContactData->primary_address_country;
	        $c->account_id =  $account_id;
	        $c->portal_active = 1;
	        $c->portal_name = $ContactData->email_address;
	        $c->portal_password = md5($ContactData->portal_user_password); 
                $c->team_id = $ContactData->team_id;
                $c->modified_user_id = $userid;
                $c->save();
                $return_code="0";
                $return_msg = "You have successfully created your account. Please login.";
                $return_id = $c->id ;
                }else if ($ContactData->datafrom == 'forgot_password'){
                    $c = new Contact;
                    $c->retrieve($row['id']);
                    $c->id = $row['id'];
                    $c->email1 = $ContactData->email_address;
                    $c->portal_active = 1;
                    $c->portal_name = $ContactData->email_address;
                    $c->portal_password = md5($ContactData->portal_user_password);
                    $c->team_id = $ContactData->team_id;
                    $c->modified_user_id = $userid;
                    $c->save();
                    $return_code="0";
                    $return_msg = "Successfully updated your account";
                    $return_id = $c->id ;
                }else if ($ContactData->datafrom == 'setting'){
                    $c = new Contact;
                    $c->retrieve($row['id']);
                    $c->id = $row['id'];
                    $c->email_opt_out = $row['opt_out'];
                    $return_code="0";
                    $return_msg = "Successfully Query your email";
                    $return_id = $c->email_opt_out;
                }

            } else {
                //Contact not found
                $email_array = explode("@", $ContactData->email_address);
                $domain =  $email_array[1];
                //Search for the account web site
                $q = "select count(*) as ct from accounts where deleted =0 and website like '%$domain'";
                $results = $GLOBALS['db']->query($q,true,"Error getting domain count");
                $row = $GLOBALS['db']->fetchByAssoc($results);
                if ($row['ct']=="0"){
                    //Could not find a matching account name
                    $return_code="-98";
                    $return_msg = "Count not found an account with domain $domain";
                }  elseif ($row['ct']=="1"){  
                    //Found matching account.  OK to prcoeed

                    $cId= $row['id'];

                    //Get the account id
                    $q = "select id from accounts where deleted =0 and website like '%$domain'";
                    $results = $GLOBALS['db']->query($q,true,"Error getting domain count");
                    if($row = $GLOBALS['db']->fetchByAssoc($results)){
                        $account_id = $row['id'];
                        //create new contact
                        $c = new Contact;
                        $c->first_name = $ContactData->first_name;
                        $c->last_name = $ContactData->last_name; 
                        $c->email1 = $ContactData->email_address;
                        $c->email_opt_out = $ContactData->email_opt_out;
                        $c->phone_mobile = $ContactData->phone_mobile;
                        $c->primary_address_street = $ContactData->primary_address_street;
                        $c->primary_address_city = $ContactData->primary_address_city;
                        $c->primary_address_state = $ContactData->primary_address_state;
                        $c->primary_address_postalcode = $ContactData->primary_address_postalcode;
                        $c->primary_address_country = $ContactData->primary_address_country;
                        $c->account_id =  $account_id;
                        $c->portal_active = 1;
                        $c->portal_name = $ContactData->email_address; 
                        $c->portal_password = md5($ContactData->portal_user_password);    
                        $c->team_id = $ContactData->team_id;
                        $c->created_by = $userid;
                        $c->save();
                        $return_id = $c->id ;
                        $return_code="0"; 
                        $return_msg = "You have successfully created your account. Please login.";

                    }  else {
                        //The record was deleted in the miliseconds between the above count and now
                        $return_code="-98";
                        $return_msg = "Count not found an account with domain $domain";
                    }

                }  else {
                    //Found multiple matching domains
                    $return_code="-97";
                    $return_msg = "Mutiple domain matches for $domain"; 

                }
            }


        } else {
            $return_msg='Could not validate user login';
            $return_code='-99';  
        }
    }

    $ret = array('return_code'=>$return_code, 'return_msg'=>$return_msg,'return_id'=>$return_id);
    echo json_encode($ret);
?>
