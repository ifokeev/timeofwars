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
$player->checkRoom('shop');

if(!empty($_GET['goto']) && $_GET['goto'] == 'pl' ){
$player->gotoRoom();
}

$player->heal();

if ($player->clanid == 200) { die(_chaosERR); }

$err         = '';
@$sale_thing = intval($_GET['sale_thing']);
@$sale       = $_POST['sale'];

if (!empty($sale_thing)) {
$arr = $db->queryRow("SELECT Un_Id, Thing_Name, Cost FROM ".SQL_PREFIX."things WHERE Wear_ON = '0' AND Un_Id = '$sale_thing' AND Owner = '$player->username' AND Slot < '13'");

if (!$arr) { $err = _SHOP_ERR5; }
elseif ( preg_match('/артефакт|клановая|именная|освящено элитно|ability/i', $arr['Thing_Name'])  ) { $err = _SHOP_ERR5; }
else {

$sale_cost = round($arr['Cost'] / 2);

$db->execQuery("DELETE FROM ".SQL_PREFIX."things WHERE Un_Id = '".$arr['Un_Id']."' AND Owner = '".$player->username."' AND Wear_ON = '0';");
$db->update( SQL_PREFIX.'players', Array( 'Money' => '[+]'.$sale_cost ), Array( 'Username' => $player->username ), 'maths' );
$db->insert( SQL_PREFIX.'transfer', Array( 'Date' => date('Y-m-d'), 'From' => $player->username, 'To' => 'Магазин', 'What' => 'Предмет '.$arr['Thing_Name'].' сдан в гос. магазин, уникальный ID '.$arr['Un_Id'].' ('.date('H:i').')' ) );


$err = sprintf(_SHOP_MSG2, $arr['Thing_Name'], $sale_cost, 'кр.');
$player->Money += $sale_cost;

}

$sale = 1;
}

unset($sale_thing);

$a = $db->queryArray("SELECT * FROM ".SQL_PREFIX."things WHERE Owner = '$player->username' AND Wear_ON = '0' AND Slot < '13'");

require_once('_loader.php');

$tow_tpl->assignGlobal('db_config', $db_config);

$temp = & $tow_tpl->getDisplay('content', true);

$temp->assign( 'bgcolor',    '#D5D5D5'   );
$temp->assign( 'player',     $player     );
$temp->assign( 'err',        $err        );
$temp->assign( 'a',          $a          );

$temp->addTemplate('shop', 'timeofwars_loc_shopsale.html');

$show = & $tow_tpl->getDisplay('index');

$show->assign('title', 'Time Of Wars - гос. магазин');
$show->assign('Content', $temp);


$show->addTemplate('header', 'header.html');
$show->addTemplate('index' , 'index.html' );
$show->addTemplate('footer', 'footer.html');


$tow_tpl->display();
?>
