function Engine_Comment_Init() {
	$(".comment").unbind('click').click(function ()
		{
			el = $(this)[0];
			regexp = /([^_]+)_([^_]+)_([0-9]+)/;
			res = regexp.exec(el.id);
			AjaxLoad('commentInterface');
			$.get('/ajax/comment', { action : 'show', type : res[2], id : res[3], page : 1 }, function (t)
			{
				$('#commentInterface')[0].innerHTML = t;
				Engine_Comment_Init();
			});
		}
	);
	
	$(".expanding").autogrow(
		{
			minHeight: 60
		});
                        
	$(".pagineComment").unbind('click').click(function ()
		{
			el = $(this)[0];
			regexp = /([^_]+)_([0-9]+)/;
			res = regexp.exec(el.id);
			AjaxLoad('commentInterface');
			$.get('/ajax/comment', { action : 'getPage', page : res[2] }, function (t)
			{
				$('#commentInterface')[0].innerHTML = t;
				Engine_Comment_Init();
			});
		}
	);
	
	$("#answerComment").unbind('submit').submit(function ()
		{
			var infos = $(this).serialize();
			infos += "&action=create";
			Doonoyz.message.create('Engine_Comment#answerComment.onsubmit');
			$.get('/ajax/comment', infos, function (t)
			{
				try {
					t = JSON.parse(t);
					Doonoyz.message.getInstance('Engine_Comment#answerComment.onsubmit').display(getString('commentAdded'));
				} catch (exception) {
					Doonoyz.message.getInstance('Engine_Comment#answerComment.onsubmit').instance.className = 'errorPopup';
					Doonoyz.message.getInstance('Engine_Comment#answerComment.onsubmit').display(getString('bigError'));
				}
			});
		}
	);
};
$(document).ready(Engine_Comment_Init);