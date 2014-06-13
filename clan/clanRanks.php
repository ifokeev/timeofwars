<?php
function sec2Date( $time ){
$month = floor( $time / 2592000 );
$min	= ($time/60)	% 60;
$hours	= ($time/3600)	% 24;
$days	= ($time/86400)	% 30;
return (($month > 0)? $month.' ���. ':'' ).(($days > 0)? $days.' ��. ':'' ).(($hours > 0)? $hours.' � ':'' ).(($min > 0)? $min.' � ':'' );
}


function date2Sec( $month=0, $days=0, $hours=0, $min=0 ){
return (intval($month)*2592000 + intval($days)*86400 + intval($hours)*3600 + intval($min)*60);
}


require_once('classes/Old/OldUserAdmin.php');
require_once('classes/Clan/ClanRanks.php');

$User           = new OldUserAdmin( $_SESSION['login'], '', $emptyObj );
$cRanks         = new ClanRanks( $User->id_clan );
$aClan          = new OldAdminClan( $User->id_clan );
$id_rank		    = intval( $_POST['id_rank'] );
$id_icon		    = intval( $_POST['id_icon'] );
$rankName		    = trim( preg_replace( "/[^a-zA-Z�-��-�0-9 -]*/i", "", $_POST['rankName'] ) );
$id_admin_abils	= $id_admin_rules = $_POST['id_admin']; // array()

if( !empty($_POST['addClanRank']) ){

if( $rankName == '' ){ $msgError = '���������� ������ �������� �����.'; }
elseif( strlen($rankName) < 3 ){ $msgError = '���� ������ <u>���������� ���</u> �����.'; }
elseif( $User->clanAdmin != 1 && $User->hasAdminAbil('CLAN_MANAGE_RANKS') == false ){ $msgError = '� ��� ��� ���� ��� �������� ������ �����.'; }
else{

$newIdRank = $cRanks->createClanRank( $rankName );
$msgError = '����� ���� '.$rankName.' ������.';

}

} elseif ( !empty($_POST['delClanRank']) ){

if( $id_rank < 1 ){ $msgError = '���������� ������� ���� ��� ��������.'; }
elseif( $User->clanAdmin != 1 && $User->hasAdminAbil('CLAN_MANAGE_RANKS') == false ){ $msgError = '� ��� ��� ���� ��� �������� �����.'; }
else{

$cRanks->destroyClanRank( $id_rank );
$msgError = '���� ������� ������.';

}

} elseif ( !empty($_POST['delClanRankRule']) ){

if( $id_rank < 1 ){ $msgError = '���������� ������� ����.'; }
elseif( $User->clanAdmin != 1 && $User->hasAdminAbil('CLAN_MANAGE_RULES') == false ){ $msgError = '� ��� ��� ���� ��� �������� ���������� ���������.'; }
else{

$cRanks->clearClanRankRules( $id_rank );

if(!empty($id_admin_rules)){
foreach($id_admin_rules as $id_admin_rules){
$cRanks->addClanRankRule( $id_rank, $id_admin_rules );
}
}

$msgError = '������ ��������� ����� ��������� ��������.';

}

} elseif ( !empty($_POST['action']) && $_POST['action'] == 'updateSetupPerms'){

if( $id_rank < 1 ){ $msgError = '���������� ������� ����.'; }
elseif( $User->clanAdmin != 1 && $User->hasAdminAbil('CLAN_MANAGE_ABILS') == false ){ $msgError = '� ��� ��� ���� ��� ���������� ���������� ������������.'; }
else{

$cRanks->clearClanRankAbils( $id_rank );

if(!empty($id_rank)){
foreach($_POST as $k => $v){
if (preg_match("/perm/i", $k)) {

if( $k == 'permDemands' ){     $val = 'perm_demands'; }
elseif( $k == 'permWeapons' ){ $val = 'perm_weapons'; }
elseif( $k == 'permAlign' ){   $val = 'perm_align';   }
elseif( $k == 'permRank' ){    $val = 'perm_rank';    }
elseif( $k == 'permMembers' ){ $val = 'perm_members'; }
elseif( $k == 'permSetup' ){   $val = 'perm_setup';   }
else{ die; }

$cRanks->SetRankAbil( $id_rank, $val );
}
}
}


$msgError = '������ ��������� ����� ���������� ���������.';
}

} elseif ( !empty($_POST['UPDATE_CLAN_RANK_ICON']) ){

if( $id_rank < 1 ){ $msgError = '���������� ������� ����.'; }
elseif( $User->clanAdmin != 1 && $User->hasAdminAbil('CLAN_MANAGE_RANKS') == false ){ $msgError = '� ��� ��� ���� ��� ��������� ������ ������ �����.'; }
else{

$cRanks->setClanRankIcon( $id_rank, $id_icon );
$msgError = '������ ����� ��������.';

}

}



if( $User->clanInfo['type'] == 'ASTRAL'){

if( $clan_info['admin'] == 1 || $User->hasAdminAbil('CLAN_MANAGE_RULES') ){ $rulesAll = $aClan->getClanRulesList(); }
else{ $rulesAll	= $User->getAdminRules( $User->username, $User->id_user, $User->id_rank ); }

} else {
$rulesAll = array();
}

$tow_tpl->assignGlobal('rulesAll', $rulesAll );


if( $User->clanAdmin == 1 || $User->hasAdminAbil('CLAN_MANAGE_ABILS') ){ }
else{ $abilsAll = $User->getAdminAbils( $User->username, $User->id_user, $User->id_rank ); }

$tow_tpl->assignGlobal('abilsAll', $abilsAll );


$clanRankAll = $cRanks->getClanRankAll();
$tow_tpl->assignGlobal('clanRankAll', $clanRankAll );


$rankIconsPath = $db_config[DREAM_IMAGES]['web_root'].'/clan/rank/';
$rankIconWeb = 'http://'.$db_config[DREAM_IMAGES]['server'].'/clan/rank/';

$rankIconFiles = array();
// ��� ������ ������
$rankIconFiles[0] = 'http://'.$db_config[DREAM_IMAGES]['server'].'/clan/'.$User->id_clan.'.gif';


$temp = glob( $rankIconsPath.$User->id_clan."_*.gif" );

if(!empty($temp))foreach( $temp as $rankIconFile ){
$rankIconFile = basename($rankIconFile);
list( $clan, $icon, ) = split( '[_.]', $rankIconFile );
$rankIconFiles[ $icon ] = $rankIconWeb.$rankIconFile;
}

$tow_tpl->assignGlobal('rankIconFiles', $rankIconFiles);

$sql_all_ranks = $db->query("SELECT * FROM ".SQL_PREFIX."clan_ranks WHERE id_clan = '$User->id_clan'");
$tow_tpl->assignGlobal('sql_all_ranks', $sql_all_ranks);
?>
