<?php
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

session_start();
if (empty($_SESSION['login'])) { include_once('includes/bag_log_in.php'); exit; }

include_once ('includes/to_view.php');
include_once ('db_config.php');
include_once ('db.php');

if ( list($why) = $db->queryCheck("SELECT Why FROM ".SQL_PREFIX."blocked WHERE Username = '".$_SESSION['login']."'") ) { die( sprintf(playerblocked, $why) ); } unset($why);

$db->checklevelup( $_SESSION['login'] );

$res = $db->queryCheck("SELECT Username, ClanID FROM ".SQL_PREFIX."players WHERE Username = '".$_SESSION['login']."'");
if($res[0] == 'DRAKO'){ die('больше ботов не получишь'); }
if($res[1] != 255 && $res[0] != 'Албано'){ die; }
@$_POST['bot_name'] = speek_to_view($_POST['bot_name']);


if(!empty($_POST['bot_name']) && isset($_POST['bot_lvl']) && !empty($_POST['bot_str']) && !empty($_POST['bot_agil']) && !empty($_POST['bot_intu']) && !empty($_POST['bot_endu']) && !empty($_POST['bot_hpall']) && isset($_POST['bot_clanid']) && isset($_POST['bot_pict']) && !empty($_POST['bot_room']) && !empty($_POST['bot_sex']) && !empty($_POST['bot_mapid']) ){

if( empty($_POST['bot_lvl']) ){ $_POST['bot_lvl'] = 0; }
$_POST['bot_pict']                                = preg_replace('/[^a-zA-Z0-9\_\-\/]/', '', $_POST['bot_pict']);

if( !empty($_POST['add_bot']) ){

if( strlen($_POST['bot_name']) > 10 ){ echo '<br /><center><b>Слишком длинный никнейм. Макс. - 10 символов.</b></center>'; die; }

if( !$db->queryRow("SELECT Username FROM ".SQL_PREFIX."players WHERE Username = '".$_POST['bot_name']."'") ){
$db->execQuery("INSERT INTO ".SQL_PREFIX."players
( Username, Password, Level, Stre, Agil, Intu, Endu, HPnow, HPall, ClanID, Pict, Room, ChatRoom, Sex, Reg_IP, map_id ) VALUES
( '".$_POST['bot_name']."', '".make_password(mt_rand(5,10), 0)."', '".intval($_POST['bot_lvl'])."', '".intval($_POST['bot_str'])."', '".intval($_POST['bot_agil'])."', '".intval($_POST['bot_intu'])."', '".intval($_POST['bot_endu'])."', '".intval($_POST['bot_hpall'])."', '".intval($_POST['bot_hpall'])."', '".intval($_POST['bot_clanid'])."', '".$_POST['bot_pict']."', '".$_POST['bot_room']."', '".$_POST['bot_room']."',  '".$_POST['bot_sex']."', 'бот', '".intval($_POST['bot_mapid'])."' )");

if($_POST['bot_clanid'] == 0){ }
elseif(!$db->queryCheck("SELECT * FROM ".SQL_PREFIX."clan_user WHERE Username = '".$_POST['bot_name']."'") ){ $db->execQuery("INSERT INTO ".SQL_PREFIX."clan_user (id_clan, Username, admin, id_rank) VALUES ('".intval($_POST['bot_clanid'])."', '".$_POST['bot_name']."', '0', '0')"); }
else{ $db->execQuery("UPDATE ".SQL_PREFIX."clan_user SET id_clan = '".intval($_POST['bot_clanid'])."' WHERE Username = '".$_POST['bot_name']."'"); }

echo 'готово';
} else {
echo '<br /><center><b>Такой персонаж уже существует</b></center>';
}

} elseif( !empty($_POST['readd_bot']) ){

if( $db->queryRow("SELECT Username FROM ".SQL_PREFIX."players WHERE Username = '".$_POST['bot_name']."' AND Reg_IP = 'бот'") ){
$db->execQuery("UPDATE ".SQL_PREFIX."players SET Level = '".intval($_POST['bot_lvl'])."', Stre = '".intval($_POST['bot_str'])."', Agil = '".intval($_POST['bot_agil'])."', Intu = '".intval($_POST['bot_intu'])."', Endu = '".intval($_POST['bot_endu'])."', HPnow = '".intval($_POST['bot_hpall'])."', HPall = '".intval($_POST['bot_hpall'])."', ClanID = '".intval($_POST['bot_clanid'])."', Pict = '".$_POST['bot_pict']."', Room = '".$_POST['bot_room']."', ChatRoom = '".$_POST['bot_room']."', Sex = '".$_POST['bot_sex']."', map_id = '".intval($_POST['bot_mapid'])."' WHERE Username = '".$_POST['bot_name']."'");

if($_POST['bot_clanid'] == 0){ $db->execQuery("DELETE FROM ".SQL_PREFIX."clan_user WHERE Username = '".$_POST['bot_name']."'"); }
elseif(!$db->queryCheck("SELECT * FROM ".SQL_PREFIX."clan_user WHERE Username = '".$_POST['bot_name']."'") ){ $db->execQuery("INSERT INTO ".SQL_PREFIX."clan_user (id_clan, Username, admin, id_rank) VALUES ('".intval($_POST['bot_clanid'])."', '".$_POST['bot_name']."', '0', '0')"); }
else{ $db->execQuery("UPDATE ".SQL_PREFIX."clan_user SET id_clan = '".intval($_POST['bot_clanid'])."' WHERE Username = '".$_POST['bot_name']."'"); }

}else{
echo '<br /><center><b>Такого бота не найдено</b></center>';
}

}

}

include_once ('includes/conf/conf_chat.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD>
<META http-equiv=Content-Type content="text/html; charset=windows-1251">
<link rel=stylesheet type="text/css" href="http://other.it-industry.biz/css/main.css">
<META content="MSHTML 6.00.2600.0" name=GENERATOR>
<SCRIPT src="http://other.it-industry.biz/js/main.js"></SCRIPT>
</head>

<body bgColor="#f0f0f0">
<table width="100%" height="25" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td width="50%" align="center" bgcolor="#999999"><a href="?act=addbots">Добавить бота</a></td>
    <td width="50%" align="center" bgcolor="#999999"><a href="?act=bots">Управление ботами</a></td>
  </tr>
</table>
<?
if(!empty($_POST['player'])){
$val = $db->queryRow("SELECT Username, Level, Stre, Agil, Intu, Endu, HPall, ClanID, Pict, Room, Sex, map_id FROM ".SQL_PREFIX."players WHERE Username = '".speek_to_view($_POST['player'])."' AND Reg_IP = 'бот'");
if(empty($val)){ die; }

if(!empty($_POST['readd'])){
?>
<form method="post">
  <table border="0" cellspacing="0" cellpadding="0" align=center>
      <tr valign="top">
      <td width="400"> <b>Изменение характеристик бота:</b><br /><br />
        <table border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="150px">Никнейм бота:</td>
            <td width="150px"><input name="bot_name" type="text" style="width:150px;" value="<?=$val['Username'];?>" readonly></td>
          </tr>
          <tr>
            <td width="150px">Уровень:</td>
            <td width="150px"><input name="bot_lvl" type="text" style="width:150px;" value="<?=$val['Level'];?>" onFocus="this.select();"></td>
          </tr>
          <tr>
            <td width="150px">Сила:</td>
            <td width="150px"><input name="bot_str" type="text" style="width:150px;" value="<?=$val['Stre'];?>" onFocus="this.select();"></td>
          </tr>
          <tr>
            <td width="150px">Ловкость:</td>
            <td width="150px"><input name="bot_agil" type="text" style="width:150px;" value="<?=$val['Agil'];?>" onFocus="this.select();"></td>
          </tr>
          <tr>
            <td width="150px">Интуиция:</td>
            <td width="150px"><input name="bot_intu" type="text" style="width:150px;" value="<?=$val['Intu'];?>" onFocus="this.select();"></td>
          </tr>
          <tr>
            <td width="150px">Выносливость (конкретно стат):</td>
            <td width="150px"><input name="bot_endu" type="text" style="width:150px;" value="<?=$val['Endu'];?>" onFocus="this.select();"></td>
          </tr>
          <tr>
            <td width="150px">Общий уровень хп:</td>
            <td width="150px"><input name="bot_hpall" type="text" style="width:150px;" value="<?=$val['HPall'];?>" onFocus="this.select();"></td>
          </tr>
          <tr>
            <td width="150px">Клановый ID:</td>
            <td width="150px"><input name="bot_clanid" type="text" style="width:150px;" value="<?=$val['ClanID'];?>" onFocus="this.select();"></td>
          </tr>
          <tr>
            <td width="150px">Образ (пример: M/12 - это <a href="http://<?=$db_config[DREAM_IMAGES]['server'];?>/pict/M/12.gif" target=_blank>такой</a> образ):</td>
            <td width="150px"><input name="bot_pict" type="text" style="width:150px;" value="<?=$val['Pict'];?>" onFocus="this.select();"></td>
          </tr>
          <tr>
            <td width="150px">Квадрат:</td>
            <td width="150px"><input name="bot_mapid" type="text" style="width:150px;" value="<?=$val['map_id'];?>" onFocus="this.select();"></td>
          </tr>
          <tr>
            <td width="150px">Комната:</td>
            <td width="150px">
            <SELECT style="width:150px;" name="bot_room" style="width:150;">
            <? foreach( $_ROOM as $v => $k ): ?>
            <? $_val = split('::', $k); ?>
            <? if( !preg_match( '/living__/i', $v ) ): ?>
            <OPTION value="<?=$v;?>" <? if($val['Room'] == $v){echo 'SELECTED';} ?>><?=$_val[0];?></OPTION>
            <? endif; ?>
            <? endforeach; ?>
            </SELECT>
            </td>
          </tr>
          <tr>
            <td width="150px">Пол:</td>
            <td width="150px"> <SELECT style="width:150px;" name="bot_sex" style="width:150;"><OPTION value="M" <? if($val['Sex'] == 'M'){echo 'SELECTED';} ?>>Мужчина</OPTION><OPTION value="F" <? if($val['Sex'] == 'F'){echo 'SELECTED';} ?>>Женщина</OPTION></SELECT></td>
          </tr>
      </table></td>
    </tr>
  </table>
  <p align=center>
    <input type="submit" name="readd_bot" value="Изменить бота" class="oo" ONMOUSEOVER="this.className = 'on';" ONMOUSEOUT="this.className = 'oo';">
  </p>
</form>
<?
}elseif(!empty($_POST['del'])){
$db->execQuery("DELETE FROM ".SQL_PREFIX."players WHERE Username = '".speek_to_view($_POST['player'])."' AND Reg_IP = 'бот'");
$db->execQuery("DELETE FROM ".SQL_PREFIX."clan_user WHERE Username = '".speek_to_view($_POST['player'])."'");
echo 'готово';
}
die;
}

if (empty($_GET['act'])) { die('<p align=center><b>Выберите раздел</b></p>'); }
elseif($_GET['act'] == 'bots'){

$bot = $db->queryArray("SELECT Username, Level, Align, ClanID, BattleID FROM ".SQL_PREFIX."players WHERE Reg_IP = 'бот' AND Username != 'ЛамоБот' ORDER by Level ASC");
if(!empty($bot)){
?>
<table width="100%" height="50" border="1" cellpadding="0" cellspacing="0">
<tr>
<td align=center width="50%">Имя бота:</td>
<td align=center width="50%">Действие:</td>
</tr>
</table>
<table width="100%" height="50" border="1" cellpadding="0" cellspacing="0">
<?
foreach($bot as $v){
?>
<form method="POST"> <input type="hidden" name="player" value="<?=$v['Username'];?>"> <tr> <td align=center width="50%"><SCRIPT>dlogin(<?=sprintf( " '%s', %d, %d, %d ", $v['Username'], $v['Level'], $v['Align'], $v['ClanID'])?>);</SCRIPT> </td> <td align=center width="50%"><? if(!empty($v['BattleID'])){ echo 'Бот находится в бою. Подождите.'; } else { ?> <input type=submit value="Изменить" name="readd" style="width:100px;" class="oo" ONMOUSEOVER="this.className = 'on';" ONMOUSEOUT="this.className = 'oo';"> <input type=submit value="Удалить бота" name="del" style="width:100px;" class="oo" ONMOUSEOVER="this.className = 'on';" ONMOUSEOUT="this.className = 'oo';"><? } ?> </td> </tr> </form>
<?
}
?>
</table>
<?
}else{
echo '<br /><center><b>Не найдено ни одного бота</b></center>';
}

}elseif($_GET['act'] == 'addbots'){
?>
<form method="post">
  <table border="0" cellspacing="0" cellpadding="0" align=center>
      <tr valign="top">
      <td width="400"> <b>Характеристики бота:</b><br /><br />
        <table border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="150px">Никнейм бота:</td>
            <td width="150px"><input name="bot_name" type="text" style="width:150px;" value="" onFocus="this.select();"></td>
          </tr>
          <tr>
            <td width="150px">Уровень:</td>
            <td width="150px"><input name="bot_lvl" type="text" style="width:150px;" value="0" onFocus="this.select();"></td>
          </tr>
          <tr>
            <td width="150px">Сила:</td>
            <td width="150px"><input name="bot_str" type="text" style="width:150px;" value="3" onFocus="this.select();"></td>
          </tr>
          <tr>
            <td width="150px">Ловкость:</td>
            <td width="150px"><input name="bot_agil" type="text" style="width:150px;" value="3" onFocus="this.select();"></td>
          </tr>
          <tr>
            <td width="150px">Интуиция:</td>
            <td width="150px"><input name="bot_intu" type="text" style="width:150px;" value="3" onFocus="this.select();"></td>
          </tr>
          <tr>
            <td width="150px">Выносливость (конкретно стат):</td>
            <td width="150px"><input name="bot_endu" type="text" style="width:150px;" value="3" onFocus="this.select();"></td>
          </tr>
          <tr>
            <td width="150px">Общий уровень хп:</td>
            <td width="150px"><input name="bot_hpall" type="text" style="width:150px;" value="100" onFocus="this.select();"></td>
          </tr>
          <tr>
            <td width="150px">Клановый ID:</td>
            <td width="150px"><input name="bot_clanid" type="text" style="width:150px;" value="99" onFocus="this.select();"></td>
          </tr>
          <tr>
            <td width="150px">Образ (пример: M/12 - это <a href="http://<?=$db_config[DREAM_IMAGES]['server'];?>/pict/M/12.gif" target=_blank>такой</a> образ):</td>
            <td width="150px"><input name="bot_pict" type="text" style="width:150px;" value="0" onFocus="this.select();"></td>
          </tr>
          <tr>
            <td width="150px">Квадрат:</td>
            <td width="150px"><input name="bot_mapid" type="text" style="width:150px;" value="588" onFocus="this.select();"></td>
          </tr>
          <tr>
            <td width="150px">Комната:</td>
            <td width="150px">
            <SELECT style="width:150px;" name="bot_room" style="width:150;">
            <? foreach( $_ROOM as $v => $k ): ?>
            <? $_val = split('::', $k); ?>
            <? if( !preg_match( '/living__/i', $v ) ): ?>
            <OPTION value="<?=$v;?>"><?=$_val[0];?></OPTION>
            <? endif; ?>
            <? endforeach; ?>
            </SELECT>
            </td>
          </tr>
          <tr>
            <td width="150px">Пол:</td>
            <td width="150px"> <SELECT style="width:150px;" name="bot_sex" style="width:150;"><OPTION value="M" SELECTED>Мужчина</OPTION><OPTION value="F">Женщина</OPTION></SELECT></td>
          </tr>
      </table></td>
    </tr>
  </table>
  <p align=center>
    <input type="submit" name="add_bot" value="Добавить нового бота" class="oo" ONMOUSEOVER="this.className = 'on';" ONMOUSEOUT="this.className = 'oo';">
  </p>
</form>
<? } ?>
