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

class ListViewData {
    var $additionalDetails = true;
    var $additionalDetailsAllow = null;
    /**
     * Constructor sets the limitName to look up the limit in $sugar_config 
     *
     * @return ListViewData
     */
    function ListViewData() {
        $this->limitName = 'list_max_entries_per_page';
    }
    
    /**
     * checks the request for the order by and if that is not set then it checks the session for it
     *
     * @return array containing the keys orderBy => field being ordered off of and sortOrder => the sort order of that field
     */
    function getOrderBy() {
        $orderBy = '';
        $direction = '';
        //BEGIN SUGAR INT ONLY
        /*
        _pp($_REQUEST);
        _pp($this->var_order_by);
        if(isset($_SESSION['lvd'])) {
        _pp($_SESSION['lvd']['last_ob']);
        }
        */
        //END SUGAR INT ONLY
        if (!empty($_REQUEST[$this->var_order_by])) {
            $direction = 'ASC';
            $orderBy = $_REQUEST[$this->var_order_by]; 
            /*
            if(!empty($_REQUEST['lvso']) && (empty($_SESSION['lvd']['last_ob']) || strcmp($orderBy, $_SESSION['lvd']['last_ob']) == 0) ){
                $direction = $_REQUEST['lvso'];
            }
            */
            if(!empty($_REQUEST[$this->var_lvso]) && (empty($_SESSION['lvd']['last_ob'][$this->var_lvso]) || strcmp($orderBy, $_SESSION['lvd']['last_ob'][$this->var_lvso]) == 0) ){
                $direction = $_REQUEST[$this->var_lvso];
            }            
            $_SESSION[$this->var_order_by] = array('orderBy'=>$orderBy, 'direction'=> $direction);
            $_SESSION['lvd']['last_ob'][$this->var_lvso] = $orderBy;
        } 
        else {
            if(!empty($_SESSION[$this->var_order_by])) {
                $orderBy = $_SESSION[$this->var_order_by]['orderBy'];
                $direction = $_SESSION[$this->var_order_by]['direction'];
            }
        }
        return array('orderBy' => $orderBy, 'sortOrder' => $direction);
    }
    
    /**
     * gets the reverse of the sort order for use on links to reverse a sort order from what is currently used
     *
     * @param STRING (ASC or DESC) $current_order
     * @return  STRING (ASC or DESC)
     */
    function getReverseSortOrder($current_order){
        return (strcmp(strtolower($current_order), 'asc') == 0)?'DESC':'ASC';
    }
    /**
     * gets the limit of how many rows to show per page
     *
     * @return INT (the limit)
     */
    function getLimit() {
        return $GLOBALS['sugar_config'][$this->limitName];
    }

    /**
     * returns the current offset
     *
     * @return INT (current offset)
     */
    function getOffset() {
        return (!empty($_REQUEST[$this->var_offset])) ? $_REQUEST[$this->var_offset] : 0;
    }
    
    /**
     * generates the base url without 
     * any files in the block variables will not be part of the url 
     * 
     *
     * @return STRING (the base url)
     */
    function getBaseURL() {
        static $base_url;
        if(!empty($base_url)) return $base_url;
        $blockVariables = array('clear', 'mass', 'uid', 'massupdate', 'delete', 'merge', 'selectCount',$this->var_order_by, $this->var_offset, 'lvso', 'sortOrder', 'orderBy');
        $base_url = 'index.php?';
        
        if(!empty($_SESSION['listviewFilters'][$this->module]['whereClauses'])) {
           $blockVariables = array_merge($blockVariables, array_keys($_SESSION['listviewFilters'][$this->module]['whereClauses']));
        }

        foreach(array_merge($_POST, $_GET) as $name=>$value) {
        	if(!in_array($name, $blockVariables)) { 
                if(is_array($value)) {
                    foreach($value as $v) {
                        $base_url .= $name.'='.urlencode($v) . '&';
                    }
                }
                else {
                    $base_url .= $name.'='.urlencode($value) . '&';
                }
            }
        }
        return $base_url;
    }
    /**
     * based off of a base name it sets base, offset, and order by variable names to retrieve them from requests and sessions
     *
     * @param unknown_type $baseName
     */
    function setVariableName($baseName){
        $this->var_name = $_REQUEST['module'] .'2_'. strtoupper($baseName);
        $this->var_order_by = $this->var_name .'_ORDER_BY';
        $this->var_offset = $this->var_name . '_offset';
        $this->var_lvso = $this->var_name . '_lvso';
    }
    

    /*

    */
    /**
     * takes in a seed and creates the list view query based off of that seed 
     * if the $limit value is set to -1 then it will use the default limit and offset values
     * 
     * it will return an array with two key values
     *  1. 'data'=> this is an array of row data
     *  2. 'pageData'=> this is an array containg three values
     *          a.'ordering'=> array('orderBy'=> the field being ordered by , 'sortOrder'=> 'ASC' or 'DESC')
     *          b.'urls'=>array('baseURL'=>url used to generate other urls , 
     *                          'orderBy'=> the base url for order by
     *                          //the following may not be set (so check empty to see if they are set)
     *                          'nextPage'=> the url for the next group of results, 
     *                          'prevPage'=> the url for the prev group of results,
     *                          'startPage'=> the url for the start of the group,
     *                          'endPage'=> the url for the last set of results in the group
     *          c.'offsets'=>array(
     *                              'current'=>current offset
     *                              'next'=> next group offset
     *                              'prev'=> prev group offset
     *                              'end'=> the offset of the last group
     *                              'total'=> the total count (only accurate if totalCounted = true otherwise it is either the total count if less than the limit or the total count + 1 )
     *                              'totalCounted'=> if a count query was used to get the total count
     *
     * @param SugarBean $seed
     * @param string $where
     * @param int:0 $offset
     * @param int:-1 $limit
     * @param string[]:array() $filter_fields
     * @param array:array() $params
     *  Potential $params are 
        $params['distinct'] = use distinct key word
        $params['include_custom_fields'] = (on by default)
     * @param string:'id' $id_field
     * @return array('data'=> row data 'pageData' => page data information 
     */
    function getListViewData($module, $where, $offset=-1, $limit = -1, $filter_fields=array(),$params=array(),$id_field = 'id') {
        global $current_user;
        
        $this->module = $module;
        
        if(isset($params) && isset($params['list_id'])) {
           $this->setVariableName($this->module . $params['list_id']);
        } else {
           $this->setVariableName($this->module);
        }
        $order = $this->getOrderBy(); // retreive from $_REQUEST
        
        // if $params tell us to override all ordering
        if((!empty($params['overrideOrder']) && $params['overrideOrder']) && !empty($params['orderBy'])) {
            $order['orderBy'] = $params['orderBy'];
            $order['sortOrder'] =  (empty($params['sortOrder']) ? '' : $params['sortOrder']);
        }  
        
        if(empty($order['orderBy']) && !empty($userPreferenceOrder)) {
            $order = $userPreferenceOrder;
        } 
        // still empty? try to use settings passed in $param 
        if(empty($order['orderBy']) && !empty($params['orderBy'])) {
            $order['orderBy'] = $params['orderBy'];
            $order['sortOrder'] =  (empty($params['sortOrder']) ? '' : $params['sortOrder']); 
        }
        
        if(empty($order['orderBy'])) {
            $orderBy = '';
        }
        else {
            $orderBy = $order['orderBy'] . ' ' . $order['sortOrder'];
        }
        
        $data = array();
        $pageData = array();
        $pageData['tag'] = array();

        $rows = array();
        $count = 0; 
        
        $offset = $this->getOffset();
        $result = $this->getData($this->module, $where, $orderBy, $offset, $limit+1);
        
        
        // process the data
        $pageData['labels'] = array(); // save all the labels
        $pageData['doms'] = array(); // save all the dom values
        $pageData['checkboxes'] = array(); // save all the dom values
        foreach($result['field_list'] as $num => $object) {
            $pageData['labels'][$object['name']] = $object['label'];
            if(!empty($object['options'])) {
                $pageData['doms'][$object['name']] = array();
                foreach($object['options'] as $optionsNum => $nameValue) {
                    $pageData['doms'][$object['name']][$nameValue['name']] = $nameValue['value'];
                } 
            }
            if($object['type'] == 'bool') {
                $pageData['checkboxes'][strtoupper($object['name'])] = true;
            }
        }

        // replace all dom values with their actual values
        foreach($result['entry_list'] as $num => $object) {
            if(isset($object['id'])){
                $data[$object['id']] = array('ID' => $object['id']);
                foreach($object['name_value_list'] as $item => $name_value) {
                    if(!empty($pageData['doms'][$name_value['name']]) && !empty($pageData['doms'][$name_value['name']][$name_value['value']])) { // check if this is a drop down value
                        $data[$object['id']][strtoupper($name_value['name'])] = $pageData['doms'][$name_value['name']][$name_value['value']];
                    }
                    else {
                        $data[$object['id']][strtoupper($name_value['name'])] = $name_value['value'];
                    }
                    $pageData['tag'][$object['id']] = array('MAIN' => 'a'); 
                }
                $count++;
            }
        }

        $nextOffset = -1;
        $prevOffset = -1;
        $endOffset = -1;
        if($count > $limit) {
            array_pop($data); // eliminate the last one because we requested 1 more than the limit
            $nextOffset = $offset + $limit;
        }
        
        if($offset > 0) {
            $prevOffset = $offset - $limit;
            if($prevOffset < 0)$prevOffset = 0;
        }
        
        $totalCount = $count + $offset;
        $totalCounted = false;
        
        $endOffset = (floor(($totalCount - 1) / $limit)) * $limit;
        $pageData['ordering'] = $order;
        $pageData['urls'] = $this->generateURLS($pageData['ordering']['sortOrder'], $offset, $prevOffset, $nextOffset,  $endOffset, $totalCounted);
        $pageData['offsets'] = array( 'current'=>$offset, 'next'=>$nextOffset, 'prev'=>$prevOffset, 'end'=>$endOffset, 'total'=>$totalCount, 'totalCounted'=>$totalCounted);
        
        $pageData['module'] = $this->module;

        return array('data'=>$data , 'pageData'=>$pageData);
    }


    function getData($module, $where, $orderBy, $offset, $limit) {
        global $portal;
        $result = $portal->getEntries($module, $where, $orderBy, $offset, $limit);

        return $result;
    }   
    /**
     * generates urls for use by the display  layer
     *
     * @param int $sortOrder
     * @param int $offset
     * @param int $prevOffset
     * @param int $nextOffset
     * @param int $endOffset
     * @param int $totalCounted
     * @return array of urls orderBy and baseURL are always returned the others are only returned  according to values passed in.
     */
    function generateURLS($sortOrder, $offset, $prevOffset, $nextOffset, $endOffset, $totalCounted) {
        $urls = array();
        $urls['baseURL'] = $this->getBaseURL(). "$this->var_lvso=" . $this->getReverseSortOrder($sortOrder). '&';
        //$urls['baseURL'] = "$this->var_lvso=" . $this->getReverseSortOrder($sortOrder). '&';
        $urls['orderBy'] = $urls['baseURL'] .$this->var_order_by.'=';

        $dynamicUrl = '';
        if($nextOffset > -1) {
            $urls['nextPage'] = $urls['baseURL'] . $this->var_offset . '=' . $nextOffset . $dynamicUrl;
        }
        if($offset > 0) {
            $urls['startPage'] = $urls['baseURL'] . $this->var_offset . '=0' . $dynamicUrl;
        }
        if($prevOffset > -1) {
            $urls['prevPage'] = $urls['baseURL'] . $this->var_offset . '=' . $prevOffset . $dynamicUrl;
        }
        if($totalCounted) {
            $urls['endPage'] = $urls['baseURL'] . $this->var_offset . '=' . $endOffset . $dynamicUrl;
        }
                
        return $urls;
    }
    
    /**
     * generates the additional details values
     *
     * @param unknown_type $fields
     * @param unknown_type $adFunction
     * @param unknown_type $editAccess
     * @return unknown
     */
    function getAdditionalDetails($fields, $adFunction, $editAccess) {
            global $app_strings, $image_path, $theme;
            
            if(empty($GLOBALS['image_path'])) {
               global $theme;
                $GLOBALS['image_path'] = 'themes/'.$theme.'/images/';
            }


            $results = $adFunction($fields);
            $results['string'] = str_replace(array("&#039", "'"), '\&#039', $results['string']); // no xss!

            if(trim($results['string']) == '') $results['string'] = $app_strings['LBL_NONE'];
            $extra = "<span onmouseover=\"return overlib('" . 
                str_replace(array("\rn", "\r", "\n"), array('','','<br />'), $results['string'])
                . "', CAPTION, '<div style=\'float:left\'>{$app_strings['LBL_ADDITIONAL_DETAILS']}</div><div style=\'float: right\'>";
            if($editAccess) $extra .= (!empty($results['editLink']) ? "<a title=\'{$app_strings['LBL_EDIT_BUTTON']}\' href={$results['editLink']}><img style=\'margin-top: 2px\' border=0 src={$image_path}edit_inline.gif></a>" : '');
            $extra .= (!empty($results['viewLink']) ? "<a title=\'{$app_strings['LBL_VIEW_BUTTON']}\' href={$results['viewLink']}><img style=\'margin-left: 2px; margin-top: 2px\' border=0 src={$image_path}view_inline.gif></a>" : '')
                . "</div>', DELAY, 200, STICKY, MOUSEOFF, 1000, WIDTH, " 
                . (empty($results['width']) ? '300' : $results['width']) 
                . ", CLOSETEXT, '<img border=0 src={$image_path}close_inline.gif>', "
                . "CLOSETITLE, '{$app_strings['LBL_ADDITIONAL_DETAILS_CLOSE_TITLE']}', CLOSECLICK, FGCLASS, 'olFgClass', "
                . "CGCLASS, 'olCgClass', BGCLASS, 'olBgClass', TEXTFONTCLASS, 'olFontClass', CAPTIONFONTCLASS, 'olCapFontClass', CLOSEFONTCLASS, 'olCloseFontClass');\" "
                . "onmouseout=\"return nd(1000);\"><img style='padding: 0px 5px 0px 2px' border='0' src='themes/$theme/images/MoreDetail.png' width='8' height='7'></span>";

            return array('fieldToAddTo' => $results['fieldToAddTo'], 'string' => $extra.'&nbsp;'.$fields[$results['fieldToAddTo']].'</a>');
    }


}