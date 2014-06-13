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

$adm_status = 0;
if ($player->username == 's!.'){ $adm_status = 1; }


if ($player->clanid == 200) { die(_chaosERR); }

$err         = '';
@$buy        = preg_replace('/[^a-zA-Z0-9\_\-]/', '', $_GET['buy']);
@$otdel      = intval($_GET['otdel']);
@$sale_thing = intval($_GET['sale_thing']);
@$adm_add    = intval($_GET['adm_add']);
@$sale       = $_POST['sale'];


if ( (!empty($otdel) && $otdel > 20) && $player->username != 's!.') { exit; }

if (!empty($buy)) {

$arr = $db->queryRow("SELECT * FROM ".SQL_PREFIX."things_shop WHERE Amount != '0' AND Id = '$buy'");

if (!$arr) { $err = _SHOP_ERR1; }
elseif ($arr['Cost'] > $player->Money){ $err = _SHOP_ERR2; }
elseif (($arr['Clan_need'] != $player->clanid) && ($arr['Clan_need'] != '0') && ($arr['Clan_need'] != '')) { $err = _SHOP_ERR3; }
else {

$db->insert( SQL_PREFIX.'things',
Array(
'Owner' => $player->username, 'Id' => $arr['Id'], 'Thing_Name' => $arr['Thing_Name'],
'Slot' => $arr['Slot'], 'Cost' => $arr['Cost'], 'Level_need' => $arr['Level_need'], 'Stre_need' => $arr['Stre_need'],
'Agil_need' => $arr['Agil_need'], 'Intu_need' => $arr['Intu_need'], 'Endu_need' => $arr['Endu_need'],
'Clan_need' => $arr['Clan_need'], 'Level_add' => $arr['Level_add'],  'Stre_add' => $arr['Stre_add'],
'Agil_add' => $arr['Agil_add'], 'Intu_add' => $arr['Intu_add'], 'Endu_add' => $arr['Endu_add'],
'MINdamage' => $arr['MINdamage'], 'MAXdamage' => $arr['MAXdamage'], 'Crit' => $arr['Crit'],
'AntiCrit' => $arr['AntiCrit'], 'Uv' => $arr['Uv'], 'AntiUv' => $arr['AntiUv'], 'Armor1' => $arr['Armor1'],
'Armor2' => $arr['Armor2'], 'Armor3' => $arr['Armor3'], 'Armor4' => $arr['Armor4'], 'MagicID' => $arr['MagicID'],
'NOWwear' => $arr['NOWwear'], 'MAXwear' => $arr['MAXwear'], 'Wear_ON' => '0', 'Srab' => $arr['Srab']
), 'query'
);

$db->insert( SQL_PREFIX.'transfer', Array( 'Date' => date('Y-m-d'), 'From' => 'Магазин', 'To' => $player->username, 'What' => 'Предмет '.$arr['Thing_Name'].' куплен в гос. магазине, уникальный ID '.$db->insertId().' ('.date('H:i').')' ) );

$db->update( SQL_PREFIX.'things_shop', Array( 'Amount' => '[-]1' ), Array( 'Id' => $buy ), 'maths' );
$db->update( SQL_PREFIX.'players', Array( 'Money' => '[-]'.$arr['Cost'] ), Array( 'Username' => $player->username ), 'maths' );

$err = sprintf(_SHOP_MSG1, $arr['Thing_Name'], $arr['Cost'], 'кр.');
$player->Money -= $arr['Cost'];

}

}

unset($buy);

if ( (!empty($adm_add) && is_numeric($adm_add)) && $player->username == 's!.') {
$db->update( SQL_PREFIX.'things_shop', Array( 'Amount' => intval($adm_add) ), Array( 'Amount' => '0' ) );
$err = 'Успешно завезено по '.$adm_add.' предметов';
}

unset($adm_add);


require_once('_loader.php');

$tow_tpl->assignGlobal('db_config', $db_config);

$temp = & $tow_tpl->getDisplay('content', true);


$temp->assign( 'adm_status', $adm_status );
$temp->assign( 'bgcolor',    '#D5D5D5'   );
$temp->assign( 'otdel',      $otdel      );
$temp->assign( 'player',     $player     );
$temp->assign( 'sale',       $sale       );
$temp->assign( 'err',        $err        );

if( file_exists( $db_config[DREAM]['web_root'] . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'elka.dat' ) )
{
	$file = file_get_contents( $db_config[DREAM]['web_root'] . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'elka.dat' );
	if( $file == $player->Room ) $temp->assign( 'elka', true  );
}

$temp->addTemplate('shop', 'timeofwars_loc_shop.html');


$show = & $tow_tpl->getDisplay('index');


$show->assign('title', 'Time Of Wars - гос. магазин');
$show->assign('Content', $temp);


$show->addTemplate('header', 'header.html');
$show->addTemplate('index' , 'index.html' );
$show->addTemplate('footer', 'footer.html');


$tow_tpl->display();
?>
