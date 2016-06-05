<div class='content'>

  <form method='post' action="#" id='settings' class='formtool'>
  <h1>{$settings}</h1>
  <h2>{$mail}</h2>
  <h3>{$name} {$firstname}</h3>
      <span class='block'><label for='password'>{$password}</label><input type='password' name='password' /></span>
      <span class='block'><label for='password2'>{$confirmPassword}</label><input type='password' name='password2' /></span>
    <br/>
    <input type='image' name='submit' src='/images/accept.gif' class='tool' title="{$save}" />
  </form>
	<a href='/ws/unregister'>{$unregister}</a>
</div>
{if $errorMsg ne "none"}<div class='content' id="errormsg">{$errorMsg}</div>{/if}