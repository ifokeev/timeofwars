<?
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

$dbClassAdded = true;
include_once ('db_config.php');

@$_GET['id'] = intval($_GET['id']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru" id="timeofwars">
<head>
   <title>TimeOfWars.ru - лог поединка <?=$_GET['id'];?></title>
   <meta content="text/html; charset=windows-1251" http-equiv="Content-type" />
   <meta Http-Equiv="Cache-Control" Content="no-cache, max-age=0, must-revalidate, no-store" />
   <meta http-equiv="PRAGMA" content="NO-CACHE" />
   <meta Http-Equiv="Expires" Content="0" />
   <link rel="stylesheet" type="text/css" href="http://<?=$db_config[DREAM]['other'];?>/css/main.css" />
   <script src="http://<?=$db_config[DREAM]['other'];?>/js/main.js"></script>
</head>
<body bgcolor="#f0f0f0">
<?
if (!empty($_GET['id'])) {
include_once ('db.php');

$this_log = $db->queryRow("SELECT * FROM ".SQL_PREFIX."logs WHERE Id = '{$_GET['id']}'");
$file_log = $db->queryRow("SELECT * FROM ".SQL_PREFIX."file_logs WHERE Id = '{$_GET['id']}'");
$db->checklevelup();

if (!$this_log && !$file_log) { print '<CENTER>Лог <B>'.$_GET['id'].'</B> не найден в базе</CENTER>'; exit; }
?>
<table width="100%" border="1" bordercolor="#634638" align="center" cellspacing="2" cellpadding="2">
<TR bgcolor="#634638" align="center"><td><input type="button" value="Обновить" onClick="location.href='log.php?id=<?print $_GET["id"];?>';" class="oo" ONMOUSEOVER="this.className = 'on';" ONMOUSEOUT="this.className = 'oo';" /></td></tr>
<tr align="left"><td>
<?
if ($this_log){ print $this_log['Log']; }

if( $file_log && file_exists($d_f.$_GET['id'].'.log') ){
$d_f=$file_log['folder_path'];
$f=file($d_f.$_GET['id'].'.log',1);
print trim($f[2]);
}
?>
</td></tr>
<TR bgcolor="#634638" align="center"><td><input type="button" value="Обновить" onClick="location.href='log.php?id=<?print $_GET["id"];?>';" class="oo" ONMOUSEOVER="this.className = 'on';" ONMOUSEOUT="this.className = 'oo';" /></td></tr>
</table>
<?
}
?>
