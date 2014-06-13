<?
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

session_start();
if (empty($_SESSION['login'])) { include_once('includes/bag_log_in.php'); exit; }

include_once ('db_config.php');
include_once ('db.php');

$db->execQuery("DELETE FROM ".SQL_PREFIX."online WHERE Username = '".$_SESSION['login']."'");

$_SESSION = array();

@session_destroy();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru" id="timeofwars">
<head>
   <title>Time Of Wars - завершение сеанса</title>
   <meta content="text/html; charset=windows-1251" http-equiv=Content-type>
   <meta http-equiv="Refresh" content="2;url=/index.php">
</head>
<body bgcolor="#faf2f2">
<p align="center">
 <b>
  Спасибо за посещение нашей игры.<br />
  Будем рады видеть вас снова.
 </b>
</p>
</body>
</html>
