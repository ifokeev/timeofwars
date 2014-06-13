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

if($player->id_picture == '0'){

if($player->Sex == 'M' && !empty($_GET['pict_value']) && ($_GET['pict_value'] >= 7 && $_GET['pict_value'] <= 17) ){
$db->update( SQL_PREFIX.'players', Array( 'Pict' => $player->Sex.'/'.intval($_GET['pict_value']) ), Array( 'Username' => $player->username, 'Sex' => 'M' ) );
@header('Location: inv.php');
}

elseif($player->Sex == 'F' && !empty($_GET['pict_value']) && ($_GET['pict_value'] >= 30 && $_GET['pict_value'] <= 40) ){
$db->update( SQL_PREFIX.'players', Array( 'Pict' => $player->Sex.'/'.intval($_GET['pict_value']) ), Array( 'Username' => $player->username, 'Sex' => 'F' ) );
@header('Location: inv.php');
}

require_once('_loader.php');

$tow_tpl->assignGlobal('db_config', $db_config);

$temp = & $tow_tpl->getDisplay('content', true);

$temp->assign('dat', $player->Sex);

$temp->setCache('Pict', 60);

if (!$temp->isCached()) {
$temp->addTemplate('Pict', 'timeofwars_func_Pict.html');
}

$show = & $tow_tpl->getDisplay('index');


$show->assign('title', 'Time Of Wars - выбор образа');
$show->assign('Content', $temp);


$show->addTemplate('header', 'header.html');
$show->addTemplate('index' , 'index.html' );
$show->addTemplate('footer', 'footer.html');


$tow_tpl->display();

}
else {
@header('Location: inv.php');
}
?>
