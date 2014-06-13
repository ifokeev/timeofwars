<?php
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

include_once('../db_config.php');
include_once('../db.php');

$db->execQuery("DELETE FROM `".SQL_PREFIX."online` WHERE Time < '".time()."'-'1800'");
$db->execQuery("DELETE FROM `".SQL_PREFIX."stopped` WHERE Time <= '".time()."'-'600'");
$db->execQuery("DELETE FROM `".SQL_PREFIX."karma_votes` WHERE Time <= '".time()."'-'43200'");
?>
