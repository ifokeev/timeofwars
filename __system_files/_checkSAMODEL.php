<?php
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

include_once('../db_config.php');
include_once('../db.php');

$res = $db->queryArray( "SELECT * FROM ".SQL_PREFIX."things_samodel WHERE ( FROM_UNIXTIME(add_time) < now() - INTERVAL 1 MONTH )" );
if( !empty($res) )
{	foreach($res as $dat)
	{		$db->insert( SQL_PREFIX.'things',
		Array(
		'Owner' => $dat['Owner'], 'Id' => $dat['Id'], 'Thing_Name' => $dat['Thing_Name'],
		'Slot' => $dat['Slot'], 'Cost' => 0, 'Level_need' => $dat['Level_need'], 'Stre_need' => $dat['Stre_need'],
		'Agil_need' => $dat['Agil_need'], 'Intu_need' => $dat['Intu_need'], 'Endu_need' => $dat['Endu_need'],
		'Stre_add' => $dat['Stre_add'], 'Agil_add' => $dat['Agil_add'], 'Intu_add' => $dat['Intu_add'], 'Endu_add' => $dat['Endu_add'],
		'MINdamage' => $dat['MINdamage'], 'MAXdamage' => $dat['MAXdamage'], 'Crit' => $dat['Crit'],
		'AntiCrit' => $dat['AntiCrit'], 'Uv' => $dat['Uv'], 'AntiUv' => $dat['AntiUv'], 'Armor1' => $dat['Armor1'],
		'Armor2' => $dat['Armor2'], 'Armor3' => $dat['Armor3'], 'Armor4' => $dat['Armor4'],
		'NOWwear' => $dat['NOWwear'], 'MAXwear' => $dat['MAXwear'], 'Wear_ON' => '0'
		)
		);

		$db->execQuery( "DELETE FROM ".SQL_PREFIX."things_samodel WHERE Un_Id = '".$dat['Un_Id']."' AND Owner = '".$dat['Owner']."';" );

        $txt = '<i>Почта от <b> Самоделы </b> (послано '.date('d.m.y H:i').'):</i> Вещь '.$dat['Thing_Name'].' возвращена к вам в инвентарь.';
        $db->insert( SQL_PREFIX.'messages', Array( 'Username' => $dat['Owner'], 'Text' => mysql_escape_string($txt) ) );


    }
 }

?>
