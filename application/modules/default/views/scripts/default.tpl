<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
        <head>
			<title>Doonoyz :: {dynamic}{$title}{/dynamic}</title>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<META NAME="Description" CONTENT="{$textPresentation.4}" />
			<META NAME="Keywords" CONTENT="{$keywords}" /> 
			<META NAME="Indentifier-URL" CONTENT="http://www.doonoyz.com" /> 
			<META NAME="Copyright" CONTENT="Doonoyz" />
			<META NAME="Robots" CONTENT="All" />
			<META NAME="Robots" CONTENT="Index, Follow" />
			<META NAME="Revisit-after" CONTENT="7" />
			
			{if $environment eq "prod"}
			<link href="/css/engine.css?rev={$cssver}" rel="stylesheet" type="text/css" />
			{else}
			<link href="/css/private/01-style.css" rel="stylesheet" type="text/css" />
			<link href="/css/private/02-addedRules.css" rel="stylesheet" type="text/css" />
			<link href="/css/private/03-crir.css" rel="stylesheet" type="text/css" />
			<link href="/css/private/04-facebox.css" rel="stylesheet" type="text/css" />
			<link href="/css/private/05-ui.stars.css" rel="stylesheet" type="text/css" />
			<link href="/css/private/06-simplemodal.css" rel="stylesheet" type="text/css" />
			<link href="/css/private/07-common.css" rel="stylesheet" type="text/css" />
			<link href="/css/private/08-uploadify.css" rel="stylesheet" type="text/css" />
			{/if}
			<link rel="shortcut icon" href="http://www.doonoyz.com/favicon.ico" />
			<!--[if lt IE 7]>
			<link href="/css/simplemodalie7.css" rel="stylesheet" type="text/css" />
			<![endif]-->
			{foreach from=$rssFeeds item=title key=url}
			<link rel="alternate" type="application/rss+xml" title="{$title}" href="{$url}" />
			{/foreach}
			
			{* i know that js should be loaded at the end but all JS are required for the correct use of the site *}
		</head>
        <body>
				<div id='loader'><img src='/images/ajaxloader.gif' alt="{$loading}" /> {$loading}</div>
				<div class="languageDrop">
					<div class="dropdown-menu">
						<div class="menu-first">{$languageText}</div>
						<ul class="down-list" style="display:none;">
							{foreach from=$languages item=text key=lang}
							<li><a href="/language/{$lang}"><img src='/images/flag/{$lang}.jpg' alt='{$lang}' /> {$text}</a></li>
							{/foreach}
						</ul>
					</div>

				</div>
                <div id="header">
                        <div id="logo"><a href="/"><img src='/images/top_logo.gif' alt="Doonoyz" /></a></div>
                        <div id='searchBox'>
                          <form method='post' action='/search/quicksearch' id='quickSearchEngine'>
                          <label for='criteria'>{$search}</label><input type='text' name='criteria' id='criteria'/>
                          <input type='image' src='/images/pxl.gif' id='searchsubmit'/>
                          </form>
                        </div>
                        <div id='menu'>
						<ul>
							{dynamic}
							{if $userId eq 0}
							<li class="last"><a href="/ws/login">{$login}</a></li>
							<li><a href="/ws/register">{$register}</a></li>
							<li><a href="/search/advanced">{$advancedSearch}</a></li>
							{else}
							<li class="last"><a href='/ws/settings'>({$myUsername})</a></li>
							<li class="last"><a href="/ws/disconnect/token/{$tokenUser}">{$disconnect}</a></li>
							<li><a href="/search/advanced">{$advancedSearch}</a></li>
							<li><a href="/mp">{$privateMP}{if $newMPNumber}<b> ({$newMPNumber})</b>{/if}</a></li>
							<li><a href="/groups">{$manageMyGroups}</a></li>
							<li><a href="/invitation/newgroup" rel='facebox'>{$createGroup}</a></li>
							<li><a href="/studio">{$studio}</a></li>
							{if $isAdmin}<li><a href="/admin">{$admin}</a></li>{/if}
							{if $newInvitationNumber}<li><a href="/groups">{$invitations}<b> ({$newInvitationNumber})</b></a></li>{/if}
							{if $newBidNumber}<li><a href="/bid">{$newBid}<b> ({$newBidNumber})</b></a></li>{/if}
							<li><a href="/">{$home}</a></li>
							{/if}
							{/dynamic}
						</ul>
						</div>
                </div>
                <div id="body">
                        <div id="right">
                                {dynamic}{$templateRenderer}{/dynamic}
                                <div class='content'>
									<script type="text/javascript"><!--
										google_ad_client = "pub-1822012365098023";
										{*/* 728x90, date de création 19/08/09 */*}
										google_ad_slot = "9985608119";
										google_ad_width = 728;
										google_ad_height = 90;
										//-->
									</script>
									<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
                                </div>
                        </div>
                        <br class="spacer" />
                </div>
               
                <div class="ressources">
						<div id='csrfSecurityCode'>{dynamic}{$token}{/dynamic}</div>
                        <div id="starRating">
                                <input name="newrate" value="1" title="{$veryPoor}" type="radio" />
                                <input name="newrate" value="2" title="{$poor}" type="radio" />
                                <input name="newrate" value="3" title="{$notThatBad}" type="radio" />
                                <input name="newrate" value="4" title="{$fair}" type="radio" />
                                <input name="newrate" value="5" title="{$average}" checked="checked" type="radio" />
                                <input name="newrate" value="6" title="{$almostGood}" type="radio" />
                                <input name="newrate" value="7" title="{$good}" type="radio" />
                                <input name="newrate" value="8" title="{$veryGood}" type="radio" />
                                <input name="newrate" value="9" title="{$excellent}" type="radio" />
                                <input name="newrate" value="10" title="{$perfect}" type="radio" />
                        </div>
                       
                        <div id='mpToolBox' class='hidden'>
                                <input type='button' name='mpAnswer' value="{$answerMp}" id='mpAnswer' />
                                <input type='button' name='mpDelete' value="{$deleteMp}" id='mpDelete' />
                                <div id='mpText' class='hidden'>
                                        <form method='post' action='/mp/newmessage' id='mpResponseForm' class='formtool'>
                                                <div>
                                                        <textarea name='body' class="expandable"></textarea>
                                                        <input type="hidden" name='username' id='mpUsername' value="" />
                                                        <input type="hidden" name='title' id='mpTitle' value="" />
                                                        <input type="hidden" name='messageId' id='mpMessageId' value="0" />
                                                        <input type="image" src='/images/accept.gif' class='tool' name='sendnew' title="{$submit}" />
                                                </div>
                                        </form>
                                </div>
                        </div>
                </div>
                
                <div id="footer">
                        <div class='footcol last'>
							<a href="/"><img src='/images/top_logo.gif' id='footLogo' alt='Doonoyz' /></a>
                        </div>
                        <div class='footcol'>
							<ul>
								<li><a href="/">{$home}</a></li>
								<li><a href="mailto:contact@doonoyz.com">{$bugOrContact} : contact@doonoyz.com</a></li>
								{*<li><a href="http://contactbook.doonoyz.com">Contact Book</a></li>*}
								<li><a href="http://www.femtopixel.com/">Powered by FemtoPixel</a></li>
								<li><a href="http://blog.doonoyz.com">Blog</a></li>
							</ul>
                        </div>
                        <div class='footcol'>
							<ul>
								<li><a href="https://twitter.com/doonoyz">Twitter</a></li>
								<li><a href="http://www.facebook.com/pages/Doonoyz/100239361049">Facebook Page</a></li>
								<li><a href="http://www.facebook.com/group.php?gid=120483857177">Facebook Group</a></li>
								<li>&nbsp;</li>
							</ul>
                        </div>
                </div>
                <script type="text/javascript" src="/javascript/tiny_mce/tiny_mce.js"></script>
				{if $environment eq "prod"}
				<script type="text/javascript" src="/javascript/engine.js?rev={$jsver}"></script>
				{else}
				<script type="text/javascript" src="/javascript/private/01-json.js"></script>
				<script type="text/javascript" src="/javascript/private/02-jquery.js"></script>
				<script type="text/javascript" src="/javascript/private/03-jquery.jeditable.js"></script>
				<script type="text/javascript" src="/javascript/private/04-jquery.richeditor.js"></script>
				<script type="text/javascript" src="/javascript/private/05-jquery.autogrow.js"></script>
				<script type="text/javascript" src="/javascript/private/06-jquery.scrollTo.js"></script>
				<script type="text/javascript" src="/javascript/private/07-jquery.localscroll.js"></script>
				<script type="text/javascript" src="/javascript/private/08-jquery.uploadify.js"></script>
				<script type="text/javascript" src="/javascript/private/09-ui.core.min.js"></script>
				<script type="text/javascript" src="/javascript/private/10-ui.stars.pack.js"></script>
				<script type="text/javascript" src="/javascript/private/11-jquery.easing.js"></script>
				<script type="text/javascript" src="/javascript/private/12-jquery.accordion.js"></script>
				<script type="text/javascript" src="/javascript/private/13-jquery.bgiframe.js"></script>
				<script type="text/javascript" src="/javascript/private/14-facebox.js"></script>
				<script type="text/javascript" src="/javascript/private/15-jquery.simplemodal.js"></script>
				<script type="text/javascript" src="/javascript/private/16-crir.js"></script>
				<script type="text/javascript" src="/javascript/private/17-messages.js"></script>
				<script type="text/javascript" src="/javascript/private/18-library.js"></script>
				<script type="text/javascript" src="/javascript/private/19-mpEngine.js"></script>
				<script type="text/javascript" src="/javascript/private/20-bidEngine.js"></script>
				<script type="text/javascript" src="/javascript/private/21-userEngine.js"></script>
				<script type="text/javascript" src="/javascript/private/22-groupsEngine.js"></script>
				<script type="text/javascript" src="/javascript/private/23-generalEngine.js"></script>
				<script type="text/javascript" src="/javascript/private/24-commentEngine.js"></script>
				<script type="text/javascript" src="/javascript/private/25-invitationEngine.js"></script>
				<script type="text/javascript" src="/javascript/private/26-studioEngine.js"></script>
				<script type="text/javascript" src="/javascript/private/27-searchEngine.js"></script>
				<script type="text/javascript" src="/javascript/private/28-swfobject.js"></script>
				<script type="text/javascript" src="/javascript/private/29-compoEngine.js"></script>
				<script type="text/javascript" src="/javascript/private/30-adminEngine.js"></script>
				<script type="text/javascript" src="/javascript/private/31-final.js"></script>
				{/if}
                <script type="text/javascript">
                        //<![CDATA[
                        setJsTexts('{$JavaScriptTexts}');
                        //]]>
                </script>
  </body>
</html>
