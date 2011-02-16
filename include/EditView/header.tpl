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
<form id="{$formId}" name="{$formName}" {if $multipart} enctype='multipart/form-data' {/if} method="POST" action="index.php" onsubmit='return check_form("{$formName}");'>
<input type="hidden" name="module" value="{$module}">
<input type="hidden" name="id" value="{$data.id}">
<input type="hidden" name="action" value="Save">
<input type="hidden" name="returnmodule" value="{$returnModule}">
<input type="hidden" name="returnaction" value="{$returnAction}">
<input type="hidden" name="returnid" value="{$returnId}">
{foreach name=rowIteration from=$def.templateMeta.hiddenInputs key=name item=value}
<input type="hidden" name="{$name}" value="{$value}">
{/foreach}

{if isset($hiddenFields)}
{foreach name="hiddenFields" from=$hiddenFields item=input}
    <input type="hidden" name="{$input.name}" value="{$input.value}" />
{/foreach}
{/if}

<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td style="padding-bottom: 2px;">
			<input title="{$app.LBL_SAVE_BUTTON_TITLE}" class="button" type="submit" name="button" value="  {$app.LBL_SAVE_BUTTON_LABEL}  " >
			<input title="{$app.LBL_CANCEL_BUTTON_TITLE}" onclick='document.location = "index.php?module={$returnModule}&action={$returnAction}{if $returnId}&id={$returnId}{/if}"; return false' class="button" type="submit" name="button" value="  {$app.LBL_CANCEL_BUTTON_LABEL}  ">
		</td>
		<td align="right" nowrap><span class="required">{$mod.REQUIRED_SYMBOL}</span> {$mod.NTC_REQUIRED}</td>
		<td align='right'></td>
	</tr>
</table>
