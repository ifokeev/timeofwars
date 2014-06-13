<?php
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

session_start();
if (empty($_SESSION['login'])) { include_once('includes/bag_log_in.php'); exit; }

if ($_SESSION['login'] != '������' && $_SESSION['login'] != '������' ){ die('������������ ����'); }

$dbClassAdded = true;

include_once('db_config.php');
include_once('db.php');
include_once('classes/Old/OldUser.php');
include_once('classes/Old/OldMessages.php');
include_once('classes/Old/OldUserAdmin.php');
include_once('classes/Old/OldUserInf.php');

$User =& new OldUserAdmin( '', '', $User );

$msgError = '';

@$action = strtoupper($_POST['action']);
@$euroAmount = floatval($_POST['euro']);
@$moneyAmount = floatval($_POST['money']);
$UsernameTo = isset($_REQUEST['usernameTo']) ? $_REQUEST['usernameTo'] : "";
$id_user_to = OldUser::getIdUser($UsernameTo);
$UsernameFrom = isset($_REQUEST['usernameFrom']) ? $_REQUEST['usernameFrom'] : "";
$id_user_from = OldUser::getIdUser($UsernameFrom);
$db->checklevelup( $_SESSION['login'] );
if($action == 'MODIFY_USER_EURO'){

if($id_user_to == ''){ $msgError = '�������� �������� �� ������.'; }
elseif( $euroAmount == 0 ){ $msgError = '������� �������� ����� ����.'; }
else{

$msgDealer = '��������� '.$euroAmount.' ���� '.$UsernameTo;

OldMessages::logDealer($User->username, 'MODIFY_USER_EURO', '', $UsernameTo, $euroAmount, $msgDealer);
OldUserInf::modifyEuroByIdUser($UsernameTo, $euroAmount);

$msgError = '������� �������� ���� ��������� '.$UsernameTo.' �� '.$euroAmount.' ����.';
}

}elseif($action == 'TRANSFER_USERS_EURO'){

if($id_user_to == '' || $id_user_from == ''){ $msgError = '���� �� �������� ���������� �� ������.'; }
elseif( $euroAmount < 1 ){ $msgError = '������ �������� ����� ����.'; }
else{

$msgDealer = '���������� '.$euroAmount.' ���� �� '.$UsernameFrom.' � '.$UsernameTo;

OldMessages::logDealer($User->username, 'TRANSFER_USERS_EURO', $UsernameFrom, $UsernameTo, $euroAmount, $msgDealer);
OldUserInf::modifyEuroByIdUser($UsernameFrom, -$euroAmount);
OldUserInf::modifyEuroByIdUser($UsernameTo, $euroAmount);

$msgError = '������� ���������� '.$euroAmount.' ���� �� ����� '.$UsernameFrom.' �� ���� '.$UsernameTo.'.';

}

}elseif($action == 'MODIFY_USER_MONEY'){

if($id_user_to == ''){ $msgError = '�������� �������� �� ������.'; }
elseif( $moneyAmount == 0 ){ $msgError = '������� �������� ����� ��������.'; }
else{

$msgDealer = '��������� '.$moneyAmount.' �� '.$UsernameTo;

OldMessages::logDealer($User->username, 'MODIFY_USER_MONEY', '', $UsernameTo, $moneyAmount, $msgDealer);
OldUserInf::modifyMoneyByUsername($UsernameTo, $moneyAmount);

$msgError = '������� �������� ���� ��������� '.$UsernameTo.' �� '.$moneyAmount.' ��.';

}

}elseif($action == 'TRANSFER_USERS_MONEY'){

if($id_user_to == '' || $id_user_from == ''){ $msgError = '���� �� �������� ���������� �� ������.'; }
elseif( $moneyAmount < 1 ){ $msgError = '������ �������� ����� ��������.'; }
else{

$msgDealer = '���������� '.$moneyAmount.' �� �� '.$UsernameFrom.' � '.$UsernameTo;

OldMessages::logDealer($User->username, 'TRANSFER_USERS_MONEY', $UsernameFrom, $UsernameTo, $moneyAmount, $msgDealer);
OldUserInf::modifyMoneyByUsername($UsernameFrom, -$moneyAmount);
OldUserInf::modifyMoneyByUsername($UsernameTo, $moneyAmount);

$msgError = '������� ���������� '.$moneyAmount.' �� �� ����� '.$UsernameFrom.' �� ���� '.$UsernameTo.'.';

}

}



$query = sprintf("SELECT b.Username, b.Euro, IFNULL(p.Money, 0 ) as Money, IF(p.Username IS NULL, 'DEAD', 'ALIVE') as isDead FROM ".SQL_PREFIX."bank_acc b LEFT JOIN ".SQL_PREFIX."players p ON (p.Username = b.Username) ORDER BY b.Username;");
$euroAccounts = $db->queryArray($query, 'admEuro_getEuroAccounts_1');

$query = sprintf("SELECT * FROM ".SQL_PREFIX."dealer_logs WHERE action = 'MODIFY_USER_MONEY' OR action = 'MODIFY_USER_EURO' ORDER BY time DESC");
$dealerlog = $db->queryArray($query, 'admEuro_getKREDIT_acc_1');

require_once('_loader.php');

$tow_tpl->assignGlobal('db_config', $db_config);

$temp = & $tow_tpl->getDisplay('content', true);

$temp->assign('dealerlog', $dealerlog );
$temp->assign('euroAccounts', $euroAccounts );
$temp->assign('username', $User->username );
$temp->assign('msgError' , $msgError);

$temp->addTemplate('dealer', 'timeofwars_adm_dealeradmin.html');


$show = & $tow_tpl->getDisplay('index');

$show->assign('title', 'Time Of Wars - ��������� �������');
$show->assign('Content', $temp);


$show->addTemplate('header', 'header_noframes.html');
$show->addTemplate('index' , 'index.html' );
$show->addTemplate('footer', 'footer.html');


$tow_tpl->display();
?>
