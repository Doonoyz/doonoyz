Engine_Search = {
	EngineJsonValues : null
};

function Engine_Search_DeleteCriteria() {
	$(".deleteCriteria").unbind('click').click(function ()
		{
			el = $(this)[0];
		  el.parentNode.parentNode.removeChild(el.parentNode);
		}
	);
};

$(document).ready(function () {
$("#chooseCriteria").unbind('click').click(function ()
		{
			el = $(this)[0];
			filterName = $('#filterSelect')[0].value;
			var element = $('#ASECriteria'+filterName)[0];
			if (!element)
				return;
			var rid = randomID(5);

			criteria = document.createElement('div');
			$(criteria).html(replaceAll(element.innerHTML, '__UNIQUE__', rid));
			$('#engineCriterias')[0].appendChild(criteria);
			Engine_Search_DeleteCriteria();
		}
	);
	
	$("#searchEngineForm").unbind('submit').submit(function () {
			el = $(this)[0];
			AjaxLoad('searchEngineResults');
			$('#presetEngine')[0].value = $('#engineCriterias')[0].innerHTML;
			Engine_Search.EngineJsonValues = new Array();
			Engine_Search.EngineJsonValues[0] = new Array();
			$('#engineCriterias select').each(
				function (elm, element) {
					Engine_Search.EngineJsonValues[0][Engine_Search.EngineJsonValues[0].length] = element.selectedIndex;
				}
			);
			Engine_Search.EngineJsonValues[1] = new Array();
			$('#engineCriterias input').each(
				function (elm, element) {
					Engine_Search.EngineJsonValues[1][Engine_Search.EngineJsonValues[1].length] = element.value;
				}
			);
			$('#presetEngineValues')[0].value = JSON.stringify(Engine_Search.EngineJsonValues);
			return (true);
		}
	);
	
	if ($("#presetEngineValues")) {
		el = $("#presetEngineValues")[0];
		try {
			values = JSON.parse(el.value);
			for (index in values[0]) {
				$('#engineCriterias select')[index].options[values[0][index]].selected = 'selected';
			}
			for (index in values[1]) {
				$('#engineCriterias input')[index].value = values[1][index];
			}
		} catch (exception) {
		}
	}
	
	$("#menuToggleAdvanced").unbind('click').click(function () {
			$('#toggleAdvancedSearch').toggle("slow");
		}
	);
	
	$(".pagineSearch").unbind('click').click(function ()
		{
			el = $(this)[0];
			regexp = /([^_]+)_([0-9]+)/;
			res = regexp.exec(el.id);
			regexp = /^(.+)\/page\/[0-9]+(\/?.*)$/;
			if (regexp.test(document.location)) {
				loca = document.location+'';
				loca = loca.replace(regexp, "$1/page/"+res[2]+"$2");
			} else {
				loca = document.location + '/page/'+res[2];
			}
			loca = loca.replace('//', '/');
			loca = loca.replace('http:/', 'http://');
			document.location = loca;
		}
	);
	
	Engine_Search_DeleteCriteria();
});
