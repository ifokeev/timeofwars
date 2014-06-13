<?php
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

include_once('../db_config.php');
include_once('../db.php');

$res = $db->queryArray("SELECT Username, FreeTime, wasclan FROM ".SQL_PREFIX."chaos");

if(!empty($res)){
foreach($res as $v){

if (time('void') > $v['FreeTime']){
$db->update( SQL_PREFIX.'clan_user', Array( 'id_clan' => $v['wasclan'] ),  Array( 'Username' => $v['Username'] ) );
$db->update( SQL_PREFIX.'online',    Array( 'ClanID'  => $v['wasclan'] ),  Array( 'Username' => $v['Username'] ) );
$db->update( SQL_PREFIX.'players',   Array( 'ClanID'  => $v['wasclan'] ),  Array( 'Username' => $v['Username'] ) );
$db->execQuery("DELETE FROM ".SQL_PREFIX."chaos WHERE Username = '".$v['Username']."'");
}

}
}
?>
