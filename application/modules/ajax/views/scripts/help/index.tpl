<div>
	{foreach from=$messages item=curr}
	<div class='helpMessage'>
		<h1>{$curr.TITLE}</h1>
		<p>
			{$curr.BODY}
		</p>
	</div>
	{foreachelse}
		<div id='errormsg'>{$message}</div>
	{/foreach}
</div>
<script type='text/javascript'>
	$('#csrfSecurityCode')[0].innerHTML = '{$token}';
</script>