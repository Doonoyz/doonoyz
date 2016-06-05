<form method='post' action='javascript:void(0);' id='edit_{$componentType}_{$id}' class='editComponent'>
<label for='name'>{$text.name}</label><input type='text' name='name' value="{$component->getName()}" />
{if $componentType eq "contacttype"}
<label for='pattern'>{$text.pattern}</label><input type='text' name='pattern' value="{$component->getPattern()}" />
<label for='logo'>{$text.logo}</label><input type='text' name='logo' value="{$component->getLogo()}" />
<label for='filter'>{$text.filter}</label><input type='text' name='filter' value="{$component->getFilter()}" />
{/if}
<input type='submit' value='{$text.submit}' />
</form>

<form method='post' action='javascript:void(0);' id='replace_{$componentType}_{$id}' class='replaceComponentForm'>
<div id='replaceComponentDiv'></div>
<input type='submit' value='{$text.replaceWith}' />
</form>

<select id='addComponentForSelect' class='selectSort'>
{foreach from=$componentList item=curr}
<option value='{$curr.$listId}'>{$curr.$listName}</option>
{/foreach}
</select>
<a href='javascript:void(0);' id='addComponentForLink'>{$text.addComponentFor}</a>


<a href='javascript:void(0);' id="acceptComponent_{$componentType}_{$id}" class='acceptComponent'>{$text.acceptComponent}</a>
<a href='javascript:void(0);' id="deleteComponent_{$componentType}_{$id}" class='deleteComponent'>{$text.deleteComponent}</a>
{literal}
<script type='text/javascript'>
	$(document).ready(function () {
		Engine_General_Init();
		Engine_Admin_Init();
		{/literal}
		$('#csrfSecurityCode')[0].innerHTML = '{$token}';
		{literal}
	});
</script>
{/literal}