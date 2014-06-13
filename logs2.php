<?
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

include ('db_config.php');
include ('includes/battle2/write_to_xml.php');

@$id = intval($_GET['id']);
if( $id <= 0 ) die ( 'Некорректный ид боя.' );

  $battle_log = new write_to_log($id);

  $log = $battle_log->read_log();

  if( empty($log) )  die ( 'Такого лога не найдено.' );

  $return = '';
  if( !empty($log['log']) )
  {
  	krsort($log['log']);

     foreach( $log['log'] as $k => $v )
     {
     	   $return .= '<br />Ход номер '.$k.': <br />';

           if( !empty($log['death'][$k]) )
           {
           		foreach( $log['death'][$k] as $d_str )
           		 $return .= $battle_log->from_xml($d_str).'<br />';
           }


     	   if( !empty($v) )
     	   {
     		  krsort($v);
     		  foreach( $v as $str )
     			  $return .= $battle_log->from_xml($str).'<br />';
           }
           else
              $return .= 'Действия не обнаружены';

           if( !empty($log['abil'][$k]) )
           {
           	    $return .= '<hr color=#ebebeb />';

           		foreach( $log['abil'][$k] as $d_str )
           		 $return .= '<font color=green>'.$battle_log->from_xml($d_str).'</font><br />';
           	     $return .= '<hr color=#ebebeb />';
           }


     }
  }
  else   		$return = 'Действия не обнаружены.';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru" id="timeofwars">
<head>
   <title>TimeOfWars.ru - лог поединка <?=$id;?></title>
   <meta content="text/html; charset=windows-1251" http-equiv="Content-type" />
   <meta Http-Equiv="Cache-Control" Content="no-cache, max-age=0, must-revalidate, no-store" />
   <meta http-equiv="PRAGMA" content="NO-CACHE" />
   <meta Http-Equiv="Expires" Content="0" />
   <link rel="stylesheet" type="text/css" href="http://<?=$db_config[DREAM]['other'];?>/css/main.css" />
</head>
<body bgcolor="#f0f0f0">
<table width="100%" border="1" bordercolor="#634638" align="center" cellspacing="2" cellpadding="2">
<TR bgcolor="#634638" align="center"><td><input type="button" value="Обновить" onClick="location.href='logs2.php?id=<?=$id;?>';" class="oo" ONMOUSEOVER="this.className = 'on';" ONMOUSEOUT="this.className = 'oo';" /></td></tr>
<tr align="left"><td>
             <strong>Команда <font color="#ff6666">красных</font>:</strong> <font color="#000000" id="team1"><?=$log['team1'];?></font><br />
             <strong>Команда <font color="#6666ff">синих</font>:</strong> <font color="#000000" id="team2"><?=$log['team2'];?></font><br />
             <?=$log['nachalo'];?><br />
<?=$return;?>
</td></tr>
<TR bgcolor="#634638" align="center"><td><input type="button" value="Обновить" onClick="location.href='logs2.php?id=<?=$id;?>';" class="oo" ONMOUSEOVER="this.className = 'on';" ONMOUSEOUT="this.className = 'oo';" /></td></tr>
</table>
</body>
</html>