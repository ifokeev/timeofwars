<?
include_once('db_config.php');
include_once('db.php');

$Ladd = 0;
// надо переменную на слот вписывать :(
//for($i=0; $i<11; $i++):
//if ($Slot[$i] != 'empt'.$i):

//list($lev) = $db->queryCheck("SELECT Level_add FROM ".SQL_PREFIX."things WHERE Owner = '{$_SESSION['login']}' AND Wear_ON = '1' AND Slot = '$i'");
//$Ladd += $lev;

//endif;
//endfor;


$RealL = $Level - $Ladd;

$defexp = 5;
$exp = 0;

$exp_need = 10;
$ten = 10;

for($i=0; $i<101; $i++):
	
$i1 = $i*3 + 15;
$defexp = round(($i1/4)*3);
$win_need = round($exp_need / $defexp);


$money_1 = round($win_need*2);


$exp_need += $ten;
$exp_need = round($exp_need);

$exp += $exp_need;

if ($RealL == $i):

if ($exp <= $Expa):

$db->execQuery("UPDATE ".SQL_PREFIX."players SET Level = Level + '1' WHERE Username = '{$_SESSION['login']}'");
$db->execQuery("UPDATE ".SQL_PREFIX."players SET Endu = Endu + '1' WHERE Username = '{$_SESSION['login']}'");
$db->execQuery("UPDATE ".SQL_PREFIX."players SET HPall = HPall + '3' WHERE Username = '{$_SESSION['login']}'");
$db->execQuery("UPDATE ".SQL_PREFIX."players SET Ups = Ups + '3' WHERE Username = '{$_SESSION['login']}'");
$db->execQuery("UPDATE ".SQL_PREFIX."players SET Money = Money + '$money_1' WHERE Username = '{$_SESSION['login']}'");
$db->execQuery("INSERT INTO ".SQL_PREFIX."messages (Username, Text) VALUES ('{$_SESSION['login']}', '<font color=red>¬нимание!</font> ¬ы достигли следующего уровн€!')");

$RealL++;
$db->execQuery("UPDATE ".SQL_PREFIX."online SET Level = '$RealL' WHERE Username = '{$_SESSION['login']}'");

else: $next_exp = $exp; endif;

endif;
	
if($i <= 10): $ten += 25; endif;
if($i > 10 && $i <= 50):	$ten += 60; endif;
if($i > 50 && $i <= 85):	$ten += 310; endif;
if($i > 85 && $i <= 100): $ten *= 2; endif;

endfor;
?>
