<?php
require_once ('classes/Old/OldAdminTools.php');
require_once ('classes/Old/OldUserAdmin.php');
require_once ('classes/Clan/ClanDemands.php');
require_once ('classes/Clan/ClanBase.php');
require_once ('includes/to_view.php');

$User   =& new OldUserAdmin( '', '', $User );
$action = $_POST['action'];
$MYDEMANDTEXT = speek_to_view($_POST['MYDEMANDTEXT']);
if( $User->id_clan == 0 ){

$demandInfo = ClanDemands::getClanDemandsByUsername($User->username);

if( !empty($_POST['ADDMYCLANDEMAND']) ){

if( $User->id_clan != 0 ){ $msgError = '�� ��� �������� � ����� '.$User->clanInfo['title']; }
elseif( is_numeric($_POST['ADDMYCLANDEMANDID']) == false ){ $msgError = ''; }
elseif( count( $demandInfo ) > 0  && $demandInfo != false ){ $msgError = '�� ��� ������ ������ � ����.'; }
else{

ClanDemands::addClanDemandByUsername( $User->username, $_POST['ADDMYCLANDEMANDID'], $MYDEMANDTEXT );
$msgError = '���� ������ ������� �������';

}

} elseif ( !empty($_POST['DELMYCLANDEMAND']) ){

if( $User->id_clan != 0 ){ $msgError = '�� ��� �������� � ����� '.$User->clanInfo['title']; }
elseif( count( $demandInfo ) < 1  || $demandInfo == false){ $msgError = '� ��� ��� �������� ������ � ����.'; }
else{

ClanDemands::delClanDemandByUsername( $_SESSION['login'] );
$msgError = '������ ������� ��������.';

}

}

$demandInfo = ClanDemands::getClanDemandsByUsername($User->username);
$tow_tpl->assignGlobal('demandInfo', $demandInfo );

$canAddDemand = ( $User->id_clan == 0 && (count( $demandInfo ) < 1  || $demandInfo == false) );
$tow_tpl->assignGlobal('canAddDemand', $canAddDemand );

$clanList = ClanBase::getClanList();
$tow_tpl->assignGlobal('clanList', $clanList );

}
//else { $msgError = '�� ��� �������� � �����.'; }


$tow_tpl->assignGlobal('username', $username);
?>
