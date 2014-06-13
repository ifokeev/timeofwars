<?php
require_once ('classes/Old/OldUserAdmin.php');
require_once ('classes/Old/OldUserInf.php');
require_once ('classes/Old/OldMessages.php');
require_once ('classes/Old/OldAdminClan.php');
require_once ('classes/Clan/ClanBase.php');
require_once ('classes/Clan/ClanMembers.php');

$User        =& new OldUserAdmin('', '', $emptyObj);
$UserInf     = new OldUserInf('', '', $User);
$cMembers    = new ClanMembers( $User->id_clan );
$action      = $_POST['action'];
$clanUser    = $_POST['clanUser'];
$newUserRank = intval( $_POST['id_rank'] );


if($action == 'deleteFromClan'){

$leftClanInfo = ClanBase::getClanInfoExtendedById( $User->id_clan );
$userToLeft   = OldUser::getUserClan( $clanUser );

if( $clanUser == '' ){ $msgError = 'Необходимо выбрать персонажа'; }
elseif( $User->username == $clanUser ){ $msgError = 'Себя выгнать нельзя!'; }
elseif( $User->clanAdmin != 1 && $User->hasAdminAbil('CLAN_MANAGE_MEMBERS') == false ){ $msgError = 'У вас нет прав на изменение состава клана.'; }
elseif( $userToLeft['admin'] == 1 ){ $msgError = 'Главу клана нельзя выгнать'; }elseif( $UserInf->Money < $leftClanInfo['left_price'] ){ $msgError = 'Вам нехватает '.( $joinClanInfo['join_price'] - $UserInf->Money).' кр.!'; }
elseif( OldUser::getUserCity( $clanUser ) != $currentcity ){ $msgError = 'Персонаж находится в другом городе.'; }
else{

$cMembers->removeClanMemberByUsername( $clanUser );
OldUser::updateUserClan( $clanUser );

$UserInf->modifyMoney( -$joinClanInfo['left_price'] );

$msgError = $clanUser.' больше не является членом вашего клана';

$msgPrivate = 'Вас выгнал '.$User->username.' из клана '.$User->clanInfo['title'].'.';
OldMessages::sendPrivate( $clanUser, $msgPrivate );

}

} elseif($action == 'updateRank'){

$rankInfo = OldAdminClan::getClanRank( $User->id_clan, $newUserRank );

if( $clanUser == '' ){ $msgError = 'Необходимо выбрать персонаж'; }
elseif( $User->username == $clanUser ){ $msgError = 'Нельзя назначить себе ранг!'; }
elseif( $User->clanAdmin != 1 && $User->hasAdminAbil('CLAN_MANAGE_USERS_RANG') == false ){ $msgError = 'У вас нет прав на изменение ранга персонажа.'; }
elseif( OldUser::getIdUser( $clanUser ) == false ){ $msgError = 'Данный персонаж не найден.'; }
else{

$cMembers->setClanMemberRankByUsername( $clanUser, $rankInfo['id_rank'] );

if( $rankInfo['id_rank'] < 1 ){
$msgError = 'Персонажу '.$clanUser.' понижен в ранге.';
$msgPrivate = $User->username.' понизил вас в ранге. ';
} else {
$msgError = 'Персонажу '.$clanUser.' назнаен новый ранг '.$rankInfo['Title'];
$msgPrivate = $User->username.' назначили вам новый ранг '.$rankInfo['Title'];
}

OldMessages::sendPrivate( $clanUser, $msgPrivate );

}

}

$clanMembers = $cMembers->getClanMemberList();
$tow_tpl->assignGlobal('clanMembers', $clanMembers );

$clanRankAll    = OldAdminClan::getClanRankAll( $User->id_clan );
$tow_tpl->assignGlobal('clanRankAll', $clanRankAll );
?>
