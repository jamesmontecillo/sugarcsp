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

require_once("include/templates/Template.php");

class TemplateDragDropChooser extends Template {
    var $args;
    function TemplateDragDropChooser() {
    }

/*
 * This function creates the html and uses the args parameter to call the class file
 * ideally, you would want to call the displayScriptTags() function, 
 * followed by the displayDefinitionScript();
 * and lastly call the display function 
 */
    function display(){

  /*   valid entries for expected arguments array are as follow:
   *   args['left_header'] = value of left table header
   *   args['mid_header'] = value of middle table header
   *   args['right_header'] = value of right table header
   *   args['left_data'] = array to use in left data.
   *   args['mid_data'] = array to use in middle data.   
   *   args['right_data'] =array to use in right data.
   *   args['title'] =  title (if any) to be used.
   *   args['classname'] =  name to be used as class. This helps when defining multiple templates on one screen.
   *   args['left_div_name'] = Name to be used for left div (should be unique)
   *   args['mid_div_name'] = Name to be used for middle div (should be unique)
   *   args['right_div_name'] = Name to be used for right div (should be unique)
   *   args['gridcount'] = Number of grids to show.  Acceptable Values are 'one','two' and 'three'
   *                       The string is converted to numeric values, so you could also set these directly  
   *                       The values are Zero Based, so to display one column, set to '0'
   *                       To display two columns set to '1', to display three columns set to '2'.
   * $this->args['return_array']= if this is set to true, then 'display()' function returns html and javascript
   *                              in array format.  This will allow granular control of html so that you can
   *                              seperate the tables and customize the grid   
   */    
   
 
        //convert values for gridcount in case they are in string form
        if($this->args['gridcount'] == 'one'){
            $this->args['gridcount'] = 0;
        }elseif($this->args['gridcount'] == 'two'){
            $this->args['gridcount'] = 1;
        }elseif(
            $this->args['gridcount'] == 'three'){$this->args['gridcount'] = 2;
        }
 
        if(!isset($this->args['classname']) || empty($this->args['classname'])){
            $this->args['classname'] = 'DragDropGrid';
        }
        $json = getJSONobj();
        //use Json to encode the arrays of data, for passing to javascript.
        //we will always display at least one column, so set left column
        $data0_enc = $json->encode($this->args['left_data']);
        $left_div_name = $this->args['left_div_name'];
        
        //if count is set to 1, then we are displaying two columns, set the 2 column variables
        if($this->args['gridcount']==1){
            $data1_enc = $json->encode($this->args['right_data']);
            $right_div_name = $this->args['right_div_name'];
        }        
        
        //if count is set to 2, then we are displaying three columns, set the 3 column variables
        if($this->args['gridcount']==2){
            $data1_enc = $json->encode($this->args['mid_data']);
            $mid_div_name = $this->args['mid_div_name'];
            $data2_enc = $json->encode($this->args['right_data']);
            $right_div_name = $this->args['right_div_name'];
        }
        $html_str_arr = array();
        //create the table, with the divs that will get populated.  Populate both the string and array version
         $html_str  =   "<div id='" . $this->args['classname'] . "'><table  align='left'  width='180px' border='1' cellspacing='0' cellpadding='0'>";
         $html_str_arr['begin'] = $html_str;
         $html_str .=   "<tr><td width='180px' class='tabDetailViewDF'><div id='$left_div_name' class='ygrid-mso' style='width:180px;height:270px;overflow:hidden;'> </div></td>";
         $html_str_arr['left'] = "<tr><td width='180px' class='tabDetailViewDF'><div id='$left_div_name' class='ygrid-mso' style='width:180px;height:270px;overflow:hidden;'> </div></td>";
        //set the middle column only if we are displaying 3 columns
         if($this->args['gridcount']==2){                        
            $html_str .=   "<td width='180px' class='tabDetailViewDF'><div id='$mid_div_name' class='ygrid-mso' style='width:180px;height:270px;overflow:hidden;'> </div></td>";
            $html_str_arr['middle'] = "<td width='180px' class='tabDetailViewDF'><div id='$mid_div_name' class='ygrid-mso' style='width:180px;height:270px;overflow:hidden;'> </div></td>";
         }
         //set the right column if we are not in 1 column only mode
         if($this->args['gridcount']>0){                        
            $html_str .=   "<td width='180px' class='tabDetailViewDF'><div id='$right_div_name' class='ygrid-mso' style='width:180px;height:270px;overflow:hidden;'> </div></td>";
            $html_str_arr['right'] = "<td width='180px' class='tabDetailViewDF'><div id='$right_div_name' class='ygrid-mso' style='width:180px;height:270px;overflow:hidden;'> </div></td>";
         }
         $html_str .=   "</tr></table></div>";
         $html_str_arr['end'] = "</tr></table></div>";

        //create the needed javascript to set the values and invoke listener
        $j_str = "<script> ";
        $j_str .= $this->args['classname'] . ".rows0 = {$data0_enc}; ";
        $j_str .= $this->args['classname'] . ".hdr0 = [{header: '" . $this->args['left_header']  . "'}]; ";
        if($this->args['gridcount']==1){
            $j_str .= $this->args['classname'] . ".rows1 = {$data1_enc}; ";
            $j_str .= $this->args['classname'] . ".hdr1 = [{header: '" . $this->args['right_header']  . "'}]; ";
        }
        if($this->args['gridcount']==2){
            $j_str .= $this->args['classname'] . ".rows1 = {$data1_enc}; ";            
            $j_str .= $this->args['classname'] . ".rows2 = {$data2_enc}; ";
            $j_str .= $this->args['classname'] . ".hdr1 = [{header: '" . $this->args['mid_header'] . "'}]; ";
            $j_str .= $this->args['classname'] . ".hdr2 = [{header: '" . $this->args['right_header'] . "'}]; ";
        }
        $divs_str = "'".$left_div_name ."'";
        if($this->args['gridcount']==2){$divs_str .= ", '".$mid_div_name."'";}
        if($this->args['gridcount']>0) {$divs_str .= ", '".$right_div_name."'";}
        
        $j_str .= $this->args['classname'] . ".divs = [$divs_str]; ";

        $j_str .= "YAHOO.util.Event.on(window, 'load', " . $this->args['classname'] . ".init); ";
        $j_str .= "</script> ";
        //return display string
        $str = $j_str . '  ' . $html_str;
        $html_str_arr['script'] = $j_str;        
            
         if(isset($this->args['return_array']) && $this->args['return_array']){
            return $html_str_arr;    
         }else{
            return $str;
         }
    }

/*
 * This script is the javascript class definition for the template drag drop object.  This
 * makes use of the args['classname'] parameter to name the class and to prefix variables with.  This is done
 * dynamically so that multiple template dragdrop objects can be defined on the same page if needed
 * without having the variables mix up as you drag rows around.
 */
    function displayDefinitionScript() {
        //create some defaults in case arguments are missing

        //convert values for gridcount in case they are in string form
        if(!isset($this->args['gridcount']) || empty($this->args['gridcount']) || $this->args['gridcount'] == 'one'){
            $this->args['gridcount'] = 0;
        }elseif($this->args['gridcount'] == 'two'){
            $this->args['gridcount'] = 1;
        }elseif(
            $this->args['gridcount'] == 'three'){$this->args['gridcount'] = 2;
        }
 

        
        //default class name
        if(!isset($this->args['classname']) || empty($this->args['classname'])){
            $this->args['classname'] = 'DragDropGrid';
        }
        //default columns to one if the value is set to anything other than the expected 0,1 or 2
        if(($this->args['gridcount'] != 0) && ($this->args['gridcount'] != 1) && ($this->args['gridcount'] != 2)){
            $this->args['gridcount'] = 0;
        }

        //default div names
        if(!isset($this->args['left_div_name']) || empty($this->args['left_div_name'])){
            $this->args['left_div_name'] = 'left';
        }
        if(!isset($this->args['mid_div_name']) || empty($this->args['mid_div_name'])){
            $this->args['mid_div_name'] = 'mid';
        }
        if(!isset($this->args['right_div_name']) || empty($this->args['right_div_name'])){
            $this->args['right_div_name'] = 'right';
        }



    //create javascript that defines the javascript class for this instance
    //start by defining the variables that the grids will be referenced by
    $j_str =   "  
        
        <script>
           var " . $this->args['classname'] . "_grid2, " . $this->args['classname'] . "_grid1, " . $this->args['classname'] . "_grid0;
           var " . $this->args['classname'] . "_sugar_grid2, " . $this->args['classname'] . "_sugar_grid1, " . $this->args['classname'] . "_sugar_grid0;
           /*
            * This invokes the grid objects
            */
            " . $this->args['classname'] . " = function () {" ;

      //if this is not a single column, then add the functions that handle the drag and drop aspect
            if($this->args['gridcount']>0){

            $j_str .=   "                  
                   //function that displays the text while dragging items     
                   function getDDText(){
                        var count = this.getSelectionCount();
                        var indexes = this.getSelectedRowIndexes();
                        var retStr='';				
                        for(var i=0;i<indexes.length;i++){
				    		retStr=retStr+this.getDataModel().getRow(indexes[i])[0]+',';
				    		retStr=retStr+'\\n';						    		
				   	     }		
				   	    return retStr.substring(0,retStr.lastIndexOf(',')); 		                        
                    }    
                
                        //function that handles moving from one column to another
                        function moveRows(grid, dd, id, e){
                        if(grid.id != id) { // if row order, let DDGrid handle it
                            //var targetGrid = (id == " . $this->args['classname'] . ".divs[0] ? " . $this->args['classname'] . "_grid0 : " . $this->args['classname'] . "_grid1); 
                            var targetGrid = " . $this->args['classname'] . "_grid0;
                            
                            if(id == " . $this->args['classname'] . ".divs[1]){
                                 var targetGrid = " . $this->args['classname'] . "_grid1
                            }
                            if(id == " . $this->args['classname'] . ".divs[2]){
                                 var targetGrid = " . $this->args['classname'] . "_grid2
                            }
                            
                           
                            var indexes = grid.getSelectedRowIndexes();                            
                            if(indexes.length > 10){  
                              tenRowsOrMore(grid,indexes,targetGrid,e)              
                             }              
                            else{                   
                             grid.transferRows(indexes, targetGrid, targetGrid.getTargetRow(e), e.ctrlKey);
                            }                            	
                            " . $this->args['classname'] . "_sugar_grid0 = " . $this->args['classname'] . "_grid0;
                            " . $this->args['classname'] . "_sugar_grid1 = " . $this->args['classname'] . "_grid1;
                            " . $this->args['classname'] . "_sugar_grid2 = " . $this->args['classname'] . "_grid2;
                         } 
                         
                          if(typeof window.postMoveRows != 'undefined'){
                             if(typeof window.displayAddRemoveDragButtons != 'undefined'){	                                                 	                                                                            
						   	  displayAddRemoveDragButtons(add_all_fields,remove_all_fields);
						   	 }		
						   }						                                          		
                    }
    
                function tenRowsOrMore(grid,indexes,targetGrid,e){      
                 var count =0;
                    for(var j=Math.round(indexes.length/10);j>=0;j--){                                                                                      
                        var indexesN = new Array();
                        var k =0;
                        for(var i=9;i>=0;i--){                  
                          if(indexes[j*10+i] != null && indexes[j*10+i] >=0 && count <=indexes.length){     
                            indexesN[k]=indexes[j*10+i];
                            count++;
                            k++;
                           }
                         }
                        if(indexesN.length >0){
                        grid.transferRows(indexesN, targetGrid, targetGrid.getTargetRow(e), e.ctrlKey); 
                        targetGrid.getDataModel().sort(null,0,'ASC'); 
                        }
                  }
            }
	          		
  ";
            }

    //now add the script that instantiates the class    
    $j_str .=   "  
                        
            return {
                rows0 : [],
                rows1 : [],
                rows2 : [],     
                hdr0 : [],     
                hdr1 : [],
                hdr2 : [],  
                divs : [],
                init : function(){ ";
            $count = 0;
            while($count<$this->args['gridcount']+1){
                        
                   $j_str .=$this->args['classname'] . "_grid$count = new YAHOO.ext.grid.DDGrid(
                        " . $this->args['classname'] . ".divs[$count],
                        new YAHOO.ext.grid.DefaultDataModel(" . $this->args['classname'] . ".rows$count),
                        new YAHOO.ext.grid.DefaultColumnModel(" . $this->args['classname'] . ".hdr$count)                                             
                    );
                    ";
                    if($this->args['gridcount']!=0){ 
                        $j_str .= $this->args['classname'] . "_grid$count.on('dragdrop', moveRows); "
                               .   $this->args['classname'] . "_grid$count.getDragDropText = getDDText;";
                    }
                    $j_str .=                        
            
                     $this->args['classname'] . "_grid$count.autoSizeColumns = true; 
                    " . $this->args['classname'] . "_grid$count.autoSizeHeaders = true;    
                    " . $this->args['classname'] . "_grid$count.trackMouseOver = false;        
                    " . $this->args['classname'] . "_grid$count.render();
                    " . $this->args['classname'] . "_sugar_grid$count = " . $this->args['classname'] . "_grid$count;";
                    $count = $count+1;
             }                               
        $j_str.=" }
                };       
            }();
        
        </script>
        ";
        //all done, return final script
        return $j_str;
    }


/*
 * this function returns the src style sheet and script tags that need to be included
 * for the template chooser to work
 */
    function displayScriptTags() {
        $j_str =   "  
            <link rel='stylesheet' type='text/css' href='include/javascript/yui/ext/resources/css/grid.css' />
            <script type='text/javascript' src='include/javascript/yui/dragdrop.js'></script>
            <script type='text/javascript' src='include/javascript/yui/container.js'></script>
            <script type='text/javascript' src='include/javascript/yui/ext/yui-ext.js'></script>
            <script type='text/javascript' src='include/javascript/yui/ext/ddgrid.js'></script>";
        return $j_str;
    }
      
}

?>
