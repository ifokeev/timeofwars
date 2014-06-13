<?php
require_once('db.php');

class Messages {

function Messages() { }

	
function sendPrivate( $id_user, $msg ){
global $db;


$query = sprintf("INSERT INTO `".SQL_PREFIX."messages` ( `Username`, `Text`) VALUES ('%s', '%s');", $id_user, mysql_escape_string($msg));
return $db->execQuery( $query, "Messages_sendPrivate_1" );

}



function logTransfer( $loginFrom, $loginTo, $msg ){
global $db;

$query = sprintf("INSERT INTO `".SQL_PREFIX."transfer` ( `Date`, `From`, `To`, `What` ) VALUES ( '%s', '%s', '%s', '%s');", date("Y-m-d"), $loginFrom, $loginTo, mysql_escape_string($msg));
return $db->execQuery( $query, "Messages_logTransfer_1" );
}
	
	

function addAstralNotes( $id_astral, $id_user, $onTime, $shutWhy, $status, $astralLogin='', $userLogin='' ){
global $db;

$query = sprintf("INSERT INTO ".SQL_PREFIX."as_notes (id_astral, id_user, Time, On_time, Text, Status, Astral, Username) VALUES ( '%d',		'%d',	'%d',	'%d',	'%s',	'%s',	'%s',	'%s' );", $id_astral, $id_user, time(), $onTime, $shutWhy, $status,  $astralLogin, $userLogin );
$db->execQuery( $query, "Messages_addAstralNotes_1" );
}
	
	

function updateAstralNotes( $id_user, $astralName, $onTime, $NewSS, $status ){
global $db;
		
$query = sprintf("UPDATE ".SQL_PREFIX."as_notes SET Astral = '%s', Username = '%s', Time = '%d', On_time = '%d', Text = '%s' WHERE id_user = '%d' AND Status = '%s';", $astralName, $username, time(), $onTime, mysql_escape_string($NewSS), $id_user, $status );
$db->execQuery( $query, "Messages_updateAstralNotes_1" );
}



function sendClanMessages( $id_clan, $msg ){
global $db;
		
$query = sprintf("INSERT INTO ".SQL_PREFIX."messages ( `Username`, `text` ) SELECT Username, '%s' FROM ".SQL_PREFIX."clan_user WHERE id_clan = '%d';", mysql_escape_string($msg), $id_clan );
return $db->execQuery( $query, "Messages_sendClanMessagesByIdClan_1" );
}


}
?>
