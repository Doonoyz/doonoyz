<div class='content'>

	{if !$error and !$success}
  <form method='post' action="#" id='unsubscribe' class='formtool'>
	<h1>{$text.title}</h1>
	{$message}
	<div class='tool'>
		<input type='image' src='/images/accept.gif' name='yes' title="{$text.yes}" />
		<input type='image' src='/images/refuse.gif' name='no' title="{$text.no}" />
    </div>
  </form>
  {else}
  <div id="{if $success}success{else}error{/if}msg">{$message}</div>
  {/if}
</div>
