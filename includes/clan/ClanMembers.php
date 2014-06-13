<?
	if( !empty($_POST['act']) && $_POST['act'] == 'update' )
	{
		if( !is_numeric($_POST['rank']) || empty($uname) ) die;
		else
		{
			if( $_POST['rank'] == 0 )
			{
				$db->update( SQL_PREFIX.'clan_user', Array( 'id_rank' => 0 ), Array( 'Username' => $uname, 'id_clan' => $player->id_clan ) );
				$db->insert( SQL_PREFIX.'messages', Array( 'Username' => mysql_escape_string($uname), 'text' => mysql_escape_string('Вы понижены в ранге') ) );
	        }
	        else
	        {
	        	$db->insert( SQL_PREFIX.'messages', Array( 'Username' => mysql_escape_string($uname), 'text' => mysql_escape_string('Вам назначен новый ранг') ) );
	        	$db->update( SQL_PREFIX.'clan_user', Array( 'id_rank' => intval($_POST['rank']) ), Array( 'Username' => $uname, 'id_clan' => $player->id_clan ) );
	        }

	        echo '<font color="red">обновлено</font>';


		}

	}
	elseif( $_POST['act'] == 'update_tax' )
	{		if( $_POST['tax'] == '' || !is_numeric($_POST['tax']) || $_POST['tax'] < 0 || $_POST['tax'] > 50 || empty($uname) ) die;
	    elseif( !empty($_SESSION['lastacttime']) &&  time() - $_SESSION['lastacttime'] <= 5 ) echo 'time';
		else
		{		    $db->insert( SQL_PREFIX.'clan_history', Array( 'id_clan' => $player->id_clan, 'time' => time(), 'type' => 'kazna', 'text' => '<b>'.$player->username.'</b> поставил налог в '.$_POST['tax'].'% для <b>'.$uname.'</b>' ) );
			$db->update( SQL_PREFIX.'clan_user', Array( 'tax' => $_POST['tax'] ), Array( 'Username' => $uname ) );			$txt = '<b>Клановое сообщение от '.$player->username.'</b>: Вам назначен новый налог с уровня в '.$_POST['tax'].'%';
        	$db->insert( SQL_PREFIX.'messages', Array( 'Username' => mysql_escape_string($uname), 'text' => mysql_escape_string($txt) ) );
        	$_SESSION['lastacttime'] = time();
        	echo 'Налог обновлен';
        }
	}
	elseif( $_POST['act'] == 'del' )
	{
		if( !is_numeric($_POST['left']) || empty($uname) ){ die; }
		elseif( $player->Money < $_POST['left'] ){ echo '<font color="red">Недостаточно денег. Требуется '.$_POST['left'].' кр.</font>'; }
		elseif( $db->queryRow( "SELECT admin FROM ".SQL_PREFIX."clan_user WHERE Username = '".$uname."' AND admin = '1';" ) ){ echo '<font color="red">Нельзя выгнать главу</font>'; }
		else
		{

			if( $db->execQuery( "DELETE FROM ".SQL_PREFIX."clan_user WHERE Username = '".$uname."' AND id_clan = '".$player->id_clan."';" ) )
			{				$db->insert( SQL_PREFIX.'clan_history', Array( 'id_clan' => $player->id_clan, 'time' => time(), 'type' => 'members', 'text' => '<b>'.$player->username.'</b> выгнал из клана персонажа <b>'.$uname.'</b>' ) );

				$db->update( SQL_PREFIX.'players', Array( 'Money' => '[-]'.floor($_POST['left']), 'ClanID' => 0 ), Array( 'Username' => $uname, 'ClanID' => $player->id_clan ), 'maths' );
				$db->execQuery( "DELETE FROM ".SQL_PREFIX."clan_goout WHERE Username = '".$uname."' AND id_clan = '".$player->id_clan."';" );
				echo '<font color="red">'.$uname.' исключен из клана</font>';
	        }

		}

	}
	elseif( $_POST['act'] == 'delgo' )
	{
		if( $db->execQuery( "DELETE FROM ".SQL_PREFIX."clan_goout WHERE Username = '".$uname."' AND id_clan = '".$player->id_clan."';" ) )
		{
			echo 'Заявка '.$uname.' на выход из клана удалена';
        }

	}
	elseif( $_POST['act'] == 'addgo' )
	{
		    $query = sprintf("INSERT INTO ".SQL_PREFIX."clan_goout ( Username, addtime, id_clan ) VALUES ( '%s', '%s', '%d' ) ON DUPLICATE KEY UPDATE addtime = '%s';", mysql_escape_string($uname), date('d.m.Y'), $player->id_clan, date('d.m.Y') );
		    $db->execQuery($query);
		    echo 'Заявка '.$uname.' на выход из клана добавлена';

	}
	elseif( $_POST['act'] == 'clanmsg' )
	{

		$msg = iconv('UTF-8', 'windows-1251', $_POST['msg']);



		function okon4 ($number, $titles)
		{
			$cases = array (2, 0, 1, 1, 1, 2);
			return $number.' '.$titles[ ($number%100>4 && $number%100<20)? 2 : $cases[min($number%10, 5)] ];
		}

		//if( empty($uname) ) die;


		if( $_POST['uname'][0] == 'all' )
		{
			$count = $db->SQL_result($db->query( "SELECT COUNT(*) FROM ".SQL_PREFIX."clan_user WHERE id_clan = '".$player->id_clan."';" ));
			$sms = $count*0.1;
			if( $player->Money < $sms ){ echo '<font color="red">Недостаточно денег. Требуется еще '.($sms - $player->Money).' кр.</font>'; }
			else{

			$msg = '<b>Клановое сообщение от '.$player->username.'</b>: '.$msg;
			$query = sprintf("INSERT INTO ".SQL_PREFIX."messages ( `Username`, `text` ) SELECT Username, '%s' FROM ".SQL_PREFIX."clan_user WHERE id_clan = '%d';", mysql_escape_string($msg), $player->id_clan );
			$db->execQuery( $query, "OldMessages_sendClanMessagesByIdClan_1" );

			$db->update( SQL_PREFIX.'players', Array( 'Money' => '[-]'.$sms ), Array( 'Username' => $player->username ), 'maths' );
			echo '<font color="red">Отправлено '.okon4($count, array('сообщение', 'сообщения', 'сообщений')).'</font>';
			}
        }
        else
        {
        	$sms = count($_POST['uname'])*0.1;
        	if( $player->Money < $sms ){ echo '<font color="red">Недостаточно денег. Требуется еще '.($sms - $player->Money).' кр.</font>'; }
        	else{

            $i = 0;

            if( !empty($_POST['uname'][0]) ){
            $users = split( ',', $_POST['uname'][0] );
        	foreach( $users as $user )
        	{
        		$user = iconv('UTF-8', 'windows-1251', $user);
        		if( !empty($user) ){
        		$txt = '<b>Клановое сообщение от '.$player->username.'</b>: '.$msg;
        		$db->insert( SQL_PREFIX.'messages', Array( 'Username' => mysql_escape_string($user), 'text' => mysql_escape_string($txt) ) );
        		$i++;
        		}

        	}

        	if( $i != 0 ){ echo '<font color="red">Отправлено '.okon4($i, array('сообщение', 'сообщения', 'сообщений')).'</font>'; }
        	else{ echo '<font color="red">Выбирите получателей</font>'; }

        	}

        	}


        }


	}
?>
