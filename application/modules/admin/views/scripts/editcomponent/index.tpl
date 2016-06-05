<div class='content'>
<h1>{$text.chooseComponent}</h1>
{if $hasComponent}
<select id='editComponentSelect'>
{foreach from=$thelist item=curr key=k}
	<option value='{$curr.$listId}'>{$curr.$listName}</option>
{/foreach}
</select>
<a id='editComponentLink' href='/admin/edit/index/component/{$componentName}/id/0' rel='facebox'>{$text.editComponent}</a>
{else}
<select id='editComponentSelectGlobal'>
{foreach from=$components item=curr key=k}
	<option value='{$k}'>{$curr}</option>
{/foreach}
</select>
{/if}
</div>