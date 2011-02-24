<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Enterprise Subscription
 * Agreement ("License") which can be viewed at
 * http://www.sugarcrm.com/crm/products/sugar-enterprise-eula.html
 * By installing or using this file, You have unconditionally agreed to the
 * terms and conditions of the License, and You may not use this file except in
 * compliance with the License.  Under the terms of the license, You shall not,
 * among other things: 1) sublicense, resell, rent, lease, redistribute, assign
 * or otherwise transfer Your rights to the Software, and 2) use the Software
 * for timesharing or service bureau purposes such as hosting the Software for
 * commercial gain and/or for the benefit of a third party.  Use of the Software
 * may be subject to applicable fees and any use of the Software without first
 * paying applicable fees is strictly prohibited.  You do not have the right to
 * remove SugarCRM copyrights from the source code or user interface.
 *
 * All copies of the Covered Code must include on each user interface screen:
 *  (i) the "Powered by SugarCRM" logo and
 *  (ii) the SugarCRM copyright notice
 * in the same form as they appear in the distribution.  See full license for
 * requirements.
 *
 * Your Warranty, Limitations of liability and Indemnity are expressly stated
 * in the License.  Please refer to the License for the specific language
 * governing these rights and limitations under the License.  Portions created
 * by SugarCRM are Copyright (C) 2004-2010 SugarCRM, Inc.; All Rights Reserved.
 ********************************************************************************/
/*********************************************************************************

 * Description:  is a form helper
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/


function checkRequired($prefix, $required){
	foreach($required as $key){
		if(!isset($_POST[$prefix.$key]) || number_empty($_POST[$prefix.$key])){
			return false;
		}
	}
	return true;
}
function populateFromPost($prefix, &$focus){
	global $current_user;
	$focus->retrieve($_REQUEST[$prefix.'record']);
	
	if(isset($_REQUEST[$prefix.'status']) && !empty($_REQUEST[$prefix.'status'])){
			$focus->status = $_REQUEST[$prefix.'status'];	
	}
	if (!empty($_POST['assigned_user_id']) && ($focus->assigned_user_id != $_POST['assigned_user_id']) && ($_POST['assigned_user_id'] != $current_user->id)) {
		$GLOBALS['check_notify'] = true;
	}
	 foreach($focus->column_fields as $field)
		{
			if(isset($_POST[$prefix.$field]))
			{
				$focus->$field = $_POST[$prefix.$field];
			}
		}
		foreach($focus->additional_column_fields as $field)
		{
			if(isset($_POST[$prefix.$field]))
			{
				$value = $_POST[$prefix.$field];
				$focus->$field = $value;
			}
		}
		return $focus;

}

function getPostToForm($ignore=''){
	$fields = '';
	foreach ($_POST as $key=>$value){
		if($key != $ignore)
			$fields.= "<input type='hidden' name='$key' value='$value'>";
	}
	return $fields;

}
function getGetToForm($ignore=''){
	$fields = '';
	foreach ($_GET as $key=>$value){
		if($key != $ignore)
			$fields.= "<input type='hidden' name='$key' value='$value'>";
	}
	return $fields;

}
function getAnyToForm($ignore=''){
	$fields = getPostToForm($ignore);
	$fields .= getGetToForm($ignore);
	return $fields;

}

function handleRedirect($return_id='', $return_module='')
{
	if(isset($_REQUEST['return_url']) && $_REQUEST['return_url'] != "")
	{
		header("Location: ". $_REQUEST['return_url']);
		exit;
	}

	if(isset($_REQUEST['return_module']) && $_REQUEST['return_module'] != "")
	{
		$return_module = $_REQUEST['return_module'];
	}
	else
	{
		$return_module = $return_module;
	}

	if(isset($_REQUEST['return_action']) && $_REQUEST['return_action'] != "")
	{

		// if we create a new record "Save", we want to redirect to the DetailView
		if($_REQUEST['action'] == "Save" 
			&& $_REQUEST['return_module'] != 'Activities'
			&& $_REQUEST['return_module'] != 'WorkFlow'  
			&& $_REQUEST['return_module'] != 'Home' 
			&& $_REQUEST['return_module'] != 'Forecasts' 
			&& $_REQUEST['return_module'] != 'Calendar'
			&& $_REQUEST['return_module'] != 'MailMerge'
			&& $_REQUEST['return_module'] != 'TeamNotices'
			) {
			$return_action = 'DetailView';
		} elseif($_REQUEST['return_module'] == 'Activities' || $_REQUEST['return_module'] == 'Calendar') {
			$return_module = $_REQUEST['module'];
			$return_action = $_REQUEST['return_action']; 
			// wp: return action needs to be set for one-click close in task list
		} else {
			// if we "Cancel", we go back to the list view.
			$return_action = $_REQUEST['return_action'];
		}
	}
	else
	{
		$return_action = "DetailView";
	}
	
	if(isset($_REQUEST['return_id']) && $_REQUEST['return_id'] != "")
	{
		$return_id = $_REQUEST['return_id'];
	}
	
	header("Location: index.php?action=$return_action&module=$return_module&record=$return_id");
	exit;
}

function getLikeForEachWord($fieldname, $value, $minsize=4){
	$value = trim($value);
	$values = split(' ',$value);
	$ret = '';
	foreach($values as $val){
		if(strlen($val) >= $minsize){
			if(!empty($ret)){
				$ret .= ' or';
			}
			$ret .= ' '. $fieldname . ' LIKE %'.$val.'%';
		}

	}


}


?>
