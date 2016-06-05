Engine_Studio = {
	newFolder : function (groupId)
	{
		var valuePost = prompt(getString('newFolderName'));
		if (valuePost != null && valuePost.length)
		{
			Doonoyz.message.create('Engine_Studio.newFolder');
			$.get('/ajax/studio', {action : "createFolder", value : valuePost, id : groupId}, function (t)
				{
					try {
						t = JSON.parse(t);
						if (typeof(Doonoyz.callback) == "function")
						{
							Doonoyz.callback(t['default']);
							Doonoyz.callback = null;
						}
						else
							Doonoyz.message.getInstance('Engine_Studio.newFolder').display(getString('folderCreated'));
					} catch (exception) {
						Doonoyz.message.getInstance('Engine_Studio.newFolder').instance.className = 'errorPopup';
						Doonoyz.message.getInstance('Engine_Studio.newFolder').display(getString('bigError'));
					}
				});
		}
	},
	
	player : function (type, element) {
		regexp = /[^_]+_([0-9]+)/;
		infos = regexp.exec(element.id);
		realId = infos[1];
		
		engine = new Engine_Compo();
		engine.setPlayerId(element.id);
		engine.setPlayerType(type);
		engine.play(realId);
	}
};

function Engine_Studio_Init() {
$(".addFolder").unbind('click').click(function ()
		{
			el = $(this)[0];
			var regexp = /[^_]+_([0-9]+)/;
			id = regexp.exec(el.id);
			Engine_Studio.newFolder(id[1]);
		}
	);
	
	$(".studioPlayermusic").each(function (t, el)
	{
		Engine_Studio.player('music', el);
	});
	
	$(".studioPlayervideo").each(function (t, el)
	{
		Engine_Studio.player('video', el);
	});
	$(".studioPlayertext").each(function (t, el)
	{
		Engine_Studio.player('text', el);
	});
	$(".studioPlayerpicture").each(function (t, el)
	{
		Engine_Studio.player('picture', el);
	});
	
	$(".compoInterface").unbind('click').click(function ()
		{
			el = $(this)[0];
			var regexp = /[^_]+_([0-9]+)_([0-9]+)/;
			idVar = regexp.exec(el.id);
			AjaxLoad("studioContent");
			$.get('/studio/showinterface', { id : idVar[2]}, function (t)
			{
				$("#studioContent")[0].innerHTML = t;
				crir.init();
				Engine_Studio_Init();
			});
		}
	);
	
	$(".addCompo").unbind('click').click(function ()
		{
			el = $(this)[0];
		  regexp = /[^_]+_([0-9]+)_([0-9]+)/;
		  values = regexp.exec(el.id);
		  $("#addCompoDiv_"+values[1]+"_"+values[2]).toggle();
		}
	);
	
	$(".deleteCompo").unbind('click').click(function ()
		{
			el = $(this)[0];
			if (confirm(getString("deleteCompo")))
			{
				var regexp = /[^_]+_([0-9]+)_([0-9]+)/;
				id = regexp.exec(el.id);
				if (id[2])
				{
					Doonoyz.message.create('Engine_Studio.deleteCompo.onclick');
					$.get('/ajax/compo', { action : "delete", compoId : id[2]}, function (t) {
						try {
							t = JSON.parse(t);
							$('#compo_'+id[1]+'_'+id[2]).remove();
							Doonoyz.message.getInstance('Engine_Studio.deleteCompo.onclick').display(getString('compoDeleted'));
						} catch (exception) {
							Doonoyz.message.getInstance('Engine_Studio.deleteCompo.onclick').instance.className = 'errorPopup';
							Doonoyz.message.getInstance('Engine_Studio.deleteCompo.onclick').display(getString('bigError'));
						}
					});
				}
			}
		}
	);
	
	$(".deleteFolder").unbind('click').click(function ()
		{
			el = $(this)[0];
			if (confirm(getString('deleteFolderAndContent')))
			{
				var regexp = /[^_]+_([0-9]+)_([0-9]+)/;
				id = regexp.exec(el.id);
				if (id[1] && id[2])
				{
					Doonoyz.message.create('Engine_Studio.deleteFolder.onclick');
					$.get('/ajax/studio', {action : "deleteFolder", value : id[2], groupId : id[1] }, function (t) {
						try {
							t = JSON.parse(t);
							$('#compoFolder_'+id[2]).remove();
							Doonoyz.message.getInstance('Engine_Studio.deleteFolder.onclick').display(getString('folderDeleted'));
						} catch (exception) {
							Doonoyz.message.getInstance('Engine_Studio.deleteFolder.onclick').instance.className = 'errorPopup';
							Doonoyz.message.getInstance('Engine_Studio.deleteFolder.onclick').display(getString('bigError'));
						}
					});
				}
			}
		}
	);
	
	$(".publicCompo label").unbind('click').click(function ()
		{
			el = $(this)[0];
			element = $(".publicCompo input")[0];
			var elementValue = (element.checked) ? "false" : "true";
			Doonoyz.message.create('Engine_Studio.publicCompo label.onclick');
			$.get('/ajax/updatecompo', {id : element.id, value : elementValue}, function (t) {
				try {
					t = JSON.parse(t);
					message = (elementValue == "true") ? 'compoPub' : 'compoUnpub';
					Doonoyz.message.getInstance('Engine_Studio.publicCompo label.onclick').display(getString(message));
				} catch (exception) {
					Doonoyz.message.getInstance('Engine_Studio.publicCompo label.onclick').instance.className = 'errorPopup';
					Doonoyz.message.getInstance('Engine_Studio.publicCompo label.onclick').display(getString('bigError'));
				}
			});
		}
	);
	
	$(".changeFolder").unbind('change').change(function ()
		{
			el = $(this)[0];
			Doonoyz.message.create('Engine_Studio.changeFolder.onclick');
			$.get('/ajax/updatecompo', {id : el.id, value : el.value}, function (t) {
				try {
					t = JSON.parse(t);
					Doonoyz.message.getInstance('Engine_Studio.changeFolder.onclick').display(getString('changeFolder'));
				} catch (exception) {
					Doonoyz.message.getInstance('Engine_Studio.changeFolder.onclick').instance.className = 'errorPopup';
					Doonoyz.message.getInstance('Engine_Studio.changeFolder.onclick').display(getString('bigError'));
				}
			});
		}
	);
	
	$(".editableCompo").editable('/ajax/updatecompo', { 
			indicator : "<img src='/images/ajaxloader.gif'>",
			onblur    : 'cancel',
			tooltip   : getString('clickToEdit'),
			cancel    : getString('cancel'),
			submit    : getString('ok')
		});
	
	$(".editFolder").unbind('click').click(function () {
			el = $(this)[0];
			var valuePost = prompt(getString('editFolderName'));
			if (valuePost != null && valuePost.length)
			{
				Doonoyz.message.create('Engine_Studio.editFolder');
				$.get('/ajax/updatefolder', {id : el.id, value : valuePost}, function (t)
					{
						try {
							t = JSON.parse(t);
							Doonoyz.message.getInstance('Engine_Studio.editFolder').display(getString('folderEdited'));
						} catch (exception) {
							Doonoyz.message.getInstance('Engine_Studio.editFolder').instance.className = 'errorPopup';
							Doonoyz.message.getInstance('Engine_Studio.editFolder').display(getString('bigError'));
						}
					});
			}
		}
	);
	
	$(".publicFolder label").unbind('click').click(function ()
		{
			el = $(this)[0];
			element = $("#"+$(this).attr('for'))[0];
			var elementValue = (element.checked) ? "false" : "true";
			Doonoyz.message.create('Engine_Studio.publicFolder label.onclick');
			$.get('/ajax/updatefolder', {id : element.id, value : elementValue}, function (t) {
				try {
					t = JSON.parse(t);
					message = (elementValue == "true") ? 'folderPub' : 'folderUnpub';
					Doonoyz.message.getInstance('Engine_Studio.publicFolder label.onclick').display(getString(message));
				} catch (exception) {
					Doonoyz.message.getInstance('Engine_Studio.publicFolder label.onclick').instance.className = 'errorPopup';
					Doonoyz.message.getInstance('Engine_Studio.publicFolder label.onclick').display(getString('bigError'));
				}
			});
		}
	);
};
$(document).ready(Engine_Studio_Init);