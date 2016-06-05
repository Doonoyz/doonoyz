<form method='post' action='javascript:void(0);' id='censorGroupForm_{$id}' class='censorGroupForm'>
{$text.present}
<input type='hidden' name='id' value='{$group->getId()}' />
<select name='censorValue'>
	<option value='0' {if $group->getCensure() eq 0}selected='selected'{/if}>{$none}</option>
	<option value='10' {if $group->getCensure() eq 10}selected='selected'{/if}>10</option>
	<option value='12' {if $group->getCensure() eq 12}selected='selected'{/if}>12</option>
	<option value='16' {if $group->getCensure() eq 16}selected='selected'{/if}>16</option>
	<option value='18' {if $group->getCensure() eq 18}selected='selected'{/if}>18</option>
	<option value='21' {if $group->getCensure() eq 21}selected='selected'{/if}>21</option>
</select>
<input type='submit' value='{$text.submit}' />
</form>
{literal}
<script type='text/javascript'>
	$(document).ready(function () {
		Engine_Admin_Init();
		{/literal}
		$('#csrfSecurityCode')[0].innerHTML = '{$token}';
		{literal}
	});
</script>
{/literal}