{if !$fatalError}
	{assign var=id value=$compo->getId()}
        {$name} : <span id='name_{$id}' class='editableCompo editHighliter titleH1'>{$compo->getName()}</span>
		
		{if $compo->isFetched()}
		<div id='playcompo_{$id}' class='studioPlayer{$compo->getType()}'></div>
        <div class='publicCompo'>
          <label for='public_{$id}'>{$publicity}</label>
          <input type="checkbox" id='public_{$id}' name='public_{$id}' class="crirHiddenJS" value="{if $compo->isPublic()}true{else}false{/if}" {if $compo->isPublic()}checked='checked'{/if}/>
        </div>
        {else}
			{$notProcessed}
        {/if}
        {$changeFolder} : <select id='changeFolder_{$id}' class='changeFolder selectSort'>
        {foreach from=$folders item=curr}
			<option value='{$curr.ID}' {if $curr.ID eq $compo->getFolderId()}selected='selected'{/if}>{$curr.NAME}</option>
        {/foreach}
        </select><br/>
        <a href='/flvplayer/original/id/{$id}'><img src='/images/studiomanage_download.jpg' alt="{$download}" title="{$download}" /> {$download}</a><br/>
        <a href='javascript:void(0);' id='delete_{$compo->getFolderId()}_{$id}' class='deleteCompo'><img src='/images/login_cancel.jpg' alt="{$delete}" title="{$delete}" /> {$delete}</a>
{else}
<div class='error'>
	{$fatalError}
</div>
{/if}
<div id='csrfSecurityCodeAjax' class='ressources'>{$token}</div>