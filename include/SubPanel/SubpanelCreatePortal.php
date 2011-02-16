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
require_once('include/EditView/EditViewPortal.php');

class SubpanelCreatePortal extends EditViewPortal {
    var $ss;
    var $tpl;
    var $result;

    /**
     * Creates a new Subpanel Create object
     *
     * @param module string Module this detail view is for
     * @param id string record id to retrieve
     * @param fields array fields to retrieves
     * @param tpl string tpl file to use
     */
    function SubpanelCreatePortal($module, $parentId, $fields, $tpl, $translate = true) {
        global $portal;

        $this->ss = new Sugar_Smarty();

        $this->parentId = $parentId;
        $this->tpl = $tpl;
        $this->module = $module;
        $this->modStrings = array();
        $this->doms = array();

        $this->result = array();
        $this->result['fields'] = $portal->getFields($module, true);
        $this->result['data'] = array();

        foreach($this->result['fields'] as $name => $def) {
            $this->modStrings[$name] = $def['label'];
            if($translate) {
                if(!empty($def['options'])) { // convert drop down values
                    foreach($def['options'] as $n => $v) {
                        if(!empty($this->result['data'][$name]) && $n == $this->result['data'][$name]) {
                            $this->result['data'][$name] = $v;
                            break;
                        }
                    }
                }
            }
        }
    }

   function display($showTitle = true) {
        global $mod_strings;

        $this->ss->assign('module', $this->module);
        $this->ss->assign('mod', $this->modStrings);
        $this->ss->assign('fields', $this->result['fields']);
        $this->ss->assign('data', $this->result['data']);
        $this->ss->assign('parentId', $this->parentId);

        if($showTitle) {
            $title = $mod_strings['LBL_MODULE_NAME'] . (empty($this->result['data']['name']) ? '' : (': ' . $this->result['data']['name']));
            $str = '<p>' . get_module_title($mod_strings['LBL_MODULE_NAME'], $title, false)  . '</p>';
        }
        else {
            $str = '';
        }
        $str .= $this->ss->fetch($this->tpl);
        return $str;
    }

}

?>