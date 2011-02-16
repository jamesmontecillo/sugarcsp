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
<input type='hidden' name='{sugar_variable_constructor objectName=$parentFieldArray memberName=$vardef.name key='name'}' value='0'>
<input type='checkbox' class='checkbox' name='{sugar_variable_constructor objectName=$parentFieldArray memberName=$vardef.name key='name'}' size='{$displayParams.size}'
{ldelim}if strcmp('varchar', {sugar_variable_constructor stringFormat=true objectName=$parentFieldArray memberName=$vardef.name key='options.type'}) == 0{rdelim}
value='on'
{ldelim}else{rdelim}
value='1'
{ldelim}/if{rdelim}

{ldelim}if strcmp('1', {sugar_variable_constructor stringFormat=true objectName=$parentFieldArray memberName=$vardef.name key='value'}) == 0 || strcmp('yes', {sugar_variable_constructor stringFormat=true objectName=$parentFieldArray memberName=$vardef.name key='value'}) == 0 || strcmp('on', {sugar_variable_constructor stringFormat=true objectName=$parentFieldArray memberName=$vardef.name key='value'}) == 0{rdelim}
checked='checked'
{ldelim}/if{rdelim}
>
{$displayParams.postCode}