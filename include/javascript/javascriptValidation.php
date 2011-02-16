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

 ********************************************************************************/
require_once('include/SugarFields/SugarFieldHandler.php');

class javascriptValidation {
	var $formname = 'form';
    var $fields;
    
    /**
     * 
     * @param formname string name of the form being validated
     * @param fields array all the fields for the object 
     **/
    function javascriptValidation($formname, $fields) {
        global $app_strings;
        $this->script = "requiredTxt = '{$app_strings['ERR_MISSING_REQUIRED_FIELDS']}';\n";
        $this->script .= "invalidTxt = '{$app_strings['ERR_INVALID_VALUE']}';\n";
        
        $this->formname = $formname;
        $this->fields = $fields;
        $this->sfh = new SugarFieldHandler();
    }
    
    
	function setFormName($name){
		$this->formname = $name;
	}
	
	function addField($fieldName, $def) {
		$this->script .= $this->sfh->displayJSValidation($def, $this->formname);
	}

	function addFieldGeneric($field, $type,$displayName, $required, $prefix=''){
		$this->script .= "addToValidate('".$this->formname."', '".$prefix.$field."', '".$type . "', $required,'". $this->stripEndColon(translate($displayName)) . "' );\n";
	}
	function addFieldRange($field, $type,$displayName, $required, $prefix='',$min, $max){
		$this->script .= "addToValidateRange('".$this->formname."', '".$prefix.$field."', '".$type . "', $required,'".$this->stripEndColon(translate($displayName)) . "', $min, $max );\n";
	}
	
	function addFieldDateBefore($field, $type,$displayName, $required, $prefix='',$compareTo){
		$this->script .= "addToValidateDateBefore('".$this->formname."', '".$prefix.$field."', '".$type . "', $required,'".$this->stripEndColon(translate($displayName)) . "', '$compareTo' );\n";
	}

	function addFieldDateBeforeAllowBlank($field, $type, $displayName, $required, $prefix='', $compareTo, $allowBlank='true'){
		$this->script .= "addToValidateDateBeforeAllowBlank('".$this->formname."', '".$prefix.$field."', '".$type . "', $required,'".$this->stripEndColon(translate($displayName)) . "', '$compareTo', '$allowBlank' );\n";
	}
	
	function addToValidateBinaryDependency($field, $type, $displayName, $required, $prefix='',$compareTo){
		$this->script .= "addToValidateBinaryDependency('".$this->formname."', '".$prefix.$field."', '".$type . "', $required,'".$this->stripEndColon(translate($displayName)) . "', '$compareTo' );\n";
	}

	function addAllFields($skip_fields = array()){

		foreach($this->fields as $fieldName => $def){
			if(!isset($skip_fields[$fieldName])) {
				if(isset($def['type'])) {
					if($def['type'] != 'link') {		
			  			$this->addField($fieldName, $def);
					}
				}
			}
		}
	}

	function getScript($showScriptTag = true){
        if($showScriptTag){
            $this->script = '<script type="text/javascript">' . $this->script . '</script>';
        }

        return $this->script;
	}
}
?>
