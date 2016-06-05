<div id='nbFound'>{$nbFound}</div>
{include file='pagination.tpl' classToUse='pagineSearch'}

<div>
{foreach from=$results item=curr}
	<div class='searchGroup'>
		<img src='/user/getUserAvatar/{$curr.GROUP_URL}.png' alt="{$curr.GROUP_NOM}" class='avatar'/>
		<span class='searchGroupName'><a href='/{$curr.GROUP_URL}'>{$curr.GROUP_NOM}</a></span>
		<span class='location'>{if $curr.GROUP_LIEU ne ''}{$curr.GROUP_LIEU}{/if}{if $curr.GROUP_LIEU ne '' and $curr.GROUP_PAYS ne ''} / {/if}{if $curr.GROUP_PAYS ne ''}<b>{$curr.GROUP_PAYS}</b>{/if}</span>
		{*<div class='searchGroupDescription'>{$curr.GROUP_DESCRIPTION}</div>*}
		<h4>{$members}</h4> 
		{foreach from=$curr.USERS item=info key=k}
		<div class='searchGroupUser'>
			{$info.USER_NAME} : 
				<span id='competences_{$k}'>
					{assign var=counter value=0}
                    {foreach from=$info.COMPETENCIES item=curr2}
						<span class='competence'>
							{if $counter} / {/if} {$translate->translate($curr2.COMPETENCE_NAME)}
                            {assign var=counter value=$counter+1}
                        </span>
					{/foreach}
				</span>
		</div>
		{/foreach}
		<h4>{$musicalStyles}</h4>
		<div class='searchGroupStyle'>
		{assign var=counter value=0}
		{foreach from=$curr.STYLES item=info}
			<span class='style'>
				{if $counter} / {/if} {$info.STYLE_NAME}
				{assign var=counter value=$counter+1}
			</span>
		{/foreach}
		</div>
		<h4>{$label}</h4>
		<div class='searchLabel'>
			<span class='label'>
				{$info.LABEL_NAME}
			</span>
		</div>
	</div>
{foreachelse}
	{$noResult}
{/foreach}
</div>

{include file='pagination.tpl' classToUse='pagineSearch'}

<div id='csrfSecurityCodeAjax' class='ressources'>{$token}</div>