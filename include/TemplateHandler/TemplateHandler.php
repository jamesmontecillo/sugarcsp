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
 * TemplateHandler builds templates using SugarFields and a generic view.
 * Currently it handles EditViews and DetailViews. It creates a smarty template cached in
 * cache/modules/moduleName/view
 *
 */

class TemplateHandler {
    var $cacheDir  = 'cache/';
    var $templateDir = 'modules/';
    var $ss;

    function TemplateHandler() {
        $this->ss = new Sugar_Smarty();
//        $this->ss->debugging = true;
//        $this->ss->debug_tpl = 'include/Smarty/debug.tpl';
    }

    /**
     * Builds a template
     *
     * @param module string module name
     * @param view string view need (eg DetailView, EditView, etc)
     * @param tpl string generic tpl to use
     */
    function buildTemplate($module, $view, $tpl) {

        $cacheDir = create_cache_directory($this->templateDir. $module . '/');
        $file = $cacheDir . $view . '.tpl';
        $string = '{* Create Date: ' . date('Y-m-d H:i:s') . "*}\n";
        $string .= $this->ss->fetch($tpl);

        if($fh = @fopen($file, 'w')) {
            fputs($fh, $string, strlen($string) );
            fclose($fh);
        }
    }

    /**
     * Checks if a template exists
     *
     * @param module string module name
     * @param view string view need (eg DetailView, EditView, etc)
     */
    function checkTemplate($module, $view) {
        return false;
        //return file_exists($this->cacheDir . $this->templateDir . $module . '/' .$view . '.tpl');
    }

    /**
     * Retreives and displays a template
     *
     * @param module string module name
     * @param view string view need (eg DetailView, EditView, etc)
     * @param tpl string generic tpl to use
     */
    function displayTemplate($module, $view, $tpl) {
        if(!$this->checkTemplate($module, $view)) {
            $this->buildTemplate($module, $view, $tpl);
        }
        return $this->ss->fetch($this->cacheDir . $this->templateDir . $module . '/' . $view . '.tpl');
    }

    /**
     * Deletes an existing template
     *
     * @param module string module name
     * @param view string view need (eg DetailView, EditView, etc)
     */
    function deleteTemplate($module, $view) {
        if(is_file($this->cacheDir . $this->templateDir . $module . '/' .$view . '.tpl')) {
            return unlink($this->cacheDir . $this->templateDir . $module . '/' .$view . '.tpl');
        }
        return false;
    }
}
?>
