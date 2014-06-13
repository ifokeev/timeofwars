(function($){$.alerts={verticalOffset:-75,horizontalOffset:0,repositionOnResize:true,overlayOpacity:.01,overlayColor:'#FFF',draggable:true,okButton:'&nbsp;OK&nbsp;',cancelButton:'&nbsp;Cancel&nbsp;',dialogClass:null,alert:function(b,c,d){if(c==null)c='Alert';$.alerts._show(c,b,null,'alert',function(a){if(d)d(a)})},confirm:function(b,c,d){if(c==null)c='Confirm';$.alerts._show(c,b,null,'confirm',function(a){if(d)d(a)})},prompt:function(b,c,d,e){if(d==null)d='Prompt';$.alerts._show(d,b,c,'prompt',function(a){if(e)e(a)})},_show:function(b,c,d,f,g){$.alerts._hide();$.alerts._overlay('show');$("BODY").append('<div id="popup_container">'+'<h1 id="popup_title"></h1>'+'<div id="popup_content">'+'<div id="popup_message"></div>'+'</div>'+'</div>');if($.alerts.dialogClass)$("#popup_container").addClass($.alerts.dialogClass);var h=($.browser.msie&&parseInt($.browser.version)<=6)?'absolute':'fixed';$("#popup_container").css({position:h,zIndex:99999,padding:0,margin:0});$("#popup_title").text(b);$("#popup_content").addClass(f);$("#popup_message").text(c);$("#popup_message").html($("#popup_message").text().replace(/\n/g,'<br />'));$("#popup_container").css({minWidth:$("#popup_container").outerWidth(),maxWidth:$("#popup_container").outerWidth()});$.alerts._reposition();$.alerts._maintainPosition(true);switch(f){case'alert':$("#popup_message").after('<div id="popup_panel"><input type="button" value="'+$.alerts.okButton+'" id="popup_ok" /></div>');$("#popup_ok").click(function(){$.alerts._hide();g(true)});$("#popup_ok").focus().keypress(function(e){if(e.keyCode==13||e.keyCode==27)$("#popup_ok").trigger('click')});break;case'confirm':$("#popup_message").after('<div id="popup_panel"><input type="button" value="'+$.alerts.okButton+'" id="popup_ok" /> <input type="button" value="'+$.alerts.cancelButton+'" id="popup_cancel" /></div>');$("#popup_ok").click(function(){$.alerts._hide();if(g)g(true)});$("#popup_cancel").click(function(){$.alerts._hide();if(g)g(false)});$("#popup_ok").focus();$("#popup_ok, #popup_cancel").keypress(function(e){if(e.keyCode==13)$("#popup_ok").trigger('click');if(e.keyCode==27)$("#popup_cancel").trigger('click')});break;case'prompt':$("#popup_message").append('<br /><input type="text" size="30" id="popup_prompt" />').after('<div id="popup_panel"><input type="button" value="'+$.alerts.okButton+'" id="popup_ok" /> <input type="button" value="'+$.alerts.cancelButton+'" id="popup_cancel" /></div>');$("#popup_prompt").width($("#popup_message").width());$("#popup_ok").click(function(){var a=$("#popup_prompt").val();$.alerts._hide();if(g)g(a)});$("#popup_cancel").click(function(){$.alerts._hide();if(g)g(null)});$("#popup_prompt, #popup_ok, #popup_cancel").keypress(function(e){if(e.keyCode==13)$("#popup_ok").trigger('click');if(e.keyCode==27)$("#popup_cancel").trigger('click')});if(d)$("#popup_prompt").val(d);$("#popup_prompt").focus().select();break}if($.alerts.draggable){try{$("#popup_container").draggable({handle:$("#popup_title")});$("#popup_title").css({cursor:'move'})}catch(e){}}},_hide:function(){$("#popup_container").remove();$.alerts._overlay('hide');$.alerts._maintainPosition(false)},_overlay:function(a){switch(a){case'show':$.alerts._overlay('hide');$("BODY").append('<div id="popup_overlay"></div>');$("#popup_overlay").css({position:'absolute',zIndex:99998,top:'0px',left:'0px',width:'100%',height:$(document).height(),background:$.alerts.overlayColor,opacity:$.alerts.overlayOpacity});break;case'hide':$("#popup_overlay").remove();break}},_reposition:function(){var a=(($(window).height()/2)-($("#popup_container").outerHeight()/2))+$.alerts.verticalOffset;var b=(($(window).width()/2)-($("#popup_container").outerWidth()/2))+$.alerts.horizontalOffset;if(a<0)a=0;if(b<0)b=0;if($.browser.msie&&parseInt($.browser.version)<=6){a=a+$(window).scrollTop()}$("#popup_container").css({top:a+'px',left:b+'px'});$("#popup_overlay").height($(document).height())},_maintainPosition:function(a){if($.alerts.repositionOnResize){switch(a){case true:$(window).bind('resize',$.alerts._reposition);break;case false:$(window).unbind('resize',$.alerts._reposition);break}}}};jAlert=function(a,b,c){$.alerts.alert(a,b,c)};jConfirm=function(a,b,c){$.alerts.confirm(a,b,c)};jPrompt=function(a,b,c,d){$.alerts.prompt(a,b,c,d)}})(jQuery);