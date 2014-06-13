<?php
require_once ('classes/Old/OldUserInf.php');
require_once ('classes/Old/OldUserAdmin.php');
require_once ('classes/Old/OldMessages.php');
require_once ('classes/Clan/ClanDemands.php');
require_once ('classes/Clan/ClanBase.php');

$User     = new OldUserAdmin('', '', $emptyObj);
$UserInf  = new OldUserInf('', '', $User);
$cDemands = new ClanDemands($User->id_clan);


$demandUser = $_POST['demandUser'];
$action     = $_POST['action'];


if($action == 'delDemand') {

if( $User->clanAdmin != 1 && $User->hasAdminAbil('CLAN_MANAGE_DEMANDS') == false ){ $msgError = 'У вас нет прав.'; }
elseif($demandUser == ''){ $msgError = 'Неверное имя персонажа.'; }
elseif( OldUser::getIdUser($demandUser) == false ){ $msgError = 'Персонаж с заданным именем не найден.'; }
else{

ClanDemands::delClanDemandByUsername( $demandUser );
$msgError = 'Заявка персонажа '.$demandUser.' отклонена.';
$msgPrivate = 'Ваша заявка на вступление в клан '.$User->clanInfo['title'].' отклонена.';
OldMessages::sendPrivate( $demandUser, $msgPrivate );

}

} elseif ( $action == 'acceptDemand' ){

$joinClanInfo = ClanBase::getClanInfoExtendedById( $User->id_clan );
$demandUserClanInfo = OldUser::getUserClan( $demandUser );

if( $User->clanAdmin != 1 && $User->hasAdminAbil('CLAN_MANAGE_DEMANDS') == false ){ $msgError = 'У вас нет прав.'; }
elseif( $demandUser == '' ){ $msgError = 'Неверное имя персонажа.'; }
elseif( OldUser::getIdUser($demandUser) == false ){ $msgError = 'Персонаж с заданным именем не найден.'; }
elseif( $UserInf->Money < $joinClanInfo['join_price'] ){ $msgError = 'Вам нехватает '.( $joinClanInfo['join_price'] - $UserInf->Money).' кр. для принятия в клан!'; }
elseif( OldUser::getUserCity($demandUser) != $currentcity ){ $msgError = 'Персонаж отсутствует в этом городе.'; }
elseif( $demandUserClanInfo['id_clan'] != 0 ){ $msgError = 'Персонаж уже состоит в клане.';	$cDemands->rejectClanDemandByUsername( $demandUser ); }
else{

$cDemands->acceptClanDemandByUsername( $demandUser );
$cDemands->rejectClanDemandByUsername( $demandUser );

OldUser::updateUserClan( $demandUser );

$UserInf->modifyMoney( -$joinClanInfo['join_price'] );

$msgError = 'Персонаж '.$demandUser.' успешно добавлен в клан!';

$msgPrivate = $User->username.' </b>принял вас в клан '.$User->clanInfo['title'];
OldMessages::sendPrivate( $demandUser, $msgPrivate );

}


}


$clanDemands = $cDemands->getClanDemandsList();
$tow_tpl->assignGlobal('clanDemands', $clanDemands );
?>
