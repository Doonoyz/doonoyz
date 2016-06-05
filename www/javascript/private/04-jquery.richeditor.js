/**
  * jQuery richeditor editor plugin (version 1.1.0)  
  *
  */

tinyMCE.init({
			theme : "advanced",
			theme_advanced_toolbar_location : "top",
			editor_selector : "jQueryRichEditor"
		});

jQuery.fn.richeditor = function(url, options) {

    /* prevent elem has no properties error */
    if (this.length == 0) { 
        return false; 
    }

    var settings = {
        url    : url,
        name   : 'value',
        id     : 'id',
        width  : 'auto',
        height : 'auto',
        event  : 'click',
        onblur : 'cancel'
    };

    if(options) {
        jQuery.extend(settings, options);
    }
      
    jQuery(this).attr('title', settings.tooltip);

    jQuery(this)[settings.event](function(e) {

        /* save this to self because this changes when scope changes */
        var self = this;

        /* prevent throwing an exeption if edit field is clicked again */
        if (self.editing) {
            return;
        }
        if (self.cancel) {
            self.cancel = false;
            return;
        }

        /* figure out how wide and tall we are */
        var width = 
            ('auto' == settings.width)  ? jQuery(self).css('width')  : settings.width;
        var height = 
            ('auto' == settings.height) ? jQuery(self).css('height') : settings.height;

        self.editing    = true;
        self.revert     = jQuery(self).html();
        self.innerHTML  = '';

        /* create the form object */
        var f = document.createElement('form');

        /** Create buttons in top too **/
        if (settings.submit) {
            var b = document.createElement('input');
            b.type = 'submit';
            b.value = settings.submit;
            f.appendChild(b);
        }

        if (settings.cancel) {
            var b = document.createElement('input');
            b.type = 'button';
            b.value = settings.cancel;
            b.onclick = reset;
            f.appendChild(b);
        }
        /** End **/

        /*  main input element */
        var i;
				i = document.createElement('textarea');
				if (settings.rows) {
						i.rows = settings.rows;
				} else {
						jQuery(i).css('height', height);
				}
				if (settings.cols) {
						i.cols = settings.cols;
				} else {
						jQuery(i).css('width', width);
				}
				i.id = 'valueToInsertMCE';
				i.className = 'jQueryRichEditor';
				
				
        
        /* set input content via POST, GET, given data or existing value */
        /* this looks weird because it is for maintaining bc */
        var url;
        var type;
                
        if (settings.getload) {
            url = settings.getload;
            type = 'GET';
        } else if (settings.postload) {
            url = settings.postload;
            type = 'POST';      
        }

        if (url) {
            var data = {};
            data[settings.id] = self.id;
            jQuery.ajax({
               type : type,
               url  : url,
               data : data,
               success: function(str) {
                  i.value = str;
               }
            });
        } else if (settings.data) {
            i.value = settings.data;
        } else { 
            i.value = self.revert;
        }

        i.name  = settings.name;
        f.appendChild(i);
        
        if (settings.submit) {
            var b = document.createElement('input');
            b.type = 'submit';
            b.value = settings.submit;
            f.appendChild(b);
        }

        if (settings.cancel) {
            var b = document.createElement('input');
            b.type = 'button';
            b.value = settings.cancel;
            b.onclick = reset;
            f.appendChild(b);
        }

        /* add created form to self */
        self.appendChild(f);
        tinyMCE.execCommand('mceAddControl', false, "valueToInsertMCE");

        z = document.getElementById('tinymce');
        /* discard changes if pressing esc */
        jQuery(z).keydown(function(e) {
            if (e.keyCode == 27) {
                e.preventDefault();
                reset();
            }
        });

        /* discard, submit or nothing with changes when clicking outside */
        /* do nothing is usable when navigating with tab */
        var t;
        /*if ('cancel' == settings.onblur) {
            jQuery(i).blur(function(e) {
                t = setTimeout(reset, 500)
            });
        
        } else if ('submit' == settings.onblur) {
            jQuery(i).blur(function(e) {
                jQuery(f).submit();
            });
        } else {
            jQuery(i).blur(function(e) {
             
            });
        }*/
        
        jQuery(f).submit(function(e) {

            if (t) { 
                clearTimeout(t);
            }

            /* do no submit */
            e.preventDefault(); 

            /* add edited content and id of edited element to POST */           
            var p = {};
            p[i.name] = tinyMCE.activeEditor.getContent();
            p[settings.id] = self.id;

            tinyMCE.execCommand('mceRemoveControl', false, 'valueToInsertMCE');
            /* show the saving indicator */
            jQuery(self).html(options.indicator);
            // jQuery(self).load(settings.url, p, function(str) {
            jQuery.get(settings.url, p, function(str) {
                str = eval('('+str+')');
                self.innerHTML = str['default'];
                self.editing = false;
            });
            return false;
        });

        function reset() {
          tinyMCE.execCommand('mceRemoveControl', false, 'valueToInsertMCE');
            self.innerHTML = self.revert;
            self.editing   = false;
            self.cancel = true;
        }

    });

    return(this);
};
