<?php if(!defined('sugarEntry'))define('sugarEntry', true);
//require_once('include/Portal/Portal.php');
require_once ('config.php');
global $portal, $sugar_config;
//$portal = new Portal();
//$portal->loadSoapClient();
//print_r($portal->leadLogin($sugar_config['portal_username'], $sugar_config['portal_password']));
//
//print_r($portal->leadLogin('admin', $sugar_config['portal_password']));

//$where = array(
//        array('name'=>'email1', 'value'=>'james.montecillo@remotelink.com', 'operator'=>'=')
//);
//print_r($portal->getEntry('Contacts', $where, $orderBy));


////$location = 'http://html2.com/rlsugarEnt/soap.php';
//$location = $sugar_config['parent_site_url'] . "soap.php";
//
//// set up options array with SugarCRM location, etc
//$options = array(
//"location" => $location,
//"uri" => 'http://www.sugarcrm.com/sugarcrm',
//"trace" => 1
//);
//
//// user authentication array
//$user_auth = array(
//"user_name" => 'admin',
//"password" => MD5('3Fbc/ifn'),
//"version" => '.01'
//);
//
//// connect to soap server
//$client = new SoapClient(NULL, $options);
//
//// Login to SugarCRM
//$response = $client->login($user_auth,'SOAP Test');
//$session_id = $response->id;

//$client->get_available_modules ($session_id);
$module_name = 'Contacts';
//$client->get_module_fields($session_id, $module_name, 'email1');
//print_r($client);

//$query = array(array('name' => 'email1', 'value' => 'sales23@example.edu', 'operator'=>'='));

//$query = "'where email1 = sales23@example.edu'";
//$client->get_entry_list($session_id, $module_name, $query, '',0, '', '', 10, -1);
//$client->get_entry_list($session_id, $module_name, $query, $order_by,$offset=0, $select_fields=array(), $link_name_to_fields_array, $max_results, $deleted);
//$result = $client->call('get_entry_list',array('session'=>$session_id,'module_name'=>'Contacts','query'=>$query, 'order_by'=>'','offset'=>0,'select_fields'=>array(),'max_results'=>10,'deleted'=>0));
//$client->get_entry_list($session_id, 'Contacts', $query, '','','','10','-1');
//print_r($client);

//$client->get_entries_count($session_id, $module_name, $query, $deleted);

//$client->search_by_module($session_id, $query, $module_name, $offset, $max_results);
print_r($client);
?>
