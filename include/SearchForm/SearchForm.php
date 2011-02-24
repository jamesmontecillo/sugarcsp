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
require_once('include/TemplateHandler/TemplateHandler.php');

class SearchForm {
    var $th;
    var $tpl;
    var $fields;
    var $module;

    function SearchForm($module, $tpl = null) {
        global $app_strings, $portal;

        $this->th = new TemplateHandler();

        $this->module = $module;

        $this->fields = $portal->getFields($this->module, true);

        if(empty($tpl)) {
            $this->tpl = 'include/SearchForm/SearchForm.tpl';
        }
        else {
            $this->tpl = $tpl;
        }

        $this->modStrings = array();
        $translate = true;
        foreach($this->fields as $name => $def) {
            $this->modStrings[$name] = !empty($def['label']) ? $def['label'] : $name;
        }

    }

    /**
     * Populate the searchFields from $_REQUEST
     */
    function populateFromRequest() {    	
        foreach($this->fields as $name => $params) {
            if(!empty($_REQUEST[$name])) {
                $this->fields[$name]['value'] = $_REQUEST[$name];
            }
        }
    }

    /**
     * The fuction will returns an array of filter conditions.
     *
     */
    function generateSearchWhere($module) {    	
    	
        $soapWhere = array();
        $whereClauses = array();
        $searchFormButtonPressed = true;
        if(isset($_REQUEST['clear']) && $_REQUEST['clear'] == 'false') {
        	$soapWhere = array();
            $whereClauses = array();
            $this->populateFromRequest();

            $like_char = '%';

            foreach($this->fields as $field => $parms) {
                if(isset($parms['value']) && $parms['value'] != "") {
                    if(is_array($parms['value'])) {
                        $whereClauses[$field] = array();
                        $tmp = array();
                        foreach($parms['value'] as $key => $val) {
                            if($val != ' ' && $val != '') {
                                $tmp[] = $val;
                                $whereClauses[$field][$val] = true;
                            }

                        }

                        $soapWhere[] = array('name'        => $parms['name'],
                                             'value_array' => $tmp,
                                             'operator'    => 'IN');
                    }
                    elseif($parms['type'] == 'int') {
                        $soapWhere[] = array('name'     => $parms['name'],
                                             'value'    => $parms['value'],
                                             'operator' => '=');
                        $whereClauses[$field] = $parms['value'];
                    }
                    else {
                        $soapWhere[] = array('name'     => $parms['name'],
                                             'value'    => $parms['value'] . '%',
                                             'operator' => 'LIKE');
                        $whereClauses[$field] = $parms['value'];
                    }

                }
            }
        } else if(isset($_REQUEST['clear'])) {
        	$soapWhere = array();
            $whereClauses = array();
        } else {
        	$soapWhere = isset($_SESSION['listviewFilters'][$module]['soapWhere']) ? $_SESSION['listviewFilters'][$module]['soapWhere'] : array();
        	$whereClauses = isset($_SESSION['listviewFilters'][$module]['whereClauses']) ? $_SESSION['listviewFilters'][$module]['whereClauses'] : array();
        	foreach($whereClauses as $name=>$value) {
        		$this->fields[$name]['value'] = $value;
        	    if( $this->fields[$name]['type'] == 'enum' || $this->fields[$name]['type'] == 'multienum' && is_array($value)) {
        	    	foreach($value as $key=>$val) {
        	    	   $_REQUEST[$name][] = $key;	
        	    	}
        	    } else {
        	    	$_REQUEST[$name] = $value;
        	    }
        	}
        	$searchFormButtonPressed = false;
        }

        if($searchFormButtonPressed) {
           $_SESSION['listviewFilters'][$this->module]['whereClauses'] = $whereClauses; // unprocessed clauses
           $_SESSION['listviewFilters'][$this->module]['soapWhere'] = $soapWhere; // processed clauses to pass to soap
        }        
        return $soapWhere;
    }

    function display() {
       global $sugar_config, $app_strings;

        if(empty($this->modStrings)){
            global $mod_strings;
            $this->modStrings = $mod_strings;
        }

        $this->th->ss->assign('app', $app_strings);
        $this->th->ss->assign('mod', $this->modStrings);
        $this->th->ss->assign('siteUrl', $sugar_config['site_url']);

        $str = '';

        require_once('modules/' . $this->module . '/metadata/searchformdefs.php');

        $totalWidth = 0;
        foreach($viewdefs[$this->module]['searchform']['basic']['templateMeta']['widths'] as $col => $def) {
            foreach($def as $k => $value) $totalWidth += $value;
        }

        foreach($viewdefs[$this->module]['searchform']['basic']['templateMeta']['widths'] as $col => $def) {
            foreach($def as $k => $value)
                $viewdefs[$this->module]['searchform']['basic']['templateMeta']['widths'][$col][$k] = $value / ($totalWidth / 100);
        }

        foreach($viewdefs[$this->module]['searchform']['basic']['data'] as $row => $rowDef) {
            $columnsInRows = count($rowDef);
            $columnsUsed = 0;
            foreach($rowDef as $col => $colDef) {
                // change just simple fieldnames to metadata arrays
                if(!is_array($viewdefs[$this->module]['searchform']['basic']['data'][$row][$col]) && $viewdefs[$this->module]['searchform']['basic']['data'][$row][$col] != '') {
                    $viewdefs[$this->module]['searchform']['basic']['data'][$row][$col] = array('field' => $viewdefs[$this->module]['searchform']['basic']['data'][$row][$col]);
                }
                if($columnsInRows < $viewdefs[$this->module]['searchform']['basic']['templateMeta']['maxColumns']) { // calculate colspans
                    if($col == $columnsInRows - 1) {
                        $viewdefs[$this->module]['searchform']['basic']['data'][$row][$col]['colspan'] = 2 * $viewdefs[$this->module]['searchform']['basic']['templateMeta']['maxColumns'] - $columnsUsed;
                    }
                    else {
                        $viewdefs[$this->module]['searchform']['basic']['data'][$row][$col]['colspan'] = floor(($viewdefs[$this->module]['searchform']['basic']['templateMeta']['maxColumns'] * 2 - $columnsInRows) / $columnsInRows);
                        $columnsUsed = $viewdefs[$this->module]['searchform']['basic']['data'][$row][$col]['colspan'];
                    }
                }
            }
        }

        $this->th->ss->assign('def', $viewdefs[$this->module]['searchform']['basic']);
        $this->th->ss->assign('module', $this->module);
        $this->th->ss->assign('fields', $this->fields);

        $str .= $this->th->displayTemplate($this->module, 'SearchForm', $this->tpl);

        return $str;
    }
    
    function useGenerateSearch($module='') {
    	if(!empty($module)) {
    	   return (!empty($_REQUEST['query']) && $_REQUEST['query']) || 
    	          (!empty($_REQUEST['clear']) && $_REQUEST['clear']) || 
    	          isset($_SESSION['listviewFilters'][$module]['soapWhere']);	
    	}
    	return false;
    }
}

?>