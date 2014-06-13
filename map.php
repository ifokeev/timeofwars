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
$player->checkRoom('map');

if( empty($player->map_id) || $player->map_id == 0 || $player->map_id == '' )
	$player->map_id = 588;

if(!empty($_GET['goto']) && $_GET['goto'] == 'land' && ($player->map_id == 588 || $player->map_id == 589) )
	$player->gotoRoom( 'land', 'land' );


$player->heal();

$err = '';
@$id = intval($_GET['id']);

if( !empty($id) ){

list($x, $y) = $db->queryCheck("SELECT x, y FROM ".SQL_PREFIX."map WHERE id = '$id' LIMIT 1");


if( ($id == $player->map_id-1 || $id == $player->map_id+1 || $id == $player->map_id-50 || $id == $player->map_id-51 || $id == $player->map_id-52 || $id == $player->map_id+50 || $id == $player->map_id+51 || $id == $player->map_id+52) && ($x > 2 && $y > 1) ){
$db->update( SQL_PREFIX.'players', Array( 'map_id' => $id ), Array( 'Username' => $player->username ) );
}

header('Location: map.php?#map');
}

list($x, $y) = $db->queryCheck("SELECT x, y FROM ".SQL_PREFIX."map WHERE id = '$player->map_id' LIMIT 1");

$yy = $y-1;
$xx = $x-2;


@$target = speek_to_view($_POST['player']);

$dat     = $db->queryFetchArray("SELECT p.Username, p.Level, p.Align, p.ClanID, p.BattleID2 FROM ".SQL_PREFIX."players as p INNER JOIN ".SQL_PREFIX."online as o ON (o.Username = p.Username) WHERE p.Room = 'map' AND p.map_id = '$player->map_id' AND p.Username != '$player->username' AND o.Username = p.Username");


if ( !empty($target) ) {

if( !$tar = $db->queryCheck("SELECT p.Username, p.Level, p.HPnow, p.BattleID2, p.ClanID, p.map_id FROM ".SQL_PREFIX."players as p INNER JOIN ".SQL_PREFIX."online as o ON(o.Username = p.Username) WHERE p.Username = '$target' AND p.Username = o.Username") )  $err = 'Такого персонажа не существует, либо он не находится в игре';
elseif( $tar[2] <= 0 )          $err = 'Персонаж слишком слаб';
elseif( !empty($tar[3]) )       $err = 'Персонаж в бою';
elseif( $tar[5] != $player->map_id ) $err = 'Персонаж убежал с локации';
elseif( $player->HPnow <= ($player->HPall/2) )    $err = 'Вы слишком слабы. Восстановитесь.';
elseif( ($player->Level-$tar[1]) >= 3 && $player->username != 's!.')   $err = 'Невозможно напасть. Разница в уровнях должна быть не более 3.';
else{

$player->goBattle($tar[0]);

$db->insert( SQL_PREFIX.'messages',    Array( 'Username' => $player->username, 'Text' => 'Вы напали на <b> '.$tar[0].' </b>' ) );

if($tar[4] != 99){
$db->insert( SQL_PREFIX.'messages',    Array( 'Username' => $tar[0], 'Text' => 'Внимание! На вас напал <b> '.$player->username.' </b>!' ) );
}

//$db->update( SQL_PREFIX.'battle_id', Array( 'Id' => '[+]1' ), Array( 'Id' => $b_id ), 'maths' );

@header('Location: battle2.php');

exit;

//   первый else
}

}


require_once('_loader.php');

$tow_tpl->assignGlobal( 'db_config', $db_config );
$tow_tpl->assignGlobal( 'db',        $db        );

$temp = & $tow_tpl->getDisplay('content', true);

$temp->assign( 'HPnow',      $player->HPnow      );
$temp->assign( 'HPall',      $player->HPall      );
$temp->assign( 'map_id',     $player->map_id     );
$temp->assign( 'clanid',     $player->clanid     );
$temp->assign( 'username',   $player->username   );
$temp->assign( 'id_picture', $player->id_picture );

if( file_exists( $db_config[DREAM]['web_root'] . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'elka.dat' ) )
{
	$file = file_get_contents( $db_config[DREAM]['web_root'] . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'elka.dat' );
	if( $file == $player->Room ) $temp->assign( 'elka', true  );
}

$temp->assign( 'item',   $player->getItemsInfo( $player->username ) );


$temp->assign('xx',        $xx       );
$temp->assign('yy',        $yy       );
$temp->assign('x',         $x        );
$temp->assign('y',         $y        );


$temp->assign('err',       $err      );
$temp->assign('dat',       $dat      );

//$temp->setCache('map', 60);

//if (!$temp->isCached()) {
$temp->addTemplate('map', 'timeofwars_loc_map.html');
//}

$show = & $tow_tpl->getDisplay('index');


$show->assign('title', 'Time Of Wars - пригород');
$show->assign('Content', $temp);


$show->addTemplate('header', 'header.html');
$show->addTemplate('index' , 'index.html' );
$show->addTemplate('footer', 'footer.html');


$tow_tpl->display()
?>

