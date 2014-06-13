<?
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

include_once ('includes/battle/func_write_log.php');
include_once ('includes/battle/func_udar.php');
include_once ('includes/to_view.php');

session_start();
if (empty($_SESSION['login'])) { include_once('includes/bag_log_in.php'); exit; }


include_once ('func.php');
include_once ('db.php');

if ( list($why) = $db->queryCheck("SELECT Why FROM ".SQL_PREFIX."blocked WHERE Username = '{$_SESSION['login']}'") ) { die( sprintf(playerblocked, $why) ); } unset($why);

$err               = '';
$Add_Log           = '';
$TmpComment        = '';
$my_group_demand   = 0;
$voskr_clan        = 1;
$voskr_clan_thname = '';
$cantheal          = 0;
$players_list_show = '';

$db->checklevelup( $_SESSION['login'] );

if (empty($_POST['Enemy_un'])){ $_POST['Enemy_un'] = 0; }
if (empty($_GET['use'])){ $_GET['use'] = 0; }


$Player = new Player($_SESSION['login']);


if ($Player->hpnow > $Player->hpall) {
$db->execQuery("UPDATE ".SQL_PREFIX."players SET HPnow = HPall WHERE Username = '$Player->login'");
$Player->hpnow = $Player->hpall;
}

$BattleID = $Player->battle_id;


$myd = $db->queryRow("SELECT * FROM ".SQL_PREFIX."demands WHERE (Username = '$Player->login') AND (In_battle = '1')");
$nmd = $db->queryRow("SELECT * FROM ".SQL_PREFIX."demands WHERE (Name_pr = '$Player->login') AND (In_battle = '1')");


if ($myd) { $e_l = $myd['Name_pr']; $timeout = 180; $TmpComment = $myd['Comment']; }
if ($nmd) { $e_l = $nmd['Username']; $timeout = 180; }

$mgd = $db->queryRow("SELECT * FROM ".SQL_PREFIX."group_demands WHERE (Team1 LIKE '%$Player->login;%') OR (Team2 LIKE '%$Player->login%')");

if ($mgd) {
$mygd = $db->queryRow("SELECT * FROM ".SQL_PREFIX."group_demands WHERE Team1 = '{$mgd['Team1']}' AND In_battle = '1'");
$timeout = 180;
}



if (!$BattleID) {
print '<CENTER><B>Не могу получить ID боя<BR>Возможно, бой уже окончен</B><BR>Для выхода на площадь обновите экран</CENTER>';
if (!empty($_SESSION['login'])){ $db->execQuery("DELETE FROM ".SQL_PREFIX."group_demands WHERE (Team1 LIKE '%$Player->login;%') OR (Team2 LIKE '%$Player->login;%')"); }
exit;
}


if ( $db->queryRow("SELECT * FROM ".SQL_PREFIX."battle_list WHERE Id = '$BattleID'") ) { $t1p = 1; }
if ( $db->queryRow("SELECT * FROM ".SQL_PREFIX."battle_action WHERE Id = '$BattleID'") ) { $t2p = 1; }


if ( !empty($mygd) ) {

$team1p = split (';', $mygd['Team1']);
$team2p = split (';', $mygd['Team2']);

$My_team1 = $mygd['Team1'];
$TmpComment = $mygd['Comment'];

if ( empty($t1p) ) {
foreach($team1p as $v) { if ($v != '') {  $db->insert( SQL_PREFIX.'battle_list', Array( 'Player' => $v, 'Team' => '1', 'Damage' => '0', 'Dead' => '0', 'Id' => $BattleID, 'is_finished' => '0' ) ); } }
foreach($team2p as $v) { if ($v != '') {  $db->insert( SQL_PREFIX.'battle_list', Array( 'Player' => $v, 'Team' => '2', 'Damage' => '0', 'Dead' => '0', 'Id' => $BattleID, 'is_finished' => '0' ) ); } }

$db->execQuery("DELETE FROM ".SQL_PREFIX."group_demands WHERE Team1 = '".$mygd['Team1']."'");
}

} else {
//1
if ( empty($t1p) ) {

if (!empty($e_l)){
$db->insert( SQL_PREFIX.'battle_list', Array( 'Player' => $Player->login, 'Team' => '1', 'Damage' => '0', 'Dead' => '0', 'Id' => $BattleID, 'is_finished' => '0' ) );
$db->insert( SQL_PREFIX.'battle_list', Array( 'Player' => $e_l,           'Team' => '2', 'Damage' => '0', 'Dead' => '0', 'Id' => $BattleID, 'is_finished' => '0' ) );
}

if ($myd) { $db->execQuery("DELETE FROM ".SQL_PREFIX."demands WHERE Username = '$Player->login'"); }
if ($nmd) { $db->execQuery("DELETE FROM ".SQL_PREFIX."demands WHERE Name_pr = '$Player->login'"); }

}

//1 - конец
}




list($team, $dmg) = $db->queryCheck("SELECT Team, Damage FROM ".SQL_PREFIX."battle_list WHERE (Player = '$Player->login') AND (Id = '$BattleID')");

if( $log = $db->queryCheck("SELECT Log FROM ".SQL_PREFIX."logs WHERE Id = '$BattleID'") ){

$rev_log = split('<BR>', $log[0]);
$rev_log = array_reverse ($rev_log);

}else{

$start_log_text = '<font class="date">'.date('d.m.Y').', в '.date('H:i').'</font> начался бой между';

$dat = $db->queryArray("SELECT * FROM ".SQL_PREFIX."battle_list WHERE Team = '1' AND Id = '$BattleID'");
if(!empty($dat)){

foreach($dat as $v){
$pl = new Player($v['Player']);
$start_log_text = $start_log_text.' <font class=B1>'.$pl->Getdlogin().'</font>';
$team1_list = $team1_list.''.$pl->Getdlogin().';';
}

}

$start_log_text = $start_log_text.' и';

$dat = $db->queryArray("SELECT * FROM ".SQL_PREFIX."battle_list WHERE Team = '2' AND Id = '$BattleID'");
if(!empty($dat)){

foreach($dat as $v){
$pl = new Player($v['Player']);
$start_log_text = $start_log_text.' <font class=B2>'.$pl->Getdlogin().'</font>';
$team2_list = $team2_list.''.$pl->Getdlogin().';';
}

}

unset($pl);

if ($TmpComment != '') { $start_log_text = $start_log_text.' с коментарием: '.$TmpComment.'<BR><BR>'; }
else { $start_log_text = $start_log_text.' без коментария<BR><BR>'; }


$query = sprintf("INSERT INTO ".SQL_PREFIX."logs ( Id, Log, Team1, Team2, Team_won ) VALUES ( '%d', '%s', '%s', '%s', '0') ON DUPLICATE KEY UPDATE Log = '%s', Team1 = '%s', Team2 = '%s', Team_won = '0'", $BattleID, mysql_escape_string($start_log_text), mysql_escape_string($team1_list), mysql_escape_string($team2_list), mysql_escape_string($start_log_text),  mysql_escape_string($team1_list),  mysql_escape_string($team2_list));
$db->execQuery($query);


}

//-----------------------------------------------------------------------

//---------------- Ищем магию в рюкзаке ---------------------------------
$player_magic  = $db->queryArray("SELECT * FROM ".SQL_PREFIX."things WHERE (Owner = '$Player->login') AND (Slot = '11')");
$player_magic2 = $db->query("SELECT * FROM ".SQL_PREFIX."things WHERE (Owner = '$Player->login') AND (Wear_ON = '1') AND (MagicID != '') AND (Id != '$voskr_clan_thname')");
//if ($Player->clanID == $voskr_clan) {
//	$player_magic3 = mysql_query("SELECT * FROM things WHERE (Owner='$login') AND (Id='$voskr_clan_thname') AND (MagicID != '') LIMIT 1",$db);
//}
//-----------------------------------------------------------------------
$voskr_clan = 1;

if (!empty($_GET['use'])){ $err = $_GET['use']; }

if (!empty($_GET['use'])){

if (!empty($_GET['use']) && $_GET['use'] == 10){

if ($Player->clanID == $voskr_clan) {
$player_magic3 = $db->queryRow("SELECT * FROM ".SQL_PREFIX."dd WHERE Username = '$Player->login'");

if (!$player_magic3){ include_once 'magic.php'; $Add_log = magic(10, $Player->login, $BattleID);

if ($Add_log != ''){
$db->execQuery("UPDATE ".SQL_PREFIX."logs SET Log = concat(Log, '".mysql_escape_string($Add_log)."<BR>') WHERE Id = '$BattleID'");
$db->insert( SQL_PREFIX.'dd', Array( 'Username' => $Player->login, 'DD' => '0' ) );
}

}

}

} else {

$err .= $_GET['use'];

if( $db->queryRow("SELECT * FROM ".SQL_PREFIX."things WHERE (Owner = '$Player->login') AND (Un_Id = '{$_GET['use']}') AND ( (MagicID != '') AND (MagicID IS NOT null) )") ){

$err .= 'MagicID';

if ($Player->CheckThing($_GET['use'])){

include_once 'magic.php';

@$_GET['target'] = speek_to_view($_GET['target']);
$Add_log = magic($_GET['use'], $_GET['target'], $BattleID);

if ($Add_log != ''){ WriteBattleLog($Add_log, $BattleID); }
else { $err = 'Вы пытаетесь использовать недопустимую магию'; }

} else { $err = 'Вы не можете использовать данную магию'; }
} else { $err = 'Предмет не найден в рюкзаке либо не имеет магиеских способностей'; }

}

@header ('location: battle.php');
exit;
}


//---------------------------- Конец боя --------------------------------
if ($team == 1) { $enemy_team_temp = 2; $my_team_temp = 1; }
if ($team == 2) { $my_team_temp = 2; $enemy_team_temp = 1; }

if( $db->numrows("SELECT * FROM ".SQL_PREFIX."battle_list WHERE (Team = '$enemy_team_temp') AND (Dead = '0') AND (Id = '$BattleID')") > 0){ $enemy_team_alive = 1; }
if( $db->numrows("SELECT * FROM ".SQL_PREFIX."battle_list WHERE (Team = '$my_team_temp') AND (Dead = '0') AND (Id = '$BattleID')") > 0){ $my_team_alive = 1; }

if ($Player->hpnow <= 0) { include_once ('includes/battle/func_battle_end.php'); exit; }

if (empty($my_team_alive) || empty($enemy_team_alive)) { include_once ('includes/battle/func_battle_end.php'); exit; }

$my_turn_1 = $db->queryRow("SELECT * FROM ".SQL_PREFIX."battle_action WHERE (Player = '$Player->login') AND (Enemy = '{$_POST['Enemy_un']}') AND (Id = '$BattleID')");
$my_die = $db->queryRow("SELECT * FROM ".SQL_PREFIX."battle_list WHERE Player = '$Player->login' AND Id = '$BattleID'");

if (!$my_turn_1 && $my_die['Dead'] != 1){

if (!empty($_POST['attack_value'])) {

if ( !is_numeric($_POST['kick']) || !is_numeric($_POST['block']) ){ die('В логах я тебя записал, ога...'); }

if ( ($_POST['kick'] != 1 && $_POST['kick'] != 2 && $_POST['kick'] != 4 && $_POST['kick'] != 8) || ($_POST['block'] != 3 && $_POST['block'] != 6 && $_POST['block'] != 12 && $_POST['block'] != 9) ) { die('<center>Ошибка ввода параметров</center>'); }
else { $db->insert( SQL_PREFIX.'battle_action', Array( 'Player' => $Player->login, 'Action' => 'kick', 'Enemy' => $_POST['Enemy_un'], 'What' => $_POST['kick'].';'.$_POST['block'], 'Time' => time(), 'Id' => $BattleID ) ); }

}

}

//-----------------------------------------------------------------------




if ($team == 2) { $E = 'B1'; $M = 'B2'; } else { $E = 'B2'; $M = 'B1'; }

$list1 = $db->queryArray("SELECT Player FROM ".SQL_PREFIX."battle_list WHERE (Team = '1') AND (dead = '0') AND (Id = '$BattleID')");
if(!empty($list1)){
foreach($list1 as $v){
//начало
$result1 = $db->queryCheck("SELECT Username, HPnow, HPall, Reg_IP FROM ".SQL_PREFIX."players WHERE Username = '".$v['Player']."'");

if ($result1[3] == 'бот') { $cantheal = 1; }

$players_list_show .= ' <span class="'.$M.'">'.$result1[0].'</span> ['.$result1[1].'/'.$result1[2].'] ';

if ($team == 1) { if (empty($my_team_list)) { $my_team_list = $result1[0]; } else {	$my_team_list = $my_team_list.', '.$result1[0]; }  }
//конец
}
}

$players_list_show .= ' против';

$list2 = $db->queryArray("SELECT Player FROM ".SQL_PREFIX."battle_list WHERE (Team = '2') AND (dead = '0') AND (Id = '$BattleID')");
if(!empty($list2)){
foreach($list2 as $v){
//начало
$result2 = $db->queryCheck("SELECT Username, HPnow, HPall, Reg_IP FROM ".SQL_PREFIX."players WHERE Username = '".$v['Player']."'");

if ($result2[3] == 'бот') { $cantheal = 1; }

$players_list_show .= ' <span class="'.$E.'">'.$result2[0].'</span> ['.$result2[1].'/'.$result2[2].'] ';

if ($team == 2) { if (empty($my_team_list)) { $my_team_list = $result2[0]; } else {	$my_team_list = $my_team_list.', '.$result2[0]; }  }
//конец
}
}

$players_list_show .= '<br> <hr />';

//-----------------------------------------------------------------------

//-------------------------------- Цикл ---------------------------------
$my_turn1 = $db->queryArray("SELECT Player FROM ".SQL_PREFIX."battle_list WHERE (Team != '$team')  AND (Dead = '0') AND (Id = '$BattleID')");
if(!empty($my_turn1)){
foreach($my_turn1 as $v){

$my_turn2 = $db->queryCheck("SELECT Action, What, Time FROM ".SQL_PREFIX."battle_action WHERE (Player = '$Player->login') AND (Enemy = '".$v['Player']."') AND (Id = '$BattleID')");

$Enemy = new Player($v['Player']);

if (!$my_turn2[0]) { $Enemy_Username = $v['Player']; include_once ('includes/battle/func_select_kick.php'); $turn = 1; break; }
else{



if ( $Enemy->login == 'ЛамоБот' || preg_match( '/Тренер_/i', $Enemy->login ) ) {

$kickr = rand(1,4); $blockr = rand(1,4);

if ($kickr == 1) { $bkick = 1; }
if ($kickr == 2) { $bkick = 2; }
if ($kickr == 3) { $bkick = 4; }
if ($kickr == 4) { $bkick = 8; }
if ($blockr == 1) { $bblock = 3; }
if ($blockr == 2) { $bblock = 6; }
if ($blockr == 3) { $bblock = 12; }
if ($blockr == 4) { $bblock = 9; }

$db->insert( SQL_PREFIX.'battle_action', Array( 'Player' => $Enemy->login, 'Action' => 'kick', 'Enemy' => $Player->login, 'What' => $bkick.';'.$bblock, 'Time' => time(), 'Id' => $BattleID ) );
}

elseif ($Enemy->Reg_IP == 'бот' && (time('void') - $my_turn2[2]) > rand(5, 10)) {

$kickr = rand(1,4); $blockr = rand(1,4);

if ($kickr == 1) { $bkick = 1; }
if ($kickr == 2) { $bkick = 2; }
if ($kickr == 3) { $bkick = 4; }
if ($kickr == 4) { $bkick = 8; }
if ($blockr == 1) { $bblock = 3; }
if ($blockr == 2) { $bblock = 6; }
if ($blockr == 3) { $bblock = 12; }
if ($blockr == 4) { $bblock = 9; }
$db->insert( SQL_PREFIX.'battle_action', Array( 'Player' => $Enemy->login, 'Action' => 'kick', 'Enemy' => $Player->login, 'What' => $bkick.';'.$bblock, 'Time' => time(), 'Id' => $BattleID ) );
}

$enemy_turn = $db->queryRow("SELECT * FROM ".SQL_PREFIX."battle_action WHERE (Player = '".$v['Player']."') AND (Enemy = '$Player->login') AND (Id = '$BattleID')");

if ($enemy_turn) {
if ($enemy_turn['Action'] == 'kick') {


list($enemy_kick, $enemy_block) = split (';', $enemy_turn['What']);
list($my_kick, $my_block) = split (';', $my_turn2[1]);

$Add_Log .= udar($Player, $Enemy, $my_kick, $enemy_block);
WriteBattleLog($Add_Log, $BattleID);

$Add_Log = udar($Enemy, $Player, $enemy_kick, $my_block);
WriteBattleLog($Add_Log, $BattleID);


if ($Player->hpnow < 1) {
$Player->SetDead($BattleID);

if ($Player->sex == 'F') { $sex1 = 'а'; } else { $sex1 = ''; }

$id = $db->SQL_result($db->query( "SELECT turnir_id FROM ".SQL_PREFIX."turnir_users WHERE user = '".$Enemy->login."';" ),0);
if( $id )
{
	$db->update( SQL_PREFIX.'turnir_users', Array( 'points' => '[+]1' ), Array( 'user' => $Enemy->login, 'turnir_id' => $id ), 'maths' );
}

$Add_die = '<BR><font class="date">'.date('H:i').'</font> '.$Player->Getdlogin().' повержен'.$sex1.'<BR>';
WriteBattleLog($Add_die, $BattleID);
}


if ($Enemy->hpnow < 1) {
$Enemy->SetDead($BattleID);

if ($Enemy->sex == 'F') { $sex1 = 'а'; } else { $sex1 = ''; }

$id = $db->SQL_result($db->query( "SELECT turnir_id FROM ".SQL_PREFIX."turnir_users WHERE user = '".$Player->login."';" ),0);
if( $id )
{
	$db->update( SQL_PREFIX.'turnir_users', Array( 'points' => '[+]1' ), Array( 'user' => $Player->login, 'turnir_id' => $id ), 'maths' );
}

$Add_die = '<BR><font class="date">'.date('H:i').'</font> '.$Enemy->Getdlogin().' повержен'.$sex1.'<BR>';
WriteBattleLog($Add_die,$BattleID);
}


if ($inv2 == 1 && $Player->hpnow < 1) { $Player->MakeTrauma($BattleID); }
if ($inv2 == 1 && $Enemy->hpnow < 1) { $Enemy->MakeTrauma($BattleID); }

WriteBattleLog('<BR>', $BattleID);

$db->execQuery("DELETE FROM ".SQL_PREFIX."battle_action WHERE (Player = '$Player->login') AND (Action = 'kick') AND (Enemy = '$Enemy->login') AND (Id = '$BattleID')");
$db->execQuery("DELETE FROM ".SQL_PREFIX."battle_action WHERE (Player = '$Enemy->login') AND (Action = 'kick') AND (Enemy = '$Player->login') AND (Id = '$BattleID')");;

@header ('location: battle.php');
exit;
}
}
}
}
}




if (empty($turn)) {

$i_can_win = 0;

list($last) = $db->fetch_array("SELECT max(Time) FROM ".SQL_PREFIX."battle_action WHERE Id = '$BattleID'");

$differ = time() - $last;

if ($differ > 180) {

$i_can_win = 1;

if (!empty($_GET['time']) && $_GET['time'] == 'win') {

WriteBattleLog('<font class="date">'.date('H:i').'</font> '.$Player->login.' выбирает победу по таймауту. <B>'.$my_team_list.'</B> одержал(и) победу в поединке<BR>', $BattleID);
$db->execQuery("DELETE FROM ".SQL_PREFIX."battle_action WHERE (Id = '$BattleID')");

$die_players = mysql_query("SELECT Player FROM ".SQL_PREFIX."battle_list WHERE Team <> '$team' AND Id = '$BattleID'");
while (list($P) = mysql_fetch_array($die_players)) {

$tdp = new Player($P);

if ($tdp->hpnow > 0){ $tdp->MakeTrauma($BattleID); }

$db->update( SQL_PREFIX.'players', Array( 'HPnow' => '0' ), Array( 'Username' => $tdp->login, 'Id' => $BattleID ) );

}

$db->execQuery("UPDATE ".SQL_PREFIX."battle_list SET Dead = '1' WHERE Team <> '$team' AND Id = '$BattleID'");

@header ('location: battle.php');
exit;

// конец акта
}


if (!empty($_GET['time']) && $_GET['time'] == 'none') {

WriteBattleLog('<font class=date>'.date('H:i').'</font> '.$Player->login.' выбирает ничью по таймауту, бой окончен<BR>', $BattleID);

$db->execQuery("UPDATE ".SQL_PREFIX."battle_list SET Dead = '1' WHERE Id = '$BattleID'");
$db->execQuery("DELETE FROM ".SQL_PREFIX."battle_action WHERE (Id = '$BattleID')");

@header ('location: battle.php');
exit;

// конец акта
}

// конец турна
}

include_once ('includes/battle/func_battle_wait.php');
exit;
}

echo '<CENTER><H1>'.$err.'</H1></CENTER>';
?>
