<div class='content'>
	<table>
		<tr>
			<th>{$message}</th>
			<th>{$reporter}</th>
			<th>{$action}</th>
		</tr>
	
{foreach from=$tasks item=curr}
	{assign var=userId value=$curr.userId}
	<tr class='alternate{if $k % 2}1{else}2{/if}'>
		<td>{$curr.message}</td>
		<td>
			<a href='/mp/newmessage/{$curr.userName}'>{$writeMessageTo} {$curr.userName}</a>
			<a href='javascript:void(0);' id='blockUser{$curr.id}_{$userId}' class='blockUser'>{$blockUser} {$curr.userName}</a>
		</td>
		<td>
			{if $curr.componentName eq "compo"}
        <a href='/admin/check/index/component/{$curr.componentName}/id/{$curr.componentId}' rel='facebox'>{$checkCompo}</a>
        <a href='javascript:void(0);' id='deleteCompo{$curr.id}_{$curr.componentName}_{$curr.componentId}' class='deleteCompo'>{$deleteCompo}</a>
      {/if}
			{if $curr.componentName eq "news"}
        <a href='/admin/check/index/component/{$curr.componentName}/id/{$curr.componentId}' rel='facebox'>{$checkNews}</a>
        <a href='javascript:void(0);' id='deleteCompo{$curr.id}_{$curr.componentName}_{$curr.componentId}' class='deleteCompo'>{$deleteNews}</a>
      {/if}
			{if $curr.groupId neq 0}
			<a href='/admin/check/index/component/group/id/{$curr.groupId}' target='_blank'>{$consultGroup}</a>
			<a href='javascript:void(0);' id='blockGroup{$curr.id}_{$curr.groupId}' class='blockGroup'>{$blockGroup}</a>
			<a href='/admin/censor/index/id/{$curr.groupId}' class='facebox'>{$censorGroup}</a>
			{elseif $curr.componentName eq "group"}
			<a href='/admin/check/index/component/group/id/{$curr.componentId}' target='_blank'>{$consultGroup}</a>
			<a href='javascript:void(0);' id='blockGroup{$curr.id}_{$curr.componentId}' class='blockGroup'>{$blockGroup}</a>
			<a href='/admin/censor/index/id/{$curr.componentId}' rel='facebox'>{$censorGroup}</a>
			{else}
			<a href='/admin/edit/index/component/{$curr.componentName}/id/{$curr.componentId}' rel='facebox'>{$editComponent}</a>
			{/if}
			<a href='javascript:void(0);' id='deleteTask_{$curr.id}' class='deleteTask'>{$deleteTask}</a>
		</td>
	</tr>
	{assign var=k value=$k+1}
{/foreach}	
	</table>
</div>