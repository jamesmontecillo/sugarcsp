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
require_once('include/ListView/ListViewSmarty.php');
require_once('include/ListView/ListViewDataSubpanel.php');

class SubpanelPortal extends ListViewSmarty {
    var $ss;
    var $tpl;
    var $result;
    var $parentModule;
    var $id;

    /**
     * Creates a new subpanel for portal
     *
     * @param module string Module the subpanel is for
     * @param parentModule string parent module the subpanel is related to
     * @param id string record id of the parent module
     * @param fields array fields to retrieves
     * @param tpl string tpl file to use
     *
     */
    function SubpanelPortal($module, $parentModule, $id, $fields, $tpl = 'include/ListView/ListViewGeneric.tpl') {
        require_once('modules/' . $module . '/metadata/subpanelDefs.php');

        $this->displayColumns = $viewdefs[$module]['subpanel'];
        $this->ss = new Sugar_Smarty();
        $this->tpl = $tpl;

        $this->lvd = new ListViewDataSubpanel($parentModule);
        $this->lvd->module = $module;
        $this->lvd->parentModule = $parentModule;
        $this->lvd->parentRecordId = $id;
        $this->lvd->selectFields = $fields;
    }

    function process($file, $data, $htmlVar) {
        parent::process($file, $data, $htmlVar);

        $this->ss->assign('returnModule', $this->lvd->parentModule);
        $this->ss->assign('returnAction', 'DetailView');
        $this->ss->assign('returnId', $this->lvd->parentRecordId);
    }

    function display($title) {
        $str = '<p>' . get_form_header($title, '', false)  . '</p>';

        if(empty($this->data)) {
            global $app_strings;
            return $str . '<h3>' . $app_strings['LBL_NO_RECORDS_FOUND'] . '</h3>';
        }
        else {
            return $str . parent::display();
        }
    }
}
?>