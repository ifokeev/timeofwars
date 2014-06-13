<?php
class OldChatSendMessages {
	
var $lock;
var $id_user;
var $username;
var $room_file;
var $unix_microtime;
var $timenow;
	

function __construct( $id_user, $username, $room ){
global $db_config, $currentcity;
		
$this->lock = true;
		
$this->id_user = $id_user;
$this->username = $username;
		
$this->room_file = $db_config[$currentcity]['web_root']."/chat/".$room.".txt";
		
$this->unix_microtime = $this->GetMicroTime();
$this->timenow = date("H:i");
		
if( !file_exists($this->room_file) ){ touch( $this->room_file ); }

}
	

function GetMicroTime(){
$t_mtime = split(" ",microtime());
return ( (intval( substr( $t_mtime[1], -6) ) + $t_mtime[0]) * 1000000 );
}


function setNewRoom( $room ){
global $db_config, $currentcity;
$this->room_file = $db_config[$currentcity]['web_root']."/chat/".$room.".txt";
}


function writePrivate( ){
global $db;

$query = sprintf("SELECT Text FROM `".SQL_PREFIX."messages` WHERE Username = '%s';", $this->username );
$res = $db->query( $query, "ChatSendMessages_writePrivate_1" );


if( mysql_num_rows( $res ) > 0 ){
$this->begin();

while( ($my_message = mysql_fetch_array($res)) ){
$this->write( $this->unix_microtime.">><a class=date>".$this->timenow."</a> <FONT SIZE=\"2\"> <span class=private> private [".$this->username."]</span> ".$my_message['Text']." </FONT>");
}
			

$this->commit();
			
$query = sprintf("DELETE FROM `".SQL_PREFIX."messages` WHERE Username = '%s';", $this->username );
$db->execQuery( $query, "ChatSendMessages_writePrivate_2" );
}

}
	

function sendMessage( $fromUser, $msgChat ){
$str = $this->unix_microtime.">><a class=date>".$this->timenow."</a> <FONT SIZE=\"2\"> [".$fromUser."]</span> ".$msgChat." </FONT>";
$this->writeNew( $str );
}


function writeNew( $msg ){

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
