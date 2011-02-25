<?php if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('include/Save/SavePortal.php');
$module = 'myquestions';
$action = $module;

$title = $_REQUEST['questiontitle'];
$question = $_REQUEST['message'];

$dataarray = array(
    array('name' => 'account_name', 'value' => $_SESSION['account_name']),
    array('name' => 'type', 'value' => 'Question'),
    array('name' => 'name', 'value' => $title),
    array('name' => 'description' , 'value' => $question),
    array('name' => 'status' , 'value' => 'New'),
    array ('name'=>'portal_viewable','value'=>'1', 'operator'=>'=')
);

$savePortal = new SavePortal();
$savePortal->save($module, $action, $dataarray);

?>