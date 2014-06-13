<?
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

session_start();
if (empty($_SESSION['login'])) { include_once('includes/bag_log_in.php'); exit; }

include_once ('includes/to_view.php');
include_once ('db_config.php');
include_once ('db.php');


$str = '';
$err = '';
$ta1 = '';
$ta2 = '';
$data = false;
$player_in_demand = 0;

$type = isset($_GET['type']) ? $_GET['type'] : ( isset($_GET['type']) ? $_GET['type'] : $_SESSION['type'] );
$_SESSION['type'] = $type;

$all = !isset($_GET['all']) && !isset($_SESSION['all']) ? 0 : (isset($_GET['all']) ? $_GET['all'] : ( isset($_GET['all']) ? $_GET['all'] : $_SESSION['all'] ));
$_SESSION['all'] = $all;

$r_rate = !isset($_GET['r_rate']) && !isset($_SESSION['r_rate']) ? 2 : (isset($_GET['r_rate']) ? $_GET['r_rate'] : ( isset($_GET['r_rate']) ? $_GET['r_rate'] : $_SESSION['r_rate'] ));
$_SESSION['r_rate'] = $r_rate;

include_once ('classes/PlayerInfo.php');

$player = new PlayerInfo();

$player->is_blocked();
$player->checkBattle();
$player->checkRoom('main');

$player->heal();
$item   = $player->getItemsInfo( $player->username );

include_once ('chat/func_chat.php');

$co2 = $db->queryRow("SELECT * FROM ".SQL_PREFIX."demands WHERE Name_pr = '$player->username'");
$co1 = $db->queryRow("SELECT * FROM ".SQL_PREFIX."demands WHERE Username = '$player->username'");


//тестовые
$my_zayava = $db->queryRow( "SELECT dm.id, dm.opponent_id, opp.Username, opp.Level, opp.Align, opp.ClanID FROM ".SQL_PREFIX."demands_2b as dm INNER JOIN ".SQL_PREFIX."players as p ON( dm.creator_id = p.Id ) LEFT OUTER JOIN ".SQL_PREFIX."players as opp ON( opp.Id = dm.opponent_id ) WHERE dm.creator_id = '".$player->user_id."' AND dm.status = 'wait'" );
$ya_opponent = @$db->SQL_result($db->query( "SELECT id FROM ".SQL_PREFIX."demands_2b WHERE opponent_id = '".$player->user_id."';" ));




if ($co1 || $co2){ $player_in_demand = 1; }

if( $mgd = $db->queryRow("SELECT * FROM ".SQL_PREFIX."group_demands WHERE (Team1 LIKE '%$player->username%') OR (Team2 LIKE '%$player->username%')") ){  $player_in_demand = 1; }

//новая заявка
if (!empty($_POST['demand_make'])) {

if( !empty($player_in_demand) || !empty($my_zayava) || !empty($ya_opponent) ) { $err = 'Вы уже подали/приняли заявку'; }
elseif( $player->HPnow < $player->HPall/2) { $err = "В таком состоянии не стоит лезть в бой"; }
elseif( $db->queryCheck("SELECT * FROM ".SQL_PREFIX."demands WHERE Username = '$player->username'") ){ $err = 'Заявка уже добавлена'; }
elseif( !empty($_POST['Timeout']) && $_POST['Timeout'] > 10) { $err = 'Таймаут не может быть больне 10 минут!'; }
elseif( !empty($_POST['Timeout']) && $_POST['Timeout'] < 1) { $err = 'Таймаут не может быть меньше 1 минуты!'; }
elseif( $_POST['Btype'] == 3 && ($item['Slot'][0] != 'empt0' || $item['Slot'][1] != 'empt1' || $item['Slot'][2] != 'empt2' || $item['Slot'][3] != 'empt3' || $item['Slot'][4] != 'empt4' || $item['Slot'][5] != 'empt5' || $item['Slot'][6] != 'empt6' || $item['Slot'][7] != 'empt7' || $item['Slot'][8] != 'empt8' || $item['Slot'][9] != 'empt9' || $item['Slot'][10] != 'empt10') ){ $err = 'Бой <b>кулачный</b>. Нельзя влезть в него одетым'; }
else{

$_POST['Comment'] = speek_to_view($_POST['Comment']);
$_POST['Comment'] = str_replace('<', '&lt', $_POST['Comment']);
$_POST['Comment'] = str_replace('>', '&gt', $_POST['Comment']);

if($_POST['Comment'] == 'комментарий к бою'){ $_POST['Comment'] = ''; }

$db->insert( SQL_PREFIX.'demands',
Array(
'Username' => $player->username,
'Add_time' => 'CURTIME()',
'Type' => intval($_POST['Btype']),
'Timeout' => ($_POST['Timeout']*60),
'Comment' => $_POST['Comment']
)
);

$err = 'Заявка добавлена';

}

}


//принимаем
if (!empty($_POST['pr']) && !empty($_POST['gocombat'])) {

if ( (!empty($player_in_demand) && $player_in_demand == 1) || !empty($my_zayava) || !empty($ya_opponent) ) { $err = 'Для начала отзовите свою заявку'; }
elseif( $player->HPnow < $player->HPall/2 ) { $err = 'В таком состоянии не стоит лезть в бой'; }
elseif( !list($npr, $uname, $Type) = $db->queryCheck("SELECT Name_pr, Username, Type FROM ".SQL_PREFIX."demands WHERE Username = '".speek_to_view($_POST['gocombat'])."'") ){  $err = 'Заявка отозвана, либо ее принял кто-то другой'; }
elseif( !empty($npr) || $_POST['gocombat'] == $player->username ){ $err = 'Заявка отозвана, либо ее принял кто-то другой'; }
elseif( $Type == 3 && ($item['Slot'][0] != 'empt0' || $item['Slot'][1] != 'empt1' || $item['Slot'][2] != 'empt2' || $item['Slot'][3] != 'empt3' || $item['Slot'][4] != 'empt4' || $item['Slot'][5] != 'empt5' || $item['Slot'][6] != 'empt6' || $item['Slot'][7] != 'empt7' || $item['Slot'][8] != 'empt8' || $item['Slot'][9] != 'empt9' || $item['Slot'][10] != 'empt10') ){ $err = 'Бой <b>кулачный</b>. Нельзя влезть в него одетым'; }
else {

$db->update( SQL_PREFIX.'demands', Array( 'Name_pr' => $player->username ), Array( 'Username' => $uname ) );

$txt = '<font color=red>Внимание!</font> '.$player->username.' принял ваш вызов к поединку.';
$db->insert( SQL_PREFIX.'messages', Array( 'Username' => $uname, 'Text' => $txt ) );

}

}


//убить заявку
if (!empty($_POST['demand_kill'])) {
if($co1){ $db->execQuery("DELETE FROM ".SQL_PREFIX."demands WHERE Username = '$player->username'"); $player_in_demand = 0; }
}

//убиваем принятую заявку
if (!empty($_POST['close'])) {
if($co2){
$db->update( SQL_PREFIX.'demands', Array( 'Name_pr' => 'NULL' ), Array( 'Name_pr' => $player->username ) );
$player_in_demand = 0;
}
}

//отказалсо
if (!empty($_POST['no_battle'])) {

if($co1){
$txt = '<font color=red>Внимание!</font> '.$player->username.' отказал вам в поединке.';
$db->insert( SQL_PREFIX.'messages', Array( 'Username' => $col['Name_pr'], 'Text' => $txt ) );
$db->update( SQL_PREFIX.'demands', Array( 'Name_pr' => 'NULL' ), Array( 'Username' => $player->username ) );
$player_in_demand = 0;
}

}

//идем бица
if (!empty($_POST['battle'])) {

if (!$co1 || !$co1['Name_pr']) { $err = 'Вы не можете начать бой'; }
else {

$battle_id = $db->SQL_result($db->query('SELECT Id FROM '.SQL_PREFIX.'battle_id'));

$db->update( SQL_PREFIX.'demands', Array( 'In_battle' => '1' ), Array( 'Username' => $player->username ) );
$db->update( SQL_PREFIX.'players', Array( 'BattleID' => $battle_id ), Array( 'Username' => $co1['Name_pr'] ) );
$db->update( SQL_PREFIX.'players', Array( 'BattleID' => $battle_id ), Array( 'Username' => $player->username ) );
$db->update( SQL_PREFIX.'battle_id', Array( 'Id' => '[+]1' ), Array( 'Id' => $battle_id ), 'maths' );

$txt = '<font color="red">Внимание!</font> Ваш бой начался. <a style="cursor:hand" onclick="top.frames[\'TOP\'].location.href=\'../demands.php\'">Обновите страницу</a>, если это понадобится.';
$db->insert( SQL_PREFIX.'messages', Array( 'Username' => $co1['Name_pr'], 'Text' => $txt ) );
$db->insert( SQL_PREFIX.'messages', Array( 'Username' => $player->username, 'Text' => $txt ) );

@header ('location: battle.php');
exit;

}


}


$res = $db->queryArray('SELECT * FROM '.SQL_PREFIX.'group_demands');

if(!empty($res)){
foreach($res as $dat){

$tp1 = split (';', $dat['Team1']);
$tp2 = split (';', $dat['Team2']);

foreach($tp1 as $v) { if ($v == $player->username) { $in_group = 1; } if ($v == $_POST['go_group_combat']) { $conf_team1 = $dat['Team1']; } }
foreach($tp2 as $v) { if ($v == $player->username) { $in_group = 2; } }

if (!empty($in_group)) { $my_group_demand_team1 = $dat['Team1']; }

}
}

$team1_num = 0;
$team2_num = 0;

if ($mgd) {
$data = $db->queryRow("SELECT * FROM ".SQL_PREFIX."group_demands WHERE Team1 = '{$mgd['Team1']}'");

$tp1 = split (';', $data['Team1']);
$tp2 = split (';', $data['Team2']);

foreach ($tp1 as $v) { if ($v != '') { $team1_num++; } }
foreach ($tp2 as $v) { if ($v != '') { $team2_num++; } }

$left = $data['Start_time'] - time ('void');

if ($left <= 0 && $data['Team2'] == '') {
$db->execQuery("DELETE FROM ".SQL_PREFIX."group_demands WHERE Team1 = '{$data['Team1']}'");
@header ('location: demands.php?type=3');
exit;
}


if ( ($team1_num >= $data['Team1_num'] && $team2_num >= $data['Team2_num']) || ($left <= 0 && $data['Team2']) ) {

list($battle_id) = $db->queryCheck('SELECT Id FROM '.SQL_PREFIX.'battle_id');

foreach ($tp1 as $v) { if ($v != '') {  $db->update( SQL_PREFIX.'players', Array( 'BattleID' => $battle_id ), Array( 'Username' => $v ) ); } }
foreach ($tp2 as $v) { if ($v != '') {  $db->update( SQL_PREFIX.'players', Array( 'BattleID' => $battle_id ), Array( 'Username' => $v ) ); } }

$db->update( SQL_PREFIX.'group_demands', Array( 'In_battle' => '1' ), Array( 'Team1' => $data['Team1'] ) );
$db->update( SQL_PREFIX.'battle_id', Array( 'Id' => '[+]1' ), Array( 'Id' => $battle_id ), 'maths' );

@header ('location: battle.php');
exit;

}


}




if (!empty($_POST['group_confirm']) && !empty($_POST['go_group_combat'])) {


$data = $db->queryRow("SELECT * FROM ".SQL_PREFIX."group_demands WHERE (In_battle = '0') AND (Team1 = '$conf_team1')");

$ta1 = split(';', $data['Team1']);
$ta2 = split(';', $data['Team2']);

foreach ($ta1 as $team1_temp) { if ($team1_temp != '') { $team1_num++; } }
foreach ($ta2 as $team2_temp) { if ($team2_temp != '') { $team2_num++; } }

$Now_time = date('His');
list($hour, $min, $sec) = split(':', $data['Start_time']);
$Start_time = $hour.$min.$sec;

if (!$data || !empty($in_group) || $Start_time <= date('His') || ($team1_num >= $data['Team1_num'] && $team2_num >= $data['Team2_num']) ) {

if ( !empty($player_in_demand) || !empty($my_zayava) || !empty($ya_opponent) ){ $err = 'Вы уже приняли бой'; }

} else { $_POST['group_confirm_ok'] = 1; }


}



if (!empty($_POST['group_confirm_1']) || !empty($_POST['group_confirm_2']) ) {

$data = $db->queryRow("SELECT * FROM ".SQL_PREFIX."group_demands WHERE (In_battle = '0') AND (Team1 = '$conf_team1')");

$ta1 = split(';', $data['Team1']);
$ta2 = split(';', $data['Team2']);

foreach ($ta1 as $v) { if ($v != '') { $team1_num++; } if ($v == $player->username) { $cancel_att = 1; } }
foreach ($ta2 as $v) { if ($v != '') { $team2_num++; } if ($v == $player->username) { $cancel_att = 1; } }

if (!$data || $data['Start_time'] <= time('void') || $cancel_att == 1 || ($team1_num >= $data['Team1_num'] && $team2_num >= $data['Team2_num']) ){ }
else {

list($team1_level_min, $team1_level_max) = split('-', $data['Team1_level']);
list($team2_level_min, $team2_level_max) = split('-', $data['Team2_level']);

//$ta2 = split(';', $data['Team2']);

if (!empty($_POST['group_confirm_1'])) {
if ($team1_num >= $data['Team1_num']) { $err = 'Группа уже набрана'; }
elseif ($team1_level_min > $player->Level || $team1_level_max < $player->Level) { $err = 'Вы не можете принять эту заявку'; }
elseif( $data['Type'] == 2 && ($item['Slot'][0] != 'empt0' || $item['Slot'][1] != 'empt1' || $item['Slot'][2] != 'empt2' || $item['Slot'][3] != 'empt3' || $item['Slot'][4] != 'empt4' || $item['Slot'][5] != 'empt5' || $item['Slot'][6] != 'empt6' || $item['Slot'][7] != 'empt7' || $item['Slot'][8] != 'empt8' || $item['Slot'][9] != 'empt9' || $item['Slot'][10] != 'empt10') ){ $err = 'Бой <b>кулачный</b>. Нельзя влезть в него одетым'; }
else {
$db->execQuery("UPDATE ".SQL_PREFIX."group_demands SET Team1 = concat(Team1, '$player->username;') WHERE Team1 = '{$data['Team1']}'");
}

}	else {

if ($team2_num >= $data['Team2_num']){ $err = 'Группа уже набрана'; }
elseif($team2_level_min > $player->Level || $team2_level_max < $player->Level) { $err = 'Вы не можете принять эту заявку'; }
elseif($player->HPnow < $player->HPall/2) { $err = 'В таком состоянии не стоит лезть в бой'; }
elseif( $data['Type'] == 2 && ($item['Slot'][0] != 'empt0' || $item['Slot'][1] != 'empt1' || $item['Slot'][2] != 'empt2' || $item['Slot'][3] != 'empt3' || $item['Slot'][4] != 'empt4' || $item['Slot'][5] != 'empt5' || $item['Slot'][6] != 'empt6' || $item['Slot'][7] != 'empt7' || $item['Slot'][8] != 'empt8' || $item['Slot'][9] != 'empt9' || $item['Slot'][10] != 'empt10') ){ $err = 'Бой <b>кулачный</b>. Нельзя влезть в него одетым'; }
else {

if (!$data['Team2']) { $db->update( SQL_PREFIX.'group_demands', Array( 'Team2' => $player->username.';' ), Array( 'Team1' => $data['Team1'] ) ); }
else { $db->execQuery("UPDATE ".SQL_PREFIX."group_demands SET Team2 = concat(Team2, '$player->username;') WHERE Team1 = '{$data['Team1']}'"); }

}

}

}

}




if (!empty($_POST['open_group_2'])) {
if( $_POST['gbtype2'] == 2 && ($item['Slot'][0] != 'empt0' || $item['Slot'][1] != 'empt1' || $item['Slot'][2] != 'empt2' || $item['Slot'][3] != 'empt3' || $item['Slot'][4] != 'empt4' || $item['Slot'][5] != 'empt5' || $item['Slot'][6] != 'empt6' || $item['Slot'][7] != 'empt7' || $item['Slot'][8] != 'empt8' || $item['Slot'][9] != 'empt9' || $item['Slot'][10] != 'empt10') ){ $err = 'Бой <b>кулачный</b>. Нельзя влезть в него одетым'; }
elseif ( (!empty($player_in_demand) && $player_in_demand == 1) || !empty($my_zayava) || !empty($ya_opponent) ) { $err = 'Вы уже приняли/подали заявку'; }
elseif ($player->HPnow < $player->HPall/2) { $err = 'В таком состоянии не стоит лезть в бой'; }
elseif (!empty($my_group_demand_team1)) { $err = 'Заявка добавлена'; }
elseif ( ($_POST['team1_num'] < 2 && $_POST['team2_num'] < 2) || $_POST['team2_num'] < 1 || $_POST['team1_num'] > 99 || $_POST['team2_num'] > 99 || $_POST['team1_level_min'] < 0 || $_POST['team1_level_max'] > 100  || $_POST['team2_level_min'] < 0 || $_POST['team2_level_max'] > 100 ) { $err = 'Ошибка ввода данных для боя'; }
else {

$_POST['Comment'] = str_replace('<', '&lt', $_POST['Comment']);
$_POST['Comment'] = str_replace('>', '&gt', $_POST['Comment']);

$db->insert( SQL_PREFIX.'group_demands',
Array(
'Team1' => $player->username.';',
'Team1_level' => $_POST['team1_level_min'].'-'.$_POST['team1_level_max'],
'Team1_num' => $_POST['team1_num'],
'Team2' => 'NULL',
'Team2_level' => $_POST['team2_level_min'].'-'.$_POST['team2_level_max'],
'Team2_num' => $_POST['team2_num'],
'Add_time' => 'CURTIME()',
'Start_time' => (time('void')+$_POST['start_time']),
'Type' => intval($_POST['gbtype2']),
'Timeout' => $_POST['start_time'],
'Comment' => $_POST['Comment'],
'In_battle' => '0'
)
);

$err = 'Заявка добавлена';

$player_in_demand = true;

}


}



if( !empty($_GET['zayavka']) && $_GET['zayavka'] == 'add' )
{	if ($player->HPnow < $player->HPall/2) $err = 'В таком состоянии не стоит лезть в бой';
	elseif( !empty($my_zayava) ) $err = 'Вы уже подали заявку.';
	elseif( !empty($ya_opponent) ) $err = 'Вы уже приняли заявку.';
	else
	{		$db->insert( SQL_PREFIX.'demands_2b', Array( 'creator_id' => $player->user_id, 'add_time' => time() ) );
		$err = 'Заявка добавлена.';
		$my_zayava = true;
	}
}

if( !empty($_GET['zayavka']) && $_GET['zayavka'] == 'remove' )
{	if( empty($my_zayava) ) $err = 'Вашей заявки не найдено.';
	else
	{		$db->execQuery( "DELETE FROM ".SQL_PREFIX."demands_2b WHERE creator_id = '".$player->user_id."'" );
		$err = 'Заявка удалена.';
		$my_zayava = false;
    }

}


if( !empty($_GET['zayavka']) && $_GET['zayavka'] == 'ok' && !empty($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0 )
{	if( !$dem = $db->queryRow("SELECT id, opponent_id FROM ".SQL_PREFIX."demands_2b WHERE id = '".intval($_GET['id'])."'") )
	{		 $err = 'Такой заявки не существует.';
    }
	elseif ($player->HPnow < $player->HPall/2) $err = 'В таком состоянии не стоит лезть в бой';
	elseif( !empty($ya_opponent) ) $err = 'Вы уже приняли чью-то заявку.';
	elseif( !empty($dem['opponent_id']) ) $err = 'Кто-то уже принял эту заявку.';
	else
	{		$db->update( SQL_PREFIX.'demands_2b', Array( 'opponent_id' => $player->user_id ), Array( 'id' => $dem['id'] ) );
		$err = 'Заявка принята';
		$ya_opponent = $dem['id'];
	}

}


/*
$qry=mysql_query("show table status where name='newblog'") or die (mysql_error());
$row=mysql_fetch_array($qry);
$newtid=$row[10];
*/

/*
$xml = simplexml_load_string($xmlstr);

$xml->movie[0]->characters->character[0]->name = 'Miss Coder';

echo $xml->asXML();
чтобы изменить данные в name
*/

function slogin( $user, $lvl, $clanid )
{   global $db_config;
    $r = '';
	if( !empty($clanid) ) $r .= '<a href="http://'.$db_config[DREAM]['server'].'/top5.php?show='.$clanid.'"><img src="http://'.$db_config[DREAM_IMAGES]['server'].'/clan/'.$clanid.'.gif" /></a>';

	$r .= '<a href="http://'.$db_config[DREAM]['server'].'/inf.php?uname='.$user.'" target="_blank">'.$user.'</a> ['.$lvl.']';
	return $r;
}


if( !empty($_GET['demand']) && $_GET['demand'] == 'accept' )
{	if( empty($my_zayava['Username']) ) $err = 'Некого принимать.';
	else
	{		$db->insert( SQL_PREFIX.'2battle', Array( 'team1' => $player->username.';', 'team2' => $my_zayava['Username'].';', 'start_time' => time() ) );
		$id = $db->insertId();

		$db->update( SQL_PREFIX.'demands_2b', Array( 'status' => 'action', 'battle_id' => $id ), Array( 'id' => $my_zayava['id'] ) );

		$db->insert( SQL_PREFIX.'2battle_action', Array( 'battle_id' => $id, 'Username' => $player->username, 'Enemy' => $my_zayava['Username'], 'team' => 1 ) );
        $db->insert( SQL_PREFIX.'2battle_action', Array( 'battle_id' => $id, 'Username' => $my_zayava['Username'], 'Enemy' => $player->username, 'team' => 2 ) );
		//$user = slogin( $player->username, $player->Level, $player->id_clan );
		//$opp  = slogin( $my_zayava['Username'], $my_zayava['Level'], $my_zayava['ClanID']);
		$time = date( 'm, j, Y, H:i', time() );

$xmlstr =
"<?xml version=\"1.0\" encoding=\"windows-1251\"?>
<battle id=\"$id\">
 <team1>$player->username</team1>
 <team2>$my_zayava[Username]</team2>
 <log>
   <str>Было $time когда $player->username и $my_zayava[Username] начали битву.</str>
 </log>
</battle>
";

		file_put_contents( $db_config[DREAM]['web_root'] . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'battles' . DIRECTORY_SEPARATOR . $id . '.xml', $xmlstr );



		$db->update( SQL_PREFIX.'players', Array( 'BattleID2' => $id ), Array( 'Username' => $player->username ) );
		$db->update( SQL_PREFIX.'players', Array( 'BattleID2' => $id ), Array( 'Username' => $my_zayava['Username'] ) );

		$txt = '<font color="red">Внимание!</font> <a style="cursor:hand" onclick="top.frames[\'TOP\'].location.href=\'../battle2.php\'">Ваш бой начался.</a>';
		$db->insert( SQL_PREFIX.'messages', Array( 'Username' => $my_zayava['Username'], 'Text' => $txt ) );
		$db->insert( SQL_PREFIX.'messages', Array( 'Username' => $player->username, 'Text' => $txt ) );

		header( 'Location: battle2.php' );
	}

}


if( !empty($_GET['demand']) && $_GET['demand'] == 'decline' )
{
	if( empty($my_zayava['Username']) ) $err = 'Некого отклонять.';
	else
	{
		$db->update( SQL_PREFIX.'demands_2b', Array( 'opponent_id' => '' ), Array( 'creator_id' => $player->user_id ) );
		$err = 'Заявка отклонена.';
		$my_zayava['Username'] = '';

	}

}

if( !empty($_GET['demand']) && $_GET['demand'] == 'delete' )
{	if( empty($ya_opponent) ) $err = 'Ваша заявка уже отклонена.';
	else
	{		$db->update( SQL_PREFIX.'demands_2b', Array( 'opponent_id' => '' ), Array( 'opponent_id' => $player->user_id ) );
		$err = 'Заявка отменена.';
		$ya_opponent = '';
	}

}


if ( $db->queryRow("SELECT * FROM ".SQL_PREFIX."group_demands WHERE (Team1 = '$player->username;') AND (Team2 is NULL)") ){
if (!empty($_POST['group_del_demand'])) { $db->execQuery("DELETE FROM ".SQL_PREFIX."group_demands WHERE Team1 = '$player->username;'"); $player_in_demand = false; }
}

$res = $db->queryArray("SELECT * FROM ".SQL_PREFIX."demands WHERE In_battle = '0'");
if(!empty($res)){ foreach($res as $td){ if ( !$db->queryRow("SELECT * FROM ".SQL_PREFIX."online WHERE Username = '{$td['Username']}'") ){ $db->execQuery("DELETE FROM ".SQL_PREFIX."demands WHERE Username = '{$td['Username']}'"); } } }

//типа обновляем данные
$co2 = $db->queryRow("SELECT * FROM ".SQL_PREFIX."demands WHERE Name_pr = '$player->username'");
$co1 = $db->queryRow("SELECT * FROM ".SQL_PREFIX."demands WHERE Username = '$player->username'");


require_once('_loader.php');

$tow_tpl->assignGlobal('db_config', $db_config);
$tow_tpl->assignGlobal('db', $db);

$temp = & $tow_tpl->getDisplay('content', true);

$temp->assign( 'player', $player );
$temp->assign( 'co2', $co2 );
$temp->assign( 'co1', $co1 );
$temp->assign( 'data', $data );
$temp->assign( 'ta1', $ta1 );
$temp->assign( 'ta2', $ta2 );

$temp->assign( 'player_in_demand', $player_in_demand );
$temp->assign( 'team1_num', $team1_num );
$temp->assign( 'team2_num', $team2_num );
$temp->assign( 'r_rate', $r_rate );
$temp->assign( 'type', $type );
$temp->assign( 'all', $all );
$temp->assign( 'err', $err );

//тестовые
$temp->assign( 'zayavki', $db->queryArray( "SELECT dm.id, dm.add_time as time, dm.opponent_id, p.Username, p.Level, p.Align, p.ClanID FROM ".SQL_PREFIX."demands_2b as dm INNER JOIN ".SQL_PREFIX."players as p ON( dm.creator_id = p.Id ) WHERE dm.status = 'wait';" ) );
$temp->assign( 'my_zayava', $my_zayava );
$temp->assign( 'ya_opponent', $ya_opponent );

$temp->addTemplate('demands', 'timeofwars_demands.html');


$show = & $tow_tpl->getDisplay('index');

$show->assign('title', 'Time Of Wars - арена');
$show->assign('Content', $temp);

$show->addTemplate('header', 'header.html');
$show->addTemplate('index' , 'index.html' );
$show->addTemplate('footer', 'footer.html');


$tow_tpl->display();
?>
