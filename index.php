<?php
if(!defined('sugarEntry'))define('sugarEntry', true);

require_once ('config.php');

// create the global Portal object
require_once('include/Portal/Portal.php');
$portal = new Portal();
$portal->loadSoapClient();

global $currentModule;

if(isset($_REQUEST['action'])) {
	$action = $_REQUEST['action'];
} else {
	$action = "";
}
if(isset($_REQUEST['module'])) {
	$module = $_REQUEST['module'];
} else {
	$module = "";
}

if(!empty($module)) {
	$currentModule = $module;
}
session_start();



$css = "style";
$ie_css = "css-ie";
$js = "jquery-latest";

include_once("themes/sugarcsp/header.php");
include_once("themes/sugarcsp/topmenu.php");

///////////////////////////////////////////////////////////////////////////////
////	RENDER PAGE REQUEST BASED ON $module - $action - (and/or) $record
if(!empty($action) && !empty($module)) {
        if($action == 'Login' && isset($_SESSION['authenticated_user_id'])) {
		header('Location: index.php?module=Users&action=Logout');
        die();
	} else {
		$currentModuleFile = "modules/".$module."/".$action.".php";
	}
}elseif(!empty($module)) { // ifwe do not have an action, but we have a module, make the index.php file the action
	$currentModuleFile = "modules/".$currentModule."/index.php"; //'modules/'.$currentModule.'/index.php';
} else { 
	header('Location: index.php?module=Users&action=Login');
    die();
}
////	END RENDER PAGE REQUEST BASED ON $module - $action - (and/or) $record
///////////////////////////////////////////////////////////////////////////////

if(!empty($currentModuleFile)) {
    include($currentModuleFile);
}

include_once("themes/sugarcsp/rightcontent.php");
include_once ("themes/sugarcsp/footer.php");

?>

