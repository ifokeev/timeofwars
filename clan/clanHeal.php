<?php
require_once ('classes/Clan/ClanHeal.php');
require_once ('classes/Old/OldUserAdmin.php');

$User      =& new OldUserAdmin( '', '', $User );
$action    = $_POST['action'];
$userWater = intval($_POST['userwater']);

if( isset($action) && !empty($action) ){
$cHeal = new ClanHeal($User->id_clan, $User->username, $User->id_rank );
}


if($action == 'LIOT'){

if( is_numeric($userWater) == false ){ $msgError = '� ����� ������� ������ �����!'; }
elseif( $userWater < 1 ){ $msgError = '������ ��������! � ���� �� '.$cHeal->hpNow.'HP'; }
elseif( $cHeal->hpNow < $userWater ){ $msgError = '�������� ��������� ���� ��� ���� ����� ��������.'.$cHeal->hpNow.'HP'; }
elseif( ($cHeal->currentSize + $cHeal->convertUserHp($userWater)) > $cHeal->maxSize  ){ $msgError = '���� ������ ������� ���� ��� ������ ���������� ��������� ����.'; }
else{

$cHeal->userLiot($userWater);
$msgError = '�� ������� ���������� ��������� ����� � ������.';

}


} elseif ( $action == 'PIOT' ){

if (is_numeric($userWater)== false) { $msgError = '� ����� ������� ������ �����!'; }
elseif( $userWater < 1 ){ $msgError = '����, �������! ��� �� '.$cHeal->currentSize.'HP"'; }
elseif ($cHeal->currentSize < $userWater) { $msgError = '� ����� ������ ���� ������� ��������� ����.'; }
elseif (($cHeal->hpNow+$userWater) > $cHeal->hpAll){ $msgError = '�� ���� �������� ������ ������ ��� � ��� ������.'; }
else{

$cHeal->userPiot($userWater);
$msgError = '�� ������� ����������� ��������� ����� �� �����.';

}

}

$poilkaInfo = ClanHeal::getPoilkaInfo( $User->id_clan, $_SESSION['login'] );
$tow_tpl->assignGlobal( 'poilkaInfo', $poilkaInfo );
?>
