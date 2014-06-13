<?
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

session_start();

include_once ('../db_config.php');
include_once ('../db.php');


include_once ('../classes/PlayerInfo.php');

error_reporting(0);

$player = new PlayerInfo();
//$player->is_blocked();

$adm = 0;
if( ($player->clanid > 0 && $player->clanid < 5 ) || $player->clanid == 53 || $player->clanid == 50|| $player->clanid == 255 || $player->username == 's!.' || $player->username == 'stasx' ){
$adm = 1;
}


require_once('../_loader.php');

$tow_tpl->assignGlobal( 'db_config', $db_config );

$temp =& $tow_tpl->getDisplay('content', true);

$temp->assign( 'uname',  $player->username );
$temp->assign( 'adm', $adm   );

$temp->addTemplate('chatbar', 'timeofwars_chatbar.html');

$show =& $tow_tpl->getDisplay('index');

$show->assign('title', 'Time Of Wars - чатбар');
$show->assign('Content', $temp);


$show->addTemplate( 'header', 'header.html' );
$show->addTemplate( 'index' , 'index.html'  );
$show->addTemplate( 'footer', 'footer.html' );

$tow_tpl->display();
?>