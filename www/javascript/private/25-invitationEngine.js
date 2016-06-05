function Engine_Invitation_DeleteComp() {
	$(".deleteComp").unbind('click').click(function ()
		{
			el = $(this)[0];
		  el.parentNode.parentNode.removeChild(el.parentNode);
		}
	  );
};

function Engine_Invitation_Init() {
$('.submitInvite').unbind('click').click(function ()
    {
		el = $(this)[0];
      var infos = $("#prepareInvitation").serialize();
      regexp = /([^_]+)_([0-9]+)/;
      var userTab = regexp.exec(el.id);
      invitationUserInGroup(userTab[2], $('#selectedGroup')[0].value, infos);
      return (false);
    }
  );
  
  $('.submitBid').unbind('click').click(function ()
    {
		el = $(this)[0];
      var infos = $("#prepareBid").serialize();
      Doonoyz.message.create('Engine_Invitation.submitBid.onclick');
      $.post('/invitation/bid/0', infos, function (t) {
		try {
			t = JSON.parse(t);
			$.facebox.close();
			Doonoyz.message.getInstance('Engine_Invitation.submitBid.onclick').display(t['default']);
		} catch (exception) {
			Doonoyz.message.getInstance('Engine_Invitation.submitBid.onclick').instance.className = 'errorPopup';
			Doonoyz.message.getInstance('Engine_Invitation.submitBid.onclick').display(getString('bigError'));
		}
      });
      return (false);
    }
  );
 
  Engine_Invitation_DeleteComp();
 
  $('#addCompLink').unbind('click').click(function ()
    {
		el = $(this)[0];
      if ($('#addComp')[0].value == 0)
      {
        valuePost = prompt(getString('newCompetenceName'));
        if (valuePost != null && valuePost.length)
        {
            span = document.createElement('span');
            span.innerHTML = "<input type='hidden' name='newcomp[]' value=\""+valuePost+"\">";
            span.innerHTML += valuePost + " <a href='javascript:void(0);' class='deleteComp'> <img src='/images/login_cancel.jpg' alt='X' /> </a> ";
            $('#addingComp')[0].appendChild(span);
        }
      }
      else
      {
        valuePost = $('#addComp')[0].value;
        span = document.createElement('span');
        span.innerHTML = "<input type='hidden' name='comp[]' value=\""+valuePost+"\">";
        span.innerHTML += ($('#addComp')[0])[$('#addComp')[0].selectedIndex].text + " <a href='javascript:void(0);' class='deleteComp'> <img src='/images/login_cancel.jpg' alt='X' /> </a> ";
        $('#addingComp')[0].appendChild(span);
      }
      /*Engine_Invitation_DeleteComp();*/
    }
  );
 
  $('#createNewGroupFrom').unbind('submit').submit(function ()
    {
      var infos = $(this).serialize();
      newGroupCreation(infos);
    }
  );
};

$(document).ready(Engine_Invitation_Init);