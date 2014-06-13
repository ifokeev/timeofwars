<?
include_once ('db_config.php');
include_once ('db.php');


function checksession() { if (empty($_SESSION['login'])) { include_once('includes/bag_log_in.php'); exit; } }

function checkbattle () {
if ($BattleID != 0) {
?>
<SCRIPT>
window.location.href='main.php';
top.frames['ONLINE'].window.location.href='./chat/online.php?room=main';
top.frames['CHAT'].window.location.href='./chat/chat.php?room=main';
top.frames['bar'].window.location.href='./chat/chatbar.php?room=main';
</SCRIPT>
<?
exit;
}

}


function checkModer () {
$moder_status = 0;

if (!empty($_SESSION['login'])) {

list($ClanID, $LevelV) = $db->queryCheck("SELECT ClanID, Level FROM ".SQL_PREFIX."players WHERE Username = '{$_SESSION['login']}'");

if ($ClanID != 0 && ($ClanID == 1 || $ClanID == 2 || $ClanID == 3 || $ClanID == 4 || $ClanID == 50 || $ClanID == 255) ){ $moder_status = $ClanID; }
if ($_SESSION['login'] == 's!.' || $_SESSION['login'] == 'nyxa'){ $moder_status = 1; }

}

return $moder_status;
}



function checkSessionAuth( ){ if (empty($_SESSION['login'])) { include_once('includes/bag_log_in.php'); exit; } }


function checkSessionAuthBool( ){
	
if( !isset( $_SESSION['login']   ) || empty( $_SESSION['login']   ) ){ return false; 	}
else{ return true; }

}




function checkMoveTo( $id_battle='', $id_user ){
$id_battle = $_SESSION['id_battle'];
$id_user = $_SESSION['id_user'];

checkMoveToBattle( $id_battle );
}



function checkMoveToBattle( $id_battle ){
if( Checker::isFlagBattle( $_SESSION['id_user'] ) ){
echo "<SCRIPT>top.changeGameRoom('battle');</SCRIPT>";
exit();
}
}



function checkMoveToDemands( $id_demand='' ){
if( $_SESSION['id_demand'] != '' ){
echo "<SCRIPT>top.changeGameRoom('demands'); top.changeChatRoom('main');</SCRIPT>";
exit();
}
}



function getStatusArray( ){
global $User, $db;

if( is_a( $User, "User" ) ){ $tmp =& $User->hasStatus; }
elseif( isset($_SESSION['hasStatus']) ){ $tmp =& $_SESSION['hasStatus']; }
elseif( is_a( $db, "db" ) && isset($_SESSION['id_user']) ){

$query = sprintf("SELECT statusName FROM ".SQL_PREFIX."user_status WHERE id_user = '%d';", $_SESSION['id_user'] );
$tmp =& $db->queryArray( $query, "checker_getStatusArray_1" );

} else {
$tmp = array();
}

return $tmp;
}



function checkStatusChaos( $id_user='' ){
if( in_array( 'chaos', getStatusArray() ) ){
print '<CENTER><B>С проклятьем вход воспрещен</B><BR></CENTER>';
exit;
}
}


function checkStatusBlocked( $id_user='' ){
if( in_array( 'blocked', getStatusArray() ) ){
print '<CENTER><B>Персонаж заблокирован</B></CENTER>';
exit;
}
}


function checkHasPicture( $id ){ if( $id > 0 || $GLOBALS['Pict'] > 0 ){ @header ('location: inv.php'); exit; } }


class Checker {

function errorMessage( $msg ){
$dbt = debug_backtrace();
monitor_custom_event( 'Checker', $msg, 1, $dbt );
}



function fileName( $folder, $file ){
global $currentcity, $db_config;
return $db_config[$currentcity]['web_root'].'/cache/'.$folder.'/'.$file;
}



function isFlagBattle( $id_user ){
if( $id_user == '' ){ self::errorMessage( 'Empty UserID' ); }
return file_exists( Checker::fileName( "userbattle", $id_user ) );
}


function setFlagBattle( $id_user ){

if( $id_user == ''){ self::errorMessage( 'Empty UserID' ); }

$fileName = Checker::fileName( "userbattle", $id_user );
if( !file_exists( $fileName ) ){ fclose( fopen( $fileName, 'wt' ) ); }

}



function delFlagBattle( $id_user ){

if( $id_user == ''){ self::errorMessage( 'Empty UserID' ); }
$fileName = Checker::fileName( "userbattle", $id_user );

while ( file_exists( $fileName ) ){
if( unlink( $fileName ) ){ break; }
}

}



function isFlagAction( $id_battle, $id_user ){
if( $id_user == ''){ self::errorMessage( 'Empty UserID' ); }
if( $id_battle == ''){ self::errorMessage( 'Empty BattleID' ); }

$fileName = Checker::fileName( "battleaction", $id_battle."_".$id_user );
return file_exists( $fileName );
}


function setFlagAction( $id_battle, $id_user ){

if( $id_user == ''){ self::errorMessage( 'Empty UserID' ); }
if( $id_battle == ''){ self::errorMessage( 'Empty BattleID' ); }

$fileName = Checker::fileName( "battleaction", $id_battle."_".$id_user );

if( !file_exists( $fileName ) ){ fclose( fopen( $fileName, 'wt' ) ); }

}



function delFlagAction( $id_battle, $id_user ){

if( $id_user == ''){ self::errorMessage( 'Empty UserID' ); }
if( $id_battle == ''){ self::errorMessage( 'Empty BattleID' ); }

$fileName = Checker::fileName( "battleaction", $id_battle."_".$id_user );

while ( file_exists( $fileName ) ){
if( unlink( $fileName ) ){ break; }
}

}



function isFlagRefreshSess( $id_user ){
if( $id_user == ''){ self::errorMessage( 'Empty UserID' ); }
$fileName = Checker::fileName( "refreshsess", $id_user );
return file_exists( $fileName );
}



function setFlagRefreshSess( $id_user ){
if( $id_user == ''){ self::errorMessage( 'Empty UserID' ); }
$fileName = Checker::fileName( "refreshsess", $id_user );
if( !file_exists( $fileName ) ){ fclose( fopen( $fileName, 'wt' ) ); }
}


function delFlagRefreshSess( $id_user ){

if( $id_user == ''){ self::errorMessage( 'Empty UserID' ); }
$fileName = Checker::fileName( "refreshsess", $id_user );

while ( file_exists( $fileName ) ){
if( unlink( $fileName ) ){ break; }
}

}


}
?>
