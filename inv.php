<?
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

session_start();
if (empty($_SESSION['login'])) { include_once('includes/bag_log_in.php'); exit; }

include_once ('db_config.php');
include_once ('db.php');
include_once ('chat/func_chat.php');

include_once ('classes/PlayerInfo.php');
include_once ('classes/ChatSendMessages.php');

$player = new PlayerInfo();

$player->is_blocked();
$player->checkBattle();

$part = isset($_GET['part']) ? $_GET['part'] : ( isset($_GET['part']) ? $_GET['part'] : $_SESSION['part'] );
$_SESSION['part'] = $part;

$view = !isset($_GET['view']) && !isset($_SESSION['view']) ? 1 : (isset($_GET['view']) ? $_GET['view'] : ( isset($_GET['view']) ? $_GET['view'] : $_SESSION['view'] ));
$_SESSION['view'] = $view;

include_once ('includes/to_view.php');

$msg                 = array();
$err                 = '';
@$wear_down          = speek_to_view($_GET['wear_down']);
@$wear               = speek_to_view($_GET['wear']);
@$ring_slot          = intval($_GET['ring_slot']);
@$drop               = speek_to_view($_GET['drop']);
@$use                = speek_to_view($_GET['use']);
@$target             = speek_to_view($_GET['target']);
@$_GET['battleid']   = intval($_GET['battleid']);
@$givetravu          = intval($_GET['givetravu']);


$botAll = array('ЛамоБот'/*, 'EasyBOT', 'Учитель'*/);

$tow_bots = array();
$res = $db->queryArray("SELECT Username FROM ".SQL_PREFIX."players WHERE Reg_Ip = 'бот' AND Username != 'ЛамоБот'");
if(!empty($res)){
foreach($res as $v){
$tow_bots[] = $v['Username'];
}
}



$item = $player->getItemsInfo( $player->username );


$turnir_id = @$db->SQL_result($db->query( "SELECT turnir_id FROM ".SQL_PREFIX."turnir_users WHERE user = '".$player->username."';"),0);


if( !empty($_GET['undress']) && $_GET['undress'] == 'all' ){
for( $i = 0; $i < 11; $i++ ){

if( $item['Slot'][$i] != 'empt'.$i )
{
	$err  = $player->unwear( $item['Slot_id'][$i] );
	$un_w = true;
}

}

if( $un_w != true ){ $err = 'Все вещи уже сняты'; }

}


if( !empty($_GET['complect']) && $_GET['complect'] == 'save' && !$turnir_id ){$row =
$item['Slot_id'][0].';'.$item['Slot_id'][1].';'.$item['Slot_id'][2].';'.$item['Slot_id'][3].';'.$item['Slot_id'][4].';'.
$item['Slot_id'][5].';'.$item['Slot_id'][6].';'.$item['Slot_id'][7].';'.$item['Slot_id'][8].';'.$item['Slot_id'][9].';'.
$item['Slot_id'][10].';';

$db->execQuery("INSERT INTO `".SQL_PREFIX."things_komplekt` (Username, slot_thing) VALUES ('".$player->username."', '".$row."') ON DUPLICATE KEY UPDATE slot_thing = '".$row."'");
$err = 'Комплект сохранен';
}


if( !empty($_GET['complect']) && $_GET['complect'] == 'load' && !$turnir_id ){$slot_th = @$db->SQL_result($db->query("SELECT slot_thing FROM ".SQL_PREFIX."things_komplekt WHERE Username = '".$player->username."'"),0,0);
$slot    = split( ';', $slot_th );

for( $i = 0; $i < 11; $i++ )
{	if( $slot[$i] > 0 )
	{		$msg[] = $player->wear( $slot[$i] );
    }
}
}



$chat = new ChatSendMessages( $player->username, $player->ChatRoom );

$woodc = $db->queryRow("SELECT * FROM `".SQL_PREFIX."wood_g` WHERE persid = '".$_SESSION['id_user']."'");


include_once('includes/inv/stats_up.php');
include_once('includes/inv/wear.php');
include_once('includes/inv/wear_down.php');
include_once('includes/inv/give.php');
include_once('includes/inv/givetravu.php');
include_once('includes/inv/transfer.php');
include_once('includes/inv/use.php');
include_once('includes/inv/drop.php');
include_once('includes/inv/TRANSFERBLOCK.php');
include_once('includes/inv/lock_unlock.php');
include_once('includes/inv/use_recept.php');
include_once('includes/inv/use_elik.php');


$sum = $db->fetch_array("SELECT sum(Stre_add) as Stre_add, sum(Agil_add) as Agil_add, sum(Intu_add) as Intu_add, sum(Endu_add) as Endu_add, sum(Armor1) as Armor1, sum(Armor2) as Armor2, sum(Armor3) as Armor3, sum(Armor4) as Armor4, sum(Crit) as Crit, sum(AntiCrit) as ACrit, sum(Uv) as Uvorot, sum(AntiUv) as AUvorot, sum(MINdamage) as SumMINdamage, sum(MAXdamage) as SumMAXdamage FROM ".SQL_PREFIX."things WHERE Owner = '$player->username' &&  Wear_ON = '1'");
if(empty($sum['Stre_add'])){$sum['Stre_add'] = 0; } if(empty($sum['Agil_add'])){ $sum['Agil_add'] = 0; } if(empty($sum['Intu_add'])){ $sum['Intu_add'] = 0; } if(empty($sum['Endu_add'])){ $sum['Endu_add'] = 0; } if(empty($sum['Armor1'])){ $sum['Armor1'] = 0; } if(empty($sum['Armor2'])){ $sum['Armor2'] = 0; } if(empty($sum['Armor3'])){ $sum['Armor3'] = 0; } if(empty($sum['Armor4'])){ $sum['Armor4'] = 0; } if(empty($sum['Crit'])){ $sum['Crit'] = 0; } if(empty($sum['ACrit'])){ $sum['ACrit'] = 0; } if(empty($sum['AUvorot'])){ $sum['AUvorot'] = 0; } if(empty($sum['Uvorot'])){ $sum['Uvorot'] = 0; } if(empty($sum['SumMINdamage'])){ $sum['SumMINdamage'] = 0; } if(empty($sum['SumMAXdamage'])){ $sum['SumMAXdamage'] = 0; }



$player =& new PlayerInfo();
$item   =& $player->getItemsInfo( $player->username );

if( $turnir_id )
{	$next_exp = 99999999999;	$part1 = $db->queryArray( "SELECT t.* FROM ".SQL_PREFIX."turnir_things as th LEFT JOIN ".SQL_PREFIX."things as t ON (th.in_use = t.Un_Id) WHERE t.Owner = '$player->username' AND t.Wear_ON = '0';" );
    $part2 = array();
    $part3 = array();
    $part4 = array();
}
else
{	$next_exp = $player->checklevelup();	$player->heal();	$part1 = $db->queryArray("SELECT * FROM ".SQL_PREFIX."things WHERE Owner = '$player->username' AND Wear_ON = '0' AND Slot BETWEEN '0' AND '10' ORDER BY Thing_Name");
	$part2 = $db->queryArray("SELECT * FROM ".SQL_PREFIX."things WHERE Owner = '$player->username' AND Wear_ON = '0' AND (Slot = '12' OR Slot = '11')");
	$part3 = $db->queryArray("SELECT * FROM ".SQL_PREFIX."things WHERE Owner = '$player->username' AND (Slot = '13' OR Slot = '15' OR Slot = '16') ORDER BY Slot DESC");
	$part4 = $db->queryArray("SELECT * FROM ".SQL_PREFIX."things_lock WHERE Owner = '$player->username' AND Wear_ON = '0' ORDER BY Thing_Name");
}

if( empty($err) && !empty($msg) ){ $err = implode( "\n<br />\n", $msg ); }

require_once('_loader.php');

$tow_tpl->assignGlobal( 'db_config', $db_config );
$tow_tpl->assignGlobal( 'db',        $db        );

$temp = & $tow_tpl->getDisplay('content', true);

$temp->assign( 'player', $player );
$temp->assign( 'sum',    $sum    );
$temp->assign( 'err',    $err    );
$temp->assign( 'part',   $part   );
$temp->assign( 'view',   $view   );

$temp->assign( 'part1',  $part1   );
$temp->assign( 'part2',  $part2   );
$temp->assign( 'part3',  $part3   );
$temp->assign( 'part4',  $part4   );

$temp->assign( 'a',      '0'       );
$temp->assign( 'vesh',   '0'       );
$temp->assign( 'color',  '#D5D5D5' );
$temp->assign( 'item',    $item    );
$temp->assign( 'next_exp', $next_exp );

//$temp->setCache('inv', 60);

//if (!$temp->isCached()) {
$temp->addTemplate('inv', 'timeofwars_func_inv.html');
//}

$show = & $tow_tpl->getDisplay('index');


$show->assign('title', 'Time Of Wars - инвентарь персонажа');
$show->assign('Content', $temp);


$show->addTemplate('header', 'header.html');
$show->addTemplate('index' , 'index.html' );
$show->addTemplate('footer', 'footer.html');


$tow_tpl->display();
?>
