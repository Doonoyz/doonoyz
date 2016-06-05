<div class='content'>
	<h1>{$manageMostAppreciated}</h1>
	<select id='mostApSelect'>
		{foreach from=$available item=curr}
		<option value='{$curr.GROUP_ID}'>{$curr.GROUP_URL}</option>
		{/foreach}
	</select>
	<a href='javascript:void(0);' id='addSelectedMostAp'>{$addSelected}</a>
	<div id='mostApList'>
	{foreach from=$selected item=curr}
		<div id='mostAp_{$curr.GROUP_ID}'>{$curr.GROUP_URL} <a href='javascript:void(0);' class='deleteMostAp'>X</a></div>
	{/foreach}
	</div>
	<a href='javascript:void(0);' id='saveMostAp'>{$saveModif}</a>
</div>