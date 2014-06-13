<?php
class OldMessages {


function OldMessages() { }

	
function sendPrivate( $username, $msg ){
global $db;

$query = sprintf("INSERT INTO `".SQL_PREFIX."messages` ( `Username`, `Text`) VALUES ('%s', '%s');", $username, mysql_escape_string($msg) );
return $db->execQuery( $query, "Messages_sendPrivate_1" );
}


function logTransfer( $loginFrom, $loginTo, $msg ){
global $db;

$query = sprintf("INSERT INTO `".SQL_PREFIX."transfer` ( `Date`, `From`, `To`, `What` ) VALUES ( '%s', '%s', '%s', '%s');", date("Y-m-d"), $loginFrom, $loginTo, mysql_escape_string($msg) );
return $db->execQuery( $query, "Messages_logTransfer_1" );
}
	
	
function addAstralNotes( $astarlName, $username, $onTime, $shutWhy, $status, $astralLogin='', $userLogin='' ){
global $db;

$query = sprintf("INSERT INTO ".SQL_PREFIX."as_notes ( Astral, Username, Time, On_time, Text, Status) VALUES ( '%s', '%s',	'%d',	'%d',	'%s',	'%s' );", $astarlName, $username, time(), $onTime, $shutWhy, $status );
return $db->execQuery( $query, "Messages_addAstralNotes_1" );
}
	
	
function updateAstralNotes( $username, $astralName, $onTime, $NewSS, $status ){
global $db;

$query = sprintf("UPDATE ".SQL_PREFIX."as_notes SET Astral = '%s', Username = '%s', Time = '%d', On_time = '%d', Text = '%s' WHERE Username = '%s' AND Status = '%s';", $astralName, $username, time(), $onTime, mysql_escape_string($NewSS), $username, $status );
$db->execQuery( $query, "Messages_updateAstralNotes_1" );
}


function sendClanMessages( $id_clan, $msg ){
global $db;
		
$msg = nl2br($msg);
		
$query = sprintf("INSERT INTO ".SQL_PREFIX."messages ( `Username`, `text` ) SELECT Username, '%s' FROM ".SQL_PREFIX."clan_user WHERE id_clan = '%d';", mysql_escape_string($msg), $id_clan );
return $db->execQuery( $query, "OldMessages_sendClanMessagesByIdClan_1" );
}


function logDealer( $dealername, $action='', $usernameFrom='', $usernameTo='', $money=0, $descr='' ){
global $db;
		
$dealername = mysql_escape_string($dealername);
$action = mysql_escape_string(strtoupper($action));
$usernameFrom = mysql_escape_string($usernameFrom);
$usernameTo = mysql_escape_string($usernameTo);
$descr = mysql_escape_string($descr);
$money = floatval($money);
		

$query = sprintf("INSERT INTO ".SQL_PREFIX."dealer_logs ( `time`, `Dealername`, `action`, `UsernameFrom`, `UsernameTo`, `Money`, `descr` ) VALUES ( '%d', '%s', '%s', '%s', '%s', '%.2f', '%s' );", time(), $dealername, $action, $usernameFrom, $usernameTo, $money, $descr );
return $db->execQuery( $query, "OldMessages_logDealer_1" );
}



}
?>
