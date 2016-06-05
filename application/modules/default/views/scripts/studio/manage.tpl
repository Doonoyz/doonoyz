<div id='studioMenu' class='content'>
    <a href="javascript:void(0);" id='addFolder_{$groupId}' class='addFolder'><img src='/images/studiomanage_add.jpg' alt="{$addFolder}"/> {$addFolder}</a>
   
	<div>
		<a href='/ajax/help?action=studio' rel='facebox'><img id='helpImg' src='/images/help.gif' width='40' height='40' alt="{$help}" /></a>
	</div>
    <ul id='studiocompos'>
        {foreach from=$compos item=folder}
		{assign var=folderId value=$folder.ID}
            <li id='compoFolder_{$folderId}'>
				<a href='javascript:void(0);' class='compoFolderTitle'>{$folder.NAME}</a>
				<div class='compoFolder'>
					<div class='options'>
						<a href="javascript:void(0);" id='addCompo_{$groupId}_{$folderId}' class="addCompo"><img src='/images/studiomanage_add.jpg' alt="{$addCompo}" title="{$addCompo}" /></a>
						<a href='javascript:void(0);' id='delete_{$groupId}_{$folderId}' class='deleteFolder'><img src='/images/login_cancel.jpg' alt="{$deleteFolder}" title="{$deleteFolder}" /></a>
						<a href='javascript:void(0);' id='editFolder_{$folderId}' class='editFolder'><img src='/images/stylo.gif' alt="{$editFolder}" title="{$editFolder}" /></a>
						<div class='publicFolder'>
						  <label for='publicFolder_{$folderId}'>{$publicFolder}</label>
						  <input type="checkbox" id='publicFolder_{$folderId}' name='publicFolder_{$folderId}' class="crirHiddenJS" value="{if $folder.PUBLIC}true{else}false{/if}" {if $folder.PUBLIC}checked='checked'{/if}/>
						</div>
					</div>
					<div id='addCompoDiv_{$groupId}_{$folderId}' class="addCompoDiv"><div id='addCompoDivIn_{$groupId}_{$folderId}' class="addCompoDivIn">{$magickey}</div></div>
					<div class='folderInside' id='folderInside_{$folderId}'>
						{foreach from=$folder.COMPO item=file}
							{assign var=k value=$file.ID}
							<div>
								<a href="javascript:void(0);" id='compo_{$groupId}_{$k}' class="compoInterface">{$file.NAME}</a>
							</div>
						{/foreach}
					</div>
				</div>
            </li>
        {/foreach}
    </ul>
</div>

<div id='studioContent' class='content'>
</div>

<div class='spacer'>&nbsp;</div>