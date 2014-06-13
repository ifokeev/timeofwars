<?php
include_once ('../checker.php');

session_start();
if (empty($_SESSION['login'])) { include_once('includes/templates/badsession.html'); exit; }

$dbClassAdded = true;
require_once ('../db_config.php');
require_once ('db.php');
require_once ('classes/Old/OldUserAdmin.php');
require_once ('classes/Old/OldChatSendMessages.php');
require_once ('classes/Clan/ClanRelations.php');
require_once ('classes/Clan/ClanBase.php');


$User = new OldUserAdmin( "", "", $emptyObj );
$cRelations = new ClanRelations( $User->id_clan );


$reasonTo = strip_tags( $_POST['reasonTo'] );
$idClan = intval($_POST['idClan']);
$action = strtoupper($_POST['action']);
$clanAlign = $_POST['align'];


if( $action == 'UPDATE_ALIGN'){

setlocale(LC_ALL, "ru_RU.CP1251");

if( $User->clanAdmin != 1 && $User->hasAdminAbil( 'CLAN_MANAGE_ALIGN' ) == false ){ $msgError = 'У вас нет прав на изменение этой информации.'; }
elseif( preg_match( "/[^\w\s\!\?\.\,\-\_]/i", $reasonTo) ){ $msgError = 'Вы ввели недопустимое значение'; }
else{

$relation	= strtoupper( $clanAlign[ $idClan ] );
$cRelations->setRelation( $idClan, $relation, $reasonTo );
		
$clanTo   = ClanBase::getClanInfoById( $idClan );

$fromUser = '<b style="color:red;">Объявление</b>';
$msgChat  = 'Клан <b>'.$User->clanInfo['title'].'</b> <IMG SRC="http://'.$db_config[DREAM_IMAGES][server].'/clan/'.$User->id_clan.'.gif" WIDTH=24 HEIGHT=15 ALT=""> '.ClanRelations::getRelationActionTitle($relation).' <b>'.$clanTo['title'].'</b>" <IMG SRC="http://'.$db_config[DREAM_IMAGES][server].'/'.$clanTo['id_clan'].'.gif" WIDTH=24 HEIGHT=15 ALT=""> по причине : '.$reasonTo;

$chatSendMsg =& new OldChatSendMessages('', '', 'pl');
$chatSendMsg->sendMessage($fromUser, $msgChat);

$chatSendMsg->setNewRoom( 'main' );
$chatSendMsg->sendMessage($fromUser, $msgChat);

$msgError = 'Отношения обновлены.';
}

}


$clanRelations = $cRelations->getRelationList();
	
$tpl->set( 'clanRelations', $clanRelations );
$tpl->set( 'id_clan', $User->id_clan );
$tpl->set( 'msgError', $msgError );

$tpl->set( 'clanBody', $tpl->fetch('bodyClanAlign.html') );


echo $tpl->fetch('pageClanBlank.html');

?>
