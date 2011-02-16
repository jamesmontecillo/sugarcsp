{*
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
*}
{$displayParams.preCode}
<input name='{sugar_variable_constructor objectName=$parentFieldArray memberName=$vardef.name key='name'}' onblur="parseDate(this, '');" id='jscal_field{sugar_variable_constructor objectName=$parentFieldArray memberName=$vardef.name key='name'}' type='text'  size='11' maxlength='10' value='{sugar_variable_constructor objectName=$parentFieldArray memberName=$vardef.name key='value'}' >
<img src='themes/{$theme}/images/jscalendar.gif' alt='Enter Date'  id='jscal_trigger{sugar_variable_constructor objectName=$parentFieldArray memberName=$vardef.name key='name'}' align='absmiddle'> <span class='dateFormat'>yyyy-mm-dd</span>
<script>
Calendar.setup ({literal}{ldelim}{/literal}inputField : 'jscal_field{sugar_variable_constructor objectName=$parentFieldArray memberName=$vardef.name key='name'}', ifFormat : '{$CAL_DATE_FORMAT}', showsTime : false, button : 'jscal_trigger{sugar_variable_constructor objectName=$parentFieldArray memberName=$vardef.name key='name'}', singleClick : true, step : 1{literal}{rdelim}{/literal});
</script>
{$displayParams.postCode}