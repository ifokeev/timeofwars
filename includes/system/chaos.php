<?
include_once('db_config.php');
include_once('db.php');

if ($ClanID == '200'):

$res = $db->queryCheck("SELECT FreeTime, wasclan FROM ".SQL_PREFIX."chaos WHERE Username = '$u'");

if (time ('void') > $res[0]):
$db->execQuery("UPDATE ".SQL_PREFIX."clan_user SET id_clan= '$res[1]' WHERE Username = '$u'");
$db->execQuery("UPDATE ".SQL_PREFIX."online SET ClanID = '$res[1]' WHERE Username = '$u'");
$db->execQuery("DELETE FROM ".SQL_PREFIX."chaos WHERE Username = '$u'");
endif;

endif;
?>
