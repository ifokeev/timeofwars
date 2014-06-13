<?
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

session_start();

include_once('../db_config.php');
include_once('../db.php');

@$_GET['viewforum'] = intval($_GET['viewforum']);

$file = $db->queryFetchArray('SELECT * FROM '.SQL_PREFIX.'mainforum');
if( empty($file) ){ die('Форум недоступен'); }

include_once ('../includes/to_view.php');
include_once ('../includes/forum/func.php');

@$p         = intval($_GET['p']);
@$_GET['d'] = intval($_GET['d']);
$d          = (empty($_GET['d']) ? '20' : $_GET['d']);
if($d != 20 && $d != 50 && $d != 100){ $d = 20; }
$search     = '';
$color      = '#AEA599';
@$_GET['search'] = speek_to_view($_GET['search']);

if( !empty($_POST['title']) && !empty($_POST['Post']) && !empty($_POST['submit']) && (!empty($_GET['viewforum']) && is_numeric($_GET['viewforum']) && !empty($_SESSION['login']) ) )
{
	die( addtheme( speek_to_view($_POST['title']), speek_to_view($_POST['Post']), intval($_GET['viewforum']) ) );
}


if( !empty($_POST['Post']) && !empty($_POST['submit']) && empty($_POST['title']) && (!empty($_GET['viewtopic']) && is_numeric($_GET['viewtopic'])  && !empty($_SESSION['login']) ) )
{
	die( addreplay( speek_to_view($_POST['Post']), intval($_GET['viewtopic']) ) );
}


if( !empty($_GET['func']) && $_GET['func'] == 'getLast' )
{
	die( getlast( intval($_GET['viewtopic']) ) );
}


if( !empty($_SESSION['login']) )
{
	$ClanID = $db->SQL_result($db->query("SELECT ClanID FROM ".SQL_PREFIX."players WHERE Username = '".speek_to_view($_SESSION['login'])."'"), 0);
}


if( !empty($_SESSION['login']) && ( !empty($_GET['deltopid']) && is_numeric($_GET['deltopid']) ) && (!empty($_GET['viewforum']) && is_numeric($_GET['viewforum']) ) && (!empty($ClanID) && ($ClanID == 1 || $ClanID == 2 || $ClanID == 50 || $ClanID == 255 || $ClanID == 53 || $ClanID == 19)) )
{
	die( DELtop( intval($_GET['viewforum']), intval($_GET['deltopid']) ) );
}


if( !empty($_SESSION['login']) && ( !empty($_GET['delPOST']) && is_numeric($_GET['delPOST']) ) && (!empty($_GET['viewtopic']) && is_numeric($_GET['viewtopic']) ) && (!empty($ClanID) && ($ClanID == 1 || $ClanID == 2 || $ClanID == 50 || $ClanID == 255 || $ClanID == 53 || $ClanID == 19)) )
{
	die( DELpost( intval($_GET['viewtopic']), $p, intval($_GET['delPOST']) ) );
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru" id="timeofwars">
<head>
   <title>TimeOfWars - форум</title>
   <meta content="text/html; charset=windows-1251" http-equiv="Content-type" />
   <meta name="Keywords" content="timeofwars, Time Of Wars, TOW, время войн, игра, играть, игрушки, онлайн,online, интернет, internet, RPG, fantasy, фэнтези, меч, топор, магия, кулак, удар, блок, атака, защита, бой, битва, отдых, обучение, развлечение, виртуальная реальность, рыцарь, маг, знакомства, чат, лучший, форум, свет, тьма, chaos, games, клан, банк, магазин, клан" />
   <meta name="Description" content="Увлекательная RPG онлайн игра в стиле фэнтези. Стратегия, война между Светом и Тьмой, добыча ресурсов, бои, магия, торговля, приключения, кланы." />
   <meta Http-Equiv="Cache-Control" Content="no-cache, max-age=0, must-revalidate, no-store" />
   <meta http-equiv="PRAGMA" content="NO-CACHE" />
   <meta Http-Equiv="Expires" Content="0" />
   <link href="http://<?=$db_config[DREAM]['other'];?>/css/forum.css" rel="stylesheet" />
   <script src="http://<?=$db_config[DREAM]['other'];?>/js/forumuser.js"></script>
</head>
<body style="margin:0;" background="http://<?=$db_config[DREAM_IMAGES]['server'];?>/bg.jpg"><br />
<table class="g" align="center" border="0" cellpadding="4" cellspacing="1" width="800px">
 <tbody>
  <tr class="bg6">
   <td style="background-repeat: no-repeat;" align="right" background="http://<?=$db_config[DREAM_IMAGES]['server'];?>/forum/logom_ru.jpg" height="93px" width="600px"><a href="index.php"><img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/forum/forum_ru.gif" border="0" height="50px" width="398px" /></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
  </tr>
 </tbody>
</table>
<?
if( !empty($_GET['adminpanel']) && $_GET['adminpanel'] == 1 && !empty($_SESSION['login']) && (!empty($ClanID) && ($ClanID == 1 || $ClanID == 2 || $ClanID == 50 || $ClanID == 255 || $ClanID == 53  || $ClanID == 19)) )
{
	include_once('../includes/forum/admin.php');
}
elseif ( !empty($_GET['viewforum']) && is_numeric($_GET['viewforum']) )
{
	if( !$name = $db->queryCheck("SELECT id, name FROM ".SQL_PREFIX."mainforum WHERE id = '".intval($_GET['viewforum'])."'") )
	{
		die('Такого топика не существует');
	}
	else
	{
		$num = $d;
		$posts = $db->numrows("SELECT * FROM ".SQL_PREFIX."topics WHERE id_forum = '$name[0]'");
		$total = @ceil($posts/$num);

		if(empty($p) || $p < 0)
		{
			$p = 1;
		}

		if($p > $total)
		{
			$p = $total;
		}

		$start = max( 0, ($p * $num - $num) );

		if( !empty($_GET['search']) )
		{
			$search = "AND name like '%".$_GET['search']."%'";
		}

		$topic = $db->queryFetchArray("SELECT * FROM ".SQL_PREFIX."topics WHERE id_forum = '$name[0]' $search ORDER BY isfixed DESC, datepost DESC LIMIT $start, $num");
?>
<table width="800px" cellspacing="1" cellpadding="3" border="0" align="center">
 <tr>
  <td class="small">&nbsp;&nbsp;<a href="index.php" class="norm">Форум</a> -> <a href="index.php?viewforum=<?=$name[0];?>" class="norm"><?=$name[1];?></a></td>
 </tr>
</table>
<table class="g" cellspacing="1" cellpadding="3" border="0" align="center" width="800">
 <tr class="bg6 medium">
  <td height="28" colspan="6">
   <table width="100%" cellspacing="0" cellpadding="0">
    <tr>
     <td>
      <table cellspacing="0" cellpadding="0">
       <tr>
        <td>
         <a href="index.php?viewforum=<?=$name[0];?>&p=<?=$p-1;?>"><img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/forum/back_round_dis.gif" width="16px" height="16px" border="0" title="Предыдущая страница" align="absmiddle" /></a>
        </td>
        <td class="smallb">&nbsp;<strong>Страница</strong>&nbsp;</td>
        <td>
         <select class="smallb" name="p" onChange="location.href = 'index.php?viewforum=<?=$name[0];?>&p='+this.options[this.selectedIndex].value">
         <? for($i = 1; $i <= $total; $i++){ ?>
          <option label="<?=$i;?>" value="<?=$i;?>" <? if($i == $p){ echo 'selected'; } ?>><?=$i;?></option>
         <? } ?>
         </select>
        </td>
        <td class="smallb">&nbsp;<strong>из <?=$total;?></strong>&nbsp;</td>
        <td>
         <a href="index.php?viewforum=<?=$name[0];?>&p=<?=$p+1;?>"><img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/forum/fwd_round_dis.gif" width="16px" height="16px" border="0" title="Следующая страница" align="absmiddle" /></a>
        </td>
        <td class="smallb">&nbsp;&nbsp;|&nbsp;&nbsp;<strong>Показывать</strong>&nbsp;</td>
        <td>
         <select name="dd" class="smallb" onChange="location.href = 'index.php?viewforum=<?=$name[0];?>&p=<?=$p;?>&d='+this.options[this.selectedIndex].value">
          <option label="20" value="20" <?   if($d == 20){    echo 'selected'; }?>>20</option>
          <option label="50" value="50" <?   if($d == 50){    echo 'selected'; }?>>50</option>
          <option label="100" value="100" <? if($d == 100){   echo 'selected'; }?>>100</option>
         </select>
        </td>
        <td class="smallb">&nbsp;<strong>на странице</strong></td>
       </tr>
      </table>
     </td>
     <td align="right">
      <form action="index.php" method="get" style="padding: 0; margin: 0">
      <input type="hidden" name="viewforum" value="<?=$name[0];?>" />
      <input type="text" class="small" style="color: black" name="search" value="<?=$_GET['search'];?>" />
      <input type="submit" value="Поиск" class="small btn"/>
      </form>
     </td>
    </tr>
   </table>
  </td>
 </tr>
 <tr class="bg4" style="font-weight: bold">
  <td colspan="2" align="center" height="25" nowrap="nowrap" class="small">Тема</td>
  <td align="center" nowrap="nowrap" class="small">Ответов</td>
  <td align="center" nowrap="nowrap" class="small">Автор</td>
  <td align="center" nowrap="nowrap" class="small">Просмотров</td>
  <td align="center" nowrap="nowrap" class="small">Обновление</td>
 </tr>
<? if( !empty($topic) ){ ?>
<? foreach($topic as $v){ ?>
<? $lastreplay = $db->queryRow("SELECT Author, msgdate FROM ".SQL_PREFIX."posts WHERE topicid = '$v[0]' ORDER BY msgdate DESC"); ?>
  <tr>
   <td class="bg5" align="center" valign="middle" width="20"><img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/forum/<?=$v[1];?>" border="0" width="16" height="16"></td>
   <td class="bg6 medium" width="480"><? if($v[2] != 0){ ?> <b>Прикреплено:</b> <? } ?> <a href="index.php?viewtopic=<?=$v[0];?>"><b><?=ogran($v[3], 40);?></b></a> <? if(!empty($_SESSION['login']) && (!empty($ClanID) && ($ClanID == 1 || $ClanID == 2 || $ClanID == 3 || $ClanID == 50 || $ClanID == 255 || $ClanID == 53 || $ClanID == 19)) ){ ?><br /><a href="javascript:location.href='index.php?viewforum=<?=$name[0];?>&deltopid=<?=$v[0];?>'">Удалить</a>/<a href="javascript:location.href='index.php?adminpanel=1&redacttopid=<?=$v[0];?>'">Редактировать</a><? } ?><br /></td>
   <td width="50" class="bg5" align="center" valign="middle"><small><?=$db->numrows("SELECT * FROM ".SQL_PREFIX."posts WHERE topicid = '$v[0]'");?></small></td>
   <td width="100" class="bg6 medium" align="center" valign="middle" nowrap="nowrap"><span class="small"><a href="../inf.php?uname=<?=$v[4];?>" target="_blank"><?=$v[4];?></a></span></td>
   <td width="50" class="bg5" align="center" valign="middle"><small><?=$v[5];?></small></td>
   <td width="100" class="bg6 medium date"  style="font-family:Tahoma;" align="left" valign="middle" nowrap="nowrap"><? if(!empty($lastreplay)){ echo date('j.n.Y H:i', $lastreplay['msgdate']).'<br /><a href="index.php?viewtopic='.$v[0].'&func=getLast"><img src="http://'.$db_config[DREAM_IMAGES]['server'].'/forum/arrow.gif" border="0" alt="Последнее сообщение" /></a><a href="../inf.php?uname='.$lastreplay['Author'].'" target="_blank"><b>'.$lastreplay['Author'].'</b></a>'; } else { echo '<center>нет сообщений</center>'; } ?> </td>
  </tr>
<? } ?>
<? } else { ?>
    <td colspan="6" align="center" class="bg6 medium" height="30px">
     Не найдено ни одной темы.
    </td>
<? } ?>
   <tr class="bg6 medium">
    <td height="28" colspan="6">
     <table cellspacing="0" cellpadding="0">
      <tr>
       <td><a href="index.php?viewforum=<?=$name[0];?>&p=<?=$p-1;?>"><img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/forum/back_round_dis.gif" width="16px" height="16px" border="0" title="Предыдущая страница" align="absmiddle" /></a></td>
       <td class="smallb">&nbsp;<strong>Страница</strong>&nbsp;</td>
       <td>
        <select class="smallb" name="p" onChange="location.href = 'index.php?viewforum=<?=$name[0];?>&p='+this.options[this.selectedIndex].value">
        <? for($i = 1; $i <= $total; $i++){ ?>
         <option label="<?=$i;?>" value="<?=$i;?>" <? if($i == $p){ echo 'selected'; } ?>><?=$i;?></option>
        <? } ?>
       </select>
      </td>
      <td class="smallb">&nbsp;<strong>из <?=$total;?></strong>&nbsp;</td>
      <td><a href="index.php?viewforum=<?=$name[0];?>&p=<?=$p+1;?>"><img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/forum/fwd_round_dis.gif" width="16px" height="16px" border="0" title="Следующая страница" align="absmiddle" /></a></td>
      <td class="smallb">&nbsp;&nbsp;|&nbsp;&nbsp;<strong>Показывать</strong>&nbsp;</td>
      <td>
       <select name="dd" class="smallb" onChange="location.href = 'index.php?viewforum=<?=$name[0];?>&p=<?=$p;?>&d='+this.options[this.selectedIndex].value">
        <option label="20" value="20" <? if($d == 20){ echo 'selected';    }?>>20</option>
        <option label="50" value="50" <? if($d == 50){ echo 'selected';    }?>>50</option>
        <option label="100" value="100" <? if($d == 100){ echo 'selected'; }?>>100</option>
       </select>
      </td>
      <td class="smallb">&nbsp;<strong>на странице</strong></td>
     </tr>
    </table>
   </td>
  </tr>
</table>
<br />
<?
        if( (!empty($_SESSION['login']) && $_GET['viewforum'] != '23') || ($_GET['viewforum'] == '23' && (!empty($ClanID) && ($ClanID == 255 || $ClanID == 1 || $ClanID == 3 || $ClanID == 50 || $ClanID == 19 || $ClanID == 53))) )
        {
        	viewform(1);
        }
     }
}
elseif( !empty($_GET['viewtopic']) && is_numeric($_GET['viewtopic']) )
{
	if( !$name = $db->fetch_array("SELECT t.id, t.id_forum, t.name as topname, m.id as mainforum, m.name, p.topicid, t.type FROM ".SQL_PREFIX."posts as p LEFT JOIN ".SQL_PREFIX."topics as t ON (t.id = p.topicid) LEFT JOIN ".SQL_PREFIX."mainforum as m ON (m.id = t.id_forum) WHERE p.topicid = '".intval($_GET['viewtopic'])."'") )
	{
		die('<center>Такой темы не существует</center>');
	}

	$num = $d;

	$posts = $db->numrows("SELECT * FROM ".SQL_PREFIX."posts WHERE topicid = '".intval($_GET['viewtopic'])."'");

	$total = @ceil($posts/$num);

	if(empty($p) || $p < 0)
	{
		$p = 1;
	}

	if($p > $total)
	{
		$p = $total;
	}

	$start = max( 0, ($p * $num - $num) );

	$post = $db->queryFetchArray("SELECT * FROM ".SQL_PREFIX."posts WHERE topicid = '".intval($_GET['viewtopic'])."' ORDER BY msgdate ASC LIMIT $start, $num");
?>
<table width="800px" cellspacing="1" cellpadding="3" border="0" align="center">
 <tr>
  <td class="small">&nbsp;&nbsp;<a href="index.php" class="norm">Форум</a> -> <a href="index.php?viewforum=<?=$name['mainforum'];?>" class="norm"><?=$name['name'];?></a></td>
 </tr>
</table>
<table class="g" width="800px" cellspacing="1" cellpadding="4" border="0" align="center">
 <tr class="bg6 medium">
  <td height="20" colspan="2">
   <table cellspacing="0" cellpadding="0">
    <tr>
     <td><a href="index.php?viewtopic=<?=$_GET['viewtopic'];?>&p=<?=$p-1;?>"><img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/forum/back_round_dis.gif" width="16px" height="16px" border="0" title="Предыдущая страница" align="absmiddle" /></a></td>
     <td class="smallb">&nbsp;<strong>Страница</strong>&nbsp;</td>
     <td>
      <select class="smallb" name="p" onChange="location.href = 'index.php?viewtopic=<?=$_GET['viewtopic'];?>&p='+this.options[this.selectedIndex].value">
      <? for($i = 1; $i <= $total; $i++){ ?>
       <option label="<?=$i;?>" value="<?=$i;?>" <? if($i == $p){ echo 'selected'; } ?>><?=$i;?></option>
      <? } ?>
      </select>
     </td>
     <td class="smallb">&nbsp;<strong>из <?=$total;?></strong>&nbsp;</td>
     <td><a href="index.php?viewtopic=<?=$_GET['viewtopic'];?>&p=<?=$p+1;?>"><img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/forum/fwd_round_dis.gif" width="16px" height="16px" border="0" title="Следующая страница" align="absmiddle" /></a></td>
     <td class="smallb">&nbsp;&nbsp;|&nbsp;&nbsp;<strong>Показывать</strong>&nbsp;</td>
     <td>
      <select name="dd" class="smallb" onChange="location.href = 'index.php?viewtopic=<?=$_GET['viewtopic'];?>&p=<?=$p;?>&d='+this.options[this.selectedIndex].value">
       <option label="20" value="20" <? if($d == 20){ echo 'selected';    }?>>20</option>
       <option label="50" value="50" <? if($d == 50){ echo 'selected';    }?>>50</option>
       <option label="100" value="100" <? if($d == 100){ echo 'selected'; }?>>100</option>
      </select>
     </td>
     <td class="smallb">&nbsp;<strong>на странице</strong></td>
    </tr>
   </table>
  </td>
 </tr>
 <tr class="bg4 medium">
  <td height="28px" colspan="2"><a href="index.php?viewforum=<?=$name['mainforum'];?>"><img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/forum/dira.gif" border="0" /></a> <b><?=$name['topname'];?></b></td>
 </tr>
<?
if( !empty($post) )
{
	$db->execQuery("UPDATE ".SQL_PREFIX."topics SET views = views + '1' WHERE id = '".intval($_GET['viewtopic'])."'");

	foreach($post as $v)
	{
		if ($color == '#AEA599'){ $color = '#CCC3B7'; }elseif($color == '#CCC3B7'){ $color = '#AEA599'; }
		$dat = $db->queryRow("SELECT Username, Level, Align, ClanID, ClanRank FROM ".SQL_PREFIX."players WHERE Username = '$v[2]'");
		$v[3] = bbcode($v[3]);
		$v[3] = string_cut($v[3], 60);
		$v[3] = nl2br($v[3]);
?>
 <tr bgcolor="<?=$color;?>">
  <td width="20%" align="left" valign="top" nowrap="nowrap" class="regular"><a name="post<?=$v[0];?>"></a><SCRIPT>dlogin(<?=sprintf( " '%s', %d, %d, %d ", $dat['Username'], $dat['Level'], $dat['Align'], $dat['ClanID'])?>);</SCRIPT><br /><span class="smallb"><?=(!empty($dat['ClanRank']) ? $dat['ClanRank'] : 'Воин');?><br /></span><br /><span class="smallb">Сообщений: <?=$db->numrows("SELECT * FROM ".SQL_PREFIX."posts WHERE Author = '$v[2]'");?><br /></span><br /></td>
  <td width="100%" height="28" valign="top">
   <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr><td colspan="2" class="regular"><?=$v[3];?></td></tr>
    <tr><td colspan="2"><br><hr /></td></tr>
    <tr><td width="100%"><small>Отправлено:</small> <span class="date"><?=date('j.n.Y H:i', $v[4]);?></span></td><td valign="top" nowrap="nowrap"><? if(!empty($_SESSION['login']) && (!empty($ClanID) && ($ClanID == 1 || $ClanID == 2 || $ClanID == 50 || $ClanID == 255 || $ClanID == 53)) ){ ?><small><a href="javascript:location.href='index.php?viewtopic=<?=intval($_GET['viewtopic']);?>&p=<?=$p;?>&delPOST=<?=$v[0];?>'">Удалить</a>/<a href="javascript:location.href='?adminpanel=1&redactPOST=<?=$v[0];?>/<?=$p;?>'">Редактировать</a></small><? } ?></td></tr>
   </table>
  </td>
 </tr>
<?
    }
}
else
{
?>
 <td colspan="6" align="center" class="bg6 medium" height="30px">
  Такой темы не найдено.
 </td>
<?
}
?>
 <tr class="bg6 medium">
  <td height="28px" colspan="2">
   <table cellspacing="0" cellpadding="0">
    <tr>
     <td><a href="index.php?viewtopic=<?=$_GET['viewtopic'];?>&p=<?=$p-1;?>"><img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/forum/back_round_dis.gif" width="16px" height="16px" border="0" title="Предыдущая страница" align="absmiddle" /></a></td>
     <td class="smallb">&nbsp;<strong>Страница</strong>&nbsp;</td>
     <td>
      <select class="smallb" name="p" onChange="location.href = 'index.php?viewtopic=<?=$_GET['viewtopic'];?>&p='+this.options[this.selectedIndex].value">
      <? for($i = 1; $i <= $total; $i++){ ?>
       <option label="<?=$i;?>" value="<?=$i;?>" <? if($i == $p){ echo 'selected'; } ?>><?=$i;?></option>
      <? } ?>
      </select>
     </td>
     <td class="smallb">&nbsp;<strong>из <?=$total;?></strong>&nbsp;</td>
     <td><a href="index.php?viewtopic=<?=$_GET['viewtopic'];?>&p=<?=$p+1;?>"><img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/forum/fwd_round_dis.gif" width="16px" height="16px" border="0" title="Следующая страница" align="absmiddle" /></a></td>
     <td class="smallb">&nbsp;&nbsp;|&nbsp;&nbsp;<strong>Показывать</strong>&nbsp;</td>
     <td>
      <select name="dd" class="smallb" onChange="location.href = 'index.php?viewtopic=<?=$_GET['viewtopic'];?>&p=<?=$p;?>&d='+this.options[this.selectedIndex].value">
       <option label="20" value="20" <? if($d == 20){ echo 'selected';    }?>>20</option>
       <option label="50" value="50" <? if($d == 50){ echo 'selected';    }?>>50</option>
       <option label="100" value="100" <? if($d == 100){ echo 'selected'; }?>>100</option>
      </select>
     </td>
     <td class="smallb">&nbsp;<strong>на странице</strong></td>
    </tr>
   </table>
  </td>
 </tr>
</table>
</td>
</tr>
</table>
<?
if( !empty($_SESSION['login']) )
{
	if( $name['type'] != 'thread_closed.gif' )
	{
		echo '<br />';
		viewform();
	}
	else
	{
		echo '<table class="g" cellspacing="1" cellpadding="3" border="0" align="center" width="800px" height="28px"><tr class="bg4 medium"><td valign="top" align="center">Тема закрыта.</td></tr></table><br />';
	}
}

}
else
{
?>
 <table width="800px" cellspacing="1" cellpadding="3" border="0" align="center">
  <tr>
   <td class="small">
    &nbsp;&nbsp;<a href="../encicl/rules.html" class="norm" target="_blank">Правила</a>&nbsp;&nbsp;|
    &nbsp;&nbsp;<a href="../encicl/" class="norm" target="_blank">Библиотека</a>&nbsp;&nbsp;|
	&nbsp;&nbsp;<a href="../top5.php" class="norm" target="_blank">Рейтинг</a>&nbsp;&nbsp;
	<?if ( !empty($ClanID) &&  $ClanID == 255 ){ ?>|&nbsp;&nbsp;<a href="?adminpanel=1" class="norm" target="_blank">Админпанель</a>&nbsp;&nbsp;<? } ?>
   </td>
  </tr>
 </table>
 <table width="800px" cellspacing="1" cellpadding="3" border="0" class="g" align="center">
<? foreach($file as $v){ ?>
<? if($v[1] == 'razdel'){ ?>
  <tr class="bg4">
   <td colspan="5" height="28px">&nbsp; <b><?=$v[2];?></b></td>
  </tr>
<? } else { ?>
<? $lastreplay = $db->queryRow("SELECT t.name, t.id, p.Author, p.msgdate FROM ".SQL_PREFIX."posts as p LEFT JOIN ".SQL_PREFIX."topics as t ON(p.topicid = t.id) LEFT JOIN ".SQL_PREFIX."mainforum as m ON(t.id_forum = m.id) WHERE m.id = '$v[0]' ORDER BY p.msgdate DESC"); ?>
  <tr class="bg5">
   <td align="center" valign="middle" width="20px">&nbsp; &nbsp; &nbsp;</td>
   <td class="bg6" width="480px"><span class="regular"><a href="index.php?viewforum=<?=$v[0];?>"><b><?=$v[2];?></b></a></span><br /> <span style="color: #606060; font-size: 11"><?=$v[3];?></span><br />&nbsp; &nbsp;</td>
   <td align="center" valign="middle" width="50px"><?=$db->numrows("SELECT id FROM ".SQL_PREFIX."topics WHERE id_forum = '$v[0]'");?></td>
   <td align="center" valign="middle" width="50px"><?=$db->numrows("SELECT p.id FROM ".SQL_PREFIX."posts as p LEFT JOIN ".SQL_PREFIX."topics as t ON(p.topicid = t.id) LEFT JOIN ".SQL_PREFIX."mainforum as m ON(t.id_forum = m.id) WHERE m.id = '$v[0]'");?></td>
   <td width="200px" valign="middle" style="font-size: 11" nowrap="nowrap"><? if(!empty($lastreplay)){ echo '<a href="index.php?viewtopic='.$lastreplay['id'].'&func=getLast" title="'.$lastreplay['name'].'"><b>'.ogran($lastreplay['name']).'</b></a> <br /><span style="color: #990000; font-size: 11">'.date('j.n.Y H:i', $lastreplay['msgdate']).'</span> <a href="../inf.php?uname='.$lastreplay['Author'].'" target="_blank">'.$lastreplay['Author'].'</a></td>'; } else { echo '<center>Нет сообщений</center>'; } ?>
  </tr>
<? } ?>
<? } ?>
</table>
<br />
<? } ?>
<table align="center" border="0" cellspacing="0" cellpadding="0">
 <tr>
  <td align="center">
<!--Rating@Mail.ru COUNTER-->
<!--/COUNTER-->
  </td>
  <td align="center" class="small">
   &nbsp;&nbsp;&nbsp;
   &copy; Copyright © 2010. Все права защищены www.timeofwars.lv
  </td>
 </tr>
</table><br />
</body>
</html>