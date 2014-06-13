<?php


class ChatSendMessages {

private $login;
private $unix_microtime;
private $timenow;
public  $room_file;
public  $lock;


function __construct( $login, $room, $adm = 0 ){
global $db_config, $currentcity;

$this->lock           = true;

$this->login          = $login;

$this->adm            = $adm;

$this->uroom          = $room;

//$this->room_file      = $db_config[$currentcity]['web_root'].'/chat/'.$room.'.txt';
$this->room_file      = $db_config[$currentcity]['web_root'].'/chat/allchat.txt';


$this->unix_microtime = $this->GetMicroTime();

$this->timenow        = date('H:i');

if( !file_exists($this->room_file) ){ touch( $this->room_file ); @chmod($this->room_file, 0666); }

}

function __destruct(){$this->lock;
$this->login;
$this->room_file;
$this->unix_microtime;
$this->timenow;
}



function GetMicroTime(){

$t_mtime = split(" ",microtime());
return ( (intval( substr( $t_mtime[1], -6) ) + $t_mtime[0]) * 1000000 );

}


function writePrivate(){
global $db;

$query = sprintf("SELECT Username, Text FROM `".SQL_PREFIX."messages` WHERE Username = '%s';", $this->login);
$res = $db->queryArray( $query, "ChatSendMessages_writePrivate_1" );

if(!empty($res)){

$this->begin();

foreach($res as $v){
//$v['Username'] = iconv('utf-8', 'windows-1251', $v['Username']);
//$v['Text'] = iconv('windows-1251', 'utf-8', $v['Text']);
$this->write( $this->unix_microtime.'>><a class="date">'.$this->timenow.'</a> <font size="2"> <span class="private">private ['.$v['Username'].']</span> '.$v['Text'].' </font>' );
}

$this->commit();

$query = sprintf("DELETE FROM `".SQL_PREFIX."messages` WHERE Username = '%s';", $this->login);
$db->execQuery( $query, "ChatSendMessages_writePrivate_2" );

}

}

function add_line( $msg_text, $privat = false ){global $db, $db_config;


if( strlen($msg_text) < 500  ){
if( $res = $db->queryRow("SELECT Time FROM ".SQL_PREFIX."stopped WHERE Username = '$this->login'") ){

if (time() > $res['Time']){
$db->execQuery("DELETE from ".SQL_PREFIX."stopped WHERE Username = '$this->login'");
$db->update( SQL_PREFIX.'online', Array( 'Stop' => '0' ), Array( 'Username' => $this->login ) );
}

die( 'talking_off' );

} else {

if((time() - $_SESSION['lastMsgTime']) < 3 ){

die( 'very_quick' );

} elseif($msg_text == $_SESSION['lastMsgText'] && (time() - $_SESSION['lastMsgTime']) < 10) {

die( 'flood' );


} else {

$_SESSION['lastMsgTime']    = time();
$_SESSION['lastMsgText']    = $msg_text;
$msg_text                   = $this->chat_filter($msg_text);
$msg_text                   = TestStroka($msg_text);
$msg_text                   = string_cut($msg_text, 98);

//if( preg_match('/Opera/', getenv('HTTP_USER_AGENT')) ){
$msg_text = iconv('utf-8', 'windows-1251', $msg_text);
//}


if( preg_match ('/\[B\]/i', $msg_text) && $this->adm == 1 ){	$msg_text = eregi_replace('\[B\]', '', $msg_text); $msg_text = '<b>'.$msg_text.'</b>';
}

if( preg_match ('/\/me/i', $msg_text) ){	$msg_text = eregi_replace('/me', '', $msg_text);   $msg_text = '<i>'.$msg_text.'</i>';
}

	$this->sendMessageChat($this->login, $msg_text);
/*
if( $privat == false )
{	$this->sendMessage($this->login, $msg_text);
}
else
{	$this->sendMessage($this->login, $msg_text);

	preg_match('/private \[(.*)\]/i', $msg_text, $uname);
	$CR = $db->SQL_result($db->query( "SELECT ChatRoom FROM ".SQL_PREFIX."players WHERE Username = '".speek_to_view(mysql_escape_string($uname[1]))."';" ));
	if( empty($CR) ) die;

    $this->room_file = $db_config[DREAM]['web_root'].'/chat/'.$CR.'.txt';

    if( $this->uroom != $CR )
	$this->sendMessage($this->login, $msg_text);
}
*/

}

}

}


}


function chat_filter($s){
$str = $s;
$str = trim($str);
$str = htmlspecialchars($str, ENT_NOQUOTES);
$str = str_replace( '&lt;', '<', $str );
$str = str_replace( '&gt;', '>', $str );
$str = str_replace( '&quot;', '"', $str );
$str = str_replace( '&amp;', '&', $str );
$str = str_replace( '&', '&#38', $str );
$str = str_replace( '"', '&#34', $str );
$str = str_replace( "'", '&#39', $str );
$str = str_replace( '<', '&#60', $str );
$str = str_replace( '>', '&#62', $str );
$str = str_replace( '\0', '', $str );
$str = str_replace( '', '', $str );
$str = str_replace( '\t', '', $str );
$str = str_replace( '../', '. . / ', $str );
$str = str_replace( '..', '. . ', $str );
$str = str_replace( ';', '&#59', $str );
$str = str_replace( '/*', '', $str );
$str = str_replace( '%00', '', $str );
$str = stripslashes( $str );
$str = str_replace( '\\', '&#92', $str );
return $str;
}


function sendMessageChat( $fromUser, $msgChat ){

$str = $this->unix_microtime.'>><a class="date">'.$this->timenow.'</a> <font size="2"> <span>['.$fromUser.']</span> '.$msgChat.' </font>';
$this->writeNewChat( $str );

}

function writeNewChat( $msg ){

//$msg = iconv('utf-8', 'windows-1251', $msg);
//$msg = iconv('windows-1251', 'utf-8', $msg);
$msg = str_replace('\\\'','\'', $msg);
$msg = str_replace('\\\\','\\', $msg);
$msg = str_replace('\\&quot;','&quot;', $msg);

$this->begin();
$this->write($msg);
$this->commit();

echo $msg;
}


function sendMessage( $fromUser, $msgChat ){

$str = $this->unix_microtime.'>><a class="date">'.$this->timenow.'</a> <font size="2"> <span>['.$fromUser.']</span> '.$msgChat.' </font>';
$this->writeNew( $str );

}


function writeNew( $msg ){

//$msg = iconv('utf-8', 'windows-1251', $msg);
//$msg = iconv('windows-1251', 'utf-8', $msg);
$msg = str_replace('\\\'','\'', $msg);
$msg = str_replace('\\\\','\\', $msg);
$msg = str_replace('\\&quot;','&quot;', $msg);

$this->begin();
$this->write($msg);
$this->commit();


}



function begin( ){

$this->fh = fopen( $this->room_file, "a");

if ( $this->lock === true ){ flock( $this->fh, LOCK_EX ); }

}



function write( $msg ){
fwrite( $this->fh, trim($msg)."\n" );
}


function commit( ){

if ( $this->lock === true ){ flock( $this->fh, LOCK_UN ); }
fclose($this->fh);

}


}
?>
