<?

function get_date()
{
	return '<span>'.date( 'H:i' ).'.</span>&nbsp;';
}

function do_udar( &$player, &$enemy, $my_kicks, $enemy_blocks, $step = 0 )
{
		global $db, $db_config;

		//$true_blocks = array();
		//$true_kicks = array();
        $block_crit = 0;
        $critanul   = 0;
        $uvernulsa  = 0;
        $set_dead   = 0;
        $has_uv     = 0;
        $hascrit    = 0;
        $abil_work  = 1;
        $koef       = 0;

		$my_modif = $player->get_modif_player();
		$enemy_modif = $enemy->get_modif_player();


        if( $enemy->Reg_IP == 'бот' || $player->Reg_IP == 'бот' ) $abil_work = 0;

//print_r($enemy_modif); echo '<br /><br /><br /><br />'; print_r($my_modif); die;
//echo $my_kicks; echo '<br /><br /><br /><br />';  echo $enemy_blocks; die;

		$my_crit  = $my_modif['crit'] - $enemy_modif['acrit'];
		$his_uv   = $enemy_modif['uv'] - $my_modif['auv'];
        $delta_uv = 1;

        $my_crit = $my_crit/1.75;
        $his_uv  = $his_uv/3;

		if( $my_crit < 0 ) $my_crit = 0;
		if( $his_uv < 0 )  $his_uv = 0;

        if( $abil_work == 1 )
  			include ( $db_config[DREAM]['web_root']. DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'battle2' . DIRECTORY_SEPARATOR . 'abils' . DIRECTORY_SEPARATOR . 'battle_abils_mf.php' );

        if( empty($my_kicks) ) die( 'error' );


		if( $player->Username == 'ЛамоБот' && @list($uron_time, $for) = $db->queryCheck( "SELECT Time, for_time FROM ".SQL_PREFIX."sms_2uron WHERE Username = '".$enemy->Username."';" ) )
		{
			if( !empty($uron_time) && !empty($for) && time() - $uron_time < $for*3600 )
				$koef = 1.5;
        }

		elseif ( $player->Username == 'ЛамоБот' && @list($uron_time, $for) = $db->queryCheck( "SELECT Time, for_time FROM ".SQL_PREFIX."sms_3uron WHERE Username = '".$enemy->Username."';" ) )
		{
			if( !empty($uron_time) && !empty($for) && time() - $uron_time < $for*3600 )
				$koef = 2;

        }

		if ( list($uron_time, $for) = $db->queryCheck( "SELECT Time, for_time FROM ".SQL_PREFIX."sms_2uron WHERE Username = '".$player->Username."';" ) )
		{
			if( !empty($uron_time) && !empty($for) && time() - $uron_time < $for*3600 )
				$koef = 2;
        }

		elseif ( list($uron_time, $for) = @$db->queryCheck( "SELECT Time, for_time FROM ".SQL_PREFIX."sms_3uron WHERE Username = '".$player->Username."';" ) )
		{
			if( !empty($uron_time) && !empty($for) && time() - $uron_time < $for*3600 )
				$koef = 3;
        }

		else
		{
			if( $db->queryRow( "SELECT Un_Id FROM ".SQL_PREFIX."things WHERE ( Id = 'ring_dd' OR Id = 'a_bt06' ) AND Owner = '".$player->Username."' AND Wear_ON = '1';" ) )
				$koef = 2;
        }


       /*
        foreach( $my_kicks as $key => $kick )
        {
        	if( $kick != 0 )
        	{
        		if( $enemy_blocks[1] == $kick || $enemy_blocks[2] == $kick ) $true_blocks[$key] = $kick;
        		else $true_kicks[$key] = $kick;
            }
        }

      */
      //print_r($my_kicks); echo '<br /><br /><br />';
     // print_r($enemy_blocks);  echo '<br /><br /><br />';
     // if( !empty($out['Slot_id'][9]) ) //если есть щит, то 2 блока отпизды
      //  $blocked = array_intersect_assoc( $my_kicks, $enemy_blocks ); //проверяем совпадение удар <=> блок
     // else
        $blocked = array_intersect( $my_kicks, $enemy_blocks );
      //print_r($blocked);     die;
      foreach( $my_kicks as $key => $kick )
      {
      	if( $kick != 0 )
      	{

      	      	$he_blocked = 0;

              	$armor1 = rand( round($enemy_modif['Armor1'] / 2), $enemy_modif['Armor1'] );
              	$armor2 = rand( round($enemy_modif['Armor2'] / 2), $enemy_modif['Armor2'] );
              	$armor3 = rand( round($enemy_modif['Armor3'] / 2), $enemy_modif['Armor3'] );
             	$armor4 = rand( round($enemy_modif['Armor4'] / 2), $enemy_modif['Armor4'] );

                $damage = mt_rand( $my_modif['min_damage'], $my_modif['max_damage'] );

                if( !empty($koef) ) $damage *= $koef;

             	if( $my_modif['uv'] != 0 ) $delta_uv = $enemy_modif['uv']/$my_modif['uv'];

              	if( $delta_uv > 2 ) $delta_uv = 2;
              	elseif( $delta_uv < 1 ) $delta_uv = 1;


              	if( $kick == 1 ) $damage -= $armor1;
              	elseif( $kick == 2 ) $damage -= $armor2;
              	elseif( $kick == 3 ) $damage -= $armor3;
              	elseif( $kick == 4 ) $damage -= $armor4;

              	if( $damage < 0 ) $damage = 0;

              	$delta_uv = $delta_uv*15 + 50;


              	$has_uv   = ( $his_uv > rand(1,100) ) && ( $delta_uv > rand(1,100) );
              	$hascrit  = ( $my_crit > rand(1,100) );

                $battle_log = new write_to_log($player->battle_id);

  				if( $abil_work == 1 )
  					include ( $db_config[DREAM]['web_root']. DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'battle2' . DIRECTORY_SEPARATOR . 'abils' . DIRECTORY_SEPARATOR . 'battle_abils_damage.php' );

              	if( !empty($blocked) && ($blocked[1] == $kick || $blocked[2] == $kick) )  //совпал ли удар с одним из блоков противника
              	{
        	      	$he_blocked = 1;
        	      	if( $hascrit )
        	      	{  //кританул ли я
        		      	$block_crit = 1;
        		      	$damage *= 0.5;
        		    }
                  	else
                    	$damage = 0;
              	}
              	else
              	{ // если удар не заблокирован
        	      	if( $hascrit ) //если я еще и кританул
        	      	{
        		      	$critanul = 1;
        		      	$damage *= 2;
                  	}


              	}

              	if( $has_uv )
              	{
        	      	$damage = 0;
        	      	$uvernulsa = 1;
              	}


                if( $damage > 0 && $abil_work == 1 )
                {
  					include ( $db_config[DREAM]['web_root']. DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'battle2' . DIRECTORY_SEPARATOR . 'abils' . DIRECTORY_SEPARATOR . 'battle_abils_otraz.php' );
  					include ( $db_config[DREAM]['web_root']. DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'battle2' . DIRECTORY_SEPARATOR . 'abils' . DIRECTORY_SEPARATOR . 'battle_abils_hp.php' );
                }


              	if( $enemy->is_dead != 1 )
              	{
        	      	$newhp = $enemy->hp - $damage;

                    if( $damage > 0 )
                  	{
                  		if( $newhp <= 0 )
                  		{
        	        	       	$set_dead = 1;
        	        	       	$enemy->set_hp(0);
        	        	       	$enemy->set_dead(1);
        	        	       	$player->add_hited($damage);

                                $win_team = completed_or_not_completed( $player->battle_id, $step );

                                $battle_log->add_log( get_date().'<strong>'.$enemy->slogin($enemy->Username, $enemy->Level, $enemy->id_clan, $enemy->team).' убит.</strong>', $step, 1 );

								switch( $win_team )
								{
									case 3: $battle_log->add_log( get_date().'<b>Ничья.</b>', $step+1 ); break;
									case 2: $battle_log->add_log( get_date().'<b>Команда <font color="#6666ff">синих</font> победила.</b>', $step+1 ); break;
									case 1: $battle_log->add_log( get_date().'<b>Команда <font color="#ff6666">красных</font> победила.</b>', $step+1 ); break;
    							}

                        }
                        else
                        {
        	         	      	$enemy->set_hp($newhp);
        	         	      	$player->add_hited($damage);
         	         	}
                  	}
                  	else
                  	{

                                $win_team = completed_or_not_completed( $player->battle_id, $step );

								switch( $win_team )
								{
									case 3: $battle_log->add_log( get_date().'<b>Ничья.</b>', $step+1 ); break;
									case 2: $battle_log->add_log( get_date().'<b>Команда <font color="#6666ff">синих</font> победила.</b>', $step+1 ); break;
									case 1: $battle_log->add_log( get_date().'<b>Команда <font color="#ff6666">красных</font> победила.</b>', $step+1 ); break;
    							}

                  	}



                 	//пишем лог
                 	$battle_log->make_log(
                 	$player->slogin($player->Username, $player->Level, $player->id_clan, $player->team),
                 	$enemy->slogin($enemy->Username, $enemy->Level, $enemy->id_clan, $enemy->team),
                 	$damage, $kick, $he_blocked, $critanul, $block_crit, $uvernulsa, $step, $newhp, $enemy->hp_all
                 	);


              	}

        }
      }

}

function completed_or_not_completed( $battle_id, $step )
{
	global $db;

    $win_team  = '';
	$cnt1 = $db->SQL_result($db->query( "SELECT COUNT(id) FROM ".SQL_PREFIX."2battle_action WHERE battle_id = '".$battle_id."' AND is_dead = '0' AND team = '1';" ),0,0);
	$cnt2 = $db->SQL_result($db->query( "SELECT COUNT(id) FROM ".SQL_PREFIX."2battle_action WHERE battle_id = '".$battle_id."' AND is_dead = '0' AND team = '2';" ),0,0);

	if( $cnt1 == 0 || $cnt2 == 0  ) $win_team = end_battle( $battle_id, $step+1 );

    return $win_team;
}


function end_battle($battle_id, $step)
{
	global $db, $db_config;

	 if( !is_numeric($battle_id) ) die;

	$t1_nondead = 0;
	$t2_nondead = 0;
    $winners = array();
    $win_team = 0;

	if( !$db->numrows( "SELECT 2ba.id FROM ".SQL_PREFIX."2battle_action as 2ba INNER JOIN ".SQL_PREFIX."2battle as 2b ON (2b.id = 2ba.battle_id) WHERE 2ba.battle_id = '".$battle_id."' AND 2b.status = 'during';" ) )
		return ;

	if( $db->numrows( "SELECT 2ba.id FROM ".SQL_PREFIX."2battle_action as 2ba INNER JOIN ".SQL_PREFIX."2battle as 2b ON (2b.id = 2ba.battle_id) WHERE 2ba.battle_id = '".$battle_id."' AND 2ba.team = '1' AND 2ba.is_dead = '0' AND 2b.status = 'during';" ) )
	   $t1_nondead = 1;

	if( $db->numrows( "SELECT 2ba.id FROM ".SQL_PREFIX."2battle_action as 2ba INNER JOIN ".SQL_PREFIX."2battle as 2b ON (2b.id = 2ba.battle_id) WHERE 2ba.battle_id = '".$battle_id."' AND 2ba.team = '2' AND 2ba.is_dead = '0' AND 2b.status = 'during';" ) )
	   $t2_nondead = 1;

    include ( $db_config[DREAM]['web_root']. DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'ChatSendMessages.php' );
    include ( $db_config[DREAM]['web_root']. DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'turnir' . DIRECTORY_SEPARATOR . 'func.php' );
    include ( $db_config[DREAM]['web_root']. DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR  . 'battle2' . DIRECTORY_SEPARATOR . 'turnir_lib.php');
    include ( $db_config[DREAM]['web_root']. DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR  . 'battle2' . DIRECTORY_SEPARATOR . 'battle_end.php');

   	$arr = $db->queryFetchArray("SELECT id FROM ".SQL_PREFIX."map WHERE acses <> '1'");

	if( $t1_nondead == 0 && $t2_nondead == 0 ) //ничья
	{
		$players = $db->queryArray( "SELECT Username FROM ".SQL_PREFIX."2battle_action WHERE battle_id = '".$battle_id."';" );
		//ищем всех юзеров, участвовавших в битве, если все мертвы.

		if( !empty($players) )
		{
			foreach($players as $user)
			{
				$player2 = new battle($user['Username']);
                updateThingsWear( $player2->Username, 20 );

				$give_exp = round( $player2->hited * getBattleExpNew( $user['Username'], $battle_id ) / 200 );  // exp, которое получает юзер за ничью

                $upd = Array( 'Expa' => '[+]'.$give_exp );

                	if( $player2->Reg_IP == 'бот' )
                	{
                		shuffle($arr);
                		$upd['map_id'] = $arr[0][0];
                		$upd['HPnow']  = $player2->hp_all;
                    }

				$db->update( SQL_PREFIX.'players', $upd, Array( 'Username' => $player2->Username, 'BattleID2' => $battle_id ), 'maths' );
				$txt = '<font color=red>Ничья.</font> Всего вами нанесено урона: <B>'.$player2->hited.'</B>. Получено опыта: <B>'.$give_exp.'</B>';
				$db->insert( SQL_PREFIX.'messages', Array( 'Username' => $player2->Username, 'Text' => $txt ) );

				turnir_draw_game($player2);
			}
        }


        $win_team = 3;

	}


	if( $t1_nondead == 1 && $t2_nondead == 0 && empty($winners) ) //команда 1 победила
	{
		$players = $db->queryArray( "SELECT p.Username, p.Level, p.ClanID, p.HPall, p.Reg_IP, 2ba.hited FROM ".SQL_PREFIX."2battle_action as 2ba INNER JOIN ".SQL_PREFIX."players as p ON ( p.Username = 2ba.Username ) WHERE 2ba.battle_id = '".$battle_id."' AND 2ba.team = '1';" );
		//ищем всех юзеров, участвовавших в битве в первой команде

		if( !empty($players) )
		{
			foreach($players as $user)
			{
				$give_exp = round( $user['hited'] * getBattleExpNew( $user['Username'], $battle_id ) / 100 );  // exp, которое получает юзер за победу
                updateThingsWear( $user['Username'], 5 );

                $upd = Array( 'Expa' => '[+]'.$give_exp, 'Won' => '[+]1' );

                	if( $user['Reg_IP'] == 'бот' )
                	{
                		shuffle($arr);
                		$upd['map_id'] = $arr[0][0];
                		$upd['HPnow']  = $user['HPall'];
                    }

                $winners[] = $user['Username'];

				$db->update( SQL_PREFIX.'players', $upd, Array( 'Username' => $user['Username'], 'BattleID2' => $battle_id ), 'maths' );
				$txt = '<font color=red>Победа.</font> Всего вами нанесено урона: <B>'.$user['hited'].'</B>. Получено опыта: <B>'.$give_exp.'</B>';
				$db->insert( SQL_PREFIX.'messages', Array( 'Username' => $user['Username'], 'Text' => $txt ) );
				turnir_win($user, $battle_id);
			}
        }


		$players = $db->queryArray( "SELECT Username FROM ".SQL_PREFIX."2battle_action WHERE battle_id = '".$battle_id."' AND team = '2';" );
		//ищем всех юзеров, участвовавших в битве во второй команде

		if( !empty($players) )
		{
			foreach($players as $user)
			{
				$player2 = new battle($user['Username']);
                updateThingsWear( $player2->Username, 90 );

				$give_exp = 1;  // exp, которое получает юзер за поражение

                $upd = Array( 'Expa' => '[+]'.$give_exp, 'Lost' => '[+]1' );

                	if( $player2->Reg_IP == 'бот' )
                	{
                		shuffle($arr);
                		$upd['map_id'] = $arr[0][0];
                		$upd['HPnow']  = $player2->hp_all;
                    }


				$db->update( SQL_PREFIX.'players', $upd, Array( 'Username' => $player2->Username, 'BattleID2' => $battle_id ), 'maths' );
				$txt = '<font color=red>Поражение.</font> Всего вами нанесено урона: <B>'.$player2->hited.'</B>. Получено опыта: <B>'.$give_exp.'</B>';
				$db->insert( SQL_PREFIX.'messages', Array( 'Username' => $player2->Username, 'Text' => $txt ) );

				turnir_lose($player2);
			}
        }



        $win_team = 1;

	}


	if( $t1_nondead == 0 && $t2_nondead == 1 && empty($winners) ) //команда 2 победила
	{
		$players = $db->queryArray( "SELECT p.Username, p.Level, p.ClanID, p.HPall, p.Reg_IP, 2ba.hited FROM ".SQL_PREFIX."2battle_action as 2ba INNER JOIN ".SQL_PREFIX."players as p ON ( p.Username = 2ba.Username ) WHERE 2ba.battle_id = '".$battle_id."' AND 2ba.team = '2';" );
		//ищем всех юзеров, участвовавших в битве во второй команде

		if( !empty($players) )
		{
			foreach($players as $user)
			{
				$give_exp = round( $user['hited'] * getBattleExpNew( $user['Username'], $battle_id ) / 100 );  // exp, которое получает юзер за победу
                updateThingsWear( $user['Username'], 90 );

                $upd = Array( 'Expa' => '[+]'.$give_exp, 'Won' => '[+]1' );

                	if( $user['Reg_IP'] == 'бот' )
                	{
                		shuffle($arr);
                		$upd['map_id'] = $arr[0][0];
                	    $upd['HPnow']  = $user['HPall'];
                    }

                $winners[] = $user['Username'];

				$db->update( SQL_PREFIX.'players', $upd, Array( 'Username' => $user['Username'], 'BattleID2' => $battle_id ), 'maths' );
				$txt = '<font color=red>Победа.</font> Всего вами нанесено урона: <B>'.$user['hited'].'</B>. Получено опыта: <B>'.$give_exp.'</B>';
				$db->insert( SQL_PREFIX.'messages', Array( 'Username' => $user['Username'], 'Text' => $txt ) );
				turnir_win($user, $battle_id);
			}
        }


		$players = $db->queryArray( "SELECT Username FROM ".SQL_PREFIX."2battle_action WHERE battle_id = '".$battle_id."' AND team = '1';" );
		//ищем всех юзеров, участвовавших в битве во второй команде

		if( !empty($players) )
		{
			foreach($players as $user)
			{
				$player2 = new battle($user['Username']);
                updateThingsWear( $player2->Username, 90 );

				$give_exp = 1;  // exp, которое получает юзер за поражение

                $upd = Array( 'Expa' => '[+]'.$give_exp, 'Lost' => '[+]1' );

                	if( $player2->Reg_IP == 'бот' )
                	{
                		shuffle($arr);
                		$upd['map_id'] = $arr[0][0];
                		$upd['HPnow']  = $player2->hp_all;
                    }

				$db->update( SQL_PREFIX.'players', $upd, Array( 'Username' => $player2->Username, 'BattleID2' => $battle_id ), 'maths' );
				$txt = '<font color=red>Поражение.</font> Всего вами нанесено урона: <B>'.$player2->hited.'</B>. Получено опыта: <B>'.$give_exp.'</B>';
				$db->insert( SQL_PREFIX.'messages', Array( 'Username' => $player2->Username, 'Text' => $txt ) );

				turnir_lose($player2);
			}

        }


        $win_team = 2;

	}

        $db->update( SQL_PREFIX.'2battle', Array( 'status' => 'completed', 'win_team' => implode( ';', $winners ) ), Array( 'id' => $battle_id ) );
        $db->execQuery( "DELETE FROM ".SQL_PREFIX."demands_2b WHERE battle_id = '".$battle_id."';" );
        $db->execQUery ( "DELETE FROM ".SQL_PREFIX."2battle_kicks WHERE battle_id = '".$battle_id."';" );


       return $win_team;
}
?>
