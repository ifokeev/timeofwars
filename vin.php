<?php
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

session_start();
if (empty($_SESSION['login'])) { include_once('includes/bag_log_in.php'); exit; }

require_once('db_config.php');
require_once('db.php');
require_once('includes/to_view.php');

$ClanID = @$db->SQL_result($db->query("SELECT ClanID FROM ".SQL_PREFIX."players WHERE Username = '".$_SESSION['login']."';"),0);

if( $_SESSION['login'] != 'Албано' && $ClanID != 55 && $ClanID != 4 && $ClanID != 3 && $ClanID != 2 && $ClanID != 53 && $ClanID != 1 && $ClanID != 101 && $ClanID != 50 && $ClanID != 255){
die(_adminerr);
}

if( $_SESSION['login'] != 'Албано' && !@$db->SQL_result($db->query("SELECT `access` FROM `".SQL_PREFIX."access_keepers` WHERE `Username` = '".$_SESSION['login']."' AND `access` LIKE '%look_LD%';"),0) ){die('Недостаточно прав');
}

$db->checklevelup( $_SESSION['login'] );
@$_GET['uname'] = speek_to_view($_GET['uname']);

if($_SESSION['login'] != 'Албано' && $_GET['uname'] == 'Албано'){ exit; }

if( !$user = $db->queryRow("SELECT Username, Id FROM ".SQL_PREFIX."players WHERE Username = '".$_GET['uname']."' LIMIT 1") ){ die('Такого персонажа не существует'); }


include ('includes/adm/some_funcs.php');

$Syma_cr = 0;
$m = 0;

$query  = sprintf("SELECT * FROM ".SQL_PREFIX."as_notes WHERE Username = '%s' AND Status = 'info'", $user['Username']);
$info   = $db->queryArray($query, 'info');

$query  = sprintf("SELECT * FROM ".SQL_PREFIX."as_notes WHERE Username = '%s' AND Status = 'shuted'", $user['Username']);
$shut   = $db->queryArray($query, 'shuted');

$query  = sprintf("SELECT * FROM ".SQL_PREFIX."as_notes WHERE Username = '%s' AND Status = 'unshuted'", $user['Username']);
$unshut = $db->queryArray($query, 'unshuted');

$query  = sprintf("SELECT * FROM ".SQL_PREFIX."as_notes WHERE Username = '%s' AND Status = 'chaos'", $user['Username']);
$chaos  = $db->queryArray($query, 'chaos');

$query  = sprintf("SELECT * FROM ".SQL_PREFIX."as_notes WHERE Username = '%s' AND Status = 'unchaos'", $user['Username']);
$uchaos = $db->queryArray($query, 'unchaos');

$query  = sprintf("SELECT * FROM ".SQL_PREFIX."as_notes WHERE Username = '%s' AND Status = 'blok'", $user['Username']);
$blok   = $db->queryArray($query, 'blok');

$query  = sprintf("SELECT * FROM ".SQL_PREFIX."as_notes WHERE Username = '%s' AND Status = 'deblok'", $user['Username']);
$deblok = $db->queryArray($query, 'deblok');

$query  = sprintf("SELECT * FROM ".SQL_PREFIX."as_notes WHERE Username = '%s' AND Text = 'klan'", $user['Username']);
$klan   = $db->queryArray($query, 'klan');

$query  = sprintf("SELECT * FROM `".SQL_PREFIX."transfer` WHERE (`From` = '%s') ORDER BY Date", $user['Username']);
$trfrom = $db->queryArray($query, 'transfet_from');

$query  = sprintf("SELECT * FROM `".SQL_PREFIX."transfer` WHERE (`To` = '%s') ORDER BY Date", $user['Username']);
$trTO   = $db->queryArray($query, 'transfer_TO');



$query  = sprintf("SELECT arl.money, p.Username, p.Level, p.ClanID FROM `".SQL_PREFIX."admin_referal_log` as arl INNER JOIN ".SQL_PREFIX."players as p ON ( p.Id = arl.referal_id ) WHERE  `refer_id` = '%s' AND value = 'good' ORDER BY add_time", $user['Id']);
$ref_good   = $db->queryArray($query, 'referal_good');

$query  = sprintf("SELECT arl.money, p.Username, p.Level, p.ClanID FROM `".SQL_PREFIX."admin_referal_log` as arl INNER JOIN ".SQL_PREFIX."players as p ON ( p.Id = arl.referal_id ) WHERE  `refer_id` = '%s' AND value = 'bad' ORDER BY add_time", $user['Id']);
$ref_bad  = $db->queryArray($query, 'referal_bad');




$query  = sprintf("SELECT * FROM ".SQL_PREFIX."things WHERE Owner = '%s'", $user['Username']);
$array1 = $db->queryArray($query, 'things');

$query  = sprintf("SELECT * FROM ".SQL_PREFIX."things_lock WHERE Owner = '%s'", $user['Username']);
$array2 = $db->queryArray($query, 'things');

if( empty($array1) ){$array1 = array();
}

if( empty($array2) ){
$array2 = array();
}

$things = array_merge ($array1, $array2);




$query  = sprintf("SELECT Money FROM ".SQL_PREFIX."players WHERE Username = '%s'", $user['Username']);
$m      = @$db->SQL_result( $db->query($query, 'money') );

require_once('_loader.php');

$tow_tpl->assignGlobal( 'db_config', $db_config );

$temp = & $tow_tpl->getDisplay('content', true);


$temp->assign( 'ref_good', $ref_good );
$temp->assign( 'ref_bad', $ref_bad );

$temp->assign( 'ClanID', $ClanID );
$temp->assign( 'info',   $info   );
$temp->assign( 'shut',   $shut   );
$temp->assign( 'unshut', $unshut );
$temp->assign( 'chaos',  $chaos  );
$temp->assign( 'uchaos', $uchaos );
$temp->assign( 'blok',   $blok   );
$temp->assign( 'deblok', $deblok );
$temp->assign( 'klan',   $klan   );
$temp->assign( 'trfrom', $trfrom );
$temp->assign( 'trTO',   $trTO   );
$temp->assign( 'things', $things );
$temp->assign( 'm',      $m      );

$temp->addTemplate('vin', 'timeofwars_func_vin.html');

$show = & $tow_tpl->getDisplay('index');

$show->assign('title', 'Time Of Wars - анкета персонажа '.$user['Username']);
$show->assign('Content', $temp);

$show->addTemplate( 'header', 'header_noframes.html' );
$show->addTemplate( 'index' , 'index.html'           );
$show->addTemplate( 'footer', 'footer.html'          );

$tow_tpl->display();
?>
