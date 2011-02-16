<?php if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('include/Save/SavePortal.php');
$module = 'ideas';
$action = 'myideas';

$title = $_REQUEST['ideatitle'];
$problem = $_REQUEST['message'];

$dataarray = array(
    array('name' => 'account_name', 'value' => $_SESSION['account_name']),
    array('name' => 'type', 'value' => 'Idea'),
    array('name' => 'name', 'value' => $title),
    array('name' => 'description' , 'value' => $problem),
    array('name' => 'status' , 'value' => 'Submitted'),
);

$savePortal = new SavePortal();
$savePortal->save($module, $action, $dataarray);
?>