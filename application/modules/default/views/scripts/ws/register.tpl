<div class='content'>
    {if $success ne "none"}
     {if $error eq "none"}
        <div id="successmsg">{$success}</div>
      {else}
        <div id="errormsg">{$error}</div>
      {/if}
    {else}
	<div id='moreInfoOtherPart'>
  <form method='post' action="#" id='register' class='formtool'>

	<h1>{$register}</h1>
    <span class='block'><label for='mail'>{$mail}</label><input type='text' name='mail' value="{$mailValue}"/></span>
    <span class='block'><label for='login'>{$login}</label><input type='text' name='login' value="{$loginValue}"/></span>
    <span class='block'><label for='name'>{$name}</label><input type='text' name='name' value="{$nameValue}"/></span>
    <span class='block'><label for='firstname'>{$firstName}</label><input type='text' name='firstname' value="{$firstNameValue}"/></span>
    <span class='block'><label for='password'>{$password}</label><input type='password' name='password' value="{$passwordValue}"/></span>
    <span class='block'><label for='password2'>{$confirmPassword}</label><input type='password' name='password2' value="{$passwordValue2}"/></span>
    <span class='block'><img src='/ws/showcaptcha' alt='captcha' id='captcha'/><a href='javascript:void(0);' onclick="$('#captcha')[0].src = '/ws/showcaptcha/'+Math.random();"><img src='/images/reload.gif' alt='reload' title='reload'/></a></span>
    <span class='block'><label for='captcha'>{$securityCode}</label><input type='text' name='captcha' value=""/></span>
    {if $error ne "none"}<div id="errormsg">{$error}</div>{/if}
    <input type='image' name='submit' src='/images/accept.gif' class='tool' title="{$registerSubmit}" />
  </form>
  </div>
    {/if}
</div>
