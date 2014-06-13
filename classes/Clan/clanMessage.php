<?php
include_once ('../checker.php');

session_start();
checkSessionAuth();


$dbClassAdded = true;
require_once ('../db_config.php');
require_once ('db.php');



$clanSmsPrice = 0.1;

require_once ('classes/Old/OldMessages.php');
require_once ('classes/Old/OldUserAdmin.php');
require_once ('classes/Old/OldUserInf.php');
require_once ('classes/Clan/ClanMembers.php');


$User     = new OldUserAdmin( '', '', $emptyObj );
$UserInf  = new OldUserInf( '', '', $User );
$cMembers = new ClanMembers( $User->id_clan );


$msgClan = trim( strip_tags( $_POST['msgText'] ) );


$smsPrice = $cMembers->getClanMemberCount() * $clanSmsPrice;

if( $action == 'CLAN_MEMBERS_MESSAGE' ){

if( $msgClan == ''  ){ $msgError = '���������� �������� �����.'; }
elseif( $UserInf->Money < $smsPrice ){ $msgError = '��� ��������� '.( $smsPrice - $UserInf->Money ).' ��. ��� �������� ���������.'; }
else{
		
$UserInf->modifyMoney( -$smsPrice );
$msgClan = '<b>�������� ��������� �� '.$User->username.'</b> : '.$msgClan;
OldMessages::sendClanMessages( $User->id_clan, $msgClan );
$msgError = '��������� ���������!';

}

}


$tpl->set( 'id_clan', $User->id_clan );
$tpl->set( 'clanSmsPrice', $clanSmsPrice );
$tpl->set( 'smsPrice', $smsPrice );
$tpl->set( 'msgError', $msgError );
$tpl->set( 'clanBody', $tpl->fetch('bodyClanMessage.html') );
echo $tpl->fetch('pageClanBlank.html');
?>
