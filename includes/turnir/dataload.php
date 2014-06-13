<?
if( !empty($_POST['dataload']) && $_POST['dataload'] == 'to_interfere' )
{	$turnir = intval($_POST['turnir']);
	if ( !empty($turnir) && $turnir > 0 && is_numeric($turnir) && !empty($_POST['team']) && ($_POST['team'] == 1 || $_POST['team'] == 2) )
	{			$player->to_interfere( slogin($player->username, $turnir_map->do_level, $player->id_clan), $turnir, $_POST['team'] );


            $log_team = $_POST['team'] == 2 ? '<font color="#6666ff">синих.</font>' : '<font color="#ff6666">красных.</font>';
            $db->update( SQL_PREFIX.'turnir_users', Array( 'battle_id' => $turnir  ), Array( 'user' => $player->username ) );
    		turnir_log( intval($_POST['turnir_id']), 'В '.date('H:i:s').' в <a href="log.php?id='.$turnir.'" target="_blank">поединок</a> вмешался '.slogin($player->username, $turnir_map->do_level, $player->id_clan).' за команду '.$log_team );
    		turnir_msg( 'В <a href="../log.php?id='.$turnir.'" target="_blank">поединок</a> вмешался '.slogin($player->username, $turnir_map->do_level, $player->id_clan).' за команду '.$log_team );

	}
	else
		die( 'err' );




	die;
}
if( !empty($_POST['dataload']) && $_POST['dataload'] == 'test_turnir' )
{

	$turn = $db->queryRow( "SELECT COUNT(DISTINCT tu.user) as cnt, tu.user, t.prize, tu.points, tu.do_level, tu.do_stre, tu.do_agil, tu.do_intu, tu.do_intl, tu.do_endu, tu.do_ups, tu.do_hpall FROM ".SQL_PREFIX."turnir as t INNER JOIN ".SQL_PREFIX."turnir_users as tu ON ( t.id = tu.turnir_id ) WHERE tu.turnir_id = '".$turnir_map->turnir_id."' AND t.status = '2' GROUP BY tu.turnir_id;" );

	if( $turn['cnt'] <= 1 )
	{
		if( !empty($turn['user']) )
		{			$winner = new PlayerInfo($turn['user']);

            $db->update( SQL_PREFIX.'drunk', Array( 'Time' => time() ), Array( 'Username' => $winner->username ) );

           	//необходимо

 						$res = $db->queryFetchArray("SELECT id, Time, Num, Username, Stat FROM ".SQL_PREFIX."drunk WHERE Username = '".$winner->username."';");

                        if( !empty($res) )
							foreach($res as $v)
							{
							  	$stat = split(';', $v[4]);
							 	$num  = split (';', $v[2]);

							 	if( empty( $stat ) ) break;

							 	$del = '';

							  	foreach( $stat as $stat_k => $stat_v )
							 		$del .= ', '.$stat_v.' = '.$stat_v.' - \''.$num[$stat_k].'\' ';

							 	if( time() >= $v[1] && !empty($del) )
							 	{
							 		$db->execQuery("UPDATE ".SQL_PREFIX."players SET Username = '$v[3]' $del WHERE Username = '$v[3]'");
							 		$db->execQuery("DELETE FROM ".SQL_PREFIX."drunk WHERE id = '$v[0]' AND Username = '$v[3]' AND Time <= '".time()."'");
							 		$db->insert( SQL_PREFIX.'messages', Array( 'Username' => $v[3], 'Text' => '<font color="red">Внимание!</font> Действие эликсира закончилось.' ) );
							 	}
							}

			$item = $winner->getItemsInfo( $winner->username );
			for( $i = 0; $i < 11; $i++ )
			{				if( $item['Slot'][$i] != 'empt'.$i )
				{					$winner->unwear( $item['Slot_id'][$i] );
				}
			}

			if( $winner->HPnow >= $turn['do_hpall'] ) $hpnow = $turn['do_hpall'];
			else $hpnow = $winner->HPnow;

			$winner->setHP($hpnow);

			$db->update( SQL_PREFIX.'players', Array( 'Money' => '[+]'.$turn['prize'], 'Level' => $turn['do_level'], 'Stre' => $turn['do_stre'], 'Agil' => $turn['do_agil'], 'Intu' => $turn['do_intu'], 'Intl' => $turn['do_intl'], 'Endu' => $turn['do_endu'], 'Ups' => $turn['do_ups'], 'HPnow' => $hpnow, 'HPall' => $turn['do_hpall'] ), Array( 'Username' => $winner->username ), 'maths' );
			$db->insert( SQL_PREFIX.'transfer', Array( 'Date' => date('Y-m-d H:i'), 'From' => 'Турнир', 'To' => $winner->username, 'What' => 'Выиграл <a href="turnir_log.php?id='.$turnir_map->turnir_id.'" target="_blank">турнир</a> и получил приз '.$turn['prize'].' кр.' ) );
			$db->update( SQL_PREFIX.'turnir', Array( 'points' => $turn['points'], 'status' => '3', 'winner' => $winner->username.';'.$turn['do_level'].';'.$winner->id_clan.';' ), Array( 'id' => $turnir_map->turnir_id, 'status' => '2' ) );
            $db->execQuery( "DELETE FROM ".SQL_PREFIX."turnir_users WHERE user = '".$winner->username."' AND turnir_id = '".$turnir_map->turnir_id."';" );
            $db->execQuery( "DELETE t, th FROM ".SQL_PREFIX."things as t INNER JOIN ".SQL_PREFIX."turnir_things as th ON (th.in_use = t.Un_Id) WHERE t.Owner = '".$winner->username."' AND t.Wear_ON = '0' AND th.in_use = t.Un_Id;");




            $db->query("TRUNCATE TABLE ".SQL_PREFIX."turnir_things");
            turnir_log( $turnir_map->turnir_id, 'В '.date('H:i:s').' турнир <b>закончился.</b> Победитель '.slogin( $winner->username, $turn['do_level'], $winner->id_clan ).' получает приз '.$turn['prize'].' кр.' );
            turnir_msg( 'Турнир №'.$turnir_map->turnir_id.' <b>закончился.</b> Победитель '.slogin( $winner->username, $turn['do_level'], $winner->id_clan ).'.' ) ;
            echo 'go';
		}
		else
		{			$db->query("TRUNCATE TABLE ".SQL_PREFIX."turnir_things");
		    $db->update( SQL_PREFIX.'turnir', Array( 'status' => '3' ), Array( 'id' => $turnir_map->turnir_id, 'status' => '2' ) );
	        turnir_log( $turnir_map->turnir_id, 'В '.date('H:i:s').' турнир <b>закончился.</b> Победителя нет.' );
            turnir_msg( 'Турнир №'.$turnir_map->turnir_id.' <b>закончился.</b> Победителя нет.' ) ;
            echo 'go';
		}

    }

    die;

}

if( !empty($_POST['goin']) && ($_POST['goin'] == 'top' || $_POST['goin'] == 'bottom' || $_POST['goin'] == 'left' || $_POST['goin'] == 'right') )
{
	if( !empty($sms) )
	{
		$m_end = 1;
    }
    else
    {
    	$m_end = 5;
    }

	$db->update( SQL_PREFIX.'turnir_users', Array( 'end_move' => time()+$m_end, 'move_direction' => $_POST['goin'] ), Array( 'user' => $player->username ) );

	echo $m_end;
	die;
}


if( !empty($_POST['dataload']) && $_POST['dataload'] == 'emptys' )
{
	if( !empty($player->id_battle) )
	{
		echo '<script>window.location.reload();</script>';
		die;
	}

	$emptys = $db->queryArray( "SELECT tu.user, tu.battle_id, p.Username, p.Level, p.ClanID, p.Align, p.BattleID FROM ".SQL_PREFIX."turnir as t INNER JOIN ".SQL_PREFIX."turnir_users as tu ON ( t.id = tu.turnir_id ) INNER JOIN ".SQL_PREFIX."players as p ON ( p.Username = tu.user ) WHERE tu.turnir_id = '".$turnir_map->turnir_id."' AND tu.coord = '".$turnir_map->coord."' AND tu.user <> '".$player->username."' AND t.status = '2';" );

	if( !empty($emptys) )
	{
		foreach( $emptys as $empt )
		{
			echo dlogin( $empt['user'], $empt['Level'], $empt['Align'], $empt['ClanID'] ); if( empty($empt['BattleID']) ){ echo '<a href="?gobattle='.$empt['user'].'"><img src="http://'.$db_config[DREAM_IMAGES]['server'].'/turnir/boy.gif" width="12px" height="12px" /></a>'; } echo '<br />';
        }
    }
    else
    {
    	echo '&nbsp;<br />&nbsp; Пусто';
    }


   die;
}


if( !empty($_POST['dataload']) && $_POST['dataload'] == 'take_this' )
{	if( $thing = $db->queryRow( "SELECT * FROM ".SQL_PREFIX."turnir_things WHERE turnir_id = '".$turnir_map->turnir_id."' AND coord = '".$turnir_map->coord."' AND id = '".intval($_POST['thing_id'])."' AND (in_use = '' OR in_use = '0');" ) )
	{		switch($thing['img'])
		{			case 'elix_sila';
			$db->update( SQL_PREFIX.'players', Array( 'Stre' => '[+]5' ), Array( 'Username' => $player->username ), 'maths' );
			$db->insert( SQL_PREFIX.'drunk', Array( 'Username' => $player->username, 'Stat' => 'Stre', 'Num' => '5', 'Time' => (time()+3600) ) );
			$db->execQuery( "DELETE FROM ".SQL_PREFIX."turnir_things WHERE turnir_id = '".$turnir_map->turnir_id."' AND id = '".$thing['id']."';" );
			die( '&nbsp;<br />&nbsp; '.$thing['Thing_Name'].' удачно залит в себя.' );
			break;

			case 'elix_lovkost';
			$db->update( SQL_PREFIX.'players', Array( 'Agil' => '[+]6' ), Array( 'Username' => $player->username ), 'maths' );
			$db->insert( SQL_PREFIX.'drunk', Array( 'Username' => $player->username, 'Stat' => 'Agil', 'Num' => '6', 'Time' => (time()+3600) ) );
			$db->execQuery( "DELETE FROM ".SQL_PREFIX."turnir_things WHERE turnir_id = '".$turnir_map->turnir_id."' AND id = '".$thing['id']."';" );
			die( '&nbsp;<br />&nbsp; '.$thing['Thing_Name'].' удачно залит в себя.' );
			break;

			case 'elix_hertz';
			$db->execQuery( "UPDATE ".SQL_PREFIX."players SET HPnow = HPnow + '50' WHERE Username = '".$player->username."';" );
			$db->execQuery( "UPDATE ".SQL_PREFIX."players SET HPnow = HPall WHERE HPnow > HPall;" );
			$db->execQuery( "DELETE FROM ".SQL_PREFIX."turnir_things WHERE turnir_id = '".$turnir_map->turnir_id."' AND id = '".$thing['id']."';" );
			die( '&nbsp;<br />&nbsp; '.$thing['Thing_Name'].' удачно залит в себя.' );
			break;

		}
		$db->insert( SQL_PREFIX.'things',
		Array(
		'Owner' => $player->username, 'Id' => $thing['img'], 'Thing_Name' => $thing['Thing_Name'],
		'Slot' => $thing['slot'],
		'MINdamage' => $thing['MINdamage'], 'MAXdamage' => $thing['MAXdamage'],
		'Crit' => $thing['Crit'], 'AntiCrit' => $thing['AntiCrit'],
		'Uv' => $thing['Uv'], 'AntiUv' => $thing['AntiUv'],
		'Armor1' => $thing['Armor1'], 'Armor2' => $thing['Armor2'], 'Armor3' => $thing['Armor3'], 'Armor4' => $thing['Armor4'],
		'NOWwear' => 0, 'MAXwear' => 1, 'Wear_ON' => '0'
		), 'query'
		);

		$db->update( SQL_PREFIX.'turnir_things', Array( 'in_use' => $db->insertId() ), Array( 'turnir_id' => $turnir_map->turnir_id, 'id' => $thing['id'] ) );

		die( '&nbsp;<br />&nbsp; Вещь помещена в инвентарь.' );
	}
	else
	{		die( '&nbsp;<br />&nbsp; Вещь-то какой-то гад уже тю-тю...' );
    }
}

if( !empty($_POST['dataload']) && $_POST['dataload'] == 'things' )
{	if( !empty($player->id_battle) )
	{
		echo '<script>window.location.reload();</script>';
		die;
	}	$things = $db->queryArray( "SELECT * FROM ".SQL_PREFIX."turnir_things WHERE turnir_id = '".$turnir_map->turnir_id."' AND coord = '".$turnir_map->coord."' AND (in_use = '' OR in_use = '0');" );
	if( !empty($things) )
	{		foreach( $things as $thg )
		{		?>
		  <a href="javascript:take_this(<?=$thg['id'];?>);"><img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/turnir/hand.gif" /></a>&nbsp;<a href="turnir_thing.php?id=<?=$thg['id'];?>" target="_blank"><?=$thg['Thing_Name'];?></a><br />
		<?
		}
	}
	else
	{		echo '&nbsp;<br />&nbsp; Пусто';
    }    die;
}

if( !empty($_POST['dataload']) && $_POST['dataload'] == 'battles' )
{
	if( !empty($player->id_battle) )
	{
		echo '<script>window.location.reload();</script>';
		die;
	}

	$battles = $db->queryArray( "SELECT team1, team2, ba.id FROM ".SQL_PREFIX."2battle as ba INNER JOIN ".SQL_PREFIX."turnir_users as tu ON ( tu.battle_id = ba.id ) WHERE tu.turnir_id = '".$turnir_map->turnir_id."' AND tu.coord = '".$turnir_map->coord."' AND ba.status = 'during' GROUP BY ba.id;" );

      if( !empty($battles) )
      {
       foreach( $battles as $btl )
       {       	$cnt = count(split( ';', $btl['team1'] ))-1 + count(split( ';', $btl['team2'] ))-1;
      ?>
       <a href="log.php?id=<?=$btl['id'];?>" target="_blank"><img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/bullet_green.png" /></a><a href="javascript:interfere(<?=$btl['id'];?>);">ID: <?=$btl['id'];?> (<?=okon4($cnt, array('участник', 'участника', 'участников'));?>)</a>
      <?
       }
      }
      else
      {
      	echo '&nbsp;<br />&nbsp; Пусто';
      }

      die;
}


?>