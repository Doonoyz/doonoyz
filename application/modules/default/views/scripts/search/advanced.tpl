<div class="ressources">
	<div id='ASECriteriaGroup'>
	{$isa}
	<select name='filter[__UNIQUE__][GROUP][NOT]'>
	<option value='0'>{$group}</option>
	<option value='1'>{$user}</option>
	</select>
	<a href='javascript:void(0);' class='deleteCriteria'><img src="/images/login_cancel.jpg" title="{$delete}" alt="{$delete}" /></a>
	</div>

	<div id='ASECriteriaGroupName'>
	{$name}
	<select name='filter[__UNIQUE__][GROUP_NAME][NOT]'>
	<option value='0'>{$like}</option>
	<option value='1'>{$notLike}</option>
	</select>
	<input type='text' value='' name='filter[__UNIQUE__][GROUP_NAME][]'/>
	<a href='javascript:void(0);' class='deleteCriteria'><img src="/images/login_cancel.jpg" title="{$delete}" alt="{$delete}" /></a>
	</div>

	<div id='ASECriteriaCompetence'>
	<select name='filter[__UNIQUE__][COMPETENCE][NOT]'>
	<option value='0'>{$contain}</option>
	<option value='1'>{$notContain}</option>
	</select> {$competence}
	<select name='filter[__UNIQUE__][COMPETENCE][VALUE]'>
		{foreach from=$competenceList item=curr}
			<option value='{$curr.COMPETENCE_ID}'>{$translate->translate($curr.COMPETENCE_NAME)}</option>
		{/foreach}
	</select>
	<a href='javascript:void(0);' class='deleteCriteria'><img src="/images/login_cancel.jpg" title="{$delete}" alt="{$delete}" /></a>
	</div>

	<div id='ASECriteriaStyle'>
	<select name='filter[__UNIQUE__][STYLE][NOT]'>
	<option value='0'>{$contain}</option>
	<option value='1'>{$notContain}</option>
	</select> {$style}
	<select name='filter[__UNIQUE__][STYLE][VALUE]'>
		{foreach from=$styleList item=curr}
          <option value='{$curr.STYLE_ID}'>{$curr.STYLE_NAME}</option>
        {/foreach}
	</select>
	<a href='javascript:void(0);' class='deleteCriteria'><img src="/images/login_cancel.jpg" title="{$delete}" alt="{$delete}" /></a>
	</div>

	<div id='ASECriteriaGroupDesc'>
	{$description}
	<select name='filter[__UNIQUE__][GROUP_DESC][NOT]'>
	<option value='0'>{$like}</option>
	<option value='1'>{$notLike}</option>
	</select>
	<input type='text' value='' name='filter[__UNIQUE__][GROUP_DESC][VALUE]'/>
	<a href='javascript:void(0);' class='deleteCriteria'><img src="/images/login_cancel.jpg" title="{$delete}" alt="{$delete}" /></a>
	</div>

	<div id='ASECriteriaGroupFull'>
	<select name='filter[__UNIQUE__][GROUP_FULL][NOT]'>
	<option value='0'>{$is}</option>
	<option value='1'>{$isNot}</option>
	</select>
	{$full}
	<a href='javascript:void(0);' class='deleteCriteria'><img src="/images/login_cancel.jpg" title="{$delete}" alt="{$delete}" /></a>
	</div>

	<div id='ASECriteriaGroupPays'>
	{$country}
	<select name='filter[__UNIQUE__][GROUP_PAYS][NOT]'>
	<option value='0'>{$like}</option>
	<option value='1'>{$notLike}</option>
	</select>
	<input type='text' value='' name='filter[__UNIQUE__][GROUP_PAYS][VALUE]'/>
	<a href='javascript:void(0);' class='deleteCriteria'><img src="/images/login_cancel.jpg" title="{$delete}" alt="{$delete}" /></a>
	</div>

	<div id='ASECriteriaGroupUrl'>
	{$url}
	<select name='filter[__UNIQUE__][GROUP_URL][NOT]'>
	<option value='0'>{$like}</option>
	<option value='1'>{$notLike}</option>
	</select>
	<input type='text' value='' name='filter[__UNIQUE__][GROUP_URL][VALUE]'/>
	<a href='javascript:void(0);' class='deleteCriteria'><img src="/images/login_cancel.jpg" title="{$delete}" alt="{$delete}" /></a>
	</div>

	<div id='ASECriteriaGroupVille'>
	{$city}
	<select name='filter[__UNIQUE__][GROUP_VILLE][NOT]'>
	<option value='0'>{$like}</option>
	<option value='1'>{$notLike}</option>
	</select>
	<input type='text' value='' name='filter[__UNIQUE__][GROUP_VILLE][VALUE]'/>
	<a href='javascript:void(0);' class='deleteCriteria'><img src="/images/login_cancel.jpg" title="{$delete}" alt="{$delete}" /></a>
	</div>

	<div id='ASECriteriaDistance'>
	{$located}
	<select name='filter[__UNIQUE__][DISTANCE][NOT]'>
	<option value='0'>{$lessOrEqual}</option>
	<option value='1'>{$more}</option>
	</select>
	<input type='text' value='' name='filter[__UNIQUE__][DISTANCE][VALUE]'/>
	{$kmForCity}
	<input type='text' value="{$persoCity}" name='filter[__UNIQUE__][DISTANCE][SPECIAL][CITY]'/>
	{$wichPostal}
	<input type='text' value="{$persoPostal}" name='filter[__UNIQUE__][DISTANCE][SPECIAL][POSTAL]'/>
	{$inCountry}
	<input type='text' value="{$persoCountry}" name='filter[__UNIQUE__][DISTANCE][SPECIAL][COUNTRY]'/>
	<a href='javascript:void(0);' class='deleteCriteria'><img src="/images/login_cancel.jpg" title="{$delete}" alt="{$delete}" /></a>
	</div>
	
	<div id='ASECriteriaLabel'>
	<select name='filter[__UNIQUE__][LABEL][NOT]'>
	<option value='0'>{$contain}</option>
	<option value='1'>{$notContain}</option>
	</select> {$label}
	<select name='filter[__UNIQUE__][LABEL][VALUE]'>
		<option value="0">{$noLabel}</option>
		{foreach from=$labelList item=curr}
			<option value='{$curr.LABEL_ID}'>{$curr.LABEL_NAME}</option>
		{/foreach}
	</select>
	<a href='javascript:void(0);' class='deleteCriteria'><img src="/images/login_cancel.jpg" title="{$delete}" alt="{$delete}" /></a>
	</div>
</div>

<div class='content'>
<a href='javascript:void(0);' id='menuToggleAdvanced'>{$toggleAdvanced}</a>
</div>
<div id='toggleAdvancedSearch' class="content" {if $hideEngine}style='display:none'{/if}>
	<div>
		<select id='filterSelect' name='filterSelect'>
			<option>{$selectFilter}</option>
			<option value='Group'>{$groupFilter}</option>
			<option value='GroupName'>{$groupNameFilter}</option>
			<option value='Competence'>{$competenceFilter}</option>
			<option value='Style'>{$styleFilter}</option>
			<option value='GroupDesc'>{$groupDescFilter}</option>
			<option value='GroupFull'>{$groupFullFilter}</option>
			<option value='GroupPays'>{$groupPaysFilter}</option>
			<option value='GroupVille'>{$groupVilleFilter}</option>
			<option value='GroupUrl'>{$groupUrlFilter}</option>
			<option value='Distance'>{$distanceFilter}</option>
			<option value='Label'>{$labelFilter}</option>
		</select>
		<a href='javascript:void(0);' id='chooseCriteria'><img src='/images/studiomanage_add.jpg' title="{$addFilter}" /></a>
	</div>
	<form method='post' action='/search/advancedpost' id='searchEngineForm'>
		<div id='engineCriterias'>
		{if $hideEngine}{$presetEngine}{/if}
		</div>
		<input type='hidden' name='presetEngineValues' id='presetEngineValues' value='{if $hideEngine}{$presetEngineValues}{/if}'/>
		<input type='hidden' name='presetEngine' id='presetEngine' />
		<input type='submit' value='{$submit}' />
	</form>
</div>

{if $hideEngine}
<div id='searchEngineResults' class='content'>
{include file='search/showresult.tpl'}
</div>
{/if}