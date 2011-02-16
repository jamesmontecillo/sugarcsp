<?php
if(!defined('sugarEntry'))define('sugarEntry', true);
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
require_once('include/javascript/javascriptValidation.php');

class EditViewPortal {
    var $th;
    var $tpl;
    var $result;
    var $returnAction;
    var $returnModule;
    var $metadataFile;
    var $headerTpl;
    var $footerTpl;
    var $multipartForm = false;

    /**
     * Creates a new EditView portal object
     *
     * @param module string Module this detail view is for
     * @param id string record id to retrieve
     * @param tpl string tpl file to use
     */
    function EditViewPortal($module, $id, $metadataFile = null, $tpl = 'include/EditView/EditView.tpl', $translate = true) {
        global $portal, $mod_strings;

        $this->id = $id;
        $this->tpl = $tpl;
        $this->module = $module;
        $this->metadataFile = $metadataFile;

        if(isset($this->metadataFile)) {
            require_once($this->metadataFile);
        }
        elseif(is_file('custom/portal/modules/' . $this->module . '/metadata/editviewdefs.php')) {
               require_once('custom/portal/modules/' . $this->module . '/metadata/editviewdefs.php');
        }
        else {
            require_once('modules/' . $this->module . '/metadata/editviewdefs.php');
        }

        $this->defs = $viewdefs[$this->module]['editview'];

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
        $fields['id'] = true;

        $this->th = new TemplateHandler();
        $this->modStrings = array();
        $this->doms = array();

        $newRecord = empty($id) ? true : false;
        if($newRecord) { // no record, use the cached fields
            $this->result = array();
            $this->result['fields'] = $portal->getFields($module, true);
            $this->result['data'] = array();
        } else {
            // TODO: use version of getEntry that doesn't return fields
            $this->result = $portal->getEntry($module, $id, array_keys($fields));
            foreach($this->result['data'] as $name => $value) {
               $this->result['fields'][$name]['value'] = $value;
            }
        }

        foreach($this->result['fields'] as $name => $def) {

            //Use the label in moduleFields.php file if it is there
            $this->modStrings[$name] = (isset($this->result['fields'][$name]) && isset($this->result['fields'][$name]['label']))? $this->result['fields'][$name]['label'] : $def['label'];
            if($translate) {
                if(!empty($def['options'])) { // convert drop down values
                    foreach($def['options'] as $n => $v) {
                        if(!empty($this->result['data'][$name]) && $v == $this->result['data'][$name]) {
                            $this->result['fields'][$name]['value'] = $n; //CL Fix for 17176 (data value is set to label from server side; need to reset to key)
                            $this->result['data'][$name] = $v;
                            break;
                        }
                    }
                }
            }

            if($newRecord && isset($this->result['fields'][$name]['default_value'])) {
               $this->result['fields'][$name]['value'] = $this->result['fields'][$name]['default_value'];
            }
        } //foreach

    }

   function process() {
        global $mod_strings, $app_strings;

        if(empty($this->modStrings)){
            $this->modStrings = $mod_strings;
        }
        $this->th->ss->assign('app', $app_strings);
        $this->th->ss->assign('mod', $this->modStrings);
        $this->th->ss->assign('fields', $this->result['fields']);
        $this->th->ss->assign('data', $this->result['data']);

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

        if(!empty($_SERVER['HTTP_REFERER'])) {
            $values = explode('&', substr($_SERVER['HTTP_REFERER'], strpos($_SERVER['HTTP_REFERER'], '?') + 1));
            foreach($values as $value) {
                $keyValues = explode('=', $value);
                if($keyValues[0] == 'action') $this->returnAction = $keyValues[1];
                if($keyValues[0] == 'module') $this->returnModule = $keyValues[1];
                if($keyValues[0] == 'id' || $keyValues[0] == 'record') $this->returnId = $keyValues[1];
            }
        }


        // start smarty assignments
        $this->th->ss->assign('def', $this->defs);
        $this->th->ss->assign('module', $this->module);

        $this->th->ss->assign('returnModule', empty($this->returnModule) ? $this->module : $this->returnModule);
        $this->th->ss->assign('returnAction', empty($this->returnAction) ? 'ListView' : $this->returnAction);
        $this->th->ss->assign('returnId', empty($this->returnId) ? '' : $this->returnId);

        // form id and form name
        $this->formName = empty($this->defs['templateMeta']['formName']) ? $this->module . 'EditView' : $this->defs['templateMeta']['formName'];
        $this->formId = empty($this->defs['templateMeta']['formId']) ? $this->module . 'EditView' : $this->defs['templateMeta']['formId'];

        $this->th->ss->assign('formName', $this->formName);
        $this->th->ss->assign('formId', $this->formId);
        $this->th->ss->assign('headerTpl', isset($this->headerTpl) ? $this->headerTpl : 'include/EditView/header.tpl');
        $this->th->ss->assign('footerTpl', isset($this->footerTpl) ? $this->footerTpl : 'include/EditView/footer.tpl');
        $this->th->ss->assign('multipart', $this->multipartForm);

        if(isset($this->defs['templateMeta']['hiddenFields'])) {
           $this->th->ss->assign('hiddenFields', $this->defs['templateMeta']['hiddenFields']);
        }

        // javascript form validation
        $this->jv = new javascriptValidation($this->formName, $this->result['fields']);
        $this->jv->addAllFields();
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

        $str .= $this->th->displayTemplate($this->module, 'EditView', $this->tpl);
        $str .= $this->jv->getScript();

        return $str;
    }

}

?>