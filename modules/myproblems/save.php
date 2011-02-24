<?php if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('include/Save/SavePortal.php');
$module = 'myproblems';
$action = $module;

$title = $_REQUEST['problemstitle'];
$problem = $_REQUEST['message'];

$dataarray = array(
    array('name' => 'account_name', 'value' => $_SESSION['account_name']),
    array('name' => 'type', 'value' => 'Problem'),
    array('name' => 'name', 'value' => $title),
    array('name' => 'description' , 'value' => $problem),
    array('name' => 'status' , 'value' => 'New'),
);

$savePortal = new SavePortal();
$savePortal->save($module, $action, $dataarray);

?>