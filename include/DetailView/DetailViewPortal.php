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

require_once('include/Sugar_Smarty.php');
require_once('include/TemplateHandler/TemplateHandler.php');

class DetailViewPortal {

    var $th;
    var $tpl;
    var $result;
    var $notes;
    var $modStrings;
    var $id;
    var $metadataFile;
    var $headerTpl;
    var $footerTpl;
    var $returnAction;
    var $returnModule;
    var $returnId;
    var $editable;

    /**
     * Creates a new detailview portal object
     *
     * @param module string Module this detail view is for
     * @param id string record id to retrieve
     * @param fields array fields to retrieves
     * @param tpl string tpl file to use
     * @param translate bool translate the drop down values
     *
     */
    function DetailViewPortal($module, $id, $metadataFile = null, $tpl = 'include/DetailView/DetailView.tpl', $translate = true) {
        global $portal;

        $this->th = new TemplateHandler();

        $this->id = $id;
        $this->tpl = $tpl;
        $this->module = $module;
        $this->modStrings = array();
        $this->metadataFile = $metadataFile;
        $this->editable = true;

        if(isset($this->metadataFile)) {
            require_once($this->metadataFile);
        }
        elseif(is_file('custom/portal/modules/' . $this->module . '/metadata/detailviewdefs.php')) {
               require_once('custom/portal/modules/' . $this->module . '/metadata/detailviewdefs.php');
        }
        else {
            require_once('modules/' . $this->module . '/metadata/detailviewdefs.php');
        }

        $this->defs = $viewdefs[$this->module]['detailview'];

        // figure out which fields to pull based off of metadata
        $fields = array();
        foreach($this->defs['data'] as $row) {
            foreach($row as $col => $def) {
                if(is_array($def))
                    $fields[$def['field']] = true;
                else
                    $fields[$def] = true;
            }
        }
        if(!empty($this->defs['templateMeta']['extraFields'])) {
            foreach($this->defs['templateMeta']['extraFields'] as $field) {
                $fields[$field] = true;
            }
        }
        $fields['id'] = true; // always get id

        // TODO: use version of getEntry that doesn't return fields
        $this->result = $portal->getEntry($module, $id, array_keys($fields));
        foreach($this->result['data'] as $name => $value) {
            $this->result['fields'][$name]['value'] = $value;
        }
        
        foreach($this->result['fields'] as $name => $def) {
            //Use the label in moduleFields.php file if it is there
            $this->modStrings[$name] = (isset($this->result['fields'][$name]) && !empty($this->result['fields'][$name]['label']))? $this->result['fields'][$name]['label'] : $def['label'];

            if($translate) {
                if(!empty($def['options'])) { // convert drop down values
                    foreach($def['options'] as $n => $v) {
                        if(!empty($this->result['data'][$name]) && $n == $this->result['data'][$name]) {
                            $this->result['fields'][$name]['value'] = $v;
                            $this->result['data'][$name] = $v;
                            break;
                        }
                    }
                }
            }
        }
    }

    function process() {
        global $mod_strings, $sugar_config, $app_strings;

        if(empty($this->modStrings)){
            $this->modStrings = $mod_strings;
        }

        $this->th->ss->assign('app', $app_strings);
        $this->th->ss->assign('mod', $this->modStrings);
        $this->th->ss->assign('fields', $this->result['fields']);
        $this->th->ss->assign('data', $this->result['data']);
        $this->th->ss->assign('siteUrl', $sugar_config['site_url']);

        $totalWidth = 0;
        foreach($this->defs['templateMeta']['widths'] as $col => $def) {
            foreach($def as $k => $value) $totalWidth += $value;
        }
        // calculate widths
        foreach($this->defs['templateMeta']['widths'] as $col => $def) {
            foreach($def as $k => $value)
                $this->defs['templateMeta']['widths'][$col][$k] = round($value / ($totalWidth / 100), 2);
        }

        foreach($this->defs['data'] as $row => $rowDef) {
            $columnsInRows = count($rowDef);
            $columnsUsed = 0;
            foreach($rowDef as $col => $colDef) {
                // change just simple fieldnames to metadata arrays
                if(!is_array($this->defs['data'][$row][$col]) && $this->defs['data'][$row][$col] != '') {
                    $this->defs['data'][$row][$col] = array('field' => $this->defs['data'][$row][$col]);
                }
                if($columnsInRows < $this->defs['templateMeta']['maxColumns']) { // calculate colspans
                    if($col == $columnsInRows - 1) {
                        $this->defs['data'][$row][$col]['colspan'] = 2 * $this->defs['templateMeta']['maxColumns'] - $columnsUsed;
                    }
                    else {
                        $this->defs['data'][$row][$col]['colspan'] = floor(($this->defs['templateMeta']['maxColumns'] * 2 - $columnsInRows) / $columnsInRows);
                        $columnsUsed = $this->defs['data'][$row][$col]['colspan'];
                    }
                }
            }
        }

        $this->th->ss->assign('returnModule', $this->returnModule);
        $this->th->ss->assign('returnAction', $this->returnAction);
        $this->th->ss->assign('returnId', $this->returnId);
        $this->th->ss->assign('def', $this->defs);
        $this->th->ss->assign('module', $this->module);
        $this->th->ss->assign('editable', $this->editable);
        $this->th->ss->assign('headerTpl', isset($this->headerTpl) ? $this->headerTpl : 'include/DetailView/header.tpl');
        $this->th->ss->assign('footerTpl', isset($this->footerTpl) ? $this->footerTpl : 'include/DetailView/footer.tpl');
    }

    function display($showTitle = true) {
        global $mod_strings;

        if($showTitle) {
            $title = $mod_strings['LBL_MODULE_NAME'] . (empty($this->result['data']['name']) ? '' : (': ' . $this->result['data']['name']));
            $str = '<p>' . get_module_title($mod_strings['LBL_MODULE_NAME'], $title, false)  . '</p>';
        }
        else {
            $str = '';
        }

        $str .= $this->th->displayTemplate($this->module, 'DetailView', $this->tpl);

        return $str;
    }

    function insertJavascript($javascript){
        $this->ss->assign('javascript', $javascript);
    }
}
?>