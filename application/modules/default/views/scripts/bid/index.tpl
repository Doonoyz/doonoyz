<div class='content'>
        {foreach from=$bidList item=curr key=groupid}
        <div class='bidItem'>
                <h3>{$bidList.$groupid.0.GROUP_NOM}</h3>
                {foreach from=$curr item=user key=k}
                {assign var=userId value=$user.USER_ID}
                <div class="bidUser">
                        <span>{$userWantJoin} : <a href='/mp/newmessage/{$userNames.$userId}'>{$userNames.$userId}</a></span>
                        <div>
                                <h4>{$competencies}</h4>
                                {assign var=counter value=0}
                                {foreach from=$userInfos.$groupid.$userId item=comp}
                                  {if $counter} / {/if}<span>{$translate->translate($comp.COMPETENCE_NAME)}</span>
                                  {assign var=counter value=$counter+1}
                                {/foreach}
                        </div>
                        <span id='bidTools'>
                                <a href="javascript:void(0);" id='accept_{$user.BID_ID}' class="bidToThis"><img src='/images/accept.gif'  title="{$accept}" alt="{$accept}" /></a>
                                <a href="javascript:void(0);" id='decline_{$user.BID_ID}' class="bidToThis"><img src='/images/refuse.gif'  title="{$refuse}" alt="{$refuse}" /></a>
                        </span>
                </div>
                {/foreach}
        </div>
        {foreachelse}
                {$nothing}
        {/foreach}
</div>