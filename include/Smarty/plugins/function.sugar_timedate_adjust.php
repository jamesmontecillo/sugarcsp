<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {sugar_timedate_adjust} function plugin
 *
 * Type:     function<br>
 * Name:     sugar_timedate_adjust<br>
 * Purpose:  Adjustments for timedate objects
 * 
 * @author Wayne Pan {wayne at sugarcrm.com}
 * @param array
 * @param Smarty
 */

function smarty_function_sugar_timedate_adjust($params, &$smarty)
{
    if (!isset($params['timedate']) || !isset($params['adjustment'])) {
        if(!isset($params['timedate']))
            $smarty->trigger_error("sugar_field: missing 'timedate' parameter");
        if(!isset($params['adjustment']))  
            $smarty->trigger_error("sugar_field: missing 'adjustment' parameter");
                             
        return;
    }

    $td = explode(' ', $params['timedate']);
    $date = explode('-', $td[0]);
    $time = explode(':', $td[1]);
    // get offset between gmt and server
    $displayTime = mktime($time[0], $time[1], $time[2], $date[1], $date[2], $date[0]) + $params['adjustment'];

    return date('Y-m-d H:i:s', $displayTime);
}
?>
