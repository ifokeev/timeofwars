<?php
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

include_once('../db_config.php');
include_once('../db.php');

$res = $db->queryArray("SELECT Username FROM ".SQL_PREFIX."players WHERE Reg_Ip = 'бот' AND (BattleID IS NULL OR BattleID = '0' OR BattleID = '') AND Room = 'map'");

if(!empty($res)){
foreach($res as $v){

$arr = $db->queryFetchArray("SELECT id FROM ".SQL_PREFIX."map WHERE acses <> '1'"); shuffle($arr);
$db->update( SQL_PREFIX.'players', Array( 'map_id' => $arr[0][0] ), Array( 'Username' => $v['Username'] ) );

}
}
?>
