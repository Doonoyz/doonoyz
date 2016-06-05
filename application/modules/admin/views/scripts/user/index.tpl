<div class='content'>
<h1>{$text.userManage}</h1>
<select id='adminUserSelect'>
{foreach from=$userCollection item=login key=id}
	<option value='{$id}' {if $userId eq $id}selected='selected'{/if}>{$login}</option>
{/foreach}
</select>
<a id='editAdminUser' href='javascript:void(0);'>{$text.editUser}</a>
{if $userId}
<form method='post' action='/admin/user/index/userid/{$user->getId()}'>
	<input type='hidden' name='action' value='save' />
	<input type='hidden' name='csrf' value='{$token}' />
	<input type='hidden' name='id' value='{$user->getId()}' />
	<input type='submit' name='submit' value="{if $user->getActive()}{$text.blockUser}{else}{$text.allowUser}{/if}" />
</form>
{/if}
</div>