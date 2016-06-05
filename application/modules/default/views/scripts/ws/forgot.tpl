<div class='content'>

  <form method='post' action="#" id='forgot' class='formtool'>
	<h1>{$forgot}</h1>
    {if $successMsg ne "none"}
    <div id="successmsg">{$successMsg}</div>
    
    {else}
    
    {$introforgot}<br/>
    <span class='block'><label for='mail'>{$mail}</label><input type='text' name='mail' value="{$loginValue}"/></span>
    <br/>
    <br/>
    <input class='tool' type='image' src='/images/accept.gif' />
    {/if}
  </form>
</div>
  {if $successMsg eq "none"}{if $errorMsg ne "none"}<div id="errormsg" class='content'>{$errorMsg}</div>{/if}{/if}