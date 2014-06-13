<?php
require_once ('classes/Old/OldUserAdmin.php');
require_once ('classes/Old/OldChatSendMessages.php');
require_once ('classes/Clan/ClanRelations.php');
require_once ('classes/Clan/ClanBase.php');


$User       = new OldUserAdmin('', '', $emptyObj);
$cRelations = new ClanRelations( $User->id_clan );
$reasonTo   = strip_tags( $_POST['reasonTo'] );
$idClan     = intval($_POST['idClan']);
$action     = $_POST['action'];
$clanAlign  = $_POST['align'];


if( $action == 'updateAlign' ){

if( $User->clanAdmin != 1 && $User->hasAdminAbil( 'CLAN_MANAGE_ALIGN' ) == false ){ $msgError = '� ��� ��� ���� �� ��������� ���� ����������.'; }
elseif( preg_match( "/[^\w\s\!\?\.\,\-\_]/i", $reasonTo) ){ $msgError = '�� ����� ������������ ��������'; }
else{

$relation	= strtoupper( $clanAlign[ $idClan ] );
$cRelations->setRelation( $idClan, $relation, $reasonTo );

$clanTo   = ClanBase::getClanInfoById( $idClan );

$fromUser = '<b style="color:red;">����������</b>';
$msgChat  = '���� <img src="http://'.$db_config[DREAM_IMAGES][server].'/clan/'.$User->id_clan.'.gif" width="24px" height="15" alt=""> <b> '.$User->clanInfo['title'].' </b>'.ClanRelations::getRelationActionTitle($relation).'<img src="http://'.$db_config[DREAM_IMAGES][server].'/clan/'.$clanTo['id_clan'].'.gif" width="24px" height="15px" alt=""> <b> '.$clanTo['title'].' </b> �� ������� : '.$reasonTo;

//$msgChat  = iconv('WINDOWS-1251', 'UTF-8', $msgChat);

$chatSendMsg =& new OldChatSendMessages('', '', 'pl');
$chatSendMsg->sendMessage($fromUser, $msgChat);

$chatSendMsg->setNewRoom( 'main' );
$chatSendMsg->sendMessage($fromUser, $msgChat);

$msgError = '��������� ���������.';
}

}


$clanRelations = $cRelations->getRelationList();
$tow_tpl->assignGlobal('clanRelations', $clanRelations);
?>
