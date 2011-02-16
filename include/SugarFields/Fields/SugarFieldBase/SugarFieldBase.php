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
/**
 * SugarFieldBase translates and displays fields from a vardef definition into different formats
 * including DetailView, ListView, EditView. It also provides Search Inputs and database queries
 * to handle searching
 *
 */
class SugarFieldBase {
    var $ss; // Sugar Smarty Object

    function SugarFieldBase() {
        $this->ss = new Sugar_Smarty();
    }

    function ListView($vardef) {
        $this->ss->assign('vardef', $vardef);

        return $this->ss->fetch('include/SugarFields/Fields/SugarFieldBase/SugarFieldBaseListView.tpl');
    }

    /**
     * Returns a smarty template for the DetailViews
     *
     * @param parentFieldArray string name of the variable in the parent template for the bean's data
     * @param vardef vardef field defintion
     * @param displayParam parameters for display
     *      available paramters are:
     *      * labelSpan - column span for the label
     *      * fieldSpan - column span for the field
     */
    function getDetailViewSmarty($parentFieldArray, $vardef, $displayParams) {
        $this->setup($parentFieldArray, $vardef, $displayParams);

        return $this->ss->fetch('include/SugarFields/Fields/SugarFieldBase/SugarFieldBaseDetailViewSmarty.tpl');
    }

    function getEditViewSmarty($parentFieldArray, $vardef, $displayParams) {
        $this->setup($parentFieldArray, $vardef, $displayParams);

        return $this->ss->fetch('include/SugarFields/Fields/SugarFieldBase/SugarFieldBaseEditViewSmarty.tpl');
    }

    function getSearchFormSmarty($parentFieldArray, $vardef, $displayParams) {
        $this->setup($parentFieldArray, $vardef, $displayParams);

        return $this->ss->fetch('include/SugarFields/Fields/SugarFieldBase/SugarFieldBaseSearchFormSmarty.tpl');
    }

    function getEditView() {
    }

    function getSearchInput() {
    }

    function getQueryLike() {
    }

    function getQueryIn() {
    }

    function getJSValidation($vardef, $formname, $displayParams) {
        if($vardef['required'] == '0') $required = 'false';
        else $required = 'true';

        return "addToValidate('{$formname}', '{$vardef['name']}', '{$vardef['type']}', {$required}, '{$vardef['label']}');\n";
    }

    /**
     * Setup function to assign values to the smarty template, should be called before every display function
     */
    function setup($parentFieldArray, $vardef, $displayParams) {
        $this->ss->assign('parentFieldArray', $parentFieldArray);
        $this->ss->assign('vardef', $vardef);
        $this->ss->assign('displayParams', $displayParams);
        $this->ss->assign('theme', $GLOBALS['theme']);
    }
}
?>
