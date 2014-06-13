<?
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

session_start();

if ( empty($_SESSION['login']) )  die( include('includes/bag_log_in.php') );

header('Content-type: text/html; charset=windows-1251');

include_once ('includes/to_view.php');
include_once ('db_config.php');
include_once ('db.php');
include_once ('chat/func_chat.php');
include_once ('classes/PlayerInfo.php');

$player = new PlayerInfo();

if( $player->username != 'Admin' )
$player->is_blocked();

include_once ('classes/ChatSendMessages.php');

@$_GET['uname']    = speek_to_view($_GET['uname']);
@$_POST['PLLogin'] = speek_to_view($_POST['PLLogin']);
@$_POST['Time']    = floatval($_POST['Time']);
$as_name           = _ADM_asname;
$a_lev             = 0;
$msg               = array();

error_reporting(0);
if( (!empty($_GET['uname']) && $_GET['uname'] == 'Admin') || ( (!empty($_POST['PLLogin']) && $_POST['PLLogin'] == 'Admin') && $player->username != 'Admin')  ){ die; }

$acclev = @$db->SQL_result($db->query("SELECT access FROM ".SQL_PREFIX."access_keepers WHERE Username = '".$player->username."'"),0,0);

$acclev = split( ',', $acclev );

switch( $player->id_clan ){
case '55':  $as_name = _ADM_stazor;    break;
case '4':   $as_name = _ADM_hranitel1; break;
case '3':   $as_name = _ADM_hranitel2; break;
case '2':   $as_name = _ADM_hranitel3; break;
case '53':  $as_name = _ADM_hranitel4; break;
case '1':   $as_name = _ADM_hranitel5; break;
case '50':  $as_name = _ADM_hranitel7; break;
case '255': $as_name = _adminname;     break;
default:    $as_name = false;          break;
}

if( $player->username == 'Admin' ){ $as_name = _adminname; $acclev = Array( 'molch', 'molch_off', 'chaos', 'chaos_off', 'blok', 'blok_off', 'addclan', 'look_LD', 'addrow_ld', 'status', 'battle_off', 'brak_OnOff'); }

/*
if( $_GET['vanya'] == 'krut' )
{
	$mails = $db->queryArray( "SELECT Email FROM ".SQL_PREFIX."players;" );
	$mails1 = array();

	foreach( $mails as $mail )
	{
		$mails1[] = $mail['Email'];
		echo $mail['Email'].'<br />';
    }
	file_put_contents( $db_config[DREAM]['web_root'].'/cache/more/mails.txt',
	implode( "\r\n", $mails1 )
	 );
	 echo 'ok'; die;

}
*/
if ( $as_name === false ) { die(_adminerr); }

$chat = new ChatSendMessages($player->username, $player->ChatRoom);




if( !empty($_POST['inf']) && !empty($_POST['PLLogin']) && in_array( 'addrow_ld', $acclev ) ){
if( $_name = @$db->SQL_result($db->query("SELECT Username FROM ".SQL_PREFIX."players WHERE Username = '".$_POST['PLLogin']."'"),0) ){

$db->insert( SQL_PREFIX.'as_notes', Array( 'hranitel' => $player->username, 'Username' => $_name, 'Time' => time('void'), 'Text' => speek_to_view($_POST['inf_text']), 'Status' => 'info') );

$msg[] = sprintf(_ADM_info_text1, $_name );
} else { $msg[] = _ADM_nouser; }

}


if(!empty($_POST['shut']) && in_array( 'molch', $acclev ) ){
if(!empty($_POST['PLLogin']) && !empty($_POST['Time']) && !empty($_POST['Shut_why']) && !strstr($_POST['Time'],",")){
if( $_name = @$db->SQL_result($db->query("SELECT Username FROM ".SQL_PREFIX."players WHERE Username = '".$_POST['PLLogin']."'"),0) ){
if( !$db->numrows("SELECT Username FROM ".SQL_PREFIX."stopped WHERE Username = '$_name'") ){

$time_end = $_POST['Time']*3600 + time('void');
$_POST['Shut_why'] = speek_to_view($_POST['Shut_why']);

$db->insert( SQL_PREFIX.'stopped', Array( 'Username' => $_name, 'Time' => $time_end ) );
$db->insert( SQL_PREFIX.'as_notes', Array( 'hranitel' => $player->username, 'Username' => $_name, 'Time' => time('void'), 'On_time' => $_POST['Time'], 'Text' => $_POST['Shut_why'], 'Status' => 'shuted' ) );
$db->update( SQL_PREFIX.'online', Array( 'Stop' => 1 ), Array( 'Username' => $_name ) );

$msg[] = sprintf(_ADM_text1, $_name);

$sysmsg  = $as_name.sprintf(_ADM_text1_msg, $player->username, $_name, $_POST['Time'], $_POST['Shut_why']);

$new_msg = GetMicroTime().'>><a class="date">'.date('H:i').'</a> <font size="2"><img src="http://'.$db_config[DREAM_IMAGES][server].'/clan/'.$player->id_clan.'.gif" width="24px" height="15px"> '.$sysmsg.' </font>';
$new_msg = trim($new_msg)."\n";

$chat->writeNew( $new_msg );

} else { $msg[] = _ADM_text1_err; }
} else { $msg[] = _ADM_nouser; }
} else { $msg[] = _ADM_err; }
}



if (!empty($_POST['shut_off']) && in_array( 'molch_off', $acclev ) ){

if( empty($_POST['PLLogin']) ){ $log = $_POST['PLLogin1']; } else { $log = $_POST['PLLogin']; }

if( !empty($log) ){

if( $_name = @$db->SQL_result($db->query("SELECT Username FROM ".SQL_PREFIX."players WHERE Username = '$log'"),0) ){

$db->execQuery("DELETE FROM ".SQL_PREFIX."stopped WHERE Username = '$_name'");
$db->insert( SQL_PREFIX.'as_notes', Array( 'hranitel' => $player->username, 'Username' => $_name, 'Time' => time('void'), 'Status' => 'unshuted' ) );
$db->update( SQL_PREFIX.'online', Array( 'Stop' => 0 ), Array( 'Username' => $_name ) );

$msg[] = sprintf(_ADM_text2, $_name);

$sysmsg = $as_name.sprintf(_ADM_text2_msg, $player->username, $_name);

$new_msg = GetMicroTime().'>><a class="date">'.date('H:i').'</a> <font size="2"><img src="http://'.$db_config[DREAM_IMAGES][server].'/clan/'.$player->id_clan.'.gif" width="24px" height="15px"> '.$sysmsg.' </font>';
$new_msg = trim($new_msg)."\n";

$chat->writeNew( $new_msg );

} else { $msg[] = _ADM_nouser; }
}	else { $msg[] = _ADM_err; }

}



if (!empty($_POST['Chaos']) && in_array( 'chaos', $acclev ) ) {
if(!empty($_POST['PLLogin']) && !empty($_POST['Comment']) && !empty($_POST['Time'])){
if( $_name = @$db->SQL_result($db->query("SELECT Username FROM ".SQL_PREFIX."players WHERE Username = '".$_POST['PLLogin']."'"),0) ){
if( !$db->numrows("SELECT Username FROM ".SQL_PREFIX."chaos WHERE Username = '$_name'") ){

$_POST['Comment'] = speek_to_view($_POST['Comment']);
$time_end = $_POST['Time']*3600 + time('void');

$dat = $db->queryRow("SELECT id_clan FROM ".SQL_PREFIX."clan_user WHERE Username = '$_name'");

$db->update( SQL_PREFIX.'players', Array( 'ClanID' => 200 ), Array( 'Username' => $_name ) );
$db->insert( SQL_PREFIX.'chaos', Array( 'Username' => $_name, 'Comment' => $_POST['Comment'], 'FreeTime' => $time_end, 'wasclan' => $dat['id_clan'], 'link' => $_POST['Link'] ) );
$db->insert( SQL_PREFIX.'as_notes', Array( 'hranitel' => $player->username, 'Username' => $_name, 'Time' => time('void'), 'On_time' => $_POST['Time'], 'Text' => $_POST['Comment'], 'Status' => 'chaos', 'link' => $_POST['Link'] ) );

$query = sprintf("UPDATE ".SQL_PREFIX."clan_user cu LEFT JOIN ".SQL_PREFIX."online o USING(Username) SET cu.id_clan = '200', cu.id_rank = '0', o.ClanID = '200' WHERE cu.Username = '%s';", $_name);
$db->execQuery( $query );

$msg[] = sprintf(_ADM_text3, $_name);

$sysmsg = $as_name.sprintf(_ADM_text3_msg, $player->username, $_name, $_POST['Time'], $_POST['Comment']);

$new_msg = GetMicroTime().'>><a class="date">'.date('H:i').'</a> <font size="2"><img src="http://'.$db_config[DREAM_IMAGES][server].'/clan/'.$player->id_clan.'.gif" width="24px" height="15px"> '.$sysmsg.' </font>';
$new_msg = trim($new_msg)."\n";

$chat->writeNew( $new_msg );

} else { $msg[] = _ADM_text3_err; }
} else { $msg[] = _ADM_nouser; }
} else { $msg[] = _ADM_err; }

}


if ( !empty($_POST['dechaos']) && in_array( 'chaos_off', $acclev ) ) {

if( empty($_POST['PLLogin']) ){ $log = $_POST['PLLogin1']; } else { $log = $_POST['PLLogin']; }

if( !empty($log) ){
if( $_name = @$db->SQL_result($db->query("SELECT Username FROM ".SQL_PREFIX."players WHERE Username = '$log'"),0) ){
if($dat = $db->queryRow("SELECT wasclan FROM ".SQL_PREFIX."chaos WHERE Username = '$_name'") ){

$db->execQuery("DELETE FROM ".SQL_PREFIX."chaos WHERE Username = '$_name'");
$db->update( SQL_PREFIX.'players', Array( 'ClanID' => $dat['wasclan'] ), Array( 'Username' => $_name ) );

if($dat['wasclan']){  $db->update( SQL_PREFIX.'clan_user', Array( 'id_clan' => $dat['wasclan'] ), Array( 'Username' => $_name ) ); }
else{ $db->execQuery("DELETE FROM ".SQL_PREFIX."clan_user WHERE Username = '$_name'"); }

$db->update( SQL_PREFIX.'online', Array( 'ClanID' => $dat['wasclan'] ), Array( 'Username' => $_name ) );
$db->insert( SQL_PREFIX.'as_notes', Array( 'hranitel' => $player->username, 'Username' => $_name, 'Time' => time('void'), 'Status' => 'unchaos') );

$msg[] = sprintf(_ADM_text4, $_name);

$sysmsg = $as_name.sprintf(_ADM_text4_msg, $player->username, $_name);

$new_msg = GetMicroTime().'>><a class="date">'.date('H:i').'</a> <font size="2"><img src="http://'.$db_config[DREAM_IMAGES][server].'/clan/'.$player->id_clan.'.gif" width="24px" height="15px"> '.$sysmsg.' </font>';
$new_msg = trim($new_msg)."\n";

$chat->writeNew( $new_msg );

} else { $msg[] = 'На персонаже нет проклятия'; }
} else { $msg[] = _ADM_nouser; }
} else { $msg[] = _ADM_err; }

}



if(!empty($_POST['block']) && in_array( 'blok', $acclev ) ) {
if(!empty($_POST['PLLogin']) && !empty($_POST['Comment'])){
if( $_name = @$db->SQL_result($db->query("SELECT Username FROM ".SQL_PREFIX."players WHERE Username = '".$_POST['PLLogin']."'"),0) ){
if( !$db->numrows("SELECT Username FROM ".SQL_PREFIX."blocked WHERE Username = '$_name'") ){

$_POST['Comment'] = speek_to_view($_POST['Comment']);

$db->insert( SQL_PREFIX.'blocked', Array( 'Username' => $_name, 'Why' => $_POST['Comment'], 'link' => $_POST['Link'] ) );
$db->insert( SQL_PREFIX.'as_notes', Array( 'hranitel' => $player->username, 'Username' => $_name, 'Time' => time('void'), 'Text' => $_POST['Comment'], 'Status' => 'blok', 'link' => $_POST['Link']) );

$msg[] = sprintf(_ADM_text5, $_name);

$sysmsg = $as_name.sprintf(_ADM_text5_msg, $player->username, $_name, $_POST['Comment']);

$new_msg = GetMicroTime().'>><a class="date">'.date('H:i').'</a> <font size="2"><img src="http://'.$db_config[DREAM_IMAGES][server].'/clan/'.$player->id_clan.'.gif" width="24px" height="15px"> '.$sysmsg.' </font>';
$new_msg = trim($new_msg)."\n";

$chat->writeNew( $new_msg );

} else { $msg[] = _ADM_text5_err; }
} else { $msg[] = _ADM_nouser; }
} else { $msg[] = _ADM_err; }

}



if (!empty($_POST['deblock']) && in_array( 'blok_off', $acclev ) ) {
if(!empty($_POST['PLLogin'])){
if( $_name = @$db->SQL_result($db->query("SELECT Username FROM ".SQL_PREFIX."players WHERE Username = '".$_POST['PLLogin']."'"),0) ){

$db->execQuery("DELETE FROM ".SQL_PREFIX."blocked WHERE Username = '$_name'");
$db->insert( SQL_PREFIX.'as_notes', Array( 'hranitel' => $player->username, 'Username' => $_name, 'Time' => time('void'), 'Status' => 'deblok' ) );

$msg[] = sprintf(_ADM_text6, $_name);

$sysmsg = $as_name.sprintf(_ADM_text6_msg, $player->username, $_name);

$new_msg = GetMicroTime().'>><a class="date">'.date('H:i').'</a> <font size="2"><img src="http://'.$db_config[DREAM_IMAGES][server].'/clan/'.$player->id_clan.'.gif" width="24px" height="15px"> '.$sysmsg.' </font>';
$new_msg = trim($new_msg)."\n";

$chat->writeNew( $new_msg );

} else { $msg[] = _ADM_nouser; }
} else { $msg[] = _ADM_err; }

}



if( !empty($_POST['BID']) && in_array( 'battle_off', $acclev ) ) {
if( !empty($_POST['BID']) && is_numeric($_POST['BID']) ){

@$_POST['BID'] = intval($_POST['BID']);

$dat = $db->queryArray("SELECT * FROM ".SQL_PREFIX."battle_list WHERE Id = '{$_POST['BID']}'");

if(!empty($dat)):

foreach($dat as $v):
$db->update( SQL_PREFIX.'players', Array( 'BattleId' => NULL ), Array( 'Username' => $v['Player'] ) );
endforeach;

endif;

$db->insert( SQL_PREFIX.'as_notes', Array( 'hranitel' => $player->username, 'Username' => $_POST['BID'], 'Time' => time('void'), 'Status' => 'defight' ) );

$sysmsg = $as_name.sprintf(_ADM_text7_msg, $player->username, $_POST['BID']);

$new_msg = GetMicroTime().'>><a class="date">'.date('H:i').'</a> <font size="2"><img src="http://'.$db_config[DREAM_IMAGES][server].'/clan/'.$player->id_clan.'.gif" width="24px" height="15px"> '.$sysmsg.' </font>';
$new_msg = trim($new_msg)."\n";

$chat->writeNew( $new_msg );

$msg[] = 'бой '.$_POST['BID'].' успешно завершен';

} else { $msg[] = _ADM_err; }

}



if (!empty($_POST['PLLogin']) && !empty($_POST['newstatus']) && in_array( 'status', $acclev ) ) {
if( $_name = @$db->SQL_result($db->query("SELECT Username FROM ".SQL_PREFIX."players WHERE Username = '".$_POST['PLLogin']."'"),0) ){

if (preg_match ('/script/i', $_POST['NewS'])) {
$_POST['NewS'] = eregi_replace('script', _ADM_badteg, $_POST['NewS']);
$_POST['NewS'] = eregi_replace('<', _ADM_badteg, $_POST['NewS']);
$_POST['NewS'] = eregi_replace('>', _ADM_badteg, $_POST['NewS']);
}

if ( $player->id_clan != '4' && $player->id_clan != '55' && $player->id_clan != '3' ){
$db->update( SQL_PREFIX.'players', Array( 'ClanRank' => $_POST['NewS'] ), Array( 'Username' => $_name ) );
$db->insert( SQL_PREFIX.'as_notes', Array( 'hranitel' => $player->username, 'Username' => $_name, 'Time' => time('void'), 'Text' => $_POST['NewS'], 'Status' => 'status' ) );
} else {
$_POST['NewS'] = htmlspecialchars($_POST['NewS']);
$db->update( SQL_PREFIX.'players', Array( 'ClanRank' => $_POST['NewS'] ), Array( 'Username' => $_name ) );
$db->insert( SQL_PREFIX.'as_notes', Array( 'hranitel' => $player->username, 'Username' => $_name, 'Time' => time('void'), 'Text' => $_POST['NewS'], 'Status' => 'status' ) );
}

$msg[] = 'Персонажу '.$_name.' назначен новый статус';

} else { $msg[] = _ADM_nouser; }
}



if (!empty($_POST['PLLogin']) && !empty($_POST['socnewstatus']) && in_array( 'brak_OnOff', $acclev ) ) {
if( $_name = @$db->SQL_result($db->query("SELECT Username FROM ".SQL_PREFIX."players WHERE Username = '".$_POST['PLLogin']."'"),0) ){

if (preg_match ('/script/i', $_POST['NewSS'])) {
$_POST['NewSS'] = eregi_replace('script', _ADM_badteg, $_POST['NewSS']);
$_POST['NewSS'] = eregi_replace('<', _ADM_badteg, $_POST['NewSS']);
$_POST['NewSS'] = eregi_replace('>', _ADM_badteg, $_POST['NewSS']);
}

$_POST['NewSS'] = speek_to_view($_POST['NewSS']);

if( $_POST['NewSS'] == '' )
{
	if ( $db->queryRow("SELECT * FROM ".SQL_PREFIX."as_notes WHERE Username = '$_name' AND Status = 'brak'") ) {
	$db->execQuery( "DELETE FROM ".SQL_PREFIX."as_notes WHERE Username = '".$_name."' AND Status = 'brak';" );
	$msg[] = 'Персонаж '.$_name.' теперь разведен.';
	}else{
	$msg[] = 'У персонажа '.$_name.' нет супруга.';
	}

} else {
if( !$db->queryRow("SELECT Username FROM ".SQL_PREFIX."players WHERE Username = '".$_POST['NewSS']."'") ){
$msg[] = _ADM_nouser;
} else {
if ( $db->queryRow("SELECT * FROM ".SQL_PREFIX."as_notes WHERE Username = '$_name' AND Status = 'brak'") ) {
$db->update( SQL_PREFIX.'as_notes', Array( 'hranitel' => $player->username, 'Username' => $_name, 'Time' => time('void'), 'Text' => $_POST['NewSS'], 'Status' => 'brak' ), Array( 'Username' => $_name, 'Status' => 'brak' ) );
}
else {
$db->insert( SQL_PREFIX.'as_notes', Array( 'hranitel' => $player->username, 'Username' => $_name, 'Time' => time('void'), 'Text' => $_POST['NewSS'], 'Status' => 'brak' ) );
}

$msg[] = 'Персонажу '.$_name.' назначен новый супруг '.$_POST['NewSS'].' :)';

}

}


} else { $msg[] = _ADM_nouser; }
}


if ( !empty($_POST['IDchange']) && ( $player->username == 'Admin') ) {
if (is_numeric($_POST['NewID'])) {
if( $_name = @$db->SQL_result($db->query("SELECT Username FROM ".SQL_PREFIX."players WHERE Username = '".$_POST['PLLogin']."'"),0) ){

if($_POST['NewID'] == 0){
$db->execQuery("DELETE FROM ".SQL_PREFIX."clan_user WHERE Username = '$_name'");
}
elseif(!$db->queryCheck("SELECT * FROM ".SQL_PREFIX."clan_user WHERE Username = '$_name'") ){
$db->insert( SQL_PREFIX.'clan_user', Array( 'id_clan' => intval($_POST['NewID']), 'Username' => $_name ) );
}
else{
$db->update( SQL_PREFIX.'clan_user', Array( 'id_clan' => intval($_POST['NewID']) ), Array( 'Username' => $_name ) );
}

$db->update( SQL_PREFIX.'players', Array( 'ClanID' => intval($_POST['NewID']) ), Array( 'Username' => $_name ) );
$db->update( SQL_PREFIX.'online', Array( 'ClanID' => intval($_POST['NewID']) ), Array( 'Username' => $_name ) );
$db->insert( SQL_PREFIX.'as_notes', Array( 'hranitel' => $player->username, 'Username' => $_name, 'Time' => time('void'), 'Text' => 'klan', 'Status' => intval($_POST['NewID']) ) );

$sysmsg  = $as_name.sprintf(_ADM_text8_msg, $player->username, $_name);

$new_msg = GetMicroTime().'>><a class="date">'.date('H:i').'</a> <font size="2"><img src="http://'.$db_config[DREAM_IMAGES][server].'/clan/'.$player->id_clan.'.gif" width="24px" height="15px"> '.$sysmsg.' </font>';
$new_msg = trim($new_msg)."\n";

$chat->writeNew( $new_msg );

$msg[] = 'Персонажу '.$_name.' назначен новый клан '.$_POST['NewID'];

} else { $msg[] =_ADM_nouser; }
}
}



if ( !empty($_POST['Banned']) && ( $player->username == 'Admin') && !empty($_POST['PLIp']) ) {

@$_POST['PLIp'] = speek_to_view($_POST['PLIp']);

$db->insert( SQL_PREFIX.'banned', Array( 'Ip' => $_POST['PLIp'] ) );

$sysmsg  = $as_name.sprintf(_ADM_text9_msg, $player->username, $_POST['PLIp']);

$new_msg = GetMicroTime().'>><a class="date">'.date('H:i').'</a> <font size="2"><img src="http://'.$db_config[DREAM_IMAGES][server].'/clan/'.$player->id_clan.'.gif" width="24px" height="15px"> '.$sysmsg.' </font>';
$new_msg = trim($new_msg)."\n";

$chat->writeNew( $new_msg );

$msg[] = $_POST['PLIp'].' успешно добавлен в список.';

}


if( !empty($_POST['banip_off']) && ($player->username == 'Admin') ){

if( !empty($_POST['ip']) ){
foreach( $_POST['ip'] as $v ){

if( $ip = @$db->SQL_result($db->query("SELECT Ip FROM ".SQL_PREFIX."banned WHERE id = '$v';"),0) ){
$db->execQuery("DELETE FROM ".SQL_PREFIX."banned WHERE id = '$v';");
$msg[] = 'IP: '.$ip.' успешно удален из списка.';
}

}

}


}

if (!empty($_POST['PLLogin']) && !empty($_POST['PLPasswd']) && ( $player->username == 'Admin' ) && $_POST['PLLogin'] != 'Admin') {
if( $_name = @$db->SQL_result($db->query("SELECT Username FROM ".SQL_PREFIX."players WHERE Username = '".$_POST['PLLogin']."'"),0) ){
$db->update( SQL_PREFIX.'players', Array( 'Password' => $_POST['PLPasswd'] ), Array( 'Username' => $_name ) );
$msg[] = 'Успешно изменен пароль Персонажа '.$_name;
session_destroy($_name);
} else { $msg[] = _ADM_nouser; }
}


if ( !empty($_POST['userjob']) && !empty($_POST['PLLogin']) && in_array( 'addclan', $acclev ) ) {

if( $_name = @$db->SQL_result($db->query("SELECT `Username` FROM `".SQL_PREFIX."players` WHERE `Username` = '".speek_to_view($_POST['PLLogin'])."'"),0) ){

@$_POST['clan']    = intval($_POST['clan']);

if ($_name != '' && ($_POST['clan'] == 4 || $_POST['clan'] == 3 || $_POST['clan'] == 2 || $_POST['clan'] == 0 || $_POST['clan'] == 55)){

$u_clan = @$db->SQL_result($db->query("SELECT ClanID FROM ".SQL_PREFIX."players WHERE Username = '$_name'"),0);

if ( ($u_clan == 0 || $u_clan == '') || $u_clan == 55 || $u_clan == 4 || $u_clan == 3 || $u_clan == 2){

if ($_POST['clan'] == 55){$namest = _ADM_text11_clan1; }
if ($_POST['clan'] == 4){ $namest = _ADM_text11_clan2; }
if ($_POST['clan'] == 3){ $namest = _ADM_text11_clan3; }
if ($_POST['clan'] == 2){ $namest = _ADM_text11_clan4; }
if ($_POST['clan'] == 0){ $namest = _ADM_text11_clan5; }

if($_POST['clan'] == 0)
{
$db->execQuery("DELETE FROM ".SQL_PREFIX."clan_user WHERE Username = '$_name'");
$db->execQuery("DELETE FROM ".SQL_PREFIX."access_keepers WHERE Username = '$_name'");
}
else
{
$db->execQuery("INSERT INTO ".SQL_PREFIX."clan_user (id_clan, Username, admin, id_rank) VALUES ('".$_POST['clan']."', '$_name', '0', '0') ON DUPLICATE KEY UPDATE id_clan = '".$_POST['clan']."'");
}

$db->update( SQL_PREFIX.'players', Array( 'ClanID' => $_POST['clan'] ), Array( 'Username' => $_name ) );
$db->update( SQL_PREFIX.'online', Array( 'ClanID' => $_POST['clan'] ), Array( 'Username' => $_name ) );
$db->insert( SQL_PREFIX.'as_notes', Array( 'hranitel' => $player->username, 'Username' => $_name, 'Time' => time('void'), 'Text' => 'klan', 'Status' => $_POST['clan'] ) );

$row = '';

if( !empty($_POST['access']) && $_POST['clan'] != '0' ){
foreach( $_POST['access'] as $acc ){
$row .= $acc.',';
}

$db->execQuery("INSERT INTO `".SQL_PREFIX."access_keepers` (`Username`, `access`) VALUES ('$_name', '$row') ON DUPLICATE KEY UPDATE `access` = '$row'");

}

$msg[] = _ADM_text11;

$sysmsg = $as_name.sprintf(_ADM_text11_msg, $player->username, $_name).$namest;

$new_msg = GetMicroTime().'>><a class="date">'.date('H:i').'</a> <font size="2"><img src="http://'.$db_config[DREAM_IMAGES][server].'/clan/'.$player->id_clan.'.gif" width="24px" height="15px"> '.$sysmsg.' </font>';
$new_msg = trim($new_msg)."\n";

$chat->writeNew( $new_msg );

} else { $msg[] = _ADM_text11_err; }
} else { $msg[] = _ADM_nouser; }

}

}


if( !empty($_POST['adm_pict_submit']) && !empty($_POST['pict']) && $player->id_clan == 255 ){
foreach($_POST['pict'] as $old_id){

if( !$dat = $db->queryRow("SELECT Id, Author, date, price, otdel, zamok FROM ".SQL_PREFIX."pict_unreg WHERE Id = '".$old_id."'") )
{
	die;
}

if( !empty($db_config[101]['server']) )
{
$connect = ftp_connect( $db_config[101]['server'] );
$log_res = ftp_login( $connect, $db_config[101]['user'], $db_config[101]['pass'] );

if( empty($connect) || empty($log_res) )
{
	die('ошибка закачки на сервер');
}


$id = mt_rand( 0, 999999 ) . '_' . rand( 0, 999999 ) . '_' . rand( 0, 99999 );

$to     = $db_config[100]['web_root'] . SEPARATOR . 'pict' .  SEPARATOR . 'zamok' . SEPARATOR . $id . '.gif';
$from   = $db_config[100]['web_root'] . SEPARATOR . 'pict' . SEPARATOR . $dat['Id'] . '.gif';

if( !ftp_rename($connect, $from, $to) )
{
	die('ошибка');
}

ftp_delete($connect, $db_config[100]['web_root'] . SEPARATOR . 'pict' . SEPARATOR . $dat['Id'] . '.gif');
ftp_close($connect);
}
else
{
copy( $db_config[DREAM_IMAGES]['web_root'] . SEPARATOR . 'pict' . SEPARATOR . $dat['Id'] . '.gif', $db_config[DREAM_IMAGES]['web_root'] . SEPARATOR . 'pict' .  SEPARATOR . 'zamok' . SEPARATOR . $id . '.gif' );
unlink( $db_config[DREAM_IMAGES]['web_root']. SEPARATOR . 'pict' . SEPARATOR . $dat['Id'].'.gif' );
}


$db->insert( SQL_PREFIX.'pict_'.$dat['zamok'],
Array(
'Id'     => $id,
'Author' => $dat['Author'],
'date'   => $dat['date'],
'price'  => intval($dat['price']),
'otdel'  => $dat['otdel']
)
);

$db->execQuery("DELETE FROM ".SQL_PREFIX."pict_unreg WHERE Id = '".$dat['Id']."'");

$msg[1] = 'Образ(ы) добавлен(ы)';

}

}

if( !empty($_POST['adm_pictfl_submit']) && !empty($_POST['pict_fl']) && $player->id_clan == 255 ){

foreach($_POST['pict_fl'] as $old_id){

if( !$dat = $db->queryRow("SELECT * FROM ".SQL_PREFIX."things_presentshop_view WHERE id = '".$old_id."'") )
{
	die;
}

if( !empty($db_config[101]['server']) )
{
$connect = ftp_connect( $db_config[101]['server'] );
$log_res = ftp_login( $connect, $db_config[101]['user'], $db_config[101]['pass'] );

if( empty($connect) || empty($log_res) )
{
	die('ошибка закачки на сервер');
}


$id   = 'zamok_reg' . SEPARATOR . mt_rand( 0, 999999 ) . '_' . rand( 0, 999999 ) . '_' . rand( 0, 99999 );
$to   = $db_config[100]['web_root'] . SEPARATOR . 'gifts' . SEPARATOR . $id . '.gif';
$from = $db_config[100]['web_root'] . SEPARATOR . 'gifts' . SEPARATOR . $dat['presentIMG'] . '.gif';
if( !ftp_rename($connect, $from , $to) )
{
	die('ошибка');
}

ftp_delete($connect, $db_config[100]['web_root'] . SEPARATOR . 'gifts' . SEPARATOR . $dat['presentIMG'] . '.gif');
ftp_close($connect);
}
else
{
copy( $db_config[DREAM_IMAGES]['web_root'] . SEPARATOR . 'gifts' . SEPARATOR . $dat['presentIMG'] . '.gif', $db_config[DREAM_IMAGES]['web_root'] . SEPARATOR . 'gifts' .  SEPARATOR . $id . '.gif' );
unlink( $db_config[DREAM_IMAGES]['web_root']. SEPARATOR . 'gifts' . SEPARATOR . $dat['presentIMG'].'.gif' );
}


$db->insert( SQL_PREFIX.'things_presentshop_zamok_'.$dat['zamok_number'],
Array(
'presentNAME'  => $dat['presentNAME'],
'presentIMG'   => $id,
'presentPRICE' => $dat['presentPRICE'],
'presentCOUNT' => 50
)
);



$db->execQuery("DELETE FROM ".SQL_PREFIX."things_presentshop_view WHERE id = '".$dat['id']."'");

$msg[1] = 'Подарки добавлены';

}

}



if( !empty($_POST['adm_pict_del']) && !empty($_POST['pict']) && $player->id_clan == 255 ){

foreach($_POST['pict'] as $old_id){

if( !$dat = $db->queryRow("SELECT Id, Author, date, price, otdel, zamok FROM ".SQL_PREFIX."pict_unreg WHERE Id = '".$old_id."'") )
{
	die;
}


if( !empty($db_config[101]['server']) )
{
$connect = ftp_connect( $db_config[101]['server'] );
$log_res = ftp_login( $connect, $db_config[101]['user'], $db_config[101]['pass'] );

if( empty($connect) || empty($log_res) )
{
	die('ошибка закачки на сервер');
}

ftp_delete($connect, $db_config[100]['web_root'] . SEPARATOR . 'pict' . SEPARATOR . $dat['Id'] . '.gif');
ftp_close($connect);
}
else
{
unlink( $db_config[DREAM_IMAGES]['web_root']. SEPARATOR . 'pict' . SEPARATOR . $dat['Id'].'.gif' );
}


$db->execQuery("DELETE FROM ".SQL_PREFIX."pict_unreg WHERE Id = '".$dat['Id']."'");

$msg[1] = 'Образ(ы) удален(ы)';

}

}

if( !empty($_POST['adm_pictfl_del']) && !empty($_POST['pict_fl']) ){

foreach($_POST['pict_fl'] as $old_id){

if( !$dat = $db->queryRow("SELECT * FROM ".SQL_PREFIX."things_presentshop_view WHERE id = '".$old_id."'") )
{
	die;
}


if( !empty($db_config[101]['server']) )
{
$connect = ftp_connect( $db_config[101]['server'] );
$log_res = ftp_login( $connect, $db_config[101]['user'], $db_config[101]['pass'] );

if( empty($connect) || empty($log_res) )
{
	die('ошибка закачки на сервер');
}

ftp_delete($connect, $db_config[100]['web_root'] . SEPARATOR . 'gifts' . SEPARATOR . $dat['presentIMG'] . '.gif');
ftp_close($connect);
}
else
{
unlink( $db_config[DREAM_IMAGES]['web_root']. SEPARATOR . 'gifts' . SEPARATOR . $dat['presentIMG'].'.gif' );
}


$db->execQuery("DELETE FROM ".SQL_PREFIX."things_presentshop_view WHERE id = '".$dat['id']."'");

$msg[1] = 'Подарки удалены';

}

}

include_once ('includes/adm/some_funcs.php');


if( !empty($_GET['ref_off']) && is_numeric($_GET['ref_off']) && $_GET['ref_off'] > 0  && $player->id_clan == 255 )
{
	if( !$dat = $db->queryRow( "SELECT aref.id, aref.from_userid, aref.referal_id, p.Username  FROM ".SQL_PREFIX."admin_referal as aref INNER JOIN ".SQL_PREFIX."players as p ON ( p.Id = aref.from_userid ) WHERE aref.id = '".intval($_GET['ref_off'])."';" ) )
	{
		echo 'Не найдено';
    }
    else
    {
    	$user = $db->queryRow( "SELECT Username, Level, ClanID FROM ".SQL_PREFIX."players WHERE Id = '".$dat['referal_id']."';" );
    	$db->insert( SQL_PREFIX.'admin_referal_log', Array( 'add_time' => time(), 'refer_id' => $dat['from_userid'], 'referal_id' => $dat['referal_id'], 'value' => 'bad' ) );
    	$db->execQuery( "UPDATE ".SQL_PREFIX."referal as ref INNER JOIN ".SQL_PREFIX."admin_referal as aref ON ( aref.from_userid = ref.refer_id ) SET ref.status = 'bad' WHERE ref.login = '".$user['Username']."' AND aref.id = '".$dat['id']."';" );
        $db->insert( SQL_PREFIX.'messages', Array( 'Username' => $dat['Username'], 'Text' => 'Ваше дело по поводу реферала '.slogin($user['Username'], $user['Level'], $user['ClanID']).' отправлено Хранителям.' ) );

        $db->execQuery( "DELETE FROM ".SQL_PREFIX."admin_referal WHERE id = '".$dat['id']."';" );
        echo 'отправлено на полный досмотр';
    }
   die;

}



if( !empty($_GET['ref_ok']) && is_numeric($_GET['ref_ok']) && $_GET['ref_ok'] > 0 && $player->id_clan == 255 )
{
	if( !$dat = $db->queryRow( "SELECT aref.id, aref.from_userid, aref.referal_id, p.Username  FROM ".SQL_PREFIX."admin_referal as aref INNER JOIN ".SQL_PREFIX."players as p ON ( p.Id = aref.from_userid ) WHERE aref.id = '".intval($_GET['ref_ok'])."';" ) )
	{
		echo 'Не найдено';
    }
    else
    {
    	$user = $db->queryRow( "SELECT Username, Level, ClanID FROM ".SQL_PREFIX."players WHERE Id = '".$dat['referal_id']."';" );
    	if( $user['Level'] >= 10 ) $money = $user['Level'] * 0.1; else $money = 0;

    	$db->insert( SQL_PREFIX.'messages', Array( 'Username' => $dat['Username'], 'Text' => 'Вы получили '.$money.' Euro с вашего реферала '.slogin($user['Username'], $user['Level'], $user['ClanID']) ) );
    	if( !empty($money) )
    	{
    		$query = sprintf("INSERT INTO ".SQL_PREFIX."bank_acc ( Username, Euro ) VALUES ( '%s', '%.2f' ) ON DUPLICATE KEY UPDATE Euro = Euro + '%.2f';", $dat['Username'], $money, $money );
    		$db->execQuery($query, "modifyEuroByUsername_1 ");
    	}

    	$db->insert( SQL_PREFIX.'admin_referal_log', Array( 'add_time' => time(), 'refer_id' => $dat['from_userid'], 'referal_id' => $dat['referal_id'], 'money' => $money, 'value' => 'good' ) );
    	$db->execQuery( "UPDATE ".SQL_PREFIX."referal as ref INNER JOIN ".SQL_PREFIX."admin_referal as aref ON ( aref.from_userid = ref.refer_id ) SET ref.status = 'good' WHERE ref.login = '".$user['Username']."' AND aref.id = '".$dat['id']."';" );

        $db->execQuery( "DELETE FROM ".SQL_PREFIX."admin_referal WHERE id = '".$dat['id']."';" );
        echo '<b>выплачено '.$money.' Euro.</b>';
    }
   die;

}



include('_loader.php');

$tow_tpl->assignGlobal('db_config', $db_config);

$temp =& $tow_tpl->getDisplay('content', true);

$temp->assign( 'msg', implode( "\n<br />\n", $msg ) );


if( in_array( 'molch_off', $acclev ) )
{
   $b = $db->queryArray('SELECT * FROM '.SQL_PREFIX.'stopped ORDER BY Username');
   $temp->assign( 'b',      $b                );
}


if( in_array( 'chaos_off', $acclev) )
{
	$d = $db->queryArray('SELECT * FROM '.SQL_PREFIX.'chaos ORDER BY Username');
	$temp->assign( 'd',      $d                );
}


if( $player->id_clan == 255 ||  $player->username == 'Admin' )
{
	$c = $db->queryArray('SELECT * FROM '.SQL_PREFIX.'banned ORDER BY id');
	$e = $db->queryArray('SELECT id_clan, title FROM '.SQL_PREFIX.'clan ORDER BY type DESC, title, id_clan');
	$ref = $db->queryArray(
	"SELECT p.Username, p.Level, p.ClanID, fr.Username as from_user, fr.Level as from_user_lvl, fr.ClanID as from_user_clanid, ref.add_time, ref.id, r.un FROM ".SQL_PREFIX."admin_referal as ref
	INNER JOIN ".SQL_PREFIX."players as p ON ( p.Id = ref.referal_id ), ".SQL_PREFIX."players as fr, ".SQL_PREFIX."referal as r WHERE fr.Id = ref.from_userid AND fr.id = r.refer_id AND p.Username = r.login
	" );
	$z = $db->queryArray('SELECT Id, date, price, otdel FROM '.SQL_PREFIX.'pict_unreg ORDER BY date');
	$f = $db->queryArray('SELECT * FROM '.SQL_PREFIX.'things_presentshop_view ORDER BY presentDATEPOST');
	$temp->assign( 'c',      $c                );
	$temp->assign( 'e',      $e                );
	$temp->assign( 'ref',    $ref              );
	$temp->assign( 'z',      $z                );
	$temp->assign( 'f',      $f                );
}



$temp->assign( 'acclev', $acclev           );
$temp->assign( 'user',   $player->username );
$temp->assign( 'level',  $player->Level    );
$temp->assign( 'align',  $player->Align    );
$temp->assign( 'clanid', $player->id_clan   );



$temp->addTemplate('adm', 'timeofwars_func_adm.html');

$show =& $tow_tpl->getDisplay('index');


$show->assign('title', 'Time Of Wars - панель администратора');
$show->assign('Content', $temp);


$show->addTemplate('header', 'header_noframes.html');
$show->addTemplate('index' , 'index.html' );
$show->addTemplate('footer', 'footer.html');


$tow_tpl->display();
?>
