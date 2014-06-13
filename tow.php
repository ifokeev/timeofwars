<?php
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

session_start();
if (empty($_SESSION['login'])) { include_once('includes/bag_log_in.php'); exit; }

if( $_SESSION['userroom'] == 'newby' || $_SESSION['userroom'] == 'female' || $_SESSION['userroom'] == 'trade' || $_SESSION['userroom'] == 'exp' || $_SESSION['userroom'] == 'exp2' || $_SESSION['userroom'] == 'main' )
{	$_SESSION['userroom'] = 'main.php';
}
?>
<HTML>
<HEAD><TITLE>Time OF Wars - <?=$_SESSION['login'];?></TITLE>
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<link rel="SHORTCUT ICON" href="favicon.ico">
<SCRIPT LANGUAGE="JavaScript">
var fr_size = 55;
function change_chatsize(side)
{
		fo = fr_size;
       if(side == 1) fr_size += 3;
       else if(side == 0)
       {
              fr_size -= 3;
    	      if(fr_size < 0) fr_size = 0;
       }
	   ch_size_interv = setTimeout("chsize("+fo+","+fr_size+")",1);
}
function chsize(fo,fs)
{
	if (fs>fo) fo+=10; else fo-=10;
	document.all("mainframes").rows = "93,"+fr_size+"%,41,*,46,0";
	if ((fo-fs)>10 || (fo-fs)<-10) ch_size_interv = setTimeout("chsize("+fo+","+fs+")",1);
}

var CtrlPress   = false;
var ShiftPress  = false;
var Trans       = false;
var RefreshTime = 15000;
var room_now    = "<?=$_SESSION['userroom'];?>";


function AddTo(login){
if (CtrlPress == true) {
login = login.replace('%', '%25');
while (login.indexOf('+')>=0) login = login.replace('+', '%2B');
while (login.indexOf('#')>=0) login = login.replace('#', '%23');
while (login.indexOf('?')>=0) login = login.replace('?', '%3F');
window.open('../inf.php?uname='+login, '_blank')
} else {
if (ShiftPress == true) {
top.frames['bar'].document.getElementById('text').focus();
top.frames['bar'].document.getElementById('text').value = 'private ['+login+'] '+top.frames['bar'].document.getElementById('text').value;
} else {
top.frames['bar'].document.getElementById('text').focus();
top.frames['bar'].document.getElementById('text').value = 'to ['+login+'] '+top.frames['bar'].document.getElementById('text').value;
}
}
}

function AddToPrivate(login, nolookCtrl){
if (CtrlPress) {
login = login.replace('%', '%25');
while (login.indexOf('+')>=0) login = login.replace('+', '%2B');
while (login.indexOf('#')>=0) login = login.replace('#', '%23');
while (login.indexOf('?')>=0) login = login.replace('?', '%3F');
window.open('../inf.php?uname='+login, '_blank')
} else {
top.frames['bar'].document.getElementById('text').focus();
top.frames['bar'].document.getElementById('text').value = 'private ['+login+'] ' + top.frames['bar'].document.getElementById('text').value;
}
}

</SCRIPT>
<script language="JavaScript" type="text/javascript">
//<!--
document.write
(
'<frameset rows="93,55%,41,*,46" frameborder="0" bordercolor="#000000" framespacing="0" id="mainframes">' +
   '<frame src="tow_frames/menunew.html" name="TOPframe" scrolling="no" noresize="noresize">' +
      '<frameset cols="21,*,21" frameborder="0" bordercolor="#000000" framespacing="0">' +
        '<frame src="tow_frames/left2.html" name="left" scrolling="no" noresize="noresize">' +
        '<frame src="'+room_now+'" name="TOP" id="TOP" scrolling="auto">' +
        '<frame src="tow_frames/right2.html" name="right" scrolling="no" noresize="noresize">' +
      '</frameset>' +
   '<frame src="tow_frames/menu.html" name="info" id="info" scrolling="no" noresize="noresize">' +
      '<frameset cols="21,*,18%,21" frameborder="0" bordercolor="#000000" framespacing="0">' +
        '<frame src="tow_frames/left2.html" name="leftchat" scrolling="no" noresize="noresize">' +
        '<frame src="chat/chat.html" name="CHAT_RELOADED" id="CHAT_RELOADED" scrolling="yes" frameborder="0" border="0" framespacing="0" merginwidth="3" marginheight="3">' +
        '<frame src="chat/online.html" name="ONLINE" id="ONLINE" marginwidth="0" marginheight="0" scrolling="auto" frameborder="0" noresize="noresize">' +
        '<frame src="tow_frames/right2.html" scrolling="no" noresize="noresize">' +
      '</frameset>' +
   '<frame src="chat/chatbar.php" name="bar" id="bar" scrolling="no" noresize="noresize">' +
'</frameset>'
);
//-->
</script>
</head>

<noscript>
<font color="Red">Внимание!</font> В вашем браузере отключена поддержка <b>JavaScripts<b>. Необходимо ее включить (это абсолютно безопасно!) для продолжения игры.<br>
</noscript>

</html>
