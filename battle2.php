<?
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

session_start();
if ( empty($_SESSION['login']) ) die( include('includes/bag_log_in.php') );
header('Content-type: text/html; charset=windows-1251');

include ('db.php');

include ('classes/PlayerBattle.php');
include ('includes/lib/php2js.php');

$player = new battle($_SESSION['login']);
$player->is_blocked();

$enemy  = new battle($player->Enemy);
$msg = '';

if( !empty($_GET['act']) && $_GET['act'] == 'load_enemy' )
{
	die( $enemy->load_enemy_visual() );
}
if( !empty($_GET['act']) && $_GET['act'] == 'update_hp' )
{
	$str1 = $player->hp_div();
	$str1_2 = $player->mana_div();

    $str2 = $enemy->hp_div();
    $str2_2 = $enemy->mana_div();

    if( $enemy->is_dead == 1 )
    {
    	$enemy->hp = 0;
    	$str2 = $enemy->hp_div();
    }

    if( $player->is_dead == 1 )
    {
    	$player->hp = 0;
    	$str1 = $player->hp_div();
    }

    if( !empty($enemy->Id) ) die(php2js( array( 'player_id' => $player->Id, 'player_hp' => $str1, 'player_mana' => $str1_2, 'enemy_id' => $enemy->Id, 'enemy_hp' => $str2, 'enemy_mana' => $str2_2  ) )); // отсылаем посредством магического json'a
}

$battle = $db->queryRow( "SELECT step, id FROM ".SQL_PREFIX."2battle WHERE (team1 LIKE '%".$player->Username.";%' OR team2 LIKE '%".$player->Username.";%') AND (status = 'during' OR status = 'completed') AND id = '".$player->battle_id."';" );
if( !$battle )
	die( header('Location: '.$_SESSION['userroom']) );

include ('includes/battle2/func_write_to_log.php');
include ('includes/battle2/write_to_xml.php');

$battle_log = new write_to_log($player->battle_id);

if( !empty($_GET['use_magic']) && is_numeric($_GET['use_magic']) && $_GET['use_magic'] > 0 )
{
	$target = '';
    $msg = '';

	if( !empty($_GET['target']) )
		 $target = mysql_real_escape_string(addslashes(htmlspecialchars($_GET['target'])));



	include ( 'includes/battle2/magic2.php' );

	if( $player->is_dead == 0 )
	{
	   $msg = magic( $_GET['use_magic'], $target, $player->battle_id, $battle['step'] );
	   $msg = iconv('windows-1251', 'UTF-8', $msg);
       echo $msg;
	}


    die;
}



include('_loader.php');

$tow_tpl->assignGlobal('db_config', $db_config);

$temp = & $tow_tpl->getDisplay('battle', true);


$temp->assign('log', $battle_log->read_log() );
$temp->assign('battle_log', $battle_log );
$temp->assign('player', $player);
$temp->assign('enemy', $enemy);

$temp->assign( 'hited', @$db->SQL_result($db->query("SELECT hited FROM ".SQL_PREFIX."2battle_action WHERE Username = '".$player->Username."' AND battle_id = '".$player->battle_id."';"),0,0) );

$temp->addTemplate('battle2_action', 'timeofwars_battle_action.html');


$show = & $tow_tpl->getDisplay('index');


$show->assign('title', 'Time Of Wars - битва');
$show->assign('Content', $temp);


$show->addTemplate('header', 'header.html');
$show->addTemplate('index' , 'index.html' );
$show->addTemplate('footer', 'footer.html');


$tow_tpl->display();

?>