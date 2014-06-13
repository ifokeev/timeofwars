<?php
require_once ('classes/ChatSendMessages.php');
require_once ('classes/Old/OldAdminClan.php');
require_once ('classes/Old/OldAdminRules.php');
require_once ('classes/Old/OldUserAdmin.php');

$action = $_POST['action'];
$User   =& new OldUserAdmin($_SESSION['login'], '', $emptyObj);


if($action == 'updateSetup'){

$set = array();

if( $User->clanAdmin != 1 && $User->hasAdminAbil('CLAN_MANAGE_SETUP') == false ){ $msgError = '� ��� ��� ���� �� ��������� �������� �����.'; }
elseif( isset($_POST['updateLink']) ){

if( $_POST['clanLink'] == '' ){ $msgError = '���������� ������ ��������.'; }
elseif ( preg_match( "/[^a-z0-9.\/:\-]/i", $_POST['clanLink']) != false ){ $msgError = '�� ����� ������������ ��������'; }
else{

$set['link'] = mysql_escape_string($_POST['clanLink']);
$msgError = '������ �� �������� ��������� ������� ���������';

}

} elseif ( isset($_POST['updateSlogan']) ){

if( $_POST['clanSlogan'] == ''){ $msgError = '���������� ������ ��������.'; }
elseif( preg_match( "/[^a-z�-�0-9 ]/i", $_POST['clanSlogan'] ) != false ){ $msgError = '�� ����� ������������ ��������'; }
else{

$set['slogan'] = mysql_escape_string($_POST['clanSlogan']);
$msgError = '������ ������� ��������';

}

} elseif ( isset($_POST['updateAdvert']) ){

if($_POST['clanAdvert'] == ''){ $msgError = '���������� ������ ��������.'; }
elseif( preg_match( "/[^a-z�-�0-9 ]/i", $_POST['clanAdvert'] ) != false ){ $msgError = '�� ����� ������������ ��������'; }
else{

$set['advert'] = mysql_escape_string($_POST['clanAdvert']);
$msgError = '������� ������� ���������';

}

}

if( count($set) > 0 ){ $db->update(SQL_PREFIX.'clan', $set, array( 'id_clan' => $User->id_clan ), 'cl_updateClanSetup_1'); }

}

$query = sprintf("SELECT slogan, advert, link FROM ".SQL_PREFIX."clan WHERE id_clan = '%d';", $User->id_clan );
$clanSetup = $db->queryRow( $query, "cl_getClanSetup_1" );
$tow_tpl->assignGlobal('clanSetup', $clanSetup);
?>
