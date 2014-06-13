<?
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

include_once('includes/themedefine.php');
include_once ('db_config.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru" id="timeofwars">
<head>
   <title>TimeOfWars.ru - информация о предмете</title>
   <meta content="text/html; charset=windows-1251" http-equiv="Content-type" />
   <meta Http-Equiv="Cache-Control" Content="no-cache, max-age=0, must-revalidate, no-store" />
   <meta http-equiv="PRAGMA" content="NO-CACHE" />
   <meta Http-Equiv="Expires" Content="0" />
   <link rel="stylesheet" type="text/css" href="http://<?=$db_config[DREAM]['other'];?>/css/main.css" />
</head>
<body bgcolor="#f0f0f0">
<CENTER>
<?
@$thing = intval($_GET['id']);
if(empty($thing)){ die(_forthings_err); }

include_once ('db.php');

if ( !preg_match ('/empt/i', $thing) ) {

if( $dat = $db->queryRow("SELECT * FROM ".SQL_PREFIX."turnir_things WHERE id = '".$thing."'") ){

if (file_exists('images/'.$dat['Id'].'_big.jpg')) { print '<img src="http://'.$db_config[DREAM_IMAGES]['server'].'/'.$dat['Id'].'_big.jpg" border=0><br />'; }
else { print '<img src="http://'.$db_config[DREAM_IMAGES]['server'].'/'.$dat['Id'].'.gif" border=0><br />'; }

print '
<B>'.$dat['Thing_Name'].'</B><br />
'.sprintf(_forthings_WEAR, 0, 1).'</FONT><br />
<br />'._forthings_text2.'<br />
';

print '<br />'._forthings_text1.'<br />';

if ($dat['MAXdamage']) { echo sprintf(_forthings_ALLdmg, $dat['MINdamage'], $dat['MAXdamage']); }
if ($dat['Armor1']) {    echo sprintf(_forthings_arm1, $dat['Armor1']);                         }
if ($dat['Armor2']) {    echo sprintf(_forthings_arm2, $dat['Armor2']);                         }
if ($dat['Armor3']) {    echo sprintf(_forthings_arm3, $dat['Armor3']);                         }
if ($dat['Armor4']) {    echo sprintf(_forthings_arm4, $dat['Armor4']);                         }
if ($dat['Crit']) {      echo sprintf(_forthings_сrit, $dat['Crit'].'%');                       }
if ($dat['Uv']) {        echo sprintf(_forthings_uv, $dat['Uv'].'%');                           }
if ($dat['AntiCrit']) {  echo sprintf(_forthings_Aсrit, $dat['AntiCrit'].'%');                  }
if ($dat['AntiUv']) {    echo sprintf(_forthings_Auv, $dat['AntiUv'].'%');                      }

} else { echo _forthings_none; }
}
?>
<br><br>
</CENTER>
</BODY>

</HTML>
