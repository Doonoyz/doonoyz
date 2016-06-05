Engine_MP = {
	/*".MPhidden" : function (el) {
		$(el).hide();
	},*/
	
	showToolbox : function (id, deleteParent) {
		if (deleteParent) {
			eltToDel = $('#mpToolBox')[0].parentNode.parentNode;
		}
		
		toolbox = document.createElement('tr');
		td = document.createElement('td');
		td.colSpan = 3;
		td.appendChild($('#mpToolBox')[0]);
		toolbox.appendChild(td);
		element = $('#MPBody_'+id)[0];
		element.parentNode.insertBefore(toolbox, element);
		element.parentNode.insertBefore(element, toolbox);
		if (deleteParent) {
			eltToDel.parentNode.removeChild(eltToDel);
		}
	}
};

$(document).ready( function () {

$("#MPDeleteAll").unbind('click').click(function ()
		{
			if (confirm(getString('confirmDeleteAllMp')))
			{
				$.get("/ajax/mp", { action : "deleteAll"},
					function(data) {
						try {
							data = JSON.parse(data);
							$('.alternate2').remove();
							$('.alternate1').remove();
							$('.MPhidden').remove();
						} catch (exception) {
							Doonoyz.message.create('MPDeleteAll');
							Doonoyz.message.getInstance('MPDeleteAll').instance.className = 'errorPopup';
							Doonoyz.message.getInstance('MPDeleteAll').display(getString('bigError'));
						}
					}
				);
			}
		}
	);
	
$("#mpDelete").unbind('click').click(function ()
		{
			if (confirm(getString('confirmDeleteMp')))
			{
				var idPost = $("#mpMessageId")[0].value;
				$.get('/ajax/mp', { action : "delete", id : idPost }, function (t) 
					{
						try {
							t = JSON.parse(t);
						} catch (exception) {
							Doonoyz.message.create('mpDelete');
							Doonoyz.message.getInstance('mpDelete').instance.className = 'errorPopup';
							Doonoyz.message.getInstance('mpDelete').display(getString('bigError'));
						}
					});
				$("#myMP_"+idPost).remove();
				$("#MPBody_"+idPost).remove();
				var mpToolboxClone = $("#mpToolBox")[0];
				var toDel = mpToolboxClone.parentNode.parentNode;
				$('.ressources')[0].appendChild(mpToolboxClone);
				toDel.parentNode.removeChild(toDel);
			}
		}
	);
	
$("#mpAnswer").unbind('click').click(function ()
		{
			$('#mpText').slideDown();
		}
	);
	
$(".MPReadable").unbind('click').click(function (t) {
			id = getIdFromText($(this)[0].id);
			$.get('/ajax/mp', { action : "read", "id" : id}, function (t) {
				try {
					t = JSON.parse(t);
				} catch (exception) {
					Doonoyz.message.create('MPReadable');
					Doonoyz.message.getInstance('MPReadable').instance.className = 'errorPopup';
					Doonoyz.message.getInstance('MPReadable').display(getString('bigError'));
				}
			});
			
			if (typeof($("#mpUsernameRecup_"+id)[0]) != 'undefined') {
				$("#mpUsername")[0].value = $("#mpUsernameRecup_"+id)[0].innerHTML;
				$('#mpAnswer').css("display", 'inline');
			} else {
				$('#mpAnswer').css("display", 'none');
			}
			$("#mpTitle")[0].value = $("#MP_"+id)[0].innerHTML;
			$("#mpMessageId")[0].value = id;
			$(".MPhidden").slideUp();
			$('#mpText').slideUp();
			if ($('#mpToolBox')[0].parentNode.className != 'ressources') {
				$($('#mpToolBox')[0].parentNode.parentNode).slideUp(500, Engine_MP.showToolbox(id, true));
			} else {
				Engine_MP.showToolbox(id, false);
			}
			$('#MPBody_'+id).slideDown(500, function () {
				$('#MPBody_'+id).css("display", '');
			});
			
			$('#mpToolBox').slideDown(500, function () {
				$('#mpToolBox').css("display", 'inline');
			});
		
			//$('#MPBody_'+id)[0].parentNode.replaceChild($('#mpToolBox')[0], $('#MPBody_'+id)[0]);
		}
	);
});