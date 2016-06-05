{*
	$grouptype eq 'user'
	$grouptype eq 'admin'
	$grouptype eq 'group'
*}
{if $grouptype eq 'admin'}
	<div>
		<a href='/ajax/help?action=groupadmin' rel='facebox'><img src='/images/help.gif' width='40' height='40' alt="{$help}" id='helpImg' /></a>
	</div>
{/if}
<div class="content left sixtyfivepercent">
	{if $grouptype eq 'admin' or $name neq $emptyText}
	<div>
		<span id='name_{$id}' class='{if $grouptype eq 'admin'}editableUser editHighliter {/if}titleH1'>{$name}</span>
	</div>
	{/if}
	<div>
		{if $memberNumber eq 1}
			<span class='titleBlog'>{$competenciesText} :</span>
			<span id='competences_{$id}'>
				{assign var=counter value=0}
				{foreach from=$competencies item=curr key=k}
					<span>
						{if $counter} / {/if} {$translate->translate($curr)} {if $grouptype eq 'admin'}<a href='javascript:void(0);' id='deleteCompetenceUnique_{$id}_{$k}' class="deleteUser"> X </a>{/if}
						{assign var=counter value=$counter+1}
					</span>
				{/foreach}
			</span>
			{if $grouptype eq 'admin'}
				<select id='addCompetenceUniqueSelect_{$id}' class='selectSort alertchange'>
					<option value='0'>{$newCompetence}</option>
					{foreach from=$competenceList item=curr}
						<option value='{$curr.COMPETENCE_ID}'>{$translate->translate($curr.COMPETENCE_NAME)}</option>
					{/foreach}
				</select>
				<a href='javascript:void(0);' id='addCompetenceUnique_{$id}' class="addCompetence">{$addCompetence}</a>
			{/if}
			<a href='/invitation/{$adminId}' rel='facebox'>{$inviteUser}</a>
		{else}
			{foreach from=$membersInGroup item=curr key=k}
				{if $memberList.$k.BID_ID eq 0}
					<div>
						<span id='edituser_{$id}_{$k}' class='{if $grouptype eq 'admin'}editableUser editHighliter{/if} titleBlog'>{$memberList.$k.USER_NAME}</span> :  <a href='/invitation/{$k}' rel='facebox'>{$inviteUser}</a> {if $grouptype eq 'admin' and $k neq $adminId}<a href='javascript:void(0);' id='deleteUser_{$id}_{$k}' class="deleteUser"> X </a>{/if}
						<span id='competences_{$k}'>
							{assign var=counter value=0}
							{foreach from=$competencies.$k item=curr2 key=k2}
								<span>
									{if $counter} / {/if} {$translate->translate($curr2)} {if $grouptype eq 'admin'}<a href='javascript:void(0);' id='deleteCompetence_{$id}_{$k}_{$k2}' class="deleteUser"> X </a>{/if}
									{assign var=counter value=$counter+1}
								</span>
							{/foreach}
						</span>
						{if $grouptype eq 'admin'}
							<select id='addCompetenceSelect_{$id}_{$k}' class='selectSort alertchange'>
								<option value='0'>{$newCompetence}</option>
								{foreach from=$competenceList item=curr}
									<option value='{$curr.COMPETENCE_ID}'>{$translate->translate($curr.COMPETENCE_NAME)}</option>
								{/foreach}
							</select>
							<a href='javascript:void(0);' id='addCompetence_{$id}_{$k}' class="addCompetence">{$addCompetence}</a>
						{/if}
					</div>
				{/if}
			{/foreach}
		{/if}
	</div>
	{if $grouptype eq 'admin' or $lieu neq $emptyText}
		<div>
			<span class='titleBlog'>{$lieuText} : </span> <span id='lieu_{$id}' {if $grouptype eq 'admin'}class='editableUser editHighliter'{/if}>{$lieu}</span>
		</div>
	{/if}
	{if $grouptype eq 'admin' or $pays neq $emptyText}
		<div>
			<span class='titleBlog'>{$paysText} : </span> <span id='pays_{$id}' {if $grouptype eq 'admin'}class='editableUser editHighliter'{/if}>{$pays}</span>
		</div>
	{/if}
	{if $grouptype eq 'admin' or $postal neq $emptyText}
		<div>
			<span class='titleBlog'>{$postalText} : </span> <span id='postal_{$id}' {if $grouptype eq 'admin'}class='editableUser editHighliter'{/if}>{$postal}</span>
		</div>
	{/if}
		<div>
			<span class='titleBlog'>{$label} : </span> {if $grouptype neq 'admin'}<span id='label_{$id}'>{$labelName}</span>{else}
				<select id='label_{$id}' class='labelUpdate'>
					<option value='-1'>{$newLabel}</option>
					<option value='0' {if $labelId eq 0}selected='selected'{/if}>{$noLabel}</option>
					{foreach from=$labelList item=curr}
					<option value='{$curr.LABEL_ID}' {if $curr.LABEL_ID eq $labelId}selected='selected'{/if}>{$curr.LABEL_NAME}</option>
					{/foreach}
				</select>
			{/if}
		</div>
	<div>
		<span class='titleBlog'>{$musicalStyle} :</span> 
		<span id='styles_{$id}' class='toUpdate'>
			{assign var=counter value=0}
			{foreach from=$styles item=curr key=k}
				<span>
					{if $counter} / {/if} {$curr} {if $grouptype eq 'admin'}<a href='javascript:void(0);' id='deleteStyle_{$id}_{$k}' class="deleteUser"> X </a>{/if}
					{assign var=counter value=$counter+1}
				</span>
			{/foreach}
		</span>
		{if $grouptype eq 'admin'}
			<br/>
			<select id='addStyleSelect_{$id}' class='selectSort alertchange'>
				<option value='0'>{$newStyle}</option>
				{foreach from=$styleList item=curr}
					<option value='{$curr.STYLE_ID}'>{$curr.STYLE_NAME}</option>
				{/foreach}
			</select>
			<br/>
			<a href='javascript:void(0);' id='addStyle_{$id}' class="addStyle">{$addStyle}</a>
		{/if}
	</div>
	<br/>
	
		<div class='right'>
			<span>
				<a href='#commentInterface' id='comment_blog_{$id}' class="comment">{dynamic}{$nbComment}{/dynamic} {$comments}</a>
			</span>
			<div>
				<span class='right'>
					{dynamic}{$showNoteText}{/dynamic}
				</span>
				<span id='averageNote' class='right starRating{if $grouptype neq 'user'}Disabled{/if}'>{$average}</span>
			</div>
			<div class="spacer">&nbsp;</div>
		</div>
	<div class='right clearboth alignright'>
		<a href='http://www.doonoyz.com/rss/compo/group/{$username}'>{$userFeed}</a> <img src='/images/blog_rss.jpg' alt='RSS' /><br/>
		{if $grouptype eq 'admin'}<a href='javascript:void(0);' id='addMember_{$id}' class='addMember'>{$addMember}</a>{/if}
	</div>
	{if $isFull && $grouptype eq 'user'}
		<div>
			<a href='/invitation/bid/{$id}' rel='facebox'>{$bidForThis}</a>
		</div>
	{/if}
	{if $grouptype eq 'user'}
		<div>
			<a href='javascript:void(0);' id='reportBlog_{$id}' class='report'>{$reportBlog}</a>
		</div>
	{/if}
</div>

<div class="content right twentyfivepercent">
	<div class="blogPhoto">
		{if $grouptype eq 'admin'}<a href='javascript:void(0);' id='uploadNewPhoto'>{/if}
			<img src="/user/getUserAvatar/{$username}.png" alt="{$name}"/>
		{if $grouptype eq 'admin'}</a>{/if}
	</div>

	{if $grouptype eq 'admin'}
		<div id='uploadPhoto'>
			<form id='uploadPhotoForm' method='post' action="/user/uploadPhoto/{$username}" enctype='multipart/form-data'>
				{$newPhoto} : <input type='file' name='photo' id='uploadPhotoFileInput'/>
				<input type='submit' value="{$submit}" />
				<input type='button' value="{$cancel}" id='uploadNewPhotoCancel'/>
			</form>
		</div>
	{/if}
	<div>
		<h4>{$contacts}</h4>
		<span id='contact_{$id}' class='toUpdate'>
			<img src='/images/contact/MP.gif' alt='MP' title='MP'/> <a href='/mp/newmessage/{$adminName}'>{$adminName}</a><br/>
		</span>
		{assign var=counter value=0}
		{foreach from=$contactsValue item=curr}
			<span id='contact_{$id}_{$curr.id}'>
				<img src='/images/contact/{$curr.logo}' alt='{$curr.type}' title='{$curr.type}' /> {$curr.value} {if $grouptype eq 'admin'}<a href='javascript:void(0);' id='deleteContact_{$id}_{$curr.id}' class="deleteUser"> X </a>{/if}<br/>
			</span>
		{/foreach}
		{if $grouptype eq 'admin'}
			<select id='addContactSelect_{$id}' class='selectSort'>
				<option value='0'>{$newContact}</option>
			{foreach from=$contactList item=curr}
				<option value='{$curr.CONTACTTYPE_ID}'>{$curr.CONTACTTYPE_NAME}</option>
			{/foreach}
			</select><br/>
			<a href='javascript:void(0);' id='addContact_{$id}' class="addContact">{$addContact}</a>
		{/if}
	</div>
</div>
<div class="content right twentyfivepercent">
	<script type="text/javascript"><!--
		google_ad_client = "pub-1822012365098023";
		{*/* 200x200, date de création 19/08/09 */*}
		google_ad_slot = "6620356888";
		google_ad_width = 200;
		google_ad_height = 200;
		//-->
	</script>
	<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
</div>

<div class='spacer'>&nbsp;</div>

<div id='description_{$id}' class='{if $grouptype eq 'admin'}editRichUser editHighliter {/if}content'>
	{$description}
</div>

<div class="content playerBlog">
	<div id='player'>&nbsp;</div>
</div>

<div class="content compoBlog">
	<h3>{$compositionsText}</h3>
	<ul id="compositions">
		{foreach from=$compos item=folder key=folderId}
		<li>
			<a href='#' class='header'>{$folder.NAME}</a>
			<div>
				{foreach from=$folder.COMPO item=file}
				{assign var=k value=$file.ID}
				<div class='compoLine'>
					<a href="javascript:void(0);" id='componame_{$k}' class='playcompo{$file.TYPE}'>{$file.NAME}</a>
					<span>
						{if $grouptype eq 'user'}<a href='javascript:void(0);' id='reportMusic_{$k}' class='report'>{$reportThis}</a>{/if}
						<a href='#commentInterface' id='comment_compo_{$k}' class='comment'>{$comments}</a>
					</span>
					<span class='absolute'>
						<span class='compoVoting'>
							{if $notes.$k.line}{$notes.$k.line}{else}&nbsp;{/if}
						</span>
						<span id='note_{$id}_{$k}'  class="right starRating{if $grouptype neq 'user'}Disabled{/if}">{$notes.$k.average}</span>
					</span>
				</div>
				{/foreach}
			</div>
		</li>
		{foreachelse}
			<li>{$nocompoText}</li>
		{/foreach}
	</ul>
	{if $grouptype neq 'user'}<a href='/studio/manage/{$username}'>{$goToStudio}</a>{/if}
</div>

<div class='spacer'>&nbsp;</div>

<div id='commentInterface' class="content commentBlog">&nbsp;</div>

{if $grouptype eq 'admin'}
	<div class='content updateGroupFull'>
		<label for='full_{$id}'>{$groupIsFull}</label><input type='checkbox' id='full_{$id}' class="crirHiddenJS" value="{if $isFull}true{else}false{/if}" {if $isFull}checked='checked'{/if} name='full_{$id}' />
	</div>
{/if}