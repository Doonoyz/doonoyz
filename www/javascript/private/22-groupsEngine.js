Engine_Groups = {
	sendInformation : function (el)
	{
		Doonoyz.message.create('Engine_Groups.sendInformation');
		$.get('/ajax/groupmanager', { id : el.id}, function (t)
			{
				try {
					t = JSON.parse(t);
					Doonoyz.message.getInstance('Engine_Groups.sendInformation').display(t['default']);
				} catch (exception) {
					Doonoyz.message.getInstance('Engine_Groups.sendInformation').instance.className = 'errorPopup';
					Doonoyz.message.getInstance('Engine_Groups.sendInformation').display(getString('bigError'));
				}
			});
	}
};

$(document).ready(function () {

$(".quitGroup").unbind('click').click(function ()
		{
		el = $(this)[0];
      Engine_Groups.sendInformation(el);
    });
	
	$(".acceptInvitation").unbind('click').click(function ()
		{
		el = $(this)[0];
      Engine_Groups.sendInformation(el);
    }
	);
	
	$(".declineInvitation").unbind('click').click(function ()
		{
		el = $(this)[0];
      Engine_Groups.sendInformation(el);
    }
	);
	});