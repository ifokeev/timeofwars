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
$player->checkRoom('wedding');

if(!empty($_GET['goto']) && $_GET['goto'] == 'temple' ){
$player->gotoRoom( 'temple', 'temple' );
}

$player->heal();

unset($player);

$r = $db->queryArray("SELECT * FROM ".SQL_PREFIX."online WHERE Room = 'wedding'");

require_once('_loader.php');

$tow_tpl->assignGlobal('db_config', $db_config);

$temp = & $tow_tpl->getDisplay('content', true);

$temp->assign( 'r',  $r );

//$temp->setCache('wedding', 60);

//if (!$temp->isCached()) {
$temp->addTemplate('wedding', 'timeofwars_loc_wedding.html');
//}

$show = & $tow_tpl->getDisplay('index');


$show->assign('title', 'Time Of Wars - зал венчаний');
$show->assign('Content', $temp);


$show->addTemplate('header', 'header.html');
$show->addTemplate('index' , 'index.html' );
$show->addTemplate('footer', 'footer.html');


$tow_tpl->display();
?>

