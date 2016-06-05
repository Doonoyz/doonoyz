<div id='studioList' class='content'>
	<h1>{$title}</h1>
	<div>
	{foreach from=$groups item=curr key=groupId}
		<div>&gt; <a href='/studio/manage/{$curr.GROUP_URL}'>{$curr.GROUP_NOM}</a></div>
	{foreachelse}
		{$noGroup}
	{/foreach}
	</div>
</div>