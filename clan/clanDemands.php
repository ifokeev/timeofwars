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

if( $User->clanAdmin != 1 && $User->hasAdminAbil('CLAN_MANAGE_DEMANDS') == false ){ $msgError = '� ��� ��� ����.'; }
elseif($demandUser == ''){ $msgError = '�������� ��� ���������.'; }
elseif( OldUser::getIdUser($demandUser) == false ){ $msgError = '�������� � �������� ������ �� ������.'; }
else{

ClanDemands::delClanDemandByUsername( $demandUser );
$msgError = '������ ��������� '.$demandUser.' ���������.';
$msgPrivate = '���� ������ �� ���������� � ���� '.$User->clanInfo['title'].' ���������.';
OldMessages::sendPrivate( $demandUser, $msgPrivate );

}

} elseif ( $action == 'acceptDemand' ){

$joinClanInfo = ClanBase::getClanInfoExtendedById( $User->id_clan );
$demandUserClanInfo = OldUser::getUserClan( $demandUser );

if( $User->clanAdmin != 1 && $User->hasAdminAbil('CLAN_MANAGE_DEMANDS') == false ){ $msgError = '� ��� ��� ����.'; }
elseif( $demandUser == '' ){ $msgError = '�������� ��� ���������.'; }
elseif( OldUser::getIdUser($demandUser) == false ){ $msgError = '�������� � �������� ������ �� ������.'; }
elseif( $UserInf->Money < $joinClanInfo['join_price'] ){ $msgError = '��� ��������� '.( $joinClanInfo['join_price'] - $UserInf->Money).' ��. ��� �������� � ����!'; }
elseif( OldUser::getUserCity($demandUser) != $currentcity ){ $msgError = '�������� ����������� � ���� ������.'; }
elseif( $demandUserClanInfo['id_clan'] != 0 ){ $msgError = '�������� ��� ������� � �����.';	$cDemands->rejectClanDemandByUsername( $demandUser ); }
else{

$cDemands->acceptClanDemandByUsername( $demandUser );
$cDemands->rejectClanDemandByUsername( $demandUser );

OldUser::updateUserClan( $demandUser );

$UserInf->modifyMoney( -$joinClanInfo['join_price'] );

$msgError = '�������� '.$demandUser.' ������� �������� � ����!';

$msgPrivate = $User->username.' </b>������ ��� � ���� '.$User->clanInfo['title'];
OldMessages::sendPrivate( $demandUser, $msgPrivate );

}


}


$clanDemands = $cDemands->getClanDemandsList();
$tow_tpl->assignGlobal('clanDemands', $clanDemands );
?>
