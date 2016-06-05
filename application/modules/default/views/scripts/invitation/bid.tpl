<div id='bidToGroupAjax'>
        <h1>{$bid}</h1>
        <div>
                <div>{$presentation}</div>
                <div><b>{$group}</b> : {$groupname}</div>
                <form method='post' action='javascript:void(0);' id='prepareBid'>
					<input type='hidden' name='groupId' value='{$groupId}' />
					<input type='hidden' name='validateBid' value='1' />
					<div><b>{$competenciesText}</b> :
							<div id='addingComp'>
									{assign var=counter value=0}
									{foreach from=$competencies item=curr key=k}
											<span>
											<input type='hidden' name="comp[]" value="{$k}">
											{if $counter} / {/if} {$translate->translate($curr)} <a href='javascript:void(0);' id='deleteComp_{$k}' class="deleteComp"> <img src='/images/login_cancel.jpg' alt='X' /> </a>
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
									<a href='javascript:void(0);' id='addCompLink'><img src='/images/studiomanage_add.jpg' alt="{$addCompetence}" /></a>
							</div>
					</div>
					<input type='submit' value='{$bid}' id='submitBid_{$groupId}' class='submitBid'/>
                </form>
        </div>
</div>
<div id='csrfSecurityCodeAjax' class='ressources'>{$token}</div>