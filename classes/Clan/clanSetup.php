<?php
include_once ('../checker.php');

session_start();
checkSessionAuth();

$dbClassAdded = true;
require_once ('../db_config.php');
require_once ('db.php');
require_once ('classes/ChatSendMessages.php');
require_once ('classes/Old/OldAdminClan.php');
require_once ('classes/Old/OldAdminRules.php');
require_once ('classes/Old/OldUserAdmin.php');


$action = $_POST['action'];

$User = new OldUserAdmin( $_SESSION['login'], '', $emptyObj );
$tpl->set( 'id_clan', $User->id_clan );


if( $action == "UPDATE_SETUP" ){
	
$set = array();
	
if( $User->clanAdmin != 1 && $User->hasAdminAbil( 'CLAN_MANAGE_SETUP' ) == false ){ $msgError = 'У вас нет прав на изменение настроек клана.'; }
elseif( isset($_POST['updateLink']) ){

if( $_POST['clanLink'] == '' ){ $msgError = 'Необходимо ввести значение.'; }
elseif( preg_match( "/[^a-z0-9.\/:\-]/i", $_POST['clanLink']) != false ){ $msgError = 'Вы ввели недопустимое значение'; }
else{

$set['link'] = mysql_escape_string($_POST['clanLink']);
$msgError = 'Ссылка на клановую страничку успешно обновлена';

}

}elseif( isset($_POST['updateSlogan']) ){

if( $_POST['clanSlogan'] == '' ){ $msgError = 'Необходимо ввести значение.'; }
elseif( preg_match( "/[^a-zа-я0-9 ]/i", $_POST['clanSlogan'] ) != false ){ $msgError = 'Вы ввели недопустимое значение'; }
else{

$set['slogan'] = mysql_escape_string($_POST['clanSlogan']);
$msgError = 'Слоган успешно обновлен';

}

}elseif( isset($_POST['updateAdvert']) ){

if( $_POST['clanAdvert'] == '' ){ $msgError = 'Необходимо ввести значение.'; }
elseif( preg_match( "/[^a-zа-я0-9 ]/i", $_POST['clanAdvert'] ) != false ){ $msgError = 'Вы ввели недопустимое значение'; }
else{

$set['advert'] = mysql_escape_string($_POST['clanAdvert']);
$msgError = 'Реклама успешно обновлена';
}

}

if( count($set) > 0 ){
$db->update( "timeofwars_clan", $set, array( 'id_clan' => $User->id_clan ), "cl_updateClanSetup_1" );
}

}
	
$query = sprintf("SELECT slogan, advert, link FROM ".SQL_PREFIX."clan WHERE id_clan = '%d';", $User->id_clan );
$clanSetup = $db->queryRow( $query, "cl_getClanSetup_1" );
	

$tpl->set( 'clanSetup', $clanSetup );
$tpl->set( 'msgError', $msgError );
$tpl->set( 'clanBody', $tpl->fetch("bodyClanSetup.html") );
echo $tpl->fetch('pageClanBlank.html');
?>
