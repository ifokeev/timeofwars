<?

include ('db.php');
include ('classes/ChatSendMessages.php');
include ('includes/turnir/func.php');



$names = '';
$Add_finished = '';



function get_drop( $user, $battles )
{	global $db;	if( $battles%3 == 0 )
	{		$drop = Array(
		'kr', 'items/grass1', 'items/grass2', 'items/jen-shen', 'items/kalendula', 'items/vasilek', 'items/vetrenica', 'items/sumka',
		'items/hmel', 'items/devatisil', 'items/mak', 'items/shalf', 'items/veresk', 'items/sandal', 'items/valer',
		'items/vanil', 'items/durman', 'items/pustir', 'items/muhomor', 'items/lisichka', 'items/siroezka', 'items/opata', 'items/krasnyi',
		'items/maslenok', 'fish/beluga', 'fish/ersh', 'fish/karas', 'fish/lesh', 'fish/okun', 'fish/plotva',
		);


		$give = $drop[mt_rand( 0, count($drop)-1 )];
		if( $give == 'kr' )
		{			$give = rand(1, 10);
			$db->update( SQL_PREFIX.'players', Array( 'Money' => '[+]'.$give ), Array( 'Username' => $user ), 'maths' );
			$msg = 'Вау! Вы только что нашли <b>'.okon4( $give, Array( 'кредит', 'кредита', 'кредитов' )).'.</b>';
			$db->execQuery("INSERT INTO `".SQL_PREFIX."messages` VALUES ('".$user."', '".mysql_escape_string($msg)."');");
			$db->execQuery("INSERT INTO `".SQL_PREFIX."transfer` (`Date`, `From`, `To`, `What`) VALUES ('".date('Y-m-d')."', 'Дроп', '".$user."', 'Нашел ".$give." кр.');");

		}
		else
		{			$const = str_replace( 'items/', '', $give );
			$const = str_replace( 'fish/', '', $const );

        	if (!$db->numrows("SELECT * FROM `".SQL_PREFIX."things` WHERE Owner = '".$user."' AND Id = '".$give."';"))
        	{
        		$db->insert( SQL_PREFIX.'things', Array( 'Owner' => $user, 'Id' => $give, 'Thing_Name' => constant("_FOREST_".$const.""), 'Slot' => 15, 'Cost' => '1', 'Count' => '1', 'NOWwear' => '0', 'MAXwear' => '1' ) );
        	}
        	else
        	{
        		$db->execQuery("UPDATE `".SQL_PREFIX."things` SET Count = Count + '1' WHERE Owner = '".$user."' AND Id = '".$give."'");
       	 	}
			$msg = 'Что это? <b>'.constant("_FOREST_".$const."").'!</b> Вот это да! *Помещено в инвентарь*.';			$db->execQuery("INSERT INTO `".SQL_PREFIX."messages` VALUES ('".$user."', '".mysql_escape_string($msg)."');");
			$db->execQuery("INSERT INTO `".SQL_PREFIX."transfer` (`Date`, `From`, `To`, `What`) VALUES ('".date('Y-m-d')."', 'Дроп', '".$user."', 'Нашел ".constant("_FOREST_".$const."")."');");


		}
	}
}

function test_turnir( $id )
{ global $db;

	$data = $db->queryRow( "SELECT COUNT(DISTINCT tu.user) as cnt FROM ".SQL_PREFIX."turnir as t LEFT JOIN ".SQL_PREFIX."turnir_users as tu ON ( t.id = tu.turnir_id ) WHERE tu.turnir_id = '".intval($id)."' AND t.status = '2' GROUP BY tu.turnir_id;" );

	if( $data['cnt'] <= 1 )
	{
		    $db->update( SQL_PREFIX.'turnir', Array( 'status' => '3' ), Array( 'id' => $id, 'status' => '2' ) );
	        turnir_log( $id, 'В '.date('H:i:s').' турнир <b>закончился.</b> Победителя нет.' );
            turnir_msg( 'Турнир №'.$id.' <b>закончился.</b> Победителя нет.' );
    }

}

function getBattleExpNew( $username, $id_battle ){
global $db;
$query     = sprintf("SELECT AVG(p.Level) as Level FROM ".SQL_PREFIX."battle_list bl INNER JOIN ".SQL_PREFIX."battle_list ble ON(ble.Id=bl.Id AND ble.Team!=bl.Team) LEFT JOIN ".SQL_PREFIX."players p ON (p.Username=ble.Player) WHERE bl.Id = '%d' AND bl.Player = '%s';", $id_battle, $username);
$enemy     = $db->queryRow( $query );

$query     = sprintf("SELECT (IFNULL((p.Stre - SUM(t.Stre_add)) , p.Stre)+ IFNULL((p.Agil - SUM(t.Agil_add)) , p.Agil)+ IFNULL((p.Intu - SUM(t.Intu_add)) , p.Intu)+ p.Endu + p.Intl + p.Ups) as statSum, p.Intl as Intl, p.Level as Level, p.Won as Won, p.Lost as Lost FROM ".SQL_PREFIX."players as p LEFT JOIN ".SQL_PREFIX."things as t ON (t.Owner=p.Username AND t.Wear_ON='1') WHERE p.Username='%s' GROUP BY p.Username;", $username );
$player    = $db->queryRow( $query );

$factor    = max( 1, ($player['Level'] / 10) );
$levelDiff = intval( ( $enemy['Level'] - $player['Level'] ) / $factor );

$query     = sprintf("SELECT percents FROM ".SQL_PREFIX."battle_exp WHERE '%d' BETWEEN  levelMin AND levelMax;", $levelDiff);
$exp       = $db->queryRow( $query );

return intval($exp['percents'] + getBattleExpIntlBonus( $username, $player['statSum'], $player['Intl'] ) + getBattleExpLostWonBonus( $username, $player['Level'], $player['Won'], $player['Lost'] ));
}



function getBattleExpIntlBonus( $username, $statSum, $Intl ){
global $db;
$bonusPercent = 10;
$IntlPercent = 15;
$IntlBonus = intval( ( min( $IntlPercent, ( ($Intl / $statSum) * 100 ) ) / $IntlPercent ) * $bonusPercent);

if( $IntlBonus > 0 ){
$msgPrivate = '<font color=red>Внимание!</font> Разум вас не подвёл в поединке, и вы получаете бонус к опыту в размере <b>'.$IntlBonus.'%</b>';
$db->execQuery("INSERT INTO `".SQL_PREFIX."messages` VALUES ('$username', '".mysql_escape_string($msgPrivate)."');");
}

return $IntlBonus;
}


function getBattleExpLostWonBonus( $username, $Level, $Won, $Lost ){
global $db;
$bonusPercent = 10;
$minLostWonPercent = 100;
$maxLostWonPercent = 200;

if( $Lost < 1 || $Won < 1 ){
return 0;
}

$LostWonBonus = ($Lost / $Won) * 100;

if( $LostWonBonus <= $minLostWonPercent ){
return 0;
}

$LostWonBonus = intval( ( min( $maxLostWonPercent, $LostWonBonus ) / $maxLostWonPercent ) * $bonusPercent);

if( $LostWonBonus > 0 ){
$msgPrivate = '<font color=red>Внимание!</font> Вы стремились победить противника так, что получаете бонус к опыту в размере <b>'.$LostWonBonus.'%</b>';
$db->execQuery("INSERT INTO `".SQL_PREFIX."messages` VALUES ('$username', '".mysql_escape_string($msgPrivate)."');");
}

return $LostWonBonus;
}


function updateThingsWear( $login, $iznos_rand ){
global $db;
$query = sprintf("SELECT Un_Id, Thing_Name, NOWwear, MAXwear, Stre_add, Agil_add, Endu_add, Level_add FROM ".SQL_PREFIX."things WHERE Owner = '%s' AND Wear_ON = '1' AND Slot BETWEEN '0' AND '10';", $login);
$res = $db->queryArray( $query );

if(!empty($res)):
foreach($res as $v):
if( rand(0,100) > $iznos_rand ): continue; endif;

if( $v['NOWwear'] == $v['MAXwear'] ):
$query = sprintf("UPDATE ".SQL_PREFIX."players SET Stre = Stre - '%d', Agil = Agil - '%d', HPall = HPall - '%d', Level = Level - '%d' WHERE Username = '%s';", $v['Stre_add'], $v['Agil_add'], $v['Endu_add'], $v['Level_add'], $login);
$db->execQuery( $query );

$db->execQuery("DELETE FROM ".SQL_PREFIX."things WHERE Un_Id = '".$v['Un_Id']."' AND Owner = '".speek_to_view($login)."' AND Wear_ON = '1';");


$msgPrivate = 'В ходе боя вещь '.$v['Thing_Name'].' была повреждена и безвозвратно утеряна.';
$db->execQuery("INSERT INTO `".SQL_PREFIX."messages` VALUES ('$login', '".mysql_escape_string($msgPrivate)."');");

$db->execQuery("INSERT INTO `".SQL_PREFIX."transfer` (`Date`, `From`, `To`, `What`) VALUES ('".date('Y-m-d')."', '$login', 'Корзине', '".mysql_escape_string($msgPrivate)."');");

else:
$query = sprintf("UPDATE ".SQL_PREFIX."things SET NOWwear = NOWwear + '1' WHERE Un_Id = '%d' AND Owner = '%s'", $v['Un_Id'], $login);
$db->execQuery( $query );
endif;


endforeach;
endif;

}


$db->execQuery("UPDATE ".SQL_PREFIX."hp SET Time = '".time ('void')."' WHERE Username = '$Player->login'");

$sz1_1 = round((149/$Player->hpall)*$Player->hpnow);
$sz2_1 = 150 - $sz1_1;

if ($Player->hpnow/$Player->hpall < 0.33): $color1 = 'images/hpred.gif'; else:
if ($Player->hpnow/$Player->hpall < 0.66): $color1 = 'images/hpyellow.gif'; else: $color1 = 'images/hpgreen.gif'; endif;
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

$voskr_clan = 9;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
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
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" bgcolor="#f0f0f0">
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
    </table>
   </td>
   <td valign="top">
    <table width="100%" cellspacing="0" cellpadding="0" align="center">
     <tr>
      <td colspan="2"><h3>Поединок</h3></td>
     </tr>
    </table>
    <center>
<?

if ($Player->hpnow <= 0 && !empty($enemy_team_alive) && !empty($my_team_alive)):

if ($team == 2): $E = 'B1'; $M = 'B2'; else: $E = 'B2'; $M = 'B1'; endif;


$res = $db->queryArray("SELECT Player FROM ".SQL_PREFIX."battle_list WHERE (Team = '1') AND (dead = '0') AND (Id = '$BattleID')");
if(!empty($res)):
foreach($res as $v):
//начало
$result = $db->queryCheck("SELECT Username, HPnow, HPall FROM ".SQL_PREFIX."players WHERE Username = '".$v['Player']."'");

$players_list_show .= ' <span class="'.$M.'">'.$result[0].'</span> ['.$result[1].'/'.$result[2].'] ';

if ($team == 1): if (empty($my_team_list)): $my_team_list = $result[0]; else:	$my_team_list = $my_team_list.', '.$result[0]; endif;  endif;
//конец
endforeach;
endif;


$players_list_show .= ' против';


$res = $db->queryArray("SELECT Player FROM ".SQL_PREFIX."battle_list WHERE (Team = '2') AND (dead = '0') AND (Id = '$BattleID')");
if(!empty($res)):
foreach($res as $v):
//начало

$result = $db->queryCheck("SELECT Username, HPnow, HPall FROM ".SQL_PREFIX."players WHERE Username = '".$v['Player']."'");

$players_list_show .= ' <span class="'.$E.'">'.$result[0].'</span> ['.$result[1].'/'.$result[2].'] ';

if ($team == 2): if (empty($my_team_list)): $my_team_list = $result[0]; else:	$my_team_list = $my_team_list.', '.$result[0]; endif; endif;
//конец
endforeach;
endif;

$players_list_show .= '<hr />';
?>
Для вас бой окончен. Подождите окончания боя<br />
<?=$players_list_show;?>
       <meta http-equiv="refresh" content="20;url=battle.php">
       <br /><input type="button" value="Обновить" class="oo" onmouseover="this.className = 'on';" onmouseout="this.className = 'oo';" onClick="window.location.href='battle.php'" />
<?
else:

list($is_finished) = $db->queryCheck("SELECT is_finished FROM ".SQL_PREFIX."battle_list WHERE Id = '$BattleID'");
$db->execQuery("UPDATE ".SQL_PREFIX."battle_list SET is_finished = '1' WHERE Id = '$BattleID'");

if ((empty($my_team_alive) || empty($enemy_team_alive) )&& (!$is_finished) ):

if (!empty($my_team_alive)):

$res = $db->query("SELECT Player FROM ".SQL_PREFIX."battle_list WHERE team = '$team' && Id = '$BattleID'");

for ($i=1;$i<=mysql_num_rows($res);$i++):
list($tname) = mysql_fetch_row($res);
if ($i > 1): $names .= ','; endif;
$names .= '<b>'.$tname.'</b>';
endfor;

else:

$res = $db->query("SELECT Player FROM ".SQL_PREFIX."battle_list WHERE team <> '$team' && Id = '$BattleID'");

for($i=1;$i<=mysql_num_rows($res);$i++):
list($tname) = mysql_fetch_row($res);
if ($i > 1): $names .= ','; endif;
$names .= '<b>'.$tname.'</b>';
endfor;

endif;

$Add_finished .= '<font class=date>'.date('H:i').'</font> Бой закончен. Победа за <i>'.$names.'</i>.<br />';
$db->execQuery("UPDATE ".SQL_PREFIX."logs SET Log = concat(Log, '".mysql_escape_string($Add_finished)."') WHERE Id = '$BattleID' LIMIT 1");

endif;

if ((empty($my_team_alive)) && (!empty($enemy_team_alive))):

$res = $db->queryArray("SELECT Username, BattleID FROM ".SQL_PREFIX."players WHERE Reg_IP = 'бот' AND Username NOT LIKE 'Тренер_%'");

foreach($res as $bot):
if ($bot['BattleID'] == $BattleID):
$arr = $db->queryFetchArray("SELECT id FROM ".SQL_PREFIX."map WHERE acses <> '1'"); shuffle($arr);
$db->execQuery("UPDATE `".SQL_PREFIX."players` SET BattleID = NULL, HPnow = HPall, map_id = '".$arr[0][0]."' WHERE Username = '".$bot['Username']."'");

if( $bot['Username'] != 'ЛамоБот' ):
$db->execQuery("UPDATE `".SQL_PREFIX."players` SET Won = Won + '1' WHERE Username = '".$bot['Username']."'");
endif;

endif;
endforeach;

$res = $db->queryArray("SELECT Username, BattleID FROM ".SQL_PREFIX."players WHERE Username LIKE 'Тренер_%'");

if( !empty($res) ):
foreach($res as $bot):
if ($bot['BattleID'] == $BattleID):
$db->execQuery("DELETE FROM ".SQL_PREFIX."players WHERE Username = '".$bot['Username']."'");
endif;
endforeach;
endif;

if ($Player->clanID == $voskr_clan): $db->execQuery("DELETE FROM ".SQL_PREFIX."dd WHERE Username = '$Player->login'"); endif;

if ($team == 1): $eteam = 2; endif;
if ($team == 2): $eteam = 1; endif;

$db->execQuery("UPDATE ".SQL_PREFIX."logs SET Team_won = '$eteam' WHERE Id = '$BattleID'");

updateThingsWear($Player->login, 90);

$db->execQuery("UPDATE ".SQL_PREFIX."players SET BattleID = NULL WHERE Username = '$Player->login'");
$db->execQuery("UPDATE ".SQL_PREFIX."players SET Lost = Lost + '1' WHERE Username = '$Player->login'");

$turn = $db->queryRow( "SELECT turnir_id, do_level, do_stre, do_agil, do_intu, do_intl, do_endu, do_ups, do_hpall FROM ".SQL_PREFIX."turnir_users WHERE user = '".$Player->login."';" );
if( $turn )
{
	$db->update( SQL_PREFIX.'players', Array( 'Level' => $turn['do_level'], 'Stre' => $turn['do_stre'], 'Agil' => $turn['do_agil'], 'Intu' => $turn['do_intu'], 'Intl' => $turn['do_intl'], 'Endu' => $turn['do_endu'], 'Ups' => $turn['do_ups'], 'HPnow' => 0, 'HPall' => $turn['do_hpall'] ), Array( 'Username' => $Player->login ) );	$Player->unwear_all();	$db->execQuery( "DELETE FROM ".SQL_PREFIX."turnir_users WHERE user = '".$Player->login."';" );    $db->execQuery( "DELETE t, th FROM ".SQL_PREFIX."things as t LEFT JOIN ".SQL_PREFIX."turnir_things as th ON (th.in_use = t.Un_Id) WHERE t.Owner = '".$Player->login."' AND t.Wear_ON = '0' AND th.in_use = t.Un_Id;");
    $db->update( SQL_PREFIX.'drunk', Array( 'Time' => time() ), Array( 'Username' => $Player->login ) );
	turnir_log( $turn['turnir_id'], 'В '.date('H:i:s').' '.slogin( $Player->login, $turn['do_level'], $Player->clanID ).' выбыл из турнира.' );
	turnir_msg( slogin( $Player->login, $turn['do_level'], $Player->clanID ).' выбыл из турнира.' );
}
$_SESSION['battles'] += 1;

$txt = '<font color=red>Внимание!</font> Вы проиграли. Всего вами нанесено урона: <B>'.$dmg.'</B>. Получено опыта: <B>0</B>';
echo $txt.'<br />';
?>
       <br /><input type="button" value="Вернуться" class="oo" onmouseover="this.className = 'on';" onmouseout="this.className = 'oo';" onClick="window.location.href='<?=$Player->room;?>.php'" />
<?
$db->execQuery("INSERT INTO `".SQL_PREFIX."messages` VALUES ('$Player->login', '".mysql_escape_string($txt)."');");
endif;



if ((!empty($my_team_alive)) && (empty($enemy_team_alive))):

$_SESSION['battles'] += 1;

$res = $db->queryArray("SELECT Username, BattleID FROM ".SQL_PREFIX."players WHERE Reg_IP = 'бот' AND Username NOT LIKE 'Тренер_%'");

foreach($res as $bot):
if ($bot['BattleID'] == $BattleID):
$arr = $db->queryFetchArray("SELECT id FROM ".SQL_PREFIX."map WHERE acses <> '1'"); shuffle($arr);
$db->execQuery("UPDATE `".SQL_PREFIX."players` SET BattleID = NULL, HPnow = HPall, map_id = '".$arr[0][0]."' WHERE Username = '".$bot['Username']."'");

if( $bot['Username'] != 'ЛамоБот' ):
$db->execQuery("UPDATE `".SQL_PREFIX."players` SET Lost = Lost + '1' WHERE Username = '".$bot['Username']."'");
if( !empty($_SESSION['battles']) && $_SESSION['battles']%3 == 0 ) get_drop( $Player->login, $_SESSION['battles'] );
endif;

endif;
endforeach;

$res = $db->queryArray("SELECT Username, BattleID FROM ".SQL_PREFIX."players WHERE Username LIKE 'Тренер_%'");

if( !empty($res) ):
foreach($res as $bot):
if ($bot['BattleID'] == $BattleID):
$db->execQuery("DELETE FROM ".SQL_PREFIX."players WHERE Username = '".$bot['Username']."'");
endif;
endforeach;
endif;

if ($Player->clanID == $voskr_clan): $db->execQuery("DELETE FROM ".SQL_PREFIX."dd WHERE Username = '$Player->login'"); endif;

$db->execQuery("UPDATE ".SQL_PREFIX."logs SET Team_won = '$team' WHERE Id = '$BattleID'");
$db->execQuery("UPDATE ".SQL_PREFIX."players SET BattleID = NULL WHERE Username = '$Player->login'");

updateThingsWear( $Player->login, 5 );

$give_exp = round( $dmg * getBattleExpNew( $Player->login, $BattleID ) / 100 );
//$give_exp = round( ( $dmg * getBattleExpNew( $Player->login, $BattleID ) / 100 ) * 2 );

if ($Player->clanID == 200) { $give_exp = round( $give_exp/2 ); }

$query = sprintf("UPDATE ".SQL_PREFIX."players SET Won = Won + '1', Expa = Expa + '%d' WHERE Username = '%s';",$give_exp, $Player->login);
$db->execQuery( $query );

$turn = $db->queryRow( "SELECT turnir_id, do_level FROM ".SQL_PREFIX."turnir_users WHERE user = '".$Player->login."';" );
if( $turn )
{	//$db->update( SQL_PREFIX.'turnir_users', Array( 'points' => '[+]1' ), Array( 'user' => $Player->login, 'turnir_id' => $id ), 'maths' );
	turnir_log( $turn['turnir_id'], 'В '.date('H:i:s').' '.slogin( $Player->login, $turn['do_level'], $Player->clanID ).' выиграл <a href="http://'.$db_config[DREAM]['server'].'/log.php?id='.$BattleID.'" target="_blank">бой ID: '.$BattleID.'.</a>.' );
	turnir_msg( slogin( $Player->login, $turn['do_level'], $Player->clanID ).' выиграл <a href="http://'.$db_config[DREAM]['server'].'/log.php?id='.$BattleID.'" target="_blank">бой ID: '.$BattleID.'.</a>' );

}



$msgPrivate = '<font color=red>Внимание!</font> Вы победили. Всего вами нанесено урона: <B>'.$dmg.'</B>. Получено опыта: <B>'.$give_exp.'</B>';
echo $msgPrivate.'<br />';

?>
       <br /><input type="button" value="Вернуться" class="oo" onmouseover="this.className = 'on';" onmouseout="this.className = 'oo';" onClick="window.location.href='<?=$Player->room;?>.php'" />
<?
$db->execQuery("INSERT INTO `".SQL_PREFIX."messages` VALUES ('$Player->login', '".mysql_escape_string($msgPrivate)."');");
endif;



if( (empty($my_team_alive)) && (empty($enemy_team_alive)) ):

$res = $db->queryArray("SELECT Username, BattleID FROM ".SQL_PREFIX."players WHERE Reg_IP = 'бот' AND Username NOT LIKE 'Тренер_%'");

foreach($res as $bot):
if ($bot['BattleID'] == $BattleID):
$arr = $db->queryFetchArray("SELECT id FROM ".SQL_PREFIX."map WHERE acses <> '1'"); shuffle($arr);
$db->execQuery("UPDATE `".SQL_PREFIX."players` SET BattleID = NULL, HPnow = HPall, map_id = '".$arr[0][0]."' WHERE Username = '".$bot['Username']."'");
endif;
endforeach;

$res = $db->queryArray("SELECT Username, BattleID FROM ".SQL_PREFIX."players WHERE Username LIKE 'Тренер_%'");

if( !empty($res) ):
foreach($res as $bot):
if ($bot['BattleID'] == $BattleID):
$db->execQuery("DELETE FROM ".SQL_PREFIX."players WHERE Username = '".$bot['Username']."'");
endif;
endforeach;
endif;


if ($Player->clanID == $voskr_clan): $db->execQuery("DELETE FROM ".SQL_PREFIX."dd WHERE Username = '$Player->login'"); endif;

//updateThingsWear( $Player->login, 20 );

$give_exp = round( $dmg * getBattleExpNew( $Player->login, $BattleID ) / (100 * 2) );
//$give_exp = round( ( $dmg * getBattleExpNew( $Player->login, $BattleID ) / 200 ) * 2 );

if ($Player->clanID == 200): $give_exp = 0; endif;


$db->execQuery("UPDATE ".SQL_PREFIX."players SET Expa = Expa + '$give_exp' WHERE Username = '$Player->login'");

$Add_finished .= '<font class="date">'.date('H:i').'</font> <b>Бой закончен. Ничья</b><br />';
$db->execQuery("UPDATE ".SQL_PREFIX."logs SET Log = concat(Log, '".mysql_escape_string($Add_finished)."') WHERE Id = '$BattleID' LIMIT 1");



$turn = $db->queryRow( "SELECT turnir_id, do_level, do_stre, do_agil, do_intu, do_intl, do_endu, do_ups, do_hpall FROM ".SQL_PREFIX."turnir_users WHERE user = '".$Player->login."';" );
if( $turn )
{	$db->update( SQL_PREFIX.'players', Array( 'Level' => $turn['do_level'], 'Stre' => $turn['do_stre'], 'Agil' => $turn['do_agil'], 'Intu' => $turn['do_intu'], 'Intl' => $turn['do_intl'], 'Endu' => $turn['do_endu'], 'Ups' => $turn['do_ups'], 'HPnow' => 0, 'HPall' => $turn['do_hpall'] ), Array( 'Username' => $Player->login ) );    turnir_log( $turn['turnir_id'], 'В '.date('H:i:s').' '.slogin( $Player->login, $turn['do_level'], $Player->clanID ).' выбыл из турнира.' );
	turnir_msg( slogin( $Player->login, $turn['do_level'], $Player->clanID ).' выбыл из турнира.' );
	test_turnir($turn['turnir_id']);
	$Player->unwear_all();
	$db->execQuery( "DELETE FROM ".SQL_PREFIX."turnir_users WHERE user = '".$Player->login."';" );
    $db->execQuery( "DELETE t, th FROM ".SQL_PREFIX."things as t LEFT JOIN ".SQL_PREFIX."turnir_things as th ON (th.in_use = t.Un_Id) WHERE t.Owner = '".$Player->login."' AND t.Wear_ON = '0' AND th.in_use = t.Un_Id;");
    $db->update( SQL_PREFIX.'drunk', Array( 'Time' => time() ), Array( 'Username' => $Player->login ) );
}

$_SESSION['battles'] += 1;

$db->execQuery("UPDATE ".SQL_PREFIX."players SET BattleID = NULL WHERE Username = '$Player->login'");

$txt = '<font color=red>Внимание!</font> Ничья. Всего вами нанесено урона: <B>'.$dmg.'</B>. Получено опыта: <B>'.$give_exp.'</B>';
echo $txt.'<br />';
?>
     <br /><input type="button" value="Вернуться" class="oo" onmouseover="this.className = 'on';" onmouseout="this.className = 'oo';" onClick="window.location.href='<?=$Player->room;?>.php'" />
<?
$db->execQuery("INSERT INTO `".SQL_PREFIX."messages` VALUES ('$Player->login', '".mysql_escape_string($txt)."');");
endif;

endif;
?>
     </center><hr /><br />
     <font class="dsc">(Таймаут 3 мин.)</font><br />
     Нанесено урона: <b><?=$dmg;?></b><br />
     <? if (count($rev_log) < 26): $lines = count($rev_log); else: $lines = 26; endif; ?>
     <? for($i=0; $i<$lines; $i++): print $rev_log[$i].' <br />'; endfor; ?><br />
     <font color="red">Вырезано для уменьшения лога.</font> | <a href="log.php?id=<?=$BattleID;?>" target="_blank">Полный лог боя</a>
    </td>
    <td  valign="top" align="rigth"><img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/battle/<?=rand(1,10);?>.gif" /></td>
  </tr>
 </table>
</body>
</html>

