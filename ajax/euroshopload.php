<?php
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

session_start();

include_once ('../db_config.php');
include_once ('../db.php');
include_once ('../classes/PlayerInfo.php');
include_once ('../includes/to_view.php');

$player = new PlayerInfo();

require_once 'JsHttpRequest.php';

$JsHttpRequest =& new JsHttpRequest("windows-1251");

@$otdel = intval($_POST['q']);
/*$shop   = '';

if( !empty($_GET['shop']) ){
if( $s_room = @$db->SQL_result($db->query("SELECT zamok FROM ".SQL_PREFIX."castles WHERE zamok = '".speek_to_view($_GET['shop'])."'"),0,0) ){$shop = '_'.$s_room;
}
}
*/
if(empty($otdel)){ die; }

switch( $otdel ){
case 1:      $otn = _EUROSHOP_otdel1;    break;
case 2:      $otn = _EUROSHOP_otdel2;    break;
case 3:      $otn = _EUROSHOP_otdel3;    break;
case 4:      $otn = _EUROSHOP_otdel4;    break;
case 5:      $otn = _EUROSHOP_otdel5;    break;
case 6:      $otn = _EUROSHOP_otdel6;    break;
case 7:      $otn = 'Улучшение артефактов'; break;
default:     $otn = _EUROSHOP_otdel1;    break;
}

$st = 'Euro';

$Money = $db->SQL_result($db->query("SELECT Euro FROM `".SQL_PREFIX."bank_acc` WHERE Username = '$player->username'"));
if( empty($Money) )
{
	$Money = '0.00';
}

if( $otdel == 7 )
{	$out = $db->queryArray("SELECT * FROM `".SQL_PREFIX."things` WHERE Thing_Name LIKE '%(артефакт)%' AND Owner = '".$player->username."' AND Wear_ON = '0' ORDER BY `cost`");
}
else
{	$out = $db->queryArray("SELECT * FROM `".SQL_PREFIX."things_euroshop` WHERE `Amount` != '0' AND `Otdel` = '$otdel' ORDER BY `Eurocost`");
}

$GLOBALS['_RESULT'] = array(
  "otdname" => $otn
);

$bgcolor = '#D5D5D5';
?>
<table width="100%" cellspacing="1" cellpadding="2" bgcolor="#A5A5A5">
<? if ( !empty($out) ):  ?>
<? foreach ( $out as $v ):  ?>
<? if ($bgcolor == '#C7C7C7'): $bgcolor = '#D5D5D5'; elseif($bgcolor == '#D5D5D5'): $bgcolor = '#C7C7C7'; endif;  ?>
<?

if( $otdel == 7 )
{
if (!empty($v['Owner']) && $v['Cost']) { $v['Eurocost'] = $v['Cost']; $st = 'кр.'; }
if ($v['Level_need']) {$v['Level_need'] += 1; }
if ($v['Stre_need']) { $v['Stre_need']  = sprintf(_forthings_sila, $v['Stre_need']); } else {  $v['Stre_need'] = false; }
if ($v['Agil_need']) { $v['Agil_need']  = sprintf(_forthings_lovkost,  $v['Agil_need']); } else { $v['Agil_need'] = false; }
if ($v['Intu_need']) { $v['Intu_need']  = sprintf(_forthings_inta, $v['Intu_need']); } else { $v['Intu_need'] = false; }
if ($v['Endu_need']) { $v['Endu_need']  = sprintf(_forthings_ENDUneed, $v['Endu_need']); } else { $v['Endu_need'] = false; }
if ($v['Level_need']){ $v['Level_need'] = sprintf(_forthings_level, $v['Level_need']); } else { $v['Level_need'] = false; }
if ($v['Level_add']) { $v['Level_add']  = sprintf(_forthings_level, $v['Level_add']); } else { $v['Level_add'] = false; }
if ($v['MAXdamage']) { $v['MAXdamage']  = sprintf(_forthings_ALLdmg, ceil($v['MINdamage']+$v['MINdamage']*0.05), ceil($v['MAXdamage']+$v['MAXdamage']*0.05) ); } else { $v['MAXdamage'] = false; }
if ($v['Armor1']) {    $v['Armor1']     = sprintf(_forthings_arm1, ceil($v['Armor1']+$v['Armor1']*0.05) ); } else { $v['Armor1'] = false; }
if ($v['Armor2']) {    $v['Armor2']     = sprintf(_forthings_arm2, ceil($v['Armor2']+$v['Armor2']*0.05) ); } else { $v['Armor2'] = false; }
if ($v['Armor3']) {    $v['Armor3']     = sprintf(_forthings_arm3, ceil($v['Armor3']+$v['Armor3']*0.05) ); } else { $v['Armor3'] = false; }
if ($v['Armor4']) {    $v['Armor4']     = sprintf(_forthings_arm4, ceil($v['Armor4']+$v['Armor4']*0.05) ); } else { $v['Armor4'] = false; }
if ($v['Crit']) {      $v['Crit']       = sprintf(_forthings_сrit, ceil($v['Crit']+$v['Crit']*0.05).'%'); } else { $v['Crit'] = false; }
if ($v['Uv']) {        $v['Uv']         = sprintf(_forthings_uv, ceil($v['Uv']+$v['Uv']*0.05).'%'); } else { $v['Uv'] = false; }
if ($v['AntiCrit']) {  $v['AntiCrit']   = sprintf(_forthings_Aсrit, ceil($v['AntiCrit']+$v['AntiCrit']*0.05).'%'); } else { $v['AntiCrit'] = false; }
if ($v['AntiUv']) {    $v['AntiUv']     = sprintf(_forthings_Auv, ceil($v['AntiUv']+$v['AntiUv']*0.05).'%'); } else { $v['AntiUv'] = false; }
if ($v['Stre_add']) {  $v['Stre_add']   = sprintf(_forthings_sila, $v['Stre_add']); } else { $v['Stre_add'] = false; }
if ($v['Agil_add']) {  $v['Agil_add']   = sprintf(_forthings_lovkost, $v['Agil_add']); } else { $v['Agil_add'] = false; }
if ($v['Intu_add']) {  $v['Intu_add']   = sprintf(_forthings_inta, $v['Intu_add']); } else { $v['Intu_add'] = false; }
if ($v['Endu_add']) {  $v['Endu_add']   = sprintf(_forthings_endu, ceil($v['Endu_add']+$v['Endu_add']*0.05)); } else { $v['Endu_add'] = false; }
if ($v['MagicID']) {   $v['MagicID']    = sprintf(_forthings_magicID, $v['MagicID']); } else { $v['MagicID'] = false; }
if ($v['Srab']) {      $v['Srab']       = sprintf(_forthings_srab, $v['Srab']); } else { $v['Srab'] = false; }

}
else
{

if (!empty($v['Eurocost']) && $v['Eurocost'] > $Money) { $v['Eurocost'] = '<font color=red>'.$v['Eurocost'].'</font>'; }
if ($v['Level_need']) { if ($v['Level_need'] > $player->Level) { $v['Level_need'] = '<font color=red><B>'.$v['Level_need'].'</B></font>'; }  }
if ($v['Stre_need']) { if ($v['Stre_need'] > $player->Stre) { $v['Stre_need'] = '<font color=red><B>'.$v['Stre_need'].'</B></font>'; } }
if ($v['Agil_need']) { if ($v['Agil_need'] > $player->Agil) { $v['Agil_need'] = '<font color=red><B>'.$v['Agil_need'].'</B></font>'; } }
if ($v['Intu_need']) { if ($v['Intu_need'] > $player->Intu) { $v['Intu_need'] = '<font color=red><B>'.$v['Intu_need'].'</B></font>'; } }
if ($v['Endu_need']) { if ($v['Endu_need'] > $player->Endu) { $v['Endu_need'] = '<font color=red><B>'.$v['Endu_need'].'</B></font>'; } }
if ($v['Stre_need']) { $v['Stre_need']  = sprintf(_forthings_sila, $v['Stre_need']); } else {  $v['Stre_need'] = false; }
if ($v['Agil_need']) { $v['Agil_need']  = sprintf(_forthings_lovkost,  $v['Agil_need']); } else { $v['Agil_need'] = false; }
if ($v['Intu_need']) { $v['Intu_need']  = sprintf(_forthings_inta, $v['Intu_need']); } else { $v['Intu_need'] = false; }
if ($v['Endu_need']) { $v['Endu_need']  = sprintf(_forthings_ENDUneed, $v['Endu_need']); } else { $v['Endu_need'] = false; }
if ($v['Level_need']){ $v['Level_need'] = sprintf(_forthings_level, $v['Level_need']); } else { $v['Level_need'] = false; }
if ($v['Level_add']) { $v['Level_add']  = sprintf(_forthings_level, $v['Level_add']); } else { $v['Level_add'] = false; }
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
if ($v['MagicID']) {   $v['MagicID']    = sprintf(_forthings_magicID, $v['MagicID']); } else { $v['MagicID'] = false; }
if ($v['Srab']) {      $v['Srab']       = sprintf(_forthings_srab, $v['Srab']); } else { $v['Srab'] = false; }


}
?>
 <tr bgcolor="<?=$bgcolor;?>">
  <td align="center" width="250px">
   <img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$v['Id'];?>.gif"><br />
   <? if( $otdel == 7 ): ?>
   <a href="euroshop.php?upgrade=<?=$v['Un_Id'];?>&otdel=7">Улучшить за <?=sprintf ("%.2f", ($v['Cost']/15*0.05) );?> Euro.</a>
   <? else: ?>
   <a href="euroshop.php?buy=<?=$v['Id'];?>&otdel=<?=$otdel;?>"><?=_SHOP_buy1;?></a>
   <? endif; ?>
  </td>
  <td valign="top">
   <a href="http://<?=$db_config[DREAM][server];?>/info/<?=$v['Id'];?>.html" target="_blank"><?=$v['Thing_Name'];?></a>
   <?if($v['Clan_need']):?><img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/clan/<?=$v['Clan_need'];?>.gif"><? endif; ?><br />
   <b><?=sprintf(_forthings_cost, $v['Eurocost'], $st);?></b> <small><?=!empty($v['Amount']) ? sprintf(_SHOP_howmany, $v['Amount']) : '';?></small><br />
   <?=sprintf(_forthings_WEAR, $v['NOWwear'], $v['MAXwear']);?></font><br />
   <? if( $otdel == 7 ): ?>
   <br />
   <b>Будет:</b>
   <br />
   <? endif; ?>
   <br /><?=_forthings_text2;?><br />
   <?=$v['Stre_need'].$v['Agil_need'].$v['Intu_need'].$v['Endu_need'].$v['Level_need'];?>
   <br /><?=_forthings_text1;?><br />
   <?=$v['Level_add'].$v['MAXdamage'].$v['Armor1'].$v['Armor2'].$v['Armor3'].$v['Armor4'].$v['Crit'].$v['Uv'].$v['AntiCrit'].$v['AntiUv'].$v['Stre_add'].$v['Agil_add'].$v['Intu_add'].$v['Endu_add'].$v['MagicID'].$v['Srab'];?>
  </td>
 </tr>
<? endforeach; ?>
<?  else: ?>
 <tr><td bgcolor="#e2e0e0" align="center"><?=_SHOP_MSG4;?></td></tr>
<? endif; ?>
</table>