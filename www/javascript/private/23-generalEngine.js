function Engine_General_Init() {
$(".editHighliter").unbind('hover').hover(function () {
			$(this).css('background-color', '#B4D254');
		},

		function () {
			$(this).css('background-color', '#EEEEEE');
		}
	);
	
	$("#quickSearchEngine").unbind('submit').submit(function () {
			$('#quickSearchEngine input').each(function (t, elt) {
				if (elt.name == "csrf") {
					elt.value = $('#csrfSecurityCode')[0].innerHTML;
				}
			});
		}
	);
	
	$(".selectSort").each(function (t, el) {
		if (el.options.length > 1) {
			sortList(el);
		}
	});
};

$(document).ready(Engine_General_Init);