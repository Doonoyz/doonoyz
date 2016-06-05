<div class='content'>
	<div id='moreInfoOtherPart'>
  <form method='post' action="#" id='register' class='formtool'>
  <h1>{$invitation}</h1>

    {if $success eq "none"}  
    <span class='block'><label for='mail'>{$mail}</label>{$mailValue}</span>
    <span class='block'><label for='login'>{$login}</label><input type='text' name='login' value="{$loginValue}"/></span>
    <span class='block'><label for='name'>{$name}</label><input type='text' name='name' value="{$nameValue}"/></span>
    <span class='block'><label for='firstname'>{$firstName}</label><input type='text' name='firstname' value="{$firstNameValue}"/></span>
    <span class='block'><label for='password'>{$password}</label><input type='password' name='password' value="{$passwordValue}"/></span>
    <span class='block'><label for='password2'>{$confirmPassword}</label><input type='password' name='password2' value="{$passwordValue2}"/></span>
    {if $error ne "none"}<div id="errormsg">{$error}</div>{/if}
    <input type='image' name='submit' src='/images/accept.gif' class='tool' title="{$submit}" />
    {/if}
  </form>
  </div>
</div>
{if $success ne "none"}  
{if $error eq "none"}
	<div class='content' id="successmsg">{$success}</div>
{else}
	<div class='content' id="errormsg">{$error}</div>
{/if}
{/if}
