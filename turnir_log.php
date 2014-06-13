<?
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

include_once ('db_config.php');

@$_GET['id'] = intval($_GET['id']);
$file = $db_config[DREAM]['web_root'] . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'turnir' . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR . $_GET['id'];

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
</head>
<body bgcolor="#f0f0f0">
<?
if (!empty($_GET['id'])) {	if( !file_exists($file) ) die( 'Такой турнир не найден в базе.' );
	$log = file_get_contents( $file );

?>
<table width="100%" border="1" bordercolor="#634638" align="center" cellspacing="2" cellpadding="2">
<TR bgcolor="#634638" align="center"><td><input type="button" value="Обновить" onClick="location.href='turnir_log.php?id=<?print $_GET["id"];?>';" class="oo" ONMOUSEOVER="this.className = 'on';" ONMOUSEOUT="this.className = 'oo';" /></td></tr>
<tr align="left"><td>
<?=$log;?>
</td></tr>
<TR bgcolor="#634638" align="center"><td><input type="button" value="Обновить" onClick="location.href='turnir_log.php?id=<?print $_GET["id"];?>';" class="oo" ONMOUSEOVER="this.className = 'on';" ONMOUSEOUT="this.className = 'oo';" /></td></tr>
</table>
<?
}
?>
