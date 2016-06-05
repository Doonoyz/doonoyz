<div class='content'>
	<div id='moreInfoDisplay'>
		{$moreInfo}
	</div>
	<div id='moreInfoOtherPart'>

	  <form method='post' action="#" id='login' class='formtool'>
		<h1>{$login}</h1>
		<span class='block'><label for='mail'>{$mail}<br/><sub>{$mailSub}</sub></label><input type='text' name='mail' value="{$loginValue}"/></span>
		<span class='block'><label for='password'>{$password}</label><input type='password' name='password' value="{$passwordValue}"/></span>
		<span id='loginrememberme' class="block"><label for='rememberme'>{$rememberMe}</label><input type="checkbox" id='rememberme' name='rememberme' class="crirHiddenJS" value="{$remembered}" {if $remembered eq 'true'}checked='checked'{/if}/></span>
		<input class='tool' type='image' src='/images/accept.gif' />
	  </form>
		<br/>
		<a href='/ws/forgot'>&gt; {$forgotPassword}</a><br/>
		<a href='/ws/register'>&gt; {$registerAccount}</a>
		<br/>
	  
	  <form method="post" action="#" class='formtool'>
		<h1>{$openIdLogin}&nbsp;<img src="/images/login-bg.gif" /></h1>
		<input type="text" name="openid_id" size="45" />
		<input type="hidden" name="loginType" value="openId" />
		<div class='spacer'>&nbsp;</div>
		<input type='image' name='submit' src='/images/accept.gif' class='tool' />
	  </form>
	</div>
	  {if $errorMsg ne "none"}<div id="errormsg">{$errorMsg}</div>{/if}
</div>