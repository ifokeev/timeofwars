<?
	if( !empty($_POST['act']) && $_POST['act'] == 'addmoney' )
	{
		if( empty($_POST['money']) || !is_numeric($_POST['money']) || $_POST['money'] <= 0 ){ echo 'err'; }
		elseif( $_POST['money'] > $player->Money ){ echo 'err'; }
		else
		{
			$money = floor($_POST['money']);

			$db->update( SQL_PREFIX.'players', Array( 'Money' => '[-]'.$money ), Array( 'Username' => $player->username ), 'maths' );
			$db->update( SQL_PREFIX.'clan', Array( 'kazna' => '[+]'.$money ), Array( 'id_clan' => $player->id_clan ), 'maths' );
            $db->insert( SQL_PREFIX.'clan_history', Array( 'id_clan' => $player->id_clan, 'time' => time(), 'type' => 'kazna', 'text' => '<b>'.$player->username.'</b> добавил '.$money.' кр в казну.' ) );

			echo $db->SQL_result($db->query("SELECT kazna FROM ".SQL_PREFIX."clan WHERE id_clan = '".$player->id_clan."';"));
        }


	}
	elseif( $_POST['act'] == 'add_demand' )
	{
		if( empty($_POST['money']) || !is_numeric($_POST['money']) || $_POST['money'] <= 0 ){ echo 'Некорректная сумма'; }
		elseif( $_POST['money'] > $db->SQL_result($db->query( "SELECT kazna FROM ".SQL_PREFIX."clan WHERE id_clan = '".$player->id_clan."';" )) ){ echo 'В казне нет столько денег'; }
		else
		{
			$money = floor($_POST['money']);
		    $query = sprintf("INSERT INTO ".SQL_PREFIX."clan_demands_m ( Username, addtime, id_clan, howmuch ) VALUES ( '%s', '%s', '%d', '%d' ) ON DUPLICATE KEY UPDATE addtime = '%s', howmuch = '%d';", $player->username, date('d.m.Y'), $player->id_clan, $money, date('d.m.Y'), $money );
		    $db->execQuery($query);

		    echo '<b>Заявка добавлена. Вы получите сумму, если казначей подтвердит ее.</b>';

		}

	}
	elseif( $_POST['act'] == 'give_money' )
	{
		if( empty($uname) ){ die; }
		elseif( $uname == $player->username ){ echo 'err2'; }
		else
		{
			$money = $db->SQL_result($db->query( "SELECT howmuch FROM ".SQL_PREFIX."clan_demands_m WHERE Username = '".$uname."' AND id_clan = '".$player->id_clan."';" ));
			if( !empty($money) )
			{
				if( $money <= $db->SQL_result($db->query( "SELECT kazna FROM ".SQL_PREFIX."clan WHERE id_clan = '".$player->id_clan."';" )) )
				{
				$db->update( SQL_PREFIX.'players', Array( 'Money' => '[+]'.$money ), Array( 'Username' => $uname ), 'maths' );
				$db->execQuery( "DELETE FROM ".SQL_PREFIX."clan_demands_m WHERE Username = '".$uname."' AND id_clan = '".$player->id_clan."';" );
				$db->update( SQL_PREFIX.'clan', Array( 'kazna' => '[-]'.$money ), Array( 'id_clan' => $player->id_clan ), 'maths' );
                $db->insert( SQL_PREFIX.'clan_history', Array( 'id_clan' => $player->id_clan, 'time' => time(), 'type' => 'kazna', 'text' => '<b>'.$player->username.'</b> выдал '.$money.' кр. персонажу <b>'.$uname.'</b>' ) );

				echo $db->SQL_result($db->query("SELECT kazna FROM ".SQL_PREFIX."clan WHERE id_clan = '".$player->id_clan."';"));
				}
				else
				{
					echo 'err';
				}
	        }

		}

	}
	elseif( $_POST['act'] == 'del_demand' )
	{
		$db->execQuery( "DELETE FROM ".SQL_PREFIX."clan_demands_m WHERE Username = '".$uname."' AND id_clan = '".$player->id_clan."';" );
		echo 'Удалено';

	}

?>