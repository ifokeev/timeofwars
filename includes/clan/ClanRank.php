<?
	if( !empty($_POST['act']) && $_POST['act'] == 'update' )
	{

		if( empty($_POST['result']) ) $row = '';
		elseif( count($_POST['result']) == 1 ) $row = $_POST['result'][0];
		else $row = implode( ',', $_POST['result'] );


        if( empty($_POST['rank']) || !is_numeric($_POST['rank']) || preg_match('/[^a-z\,]/i', $row) ) die;

        $db->update( SQL_PREFIX.'clan_ranks', Array( 'perms' => $row ), Array( 'id_rank' => intval($_POST['rank']) ) );

        $err = '<font color="red">Ранг "'.$db->SQL_result($db->query("SELECT rank_name FROM ".SQL_PREFIX."clan_ranks WHERE id_rank = '".intval($_POST['rank'])."';")).'" обновлен</font>';

    }
    elseif( $_POST['act'] == 'del' )
    {
    	if( !is_numeric($_POST['rank']) )die;

        if( !empty($_SESSION['lastacttime']) &&  time() - $_SESSION['lastacttime'] <= 10 ){ echo 'time'; }
        else{
    	$db->execQuery( "DELETE FROM ".SQL_PREFIX."clan_ranks WHERE id_rank = '".intval($_POST['rank'])."';" );
    	$_SESSION['lastacttime'] = time();
    	}

    }
    elseif( $_POST['act'] == 'new' )
    {
    	$rank = iconv('UTF-8', 'windows-1251', $_POST['rank']);

        $rank = trim($rank);
        if( !empty($_SESSION['lastacttime']) && time() - $_SESSION['lastacttime'] <= 10 ){ echo 'time'; }
    	elseif( empty($rank) || strlen($rank) <= 3 || strlen($rank) > 13 || trim(strtolower($rank)) == 'глава' || preg_match( "/[^a-zA-Zа-яА-Я0-9 -]/i", $rank ) ){ echo 'err';  }
    	else{

    	$db->insert( SQL_PREFIX.'clan_ranks', Array( 'id_clan' => $player->id_clan, 'rank_name' => $rank ) );
    	$_SESSION['lastacttime'] = time();
    	echo $db->insertId();

    	}

    }

?>
