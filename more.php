<?
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

session_start();
if (empty($_SESSION['login'])) { include_once('includes/bag_log_in.php'); exit; }
header( 'Content-type: text/html; charset=windows-1251;' );
include_once ('includes/to_view.php');
include_once ('db_config.php');
include_once ('db.php');

include_once ('classes/PlayerInfo.php');

$player = new PlayerInfo();

$player->is_blocked();
$player->checkBattle();
$player->checkRoom('more');



if( !$more = $db->queryRow( "SELECT * FROM ".SQL_PREFIX."more_players WHERE user_id = '".$player->user_id."';" ) )
{	die( 'Хакин хакин ай лю лю' );}




if(!empty($_GET['goto']) && $_GET['goto'] == 'port' && $more['coords'] == 717 ){
$player->gotoRoom( 'port', 'port' );
}



$player->heal();

$msg = '';
if( !empty($_POST['act']) && $_POST['act'] == 'storm' )
{	$db->update( SQL_PREFIX.'more_players',
	Array(
	'coords' => $db->SQL_result($db->query( "SELECT id FROM ".SQL_PREFIX."more ORDER BY RAND();")),
	'end_fishing' => 0,
	'end_move' => time()+60,
	),
	Array( 'user_id' => $player->user_id )
	);
}




if( !file_exists( $db_config[DREAM]['web_root'].'/cache/more/coords.txt' ) )
{	touch( $db_config[DREAM]['web_root'].'/cache/more/coords.txt' );
    @chmod( $db_config[DREAM]['web_root'].'/cache/more/coords.txt', 0666);	file_put_contents( $db_config[DREAM]['web_root'].'/cache/more/coords.txt',
	implode( "\r\n", array_rand( $db->queryArray( "SELECT id FROM ".SQL_PREFIX."more;" ), 15 ) )."\r\n".time()
	 );
}


$work = array();

$new_coords = file( $db_config[DREAM]['web_root'].'/cache/more/coords.txt' );
if( !empty( $new_coords ) )
{	foreach( $new_coords as $k => $coord )
	{
		if( $coord == end($new_coords) )
		{			$time = $coord;
		}
		else
		{		    $work[] = $db->SQL_result( $db->query("SELECT id FROM ".SQL_PREFIX."more;"), $coord );
        }
    }

    if( $time+300 < time() ) unlink( $db_config[DREAM]['web_root'].'/cache/more/coords.txt' );

}


//$work = Array( 701, 711, 713, 720, 728, 734, 741, 745 );





$more = $db->queryRow( "SELECT * FROM ".SQL_PREFIX."more_players WHERE user_id = '".$player->user_id."';" );

if( $player->id_clan == 255 )
{
	$more['udochka'] = 0.1;
	$more['lodka'] = 0.1;

}

if( !empty($_GET['work']) && $_GET['work'] == 1 && in_array( $more['coords'], $work ) )
{
	$db->update( SQL_PREFIX.'more_players', Array( 'end_fishing' => (time()+$more['udochka']*10) ), Array( 'user_id' => $player->user_id ) );
	//$more['end_fishing'] = (time()+$more['udochka']*10);

}

if( !empty($more['end_fishing']) && $more['end_fishing'] <= time() && $more['last_coord_fish'] <> $more['coords'] )
{	if( mt_rand( 0,100 ) >= 60 )
	{		$db->update( SQL_PREFIX.'more_players', Array( 'end_fishing' => 0, 'last_coord_fish' => $more['coords'] ), Array( 'user_id' => $player->user_id ) );
        $fish = Array(
        0 => Array( 'name' => 'Белуга', 'cost' => 1, 'id' => 'beluga' ),
        1 => Array( 'name' => 'Ёрш', 'cost' => 1, 'id' => 'ersh' ),
        2 => Array( 'name' => 'Карась', 'cost' => 1, 'id' => 'karas' ),
        3 => Array( 'name' => 'Лещ', 'cost' => 1, 'id' => 'lesh' ),
        4 => Array( 'name' => 'Окунь', 'cost' => 1, 'id' => 'okun' ),
        5 => Array( 'name' => 'Плотва', 'cost' => 1, 'id' => 'plotva' ),
        );

        shuffle($fish);

        if (!$db->numrows("SELECT * FROM `".SQL_PREFIX."things` WHERE Owner = '$player->username' AND Id = 'fish/".$fish[0]['id']."'"))
        {        	$db->insert( SQL_PREFIX.'things', Array( 'Owner' => $player->username, 'Id' => 'fish/'.$fish[0]['id'], 'Thing_Name' => $fish[0]['name'], 'Slot' => 15, 'Cost' => '1', 'Count' => '1', 'NOWwear' => '0', 'MAXwear' => '1' ) );
        }
        else
        {        	$db->execQuery("UPDATE `".SQL_PREFIX."things` SET Count = Count + '1' WHERE Owner = '$player->username' AND Id = 'fish/".$fish[0]['id']."'");
        }

        $msg = 'Вы только что нашли "'.$fish[0]['name'].'"! Однако, молодец :-).';
    }
    else
    {    	$db->update( SQL_PREFIX.'more_players', Array( 'end_fishing' => 0, 'last_coord_fish' => $more['coords'] ), Array( 'user_id' => $player->user_id ) );
        $msg = 'Вы ничего не поймали :-(';
    }

}

switch( @$_GET['goin'] )
{
	case 'top':
    $new_coord = @$db->SQL_result($db->query("SELECT top_id FROM ".SQL_PREFIX."more WHERE id = '".intval($more['coords'])."';"));
    if( !empty($new_coord) ) $db->update( SQL_PREFIX.'more_players', Array( 'coords' => $new_coord, 'end_move' => (time()+$more['lodka']*10) ), Array( 'user_id' => $player->user_id ) );
	break;


	case 'bottom':
    $new_coord = @$db->SQL_result($db->query("SELECT bottom_id FROM ".SQL_PREFIX."more WHERE id = '".intval($more['coords'])."';"));
    if( !empty($new_coord) ) $db->update( SQL_PREFIX.'more_players', Array( 'coords' => $new_coord, 'end_move' => (time()+$more['lodka']*10) ), Array( 'user_id' => $player->user_id ) );
	break;


	case 'left':
    $new_coord = @$db->SQL_result($db->query("SELECT left_id FROM ".SQL_PREFIX."more WHERE id = '".intval($more['coords'])."';"));
    if( !empty($new_coord) ) $db->update( SQL_PREFIX.'more_players', Array( 'coords' => $new_coord, 'end_move' => (time()+$more['lodka']*10) ), Array( 'user_id' => $player->user_id ) );
	break;


	case 'right':
    $new_coord = @$db->SQL_result($db->query("SELECT right_id FROM ".SQL_PREFIX."more WHERE id = '".intval($more['coords'])."';"));
    if( !empty($new_coord) ) $db->update( SQL_PREFIX.'more_players', Array( 'coords' => $new_coord, 'end_move' => (time()+$more['lodka']*10) ), Array( 'user_id' => $player->user_id ) );
	break;


}


require_once('_loader.php');

$tow_tpl->assignGlobal('db_config', $db_config);

$temp = & $tow_tpl->getDisplay('content', true);


$temp->assign( 'msg', $msg  );
$temp->assign( 'work', $work  );
$temp->assign( 'more', $db->queryRow( "SELECT mp.*, m.* FROM ".SQL_PREFIX."more_players as mp LEFT JOIN ".SQL_PREFIX."more as m ON( m.id = mp.coords ) WHERE mp.user_id = '".$player->user_id."';" )  );


$temp->addTemplate('port', 'timeofwars_loc_more.html');


$show = & $tow_tpl->getDisplay('index');


$show->assign('title', 'Time Of Wars - Море');
$show->assign('Content', $temp);


$show->addTemplate('header', 'header.html');
$show->addTemplate('index' , 'index.html' );
$show->addTemplate('footer', 'footer.html');


$tow_tpl->display();
?>
