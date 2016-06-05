<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
        <head>
			<title>Doonoyz :: {dynamic}{$title}{/dynamic}</title>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			
			{if $environment eq 'prod'}
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
			<!--[if lt IE 7]>
			<link href="/css/simplemodalie7.css" rel="stylesheet" type="text/css" />
			<![endif]-->
			<link rel="shortcut icon" href="http://www.doonoyz.com/favicon.ico" />
			
			<script type="text/javascript" src="/javascript/tiny_mce/tiny_mce.js"></script>
			{if $environment eq 'prod'}
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
        </head>
        <body>
				<div id='loader'><img src='/images/ajaxloader.gif' alt="{$loading}" /> {$loading}</div>
                <div id="header">
                        <div id="logo"><a href="/"><img src='/images/top_logo.gif' alt="Doonoyz" /></a></div>
                        <div id='menu'>
						<ul>
						{dynamic}
						<li class="last"><a href='/ws/settings'>({$myUsername})</a></li>
						<li class="last"><a href="/ws/disconnect/token/{$tokenUser}">{$disconnect}</a></li>
						<li><a href="/admin">{$tasks}</a></li>
						<li><a href="/admin/groups">{$manageGroups}</a></li>
						<li><a href="/admin/editcomponent">{$editComponent}</a></li>
						<li><a href="/admin/user">{$editUser}</a></li>
						<li><a href="/admin/home">{$manageHome}</a></li>
						{/dynamic}
                        </ul>
                        </div>
                </div>
                <div id="body">
                        <div id="right">
                                {dynamic}{$templateRenderer}{/dynamic}
                        </div>
                        <br class="spacer" />
                </div>

                <div id="footer">
						<div class='footcol'>
                        <ul>
                                <li><a href="/">Home</a></li>
                                <li><a href="mailto:contact@doonoyz.com">{$bugOrContact}</a></li>
                                <li><a href="http://contactbook.doonoyz.com">Contact Book</a></li>
                                <li><a href="http://blog.doonoyz.com">Blog</a></li>
                        </ul>
                        </div>
                        <div class='footcol last'>
							<a href="/"><img src='/images/foot_logo.gif' alt='Doonoyz' /></a>
                        </div>
                </div>
                <div class='ressources'>
					<div id='csrfSecurityCode'>{$token}</div>
                </div>
                <script type="text/javascript">
                        //<![CDATA[
                        setJsTexts('{$JavaScriptTexts}');
                        //]]>
                </script>
  </body>
</html>