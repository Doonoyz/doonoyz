Engine_User = {
 
  player : function (type, element)
  {
	regexp = /[^_]+_([0-9]+)/;
	infos = regexp.exec(element.id);
	realId = infos[1];
	realName = element.innerHTML;
	realName = realName.replace(' ', '_');
	
	AjaxLoad('player');
	engine = new Engine_Compo();
	engine.setPlayerId('player');
	engine.setPlayerType(type);
	engine.setAutostart(true);
	engine.setWidth(770);
	engine.setHeight(500);
	engine.play(realId);
	realLink = document.location.toString().split('#');
	directLink =  realLink[0] + '/#' + realId + '-' + realName;
	directLink = directLink.replace('\/\/', '\/');
	directLink = directLink.replace('http:\/', 'http:\/\/');
	$('#player').html($('#player')[0].innerHTML + '<br/>' + getString('directLinkShare') + ' : <b>' + directLink + '</b>');
  },
  
  checkForCompo : function () {
	var myFile = document.location.toString();
	regexp = /\#([0-9]+)\-.+$/;
	info = regexp.exec(myFile);
	if (info && typeof(info[1]) != 'undefined') { /* the URL contains an anchor */
		compoId = info[1];
		element = $('#componame_'+compoId);
		if (element) {
			element.click();
			$.scrollTo( '#player', 200);
		}
	}
  }
};

$(document).ready(function () {
$(".deleteUser").unbind('click').click(function ()
		{
			el = $(this)[0];
			$.get('/ajax/deleteingroup', {id : el.id}, 
				function (t)
				{
					try {
						t = JSON.parse(t);
						el.parentNode.parentNode.removeChild(el.parentNode);
					} catch (exception) {
						Doonoyz.message.create('deleteUser');
						Doonoyz.message.getInstance('deleteUser').instance.className = 'errorPopup';
						Doonoyz.message.getInstance('deleteUser').display(getString('bigError'));
					}
				}
			);
		}
	);
	
	$("#uploadPhotoFileInput").unbind('change').change(function () {
			el = $(this)[0];
			filename = el.value.split('.');
			fileExt = filename[filename.length - 1];
			security = new Array('gif', 'png', 'jpg', 'jpeg', 'bmp');
			found = false;
			
			for (ext in security)
			{
				if (security[ext] == fileExt.toLowerCase()) {
					found = true;
				}
			}
			if (!found) {
				alert(getString('fileFormats') +'\n\n' + security.join(', '));
			}
		}
	);
	
	$(".report").unbind('click').click(function ()
		{
			el = $(this)[0];
			Doonoyz.message.create('Engine_User.report.onclick');
			$.get('/ajax/report', {id : el.id}, 
				function (t)
				{
					try {
						t = JSON.parse(t);
						Doonoyz.message.getInstance('Engine_User.report.onclick').display(getString('alertSent'));
					} catch (exception) {
						Doonoyz.message.getInstance('Engine_User.report.onclick').instance.className = 'errorPopup';
						Doonoyz.message.getInstance('Engine_User.report.onclick').display(getString('bigError'));
					}
				}
			);
		}
	);

	$('.alertchange').unbind('change').change(function () {
		Doonoyz.message.create('Engine_User.alertchange.onchange');
		Doonoyz.message.getInstance('Engine_User.alertchange.onchange').display(getString('skillMusicalAddForget'));
	});
	
	$(".addCompetence").unbind('click').click(function ()
    {
		el = $(this)[0];
      id = el.id;
      regexp = /^([^_]+)(_.+)$/;
      idSelect = id.replace(regexp, "$1Select$2");
      valueSelect = $('#'+idSelect)[0].value;
      
      if (valueSelect != 0)
      {
		Doonoyz.message.create('Engine_User.addCompetence.onclick');
        $.get('/ajax/addingroup', {id : idSelect, value : valueSelect}, 
          function (t)
          {
			try {
				t = JSON.parse(t);
				Doonoyz.message.getInstance('Engine_User.addCompetence.onclick').display(getString('competenceAdded'));
			} catch (exception) {
				Doonoyz.message.getInstance('Engine_User.addCompetence.onclick').instance.className = 'errorPopup';
				Doonoyz.message.getInstance('Engine_User.addCompetence.onclick').display(getString('bigError'));
			}
          }
        );
      }
      else
      {
        id = el.id;
        regexp = /^([^_]+)(_.+)$/;
        idSelect = id.replace(regexp, "$1Adding$2");
        valuePost = prompt(getString("newCompetenceName"));
        if (valuePost != null && valuePost.length)
        {
			Doonoyz.message.create('Engine_User.addCompetence.onclick');
          $.get('/ajax/addingroup', {id : idSelect, value : valuePost}, 
            function (t)
            {
				try {
					t = JSON.parse(t);
					Doonoyz.message.getInstance('Engine_User.addCompetence.onclick').display(getString('newCompetenceAdded'));
				} catch (exception) {
					Doonoyz.message.getInstance('Engine_User.addCompetence.onclick').instance.className = 'errorPopup';
					Doonoyz.message.getInstance('Engine_User.addCompetence.onclick').display(getString('bigError'));
				}
            }
          );
        }
      }
    }
	);
	
	$(".addStyle").unbind('click').click(function ()
    {
		el = $(this)[0];
      id = el.id;
      regexp = /^([^_]+)(_.+)$/;
      idSelect = id.replace(regexp, "$1Select$2");
      valueSelect = $('#'+idSelect)[0].value;
      
      if (valueSelect != 0)
      {
			Doonoyz.message.create('Engine_User.addStyle.onclick');
        $.get('/ajax/addingroup', {id : idSelect, value : valueSelect}, 
          function (t)
          {
			try {
				t = JSON.parse(t);
				Doonoyz.message.getInstance('Engine_User.addStyle.onclick').display(getString('styleAdded'));
			} catch (exception) {
				Doonoyz.message.getInstance('Engine_User.addStyle.onclick').instance.className = 'errorPopup';
				Doonoyz.message.getInstance('Engine_User.addStyle.onclick').display(getString('bigError'));
			}
          }
        );
      }
      else
      {
        id = el.id;
        regexp = /^([^_]+)(_.+)$/;
        idSelect = id.replace(regexp, "$1Adding$2");
        valuePost = prompt(getString('newStyleName'));
        if (valuePost != null && valuePost.length)
        {
			Doonoyz.message.create('Engine_User.addStyle.onclick');
          $.get('/ajax/addingroup', {id : idSelect, value : valuePost}, 
            function (t)
            {
				try {
					t = JSON.parse(t);
					Doonoyz.message.getInstance('Engine_User.addStyle.onclick').display(getString('newStyleAdded'));
				} catch (exception) {
					Doonoyz.message.getInstance('Engine_User.addStyle.onclick').instance.className = 'errorPopup';
					Doonoyz.message.getInstance('Engine_User.addStyle.onclick').display(getString('bigError'));
				}
            }
          );
        }
      }
    }
	);
	
	$(".addContact").unbind('click').click(function ()
    {
		el = $(this)[0];
      id = el.id;
      regexp = /^([^_]+)(_.+)$/;
      idSelect = id.replace(regexp, "$1Select$2");
      valueSelect = $('#'+idSelect)[0].value;
      
      if (valueSelect != 0)
      {
        valueContact = prompt(getString("contactTypeAddress"));
        if (valueContact != null && valueContact.length)
        {
			Doonoyz.message.create('Engine_User.addContact.onclick');
          $.get('/ajax/addingroup', {id : idSelect, idContact : valueSelect, value : valueContact}, 
            function (t)
            {
				try {
					t = JSON.parse(t);
					Doonoyz.message.getInstance('Engine_User.addContact.onclick').display(getString('contactTypeAdded'));
				} catch (exception) {
					Doonoyz.message.getInstance('Engine_User.addContact.onclick').instance.className = 'errorPopup';
					Doonoyz.message.getInstance('Engine_User.addContact.onclick').display(getString('bigError'));
				}
            });
        }
      }
      else
      {
        id = el.id;
        regexp = /^([^_]+)(_.+)$/;
        idSelect = id.replace(regexp, "$1Adding$2");
        valuePost = prompt(getString("newContactType"));
        if (valuePost != null && valuePost.length)
        {
          valueContact = prompt(getString("contactTypeAddress"));
          if (valueContact != null && valueContact.length)
          {        
			Doonoyz.message.create('Engine_User.addContact.onclick');
            $.get('/ajax/addingroup', {id : idSelect, idContact : valuePost, value : valueContact}, 
              function (t)
              {
				try {
					t = JSON.parse(t);
					Doonoyz.message.getInstance('Engine_User.addContact.onclick').display(getString('newContactTypeAddressAdded'));
				} catch (exception) {
					Doonoyz.message.getInstance('Engine_User.addContact.onclick').instance.className = 'errorPopup';
					Doonoyz.message.getInstance('Engine_User.addContact.onclick').display(getString('bigError'));
				}
              }
            );
          }
        }
      }
    }
	);
	
	$("#uploadNewPhoto").unbind('click').click(function ()
    {
      $("#uploadPhoto")[0].style.display = "block";
    }
	);
	
	$("#uploadNewPhotoCancel").unbind('click').click(function ()
    {
      $("#uploadPhoto")[0].style.display = "none";
    }
	);
	
	$("#uploadPhotoForm").unbind('submit').submit(function ()
    {
		el = $(this)[0];
      el.parentNode.style.display = "block";
    }
	);

	$(".labelUpdate").unbind('onchange').change(function () {
		Doonoyz.message.create('Engine_User.labelUpdate');
		idPost = this.id;
		valuePost = this.value;
		messageDisplay = 'labelAdded';
		if (this.value == '-1') {
			valuePost = prompt(getString("newLabelName"));
			if (valuePost != null && valuePost.length) {
				idPost = 'new' + idPost;
				messageDisplay = 'newLabelAdded';
			} else {
				return;
			}
		}
		$.get('/ajax/updategroup', {id : idPost, value : valuePost}, function (t) {
			try {
				t = JSON.parse(t);
				Doonoyz.message.getInstance('Engine_User.labelUpdate').display(getString(messageDisplay));
			} catch (exception) {
				Doonoyz.message.getInstance('Engine_User.labelUpdate').instance.className = 'errorPopup';
				Doonoyz.message.getInstance('Engine_User.labelUpdate').display(getString('bigError'));
			}
		});
	}
	);
  
  $(".updateGroupFull label").unbind('click').click(function ()
	{
		el = $(this)[0];
		element = $(".updateGroupFull input")[0];
		if (!element) {
			return;
		}
		$.get('/ajax/updategroup', {id : element.id, value : (element.checked ? 'bid' : 'full')}, function (t) {
			try {
				t = JSON.parse(t);
			} catch (exception) {
				Doonoyz.message.create('updateGroupFull');
				Doonoyz.message.getInstance('updateGroupFull').instance.className = 'errorPopup';
				Doonoyz.message.getInstance('updateGroupFull').display(getString('bigError'));
			}
		});
	}
  );
  
  $(".playcompovideo").unbind('click').click(function ()
	{
		el = $(this)[0];
		Engine_User.player('video', el);
	});

  
  $(".playcompotext").unbind('click').click(function ()
	{
		el = $(this)[0];
		Engine_User.player('text', el);
	});
  
  $(".playcompoopicture").unbind('click').click(function ()
	{
		el = $(this)[0];
		Engine_User.player('picture', el);
	});
  
  $(".playcompomusic").unbind('click').click(function ()
	{
		el = $(this)[0];
		Engine_User.player('music', el);
	});
  
	Engine_User.checkForCompo();
	
  $(".addMember").unbind('click').click(function ()
    {
		el = $(this)[0];
      valuePost = prompt(getString("loginOrMail"));
      if (valuePost != null && valuePost.length)
      {
		Doonoyz.message.create('Engine_User.addMember.onclick');
        $.get('/ajax/addingroup', {id : el.id, value : valuePost}, function (t)
          {
			try {
				t = JSON.parse(t);
				Doonoyz.message.getInstance('Engine_User.addMember.onclick').display(t['default']);
			} catch (exception) {
				Doonoyz.message.getInstance('Engine_User.addMember.onclick').instance.className = 'errorPopup';
				Doonoyz.message.getInstance('Engine_User.addMember.onclick').display(getString('bigError'));
			}
          }
        );
      }
    }
  );
  
  $(".censorOk").unbind('click').click(function ()
	{
		el = $(this)[0];
		var regexp = /[^_]+_([0-9]+)/;
		infos = regexp.exec(el.id);
		setCookie('censor[' + infos[1] + ']', '1');
		document.location.reload();
	}
  );
  
  $('#createGroupNotExists').unbind('submit').submit(function ()
    {
		var infos = $(this).serialize();
		newGroupCreation(infos);
    }
  );
});