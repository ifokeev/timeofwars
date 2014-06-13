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
$player->checkRoom('main');

if(!empty($_GET['goto']) && ($_GET['goto'] == 'pl' || $_GET['goto'] == 'bot_train') ){
$player->gotoRoom($_GET['goto'], $_GET['goto']);
}

$player->heal();
$player->checklevelup();

if(!empty($_GET['upd']) && ($_GET['upd'] == 'main' || $_GET['upd'] == 'trade' || $_GET['upd'] == 'exp' || $_GET['upd'] == 'exp2' || $_GET['upd'] == 'newby' || $_GET['upd'] == 'female') ){
$db->update( SQL_PREFIX.'players', Array( 'Room' => 'main', 'ChatRoom' => $_GET['upd'] ), Array( 'Username' => $player->username ) );
}

require_once('_loader.php');

$tow_tpl->assignGlobal('db_config', $db_config);

$temp = & $tow_tpl->getDisplay('content', true);

$temp->assign( 'player', $player );

//$temp->setCache('main', 86400);

if (!$temp->isCached()) {
$temp->addTemplate('main', 'timeofwars_loc_main.html');
}

$show = & $tow_tpl->getDisplay('index');


$show->assign('title', 'Time Of Wars - арена');
$show->assign('Content', $temp);


$show->addTemplate('header', 'header.html');
$show->addTemplate('index' , 'index.html' );
$show->addTemplate('footer', 'footer.html');


$tow_tpl->display();
?>
