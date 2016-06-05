<div>
        <h1>{$invitation}</h1>
        <div>
                <div>{$presentation}</div>
                <div>{$usernameText} : {$username}</div>
                <form method='post' action='/invitation/validate/{$userId}' id='prepareInvitation'>
                        <div>{$competenciesText} :
                                <div id='addingComp'>
                                        {assign var=counter value=0}
                                        {foreach from=$competencies item=curr key=k}
                                                <span>
                                                <input type='hidden' name="comp[]" value="{$k}">
                                                {if $counter} / {/if} {$translate->translate($curr)} <a href='javascript:void(0);' id='deleteComp_{$k}' class="deleteComp"> X </a>
                                                {assign var=counter value=$counter+1}
                                                </span>
                                        {/foreach}
                                </div>
                                <div>
                                        <select id='addComp' class='selectSort'>
                                                <option value='0'>{$newCompetence}</option>
                                                {foreach from=$competenceList item=curr}
                                                        <option value='{$curr.COMPETENCE_ID}'>{$translate->translate($curr.COMPETENCE_NAME)}</option>
                                                {/foreach}
                                        </select>
                                        <a href='javascript:void(0);' id='addCompLink'>{$addCompetence}</a>
                                </div>
                        </div>
                        <div>
                                <select name="selectedGroup" id='selectedGroup' class='selectSort'>
                                        <option value='0'>{$newGroup}</option>
                                        {foreach from=$groupList item=curr}
                                                <option value='{$curr.GROUP_ID}'>{$curr.GROUP_NOM}</option>
                                        {/foreach}
                                </select>
                        </div>
                        <input type='button' value='{$invite}' id='submitInvite_{$userId}' class='submitInvite'/>
                </form>
        </div>
</div>
<div id='csrfSecurityCodeAjax' class='ressources'>{$token}</div>