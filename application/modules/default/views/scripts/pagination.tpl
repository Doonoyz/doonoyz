{* Pagination *}
<div class="pagination">
	{if $page gt 1}
		<a href='javascript:void(0);' id='pageprevious_{$page-1}' class='{$classToUse}'>◄</a>
	{/if}
	{if $totalPage < 13}
		{section name=pagination start=1 loop=$totalPage+1 step=1}
			{if $smarty.section.pagination.index ne $page}
				<a href='javascript:void(0);' id='page_{$smarty.section.pagination.index}' class='{$classToUse}'>{$smarty.section.pagination.index}</a>
			{else}
				<span class='active'>{$smarty.section.pagination.index}</span>
			{/if}
		{/section}
	{else}
		<a href='javascript:void(0);' id='page_1' class='{$classToUse}'>1</a>
		<a href='javascript:void(0);' id='page_2' class='{$classToUse}'>2</a>
		...
		{section name=pagination start=$page-3 loop=8 step=1}
			{if $smarty.section.pagination.index ne $page}
				<a href='javascript:void(0);' id='page_{$smarty.section.pagination.index}' class='{$classToUse}'>{$smarty.section.pagination.index}</a>
			{else}
				<span class='active'>{$smarty.section.pagination.index}</span>
			{/if}
		{/section}
		...
		<a href='javascript:void(0);' id='page_{$totalPage-1}' class='{$classToUse}'>{$totalPage-1}</a>
		<a href='javascript:void(0);' id='page_{$totalPage}' class='{$classToUse}'>{$totalPage}</a>
	{/if}
	{if $page lt $totalPage}
		<a href='javascript:void(0);' id='pagenext_{$page+1}' class='{$classToUse}'>►</a>
	{/if}
</div>
{* /Pagination *}