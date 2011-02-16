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

 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

global $portal;

class SavePortal {
    var $module;
 
    function SavePortal($module, $metadataFile = null) {
        $this->metadataFile = $metadataFile;
        $this->module = $module;
        
        if(isset($this->metadataFile)) {
            require_once($this->metadataFile);
        } else if(file_exists('custom/portal/modules/'. $this->module . '/metadata/editviewdefs.php')) {
            require_once('custom/portal/modules/'. $this->module . '/metadata/editviewdefs.php');
        } else {
            require_once('modules/' . $this->module . '/metadata/editviewdefs.php');
        }

        $this->defs = $viewdefs[$this->module]['editview'];
        global $portal;
        $this->fields = $portal->getFields($module, true);
    }
    
    function process() {
        if(!empty($_REQUEST['record'])) $id = $_REQUEST['record'];
        else $id = '';

        $this->nameValues = array();
        
        $valuesToSave = array();
        foreach($this->defs['data'] as $row) {
            if(is_array($row)) {
                foreach($row as $colData) {
                    if(is_array($colData)) array_push($valuesToSave, $colData['field']);
                    else array_push($valuesToSave, $colData);
                }
            }
            else {
               array_push($valuesToSave, $row);
            }
        }
        
        if(isset($this->defs['templateMeta']['hiddenFields'])) {
           foreach($this->defs['templateMeta']['hiddenFields'] as $hidden) {
           	       array_push($valuesToSave, $hidden['name']);
           }	
        }
        
        // also save hidden inputs
        if(!empty($this->defs['templateMeta']['hiddenInputs'])) {
            foreach($this->defs['templateMeta']['hiddenInputs'] as $name => $value) {
                array_push($valuesToSave, $name);
            }
        }
        
        array_push($valuesToSave, 'id');
      
        foreach($valuesToSave as $name) {
            if(isset($_REQUEST[$name])) {
               if(isset($this->fields[$name]['type']) && $this->fields[$name]['type'] == 'multienum') {
               	 $this->nameValues[] = array('name' => $name, 'value' => implode('^,^', $_REQUEST[$name]));
               } else {
                 $this->nameValues[] = array('name' => $name, 'value' => $_REQUEST[$name]);
               } //if-else
            } //if
        } //foreach
    }

    function save($redirect = true) {
        global $portal;
       
        $result = $portal->save($this->module, $this->nameValues);
        
        if($redirect) {
            if(!empty($_REQUEST['returnmodule']) && !empty($_REQUEST['returnaction']) && !empty($result['id'])) {
                $header = 'index.php?module=' . $_REQUEST['returnmodule'] . '&action=' . $_REQUEST['returnaction'] . '&id=' . $result['id'];
            }
            else {
                $header = 'index.php?module=' . $this->module . '&action=index';
            }
            
            header('Location: ' . $header);        
        }
        
        return $result;
    }   
}


?>