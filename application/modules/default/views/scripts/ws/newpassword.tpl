{if $successMsg eq "none"}
<div class='content'>

  <form method='post' action="#" id='forgot' class='formtool'>
	<h1>{$forgot}</h1>
    <span class='block'><label for='password'>{$password}</label><input type='password' name='password' value=""/></span>
    <span class='block'><label for='chackpassword'>{$checkpassword}</label><input type='password' name='checkpassword' value=""/></span>

    <input type='image' name='submit' src='/images/accept.gif' class='tool' title="{$submit}" />

    {if $errorMsg ne "none"}<div id="errormsg">{$errorMsg}</div>{/if}

  </form>
</div>
{else}
      {if $errorMsg ne "none"}
        <div class='content' id="errormsg">{$errorMsg}</div>
      {else}
        <div class='content' id="successmsg">{$successMsg}</div>
      {/if}
{/if}
      