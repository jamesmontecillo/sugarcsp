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
 


require_once('include/generic/SugarWidgets/SugarWidget.php');

class SugarWidgetTabs extends SugarWidget
{
 var $tabs;
 var $current_key;

 function SugarWidgetTabs(&$tabs,$current_key,$jscallback)
 {
   $this->tabs = $tabs;
   $this->current_key = $current_key;
   $this->jscallback = $jscallback;
 }

 function display()
 {
	global $image_path;
	$IMAGE_PATH = $image_path;
	ob_start();
?>
<script>
var keys = [ <?php 
$tabs_count = count($this->tabs);
for($i=0; $i < $tabs_count;$i++) 
{
 $tab = $this->tabs[$i];
 echo "\"".$tab['key']."\""; 
 if ($tabs_count > ($i + 1))
 {
   echo ",";
 }
}
?>]; 

function selectTabCSS(key)
{


  for( var i=0; i<keys.length;i++)
  {
   var liclass = '';
   var linkclass = '';

 if ( key == keys[i])
 {
   var liclass = 'active';
   var linkclass = 'current';
 }
  	document.getElementById('tab_li_'+keys[i]).className = liclass;

  	document.getElementById('tab_link_'+keys[i]).className = linkclass;
  }
    <?php echo $this->jscallback;?>(key);
}
</script>

<ul class="tablist">
<?php 
	foreach ($this->tabs as $tab)
	{
		$TITLE = $tab['title'];
		$LI_ID = "";
		$A_ID = "";

	  if ( ! empty($tab['hidden']) && $tab['hidden'] == true)
		{
			  $LI_ID = "style=\"display: none\"";
			  $A_ID = "style=\"display: none\"";

		} else if ( $this->current_key == $tab['key'])
		{
			  $LI_ID = "class=\"active\"";
			  $A_ID = "class=\"current\"";
		}

		$LINK = "<li $LI_ID id=\"tab_li_".$tab['link']."\"><a $A_ID id=\"tab_link_".$tab['link']."\" href=\"javascript:selectTabCSS('{$tab['link']}');\">$TITLE</a></li>";

?>
<?php echo $LINK; ?>	
<?php
	}
?>
</ul>
<?php 
	$ob_contents = ob_get_contents();
        ob_end_clean();
        return $ob_contents;
	}
}
?>
