<?
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

session_start();
if (empty($_SESSION['login'])) { include_once('includes/bag_log_in.php'); exit; }

include_once ('includes/to_view.php');
include_once ('db_config.php');
include_once ('db.php');

include_once ('classes/PlayerInfo.php');

$player = new PlayerInfo();

$player->is_blocked();
$player->checkBattle();
$player->checkRoom('hospitalrooms');

if(!empty($_GET['goto']) && $_GET['goto'] == 'hospital' ){
$db->execQuery("DELETE FROM `".SQL_PREFIX."living_inside` WHERE Username = '$player->username'");
$player->gotoRoom( 'hospital', 'hospital' );
}

$player->heal();

if( !$Id = @$db->SQL_result($db->query("SELECT Id FROM `".SQL_PREFIX."living_inside` WHERE Username = '$player->username'")) ){
die('В комнату войти не получилось. Попробуйте еще раз. <br /> <input type="button" onclick="window.location.href=\'?goto=hospital\'" value="Вернуться">');
}

$err = '';

$arr = $db->queryRow("SELECT * FROM `".SQL_PREFIX."living_rooms` WHERE Id = '$Id'");

if ($arr['Office'] == 0) { $qr = 1; }

if(!empty($_GET['make_key']) && $_GET['make_key'] == 1){
if($arr['Founder'] != $player->username){ $err = 'Вы не являетесь владельцем квартиры'; }
elseif($player->Money < 5){ $err = 'Недостаточно денег, для создания дубликата'; }
else{

$db->insert( SQL_PREFIX.'things', Array( 'Owner' => $player->username, 'Id' => 'room_key', 'Thing_Name' => 'Ключ от квартиры №'.$Id.' (дубликат)', 'Slot' => '15', 'Cost' => '5', 'Level_need' => '1', 'MAXwear' => '500' ) );
$db->update( SQL_PREFIX.'players', Array( 'Money' => '[-]5' ), Array( 'Username' => $player->username ), 'maths' );
$err = 'Дубликат ключа помещен в Ваш рюкзак';

}

}


if(!empty($_GET['newt'])){
if($arr['Founder']!= $player->username){ $err = 'Вы не являетесь владельцем квартиры'; }
elseif (preg_match ('/[^a-zA-Z0-9Аа-яА-Я ]/', $_GET['newt'])) { $err = 'Надпись содержит недопустимые символы'; }
elseif (strlen($_GET['newt']) > 20) {	$err = 'Максимальная длина надписи 20 символов'; }
else{

$db->update( SQL_PREFIX.'living_rooms', Array( 'Name' => speek_to_view($_GET['newt']) ), Array( 'Id' => $Id ) );
$err = 'Табличка обновлена успешно';

}

}

$r = $db->queryArray("SELECT p.Username, p.Level, p.HPnow, p.HPall, p.ClanID, p.Align FROM ".SQL_PREFIX."living_inside as l, ".SQL_PREFIX."players as p WHERE (l.Id = '$Id') && (l.Username != '$player->username') && (p.Username = l.Username )");

require_once('_loader.php');

$tow_tpl->assignGlobal('db_config', $db_config);

$temp = & $tow_tpl->getDisplay('content', true);

$temp->assign( 'player', $player );
$temp->assign( 'r',      $r      );
$temp->assign( 'Id',     $Id     );
$temp->assign( 'qr',     $qr     );
$temp->assign( 'err',    $err    );
$temp->assign( 'arr',    $arr    );



//$temp->setCache('rooms', 60);

if (!$temp->isCached()) {
$temp->addTemplate('rooms', 'timeofwars_loc_hospitalrooms.html');
}

$show = & $tow_tpl->getDisplay('index');


$show->assign('title', 'Time Of Wars - комнаты госпиталя');
$show->assign('Content', $temp);


$show->addTemplate('header', 'header.html');
$show->addTemplate('index' , 'index.html' );
$show->addTemplate('footer', 'footer.html');


$tow_tpl->display();

?>
