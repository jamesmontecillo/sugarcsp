<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty modifier to convert multienum separated value to Array
 *
 * Type:     modifier<br>
 * Name:     multienum_to_array<br>
 * Purpose:  Utility to transform multienum String to Array format
 * @author   Collin Lee <clee at sugarcrm dot com>
 * @param string The multienum field's value(s) as a String
 * @param default The multienum field's default value
 * @return Array
 */
function smarty_modifier_multienum_to_array($string, $default)
{
	if(!isset($string) || empty($string)) {
	   return array($default);	
	}
	
	return explode('^,^', $string);
}

?>
