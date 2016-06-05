{include file='pagination.tpl' classToUse='pagineComment'}

<div class='comments content'>
{assign var=counter value=0}
{foreach from=$comments item=curr key=k}
	<div class='commentItem{if $counter eq 0}Last{/if}'>
		<span class='commentTitle'>{$curr.COMMENT_DATE} - <a href='/mp/newmessage/{$userList.$userId}'>{$userList.$userId}</a></span>
		<div>
			{$curr.COMMENT_BODY}
		</div>
		{assign var=userId value=$curr.USER_ID}
	</div>
	{assign var=counter value=$counter+1}
{foreachelse}
	<div class='commentItemLast'>
		{$noComment}
	</div>
{/foreach}
</div>

{include file='pagination.tpl' classToUse='pagineComment'}

{if $connected}
<div>
	<form id='answerComment' action='javascript:void(0);' method='post' class='formtool'>
		<h4>{$newComment}</h4>
		<input type='hidden' name='type' value='{$commentType}' />
		<input type='hidden' name='id' value='{$commentId}' />
		<textarea name='body' class='expanding'></textarea>
		<input type='image' src='/images/accept.gif' name='submit' title="{$submit}" class='tool' />
	</form>
</div>
{else}
<div>
{$connectedOrRegister}
</div>
{/if}
<div id='csrftoken' class='hidden'>{$token}</div>
