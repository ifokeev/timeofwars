<?php
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

include_once('../db_config.php');
include_once('../db.php');

$res = $db->queryFetchArray("SELECT id, Time, Num, Username, Stat FROM ".SQL_PREFIX."drunk");

if( !empty($res) ){
foreach($res as $v){

$turnir = @$db->SQL_result($db->query( "SELECT tu.user FROM ".SQL_PREFIX."turnir_users as tu INNER JOIN ".SQL_PREFIX."turnir as t ON ( t.id = tu.turnir_id ) WHERE tu.user = '".$v[3]."' AND t.status = '2';" ), 0,0);
if( !$turnir )
{ 	$stat = split(';', $v[4]);
 	$num  = split (';', $v[2]);

 	if( empty( $stat ) ) die;

 	$del = '';

 	foreach( $stat as $stat_k => $stat_v )
 	{ 		$del .= ', '.$stat_v.' = '.$stat_v.' - \''.$num[$stat_k].'\' ';
 	}

 	if( time() >= $v[1] && !empty($del) )
 	{
 		$db->execQuery("UPDATE ".SQL_PREFIX."players SET Username = '$v[3]' $del WHERE Username = '$v[3]'");
 		$db->execQuery("DELETE FROM ".SQL_PREFIX."drunk WHERE id = '$v[0]' AND Username = '$v[3]' AND Time <= '".time()."'");
 		$db->insert( SQL_PREFIX.'messages', Array( 'Username' => $v[3], 'Text' => '<font color="red">Внимание!</font> Действие эликсира закончилось.' ) );
 	}

}

}

}

unset($res);
?>

