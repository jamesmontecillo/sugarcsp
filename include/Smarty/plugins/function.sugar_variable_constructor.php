<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {sugar_variable_constructor} function plugin
 *
 * Type:     function<br>
 * Name:     sugar_variable_constructor<br>
 * Purpose:  creates a smarty variable from the parameters
 * 
 * @author Wayne Pan {wayne at sugarcrm.com}
 * @param array
 * @param Smarty
 */

function smarty_function_sugar_variable_constructor($params, &$smarty)
{
    if (!isset($params['objectName']) || !isset($params['memberName']) || !isset($params['key'])) {
        if(!isset($params['objectName']))  
            $smarty->trigger_error("sugar_variable_constructor: missing 'objectName' parameter");
        if(!isset($params['memberName']))  
            $smarty->trigger_error("sugar_variable_constructor: missing 'memberName' parameter");
        if(!isset($params['key']))  
            $smarty->trigger_error("sugar_variable_constructor: missing 'key' parameter");
        return;
    }

    $displayParams = $smarty->get_template_vars('displayParams');
    
    if(isset($params['stringFormat'])) {
        $_contents =  '$'. $params['objectName'] . '.' . $params['memberName'] . '.' . $params['key'];
    } else {
        $_contents = '{$' . $params['objectName'] . '.' . $params['memberName'] . '.' . $params['key'] . (!empty($displayParams['url2html']) ? '|url2html' : '') . (!empty($displayParams['nl2br']) ? '|nl2br' : '') . '}';
    }
    return $_contents;
}
?>
