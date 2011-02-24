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

/*	Default definitions for quicksearches
 * 
 */

class QuickSearchDefaults {	
	function getQSParent() {
		global $app_strings;
		
		$qsParent = array( 
					'method' => 'query',
					'modules' => array('Accounts'), 
					'group' => 'or', 
					'field_list' => array('name', 'id'), 
					'populate_list' => array('parent_name', 'parent_id'), 
					'conditions' => array(array('name'=>'name','op'=>'like_custom','end'=>'%','value'=>'')), 
					'order' => 'name', 
					'limit' => '30',
					'no_match_text' => $app_strings['ERR_SQS_NO_MATCH']
					);
					
		return $qsParent;
	}
	
	function getQSUser() {
		global $app_strings;
		
		$qsUser = array(  'method' => 'get_user_array', // special method  
						'field_list' => array('user_name', 'id'), 
						'populate_list' => array('assigned_user_name', 'assigned_user_id'), 
						'conditions' => array(array('name'=>'user_name','op'=>'like_custom','end'=>'%','value'=>'')),
						'limit' => '30','no_match_text' => $app_strings['ERR_SQS_NO_MATCH']);
		return $qsUser;
	}
	
	function getQSTeam() {
		global $app_strings;
		
		$qsTeam = array( 
					'method' => 'query', 
					'modules'=> array('Teams'), 
					'group' => 'or', 
					'field_list' => array('name', 'id'), 
					'populate_list' => array('team_name', 'team_id'), 
					'conditions' => array(array('name'=>'name','op'=>'like_custom','end'=>'%','value'=>''), 
												 array('name'=>'name','op'=>'like_custom','begin'=>'(','end'=>'%','value'=>'')), 
					'order' => 'name', 'limit' => '30', 'no_match_text' => $app_strings['ERR_SQS_NO_MATCH']);
		return $qsTeam;		
	}
	
	function getQSScripts() {
		require_once('include/json_config.php');
		static $json_config = null;
		if(!isset($json_config)) $json_config = new json_config();
		
		global $sugar_version, $sugar_config, $theme;
		$qsScripts = '<script type="text/javascript" src="include/JSON.js?s=' . $sugar_version . '&c=' . $sugar_config['js_custom_version'] . '"></script><script type="text/javascript">' . $json_config->get_static_json_server() . '</script>
		<script type="text/javascript" src="include/jsolait/init.js?s=' . $sugar_version . '&c=' . $sugar_config['js_custom_version'] . '"></script>
		<script type="text/javascript" src="include/jsolait/lib/urllib.js?s=' . $sugar_version . '&c=' . $sugar_config['js_custom_version'] . '"></script>
		<script type="text/javascript" src="include/javascript/jsclass_base.js?s=' . $sugar_version . '&c=' . $sugar_config['js_custom_version'] . '"></script>
		<script type="text/javascript" src="include/javascript/jsclass_async.js?s=' . $sugar_version . '&c=' . $sugar_config['js_custom_version'] . '"></script>
		<script type="text/javascript">sqsWaitGif = "themes/' . $theme . '/images/sqsWait.gif";</script>
		<script type="text/javascript" src="include/javascript/quicksearch.js?s=' . $sugar_version . '&c=' . $sugar_config['js_custom_version'] . '"></script>
		';
		
		return $qsScripts;
		
	}
	
	function getQSScriptsNoServer() {
		global $sugar_version, $sugar_config, $theme;
		
		$qsScriptsNoServer = '<script type="text/javascript" src="include/JSON.js?s=' . $sugar_version . '&c=' . $sugar_config['js_custom_version'] . '"></script>
		<script type="text/javascript" src="include/jsolait/init.js?s=' . $sugar_version . '&c=' . $sugar_config['js_custom_version'] . '"></script>
		<script type="text/javascript" src="include/jsolait/lib/urllib.js?s=' . $sugar_version . '&c=' . $sugar_config['js_custom_version'] . '"></script>
		<script type="text/javascript" src="include/javascript/jsclass_base.js?s=' . $sugar_version . '&c=' . $sugar_config['js_custom_version'] . '"></script>
		<script type="text/javascript" src="include/javascript/jsclass_async.js?s=' . $sugar_version . '&c=' . $sugar_config['js_custom_version'] . '"></script>
		<script type="text/javascript">sqsWaitGif = "themes/' . $theme . '/images/sqsWait.gif";</script>
		<script type="text/javascript" src="include/javascript/quicksearch.js?s=' . $sugar_version . '&c=' . $sugar_config['js_custom_version'] . '"></script>
		';
		
		return $qsScriptsNoServer;		
	}
	
	function getQSScriptsJSONAlreadyDefined() {
		global $sugar_version, $sugar_config, $theme;
		
		$qsScriptsJSONAlreadyDefined = '<script type="text/javascript">sqsWaitGif = "themes/' . $theme . '/images/sqsWait.gif";</script><script type="text/javascript" src="include/javascript/quicksearch.js?s=' . $sugar_version . '&c=' . $sugar_config['js_custom_version'] . '"></script>';
		return $qsScriptsJSONAlreadyDefined;
	}
	
	
}

?>