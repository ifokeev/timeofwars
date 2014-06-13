<?
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

session_start();
if (empty($_SESSION['login'])) { include_once('includes/bag_log_in.php'); exit; }

include_once ('db_config.php');
include_once ('db.php');

include_once ('classes/PlayerInfo.php');

$player = new PlayerInfo();

$player->is_blocked();
$player->checkBattle();
$player->checkRoom('repair');

if(!empty($_GET['goto']) && $_GET['goto'] == 'pl' ){
$player->gotoRoom();
}

$player->heal();

$msg   = '';
@$item = intval($_GET['item']);

if(!empty($_GET['item'])){
$data = $db->queryRow("SELECT * FROM ".SQL_PREFIX."things WHERE NOWwear != '0' AND Slot < '11' AND Wear_ON = '0' AND Owner = '$player->username'");
if($data){

if(!empty($_GET['reptype']) && $_GET['reptype'] == 1){

if($player->Money >= 0.1){

$db->execQuery("UPDATE ".SQL_PREFIX."things SET NOWwear = NOWwear - '1' WHERE Un_Id = '$item' AND Owner = '$player->username' AND NOWwear > '0' AND Slot < '11' AND Wear_ON = '0' LIMIT 1");
$db->update( SQL_PREFIX.'players', Array( 'Money' => '[-]0.1' ), Array( 'Username' => $player->username ), 'maths' );


$msg = sprintf(_REPAIR_msg1, $data['Thing_Name']);
$player->Money -= 0.1;

} else { $msg = _REPAIR_err1; }


} elseif (!empty($_GET['reptype']) && $_GET['reptype'] == 2){

if($player->Money >= $data['NOWwear'] * 0.1){

$db->execQuery("UPDATE ".SQL_PREFIX."things set NOWwear = '0' WHERE Un_Id = '$item' AND Owner = '$player->username' AND NOWwear > '0' AND Slot < '11' AND Wear_ON = '0' LIMIT 1");
$db->update( SQL_PREFIX.'players', Array( 'Money' => '[-]'.($data['NOWwear']*0.1) ), Array( 'Username' => $player->username ), 'maths' );

$msg = sprintf(_REPAIR_msg2, $data['Thing_Name']);
$player->Money -= $data['NOWwear'] * 0.1;

} else { $msg =_REPAIR_err1; }
} else { die("<script>top.location.href='index.php';</script>"); }
} else { $msg = _REPAIR_err2; }

}


$rep = array();

$res = mysql_query("SELECT * FROM ".SQL_PREFIX."things WHERE NOWwear <> '0' AND Slot < '11' AND Wear_ON = '0' AND Owner = '$player->username' AND (MagicID <> 'шахтёр' OR MagicID IS NULL) ORDER BY cost");
while($arr = mysql_fetch_assoc($res)){

if ($arr['Stre_need']) { $arr['Stre_need']  = sprintf(_forthings_sila, $arr['Stre_need']); } else {  $arr['Stre_need'] = false; }
if ($arr['Agil_need']) { $arr['Agil_need']  = sprintf(_forthings_lovkost,  $arr['Agil_need']); } else { $arr['Agil_need'] = false; }
if ($arr['Intu_need']) { $arr['Intu_need']  = sprintf(_forthings_inta, $arr['Intu_need']); } else { $arr['Intu_need'] = false; }
if ($arr['Endu_need']) { $arr['Endu_need']  = sprintf(_forthings_ENDUneed, $arr['Endu_need']); } else { $arr['Endu_need'] = false; }
if ($arr['Level_need']){ $arr['Level_need'] = sprintf(_forthings_level, $arr['Level_need']); } else { $arr['Level_need'] = false; }
if ($arr['Level_add']) { $arr['Level_add']  = sprintf(_forthings_level, $arr['Level_add']); } else { $arr['Level_add'] = false; }
if ($arr['MAXdamage']) { $arr['MAXdamage']  = sprintf(_forthings_ALLdmg, $arr['MINdamage'], $arr['MAXdamage']); } else { $arr['MAXdamage'] = false; }
if ($arr['Armor1']) {    $arr['Armor1']     = sprintf(_forthings_arm1, $arr['Armor1']); } else { $arr['Armor1'] = false; }
if ($arr['Armor2']) {    $arr['Armor2']     = sprintf(_forthings_arm2, $arr['Armor2']); } else { $arr['Armor2'] = false; }
if ($arr['Armor3']) {    $arr['Armor3']     = sprintf(_forthings_arm3, $arr['Armor3']); } else { $arr['Armor3'] = false; }
if ($arr['Armor4']) {    $arr['Armor4']     = sprintf(_forthings_arm4, $arr['Armor4']); } else { $arr['Armor4'] = false; }
if ($arr['Crit']) {      $arr['Crit']       = sprintf(_forthings_сrit, $arr['Crit'].'%'); } else { $arr['Crit'] = false; }
if ($arr['Uv']) {        $arr['Uv']         = sprintf(_forthings_uv, $arr['Uv'].'%'); } else { $arr['Uv'] = false; }
if ($arr['AntiCrit']) {  $arr['AntiCrit']   = sprintf(_forthings_Aсrit, $arr['AntiCrit'].'%'); } else { $arr['AntiCrit'] = false; }
if ($arr['AntiUv']) {    $arr['AntiUv']     = sprintf(_forthings_Auv, $arr['AntiUv'].'%'); } else { $arr['AntiUv'] = false; }
if ($arr['Stre_add']) {  $arr['Stre_add']   = sprintf(_forthings_sila, $arr['Stre_add']); } else { $arr['Stre_add'] = false; }
if ($arr['Agil_add']) {  $arr['Agil_add']   = sprintf(_forthings_lovkost, $arr['Agil_add']); } else { $arr['Agil_add'] = false; }
if ($arr['Intu_add']) {  $arr['Intu_add']   = sprintf(_forthings_inta, $arr['Intu_add']); } else { $arr['Intu_add'] = false; }
if ($arr['Endu_add']) {  $arr['Endu_add']   = sprintf(_forthings_endu, $arr['Endu_add']); } else { $arr['Endu_add'] = false; }
if ($arr['MagicID']) {   $arr['MagicID']    = sprintf(_forthings_magicID, $arr['MagicID']); } else { $arr['MagicID'] = false; }

$rep[$arr['Un_Id']] = array('img' => $arr['Id'], 'name' => $arr['Thing_Name'], 'cost' => $arr['Cost'], 'min' => $arr['NOWwear'], 'max' => $arr['MAXwear'], 'SNeed' => $arr['Stre_need'], 'ANeed' => $arr['Agil_need'], 'INeed' => $arr['Intu_need'], 'ENeed' => $arr['Endu_need'], 'LNeed' => $arr['Level_need'], 'LAdd' => $arr['Level_add'], 'DAdd_max' => $arr['MAXdamage'], 'DAdd_min' => $arr['MINdamage'], 'A1' => $arr['Armor1'], 'A2' => $arr['Armor2'], 'A3' => $arr['Armor3'], 'A4' => $arr['Armor4'], 'cr' => $arr['Crit'], 'uv' => $arr['Uv'], 'Acr' => $arr['AntiCrit'], 'Auv' => $arr['AntiUv'], 'Sadd' => $arr['Stre_add'], 'Aadd' => $arr['Agil_add'], 'Iadd' => $arr['Intu_add'], 'Eadd' => $arr['Endu_add'], 'M_ID' => $arr['MagicID']);

}

require_once('_loader.php');

$tow_tpl->assignGlobal('db_config', $db_config);

$temp = & $tow_tpl->getDisplay('content', true);

$temp->assign( 'bgcolor', '#D5D5D5'      );
$temp->assign( 'Money',   $player->Money );
$temp->assign( 'rep',     $rep           );
$temp->assign( 'msg',     $msg           );

if( file_exists( $db_config[DREAM]['web_root'] . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'elka.dat' ) )
{
	$file = file_get_contents( $db_config[DREAM]['web_root'] . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'elka.dat' );
	if( $file == $player->Room ) $temp->assign( 'elka', true  );
}

//$temp->setCache('repair', 60);

//if (!$temp->isCached()) {
$temp->addTemplate('repair', 'timeofwars_loc_repair.html');
//}

$show = & $tow_tpl->getDisplay('index');


$show->assign('title', 'Time Of Wars - ремонтная мастерская');
$show->assign('Content', $temp);


$show->addTemplate('header', 'header.html');
$show->addTemplate('index' , 'index.html' );
$show->addTemplate('footer', 'footer.html');


$tow_tpl->display();
?>
