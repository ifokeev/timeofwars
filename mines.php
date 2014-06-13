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
$player->checkRoom('mines');

if(!empty($_GET['goto']) && ($_GET['goto'] == 'land' || $_GET['goto'] == 'smith') ){
$player->gotoRoom( $_GET['goto'], $_GET['goto'] );
}

require_once('_loader.php');

$tow_tpl->assignGlobal('db_config', $db_config);

$temp =& $tow_tpl->getDisplay('content', true);

$temp->addTemplate('land', 'timeofwars_loc_mines.html');


$show =& $tow_tpl->getDisplay('index');


$show->assign('title', 'Time Of Wars - шахта');
$show->assign('Content', $temp);


$show->addTemplate('header', 'header.html');
$show->addTemplate('index' , 'index.html' );
$show->addTemplate('footer', 'footer.html');


$tow_tpl->display();
?>