<?php if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

$title = $_REQUEST['questiontitle'];
$question = $_REQUEST['message'];

//require_once('include/Portal/Portal.php');
//$portal = new Portal();

global $portal, $sugar_config;
$response = $portal->login($sugar_config['portal_username'], $sugar_config['portal_password'], $_SESSION['user_name'], $_SESSION['user_password']);

//print_r ($portal->getFields('Cases'));

$dataarray = array(
    array('name' => 'account_name', 'value' => $_SESSION['user_name']),
    array('name' => 'case_type_c', 'value' => 'Question'),
    array('name' => 'name', 'value' => $title),
    array('name' => 'description' , 'value' => $question),
    array('name' => 'status' , 'value' => 'New'),
);
$portal->save('Cases', $dataarray);

header('Location: index.php?module=myquestions&action=index');

?>