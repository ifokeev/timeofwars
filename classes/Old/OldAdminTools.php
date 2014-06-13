<?php
require_once ('db.php');

class OldAdminTools {

function OldAdminTools() { }


function writeSystemMessage( $msgSys ){
global $cSendMessage, $User, $unix_microtime, $timenow;

$msgChat = $unix_microtime.">><a class=date>".$timenow."</a>"." <FONT SIZE=\"2\"> <IMG SRC='/images/clan/".$User->id_clan.".gif' WIDTH=24 HEIGHT=15 ALT=''> ".$msgSys." </FONT>";
$cSendMessage->writeNew( $msgChat );
}

	

function isUserStopped( $username ){
global $db;
		
$query = sprintf("SELECT `Time` FROM ".SQL_PREFIX."stopped WHERE Username = '%s';", $username );
$res = $db->queryRow( $query, "OldAdminTools_isUserStopped_1" );

return ($res['Time'] - time()) > 0;
}


function setUserStopped( $username, $onTime ){
global $db;
		
$toTime = time() + $onTime;
		
$res = true;
		
$query = sprintf("UPDATE ".SQL_PREFIX."online SET Stop = '1' WHERE Username = '%s';", $username );
$res = $res && $db->execQuery( $query, "OldAdminTools_setUserStopped_1" );
		
$query = sprintf("INSERT INTO ".SQL_PREFIX."stopped (`Username`, `Time`) VALUES ('%s', '%d') ON DUPLICATE KEY UPDATE `Time` = `Time` + '%d';", $username, $toTime, $onTime );
$res = $res && $db->execQuery( $query, "OldAdminTools_setUserStopped_2" );

return $res;
}
	
	
function delUserStopped( $username ){
global $db;
		
$res = true;

$query = sprintf("DELETE FROM ".SQL_PREFIX."stopped WHERE Username = '%s';", $username );
$res = $res && $db->execQuery( $query, "OldAdminTools_delUserStopped_1" );
		
$query = sprintf("UPDATE ".SQL_PREFIX."online SET Stop = '0' WHERE Username = '%s';", $username );
$res = $res && $db->execQuery( $query, "OldAdminTools_delUserStopped_2" );
		
return $res;
}

	
function isUserChaos( $username ){
global $db;
		
$query = sprintf("SELECT `FreeTime` as `Time` FROM ".SQL_PREFIX."chaos WHERE Username = '%s';", $username );
$res = $db->queryRow( $query, "OldAdminTools_isUserChaos_1" );

return ($res['Time'] - time()) > 0;
}


function setUserChaos( $username, $onTime, $comment, $link ){
global $db;
		
$query = sprintf("SELECT id_clan FROM ".SQL_PREFIX."clan_user WHERE Username = '%s';", $username );
$res = $db->queryRow( $query, "OldAdminTools_setUserChaos_1" );
		
$wasclan = isset( $res['id_clan']) ? $res['id_clan'] : 0;
		
$toTime = time() + $onTime;
$res = true;
		
$query = sprintf("INSERT INTO ".SQL_PREFIX."chaos (`Username`, `FreeTime`, `Comment`, `wasclan`, `link`) VALUES ('%s', '%d', '%s', '%d', '%s') ON DUPLICATE KEY UPDATE `FreeTime` = `FreeTime` + '%d', `Comment` = CONCAT_WS( ',', `Comment`, '%s' ), `wasclan` = '%d', `link` = CONCAT_WS( ',', `link`, '%s' );", $username, $toTime, mysql_escape_string($comment), $wasclan, mysql_escape_string($link), $onTime, mysql_escape_string($comment), $wasclan, mysql_escape_string($link)	);
$res = $res && $db->execQuery( $query, "OldAdminTools_setUserChaos_1" );
		
$query = sprintf("UPDATE ".SQL_PREFIX."online o SET o.ClanID = '200' WHERE o.Username = '%s';", $username );
$res = $res && $db->execQuery( $query, "OldAdminTools_setUserChaos_2" );
		
$query = sprintf("INSERT INTO ".SQL_PREFIX."clan_user (`id_clan`, `Username`) VALUES ( '200', '%s') ON DUPLICATE KEY UPDATE id_clan = '200';", $username	);
$res = $res && $db->execQuery( $query, "OldAdminTools_setUserChaos_2" );

return $res;
}
	
	
function delUserChaos( $username ){
global $db;
		
$query = sprintf("SELECT wasclan FROM ".SQL_PREFIX."chaos WHERE Username = '%s';", $username );
$res = $db->queryRow( $query, "OldAdminTools_delUserChaos_1" );
$wasclan = $res['wasclan'];
		
$res = true;

$query = sprintf("DELETE FROM ".SQL_PREFIX."chaos WHERE Username = '%s';", $username );
$res = $res && $db->execQuery( $query, "OldAdminTools_delUserChaos_2" );
		
$query = sprintf("UPDATE ".SQL_PREFIX."online SET ClanID = '%d' WHERE Username = '%s';", $wasclan, $username );
$res = $res && $db->execQuery( $query, "OldAdminTools_delUserChaos_3" );
		

if( $wasclan > 0 ){
			
$query = sprintf("INSERT INTO ".SQL_PREFIX."clan_user (id_clan, Username) VALUES ('%d', '%s' ) ON DUPLICATE KEY UPDATE id_clan = '%d';", $wasclan, $username, $wasclan	);
$res = $res && $db->execQuery( $query, "OldAdminTools_delUserChaos_4" );

}
		
return $res;
}

	
	
function isUserBlock( $username ){
global $db;
		
$query = sprintf("SELECT `Time` FROM ".SQL_PREFIX."blocked WHERE Username = '%s';", $username );
$res = $db->queryRow( $query, "OldAdminTools_isUserBlock_1" );

return ($res['Time'] > 0 );
}


function setUserBlock( $username, $onTime, $comment='', $link='' ){
global $db;
		
$res = true;
		
$toTime = time() + $onTime;
		
$query = sprintf("INSERT INTO ".SQL_PREFIX."blocked (`Username`, `Time`, `Why`, `link`) VALUES ('%s', '%d', '%s', '%s') ON DUPLICATE KEY UPDATE `Time` = `Time` + '%d', `Why` = CONCAT_WS( ',', `Why`, '%s' ), `link` = CONCAT_WS( ',', `link`, '%s' );", $username, $toTime, mysql_escape_string($comment), mysql_escape_string($link), $onTime, mysql_escape_string($comment), mysql_escape_string($link) );
$res = $res && $db->execQuery( $query, "OldAdminTools_setUserBlock_1" );
		
$query = sprintf("UPDATE ".SQL_PREFIX."online SET SId = '0' WHERE Username = '%s';", $username );
$db->query( $query, "OldAdminTools_setUserBlock_1" );

return $db->execQuery( $query, "OldAdminTools_setUserBlock_1" );
}


function delUserBlock( $username ){
global $db;
		
$res = true;

$query = sprintf("DELETE FROM ".SQL_PREFIX."blocked WHERE Username = '%s';", $username );
$res = $res && $db->execQuery( $query, "OldAdminTools_delUserBlock_2" );
		
return $res;
}

	
function hasAccessTo( $name ){
global $User;

if( !is_a($User, "UserAdmin") ){ return false; }

return $User->hasAdminAbil( $name );
}


function isUserOnline( $username ){
global $db;

$query = sprintf("SELECT Username FROM ".SQL_PREFIX."online WHERE Username = '%s';", $username );
return $db->queryCheck( $query, "OldAdminTools_isUserOnline_1" );
}


function hasUserStatus( $username, $statusName ){
		
switch ($statusName) {
case 'stop':  return self::isUserStopped( $username ); break;
case 'chaos': return self::isUserChaos( $username );   break;
case 'block': return self::isUserBlock( $username );   break;
default: return false; break;
}
		
}


function setUserStatus( $username, $statusName, $onTime, $comments='', $link='' ){
		
		
switch ($statusName) {
case 'stop':  self::setUserStopped( $username, $onTime );                 break;
case 'chaos': self::setUserChaos( $username, $onTime, $comments, $link ); break;
case 'block': self::setUserBlock( $username, $onTime, $comments, $link ); break;
default: return false; break;
}
		
}


function delUserStatus( $username, $statusName ){
		
switch ($statusName) {
case 'stop':  self::delUserStopped( $username ); break;
case 'chaos': self::delUserChaos( $username );   break;
case 'block': self::delUserBlock( $username );   break;
default: return false; break;
}

}


function getUserStatusList( $username ){
global $db;
		
$query = sprintf("
SELECT `Time` as `Time`, 'none' as `Comment`, 'none' as `Link`, 'stop' as `Name` FROM ".SQL_PREFIX."stopped WHERE Username = '%s' UNION
SELECT `FreeTime` as `Time`, `Comment` as `Comment`, `link` as `Link`, 'chaos' as `Name` FROM ".SQL_PREFIX."chaos WHERE Username = '%s' UNION
SELECT `Time` as `Time`, `Why` as `Comment`, `link` as `Link`, 'block' as `Name` FROM ".SQL_PREFIX."blocked WHERE Username = '%s';", $username, $username, $username );
		
return $db->queryArray( $query, "OldAdminTools_getUserStatusList_1" );
}


function isBattleExists( $id_battle ){
global $db;

$query = sprintf("SELECT id_battle FROM ".SQL_PREFIX."battle WHERE id_battle = '%d';", $id_battle );
return $db->queryCheck( $query, "AdminTools_isBattleExists_1" );
}


function setBattleEnd( $id_battle ){
global $db;

$query = sprintf("UPDATE ".SQL_PREFIX."battle_participant SET canMove = 'END' WHERE id_battle = '%d';", $id_battle );
$db->execQuery( $query, "AdminTools_setBattleEnd_1" );
}


function getAstralClanInfo( $id_clan ){
global $db;

$query = sprintf("SELECT * FROM ".SQL_PREFIX."clan WHERE id_clan = '%d';", $id_clan );
$res = $db->query( $query, "AdminTools_getAstralClanInfo_1" );
}



}
?>
