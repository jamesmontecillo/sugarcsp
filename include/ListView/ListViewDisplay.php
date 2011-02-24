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

require_once('include/ListView/ListViewData.php');

class ListViewDisplay {
	var $rowCount;
	var $mass = null;
	var $multi_select_popup;
	var $lvd;
	var $moduleString;

	/**
	 * Constructor
	 * @return null
	 */
	function ListViewDisplay() {
		$this->lvd = new ListViewData();
	}

	/**
	 * Setup the class
	 * @param seed SugarBean Seed SugarBean to use
	 * @param file File Template file to use
	 * @param string $where
	 * @param offset:0 int offset to start at
	 * @param int:-1 $limit
	 * @param string[]:array() $filter_fields
	 * @param array:array() $params
	 * 	Potential $params are
		$params['distinct'] = use distinct key word
		$params['include_custom_fields'] = (on by default)
		$params['massupdate'] = true by default;
	 * @param string:'id' $id_field
	 */
	function setup($module, $file, $where, $params = array(), $offset = 0, $limit = -1,  $filter_fields = array(), $id_field = 'id') {
        global $sugar_config;

        if(empty($where) && !empty($_SESSION['listviewFilters'][$module]['soapWhere'])) {
            $where = $_SESSION['listviewFilters'][$module]['soapWhere'];
        }
        if($limit == -1) $limit = $sugar_config['list_max_entries_per_page'];
		$this->module = $module;
		$data = $this->lvd->getListViewData($module, $where, $offset, $limit, $filter_fields, $params, $id_field);

		$this->process($file, $data, $module);
	}

	/**
	 * Any additional processing
	 * @param file File template file to use
	 * @param data array row data
	 * @param html_var string html string to be passed back and forth
	 */
	function process($file, $data, $htmlVar) {
		$this->rowCount = count($data['data']);
		$this->moduleString = $data['pageData']['module'] . '2_' . strtoupper($htmlVar) . '_offset';
	}

	/**
	 * Display the listview
	 * @return string ListView contents
	 */
	function display() {
		$str = '';

        return $str;
	}

	/**
	 * Display the bottom of the ListView (ie MassUpdate
	 * @return string contents
	 */
	function displayEnd() {
		$str = '';

		return $str;
	}

}
?>