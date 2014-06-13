<?
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

session_start();
if (empty($_SESSION['login'])) { include_once('includes/bag_log_in.php'); exit; }

include_once ('db_config.php');
include_once ('db.php');

include_once ('classes/PlayerInfo.php');

$player = new PlayerInfo();


require_once('_loader.php');

$tow_tpl->assignGlobal('db_config', $db_config);

$temp =& $tow_tpl->getDisplay('content', true);

$temp->assign( 'id', $player->user_id );
//$temp->setCache('sms_info', 86400);

//if (!$temp->isCached()) {
$temp->addTemplate('sms_info', 'timeofwars_sms_info.html');
//}

$show =& $tow_tpl->getDisplay('index');


$show->assign('title', 'Time Of Wars - SMS-сервис');
$show->assign('Content', $temp);


$show->addTemplate('header', 'header_noframes.html');
$show->addTemplate('index' , 'index.html' );
$show->addTemplate('footer', 'footer.html');


$tow_tpl->display();
?>
