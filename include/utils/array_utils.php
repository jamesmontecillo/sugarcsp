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


//to_string methods to get strings for values

 // var_export gets rid of the empty values that we use to display None 	 
 // thishelper function fixes that 	 
function var_export_helper($tempArray) {
	if(!is_array($tempArray)){
		return var_export($tempArray, true);	
	}
	
     $addNone = 0; 	 
 
     foreach($tempArray as $key=>$val) 	 
     { 	 
             if($key == '' && $val == '') 	 
                     $addNone = 1; 	 
     } 	 
 
     $newArray = var_export($tempArray, true); 	 
 
     if($addNone) 	 
     { 	 
             $newArray = str_replace("array (", "array ( '' => '',", $newArray); 	 
     } 	 
 
     return $newArray; 	 
} 



//this function is used to overide a value in an array and returns the string code to write
function override_value_to_string($array_name, $value_name, $value){
	$string = "\${$array_name}[". var_export($value_name, true). "] = ";
	$string .= var_export_helper($value,true);
	return $string . ";";
}

function add_blank_option($options){
	if(!isset($options['']) && !isset($options['0']))
		$options = array_merge(array(''=>''), $options);
	return $options;
}

// This function iterates through the given arrays and combines the values of each key, to form one array
// Returns FALSE if number of elements in the arrays do not match; otherwise, returns merged array
// Example: array("a", "b", "c") and array("x", "y", "z") are passed in; array("ax", "by", "cz") is returned
function array_merge_values($arr1, $arr2) {
	if (count($arr1) != count($arr2)) {
		return FALSE;
	}

	for ($i = 0; $i < count($arr1); $i++) {
		$arr1[$i] .= $arr2[$i];
	}

	return $arr1;
}
?>