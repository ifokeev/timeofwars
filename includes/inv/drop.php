<?
if (!empty($drop)) {

if($woodc){ $err = 'Вы слишком заняты поиском трав'; }
//elseif($turnir_id){ $err = 'Вы слишком заняты турниром.'; }
else {

if( !list($Thing_Name, $Un_Id) = $db->queryCheck("SELECT Thing_Name, Un_Id FROM `".SQL_PREFIX."things` WHERE Owner = '$player->username' AND Un_Id = '$drop' AND Wear_ON = '0'") ){ $err = 'Такой вещи не найдено в рюкзаке'; }
elseif ( $player->id_clan != 255 && preg_match('/артефакт|клановая|именная|ability|элитно/i', $Thing_Name) ) { $err = 'Эту вещь нельзя выбросить'; }
else{

if( preg_match('/для турнира/i', $Thing_Name) && list($turn_th, $turn_id, $coord) = $db->queryCheck( "SELECT th.id, th.turnir_id, tu.coord FROM ".SQL_PREFIX."turnir_things as th INNER JOIN ".SQL_PREFIX."turnir_users as tu ON (tu.turnir_id = th.turnir_id) WHERE tu.user = '".$player->username."' AND in_use = '".$Un_Id."';") )
{	$db->execQuery("DELETE FROM ".SQL_PREFIX."things WHERE Owner = '$player->username' AND Un_Id = '$Un_Id'");
	$db->update( SQL_PREFIX.'turnir_things', Array( 'in_use' => 0, 'coord' => $coord ), Array( 'turnir_id' => $turn_id, 'id' => $turn_th ) );
	$err = 'Предмет '.$Thing_Name.' выброшен на землю. Другие персонажи могут его поднять.';
}else
{	$db->execQuery("DELETE FROM ".SQL_PREFIX."things WHERE Owner = '$player->username' AND Un_Id = '$Un_Id'");
	$db->insert( SQL_PREFIX.'transfer', Array( 'Date' => date('Y-m-d'), 'From' => $player->username, 'To' => 'Помойка', 'What' => 'Предмет '.$Thing_Name.' выброшен, уникальный ID '.$Un_Id.' ('.date('H:i').')' ) );
	$err = 'Предмет '.$Thing_Name.' выброшен';
}


}

//проверка на лес
}
// конец
}
?>
