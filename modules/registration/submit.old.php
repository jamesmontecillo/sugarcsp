<?php if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

//require_once('include/Portal/Portal.php');
//$portal = new Portal();

//$salutation = $_REQUEST[''];
$first_name = $_REQUEST['first_name'];
$last_name = $_REQUEST['last_name'];
//$phone_work = $_REQUEST[''];
$phone_mobile = $_REQUEST['phone'];
//$phone_home = $_REQUEST[''];
//$do_not_call = $_REQUEST[''];
$email1 = $_REQUEST['email'];
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

$password = $_REQUEST['password'];

global $portal, $sugar_config;
$result = $portal->leadLogin($sugar_config['portal_username'], $sugar_config['portal_password']);
$portal->handleResult($result);

//$portal->login($sugar_config['portal_username'], $sugar_config['portal_password'], $sugar_config['username'], $sugar_config['password']);
//$where = array(
//        array('name'=>'email1', 'value'=>$email1, 'operator'=>'='),
//);
//print_r($portal->getEntries('Contacts', $where, $orderBy));

//print_r ($portal->getFields('Contacts'));

$dataarray = array(
//    array('name' => 'salutation', 'value' => $salutation),
    array('name' => 'first_name', 'value' => $first_name),
    array('name' => 'last_name' , 'value' => $last_name),
//    array('name' => 'phone_work', 'value' => $phone_work),
    array('name' => 'phone_mobile', 'value' => $phone_mobile),
//    array('name' => 'phone_home', 'value' => $phone_home),
//    array('name' => 'do_not_call', 'value' => $do_not_call),
    array('name' => 'email1', 'value' => $email1),
//    array('name' => 'email2', 'value' => $email2),
//    array('name' => 'email_opt_out', 'value' => $email_opt_out),
//    array('name' => 'title', 'value' => $title),
//    array('name' => 'department', 'value' => $department),
//    array('name' => 'account_name', 'value' => $account_name),
    array('name' => 'primary_address_street', 'value' => $address),
    array('name' => 'primary_address_city', 'value' => $add_city),
    array('name' => 'primary_address_state', 'value' => $add_state),
    array('name' => 'primary_address_postalcode', 'value' => $add_postcode),
    array('name' => 'primary_address_country', 'value' => $add_country),
    array('name' => 'portal_name', 'value' => $email1),
    array('name' => 'portal_active', 'value' => '1'),
    array('name' => 'portal_password', 'value' => md5($password)),
    array('name' => 'team_id', 'value' => '1'),
    );
print_r($portal->save('Contacts', $dataarray));
//header('Location: index.php?module=Users&action=Login');
?>