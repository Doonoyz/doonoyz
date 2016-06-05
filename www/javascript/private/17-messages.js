/**
	To enhance but that's a start :
	
	message = new Message();
	message.instance.className = 'errorPopup';
	message.display('coucou');
*/
Message = function () {
	
	this.instance = null;
	this.instanceName = null;
	this.closeLink = "<img src='/images/pxl.gif' alt='Close' class='popupButton' onclick=\"$(this.parentNode).trigger('message:kill');\" />";
	
	this.construct = function ()
	{
		this.createInstance();
		this.load();
		$(this.instance).bind('message:kill', {that : this}, this.kill);
	};
	
	this.createInstance = function ()
	{
		elementMessage = document.createElement('div');
		elementMessage.style.display = 'none';
		elementMessage.className = 'messagePopup';
		this.instance = elementMessage;
		document.getElementsByTagName('body')[0].appendChild(this.instance);
		$(this.instance).fadeIn(1000);
	};
	
	this.load = function ()
	{
		if (this.instance)
		{
			this.instance.innerHTML = getString('loading') + this.closeLink;
		}
	};
	
	this.display = function (text, noFade)
	{
		if (this.instance)
		{
			this.instance.innerHTML = text + this.closeLink;
			if (typeof(noFade) == 'undefined' || !noFade) {
				this.fade();
			}
		}
	};
	
	this.kill = function (opt) {
		if (opt) {
			that = opt.data.that;
		}
		if (this.instance) {
			that = this;
		}
		if (that.instance && that.instance.parentNode) {
			that.instance.parentNode.removeChild(that.instance);
		}
	};
	
	this.fade = function () {
		$(this.instance).fadeOut(5000, 
			function () {
				$(this).trigger('message:kill');
			}
		);
	};
	
	this.construct();
};