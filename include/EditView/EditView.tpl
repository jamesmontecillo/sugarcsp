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
{include file=$headerTpl}

<table width='100%' border='0' cellspacing='1' cellpadding='0'  class='tabDetailView'>
{foreach name=rowIteration from=$def.data key=row item=rowData}
<tr>
	{assign var='columnsInRow' value=$rowData|@count}
	{assign var='columnsUsed' value=0}
	{foreach name=colIteration from=$rowData key=col item=colData}
		<td width='{$def.templateMeta.widths[$smarty.foreach.colIteration.index].label}%' class='tabDetailViewDL'>
			{$mod[$colData.field]|strip_semicolon}
			{if $fields[$colData.field].required}<span class="required">{$app.LBL_REQUIRED_SYMBOL}</span>{/if}
		</td>
		<td width='{$def.templateMeta.widths[$smarty.foreach.colIteration.index].field}%' class='tabDetailViewDF' {if $colData.colspan}colspan='{$colData.colspan}'{/if}>
			{if $colData.customCode}
				{sugar_evalcolumn var=$colData.customCode rowData=$data}
			{elseif $fields[$colData.field]}
				{if $colData.readOnly}
					{sugar_field parentFieldArray='fields' vardef=$fields[$colData.field] displayType='detailView' displayParams=$colData.displayParams typeOverride=$colData.type}
				{else}
					{sugar_field parentFieldArray='fields' vardef=$fields[$colData.field] displayType='editView' displayParams=$colData.displayParams typeOverride=$colData.type}
				{/if}
			{/if}
		</td>
	{/foreach}
</tr>
{/foreach}
</table>

{include file=$footerTpl}