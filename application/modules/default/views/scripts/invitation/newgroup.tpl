
<form method='post' action='javascript:void(0);' id='createNewGroupFrom' class='formtool'>
	<h1>{$newGroup}</h1>
  <span>{$groupUrl} *</span><br/>
  <span>http://www.doonoyz.com/<input type='text' name='name' /></span><br/>
  <span>{$groupName}</span><br/>
  <span><input type='text' name='groupname' /></span><br/>
  <div class='tool'><input type='image' src='/images/accept.gif' title="{$create}" name='commitGroup'/></div>
</form>

* {$required}
<div id='csrfSecurityCodeAjax' class='ressources'>{$token}</div>