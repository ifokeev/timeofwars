<?
class turnir_map extends PlayerInfo
{	public $username;
	public $user_id;
	public $id_clan;
	public $turnir_id;
	public $coord;
	public $end_move;
	public $move_direction;
	public $do_level;
	public $sms;
	public $go_array = array();
	function __construct($user, $id, $clanid, $battleid )
	{		global $db, $db_config, $good_cage;
		$this->username = $user;
		$this->user_id  = $id;
		$this->id_clan = $clanid;
		$this->id_battle = $battleid;

		$us_data = $db->queryRow( "SELECT
										tu.turnir_id,
										tu.coord,
										tu.end_move,
										tu.do_level,
										tu.move_direction
									FROM
										".SQL_PREFIX."turnir as t
											INNER JOIN ".SQL_PREFIX."turnir_users as tu ON
												t.id = tu.turnir_id
									WHERE tu.user = '".$this->username."' AND t.status = '2';" );


        if( empty($us_data) )
			$this->gotoRoom( 'turnir', 'turnir' );


		$this->turnir_id      = $us_data['turnir_id'];
		$this->coord 	      = $us_data['coord'];



		$this->end_move       = $us_data['end_move'];
		$this->move_direction = $us_data['move_direction'];
		$this->do_level       = $us_data['do_level'];

		$this->mdl_lvl = file_get_contents( $db_config[DREAM]['web_root'] . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'turnir' . DIRECTORY_SEPARATOR . 'middle_lvl_'.$this->turnir_id.'.dat' );
        $this->sms = $db->SQL_result( $db->query ( "SELECT sms_time FROM ".SQL_PREFIX."sms_turnir WHERE user_id = '".$this->user_id."' AND sms_time >= '".time()."';" ),0 );


		if( !file_exists( $db_config[DREAM]['web_root'] . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'turnir' . DIRECTORY_SEPARATOR . 'map.txt' ) )
		{
			file_put_contents(
			$db_config[DREAM]['web_root'] . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'turnir' . DIRECTORY_SEPARATOR . 'map.txt',
			'1;1;1;1'."\n".'1;0;0;1'."\n".'1;0;0;1'."\n".'1;1;1;1'."\n"
			);
		}

	}


	public function update_to_middl_level()
	{
		global $db;

		$Level = $this->mdl_lvl;

		$sumstats = $Level*4 + 15;

		$endustats = $Level + 3;
		$enduadd   = $endustats*3;
		$enduall   = $enduadd + 9;
		$freestats = $sumstats - $endustats - 9;

		$db->update( SQL_PREFIX.'players', Array( 'Level' => $Level, 'Stre' => 3, 'Agil' => 3, 'Intu' => 3, 'Endu' => $endustats, 'Intl' => '0', 'HPall' => $enduall, 'HPnow' => $enduall, 'Ups' => $freestats ), Array( 'Username' => $this->username ) );

	}

	public function set_cage( $cage )
	{		global $db;
		$db->update( SQL_PREFIX.'turnir_users', Array( 'end_move' => 0, 'move_direction' => '', 'coord' => $cage ), Array( 'user' => $this->username ) );        $this->coord = $cage;
        $this->end_move = '';

	}

	public function go_battle_turnir( $user, $x, $y )
	{		global $db;

        $msg = '';

		list( $enemy, $lvl, $cid, $hpnow, $batid ) = $db->queryCheck( "SELECT p.Username, tu.do_level, p.ClanID, p.HPnow, p.BattleID FROM ".SQL_PREFIX."players as p INNER JOIN ".SQL_PREFIX."turnir_users as tu ON (p.Username = tu.user) WHERE tu.coord = '".$this->coord."' AND tu.user = '".speek_to_view($user)."';" );
		if( !$enemy ){ $msg = 'Персонаж убежал с локации.'; }
		elseif( !empty($batid) ) $msg = 'Персонаж в бою';
		elseif( $hpnow <= 0 ){ $msg = 'Какой-то слабенький он...'; }
		else
		{

	        $b_id = $this->goBattle( $enemy );
			$db->insert( SQL_PREFIX.'messages',    Array( 'Username' => $this->username, 'Text' => 'Вы напали на <b> '.$enemy.' </b>' ) );
			$db->insert( SQL_PREFIX.'messages',    Array( 'Username' => $enemy, 'Text' => 'Внимание! На вас напал <b> '.$this->username.' </b>!' ) );

	        $db->update( SQL_PREFIX.'turnir_users', Array( 'battle_id' => $b_id ), Array( 'user' => $this->username ) );
	        $db->update( SQL_PREFIX.'turnir_users', Array( 'battle_id' => $b_id ), Array( 'user' => $enemy ) );

			turnir_log( $this->turnir_id, 'В '.date('H:i:s').' '.wslogin( $this->username, $this->do_level, $this->id_clan ).' напал на '.wslogin( $enemy, $lvl, $cid ).' в локации x:'.$x.'; y:'.$y.'. Завязался <a href="log.php?id='.$b_id.'" target="_blank">бой</a>.' );
	        turnir_msg( wslogin( $this->username, $this->do_level, $this->id_clan ).' напал на '.wslogin( $enemy, $lvl, $cid ).' в локации x:'.$x.'; y:'.$y.'.' );


			die( header( 'Location: battle.php' ) );

	    }

	    return $msg;
	}

	public function insert_things()
	{		global $db, $db_config, $good_cage;
		if( !$db->queryRow( "SELECT * FROM ".SQL_PREFIX."turnir_things WHERE turnir_id = '".$this->turnir_id."';" ) )
		{
			$things = file( $db_config[DREAM]['web_root'] . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'turnir' . DIRECTORY_SEPARATOR . 'things.dat' );
	    	$cnt = $db->SQL_result( $db->query( "SELECT COUNT(*) FROM ".SQL_PREFIX."turnir_users WHERE turnir_id = '".$this->turnir_id."' GROUP BY turnir_id;" ),0);

 	    	$min = ceil(count($things)/$cnt);
	    	$max = ceil($cnt*mt_rand(3,7));
 	    	$rand = $min >= $max ? $max : mt_rand( $min, $max );
 	    	$thg = array_rand( $things, $rand );
	        $c_rand = count($thg) <= $min ? 1 : mt_rand( 1, ceil($min/$max) );

	    	foreach( $thg as $thing )
	    	{
	    		list( $name, $img, $slot, $uv, $auv, $krit, $akrit, $arm1, $arm2, $arm3, $arm4, $min_dmg, $max_dmg ) = explode( ';', $things[$thing] );

	    		if( $c_rand == 1 )
	    			$coords = array( array_rand( $good_cage, $c_rand ) );
	    		else
	    			$coords = array_rand( $good_cage, $c_rand );

	    		if( !empty($coords) )
		    		foreach( $coords as $coord )
		    		{
		    			$db->insert( SQL_PREFIX.'turnir_things',
		    			Array(
		   		 		'turnir_id' => $this->turnir_id,
		    			'coord' => $good_cage[$coord],
		    			'Thing_Name' => $name,
		    			'img' => $img,
		   		 		'slot' => $slot,
		    	        'Crit' => $krit,
		    	        'AntiCrit' => $akrit,
		    	        'Uv' => $uv,
		     	        'AntiUv' => $auv,
		    	   	    'Armor1' => $arm1,
		      	        'Armor2' => $arm2,
		                'Armor3' => $arm3,
		            	'Armor4' => $arm4,
		            	'MINdamage' => $min_dmg,
		            	'MAXdamage' => $max_dmg,
		            	) );

		       	 	}
	    	}

	    }

	}


	public function go_img($n_cages, $map)
	{
		$go = array( 'up' => '', 'right' => '', 'down' => '', 'left' => '' );

		if( $this->coord-$n_cages < 0 )
			$up_cages = 0;
		else
			$up_cages = $n_cages;


		if( $this->coord+$n_cages > count($map) )
		    $down_cages = 0;
		else
			$down_cages = $n_cages;


		if( isset($map[$this->coord-$up_cages]) && $map[$this->coord] == 1 && $map[$this->coord-$up_cages] == 1 )
				$go['up']    = true;

		if( isset($map[$this->coord+1]) && $map[$this->coord] == 1 && $map[$this->coord+1] == 1 )
		   		$go['right'] = true;

		if( isset($map[$this->coord+$down_cages]) && $map[$this->coord] == 1 && $map[$this->coord+$down_cages] == 1 )
		   		$go['down']  = true;

		if( isset($map[$this->coord-1]) && $map[$this->coord] == 1 && $map[$this->coord-1] == 1 )
				$go['left']  = true;





		if( $go['up'] == true && $go['right'] == true && $go['down'] == true && $go['left'] == true )      $img = 1;
		elseif( $go['up'] != true && $go['right'] == true && $go['down'] != true && $go['left'] == true )  $img = 2;
		elseif( $go['up'] == true && $go['right'] != true && $go['down'] == true && $go['left'] != true )  $img = 3;
		elseif( $go['up'] == true && $go['right'] != true && $go['down'] != true && $go['left'] == true )  $img = 4;
		elseif( $go['up'] != true && $go['right'] != true && $go['down'] == true && $go['left'] == true )  $img = 5;
		elseif( $go['up'] == true && $go['right'] == true && $go['down'] != true && $go['left'] != true )  $img = 6;
		elseif( $go['up'] != true && $go['right'] == true && $go['down'] == true && $go['left'] != true )  $img = 7;
		elseif( $go['up'] != true && $go['right'] != true && $go['down'] == true && $go['left'] != true )  $img = 8;
		elseif( $go['up'] != true && $go['right'] == true && $go['down'] != true && $go['left'] != true )  $img = 9;
		elseif( $go['up'] == true && $go['right'] != true && $go['down'] != true && $go['left'] != true )  $img = 10;
		elseif( $go['up'] != true && $go['right'] != true && $go['down'] != true && $go['left'] == true )  $img = 11;
		elseif( $go['up'] == true && $go['right'] == true && $go['down'] != true && $go['left'] == true )  $img = 12;
		elseif( $go['up'] != true && $go['right'] == true && $go['down'] == true && $go['left'] == true )  $img = 13;
		elseif( $go['up'] == true && $go['right'] == true && $go['down'] == true && $go['left'] != true )  $img = 14;
		elseif( $go['up'] == true && $go['right'] != true && $go['down'] == true && $go['left'] == true )  $img = 15;


		$this->go_array = $go;

		return $img;

	}


	public function end_turnir_bug()
	{
		global $db;

		$turn = $db->queryRow( "SELECT
									COUNT(DISTINCT tu.user) as cnt
			 					FROM
			 						".SQL_PREFIX."turnir as t
			 							INNER JOIN
			 								".SQL_PREFIX."turnir_users as tu ON
			 									t.id = tu.turnir_id
			 					WHERE
			 						tu.turnir_id = '".$this->turnir_id."' AND t.status = '2'
			 					GROUP BY tu.turnir_id;" );

		if( $turn['cnt'] == 2 && empty($this->id_battle) )
		{			if( $user = $db->queryRow("SELECT
											p.Username,
											p.ClanID,
											do_level,
											do_stre,
											do_agil,
											do_intu,
											do_intl,
											do_endu,
											do_ups,
											do_hpall
										FROM
											".SQL_PREFIX."turnir_users as tu
												INNER JOIN ".SQL_PREFIX."players as p ON
													p.Username = tu.user
										WHERE
											p.Room = 'turnir_map' AND p.Username <> '".$this->username."' AND p.BattleID IS NOT NULL LIMIT 1;" ) )
			{


 				   $res = $db->queryFetchArray("SELECT id, Time, Num, Username, Stat FROM ".SQL_PREFIX."drunk WHERE Username = '".$user['Username']."';");

                        if( !empty($res) )
							foreach($res as $v)
							{
							  	$stat = explode(';', $v[4]);
							 	$num  = explode (';', $v[2]);

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

					$item = $this->getItemsInfo( $user['Username'] );
					for( $i = 0; $i < 11; $i++ )
						if( $item['Slot'][$i] != 'empt'.$i )
							$this->unwear( $user['Username'], $item['Slot_id'][$i] );




					$db->update( SQL_PREFIX.'players', Array(
														'Level' => $user['do_level'],
														'Stre' => $user['do_stre'],
														'Agil' => $user['do_agil'],
														'Intu' => $user['do_intu'],
														'Intl' => $user['do_intl'],
														'Endu' => $user['do_endu'],
														'Ups' => $user['do_ups'],
														'HPnow' => 0,
														'HPall' => $user['do_hpall']
														),
														Array( 'Username' => $user['Username'] ) );

					$db->execQuery( "DELETE FROM ".SQL_PREFIX."turnir_users WHERE user = '".$user['Username']."';" );
				    $db->execQuery( "DELETE t, th FROM ".SQL_PREFIX."things as t INNER JOIN ".SQL_PREFIX."turnir_things as th ON (th.in_use = t.Un_Id) WHERE t.Owner = '".$user['Username']."';");



					turnir_log( $this->turnir_id, 'В '.date('H:i:s').' '.wslogin( $user['Username'], $user['do_level'], $user['ClanID'] ).' выбыл из турнира.' );
					turnir_msg( wslogin( $user['Username'], $user['do_level'], $user['ClanID'] ).' выбыл из турнира.' );
			}

		}


	}

	function unwear($user, $id)
	{
		global $db;


		$query = '';

		if( !$thing_on = $db->queryRow("SELECT Un_Id, Endu_add, Slot, Stre_add, Agil_add, Intu_add, Level_add, Thing_Name FROM ".SQL_PREFIX."things WHERE Owner = '".$user."' AND Un_Id = '$id' AND Wear_ON = '1'") )	break;
		else
		{



			$upd = Array();

			if ($this->HPnow > ($this->HPall - $thing_on['Endu_add']) )
			{
				                      $upd['HPnow'] = ($this->HPall - $thing_on['Endu_add']);
			}
			if ($thing_on['Stre_add']) {  $upd['Stre'] = '[-]'.$thing_on['Stre_add'];     }
			if ($thing_on['Agil_add']) {  $upd['Agil'] = '[-]'.$thing_on['Agil_add'];     }
			if ($thing_on['Intu_add']) {  $upd['Intu'] = '[-]'.$thing_on['Intu_add'];     }
			if ($thing_on['Endu_add']) {  $upd['HPall'] = '[-]'.$thing_on['Endu_add'];    }
			if ($thing_on['Level_add']) { $upd['Level'] = '[-]'.$thing_on['Level_add'];   }
			if ($thing_on['Slot'] == 4 || $thing_on['Slot'] == 5 || $thing_on['Slot'] == 6)
			{
				                      $query = ", Slot = '4'";
			}


			if( !empty($upd) )
				$db->update( SQL_PREFIX.'players', $upd, Array( 'Username' => $user ), 'maths' );


			$db->execQuery("UPDATE ".SQL_PREFIX."things SET Wear_ON = '0' ".$query." WHERE Owner = '".$user."' AND Un_Id = '".$id."' AND Wear_ON = '1'");





		}


	}
}
?>