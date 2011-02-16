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
 //usage: initialize the tree, add nodes, generate header for required files inclusion.
 //  	  generate function that has tree data and script to convert data into tree init.
 //		  generate call to tree init function.
 //		  subsequent tree data calls will be served by the node class.  
 //		  tree view by default make ajax based calls for all requests.
require_once ('include/ytree/Tree.php');
require_once ('include/JSON.php');

class Tree {
  var $tree_style='include/ytree/TreeView/css/folders/tree.css';	
  var $_header_files=array(	
							//'include/javascript/yui/YAHOO.js',
						   	//'include/javascript/yui/log.js',
							'include/ytree/TreeView/TreeView.js',
							'include/ytree/TreeView/Node.js',							
							'include/ytree/TreeView/TextNode.js',
							'include/ytree/TreeView/RootNode.js',
							'include/ytree/TreeView/MenuNode.js',							
							'include/ytree/treeutil.js',
							'include/JSON.js',																					
					 );
					 
  var $_debug_window=false;
  var $_debug_div_name='debug_tree';
  var $_name;
  var $_nodes=array();
  var $json;
  //collection of parmeter properties;
  var $_params=array();
  				   
  function Tree($name) {
		$this->_name=$name;
		$this->json=new JSON(JSON_LOOSE_TYPE);  
  }
  
  //optionally add json.js, required for making AJAX Calls. 
  function include_json_reference($reference=null) {
  	if (empty($reference)) {
  		$this->_header_files[]='include/JSON.js';
  	} else { 
  		$this->_header_files[]=$reference;
  	} 												 
  }
           
  function add_node($node) {
  		$this->_nodes[$node->uid]=$node;
  }
  
// returns html for including necessary javascript files.
  function generate_header() {
    $ret="<link rel='stylesheet' href='{$this->tree_style}'>\n";
   	foreach ($this->_header_files as $filename) {
   		$ret.="<script language='JavaScript' src='{$filename}'></script>\n";	
   	}
	return $ret;
  }
  
//properties set here will be accessible from
//the tree's name space..
  function set_param($name, $value) {
  	if (!empty($name) && !empty($value)) {
 		$this->_params[$name]=$value;
 	}
  }
 	  
  function generate_nodes_array($scriptTags = true) {
	global $sugar_config;
	$node=null;
	$ret=array();
	foreach ($this->_nodes as $node ) {
		$ret['nodes'][]=$node->get_definition();
	}  	
	
	//todo removed site_url setting from here.
	//todo make these variables unique.	
  	$tree_data="var TREE_DATA= " . $this->json->encode($ret) . ";\n";
  	$tree_data.="var param= " . $this->json->encode($this->_params) . ";\n";  	

  	$tree_data.="var mytree;\n";
  	$tree_data.="treeinit(mytree,TREE_DATA,'{$this->_name}',param);\n";
  	if($scriptTags) return '<script>'.$tree_data.'</script>';
    else return $tree_data;
  }
}
?>
