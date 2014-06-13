<?php
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

session_start();

include_once ('../db_config.php');
include_once ('../db.php');
include_once ('../classes/PlayerInfo.php');
include_once ('../includes/to_view.php');

require_once 'JsHttpRequest.php';

$JsHttpRequest =& new JsHttpRequest("windows-1251");


if( !empty($_POST['q']) )
{
@$otdel = intval($_POST['q']);
$_SESSION['otd'] = $otdel;

if(empty($otdel)){ die; }

switch( $otdel ){
case 1:      $otn = _EUROSHOP_otdel1;    break;
case 2:      $otn = _EUROSHOP_otdel2;    break;
case 3:      $otn = _EUROSHOP_otdel3;    break;
default:     $otn = _EUROSHOP_otdel1;    break;
}



if( !$db->numrows( "SELECT * FROM ".SQL_PREFIX."smith WHERE Player = '".filter($_SESSION['login'])."';" ) )
{
		$db->insert( SQL_PREFIX.'smith', Array( 'Player' => filter($_SESSION['login']) ) );
}



$out = $db->queryArray("SELECT sm.*, COUNT(ts.Un_Id) as cnt FROM `".SQL_PREFIX."things_samodel` as ts, `".SQL_PREFIX."smith` as sm WHERE ts.Otdel = '$otdel' AND ts.Owner = sm.Player GROUP BY ts.Owner ORDER BY sm.Exp DESC, ts.Cost");

$GLOBALS['_RESULT'] = array(
  "otdname" => $otn
);

$bgcolor = '#D5D5D5';
?>
<table width="100%" cellspacing="1" cellpadding="2" bgcolor="#A5A5A5">
<? if ( !empty($out) ):  ?>
<? foreach ( $out as $v ):  ?>
<?
$exp  = ( (max(1, $v['Exp']) ) / 450);
$level = floor( Log10($exp)/Log10(2.3) );
$level++;
if ($level<0){$level=0;}
$player = new PlayerInfo($v['Player']);
?>
<? if ($bgcolor == '#C7C7C7'): $bgcolor = '#D5D5D5'; elseif($bgcolor == '#D5D5D5'): $bgcolor = '#C7C7C7'; endif;  ?>
 <tr bgcolor="<?=$bgcolor;?>">
  <td align="center">
   <a href="javascript:showcom('<?=$v['Player'];?>');">Посмотреть</a>
  </td>
  <td valign="top">
  Кузнец: <? if( !empty($player->clanid) ): ?><a href="top5.php?show=<?=$player->clanid;?>"><img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/clan/<?=$player->clanid;?>.gif" /></a><? endif; ?><a href="javascript:top.AddToPrivate('<?=$player->username;?>', true)"><?=$player->username;?></a> [<?=$player->Level;?>] <a href="inf.php?uname=<?=$player->username;?>" target="_blank"><img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/inf.gif" width="12px" height="12px" title="info <?=$player->username;?>" /></a><br />
  Товаров: <?=$v['cnt'];?><br />
  Уровень кузнеца: <?=$level;?>

  </td>
 </tr>
<? endforeach; ?>
<?  else: ?>
 <tr><td bgcolor="#e2e0e0" align="center"><?=_SHOP_MSG4;?></td></tr>
<? endif; ?>
</table>
<?
}
elseif( !empty( $_POST['user'] ) )
{	$out = $db->queryArray("SELECT * FROM `".SQL_PREFIX."things_samodel` WHERE Otdel = '".intval($_SESSION['otd'])."' AND Owner = '".filter($_POST['user'])."' ORDER BY Cost");
    $bgcolor = '#D5D5D5';

    $player = new PlayerInfo();
?>
<table width="100%" cellspacing="1" cellpadding="2" bgcolor="#A5A5A5">
<? if ( !empty($out) ):  ?>
<? foreach ( $out as $v ):  ?>
<? if ($bgcolor == '#C7C7C7'): $bgcolor = '#D5D5D5'; elseif($bgcolor == '#D5D5D5'): $bgcolor = '#C7C7C7'; endif;  ?>
<?
if ($v['Cost'] > $player->Money) { $v['Cost'] = '<font color="red">'.$v['Cost'].'</font>'; }
if ($v['Level_need']){ if ($v['Level_need'] > $player->Level) { $v['Level_need'] = '<font color="red"><b>'.$v['Level_need'].'</b></font>'; }  }
if ($v['Stre_need']) { if ($v['Stre_need'] > $player->Stre) {   $v['Stre_need']  = '<font color="red"><b>'.$v['Stre_need'].'</b></font>'; } }
if ($v['Agil_need']) { if ($v['Agil_need'] > $player->Agil) {   $v['Agil_need']  = '<font color="red"><b>'.$v['Agil_need'].'</b></font>'; } }
if ($v['Intu_need']) { if ($v['Intu_need'] > $player->Intu) {   $v['Intu_need']  = '<font color="red"><b>'.$v['Intu_need'].'</b></font>'; } }
if ($v['Endu_need']) { if ($v['Endu_need'] > $player->Endu) {   $v['Endu_need']  = '<font color="red"><b>'.$v['Endu_need'].'</b></font>'; } }
if ($v['Stre_need']) { $v['Stre_need']  = sprintf(_forthings_sila, $v['Stre_need']); } else {  $v['Stre_need'] = false; }
if ($v['Agil_need']) { $v['Agil_need']  = sprintf(_forthings_lovkost,  $v['Agil_need']); } else { $v['Agil_need'] = false; }
if ($v['Intu_need']) { $v['Intu_need']  = sprintf(_forthings_inta, $v['Intu_need']); } else { $v['Intu_need'] = false; }
if ($v['Endu_need']) { $v['Endu_need']  = sprintf(_forthings_ENDUneed, $v['Endu_need']); } else { $v['Endu_need'] = false; }
if ($v['Level_need']){ $v['Level_need'] = sprintf(_forthings_level, $v['Level_need']); } else { $v['Level_need'] = false; }
if ($v['MAXdamage']) { $v['MAXdamage']  = sprintf(_forthings_ALLdmg, $v['MINdamage'], $v['MAXdamage']); } else { $v['MAXdamage'] = false; }
if ($v['Armor1']) {    $v['Armor1']     = sprintf(_forthings_arm1, $v['Armor1']); } else { $v['Armor1'] = false; }
if ($v['Armor2']) {    $v['Armor2']     = sprintf(_forthings_arm2, $v['Armor2']); } else { $v['Armor2'] = false; }
if ($v['Armor3']) {    $v['Armor3']     = sprintf(_forthings_arm3, $v['Armor3']); } else { $v['Armor3'] = false; }
if ($v['Armor4']) {    $v['Armor4']     = sprintf(_forthings_arm4, $v['Armor4']); } else { $v['Armor4'] = false; }
if ($v['Crit']) {      $v['Crit']       = sprintf(_forthings_сrit, $v['Crit'].'%'); } else { $v['Crit'] = false; }
if ($v['Uv']) {        $v['Uv']         = sprintf(_forthings_uv, $v['Uv'].'%'); } else { $v['Uv'] = false; }
if ($v['AntiCrit']) {  $v['AntiCrit']   = sprintf(_forthings_Aсrit, $v['AntiCrit'].'%'); } else { $v['AntiCrit'] = false; }
if ($v['AntiUv']) {    $v['AntiUv']     = sprintf(_forthings_Auv, $v['AntiUv'].'%'); } else { $v['AntiUv'] = false; }
if ($v['Stre_add']) {  $v['Stre_add']   = sprintf(_forthings_sila, $v['Stre_add']); } else { $v['Stre_add'] = false; }
if ($v['Agil_add']) {  $v['Agil_add']   = sprintf(_forthings_lovkost, $v['Agil_add']); } else { $v['Agil_add'] = false; }
if ($v['Intu_add']) {  $v['Intu_add']   = sprintf(_forthings_inta, $v['Intu_add']); } else { $v['Intu_add'] = false; }
if ($v['Endu_add']) {  $v['Endu_add']   = sprintf(_forthings_endu, $v['Endu_add']); } else { $v['Endu_add'] = false; }
?>
 <tr bgcolor="<?=$bgcolor;?>">
  <td align="center">
   <img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$v['Id'];?>.gif"><br />
   <a href="handmade.php?buy=<?=$v['Un_Id'];?>"><?=_SHOP_buy1;?></a>
  </td>
  <td valign="top">
   <span><?=$v['Thing_Name'];?></span><br />
   <b><?=sprintf(_forthings_cost, $v['Cost'], 'кр.');?></b><br />
   <?=sprintf(_forthings_WEAR, $v['NOWwear'], $v['MAXwear']);?></font><br />
   <br /><?=_forthings_text2;?><br />
   <?=$v['Stre_need'].$v['Agil_need'].$v['Intu_need'].$v['Endu_need'].$v['Level_need'];?>
   <br /><?=_forthings_text1;?><br />
   <?=$v['MAXdamage'].$v['Armor1'].$v['Armor2'].$v['Armor3'].$v['Armor4'].$v['Crit'].$v['Uv'].$v['AntiCrit'].$v['AntiUv'].$v['Stre_add'].$v['Agil_add'].$v['Intu_add'].$v['Endu_add'];?>
  </td>
 </tr>
<? endforeach; ?>
<?  else: ?>
 <tr><td bgcolor="#e2e0e0" align="center"><?=_SHOP_MSG4;?></td></tr>
<? endif; ?>
</table><?
}
?>