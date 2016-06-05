/** CONFIG **/
tinyMCE.init({
                        theme : "advanced",
                        theme_advanced_toolbar_location : "top",
                        width:"100%",
                        height:"500px",
                        editor_selector : "tinyMCEArea"
                });

MessageSingleton = {
    messager : Array(),
    add : function () {
        var id = MessageSingleton.messager.length;
        MessageSingleton.messager[id] = new Message();
        return(id);
    },
    getInstance : function (id) {
        return (MessageSingleton.messager[id]);
    },
    create : function (id) {
        if (typeof(MessageSingleton.messager[id]) != 'undefined') {
            MessageSingleton.messager[id].kill();
        }
        MessageSingleton.messager[id] = new Message();
        MessageSingleton.messager[id].instanceName = id;
    }
};

Doonoyz = {
  notes: Array(),
  callback : 0,
  userId : 0,
  infos : 0,
  message : MessageSingleton
};

/** End CONFIG **/
function test()
{
        alert("Library Successfully Loaded !");
}

/**
* Get a PHP assigned string
*
* @param        string                  Assigned string key
* @return       string                  translated text
*/
function                                        getString(key) {
        if (_gAssignedTexts && _gAssignedTexts[key]) {
                return (_gAssignedTexts[key]);
        }
        return ('');
}

/**
* Sets all Js texts for languages
*
* @param        json                    Json stream with all texts translated
*/
function setJsTexts(json)
{
        if (json.length)
        {
                //_gAssignedTexts = new Hash();
				try {
					_gAssignedTexts = JSON.parse(json);
				} catch (exception) {
					_gAssignedTexts = {};
				}
        }
}

function initStarRating()
{
        $('.starRating').each(function (t, e)
        {
                Doonoyz.notes[e.id] = e.innerHTML;
                e.innerHTML = $('#starRating')[0].innerHTML;
        });
       
        $('.starRatingDisabled').each(function (t, e)
        {
                Doonoyz.notes[e.id] = e.innerHTML;
                e.innerHTML = $('#starRating')[0].innerHTML;
        });
        $('.starRating').stars({
                        oneVoteOnly: true,
                        split:2,
                        disabled: (getString('userId') == "userId:0") ? true : false,
                        callback: function(ui, type, value)
                                {
                                        Doonoyz.message.create('initStarRating');
                                        $.get('/ajax/vote', { note : value, id : type.id },
                                                function (t) {
													try {
														t = JSON.parse(t);
                                                        Doonoyz.message.getInstance('initStarRating').display(getString('thankVote'));
                                                    } catch (exception) {
														Doonoyz.message.getInstance('initStarRating').instance.className = 'errorPopup';
                                                        Doonoyz.message.getInstance('initStarRating').display(getString('bigError'));
                                                    }
                                                }
                                        );
                                }
        });
       
        $('.starRatingDisabled').stars({
                        oneVoteOnly: true,
                        disabled: true,
                        split:2
        });
       
        $('.starRating').each(function (t, e)
        {
                setStarNote(e.id, Doonoyz.notes[e.id]);
        });
       
        $('.starRatingDisabled').each(function (t, e)
        {
                setStarNote(e.id, Doonoyz.notes[e.id]);
        });
}

function setStarNote(id, note)
{
        $("#"+id).stars("select", Math.round(note * 2));
}

function getIdFromText(text) {
    var         regexp = /^\w+_(\d+)$/;
    if (found = regexp.exec(text)) {
      return(Number(found[1]));
    }
    return(false);
}

function AjaxLoad(id)
{
	if ($('#'+id)) {
		$('#'+id).html("<img src='/images/ajaxloader.gif' alt='Loading...' />");
	}
}

function getRandomNumber(range)
{
        return Math.floor(Math.random() * range);
}

function getRandomChar()
{
        var chars = "0123456789abcdefghijklmnopqurstuvwxyzABCDEFGHIJKLMNOPQURSTUVWXYZ";
        return chars.substr( getRandomNumber(62), 1 );
}

function randomID(size)
{
        var str = "";
        for(var i = 0; i < size; i++)
        {
                str += getRandomChar();
        }
        return str;
}

function displayNewGroupInterface()
{
  $.facebox(function () {
    $.get('/invitation/newgroup', function (data) {
        $.facebox.reveal(data);
    });
  });
}

function newGroupCreation(infos)
{
  $.facebox(function () {
    Doonoyz.message.create('newGroupCreation');
    $.post("/invitation/newgroup", infos, function (resp) {
		try {
		  data = JSON.parse(resp);
		  if (data['default'] == "error")
		  {
			Doonoyz.message.getInstance('newGroupCreation').instance.className = 'errorPopup';
			Doonoyz.message.getInstance('newGroupCreation').display(getString("urlTaken"));
			displayNewGroupInterface();
		  }
		  else
		  {
			if (typeof(Doonoyz.callback) == "function")
			{
			  Doonoyz.callback(data);
			  Doonoyz.callback = null;
			}
			else
			{
			  var regexp = /name\=([^&]+)/;
			  var array = regexp.exec(infos);
			  Doonoyz.message.getInstance('newGroupCreation').display(getString("createGroupSuccess") + "<br/><a href='http://www.doonoyz.com/"+array[1]+"'>http://www.doonoyz.com/"+array[1]+"</a>", true);
			  $.facebox.close();
			}
		  }
		} catch (exception) {
			Doonoyz.message.getInstance('newGroupCreation').instance.className = 'errorPopup';
			Doonoyz.message.getInstance('newGroupCreation').display(getString("bigError"));
		}
    });
  });
}

function invitationUserInGroup(user, group, infos)
{
  if (group > 0)
  {
    var action = "/invitation/validate/"+user;
    var regexp = /selectedGroup=[0-9]+/;
    Doonoyz.message.create('invitationUserInGroup');
    $.post(action, infos.replace(regexp, "selectedGroup=" + group), function (t)
      {
		try {
			t = JSON.parse(t);
			$.facebox.close();
			Doonoyz.message.getInstance('invitationUserInGroup').display(t['default']);
		} catch (exception) {
			Doonoyz.message.getInstance('invitationUserInGroup').instance.className = 'errorPopup';
			Doonoyz.message.getInstance('invitationUserInGroup').display(getString('bigError'));
		}
      });
  }
  else
  {
    Doonoyz.userId = user;
    Doonoyz.infos = infos;
    Doonoyz.callback = function (groupId)
      {
        invitationUserInGroup(Doonoyz.userId, groupId, Doonoyz.infos)
      };
    displayNewGroupInterface();
  }
}

/**
 * replace all occurences of A by B in expr
 */
function replaceAll(expr, a, b)
{
	var i=0;
	while (i!=-1)
	{
		i=expr.indexOf(a,i);
		if (i>=0)
		{
			expr=expr.substring(0,i)+b+expr.substring(i+a.length);
			i+=b.length;
		}
	}
	return expr;
}

/**
 * Create a cookie
 *
 * @example setCookie('censor[test]', '1', time() + 3600) will set the censor for the group test as read for one hour
 */
function setCookie () {
	var argv=setCookie.arguments;
	var argc=setCookie.arguments.length;
	var name = argv[0];
	var value = argv[1];
	var expires=(argc > 2) ? argv[2] : null;
	var path=(argc > 3) ? argv[3] : null;
	var domain=(argc > 4) ? argv[4] : null;
	var secure=(argc > 5) ? argv[5] : false;
	document.cookie=name+"="+escape(value)+
		((expires==null) ? "" : ("; expires="+expires.toGMTString()))+
		((path==null) ? "" : ("; path="+path))+
		((domain==null) ? "" : ("; domain="+domain))+
		((secure==true) ? "; secure" : "");
}

/**
 * Sort a select by its object
 *
 * @param HTMLElement Element to sort
 */
function sortList(lb)
{
	arrTexts = new Array();
	arrValues = new Array();
	arrOldTexts = new Array();
	for(i = 0; i<lb.length; i++) {
		arrTexts[i] = lb.options[i].text;
		arrValues[i] = lb.options[i].value;
		arrOldTexts[i] = lb.options[i].text;
	}
	arrTexts.sort();
	for(i = 0; i<lb.length; i++) {
		lb.options[i].text = arrTexts[i];
		for(j = 0; j<lb.length; j++) {
			if (arrTexts[i] == arrOldTexts[j]) {
				lb.options[i].value = arrValues[j];
				j = lb.length;
			}
		}
	}
	
	foundIndex = -1;
	for (i = 0; i < lb.length; i++) {
		if (lb.options[i].value == 0) {
			foundIndex = i;
			lb.options[i].selected = 'selected';
		}
	}
	if (foundIndex != -1) {
		lb.insertBefore(lb.options[foundIndex], lb.options[0]);
	}
}
