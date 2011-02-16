<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {sugar_evalcolumn} function plugin
 *
 * Type:     function<br>
 * Name:     sugar_evalcolumn<br>
 * Purpose:  evaluate a string by substituting values in the rowData parameter. Used for ListViews<br>
 * 
 * @author Wayne Pan {wayne at sugarcrm.com
 * @param array
 * @param Smarty
 */
function smarty_function_sugar_evalcolumn($params, &$smarty)
{
    if (!isset($params['var']) || !isset($params['rowData'])) {
        if(!isset($params['var']))  
            $smarty->trigger_error("evalcolumn: missing 'var' parameter");
        if(!isset($params['rowData']) && !isset($params['fields']))  
            $smarty->trigger_error("evalcolumn: missing 'rowData or fields' parameter");
        return;
    }

    if(!isset($params['fields'])) $params['fields'] = array();
    if(!isset($params['rowData'])) $params['rowData'] = array();

    if($params['var'] == '') {
        return;
    }

    if(is_array($params['var'])) {
        foreach($params['var'] as $key => $value) {
            $params['var'][$key] = searchReplace($value, $params['rowData'], $params['fields']);
        }
    }
    else {
        $params['var'] = searchReplace($params['var'], $params['rowData'], $params['fields']);
    }

    if(isset($params['toJSON'])) {
        $json = getJSONobj();
        $params['var'] = $json->encode($params['var']);
    }
    
    if (!empty($params['assign'])) {
        $smarty->assign($params['assign'], $params['var']);
    } else {
        return $params['var'];
    }
}

function searchReplace($value, &$rowData, &$fields) {
    preg_match_all('/\{\$(.*)\}/U', $value, $matches);

    for($wp = 0; $wp < count($matches[0]); $wp++) {
        if(isset($rowData[$matches[1][$wp]])) { 
            $value = str_replace($matches[0][$wp], $rowData[$matches[1][$wp]], $value);
        }
        elseif(isset($fields[$matches[1][$wp]]['value'])) { 
            $value = str_replace($matches[0][$wp], $fields[$matches[1][$wp]]['value'], $value);
        }
        elseif(strpos($value, 'language.', 0)) {
            $value = str_replace($matches[0][$wp], translate(strtoupper(substr($matches[1][$wp], 9))), $value);
        }
        else { 
            $value = str_replace($matches[0][$wp], '', $value);
        }
    }
    return $value;
}
?>