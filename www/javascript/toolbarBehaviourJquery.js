Twindoo_ToolbarEngine = {
	  
	'#toolbarWidget':                   function (el) {
    el.onmouseover = function () {
        Twindoo_ToolbarEngine.inToolbar = 1;
        if ($('#specialtoolbar')[0].style.display == 'none')
        {
          $('#specialtoolbar').slideToggle(200);
        }
    },
    el.onmouseout = function () {
      Twindoo_ToolbarEngine.inToolbar = 0;
    }
	},
		
	"body" :            function (el) {
    window.setInterval(Twindoo_ToolbarEngine.toolbarTimer, 5000);
	},
	
	inToolbar : 0,
	toolbarTimer :    function () {
    if (!Twindoo_ToolbarEngine.inToolbar && $('#specialtoolbar')[0].style.display != 'none')
      $('#specialtoolbar').slideToggle(200);
	},
}

Behaviour.register(Twindoo_ToolbarEngine);