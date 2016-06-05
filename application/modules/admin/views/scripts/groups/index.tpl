<div class='content'>
<h1>{$text.groupManaging}</h1>
<select id='groupManageSelect'>
{foreach from=$groupList item=curr}
<option value='{$curr.GROUP_URL}' {if $selectedGroup eq $curr.GROUP_URL}selected='selected'{/if}>{$curr.GROUP_URL}</option>
{/foreach}
</select>
<a href='javascript:void(0);' id='groupManageLink'>{$text.editGroup}</a>
{if $selectedGroup}
{$text.censor} : {$currentGroup->getCensure()} <a href='/admin/censor/index/id/{$currentGroup->getId()}' rel='facebox'>{$text.censorGroup}</a><br/>
{$text.active} : {if $currentGroup->isActive()}<a href='javascript:void(0);' id='blockGroup_{$currentGroup->getId()}' class='blockGroup'>{$text.blockGroup}</a>{else}<a href='javascript:void(0);' id='activeGroup_{$currentGroup->getId()}' class='activeGroup'>{$text.activeGroup}</a>{/if}
<a href='/{$currentGroup->getUrl()}' target='_blank'>{$text.consultGroup}</a>
{/if}
</div>