<?php
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

session_start();
if (empty($_SESSION['login'])) { include_once('includes/bag_log_in.php'); exit; }
if ($_SESSION['login'] != '������' && $_SESSION['login'] != '������'){ die('�� �� ��������� ���������������'); }
$msgError = '';
$dbClassAdded = true;
require_once('db_config.php');
require_once('db.php');
require_once('classes/Old/OldUser.php');
require_once('classes/Old/OldUserAdmin.php');
require_once('classes/Old/OldUserInf.php');
require_once('classes/Clan/ClanBase.php');
$db->checklevelup( $_SESSION['login'] );
$User =& new OldUserAdmin( '', '', $User );
$iconWidth = 24;
$iconHeight = 15;
$iconBigWidth = 64;
$iconBigHeight = 64;

/*
1 = GIF, 2 = JPG, 3 = PNG, 4 = SWF,
5 = PSD, 6 = BMP, 7 = TIFF(intel byte order), 8 = TIFF(motorola byte order),
9 = JPC, 10 = JP2, 11 = JPX, 12 = JB2,
13 = SWC, 14 = IFF, 15 = WBMP, 16 = XBM
*/

$iconType = 1;
$iconExt = 'gif';

$iconBigType = 1;
$iconBigExt = 'gif';

$iconPath = 'images/clan';
$iconPathRank = $iconPath.'/rank';

$iconWeb = 'http://'.$db_config[DREAM_IMAGES]['server'].'/clan';
$iconWebRank = $iconWeb.'/rank';

@$action = strtoupper($_POST['action']);

@$id_clan = intval($_POST['id_clan']);
$clanInfo = ClanBase::getClanInfoById( $id_clan );

@$rankIconNum = intval($_POST['rank']);

@$title = mysql_escape_string(trim($_POST['title']));
@$type = mysql_escape_string( strtoupper( trim($_POST['type']) ) );

$joinPrice = 20;
$leftPrice = 5;

//@$joinPrice = intval($_POST['joinPrice']);
//@$leftPrice = intval($_POST['leftPrice']);

@$clanIcon = $_FILES['icon'];
$clanIcon['info'] = getimagesize($clanIcon['tmp_name']);

@$clanLink	= trim($_POST['clanLink']);
@$clanSlogan	= trim($_POST['clanSlogan']);
@$clanAdvert	= trim($_POST['clanAdvert']);

$Username = isset($_REQUEST['username']) ? $_REQUEST['username'] : '';
$id_user = OldUser::getIdUser( $Username );

if( $action == 'CREATE_NEW_CLAN' ){

if( $id_clan < 1 ){ $msgError = '���������� ������� ID �����'; }
elseif($title == ''){ $msgError = '���������� ������ �������� �����'; }
elseif(!empty($clanInfo)){ $msgError = '���� � �������� ID ��� ������.'; }
else{

ClanBase::createNewClan($id_clan, $title, 'CLAN', $joinPrice, $leftPrice);
$msgError = '����� ���� ������. ID: '.$id_clan.' - '.$title.'.';

}

}elseif($action == 'UPDATE_CLAN_ADMIN'){

if( $id_clan < 1 ){ $msgError = '���������� ������� ID �����'; }
elseif( empty($clanInfo) ){ $msgError = '���� � �������� ID �� ������.'; }
elseif( $id_user == false ){ $msgError = '�������� ��� ���������.'; }
else{

$query = sprintf("UPDATE ".SQL_PREFIX."clan_user SET admin = '0' WHERE id_clan = '%d';", $id_clan);
$db->execQuery($query, 'admClan_resetClanAdmin_1');

$query = sprintf("INSERT INTO ".SQL_PREFIX."clan_user ( `id_clan`, `Username`, `admin`, `id_rank` ) VALUES ( '%d', '%s', '1', '0' ) ON DUPLICATE KEY UPDATE admin = '1', id_rank = '0', id_clan = '%d';", $id_clan, $Username, $id_clan);
$db->execQuery( $query, "admClan_setClanAdmin_1" );

$msgError = '����� ID: '.$id_clan.' ������� �������� ����� '.$Username.'.';

}

}elseif($action == 'UPDATE_CLAN_SETUP'){

if( $id_clan < 1 ){ $msgError = '���������� ������� ID �����'; }
elseif(empty($clanInfo)){ $msgError = '���� � �������� ID �� ������.'; }
else{

$set = array();
$msgArray = array();

if($title != ''){

if(preg_match('/[^a-z�-�0-9 \-,.!`]/i', $title) != false){ $msgArray[] = '�������� ����� - ������������ ��������!'; }
else{

$set['title'] = mysql_escape_string($title);
$msgArray[] = '�������� ����� - ������� ���������.';
}

}

if($clanLink != ''){

if( preg_match('/[^a-z0-9.\/:\-]/i', $clanLink) != false){ $msgArray[] = '������ �� �������� ��������� - ������������ ��������!'; }
else{

$set['link'] = mysql_escape_string($clanLink);
$msgArray[] = '������ �� �������� ��������� - ������� ���������.';
}

}


if($clanSlogan != ''){

if( preg_match('/[^a-z�-�0-9 \-,.!]/i', $clanSlogan ) != false){ $msgArray[] = '������ - ������������ ��������!'; }
else{

$set['slogan'] = mysql_escape_string($clanSlogan);
$msgArray[] = '������ - ������� ��������.';

}

}


if($clanAdvert != ''){

if( preg_match( "/[^a-z�-�0-9 \-,.!]/i", $clanAdvert ) != false ){ $msgArray[] = '������� - ������������ ��������!'; }
else{

$set['advert'] = mysql_escape_string($clanAdvert);
$msgArray[] = '������� - ������� ���������.';
}

}


if( count($set) > 0 ){
$db->update('timeofwars_clan', $set, array( 'id_clan' => $id_clan ), 'admClan_updateClanInfo_1');
}

$msgError = implode( "\n<br>\n", $msgArray );
}

}elseif($action == 'UPLOAD_CLAN_ICON'){


if( $id_clan < 1 ){ $msgError = '���������� ������� ID �����'; }
elseif(empty($clanInfo)){ $msgError = '���� � �������� ID �� ������.'; }
elseif( empty($clanIcon) || $clanIcon['error'] != ''){ $msgError = '��������� ������ ��� ������� ������ ������. '.$clanIcon['error']; }
elseif( $clanIcon['info'][0] != $iconWidth || $clanIcon['info'][1] != $iconHeight ){ $msgError = '�������� ������� �����.'; }
elseif( $clanIcon['info'][2] != $iconType ){ $msgError = '�������� ������ �����.'; }
elseif( move_uploaded_file( $clanIcon['tmp_name'], $iconPath.'/'.$id_clan.'.'.$iconExt ) == false ){ $msgError = '�� ����� ����������� ����� ��������� ������.'; }
else{

$msgError = '������� �������� ������ ��� ����� ID: '.$id_clan;
$msgError .= ' <img src=\''.$iconWeb.'/'.$id_clan.'.'.$iconExt.'\' width=\''.$iconWidth.'\' height=\''.$iconHeight.'\'>.';

}

}elseif($action == 'UPLOAD_CLAN_ICON_BIG'){

if( $id_clan < 1 ){ $msgError = '���������� ������� ID �����'; }
elseif( empty($clanInfo) ){ $msgError = '���� � �������� ID �� ������.'; }
elseif( empty($clanIcon) || $clanIcon['error'] != "" ){ $msgError = '��������� ������ ��� ������ ������ ������. '.$clanIcon['error']; }
elseif( $clanIcon['info'][0] != $iconWidth || $clanIcon['info'][1] != $iconHeight ){ $msgError = '�������� ������� �����.'; }
elseif( $clanIcon['info'][2] != $iconType ){ $msgError = '�������� ������ �����.'; }
elseif( move_uploaded_file( $clanIcon['tmp_name'], $iconPath.'/'.$id_clan.'_big.'.$iconExt ) == false ){ $msgError = '�� ����� ����������� ����� ��������� ������.'; }
else{

$msgError = '������� �������� ������ ��� ����� ID: '.$id_clan;
$msgError .= ' <img src=\''.$iconWeb.'/'.$id_clan.'_big.'.$iconExt.'\' width=\''.$iconWidth.'\' height=\''.$iconHeight.'\'>.';

}

}elseif($action == 'UPLOAD_RANK_ICON'){

if( $id_clan < 1 ){ $msgError = '���������� ������� ID �����'; }
elseif( empty($clanInfo) ){ $msgError = '���� � �������� ID �� ������.'; }
elseif( empty($clanIcon) || $clanIcon['error'] != ''){ $msgError = '��������� ������ ��� ������ ������ ������. '.$clanIcon['error']; }
elseif( $clanIcon['info'][0] != $iconWidth || $clanIcon['info'][1] != $iconHeight ){ $msgError = '�������� ������� �����.'; }
elseif( $clanIcon['info'][2] != $iconType ){ $msgError = '�������� ������ �����.'; }
else{

if( $rankIconNum < 1 ){
for( $i=1; true; $i++ ){
if( file_exists( $iconPathRank.'/'.$id_clan.'_'.$i.'.'.$iconExt ) == false ){
$rankIconNum = $i;
break;
}
}
}


if( move_uploaded_file( $clanIcon['tmp_name'], $iconPathRank.'/'.$id_clan.'_'.$rankIconNum.'.'.$iconExt ) == false ){
$msgError = '�� ����� ����������� ����� ��������� ������.';
}else{

$msgError = '������� �������� ������ #'.$rankIconNum.' ��� ����� ID: '.$id_clan;
$msgError.= ' <img src=\''.$iconWebRank.'/'.$id_clan.'_'.$rankIconNum.'.'.$iconExt.'\' width=\''.$iconWidth.'\' height=\''.$iconHeight.'\'>.';

}
}


}

require_once('_loader.php');

$tow_tpl->assignGlobal('db_config', $db_config);

$clanInfo = array();


if( $id_clan > 0 ){

$clanInfo = ClanBase::getClanInfoFullById( $id_clan );

$clanIconFile = $iconWeb.'/'.$id_clan.'.gif';

$rankIconFiles = array();

$temp = glob($iconPathRank.'/'.$id_clan.'_*.gif');

if(!empty($temp))foreach( $temp as $rankIconFile ){

$rankIconFile = basename($rankIconFile);
list( $clan, $icon, ) = split( '[_.]', $rankIconFile );
$rankIconFiles[ $icon ] = $iconWebRank.'/'.$rankIconFile;

}

$temp = & $tow_tpl->getDisplay('content', true);

$temp->assign('clanIconFile', $clanIconFile   );
$temp->assign('rankIconFiles', $rankIconFiles );
}

$temp = & $tow_tpl->getDisplay('content', true);

$temp->assign('id_clan', $id_clan );
$temp->assign('clanInfo', $clanInfo );
$temp->assign('clanList', ClanBase::getClanList() );
$temp->assign('msgError', $msgError);



$temp->addTemplate('clans', 'timeofwars_adm_clans.html');


$show = & $tow_tpl->getDisplay('index');

$show->assign('title', 'Time Of Wars - �����');
$show->assign('Content', $temp);


$show->addTemplate('header', 'header_noframes.html');
$show->addTemplate('index' , 'index.html' );
$show->addTemplate('footer', 'footer.html');


$tow_tpl->display();
?>
