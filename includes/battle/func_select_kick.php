<?
include_once ('db_config.php');
include_once ('db.php');


$voskr_clan = 1;
$voskr_clan_thname = 'rs_000';

$sz1_1 = round((149/$Player->hpall)*$Player->hpnow);
$sz2_1 = 150 - $sz1_1;

if ($Player->hpnow/$Player->hpall < 0.33): $color1 = 'http://'.$db_config[DREAM_IMAGES]['server'].'/hpred.gif'; else:
if ($Player->hpnow/$Player->hpall < 0.66): $color1 = 'http://'.$db_config[DREAM_IMAGES]['server'].'/hpyellow.gif'; else: $color1 = 'http://'.$db_config[DREAM_IMAGES]['server'].'/hpgreen.gif'; endif;
endif;

$Slot_name = array('Пустой слот серьги', 'Пустой слот ожерелье', 'Пустой слот оружие', 'Пустой слот броня', 'Пустой слот кольцо', 'Пустой слот кольцо', 'Пустой слот кольцо', 'Пустой слот шапка', 'Пустой слот перчатки', 'Пустой слот щит', 'Пустой слот обувь');
for($i=0; $i<11; $i++): $Slot[$i] = 'empt'.$i; endfor;
$Slot_id = $Slot;

$thing = $db->queryArray("SELECT Slot, Un_Id, Id, Thing_Name, NOWwear, MAXwear FROM ".SQL_PREFIX."things WHERE (Owner = '$Player->login') AND (Wear_ON = '1') AND (Slot < '11')");

if(!empty($thing)):
foreach($thing as $v):

$i = $v['Slot'];
$Slot_id[$i] = $v['Un_Id'];
$Slot[$i] =  $v['Id'];
$Slot_name[$i] = $v['Thing_Name']."\n(долговечность ".$v['NOWwear']."/".$v['MAXwear'].")";

endforeach;
endif;
?>
<!DOCTYPE html PUBLIC "-//W3C//Dtd XHTML 1.0 Transitional//EN"
"http://www.w3.org/tr/xhtml1/Dtd/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru" id="timeofwars">
<head>
   <title></title>
   <meta content="text/html; charset=windows-1251" http-equiv="Content-type" />
   <meta Http-Equiv="Cache-Control" Content="no-cache, max-age=0, must-revalidate, no-store" />
   <meta http-equiv="PRAGMA" content="NO-CACHE" />
   <meta Http-Equiv="Expires" Content="0" />
   <link rel="stylesheet" type="text/css" href="http://<?=$db_config[DREAM]['other'];?>/css/main.css" />
   <script type="text/javascript">
   <!--
   if ( !parent || !parent.frames || parent.location.href == self.location.href ) self.location = self.location.protocol+"//"+self.location.hostname;
   //-->
   </script>
   <script src="http://<?=$db_config[DREAM]['other'];?>/js/main.js"></script>
   <script src="http://<?=$db_config[DREAM]['other'];?>/js/magic.js"></script>
   <script>var attack=false;var defend=false;function check(){if ((! attack) || (! defend)) { alert('Блок или удар не выбран.'); return false; } return true;}function setattack() {attack=true}function setdefend() {defend=true}</script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" bgcolor="#f0f0f0">
 <form action="battle.php" method="POST">
 <table width="100%" cellspacing="0" cellpadding="0">
  <tr>
   <td valign="top" align="center">
   <script>dlogin(<?=sprintf( " '%s', %d, %d, %d ", $Player->login, $Player->level, $Player->align, $Player->clanID )?>);</script>
    <table cellspacing="0" cellpadding="0">
	 <tr>
	  <td nowrap="nowrap">
	   <div id="HP"><img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/herz.gif" width="8px" height="8px" alt="<?=hplevel;?>"> <img src="<?=$color1;?>" width="<?=$sz1_1;?>px" height="8px" alt="<?=hplevel;?>" /><img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/hpsilver.gif" width="<?=$sz2_1;?>px" height="8px" alt="<?=hplevel;?>" />:<?=$Player->hpnow;?>/<?=$Player->hpall;?></div>
      </td>
     </tr>
	</table>
    <table cellpadding="0" cellspacing="0" width="243px">
     <td>
      <div style="position:relative;" width="242px" height="290px" border="0">
       <img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/frames/_main/pers_i_s.gif" width="242px" height="290px" border="0">
       <div width="242px" height="20px" style="position:absolute;left:0px; top:-5px; z-index:1;"></div>
       <div style="position:absolute; left:95px; top:13px; z-index:1; filter:progid:DXImageTransform.Microsoft.Alpha( Opacity=100, Style=0);">
        <a href="http://<?=$db_config[DREAM][server];?>/thing.php?thing=<?=$Slot_id[7];?>" target="_blank">
         <img alt="<?=$Slot_name[7];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$Slot[7];?>.gif" width="50px" height="51px" />
        </a>
       </div>
       <div style="position:absolute; left:17px; top:66px; z-index:1; filter:progid:DXImageTransform.Microsoft.Alpha( Opacity=100, Style=0);">
        <a href="http://<?=$db_config[DREAM][server];?>/thing.php?thing=<?=$Slot_id[2];?>" target="_blank">
         <img alt="<?=$Slot_name[2];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$Slot[2];?>.gif" width="50px" height="50px" />
        </a>
       </div>
       <div style="position:absolute; left:170px; top:62px; z-index:1; filter:progid:DXImageTransform.Microsoft.Alpha( Opacity=100, Style=0);">
        <a href="http://<?=$db_config[DREAM][server];?>/thing.php?thing=<?=$Slot_id[9];?>" target="_blank">
         <img alt="<?=$Slot_name[9];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$Slot[9];?>.gif" />
        </a>
       </div>
       <div style="position:absolute; left:160px; top:145px; z-index:1; filter:progid:DXImageTransform.Microsoft.Alpha( Opacity=100, Style=0);">
        <a href="http://<?=$db_config[DREAM][server];?>/thing.php?thing=<?=$Slot_id[3];?>" target="_blank">
         <img alt="<?=$Slot_name[3];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$Slot[3];?>.gif" />
        </a>
       </div>
       <div style="position:absolute; left:23px; top:210px; z-index:1; filter:progid:DXImageTransform.Microsoft.Alpha( Opacity=100, Style=0);">
        <img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/book0.gif" alt="Пустой слот аксесуары" />
       </div>
       <div style="position:absolute; left:22px; top:150px; z-index:1; filter:progid:DXImageTransform.Microsoft.Alpha( Opacity=100, Style=0);">
        <a href="http://<?=$db_config[DREAM][server];?>/thing.php?thing=<?=$Slot_id[8];?>" target="_blank">
         <img alt="<?=$Slot_name[8];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$Slot[8];?>.gif" />
        </a>
       </div>
       <div style="position:absolute; left:173px; top:220px;z-index:1; filter:progid:DXImageTransform.Microsoft.Alpha( Opacity=100, Style=0);">
        <a href="http://<?=$db_config[DREAM][server];?>/thing.php?thing=<?=$Slot_id[10];?>" target="_blank">
         <img alt="<?=$Slot_name[10];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$Slot[10];?>.gif" width="50px" height="35px" />
        </a>
       </div>
       <div align="center" style="position:absolute; left:70px; top:69px; width:100px ;height:200px; z-index:2; filter:progid:DXImageTransform.Microsoft.Alpha( Opacity=100, Style=0);">
        <img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/pict/<?=$Player->Image;?>.gif" width="70px" height="180px" title="<?=$result[0];?>" />
       </div>
       <div style="position:absolute; left:27px; top:35px; z-index:1; filter:progid:DXImageTransform.Microsoft.Alpha( Opacity=100, Style=0);">
        <a href="http://<?=$db_config[DREAM][server];?>/thing.php?thing=<?=$Slot_id[1];?>" target="_blank">
         <img alt="<?=$Slot_name[1];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$Slot[1];?>.gif" />
        </a>
       </div>
       <div style="position:absolute; left:170px; top:35px; z-index:1;width:50px ;height:20px; filter:progid:DXImageTransform.Microsoft.Alpha( Opacity=100, Style=0);">
        <a href="http://<?=$db_config[DREAM][server];?>/thing.php?thing=<?=$Slot_id[0];?>" target="_blank">
         <img alt="<?=$Slot_name[0];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$Slot[0];?>.gif" />
        </a>
       </div>
       <div style="position:absolute; left:90px; top:260px; z-index:1;width:20px ;height:20px; filter:progid:DXImageTransform.Microsoft.Alpha( Opacity=100, Style=0);">
        <a href="http://<?=$db_config[DREAM][server];?>/thing.php?thing=<?=$Slot_id[4];?>" target="_blank">
         <img alt="<?=$Slot_name[4];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$Slot[4];?>.gif" />
        </a>
       </div>
       <div style="position:absolute; left:113px; top:258px; z-index:1;width:20px ;height:20px; filter:progid:DXImageTransform.Microsoft.Alpha( Opacity=100, Style=0);">
        <a href="http://<?=$db_config[DREAM][server];?>/thing.php?thing=<?=$Slot_id[5];?>" target="_blank">
         <img alt="<?=$Slot_name[5];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$Slot[5];?>.gif" />
        </a>
       </div>
       <div style="position:absolute; left:134px; top:260px; z-index:1;width:20px ;height:20px; filter:progid:DXImageTransform.Microsoft.Alpha( Opacity=100, Style=0);">
        <a href="http://<?=$db_config[DREAM][server];?>/thing.php?thing=<?=$Slot_id[6];?>" target="_blank">
         <img alt="<?=$Slot_name[6];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$Slot[6];?>.gif" />
        </a>
       </div>
      </td>
     </tr>
     <tr>
      <td align="left">
       <?=$Player->GetStats();?>
      </td>
     </tr>
     <tr>
      <td align="center">
<? if ( !empty($player_magic) ):  ?>
      <br /><br /><b>Свитки/Эликсиры:</b><br /><br />
<? foreach($player_magic as $v): ?>
<? if ($Player->clanID == $voskr_clan): ?>
<? if (!$dat = $db->queryRow("SELECT * FROM ".SQL_PREFIX."dd WHERE Username = '$Player->login'")): ?>
         <a href="battle.php?use=10"><img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/rs_000.gif" alt="Свиток 'Живая вода'" /></a><br />
<? endif;      ?>
<? endif;      ?>
<? switch( $v['MagicID'] ): ?>
<? case 'note':                         echo '<a href="JavaScript:usegovor(\''.$v['Un_Id'].'\',\''.rawurlencode($Enemy_Username).'\')"><img src="http://'.$db_config[DREAM_IMAGES]['server'].'/'.$v['Id'].'.gif" alt="'.$v['MagicID'].' (Долговечность: '.$v['NOWwear'].'/'.$v['MAXwear'].')" /></a><br />';    break; ?>
<? case 'Fireball':                     echo '<a href="JavaScript:usefire(\''.$v['Un_Id'].'\',\''.rawurlencode($Enemy_Username).'\')"><img src="http://'.$db_config[DREAM_IMAGES]['server'].'/'.$v['Id'].'.gif" alt="'.$v['MagicID'].' (Долговечность: '.$v['NOWwear'].'/'.$v['MAXwear'].')" /></a><br />';     break; ?>
<? case 'Ледяной удар':                 echo '<a href="JavaScript:usefire(\''.$v['Un_Id'].'\',\''.rawurlencode($Enemy_Username).'\')"><img src="http://'.$db_config[DREAM_IMAGES]['server'].'/'.$v['Id'].'.gif" alt="'.$v['MagicID'].' (Долговечность: '.$v['NOWwear'].'/'.$v['MAXwear'].')" /></a><br />';     break; ?>
<? case 'Подчинение':                   echo '<a href="JavaScript:usepodch(\''.$v['Un_Id'].'\',\''.rawurlencode($Enemy_Username).'\')"><img src="http://'.$db_config[DREAM_IMAGES]['server'].'/'.$v['Id'].'.gif" alt="'.$v['MagicID'].' (Долговечность: '.$v['NOWwear'].'/'.$v['MAXwear'].')" /></a><br />';    break; ?>
<? case 'Воскрешение':                  echo '<a href="JavaScript:usepodch(\''.$v['Un_Id'].'\',\''.rawurlencode($Enemy_Username).'\')"><img src="http://'.$db_config[DREAM_IMAGES]['server'].'/'.$v['Id'].'.gif" alt="'.$v['MagicID'].' (Долговечность: '.$v['NOWwear'].'/'.$v['MAXwear'].')" /></a><br />';    break; default: ?>
<? if (strpos($v['MagicID'], 'екарь')): echo '<a href="JavaScript:usepodch(\''.$v['Un_Id'].'\', \''.rawurlencode($Enemy_Username).'\')"><img src="http://'.$db_config[DREAM_IMAGES]['server'].'/'.$v['Id'].'.gif" alt="'.$v['MagicID'].' (Долговечность: '.$v['NOWwear'].'/'.$v['MAXwear'].')" /></a><br />';   else: echo '<a href="battle.php?use='.$v['Un_Id'].'&enemy='.rawurlencode($Enemy_Username).'"><img src="http://'.$db_config[DREAM_IMAGES]['server'].'/'.$v['Id'].'.gif" alt="'.$v['MagicID'].' (Долговечность: '.$v['NOWwear'].'/'.$v['MAXwear'].')" /></a><br />'; endif; break; ?>
<? endswitch;   ?>
<? endforeach;  ?>
<? endif;       ?>
      </td>
     </tr>
    </table>
   </td>
   <td valign="top">
    <table width="100%" cellspacing="0" cellpadding="0">
     <tr>
      <td colspan="2"><h3>Поединок</h3></td>
     </tr>
     <tr>
      <td><font color="#660000"><b>Ваш ход</b></font></td>
      <td align="right">&nbsp;</td>
     </tr>
    </table>
    <center>
    <table cellspacing="0" cellpadding="0">
     <tr>
	  <td align="center" bgcolor="#bbbbbb"><b>Атака</b></td>
      <td>&nbsp;</td>
      <td align="center" bgcolor="#bbbbbb"><b>Защита</b></td>
     </tr>
     <tr>
      <td>
       <table cellspacing="0" cellpadding="0">
        <tr><td width="25px"><input type="radio" id="A1" name="kick" value="1" onclick="setattack()" /></td><td align="left"><label for="A1">удар в голову</label></td></tr>
        <tr><td width="25px"><input type="radio" id="A2" name="kick" value="2" onclick="setattack()" /></td><td align="left"><label for="A2">удар в корпус</label></td></tr>
        <tr><td width="25px"><input type="radio" id="A3" name="kick" value="4" onclick="setattack()" /></td><td align="left"><label for="A3">удар в пояс(пах)</label></td></tr>
        <tr><td width="25px"><input type="radio" id="A4" name="kick" value="8" onclick="setattack()" /></td><td align="left"><label for="A4">удар по ногам</label></td></tr>
       </table>
      </td>
      <td>&nbsp;</td>
      <td>
	   <table cellspacing="0" cellpadding="0">
        <tr><td width="25px"><input type="radio" id="D1" name="block" value="3" onclick="setdefend()" /></td><td align="left"><label for="D1">блок головы и корпуса</label></td></tr>
        <tr><td width="25px"><input type="radio" id="D2" name="block" value="6" onclick="setdefend()" /></td><td align="left"><label for="D2">блок корпуса и пояса</label></td></tr>
        <tr><td width="25px"><input type="radio" id="D3" name="block" value="12" onclick="setdefend()" /></td><td align="left"><label for="D3">блок пояса и ног</label></td></tr>
        <tr><td width="25px"><input type="radio" id="D4" name="block" value="9" onclick="setdefend()" /></td><td align="left"><label for="D4">блок головы и ног</label></td></tr>
       </table>
      </td>
     </tr>
     <tr>
	  <td colspan="3" align="center" bgcolor="#bbbbbb"><input type="hidden" name="Enemy_un" Value="<?=$Enemy_Username;?>"><input type="button" class="oo" onmouseover="this.className = 'on';" onmouseout="this.className = 'oo';" value="Обновить" onClick="window.location.href='battle.php'"> <input type="submit" class="oo" onmouseover="this.className = 'on';" onmouseout="this.className = 'oo';" name=attack_value value="Нанести удар" onclick="return check();"></td>
     </tr>
    </table>
    </center>
    <hr />
    <?=$players_list_show;?>
    <br />
    <font class="dsc">(Таймаут 3 мин.)</font><br />
    Нанесено урона: <b><?=$dmg;?></b><br />
    <? if(count($rev_log) < 26): $lines = count($rev_log); else: $lines = 26; endif; ?>
    <? for($i=0; $i<$lines; $i++): print $rev_log[$i].'<br />'; endfor; ?><br />
    <font color="red">Вырезано для уменьшения лога.</font> | <a href="log.php?id=<?=$BattleID;?>" target="_blank">Полный лог боя</a>
   </td>
<?
$sz1_1 = round((149/$Enemy->hpall)*$Enemy->hpnow);
$sz2_1 = 150 - $sz1_1;

if ($Enemy->hpnow/$Enemy->hpall < 0.33): $color1 = 'http://'.$db_config[DREAM_IMAGES]['server'].'/hpred.gif'; else:
if ($Enemy->hpnow/$Enemy->hpall < 0.66): $color1 = 'http://'.$db_config[DREAM_IMAGES]['server'].'/hpyellow.gif'; else: $color1 = 'http://'.$db_config[DREAM_IMAGES]['server'].'/hpgreen.gif'; endif;
endif;

$Slot_name = array('Пустой слот серьги', 'Пустой слот ожерелье', 'Пустой слот оружие', 'Пустой слот броня', 'Пустой слот кольцо', 'Пустой слот кольцо', 'Пустой слот кольцо', 'Пустой слот шапка', 'Пустой слот перчатки', 'Пустой слот щит', 'Пустой слот обувь');
for($i=0; $i<11; $i++): $Slot[$i] = 'empt'.$i; endfor;
$Slot_id = $Slot;

$thing = $db->queryArray("SELECT Slot, Un_Id, Id, Thing_Name, NOWwear, MAXwear FROM ".SQL_PREFIX."things WHERE (Owner = '$Enemy->login') AND (Wear_ON = '1') AND (Slot < '11')");

if(!empty($thing)):

foreach($thing as $v):

$i = $v['Slot'];
$Slot_id[$i] = $v['Un_Id'];
$Slot[$i] =  $v['Id'];
$Slot_name[$i] = $v['Thing_Name']."\n(долговечность ".$v['NOWwear']."/".$v['MAXwear'].")";

endforeach;

endif;
?>
   <td valign="top" align="center">
   <script>dlogin(<?=sprintf( " '%s', %d, %d, %d ", $Enemy->login, $Enemy->level, $Enemy->align, $Enemy->clanID )?>);</script>
    <table cellspacing="0" cellpadding="0">
	 <tr>
	  <td nowrap="nowrap">
	   <div id="HP"><img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/herz.gif" width="8px" height="8px" alt="<?=hplevel;?>"> <img src="<?=$color1;?>" width="<?=$sz1_1;?>px" height="8px" alt="<?=hplevel;?>" /><img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/hpsilver.gif" width="<?=$sz2_1;?>px" height="8px" alt="<?=hplevel;?>" />:<?=$Enemy->hpnow;?>/<?=$Enemy->hpall;?></div>
      </td>
     </tr>
	</table>
    <table cellpadding="0" cellspacing="0" width="243px">
     <td>
      <div style="position:relative;" width="242px" height="290px" border="0">
       <img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/frames/_main/pers_i_s.gif" width="242px" height="290px" border="0">
       <div width="242px" height="20px" style="position:absolute;left:0px; top:-5px; z-index:1;"></div>
       <div style="position:absolute; left:95px; top:13px; z-index:1; filter:progid:DXImageTransform.Microsoft.Alpha( Opacity=100, Style=0);">
        <a href="http://<?=$db_config[DREAM][server];?>/thing.php?thing=<?=$Slot_id[7];?>" target="_blank">
         <img alt="<?=$Slot_name[7];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$Slot[7];?>.gif" width="50px" height="51px" />
        </a>
       </div>
       <div style="position:absolute; left:17px; top:66px; z-index:1; filter:progid:DXImageTransform.Microsoft.Alpha( Opacity=100, Style=0);">
        <a href="http://<?=$db_config[DREAM][server];?>/thing.php?thing=<?=$Slot_id[2];?>" target="_blank">
         <img alt="<?=$Slot_name[2];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$Slot[2];?>.gif" width="50px" height="50px" />
        </a>
       </div>
       <div style="position:absolute; left:170px; top:62px; z-index:1; filter:progid:DXImageTransform.Microsoft.Alpha( Opacity=100, Style=0);">
        <a href="http://<?=$db_config[DREAM][server];?>/thing.php?thing=<?=$Slot_id[9];?>" target="_blank">
         <img alt="<?=$Slot_name[9];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$Slot[9];?>.gif" />
        </a>
       </div>
       <div style="position:absolute; left:160px; top:145px; z-index:1; filter:progid:DXImageTransform.Microsoft.Alpha( Opacity=100, Style=0);">
        <a href="http://<?=$db_config[DREAM][server];?>/thing.php?thing=<?=$Slot_id[3];?>" target="_blank">
         <img alt="<?=$Slot_name[3];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$Slot[3];?>.gif" />
        </a>
       </div>
       <div style="position:absolute; left:23px; top:210px; z-index:1; filter:progid:DXImageTransform.Microsoft.Alpha( Opacity=100, Style=0);">
        <img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/book0.gif" alt="Пустой слот аксесуары" />
       </div>
       <div style="position:absolute; left:22px; top:150px; z-index:1; filter:progid:DXImageTransform.Microsoft.Alpha( Opacity=100, Style=0);">
        <a href="http://<?=$db_config[DREAM][server];?>/thing.php?thing=<?=$Slot_id[8];?>" target="_blank">
         <img alt="<?=$Slot_name[8];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$Slot[8];?>.gif" />
        </a>
       </div>
       <div style="position:absolute; left:173px; top:220px;z-index:1; filter:progid:DXImageTransform.Microsoft.Alpha( Opacity=100, Style=0);">
        <a href="http://<?=$db_config[DREAM][server];?>/thing.php?thing=<?=$Slot_id[10];?>" target="_blank">
         <img alt="<?=$Slot_name[10];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$Slot[10];?>.gif" width="50px" height="35px" />
        </a>
       </div>
       <div align="center" style="position:absolute; left:70px; top:69px; width:100px ;height:200px; z-index:2; filter:progid:DXImageTransform.Microsoft.Alpha( Opacity=100, Style=0);">
        <img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/pict/<?=$Enemy->Image;?>.gif" width="70px" height="180px" title="<?=$result[0];?>" />
       </div>
       <div style="position:absolute; left:27px; top:35px; z-index:1; filter:progid:DXImageTransform.Microsoft.Alpha( Opacity=100, Style=0);">
        <a href="http://<?=$db_config[DREAM][server];?>/thing.php?thing=<?=$Slot_id[1];?>" target="_blank">
         <img alt="<?=$Slot_name[1];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$Slot[1];?>.gif" />
        </a>
       </div>
       <div style="position:absolute; left:170px; top:35px; z-index:1;width:50px ;height:20px; filter:progid:DXImageTransform.Microsoft.Alpha( Opacity=100, Style=0);">
        <a href="http://<?=$db_config[DREAM][server];?>/thing.php?thing=<?=$Slot_id[0];?>" target="_blank">
         <img alt="<?=$Slot_name[0];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$Slot[0];?>.gif" />
        </a>
       </div>
       <div style="position:absolute; left:90px; top:260px; z-index:1;width:20px ;height:20px; filter:progid:DXImageTransform.Microsoft.Alpha( Opacity=100, Style=0);">
        <a href="http://<?=$db_config[DREAM][server];?>/thing.php?thing=<?=$Slot_id[4];?>" target="_blank">
         <img alt="<?=$Slot_name[4];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$Slot[4];?>.gif" />
        </a>
       </div>
       <div style="position:absolute; left:113px; top:258px; z-index:1;width:20px ;height:20px; filter:progid:DXImageTransform.Microsoft.Alpha( Opacity=100, Style=0);">
        <a href="http://<?=$db_config[DREAM][server];?>/thing.php?thing=<?=$Slot_id[5];?>" target="_blank">
         <img alt="<?=$Slot_name[5];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$Slot[5];?>.gif" />
        </a>
       </div>
       <div style="position:absolute; left:134px; top:260px; z-index:1;width:20px ;height:20px; filter:progid:DXImageTransform.Microsoft.Alpha( Opacity=100, Style=0);">
        <a href="http://<?=$db_config[DREAM][server];?>/thing.php?thing=<?=$Slot_id[6];?>" target="_blank">
         <img alt="<?=$Slot_name[6];?>" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/<?=$Slot[6];?>.gif" />
        </a>
       </div>
      </td>
     </tr>
     <tr>
      <td align="left">
       <?=$Enemy->GetStats();?>
      </td>
     </tr>
    </table>
   </td>
  </tr>
 </table>
</form>
</body>
</html>