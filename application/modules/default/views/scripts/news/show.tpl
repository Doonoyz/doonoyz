<title>{$news} - {$group}</title>
<description><![CDATA[{$description}]]></description>
<link>http://www.doonoyz.com.com/{$group}</link>
<lastBuildDate>Thu, 07 Aug 2008 14:44:12 +0200</lastBuildDate>

{foreach from=$items item=curr}
<item>
		<title>{$curr.NEWS_TITLE}</title>
		<link>http://www.live360.fr/news/104437/Des-nouvelles-outre-frontieres-de-Tales-of-Vesperia.html</link>
		<description>Dans l&amp;#39;attente de la venue de certains titres chez nous, pauvres européens, il est intéressant de passer les frontières pour alimenter notre curiosité vidéoludique. Sortie depuis aujourd&amp;#39;hui au Japon, nous vous proposons un voyage vers l&amp;#39;Archipel afin de prendre quelques nouvelles de Tales of Vesperia. ...</description>
		<author>{$groupAdmin}</author>

		<pubDate>{$curr.title}Thu, 07 Aug 2008 13:47:20 +0200</pubDate>
</item>
{/foreach}