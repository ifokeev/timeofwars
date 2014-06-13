<?php
$clanSmsPrice = 0.1;

require_once('classes/Old/OldMessages.php');
require_once('classes/Old/OldUserAdmin.php');
require_once('classes/Old/OldUserInf.php');
require_once('classes/Clan/ClanMembers.php');


$User     =& new OldUserAdmin('', '', $emptyObj);
$UserInf  = new OldUserInf('', '', $User);
$cMembers = new ClanMembers($User->id_clan);
$action   = $_POST['action'];
$msgClan  = trim( strip_tags( $_POST['msgText'] ) );
$smsPrice = $cMembers->getClanMemberCount() * $clanSmsPrice;

if( $action == 'clanMembersMessage' ){

if( $msgClan == ''  ){ $msgError = 'Необходимо написать текст.'; }
elseif( $UserInf->Money < $smsPrice ){ $msgError = 'Вам нехватает '.( $smsPrice - $UserInf->Money ).' кр. для отправки сообщения.'; }
else{

$UserInf->modifyMoney( -$smsPrice );
$msgClan = '<b>Клановое сообщение от '.$User->username.'</b> : '.$msgClan;
OldMessages::sendClanMessages( $User->id_clan, $msgClan );
$msgError = 'Сообщение разослано!';

}

}


$tow_tpl->assignGlobal('clanSmsPrice', $clanSmsPrice);
$tow_tpl->assignGlobal('smsPrice', $smsPrice);
?>
