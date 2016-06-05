<div class='content'>
	<table id='groupManagerTable'>
		<tr>
			<th>{$groupName}</th>
			<th>{$competencies}</th>
			<th>{$status}</th>
		</tr>

	
	{foreach from=$infos item=curr key=id}
	<tr class='alternate{if $k % 2}1{else}2{/if}'>
		<td><a href='/{$curr.GROUP_URL}'>{$curr.GROUP_NOM}</a></td>
		<td>
			{assign var=counter value=0}
			{foreach from=$curr.COMPETENCES item=comp}
				<span>
					{if $counter eq 1} / {/if} {$translate->translate($comp)}
				</span>
				{assign var=counter value=1}
			{/foreach}
		</td>
		<td>
			{if $curr.BID_ID neq 0 and $curr.ACTIVE eq 0}
				{$bidDeliberating} <a href='javascript:void(0);' id='quit_{$id}' class="quitGroup">{$cancel}</a>
			{elseif $curr.BID_ID eq 0 and $curr.ACTIVE eq 1}
				{$validated} <a href='javascript:void(0);' id='quit_{$id}' class="quitGroup">{$quitGroup}{if $curr.GROUP_ADMIN eq $userId} ({$deleteGroup}){/if}</a>
			{elseif $curr.BID_ID eq 0 and $curr.ACTIVE eq 0}
				<a href='javascript:void(0);' id='accept_{$id}' class='acceptInvitation'>{$accept}</a>
				<a href='javascript:void(0);' id='decline_{$id}' class='declineInvitation'>{$decline}</a>
			{else}
				{$blocked} <a href='javascript:void(0);' id='quit_{$id}' class="quitGroup">{$quitGroup}</a>
			{/if}
		</td>
	</tr>
	{assign var=k value=$k+1}
	{/foreach}
	</table>
</div>