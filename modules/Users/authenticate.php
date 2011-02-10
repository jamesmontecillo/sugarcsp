<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

$user_name = $_REQUEST['user_name'];
$password = $_REQUEST['password'];

global $portal;
//require_once('include/Portal/Portal.php');
//$portal = new Portal();

$response = $portal->login($sugar_config['portal_username'], $sugar_config['portal_password'], $user_name, $password);

$res = $portal->getCurrentUserID();
$fullname = $portal->getEntry('Contacts', $res['id'], array('first_name','last_name'));
$_SESSION['fullname'] = $fullname['data']['first_name'] . " " . $fullname['data']['last_name'];

$session_id = $response['id'];

//$dataarray = array(
//    array('name' => 'id', 'value' => $res['id']),
//    array('name' => 'description', 'value' => 'Pogi'),
//);
//print_r($portal->getFields('Contacts'));
//print_r($portal->soapClientProxy->portal_set_entry($session_id, 'Contacts', $dataarray));

if (isset($session_id)){
    $_SESSION['user_name'] = $user_name;
    $_SESSION['user_password'] = $password;
    header('Location: index.php?module=home&action=index');
}

//{
//    header('Location: index.php?module=Users&action=Login');
//}

//echo "<br />";
//$response = $client->logout($session_id);
//$response = $client->get_available_modules($session_id);
//$response = $client->get_module_fields($session_id, 'Accounts');
//$user_id = $client->get_user_id($session_id);
?>