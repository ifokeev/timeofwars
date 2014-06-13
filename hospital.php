<?
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

session_start();
if (empty($_SESSION['login'])) { include_once('includes/bag_log_in.php'); exit; }

include_once ('db_config.php');
include_once ('db.php');

include_once ('classes/PlayerInfo.php');

$player = new PlayerInfo();

$player->is_blocked();
$player->checkBattle();
$player->checkRoom('hospital');

if(!empty($_GET['goto']) && $_GET['goto'] == 'pl' ){
$player->gotoRoom();
}

$player->heal();

$msg                = '';
@$_GET['goroomid']  = intval($_GET['goroomid']);
@$_GET['buyroomid'] = intval($_GET['buyroomid']);


if(!empty($_GET['goroomid']) && is_numeric($_GET['goroomid'])){

if( list($Id, $cap) = $db->queryCheck("SELECT Id, Capacity FROM ".SQL_PREFIX."living_rooms WHERE Id = '{$_GET['goroomid']}'") ){

if( list($id, $name) = $db->queryCheck("SELECT Un_Id, Thing_Name FROM ".SQL_PREFIX."things WHERE Thing_Name like '%Ключ от квартиры №$Id%' AND Owner = '$player->username' AND Id = 'room_key'") ){

if( $db->numrows("SELECT * FROM ".SQL_PREFIX."living_inside WHERE Id = '$Id'") <= $cap ){

$db->execQuery("INSERT INTO ".SQL_PREFIX."living_inside (Id, Username) VALUES ('$Id', '$player->username') ON DUPLICATE KEY UPDATE Id = '$Id'");


if( $name == 'Ключ от квартиры №'.$Id.' (дубликат)' ){
$db->update( SQL_PREFIX.'things', Array( 'NOWwear' => '[+]1' ), Array( 'Username' => $player->username, 'Un_Id' => $id, 'Id' => 'room_key' ), 'maths' );
$db->execQuery("DELETE FROM ".SQL_PREFIX."things WHERE NOWwear = MAXwear AND Owner = '$player->username'");
}


die( $player->gotoRoom( 'hospitalrooms', 'living__'.$Id ) );

} else { $msg = 'В комнате слишком много человек. Вы не можете войти.'; }

} else { $msg = 'Нету подходящего ключа в рюкзаке'; }

} else { $msg = 'Такой комнаты не существует'; }

}

if(!empty($_GET['buyroomid']) && is_numeric($_GET['buyroomid'])){
if( list($Id, $cost) = $db->queryCheck("SELECT Id, Cost FROM ".SQL_PREFIX."living_rooms WHERE Id = '{$_GET['buyroomid']}' AND (Founder='' OR Founder is null)") ){
if($player->Money >= $cost){

$db->update( SQL_PREFIX.'players', Array( 'Money' => '[-]'.$cost ), Array( 'Username' => $player->username ), 'maths' );
$db->insert( SQL_PREFIX.'things', Array( 'Owner' => $player->username, 'Id' => 'room_key', 'Thing_Name' => 'Ключ от квартиры №'.$Id.' (оригинал)', 'Slot' => '15', 'Cost' => '5', 'Level_need' => '1', 'MAXwear' => '500' ) );
$db->execQuery("UPDATE ".SQL_PREFIX."living_rooms SET Founder = '$player->username' WHERE Id = '$Id' AND (Founder='' OR Founder is null)");

$player->Money -= $cost;
$msg = 'Комната №'.$Id.' успешно куплена';

} else { $msg = 'Недостаточно денег'; }

} else { $msg = 'Такой комнаты не существует, либо она уже куплена'; }

}

$r = $db->queryArray('SELECT * FROM '.SQL_PREFIX.'living_rooms', 'living_rooms');

require_once('_loader.php');

$tow_tpl->assignGlobal('db_config', $db_config);

$temp = & $tow_tpl->getDisplay('content', true);

$temp->assign( 'msg',   $msg   );
$temp->assign( 'Money', $player->Money );
$temp->assign( 'r',     $r     );


//$temp->setCache('hospital', 60);

if (!$temp->isCached()) {
$temp->addTemplate('hospital', 'timeofwars_loc_hospital.html');
}

$show = & $tow_tpl->getDisplay('index');


$show->assign('title', 'Time Of Wars - городской госпиталь');
$show->assign('Content', $temp);


$show->addTemplate('header', 'header.html');
$show->addTemplate('index' , 'index.html' );
$show->addTemplate('footer', 'footer.html');


$tow_tpl->display();
?>
