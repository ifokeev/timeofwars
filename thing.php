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
@$_GET['thing'] = intval($_GET['thing']);
if(empty($_GET['thing'])){ die(_forthings_err); }

include_once ('db.php');

if (preg_match ('/empt/i', $_GET['thing'])) { }
else {

if( $dat = $db->queryRow("SELECT * FROM ".SQL_PREFIX."things WHERE Un_Id = '{$_GET['thing']}'") ){

if (file_exists('images/'.$dat['Id'].'_big.jpg')) { print '<img src="http://'.$db_config[DREAM_IMAGES]['server'].'/'.$dat['Id'].'_big.jpg" border=0><br />'; }
else { print '<img src="http://'.$db_config[DREAM_IMAGES]['server'].'/'.$dat['Id'].'.gif" border=0><br />'; }

print '
<B>'.$dat['Thing_Name'].'</B><br />
'.sprintf(_forthings_cost, $dat['Cost'], 'кр.').'<br />
'.sprintf(_forthings_WEAR, $dat['NOWwear'], $dat['MAXwear']).'</FONT><br />
<br />'._forthings_text2.'<br />
';

if ($dat['Stre_need']) { echo sprintf(_forthings_sila, $dat['Stre_need']);                     }
if ($dat['Agil_need']) { echo sprintf(_forthings_lovkost,  $dat['Agil_need']);                 }
if ($dat['Intu_need']) { echo sprintf(_forthings_inta, $dat['Intu_need']);                     }
if ($dat['Endu_need']) { echo sprintf(_forthings_ENDUneed, $dat['Endu_need']);                 }
if ($dat['Level_need']){ echo sprintf(_forthings_level, $dat['Level_need']);                   }

print '<br />'._forthings_text1.'<br />';

if ($dat['Level_add']) { echo sprintf(_forthings_level, $dat['Level_add']);                     }
if ($dat['MAXdamage']) { echo sprintf(_forthings_ALLdmg, $dat['MINdamage'], $dat['MAXdamage']); }
if ($dat['Armor1']) {    echo sprintf(_forthings_arm1, $dat['Armor1']);                         }
if ($dat['Armor2']) {    echo sprintf(_forthings_arm2, $dat['Armor2']);                         }
if ($dat['Armor3']) {    echo sprintf(_forthings_arm3, $dat['Armor3']);                         }
if ($dat['Armor4']) {    echo sprintf(_forthings_arm4, $dat['Armor4']);                         }
if ($dat['Crit']) {      echo sprintf(_forthings_сrit, $dat['Crit'].'%');                       }
if ($dat['Uv']) {        echo sprintf(_forthings_uv, $dat['Uv'].'%');                           }
if ($dat['AntiCrit']) {  echo sprintf(_forthings_Aсrit, $dat['AntiCrit'].'%');                  }
if ($dat['AntiUv']) {    echo sprintf(_forthings_Auv, $dat['AntiUv'].'%');                      }
if ($dat['Stre_add']) {  echo sprintf(_forthings_sila, $dat['Stre_add']);                       }
if ($dat['Agil_add']) {  echo sprintf(_forthings_lovkost, $dat['Agil_add']);                    }
if ($dat['Intu_add']) {  echo sprintf(_forthings_inta, $dat['Intu_add']);                       }
if ($dat['Endu_add']) {  echo sprintf(_forthings_endu, $dat['Endu_add']);                       }
if ($dat['MagicID']) {   echo sprintf(_forthings_magicID, $dat['MagicID']);                     }
if ($dat['Srab']) {      echo sprintf(_forthings_srab, $dat['Srab']);                           }


} else { echo _forthings_none; }
}
?>
<br><br>
</CENTER>
</BODY>

</HTML>
