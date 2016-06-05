<div class='content'>
	<table id='MPsection'>
		<tr class='MPTitle MP'>
			<th>{$dateHour}</th>
			<th>{$pseudo}</th>
			<th>{$title}</th>
		</tr>
	
	{foreach from=$messages item=curr key=k}
	{assign var=senderid value=$curr.USER_ID_SENDER}
	{*!-- this is a block --*}
	<tr id='myMP_{$curr.MP_ID}' class='MP alternate{if $k % 2}1{else}2{/if} {if $curr.MP_READ}MPread{/if}'>
		<td>{$curr.MP_DATE}</td>
		<td>{if $senderid}<a href='/mp/newmessage/{$users.$senderid}' id='mpUsernameRecup_{$curr.MP_ID}'>{$users.$senderid}</a>{else}Doonoyz Admin{/if}</td>
		<td><a id='MP_{$curr.MP_ID}' class='MPReadable' href='javascript:void(0);'>{$curr.MP_TITLE}</a></td>
	</tr>
	<tr class='alternate{if $k % 2}1{else}2{/if} MPhidden' id='MPBody_{$curr.MP_ID}' style='display:none;'>
		<td colspan='3'>{$curr.MP_BODY}</td>
	</tr>
	{*!-- end of the block --*}
	{/foreach}
	</table>
</div>
<div class='content'>
	&gt; <a href='/mp/newmessage' id='MPNew'>{$newMessage} <img src='/images/studiomanage_add.jpg' alt="{$newMessage}" title="{$newMessage}" /></a><br/>
	&gt; <a href='javascript:void(0);' id='MPDeleteAll'>{$deleteAll} <img src='/images/login_cancel.jpg' alt="{$deleteAll}" title="{$deleteAll}" /></a>
</div>
