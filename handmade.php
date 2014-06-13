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
$player->checkRoom('handmade');

if(!empty($_GET['goto']) && $_GET['goto'] == 'land' ){
$player->gotoRoom( 'land', 'land' );
}

$player->heal();


$err                  = '';
@$buy                 = intval($_GET['buy']);


if (!empty($buy)) {
$dat = $db->queryRow("SELECT * FROM ".SQL_PREFIX."things_samodel WHERE Un_Id = '".$buy."' AND Otdel = '".intval($_SESSION['otd'])."' AND Id LIKE 'smith_%'");
if (!$dat) { $err = _SHOP_ERR1; }
elseif ( $dat['Cost'] > $player->Money ) { $err = _SHOP_ERR2; }
elseif ( $dat['Owner'] == $player->username ) { $err = 'Нельзя купить вещь у самого себя'; }
elseif ( @in_array($player->username, (array)$db->queryArray( "SELECT i.Username FROM ".SQL_PREFIX."ip as i LEFT JOIN ".SQL_PREFIX."players as p ON p.Username = '".$dat['Owner']."' WHERE i.Ip = p.Reg_IP" )) ){ $err = 'Нельзя купить вещь у своего мульта'; }
else {

$db->insert( SQL_PREFIX.'things',
Array(
'Owner' => $player->username, 'Id' => $dat['Id'], 'Thing_Name' => $dat['Thing_Name'],
'Slot' => $dat['Slot'], 'Cost' => 0, 'Level_need' => $dat['Level_need'], 'Stre_need' => $dat['Stre_need'],
'Agil_need' => $dat['Agil_need'], 'Intu_need' => $dat['Intu_need'], 'Endu_need' => $dat['Endu_need'],
'Stre_add' => $dat['Stre_add'], 'Agil_add' => $dat['Agil_add'], 'Intu_add' => $dat['Intu_add'], 'Endu_add' => $dat['Endu_add'],
'MINdamage' => $dat['MINdamage'], 'MAXdamage' => $dat['MAXdamage'], 'Crit' => $dat['Crit'],
'AntiCrit' => $dat['AntiCrit'], 'Uv' => $dat['Uv'], 'AntiUv' => $dat['AntiUv'], 'Armor1' => $dat['Armor1'],
'Armor2' => $dat['Armor2'], 'Armor3' => $dat['Armor3'], 'Armor4' => $dat['Armor4'],
'NOWwear' => $dat['NOWwear'], 'MAXwear' => $dat['MAXwear'], 'Wear_ON' => '0'
)
);

$db->execQuery( "DELETE FROM ".SQL_PREFIX."things_samodel WHERE Un_Id = '".$buy."' AND Owner = '".$dat['Owner']."' AND Otdel = '".intval($_SESSION['otd'])."' AND Id LIKE 'smith_%';" );
$db->update( SQL_PREFIX.'players', Array( 'Money' => '[-]'.$dat['Cost'] ), Array( 'Username' => $player->username ), 'maths' );
$db->update( SQL_PREFIX.'players', Array( 'Money' => '[+]'.$dat['Cost'] ), Array( 'Username' => $dat['Owner'] ), 'maths' );


$db->insert( SQL_PREFIX.'transfer', Array( 'Date' => date('Y-m-d'), 'From' => 'Маг самоделов', 'To' => $player->username, 'What' => 'купил самодел ID: '.$dat['Un_Id'].' у персонажа '.$dat['Owner'].' за '.$dat['Cost'].' кр. ('.date('H:i').')' ) );
$db->insert( SQL_PREFIX.'transfer', Array( 'Date' => date('Y-m-d'), 'From' => 'Маг самоделов', 'To' => $dat['Owner'], 'What' => 'Продал самодел ID: '.$dat['Un_Id'].' персонажу '.$player->username.' за '.$dat['Cost'].' кр. ('.date('H:i').')' ) );

$txt = '<i>Почта от <b> Самоделы </b> (послано '.date('d.m.y H:i').'):</i> Персонаж '.$player->username.' купил у вас '.$dat['Thing_Name'].' за '.$dat['Cost'].' кр.';
$db->insert( SQL_PREFIX.'messages', Array( 'Username' => $dat['Owner'], 'Text' => mysql_escape_string($txt) ) );


$err = sprintf(_SHOP_MSG1, $dat['Thing_Name'], $dat['Cost'], 'кр.');
$player->Money -= $dat['Cost'];

}


}

unset($buy);


require_once('_loader.php');

$tow_tpl->assignGlobal('db_config', $db_config);

$temp = & $tow_tpl->getDisplay('content', true);

$temp->assign( 'Money',   $player->Money );
$temp->assign( 'err',     $err     );

$temp->addTemplate('euroshop', 'timeofwars_loc_shop_samodel.html');


$show = & $tow_tpl->getDisplay('index');


$show->assign('title', 'Time Of Wars - заморская лавка');
$show->assign('Content', $temp);


$show->addTemplate('header', 'header.html');
$show->addTemplate('index' , 'index.html' );
$show->addTemplate('footer', 'footer.html');


$tow_tpl->display();
?>
