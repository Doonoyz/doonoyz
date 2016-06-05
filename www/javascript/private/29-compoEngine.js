Engine_Compo = function () {
	this.playerId = null;
	this.playerType = null;
	this.autostart = false;
	this.width = 300;
	this.height = 200;
	
	this.setWidth = function (value) {
		this.width = value;
	};
	this.setHeight = function (value) {
		this.height = value;
	};
	
	this.setAutostart = function (value) {
		this.autostart = (value) ? true : false;
	};
	
	this.setPlayerId = function (id) {
		this.playerId = id;
	};
	
	this.setPlayerType = function (type) {
		this.playerType = type;
	};
	
	this.play = function (id) {
		switch (this.playerType) {
			case 'video':
				this.videoPlayer(id);
				break;
			case 'music':
				this.musicPlayer(id);
				break;
			case 'text':
				this.textPlayer(id);
				break;
			case 'picture':
				this.picturePlayer(id);
				break;
			default:
				alert('Error Player Type !');
		}
	};
	
	this.videoPlayer = function (id) {
		videofile = "/flvplayer/stream/";
		previewfile = "/flvplayer/preview/id/"+id;
		elem = document.createElement('div');
		elem.id = this.playerId + '_play';
		$("#"+this.playerId).html('&nbsp;');
		$("#"+this.playerId)[0].appendChild(elem);
		$("#"+this.playerId + '_play').html('<a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a>');
		flashvars = {};
		//flashvars.skin = 'http://www.doonoyz.com/flash/skin/bluemetal.swf';
		flashvars.streamer = videofile;
		flashvars.file = id+'.flv';
		flashvars.bufferlength = 2;
		flashvars.autostart = this.autostart;
		flashvars.image = previewfile;
			
		params = {};
		params.allowfullscreen = 'true';
		params.allowscriptaccess = 'always';
		
		attributes = {};
		swfobject.embedSWF("/flash/player.swf", this.playerId + '_play', this.width, this.height, "9.0.0","/flash/expressInstall.swf", flashvars, params, attributes);
	};
	
	this.textPlayer = function (id) {
		elem = document.createElement('div');
		elem.id = this.playerId + '_play';
		$("#"+this.playerId).html('&nbsp;');
		$("#"+this.playerId)[0].appendChild(elem);
		$("#"+this.playerId + '_play').html('<a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a>');
		
		flashvars = {};
		params = {};
		params.allowscriptaccess = 'always';

		attributes = {};
		swfobject.embedSWF("/flvplayer/stream/file/"+id+'.swf', this.playerId + '_play', this.width, this.height, "9.0.0","/flash/expressInstall.swf", flashvars, params, attributes);
	};
	
	this.musicPlayer = function (id) {
		this.height = 20;
		//skin height
		//this.height = 35;
		videofile = "/flvplayer/stream/";
		previewfile = "/flvplayer/preview/id/"+id;
		elem = document.createElement('div');
		elem.id = this.playerId + '_play';
		$("#"+this.playerId).html('&nbsp;');
		$("#"+this.playerId)[0].appendChild(elem);
		$("#"+this.playerId + '_play').html('<a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a>');
		flashvars = {};
		//flashvars.skin = 'http://www.doonoyz.com/flash/skin/bluemetal.swf';
		flashvars.streamer = videofile;
		flashvars.file = id+'.flv';
		flashvars.bufferlength = 2;
		flashvars.autostart = this.autostart;
		flashvars.image = previewfile;
			
		params = {};
		params.allowfullscreen = 'true';
		params.allowscriptaccess = 'always';
		
		attributes = {};
		swfobject.embedSWF("/flash/player.swf", this.playerId + '_play', this.width, this.height, "9.0.0","/flash/expressInstall.swf", flashvars, params, attributes);
	};

	this.picturePlayer = function (id) {
		$("#"+this.playerId).html("<img src='/flvplayer/stream/file/"+id+"' alt='"+id+"'/>");
	};

};