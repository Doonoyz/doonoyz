{if !$ajaxCall}
<div id='toUpdate'>
{/if}
{$templateRenderer}
{if !$ajaxCall}
</div>
<script type='text/javascript'>
	Engine_Invitation_Init();
</script>
{/if}