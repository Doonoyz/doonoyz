<div class='content'>
	{if $success eq "none"}
	<form method='post' action='#' class='formtool' id='newMessageForm'>
		<div><label for='username'>{$pseudo}</label> <span><input type="text" value="{$username}" name='username' class='inform' /></span></div>
		<div><label for='title'>{$title}</label> <span><input type="text" name='title' value="{$titleText}" class='inform' /></span></div>
		<div><label for='body'>{$body}</label> <span><textarea name='body' class='expanding inform' >{$bodyText}</textarea></span></div>
		<div class='tool'><input type='image' src='/images/accept.gif' title="{$send}" name='sendnew' /></div>
	</form>
	{if $error neq "none"}<div class="error">{$error}</div>{/if}
	{else}
		<div class="success">{$success}</div>
	{/if}
</div>