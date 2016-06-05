{foreach from=$results item=curr}
<url>
	<loc>http://www.doonoyz.com/{$curr.GROUP_URL}</loc>
	<changefreq>weekly</changefreq>
	<priority>0.8</priority>
</url>
{/foreach}