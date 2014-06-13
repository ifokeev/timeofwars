<?php
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

session_start();
if (empty($_SESSION['login'])) { include_once('includes/bag_log_in.php'); exit; }
function get_value($s){ global $_GET, $_POST; if ( isset($_POST[$s]) ) return $_POST[$s]; elseif (isset($_GET[$s]) ) return $_GET[$s]; return ''; }

if ($_SESSION['login'] != 'Албано' && $_SESSION['login'] != 'Албано' ){ die('Вы не являетесь администратором'); }

include_once ('includes/to_view.php');
include_once ('db_config.php');
include_once ('db.php');

@$action = get_value('Action');
$db->checklevelup( $_SESSION['login'] );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru" id="timeofwars">
<head>
   <title>Дилерская админка</title>
   <meta content="text/html; charset=windows-1251" http-equiv=Content-type>
   <meta Http-Equiv=Cache-Control Content="no-cache, max-age=0, must-revalidate, no-store">
   <meta http-equiv=PRAGMA content=NO-CACHE>
   <meta Http-Equiv=Expires Content=0>
   <link rel="stylesheet" type="text/css" href="http://<?=$db_config[DREAM]['other'];?>/css/main.css">
</head>
<body bgColor="#f0f0f0">
<table width="100%" height="25" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <a href="?Action=level">Левел</a>
    <a href="?Action=thingadd">Новая вещь</a>
    <a href="?Action=Things">Предметы</a>
    <a href="?Action=Logs">Логи</a></td>
    <a href="?Action=ekred">Начисление Кр/Екр</a>
    <a href="?Action=clan">Кланы</a>

  </tr>
</table>
<?
if (empty($action)) { print '<p><b>Выберите раздел</b></p>'; }
if (!empty($action) &&  $action == 'level'){

if( !empty($_POST['new_vars']) && !empty($_POST['new_user']) && !empty($_POST['new_exp']) )
{	if( $_SESSION['login'] == 'DRAKO' ){ die('Безопасность. запрещено.'); }

	$db->update( SQL_PREFIX.'players', Array( 'Expa' => intval($_POST['new_exp']) ), Array( 'Username' => speek_to_view($_POST['new_user']) ) );
	echo 'сделано для юзера '.$_POST['new_user'];
}
?>
<form method="POST"><br /><br />
Юзер <input type="text" name="new_user" value="" /><br />
Експа <input type="text" name="new_exp" value="" /><br />
<input type="submit" name="new_vars" value="Я никому не принесу зла" />
</form>
<?
}
if (!empty($action) &&  $action == 'thingadd'){

if ( (!empty($_POST['act']) && $_POST['act'] == 'addnewthing') && !empty($_POST['ADDNEWTHING']) ){
if( $_SESSION['login'] == 'DRAKO' ){ die('Безопасность. запрещено.'); }
$table = ($_POST['where'] == '1' ? 'things_shop' : ( $_POST['where'] == '2' ? 'things_euroshop' : ( $_POST['where'] == '3' ? 'things_presentshop' : '')));

if($table == 'things_shop'){
$db->execQuery("INSERT INTO ".SQL_PREFIX."things_shop (Amount, Otdel, Id, Thing_Name, Slot, Cost, Level_need, Stre_need, Agil_need, Intu_need, Endu_need, Clan_need, Level_add, Stre_add, Agil_add, Intu_add, Endu_add, MINdamage, MAXdamage, Crit, AntiCrit, Uv, AntiUv, Armor1, Armor2, Armor3, Armor4, MagicID, NOWwear, MAXwear, Srab) VALUES ('".intval($_POST['countThings'])."', '".intval($_POST['Fotdel'])."', '".speek_to_view($_POST['FId'])."', '".speek_to_view($_POST['FThing_Name'])."', '".intval($_POST['FSlot'])."', '".intval($_POST['FCost'])."', '".intval($_POST['FLevel_need'])."', '".intval($_POST['FStre_need'])."', '".intval($_POST['FAgil_need'])."', '".intval($_POST['FIntu_need'])."', '".intval($_POST['FEndu_need'])."', '".intval($_POST['FClan_need'])."', '".speek_to_view($_POST['FLevel_add'])."', '".intval($_POST['FStre_add'])."', '".intval($_POST['FAgil_add'])."', '".intval($_POST['FIntu_add'])."', '".intval($_POST['FEndu_add'])."', '".intval($_POST['FMINdamage'])."', '".intval($_POST['FMAXdamage'])."', '".intval($_POST['FCrit'])."', '".intval($_POST['FAntiCrit'])."', '".intval($_POST['FUv'])."', '".intval($_POST['FAntiUv'])."', '".intval($_POST['FArmor1'])."', '".intval($_POST['FArmor2'])."', '".intval($_POST['FArmor3'])."', '".intval($_POST['FArmor4'])."', '".speek_to_view($_POST['FMagicID'])."', '0', '".intval($_POST['FMAXwear'])."', '".intval($_POST['FSrab'])."') ");
echo "<font color=red><b>Успешно добавлено</b></font>";
}

if($table == 'things_euroshop'){
$db->execQuery("INSERT INTO ".SQL_PREFIX."things_euroshop (Amount, Otdel, Id, Thing_Name, Slot, Eurocost, Level_need, Stre_need, Agil_need, Intu_need, Endu_need, Clan_need, Level_add, Stre_add, Agil_add, Intu_add, Endu_add, MINdamage, MAXdamage, Crit, AntiCrit, Uv, AntiUv, Armor1, Armor2, Armor3, Armor4, MagicID, NOWwear, MAXwear, Srab, Cost) VALUES ('".intval($_POST['countThings'])."', '".intval($_POST['Fotdel'])."', '".speek_to_view($_POST['FId'])."', '".speek_to_view($_POST['FThing_Name'])."', '".intval($_POST['FSlot'])."', '".intval($_POST['FCost'])."', '".intval($_POST['FLevel_need'])."', '".intval($_POST['FStre_need'])."', '".intval($_POST['FAgil_need'])."', '".intval($_POST['FIntu_need'])."', '".intval($_POST['FEndu_need'])."', '".intval($_POST['FClan_need'])."', '".speek_to_view($_POST['FLevel_add'])."', '".intval($_POST['FStre_add'])."', '".intval($_POST['FAgil_add'])."', '".intval($_POST['FIntu_add'])."', '".intval($_POST['FEndu_add'])."', '".intval($_POST['FMINdamage'])."', '".intval($_POST['FMAXdamage'])."', '".intval($_POST['FCrit'])."', '".intval($_POST['FAntiCrit'])."', '".intval($_POST['FUv'])."', '".intval($_POST['FAntiUv'])."', '".intval($_POST['FArmor1'])."', '".intval($_POST['FArmor2'])."', '".intval($_POST['FArmor3'])."', '".intval($_POST['FArmor4'])."', '".speek_to_view($_POST['FMagicID'])."', '0','".intval($_POST['FMAXwear'])."', '".intval($_POST['FSrab'])."', '1000') ");
echo "<font color=red><b>Успешно добавлено</b></font>";
}

if($table == 'things_presentshop'){
$db->execQuery("INSERT INTO ".SQL_PREFIX."things_presentshop (presentNAME, presentIMG, presentABOUT, presentPRICE, presentCOUNT) VALUES ('".speek_to_view($_POST['FThing_Name'])."', '".speek_to_view($_POST['FId'])."', '".speek_to_view($_POST['FMagicID'])."', '".intval($_POST['FCost'])."', '".intval($_POST['countThings'])."')");
echo "<font color=red><b>Успешно добавлено</b></font>";
}


}
?>
<form method="post">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr valign="top">
      <td width="400"> <strong>Общие характеристики:</strong>
        <input name="act" type="hidden"  value="addnewthing">
          <br>
        <table border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="150px">Куда?</td>
            <td width="150px">
            <SELECT style="width:110px;" name="where" style="width: 160;">
		        <OPTION value="1">Магазин</OPTION>
	         	<OPTION value="2">Евромагазин</OPTION>
		        <OPTION value="3">Магазин подарков</OPTION>
		        </SELECT>
            </td>
          </tr>
          <tr>
            <td width="150px">картинка</td>
            <td width="150px"><input name="FId" type="text" id="FId" value=""></td>
          </tr>
          <tr>
            <td width="150px">Имя</td>
            <td width="150px"><input name="FThing_Name" type="text" id="FThing_Name" value=""></td>
          </tr>
          <tr>
            <td width="150px">Отдел</td>
            <td width="150px"><input name="Fotdel" type="text" id="Fotdel" value=""></td>
          </tr>
          <tr>
            <td width="150px">Слот</td>
            <td width="150px"><input name="FSlot" type="text" id="FSlot" value=""></td>
          </tr>
          <tr>
            <td width="150px">Цена</td>
            <td width="150px"><input name="FCost" type="text" id="FCost" value=""></td>
          </tr>
          <tr>
            <td width="150px">Долговечность</td>
            <td width="150px"><input type="text" name="FMAXwear" value="1"></td>
          </tr>
          <tr>
            <td width="150px">Количество</td>
            <td width="150px"><input name="countThings" type="text" value="999"></td>
          </tr>
        </table>
        <strong><br>
        Требования:</strong><br> <table border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="210">Требуется уровень</td>
            <td width="150"> <input name="FLevel_need" type="text" id="FLevel_need" value="">
            </td>
          </tr>
          <tr>
            <td>Требуется силы</td>
            <td><input type="text" name="FStre_need"  value=""></td>
          </tr>
          <tr>
            <td>Требуется интуиции</td>
            <td><input type="text" name="FIntu_need" value=""></td>
          </tr>
          <tr>
            <td>Требуется ловкости</td>
            <td><input type="text" name="FAgil_need" value=""></td>
          </tr>
          <tr>
            <td>Требуется выносливости</td>
            <td><input type="text" name="FEndu_need" value=""></td>
          </tr>
          <tr>
            <td>Требуется клан</td>
            <td><input type="text" name="FClan_need" value=""></td>
          </tr>
        </table>
  </td>
      <td width="360">
        <strong>Действует на:</strong>
        <table border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="210">Уровень</td>
            <td width="150"> <input type="text" name="FLevel_add" value="">
            </td>
          </tr>
          <tr>
            <td>Сила</td>
            <td><input type="text" name="FStre_add" value=""></td>
          </tr>
          <tr>
            <td>Интуиция</td>
            <td><input name="FIntu_add" type="text" value=""></td>
          </tr>
          <tr>
            <td>Ловкость</td>
            <td><input name="FAgil_add" type="text" id="FAgil_add" value=""></td>
          </tr>
          <tr>
            <td>Выносливость</td>
            <td><input name="FEndu_add" type="text" id="FEndu_add" value=""></td>
          </tr>
          <tr>
            <td>Макс. удар</td>
            <td><input name="FMAXdamage" type="text" id="FMAXdamage2" value=""></td>
          </tr>
          <tr>
            <td>Мин. удар</td>
            <td><input name="FMINdamage" type="text" id="FMINdamage2" value=""></td>
          </tr>
          <tr>
            <td>Вероятность крита</td>
            <td><input name="FCrit" type="text" id="FCrit2" value=""></td>
          </tr>
          <tr>
            <td>Вероятность уворота</td>
            <td><input name="FUv" type="text" id="FUv2" value=""></td>
          </tr>
          <tr>
            <td>Вероятность антикрита</td>
            <td><input name="FAntiCrit" type="text" id="FAntiCrit2" value=""></td>
          </tr>
          <tr>
            <td>Вероятность антиуворота</td>
            <td><input name="FAntiUv" type="text" id="FAntiUv2" value=""></td>
          </tr>
          <tr>
            <td>Броня головы</td>
            <td><input name="FArmor1" type="text" id="FArmor12" value=""></td>
          </tr>
          <tr>
            <td>Броня корпуса</td>
            <td><input name="FArmor2" type="text" id="FArmor22" value=""></td>
          </tr>
          <tr>
            <td>Броня пояса</td>
            <td><input name="FArmor3" type="text" id="FArmor32" value=""></td>
          </tr>
          <tr>
            <td>Броня ног</td>
            <td><input name="FArmor4" type="text" id="FArmor42" value=""></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Встроенная магия</td>
            <td><input name="FMagicID" type="text"  value=""></td>
          </tr>
          <tr>
            <td>Вероятность срабатывания</td>
            <td><input name="FSrab" type="text" value=""></td>
          </tr>
        </table></td>
    </tr>
  </table>
  <p>
    <input type="submit" name="ADDNEWTHING" value="Добавить" class="oo" ONMOUSEOVER="this.className = 'on';" ONMOUSEOUT="this.className = 'oo';">
  </p>
</form>
<?
}
if (!empty($action) && ($action == 'Things' || $action == 'Select' || $action == 'Update')){
?>
<form name="form1" method="post" action="">
  <p><strong>Изменение характеристик предмета
    <input name="Action" type="hidden" value="Select">
    </strong></p>
  <table border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="210">ID предмета</td>
      <td width="210"><input name="FUn_Id" type="text"></td>
    </tr>
  </table><br>
    <input type="submit" name="Submit" value="Выбрать" class="oo" ONMOUSEOVER="this.className = 'on';" ONMOUSEOUT="this.className = 'oo';">

 </form>

<?
}

if(!empty($action) && ($action == 'Select' || $action == 'Update') ){

if( (isset($_POST['FUn_Id'])) && ($_POST['FUn_Id'] != '') ){

$Un_Id =  $_POST['FUn_Id'];

if(!empty($action) && $action == 'Select' ){

if( $dat = $db->queryRow("SELECT * FROM ".SQL_PREFIX."things WHERE Un_Id = '{$_POST['FUn_Id']}'") ){
?>
<hr>
				<form name="form2" method="post" action="">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr valign="top">
      <td width="400"> <strong>Общие характеристики:</strong>
        <input name="Action" type="hidden"  value="Update">
          <br>
        <table border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="210">Владелец</td>
            <td width="150"> <input name="FOwner" type="text" id="FOwner" value="<?echo $dat['Owner'];?>">
            </td>
          </tr>
          <tr>
            <td>Уникальный ID </td>
            <td><input name="FUn_Id" type="text"  value="<?echo $dat['Un_Id'];?>"></td>
          </tr>
          <tr>
            <td>ID</td>
            <td><input name="FId" type="text" id="FId" value="<?echo $dat['Id'];?>"></td>
          </tr>
          <tr>
            <td>Имя</td>
            <td><input name="FThing_Name" type="text" id="FThing_Name" value="<?echo $dat['Thing_Name'];?>"></td>
          </tr>
          <tr>
            <td>Слот</td>
            <td><input name="FSlot" type="text" id="FSlot" value="<?echo $dat['Slot'];?>"></td>
          </tr>
          <tr>
            <td>Цена</td>
            <td><input name="FCost" type="text" id="FCost" value="<?echo $dat['Cost'];?>"></td>
          </tr>
          <tr>
            <td>Макс. долговечность</td>
            <td><input type="text" name="FMAXwear" value="<?echo $dat['MAXwear'];?>"></td>
          </tr>
          <tr>
            <td>Текущая долговечность</td>
            <td><input name="FNOWwear" type="text" value="<?echo $dat['NOWwear'];?>"></td>
          </tr>
        </table>
        <strong><br>
        Требования:</strong><br> <table border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="210">Требуется уровень</td>
            <td width="150"> <input name="FLevel_need" type="text" id="FLevel_need" value="<?echo $dat['Level_need'];?>">
            </td>
          </tr>
          <tr>
            <td>Требуется силы</td>
            <td><input type="text" name="FStre_need"  value="<?echo $dat['Stre_need'];?>"></td>
          </tr>
          <tr>
            <td>Требуется интуиции</td>
            <td><input type="text" name="FIntu_need" value="<?echo $dat['Intu_need'];?>"></td>
          </tr>
          <tr>
            <td>Требуется ловкости</td>
            <td><input type="text" name="FAgil_need" value="<?echo $dat['Agil_need'];?>"></td>
          </tr>
          <tr>
            <td>Требуется выносливости</td>
            <td><input type="text" name="FEndu_need" value="<?echo $dat['Endu_need'];?>"></td>
          </tr>
          <tr>
            <td>Требуется клан</td>
            <td><input type="text" name="FClan_need" value="<?echo $dat['Clan_need'];?>"></td>
          </tr>
        </table>
  </td>
      <td width="360">
        <strong>Действует на:</strong>
        <table border="0" cellspacing="0" cellpadding="0">
          <!---tr>
            <td width="210">Уровень</td>
            <td width="150"> <input type="text" name="FLevel_add" value="<?echo $dat['Level_add'];?>">
            </td>
          </tr--->
          <tr>
            <td>Сила</td>
            <td><input type="text" name="FStre_add" value="<?echo $dat['Stre_add'];?>"></td>
          </tr>
          <tr>
            <td>Интуиция</td>
            <td><input name="FIntu_add" type="text" value="<?echo $dat['Intu_add'];?>"></td>
          </tr>
          <tr>
            <td>Ловкость</td>
            <td><input name="FAgil_add" type="text" id="FAgil_add" value="<?echo $dat['Agil_add'];?>"></td>
          </tr>
          <tr>
            <td>Выносливость</td>
            <td><input name="FEndu_add" type="text" id="FEndu_add" value="<?echo $dat['Endu_add'];?>"></td>
          </tr>
          <tr>
            <td>Макс. удар</td>
            <td><input name="FMAXdamage" type="text" id="FMAXdamage2" value="<?echo $dat['MAXdamage'];?>"></td>
          </tr>
          <tr>
            <td>Мин. удар</td>
            <td><input name="FMINdamage" type="text" id="FMINdamage2" value="<?echo $dat['MINdamage'];?>"></td>
          </tr>
          <tr>
            <td>Вероятность крита</td>
            <td><input name="FCrit" type="text" id="FCrit2" value="<?echo $dat['Crit'];?>"></td>
          </tr>
          <tr>
            <td>Вероятность уворота</td>
            <td><input name="FUv" type="text" id="FUv2" value="<?echo $dat['Uv'];?>"></td>
          </tr>
          <tr>
            <td>Вероятность антикрита</td>
            <td><input name="FAntiCrit" type="text" id="FAntiCrit2" value="<?echo $dat['AntiCrit'];?>"></td>
          </tr>
          <tr>
            <td>Вероятность антиуворота</td>
            <td><input name="FAntiUv" type="text" id="FAntiUv2" value="<?echo $dat['AntiUv'];?>"></td>
          </tr>
          <tr>
            <td>Броня головы</td>
            <td><input name="FArmor1" type="text" id="FArmor12" value="<?echo $dat['Armor1'];?>"></td>
          </tr>
          <tr>
            <td>Броня корпуса</td>
            <td><input name="FArmor2" type="text" id="FArmor22" value="<?echo $dat['Armor2'];?>"></td>
          </tr>
          <tr>
            <td>Броня пояса</td>
            <td><input name="FArmor3" type="text" id="FArmor32" value="<?echo $dat['Armor3'];?>"></td>
          </tr>
          <tr>
            <td>Броня ног</td>
            <td><input name="FArmor4" type="text" id="FArmor42" value="<?echo $dat['Armor4'];?>"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Встроенная магия</td>
            <td><input name="FMagicID" type="text"  value="<?echo $dat['MagicID'];?>"></td>
          </tr>
          <tr>
            <td>Вероятность срабатывания</td>
            <td><input name="FSrab" type="text" value="<?echo $dat['Srab'];?>"></td>
          </tr>
        </table></td>
    </tr>
  </table>
  <p>
    <input type="submit" name="Update" value="Обновить" class="oo" ONMOUSEOVER="this.className = 'on';" ONMOUSEOUT="this.className = 'oo';">
  </p>
  </form>

<?
} else { print '<font color = red>Предмет с уникальным ID '.$Un_Id.' не найден 1</font>'; }

}

if (!empty($action) && $action == 'Update') {
$st = ''; $st2 = '';

if( $dat = $db->queryRow("SELECT * FROM ".SQL_PREFIX."things WHERE Un_Id = '$Un_Id'") ){


$Owner = $_POST['FOwner'];
$Id = $_POST['FId'];
$Thing_Name = $_POST['FThing_Name'];
$Slot = $_POST['FSlot'];
$Cost = $_POST['FCost'];
$Level_need  = $_POST['FLevel_need'];
$Stre_need = $_POST['FStre_need'];
$Agil_need = $_POST['FAgil_need'];
$Intu_need = $_POST['FIntu_need'];
$Endu_need = $_POST['FEndu_need'];
$Clan_need = $_POST['FClan_need'];
$Level_add = $_POST['FLevel_add'];
$Stre_add = $_POST['FStre_add'];
$Agil_add = $_POST['FAgil_add'];
$Intu_add = $_POST['FIntu_add'];
$Endu_add = $_POST['FEndu_add'];
$MINdamage = $_POST['FMINdamage'];
$MAXdamage = $_POST['FMAXdamage'];
$Crit = $_POST['FCrit'];
$AntiCrit = $_POST['FAntiCrit'];
$Uv = $_POST['FUv'];
$AntiUv = $_POST['FAntiUv'];
$Armor1 = $_POST['FArmor1'];
$Armor2 = $_POST['FArmor2'];
$Armor3 = $_POST['FArmor3'];
$Armor4 = $_POST['FArmor4'];

$MAXwear = $_POST['FMAXwear'];
$NOWwear = $_POST['FNOWwear'];

$MagicID = $_POST['FMagicID'];
$Srab = $_POST['FSrab'];

$st2 .= "Thing_Name = '$Thing_Name'";

if ($Owner != $dat['Owner']) {            $st .= 'Owner '.$dat['Owner'].' => '.$Owner.'; ';                  $st2 .= ", Owner = '$Owner'";              }
if ($Id != $dat['Id']) {                  $st .= 'Id '.$dat['Id'].' => '.$Id.'; ';                           $st2 .= ", Id = '$Id'";                    }
if ($Thing_Name != $dat['Thing_Name']) {  $st .= 'Thing_Name '.$dat['Thing_Name'].' => '.$Thing_Name.'; ';                                              }
if ($Slot != $dat['Slot']) {              $st .= 'Slot '.$dat['Slot'].' => '.$Slot.'; ';                     $st2 .= ", Slot = '$Slot'";                }
if ($Cost != $dat['Cost']) {              $st .= 'Cost '.$dat['Cost'].' => '.$Cost.'; ';                     $st2 .= ", Cost = '$Cost'";                }
if ($Level_need != $dat['Level_need']) {  $st .= 'Level_need '.$dat['Level_need'].' => '.$Level_need.'; ';   $st2 .= ", Level_need = '$Level_need'";    }
if ($Stre_need != $dat['Stre_need']) {    $st .= 'Stre_need '.$dat['Stre_need'].' => '.$Stre_need.'; ';      $st2 .= ", Stre_need = '$Stre_need'";      }
if ($Agil_need != $dat['Agil_need']) {    $st .= 'Agil_need '.$dat['Agil_need'].' => '.$Agil_need.'; ';      $st2 .= ", Agil_need = '$Agil_need'";      }
if ($Intu_need != $dat['Intu_need']) {    $st .= 'Intu_need '.$dat['Intu_need'].' => '.$Intu_need.'; ';      $st2 .= ", Intu_need = '$Intu_need'";      }
if ($Endu_need != $dat['Endu_need']) {    $st .= 'Endu_need '.$dat['Endu_need'].' => '.$Endu_need.'; ';      $st2 .= ", Endu_need = '$Endu_need'";      }
if ($Clan_need != $dat['Clan_need']) {    $st .= 'Clan_need '.$dat['Clan_need'].' => '.$Clan_need.'; ';      $st2 .= ", Clan_need = '$Clan_need'";      }
if ($Level_add != $dat['Level_add']) {    $st .= 'Level_add '.$dat['Level_add'].' => '.$Level_add.'; ';      $st2 .= ", Level_add = '$Level_add'";      }
if ($Stre_add != $dat['Stre_add']) {      $st .= 'Stre_add '.$dat['Stre_add'].' => '.$Stre_add.'; ';         $st2 .= ", Stre_add = '$Stre_add'";        }
if ($Agil_add != $dat['Agil_add']) {      $st .= 'Agil_add '.$dat['Agil_add'].' => '.$Agil_add.'; ';         $st2 .= ", Agil_add = '$Agil_add'";        }
if ($Intu_add != $dat['Intu_add']) {      $st .= 'Intu_add '.$dat['Intu_add'].' => '.$Intu_add.'; ';         $st2 .= ", Intu_add = '$Intu_add'";        }
if ($Endu_add != $dat['Endu_add']) {      $st .= 'Endu_add '.$dat['Endu_add'].' => '.$Endu_add.'; ';         $st2 .= ", Endu_add = '$Endu_add'";        }
if ($MINdamage != $dat['MINdamage']) {    $st .= 'MINdamage '.$dat['MINdamage'].' => '.$MINdamage.'; ';      $st2 .= ", MINdamage = '$MINdamage'";      }
if ($MAXdamage != $dat['MAXdamage']) {    $st .= 'MAXdamage '.$dat['MAXdamage'].' => '.$MAXdamage.'; ';      $st2 .= ", MAXdamage = '$MAXdamage'";      }
if ($Crit != $dat['Crit']) {              $st .= 'Crit '.$dat['Crit'].' => '.$Crit.'; ';                     $st2 .= ", Crit = '$Crit'";                }
if ($AntiCrit != $dat['AntiCrit']) {      $st .= 'AntiCrit '.$dat['AntiCrit'].' => '.$AntiCrit.'; ';         $st2 .= ", AntiCrit = '$AntiCrit'";        }
if ($Uv != $dat['Uv']) {                  $st .= 'Uv '.$dat['Uv'].' => '.$Uv.'; ';                           $st2 .= ", Uv = '$Uv'";                    }
if ($AntiUv != $dat['AntiUv']) {          $st .= 'AntiUv '.$dat['AntiUv'].' => '.$AntiUv.'; ';               $st2 .= ", AntiUv = '$AntiUv'";            }
if ($Armor1 != $dat['Armor1']) {          $st .= 'Armor1 '.$dat['Armor1'].' => '.$Armor1.'; ';               $st2 .= ", Armor1 = '$Armor1'";            }
if ($Armor2 != $dat['Armor2']) {          $st .= 'Armor2 '.$dat['Armor2'].' => '.$Armor2.'; ';               $st2 .= ", Armor2 = '$Armor2'";            }
if ($Armor3 != $dat['Armor3']) {          $st .= 'Armor3 '.$dat['Armor3'].' => '.$Armor3.'; ';               $st2 .= ", Armor3 = '$Armor3'";            }
if ($Armor4 != $dat['Armor4']) {          $st .= 'Armor4 '.$dat['Armor4'].' => '.$Armor4.'; ';               $st2 .= ", Armor4 = '$Armor4'";            }
if ($MAXwear != $dat['MAXwear']) {        $st .= 'MAXwear '.$dat['MAXwear'].' => '.$MAXwear.'; ';            $st2 .= ", MAXwear = '$MAXwear'";          }
if ($NOWwear != $dat['NOWwear']) {        $st .= 'NOWwear '.$dat['NOWwear'].' => '.$NOWwear.'; ';            $st2 .= ", NOWwear = '$NOWwear'";          }
if ($MagicID != $dat['MagicID']) {        $st .= 'MagicID '.$dat['MagicID'].' => '.$MagicID.'; ';            $st2 .= ", MagicID = '$MagicID'";          }
if ($Srab != $dat['Srab']) {              $st .= 'Srab '.$dat['Srab'].' => '.$Srab.'; ';                     $st2 .= ", Srab = '$Srab'";                }


if ($st != '') {

$st = '<b>'.$_SESSION['login'].'</b> '.$st;
print '<font color = red>Произведены изменения: '.$st.'</font><br>';

$db->execQuery("UPDATE ".SQL_PREFIX."things SET ".$st2." WHERE Un_Id = '$Un_Id'");
$db->execQuery("INSERT INTO ".SQL_PREFIX."dealers_log (Un_Id, Log) VALUES ('$Un_Id', '$st')");

}	else { print '<font color = red>Изменений не произведено</font><br>'; }

} else { print '<font color = red>Предмет с уникальным ID '.$Un_Id.' не найден</font>'; }

}

} else { print '<font color = red>Не указан уникальный ID предмета</font>'; }

}


if ($action == 'ekred') {
print '<br><b>Начисление Кр/Екр</b><br><br>';
print '<a href=\'dealerEuro.php\' target=_blank class=\'private\'>Начислить Кредиты/Еврокредиты</a>';
}


if ($action == 'clan') {
print '<br><b>Управление кланами</b><br><br>';
print '<a href=\'clans.php\' target=_blank class=\'private\'>Создание/Редактирование кланов</a>';
}

if ($action == 'Logs') {

print '<br><b>Логи</b><br><br>';

$dat = $db->queryArray("SELECT * FROM ".SQL_PREFIX."dealers_log ORDER BY ID DESC");

if(!empty($dat)){
foreach($dat as $v){
print '№ '.$v['ID'].' ID предмета: <a href=\'thing.php?thing='.$v['Un_ID'].'\' target=\'_Blank\'>'.$v['Un_ID'].'</a> '.$v['Log'].'<br>';
}
}

}
?>
</body>
</html>
