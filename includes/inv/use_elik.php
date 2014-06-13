<?
if (!empty($_GET['use_elik'])) {

if($woodc){ $err = 'Вы слишком заняты поиском трав'; }
else{

$elik = intval($_GET['use_elik']);

if( list($id, $name, $lneed) = $db->queryCheck("SELECT Id, Thing_Name, Level_need FROM ".SQL_PREFIX."things WHERE Owner = '$player->username' AND Un_Id = '$elik' AND Slot = '16' AND Id LIKE '%elix_%'") ){

if( $lneed > $player->Level ){ $err = 'Уровень не подходит.'; }
else
{
switch($id){
case 'elix_sila';
$db->update( SQL_PREFIX.'players', Array( 'Stre' => '[+]5' ), Array( 'Username' => $player->username ), 'maths' );
$db->insert( SQL_PREFIX.'drunk', Array( 'Username' => $player->username, 'Stat' => 'Stre', 'Num' => '5', 'Time' => (time()+3600) ) );
$_txt = '<b>'.$name.'</b> использован удачно. Срок действия эликсира - 1 час.';
break;

case 'elix_lovkost';
$db->update( SQL_PREFIX.'players', Array( 'Agil' => '[+]6' ), Array( 'Username' => $player->username ), 'maths' );
$db->insert( SQL_PREFIX.'drunk', Array( 'Username' => $player->username, 'Stat' => 'Agil', 'Num' => '6', 'Time' => (time()+3600) ) );
$_txt = '<b>'.$name.'</b> использован удачно. Срок действия эликсира - 1 час.';
break;

case 'elix_intl';
$db->update( SQL_PREFIX.'players', Array( 'Intl' => '[+]8' ), Array( 'Username' => $player->username ), 'maths' );
$db->insert( SQL_PREFIX.'drunk', Array( 'Username' => $player->username, 'Stat' => 'Intl', 'Num' => '8', 'Time' => (time()+3600) ) );
$_txt = '<b>'.$name.'</b> использован удачно. Срок действия эликсира - 1 час.';
break;

case 'elix_hertz';
$db->execQuery( "UPDATE ".SQL_PREFIX."players SET HPnow = HPnow + '".($lneed*4)."' WHERE Username = '".$player->username."';" );
$db->execQuery( "UPDATE ".SQL_PREFIX."players SET HPnow = HPall WHERE HPnow > HPall;" );
$_txt = '<b>'.$name.'</b> использована удачно.';
break;


}

$db->update( SQL_PREFIX.'things', Array( 'NOWwear' => '[+]1' ), Array( 'Owner' => $player->username, 'Un_Id' => $elik ), 'maths' );
$db->insert( SQL_PREFIX.'messages', Array( 'Username' => $player->username, 'Text' => $_txt ) );
$db->execQuery("DELETE FROM ".SQL_PREFIX."things WHERE NOWwear = MAXwear AND Owner = '$player->username'");

}


}


}
//проверка на лес

}
?>
