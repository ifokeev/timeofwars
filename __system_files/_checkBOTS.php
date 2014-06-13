<?php
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

include_once('../db_config.php');
include_once('../db.php');

$res = $db->queryArray("SELECT Username, Level, Align, ClanID, Room, ChatRoom FROM ".SQL_PREFIX."players WHERE Reg_Ip = 'бот'");
if(!empty($res)){ foreach($res as $v){ if( preg_match("/Бот_/i", $v['Username']) ){ $v['Room'] = $v['ChatRoom']; } $db->execQuery("INSERT INTO ".SQL_PREFIX."online (Username, Time, Room, ClanID, Level, Align, Stop, Inv, SId) VALUES ('".$v['Username']."', '".time()."', '".$v['Room']."', '".$v['ClanID']."', '".$v['Level']."', '0', '0', '0', '0') ON DUPLICATE KEY UPDATE Time = '".time()."', Stop = '0', Inv = '0'"); } }
?>
