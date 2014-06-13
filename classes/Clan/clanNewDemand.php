<?php
include_once ('../checker.php');

session_start();
checkSessionAuth();


$dbClassAdded = true;
require_once ('../db_config.php');
require_once ('db.php');
require_once ('classes/Old/OldAdminTools.php');
require_once ('classes/Old/OldUserAdmin.php');
require_once ('classes/Clan/ClanDemands.php');
require_once ('classes/Clan/ClanBase.php');

$User =& new OldUserAdmin( '', '', $User );


if( $User->id_clan == 0 ){
	

$demandInfo = ClanDemands::getClanDemandsByUsername($User->username);
	
if( $action == 'ADD_DEMAND' ){

if( $User->id_clan != 0 ){ $msgError = '�� ��� �������� � ����� '.$User->clanInfo['title']; }
elseif( is_numeric($_POST['idClan']) == false ){ $msgError = ''; }
elseif( count( $demandInfo ) > 0  && $demandInfo != false ){ $msgError = '�� ��� ������ ������ � ����.'; }
else{
	
ClanDemands::addClanDemandByUsername( $User->username, $_POST['idClan'] );
$msgError = '���� ������ ������� �������';

}
	
}elseif( $action == 'DELETE_DEMAND' ){
	
if( $User->id_clan != 0 ){ $msgError = '�� ��� �������� � ����� '.$User->clanInfo['title']; }
elseif( count( $demandInfo ) < 1  || $demandInfo == false){ $msgError = '� ��� ��� �������� ������ � ����.'; }
else{
			
ClanDemands::delClanDemandByUsername( $_SESSION['login'] );
$msgError = '������ ������� ��������.';

}
	
}
	


$demandInfo   = ClanDemands::getClanDemandsByUsername($User->username);
$canAddDemand = ( $User->id_clan == 0 && (count( $demandInfo ) < 1  || $demandInfo == false) );
$clanList     = ClanBase::getClanList();
	

$tpl->set( 'clanList', $clanList );
$tpl->set( 'canAddDemand', $canAddDemand );
$tpl->set( 'demandInfo', $demandInfo );
$tpl->set( 'clanBody', $tpl->fetch('bodyClanNewDemand.html') );
	
} else {
	
$msgError = '�� ��� �������� � �����.';
$tpl->set( 'clanBody', '' );

}


$tpl->set( 'username', $username );
$tpl->set( 'msgError', $msgError );
echo $tpl->fetch('pageClanBlank.html');
?>
