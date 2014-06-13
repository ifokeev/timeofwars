<?
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

session_start();
if ( empty($_SESSION['login']) )
	die( include('includes/bag_log_in.php') );


header( 'Content-type: text/html; charset=windows-1251;' );

require('db.php');
require 'includes/to_view.php';

require 'classes/ChatSendMessages.php';
require 'classes/PlayerInfo.php';

require 'classes/turnir.php';

include ('includes/turnir/func.php');


$player = new PlayerInfo();

$player->is_blocked();

if( !isset($_POST['dataload']) || (isset($_POST['dataload']) && $_POST['dataload'] != 'emptys' && $_POST['dataload'] != 'battles' && $_POST['dataload'] != 'things') )	$player->checkBattle();



$player->checkRoom('turnir_map');

$turnir_map = new turnir_map( $player->username, $player->user_id, $player->id_clan, $player->id_battle );
$msg = '';




include('includes/turnir/dataload.php');



$map     = file_get_contents( $db_config[DREAM]['web_root'] . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'turnir' . DIRECTORY_SEPARATOR . 'map.txt' );
$n_cages = explode( "\n", $map );
$n_cages = explode( ';', $n_cages[0] );
$cnt_n_cages = count($n_cages);


$map = str_replace("\n", ";", $map);
$map = split( ';', $map );

$rows = file( $db_config[DREAM]['web_root'] . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'turnir' . DIRECTORY_SEPARATOR . 'map.txt' );

$good_cage = array();

if( !empty($rows) )
{	$num = 0;
	foreach( $rows as $row )
	{		$cages = split( ';', $row );
		foreach( $cages as $cage )
		{			if( $map[$num] == 1 ) $good_cage[] = $num;
			$num++;
        }
   }
}


if( empty($turnir_map->coord) )
{
	shuffle($good_cage);
	$turnir_map->set_cage( $good_cage[0] );
	$turnir_map->update_to_middl_level();
	$turnir_map->insert_things();
}



if( $turnir_map->coord-$cnt_n_cages < 0 )
	$up_cages = 0;
else
	$up_cages = $cnt_n_cages;


if( $turnir_map->coord+$cnt_n_cages > count($map) )
    $down_cages = 0;
else
	$down_cages = $cnt_n_cages;


if( !empty( $turnir_map->end_move ) && $turnir_map->end_move - time() <= 0 )
{
	switch( $turnir_map->move_direction )
	{
		case 'top':    $new = $turnir_map->coord-$up_cages; break;
		case 'bottom': $new = $turnir_map->coord+$down_cages; break;
		case 'left':   $new = $turnir_map->coord-1; break;
		case 'right':  $new = $turnir_map->coord+1; break;
    }

    $turnir_map->set_cage($new);

}



$y = floor( $turnir_map->coord/$cnt_n_cages );
$x = $turnir_map->coord%$cnt_n_cages;


if( !empty($_GET['gobattle']) )	$msg = $turnir_map->go_battle_turnir( $_GET['gobattle'], $x, $y );


$img = $turnir_map->go_img( $cnt_n_cages, $map );

$emptys = $db->queryArray( "SELECT tu.user, tu.battle_id, p.Username, p.Level, p.ClanID, p.Align, p.BattleID FROM ".SQL_PREFIX."turnir as t INNER JOIN ".SQL_PREFIX."turnir_users as tu ON ( t.id = tu.turnir_id ) INNER JOIN ".SQL_PREFIX."players as p ON ( p.Username = tu.user ) WHERE tu.turnir_id = '".$turnir_map->turnir_id."' AND tu.coord = '".$turnir_map->coord."' AND tu.user <> '".$player->username."' AND t.status = '2';" );
$battles = $db->queryArray( "SELECT team1, team2, ba.id FROM ".SQL_PREFIX."2battle as ba INNER JOIN ".SQL_PREFIX."turnir_users as tu ON ( tu.battle_id = ba.id ) WHERE tu.turnir_id = '".$turnir_map->turnir_id."' AND tu.coord = '".$turnir_map->coord."' AND ba.status = 'during' GROUP BY ba.id;" );

$turnir_map->end_turnir_bug();

require('_loader.php');

$tow_tpl->assignGlobal('db_config', $db_config);

$temp = & $tow_tpl->getDisplay('content', true);


$temp->assign( 'msg',     $msg  );
$temp->assign( 'map',     $map  );
$temp->assign( 'rows',    $rows  );
$temp->assign( 'data',    $turnir_map  );

$temp->assign( 'emptys',  $emptys  );
$temp->assign( 'battles', $battles  );

$temp->assign( 'img',     $img  );
$temp->assign( 'x',       $x  );
$temp->assign( 'y',       $y  );


$temp->assign( 'turnir_end', $db->numrows( "SELECT user FROM ".SQL_PREFIX."turnir_users WHERE turnir_id = '".$turnir_map->turnir_id."';" )  );

$temp->assign( 'uid', $player->user_id );

$temp->addTemplate('port', 'timeofwars_loc_turnir_map.html');


$show = & $tow_tpl->getDisplay('index');


$show->assign('title', 'Time Of Wars - Сердце леса');
$show->assign('Content', $temp);


$show->addTemplate('header', 'header.html');
$show->addTemplate('index' , 'index.html' );
$show->addTemplate('footer', 'footer.html');


$tow_tpl->display();
?>