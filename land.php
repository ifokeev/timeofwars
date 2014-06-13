<?
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

session_start();
if (empty($_SESSION['login'])) { include_once('includes/bag_log_in.php'); exit; }

include_once ('db_config.php');
include_once ('db.php');

include_once ('classes/PlayerInfo.php');

include_once 'mines.inc';

$player = new PlayerInfo();

$player->is_blocked();
$player->checkBattle();
$player->checkRoom('land');


$castle    = Array();


$castles = $db->queryArray("SELECT * FROM ".SQL_PREFIX."castles");
if( !empty($castles) ){foreach( $castles as $zam ){
$castle[] = $zam['zamok'];
}
}

if(!empty($_GET['goto']) && ( in_array( $_GET['goto'], $castle ) || $_GET['goto'] == 'pl' || $_GET['goto'] == 'map' || $_GET['goto'] == 'mines' || $_GET['goto'] == 'handmade' )  ){

if( $_GET['goto'] != 'pl' && $_GET['goto'] != 'map' && $_GET['goto'] != 'mines' && $_GET['goto'] != 'handmade'  ){
$player->gotoRoom( 'zamok', $_GET['goto'] );
} else {
if( $_GET['goto'] == 'map' || $_GET['goto'] == 'pl' || $_GET['goto'] == 'handmade'  || ($_GET['goto'] == 'mines' && $player->Level >= 5) ){$player->gotoRoom( $_GET['goto'], $_GET['goto'] );
}

}

}

$player->heal();
$player->checklevelup();




require_once('_loader.php');

$tow_tpl->assignGlobal('db_config', $db_config);

$temp =& $tow_tpl->getDisplay('content', true);

$temp->assign( 'user',  $player->username );
$temp->assign( 'castles',  $castles );
$temp->assign( 'gomines',  ( $player->Intl >= $needintel && $player->Intu >= $needminesint && $player->Level >= $needlevel ) ? true : false );

if( file_exists( $db_config[DREAM]['web_root'] . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'elka.dat' ) )
{
	$file = file_get_contents( $db_config[DREAM]['web_root'] . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'elka.dat' );
	if( $file == $player->Room ) $temp->assign( 'elka', true  );
}

/////раскомментировать/закомментировать при необходимости//кирка
/*$havekirka = 'scuko';
if( @$db->SQL_result($db->query( "SELECT Owner FROM ".SQL_PREFIX."things WHERE Owner = '".$player->username."' AND MagicID = '".$magicName."' AND Wear_ON = '1';")) )
{
	$havekirka = 1;
}
$temp->assign( 'havekirka', $havekirka  );*/
////конец условия


$temp->addTemplate('land', '_timeofwars_main_land.html');


$show =& $tow_tpl->getDisplay('index');


$show->assign('title', 'Time Of Wars - пригород');
$show->assign('Content', $temp);


$show->addTemplate('header', 'header.html');
$show->addTemplate('index' , 'index.html' );
$show->addTemplate('footer', 'footer.html');


$tow_tpl->display();
?>
