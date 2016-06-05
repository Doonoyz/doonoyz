Engine_Admin = {
	blockGroup : function (id, active, message) {
		Doonoyz.message.create('Engine_Admin.blockGroup');
		$.post('/admin/blockgroup', {groupId : id, value : active}, 
			function (t) {
				try {
					t = JSON.parse(t);
					Doonoyz.message.getInstance('Engine_Admin.blockGroup').display(message);
				} catch (exception) {
					Doonoyz.message.getInstance('Engine_Admin.blockGroup').instance.className = 'errorPopup';
					Doonoyz.message.getInstance('Engine_Admin.blockGroup').display(getString('bigError'));
				}
			}
		);
	}
};

function Engine_Admin_Init() {
$(".blockUser").unbind('click').click(function ()
		{
			el = $(this)[0];
			if (confirm(getString('confirmDeleteUser'))) {
				regexp = /[^_]+_([0-9]+)/;
				res = regexp.exec(el.id);
				Doonoyz.message.create('Engine_Admin.blockUser');
				$.post('/admin/blockuser', {userId : res[1]}, 
					function (t) {
						try {
							t = JSON.parse(t);
							Doonoyz.message.getInstance('Engine_Admin.blockUser').display(getString('userDeleted'));
						} catch (exception) {
							Doonoyz.message.getInstance('Engine_Admin.blockUser').instance.className = 'errorPopup';
							Doonoyz.message.getInstance('Engine_Admin.blockUser').display(getString('bigError'));
						}
					}
				);
			}
		}
	);
	
	$(".censorGroupForm").unbind('submit').submit(function ()
		{
			el = $(this)[0];
			Doonoyz.message.create('Engine_Admin.censorGroupForm');
			infos = $(el).serialize();
			$.post('/admin/censor', infos, 
				function (t) {
					try {
						t = JSON.parse(t);
						Doonoyz.message.getInstance('Engine_Admin.censorGroupForm').display(t['default']);
					} catch (exception) {
						Doonoyz.message.getInstance('Engine_Admin.censorGroupForm').instance.className = 'errorPopup';
						Doonoyz.message.getInstance('Engine_Admin.censorGroupForm').display(getString('bigError'));
					}
				}
			);
		}
	);
	
	$(".blockGroup").unbind('click').click(function ()
		{
			el = $(this)[0];
			if (confirm(getString('confirmBlockGroup'))) {
				regexp = /[^_]+_([0-9]+)/;
				res = regexp.exec(el.id);
				Engine_Admin.blockGroup(res[1], 0, getString('groupBlocked'));
			}
		}
	);
	
	$(".activeGroup").unbind('click').click(function ()
		{
			el = $(this)[0];
			regexp = /[^_]+_([0-9]+)/;
			res = regexp.exec(el.id);
			Engine_Admin.blockGroup(res[1], 1, getString('groupActive'));
		}
	);
	
	$(".deleteTask").unbind('click').click(function ()
		{
			el = $(this)[0];
			if (confirm(getString('confirmDeleteAdminTask'))) {
				regexp = /[^_]+_([0-9]+)/;
				res = regexp.exec(el.id);
				Doonoyz.message.create('Engine_Admin.deleteTask');
				$.post('/admin/deletetask', {taskId : res[1]}, 
					function (t) {
						try {
							t = JSON.parse(t);
							if (t['default'] == "ok") {
								Doonoyz.message.getInstance('Engine_Admin.deleteTask').display(getString('adminTaskDeleted'));
								el.parentNode.parentNode.parentNode.removeChild(el.parentNode.parentNode);
							}
						} catch (exception) {
							Doonoyz.message.getInstance('Engine_Admin.deleteTask').instance.className = 'errorPopup';
							Doonoyz.message.getInstance('Engine_Admin.deleteTask').display(getString('bigError'));
						}
					}
				);
			}
		}
	);
	
	$(".acceptComponent").unbind('click').click(function ()
		{
			el = $(this)[0];
			Doonoyz.message.create('Engine_Admin.acceptComponent');
			info = "action=accept&id=" + el.id;
			$.post('/admin/edit', info, 
				function (t) {
					try {
						t = JSON.parse(t);
						Doonoyz.message.getInstance('Engine_Admin.acceptComponent').display(t['default']);
					} catch (exception) {
						Doonoyz.message.getInstance('Engine_Admin.acceptComponent').instance.className = 'errorPopup';
						Doonoyz.message.getInstance('Engine_Admin.acceptComponent').display(getString('bigError'));
					}
				}
			);
		}
	);
	
	$(".editComponent").unbind('submit').submit(function ()
		{
			el = $(this)[0];
			Doonoyz.message.create('Engine_Admin.editComponent');
			info = "action=edit&editionInfo="+el.id+"&" + $(el).serialize();
			$.post('/admin/edit', info, 
				function (t) {
					try {
						t = JSON.parse(t);
						Doonoyz.message.getInstance('Engine_Admin.editComponent').display(t['default']);
					} catch (exception) {
						Doonoyz.message.getInstance('Engine_Admin.editComponent').instance.className = 'errorPopup';
						Doonoyz.message.getInstance('Engine_Admin.editComponent').display(getString('bigError'));
					}
				}
			);
		}
	);
	
	$(".deleteComponent").unbind('click').click(function ()
		{
			el = $(this)[0];
			Doonoyz.message.create('Engine_Admin.deleteComponent');
			info = "action=delete&id=" + el.id;
			$.post('/admin/edit', info, 
				function (t) {
					try {
						t = JSON.parse(t);
						Doonoyz.message.getInstance('Engine_Admin.deleteComponent').display(t['default']);
					} catch (exception) {
						Doonoyz.message.getInstance('Engine_Admin.deleteComponent').instance.className = 'errorPopup';
						Doonoyz.message.getInstance('Engine_Admin.deleteComponent').display(getString('bigError'));
					}
				}
			);
		}
	);
	
	$("#addComponentForLink").unbind('click').click(function ()
		{
			el = $(this)[0];
			valuePost = $("#addComponentForSelect")[0].value;
			span = document.createElement('span');
            span.innerHTML = "<input type='hidden' name='replace[]' value=\""+valuePost+"\">";
            span.innerHTML += valuePost + " <a href='javascript:void(0);' class='deleteComponentFor'>X</a> ";
            $('#replaceComponentDiv')[0].appendChild(span);
            Engine_Admin_Init();
		}
	);
	
	$('.deleteComponentFor').unbind('click').click(function () {
			el = $(this)[0];
			el.parentNode.parentNode.removeChild(el.parentNode);
		}
	);
	
	$('.replaceComponentForm').unbind('submit').submit(function () {
			el = $(this)[0];
			infos = "action=replaceWith&id=" + el.id + "&" + $(el).serialize();
			Doonoyz.message.create('Engine_Admin.replaceComponentForm');
			$.post('/admin/edit', info, 
				function (t) {
					try {
						t = JSON.parse(t);
						Doonoyz.message.getInstance('Engine_Admin.replaceComponentForm').display(t['default']);
					} catch (exception) {
						Doonoyz.message.getInstance('Engine_Admin.replaceComponentForm').instance.className = 'errorPopup';
						Doonoyz.message.getInstance('Engine_Admin.replaceComponentForm').display(getString('bigError'));
					}
				}
			);
		}
	);
	
	$('#editComponentSelect').unbind('change').change(function () {
			el = $(this)[0];
			regexp = /id\/([0-9]+)/;
			$('#editComponentLink')[0].href = $('#editComponentLink')[0].href.replace(regexp, 'id/' + el.value);
		}
	);
	
	$("#editComponentSelectGlobal").unbind('change').change(function () {
			el = $(this)[0];
			if (el.value != '0') {
				document.location.href = '/admin/editcomponent/index/component/'+el.value;
			}
		}
	);
	
	$("#groupManageLink").unbind('click').click(function () {
			el = $(this)[0];
			document.location.href = '/admin/groups/index/groupurl/'+$('#groupManageSelect')[0].value;
		}
	);
	
	$(".deleteMostAp").unbind('click').click(function () {
			el = $(this)[0];
			el.parentNode.parentNode.removeChild(el.parentNode);
		}
	);
	
	$("#addSelectedMostAp").unbind('click').click(function () {
			el = $(this)[0];
			value = $("#mostApSelect")[0].value;
			index = $("#mostApSelect")[0].options.selectedIndex;
			text = $("#mostApSelect")[0].options[index].text;
			div = document.createElement('div');
			div.id = 'mostAp_' + value;
			div.innerHTML = text + " <a href='javascript:void(0);' class='deleteMostAp'>X</a>";
			$('#mostApList')[0].appendChild(div);
			Engine_Admin_Init();
		}
	);
	
	$("#saveMostAp").unbind('click').click(function () {
			el = $(this)[0];
			Doonoyz.message.create('Engine_Admin#saveMostAp');
			infos = $('#mostApList').sortable("serialize") + "&action=save";
			$.post('/admin/home', infos, 
				function (t) {
					try {
						t = JSON.parse(t);
						Doonoyz.message.getInstance('Engine_Admin#saveMostAp').display(t['default']);
					} catch (exception) {
						Doonoyz.message.getInstance('Engine_Admin#saveMostAp').instance.className = 'errorPopup';
						Doonoyz.message.getInstance('Engine_Admin#saveMostAp').display(getString('bigError'));
					}
				}
			);
		}
	);
	
	$("#editAdminUser").unbind('click').click(function () {
			el = $(this)[0];
			document.location.href = '/admin/user/index/userid/' + $('#adminUserSelect')[0].value;
		}
	);
	
	$("#mostApList").sortable({ items: "div" });
};

$(document).ready(Engine_Admin_Init);