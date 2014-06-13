<?
function test_turnir( $id )
{	global $db;

	$data = $db->queryRow( "SELECT COUNT(DISTINCT tu.user) as cnt FROM ".SQL_PREFIX."turnir as t INNER JOIN ".SQL_PREFIX."turnir_users as tu ON ( t.id = tu.turnir_id ) WHERE tu.turnir_id = '".intval($id)."' AND t.status = '2' GROUP BY tu.turnir_id;" );

	if( $data['cnt'] <= 1 )
	{
		    $db->update( SQL_PREFIX.'turnir', Array( 'status' => '3' ), Array( 'id' => $id, 'status' => '2' ) );
	        turnir_log( $id, 'В '.date('H:i:s').' турнир <b>закончился.</b> Победителя нет.' );
            turnir_msg( 'Турнир №'.$id.' <b>закончился.</b> Победителя нет.' );
    }

}

function turnir_win($user, $BattleID)
{
	global $db, $db_config;

	if( empty($user) ) die;

	$turn = $db->queryRow( "SELECT turnir_id, do_level FROM ".SQL_PREFIX."turnir_users WHERE user = '".$user['Username']."';" );
	if( $turn )
	{
		turnir_log( $turn['turnir_id'], 'В '.date('H:i:s').' '.wslogin( $user['Username'], $turn['do_level'], $user['ClanID'] ).' выиграл <a href="http://'.$db_config[DREAM]['server'].'/log2.php?id='.$BattleID.'" target="_blank">бой ID: '.$BattleID.'.</a>.' );
		turnir_msg( wslogin(  $user['Username'], $turn['do_level'], $user['ClanID'] ).' выиграл <a href="http://'.$db_config[DREAM]['server'].'/log2.php?id='.$BattleID.'" target="_blank">бой ID: '.$BattleID.'.</a>' );

	}

}

function turnir_lose(&$player)
{
	global $db, $db_config;

	$turn = $db->queryRow( "SELECT turnir_id, do_level, do_stre, do_agil, do_intu, do_intl, do_endu, do_ups, do_hpall FROM ".SQL_PREFIX."turnir_users WHERE user = '".$player->Username."';" );
	if( $turn )
	{
		$db->update( SQL_PREFIX.'players', Array( 'Level' => $turn['do_level'], 'Stre' => $turn['do_stre'], 'Agil' => $turn['do_agil'], 'Intu' => $turn['do_intu'], 'Intl' => $turn['do_intl'], 'Endu' => $turn['do_endu'], 'Ups' => $turn['do_ups'], 'HPnow' => 0, 'HPall' => $turn['do_hpall'] ), Array( 'Username' => $player->Username ) );
		$player->unwear_all();

		$db->execQuery( "DELETE FROM ".SQL_PREFIX."turnir_users WHERE user = '".$player->Username."';" );
    	$db->execQuery( "DELETE t, th FROM ".SQL_PREFIX."things as t INNER JOIN ".SQL_PREFIX."turnir_things as th ON (th.in_use = t.Un_Id) WHERE t.Owner = '".$player->Username."' AND t.Wear_ON = '0' AND th.in_use = t.Un_Id;");
    	$db->update( SQL_PREFIX.'drunk', Array( 'Time' => time() ), Array( 'Username' => $player->Username ) );
		turnir_log( $turn['turnir_id'], 'В '.date('H:i:s').' '.wslogin( $player->Username, $turn['do_level'], $player->id_clan ).' выбыл из турнира.' );
		turnir_msg( wslogin( $player->Username, $turn['do_level'], $player->id_clan ).' выбыл из турнира.' );
	}

}

function turnir_draw_game(&$player)
{
	global $db, $db_config;

	$turn = $db->queryRow( "SELECT turnir_id, do_level, do_stre, do_agil, do_intu, do_intl, do_endu, do_ups, do_hpall FROM ".SQL_PREFIX."turnir_users WHERE user = '".$player->Username."';" );
	if( $turn )
	{
		$db->update( SQL_PREFIX.'players', Array( 'Level' => $turn['do_level'], 'Stre' => $turn['do_stre'], 'Agil' => $turn['do_agil'], 'Intu' => $turn['do_intu'], 'Intl' => $turn['do_intl'], 'Endu' => $turn['do_endu'], 'Ups' => $turn['do_ups'], 'HPnow' => 0, 'HPall' => $turn['do_hpall'] ), Array( 'Username' => $player->Username ) );
    	turnir_log( $turn['turnir_id'], 'В '.date('H:i:s').' '.wslogin( $player->Username, $turn['do_level'], $player->id_clan ).' выбыл из турнира.' );
		turnir_msg( wslogin( $player->Username, $turn['do_level'], $player->id_clan ).' выбыл из турнира.' );
		test_turnir($turn['turnir_id']);
		$player->unwear_all();
		$db->execQuery( "DELETE FROM ".SQL_PREFIX."turnir_users WHERE user = '".$player->Username."';" );
    	$db->execQuery( "DELETE t, th FROM ".SQL_PREFIX."things as t INNER JOIN ".SQL_PREFIX."turnir_things as th ON (th.in_use = t.Un_Id) WHERE t.Owner = '".$player->Username."' AND t.Wear_ON = '0' AND th.in_use = t.Un_Id;");
    	$db->update( SQL_PREFIX.'drunk', Array( 'Time' => time() ), Array( 'Username' => $player->Username ) );
	}


}
?>