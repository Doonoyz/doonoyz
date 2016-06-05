<div id='notExisting' class='content'>
{$userNotExists}
{if $userId}
	<form method='post' action='javascript:void(0)' id='createGroupNotExists'>
		<input type='hidden' name='name' value="{$username}"/>
		<input type='hidden' name='groupname' value="{$username}"/>
		<br/>
		<input type='submit' value="{$buttonText}" name='commitGroup'/>
	</form>
{else}
	{$connectToSee}
{/if}
</div>