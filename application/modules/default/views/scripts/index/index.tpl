<div class='content sixtypercent left'>
	<h1>{$presentation}</h1>
	{foreach from=$textPresentation item=curr}
	<p>
	{$curr}
	</p>
	<br/>
	{/foreach}
</div>

<div class='content thirtypercent right'>
	<h1>{$mostAppreciated}</h1>
	
	{foreach from=$bestUser item=object}
	<div class="homeFile">
		<img src='/user/getUserAvatar/min/1/username/{$object.GROUP_URL}.png' alt="{$object.GROUP_NOM}" class='avatar'/> <a href="/{$object.GROUP_URL}" class='title'>{$object.GROUP_NOM}</a>
		{assign var=counter value=0}
		{foreach from=$object.STYLES item=style}
            <span class='competence'>
			{if $counter} / {/if} {$translate->translate($style.STYLE_NAME)}
            {assign var=counter value=$counter+1}
            </span>
		{/foreach}
	</div>
	{/foreach}
</div>

<div class='content thirtypercent right'>
	<h1>{$newcommers}</h1>
	{dynamic}
	{foreach from=$newUsers item=object}
	<div class="homeFile">
		<img src='/user/getUserAvatar/min/1/username/{$object.GROUP_URL}.png' alt="{$object.GROUP_NOM}" class='avatar'/> <a href="/{$object.GROUP_URL}" class='title'>{$object.GROUP_NOM}</a>
		{assign var=counter value=0}
		{foreach from=$object.STYLES item=style}
            <span class='competence'>
			{if $counter} / {/if} {$translate->translate($style.STYLE_NAME)}
            {assign var=counter value=$counter+1}
            </span>
		{/foreach}
	</div>
	{/foreach}
	{/dynamic}
</div>

<div class='spacer'>&nbsp;</div>
{*
<div class='content sixtypercent left'>
	 here comes the news 
</div>
<div class='content thirtypercent right'>
	 here goes the tag cloud
</div>
*}