function defPosition(event) {
            var x = y = 0;
            if (document.attachEvent != null) { // Internet Explorer & Opera
            x = window.event.clientX + (document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft);
            y = window.event.clientY + (document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop);
      } else if (!document.attachEvent && document.addEventListener) { // Gecko
            x = event.clientX + window.scrollX;
            y = event.clientY + window.scrollY;
      } else {
            // Do nothing
      }
      return {x:x, y:y};
}

function menu(login, evt) {
      // Ѕлокируем всплывание событи€ contextmenu
      evt = evt || window.event;
      evt.cancelBubble = true;

      // ѕоказываем собственное контекстное меню
      var menu = document.getElementById("contextMenuId");



      var html = '<a class=menuItem href="javascript:MsgTo(\''+login+'\')">TO</a>'+
	   '<a class=menuItem href="javascript:Private(\''+login+'\');">PRIVATE</a>'+
	   '<a class=menuItem href="../inf.php?uname='+login+'" target=_blank onclick=";return true;">INFO</a>'+
	   '<a class=menuItem href="javascript:ClipBoard(\''+login+'\');">COPY</a>';

      // ≈сли есть что показать - показываем
      if (html) {
            menu.innerHTML = html;
            menu.style.top = defPosition(evt).y + "px";
            menu.style.left = defPosition(evt).x + "px";
            menu.style.display = "";
      }
      // Ѕлокируем всплывание стандартного браузерного меню
      return false;
}

function addHandler(object, event, handler, useCapture) {
      if (object.addEventListener) {
            object.addEventListener(event, handler, useCapture ? useCapture : false);
      } else if (object.attachEvent) {
            object.attachEvent('on' + event, handler);
      } else alert("Add handler is not supported");
}
addHandler(document, "contextmenu", function() {
      document.getElementById("contextMenuId").style.display = "none";
});
addHandler(document, "click", function() {
      document.getElementById("contextMenuId").style.display = "none";
});

function a_click(login, e)
{	if (window.event){  e = window.event.srcElement;  o = window.event; }
	else{ e = e.target; o = e; }

   if (o.shiftKey) {
   		top.frames['bar'].document.getElementById('text').focus();
		  top.frames['bar'].document.getElementById('text').value = 'private ['+login+'] '+top.frames['bar'].document.getElementById('text').value;
   } else {
   		if (o.ctrlKey) {
   			top.frames['bar'].document.getElementById('text').focus();
			window.open('http://tow.su/inf.php?uname='+login, '_blank');
   		} else {

			MsgTo(login);
   		}
   }

};


function AddLogin(login, e)
{	if (window.event){  e = window.event.srcElement;  o = window.event; }
	else{ e = e.target; o = e; }

	if (e.tagName != "SPAN") return true;

	if (e.className == "private")
		{ Private(login) }
	else
		{ MsgTo(login) }
};

function MsgTo(login){
top.frames['bar'].document.getElementById('text').focus();
top.frames['bar'].document.getElementById('text').value+= 'to ['+login+'] ';
};

function Private(login){
top.frames['bar'].document.getElementById('text').focus();
top.frames['bar'].document.getElementById('text').value='private ['+login+'] '+top.frames['bar'].document.getElementById('text').value;
};

function ClipBoard(text)
{
	clipboardData.setData("Text", text);
};