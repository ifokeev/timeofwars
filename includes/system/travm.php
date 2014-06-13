<?
include_once('db_config.php');
include_once('db.php');


if ($tr = $db->queryRow("SELECT * FROM ".SQL_PREFIX."inv WHERE Username = '$u'") ):

if (time ('void') > $tr['Time']):

if ($tr['Type2'] == 1):
$db->execQuery("UPDATE ".SQL_PREFIX."players SET Stre = Stre + '{$tr['Type3']}' WHERE Username = '$u'");
$db->execQuery("DELETE FROM ".SQL_PREFIX."inv WHERE Username = '$u'");
endif;

if ($tr['Type2'] == 2):
$db->execQuery("UPDATE ".SQL_PREFIX."players SET Agil = Agil + '{$tr['Type3']}' WHERE Username = '$u'");
$db->execQuery("DELETE FROM ".SQL_PREFIX."inv WHERE Username = '$u'");
endif;

if ($tr['Type2'] == 3):
$db->execQuery("UPDATE ".SQL_PREFIX."players SET Intu = Intu + '{$tr['Type3']}' WHERE Username = '$u'");
$db->execQuery("DELETE FROM ".SQL_PREFIX."inv WHERE Username = '$u'");
endif;

endif;

endif;
?>
