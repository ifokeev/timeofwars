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

if( $clanUser == '' ){ $msgError = '���������� ������� ���������'; }
elseif( $User->username == $clanUser ){ $msgError = '���� ������� ������!'; }
elseif( $User->clanAdmin != 1 && $User->hasAdminAbil('CLAN_MANAGE_MEMBERS') == false ){ $msgError = '� ��� ��� ���� �� ��������� ������� �����.'; }
elseif( $userToLeft['admin'] == 1 ){ $msgError = '����� ����� ������ �������'; }elseif( $UserInf->Money < $leftClanInfo['left_price'] ){ $msgError = '��� ��������� '.( $joinClanInfo['join_price'] - $UserInf->Money).' ��.!'; }
elseif( OldUser::getUserCity( $clanUser ) != $currentcity ){ $msgError = '�������� ��������� � ������ ������.'; }
else{

$cMembers->removeClanMemberByUsername( $clanUser );
OldUser::updateUserClan( $clanUser );

$UserInf->modifyMoney( -$joinClanInfo['left_price'] );

$msgError = $clanUser.' ������ �� �������� ������ ������ �����';

$msgPrivate = '��� ������ '.$User->username.' �� ����� '.$User->clanInfo['title'].'.';
OldMessages::sendPrivate( $clanUser, $msgPrivate );

}

} elseif($action == 'updateRank'){

$rankInfo = OldAdminClan::getClanRank( $User->id_clan, $newUserRank );

if( $clanUser == '' ){ $msgError = '���������� ������� ��������'; }
elseif( $User->username == $clanUser ){ $msgError = '������ ��������� ���� ����!'; }
elseif( $User->clanAdmin != 1 && $User->hasAdminAbil('CLAN_MANAGE_USERS_RANG') == false ){ $msgError = '� ��� ��� ���� �� ��������� ����� ���������.'; }
elseif( OldUser::getIdUser( $clanUser ) == false ){ $msgError = '������ �������� �� ������.'; }
else{

$cMembers->setClanMemberRankByUsername( $clanUser, $rankInfo['id_rank'] );

if( $rankInfo['id_rank'] < 1 ){
$msgError = '��������� '.$clanUser.' ������� � �����.';
$msgPrivate = $User->username.' ������� ��� � �����. ';
} else {
$msgError = '��������� '.$clanUser.' ������� ����� ���� '.$rankInfo['Title'];
$msgPrivate = $User->username.' ��������� ��� ����� ���� '.$rankInfo['Title'];
}

OldMessages::sendPrivate( $clanUser, $msgPrivate );

}

}

$clanMembers = $cMembers->getClanMemberList();
$tow_tpl->assignGlobal('clanMembers', $clanMembers );

$clanRankAll    = OldAdminClan::getClanRankAll( $User->id_clan );
$tow_tpl->assignGlobal('clanRankAll', $clanRankAll );
?>
