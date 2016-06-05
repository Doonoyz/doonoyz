$(document).ready(function () {
  document.cookie = "jsactive=true";
		
		$('.expandable').autogrow(
			{
				minHeight: 60
			});
		$(".expanding").autogrow(
			{
				minHeight: 60,
				lineHeight: 16
			});
	
		$('.addCompoDivIn').each(function (el, obj) {
			regexp = /[^_]+_([0-9]+)_([0-9]+)/;
			values = regexp.exec(obj.id);
			mykey = escape(obj.innerHTML);
			$("#"+obj.id).fileUpload(
				{
				  uploader : '/flash/uploader.swf',
				  cancelImg : '/images/upload/cancel.png',
				  script : "/studio/uploadcompo/groupname/"+values[1]+"/folderId/"+values[2],
				  scriptData : {'flashsession' : mykey},
				  fileDataName : 'file',
				  fileExt : getString('acceptedFiles'),
				  fileDesc : getString('acceptedFiles'),
				  multi : true,
				  auto : true,
				  wmode : 'transparent',
				  displayData : 'percentage',
				  buttonText : getString('browse'),
				  onComplete: function (event, queue, file, res, data) {
					var key = 'Engine_General.ajaxfileupload.'+queue;
					console.debug(res);
					try {
						vals = JSON.parse(res);
						Doonoyz.message.create(key);
						if (typeof(vals.status) != 'undefined' && vals.status != 'ok') {
							Doonoyz.message.getInstance(key).instance.className = 'errorPopup';
							Doonoyz.message.getInstance(key).display(vals.message);
						} else {
							Doonoyz.message.getInstance(key).display(getString('compoCreated'));
						}
					} catch (exception) {
						Doonoyz.message.getInstance(key).instance.className = 'errorPopup';
						Doonoyz.message.getInstance(key).display(getString('bigError'));
					}
				  },
				  onError : function (event, queue, file, res, data) {
						var key = 'Engine_General.ajaxfileupload.'+queue;
						Doonoyz.message.create(key);
						Doonoyz.message.getInstance(key).instance.className = 'errorPopup';
						Doonoyz.message.getInstance(key).display(getString('noChangeOrError'));
				  },
				  onSelect : function (event, queue, data) {
					$("#"+obj.id).fileUploadSettings('scriptData', '&flashsession='+mykey);
				  }
				}
			  );
		   }
		);
    $(".editableUser").editable('/ajax/updategroup', { 
        indicator : "<img src='/images/ajaxloader.gif'>",
        onblur    : 'cancel',
        tooltip   : getString('clickToEdit'),
        cancel    : getString('cancel'),
        submit    : getString('ok')
    });
    
    $(".editRichUser").richeditor('/ajax/updategroup', { 
					indicator : "<img src='/images/ajaxloader.gif'>",
					onblur    : 'cancel',
					tooltip   : getString('clickToEdit'),
					cancel    : getString('cancel'),
					submit    : getString('ok')
			});
			
    jQuery('a[rel*=facebox]').facebox();

	/*language drop down menu*/
	//$('.down-list').width($('.dropdown-menu').width()-2);
    $('.dropdown-menu').unbind('hover').hover(
      function () {
        $('.menu-first', this).addClass('slide-down');
        $('.down-list', this).slideDown(100);
      },
      function () {
        obj = this;
        $('.down-list', this).slideUp(100, function(){ $('.menu-first', obj).removeClass('slide-down'); });
      }
    );
	/*language drop down menu*/

	initStarRating();
	$.localScroll();
	$("#compositions").accordion({
		header: ".header",
		autoHeight : false,
		alwaysOpen : false
	});
	$("#compositions").accordion( "activate", -1 );
	$("#studiocompos").accordion({
        header: ".compoFolderTitle",
        autoHeight : false,
		alwaysOpen : false
    });
    $("#studiocompos").accordion( "activate", -1 );
    $('#loader')[0].style.display = 'none';
});