<?

	$demands = new ClanDemands( $player->id_clan );

	if( list($uClanID, $id_clan, $j_price) = $demands->getClanDemandsByUsername( $uname ) )
	{
		if( !empty($_POST['act']) && $_POST['act'] == 'add' )
		{
            if( empty($uClanID) ){

			if( $player->Money >= $j_price ){
			$demands->acceptClanDemandByUsername($uname);
			$demands->delClanDemandByUsername($uname, $id_clan);
			$db->update( SQL_PREFIX.'players', Array( 'Money' => '[-]'.$j_price, 'ClanID' => $id_clan ), Array( 'Username' => $player->username ), 'maths' );
			$db->update( SQL_PREFIX.'players', Array( 'ClanID' => $id_clan ), Array( 'Username' => $uname ) );
		    $db->insert( SQL_PREFIX.'clan_history', Array( 'id_clan' => $player->id_clan, 'time' => time(), 'type' => 'members', 'text' => '<b>'.$player->username.'</b> ������ � ���� ��������� <b>'.$uname.'</b>' ) );

			$err = '<font color="red">��������� �������� ����� ����</font>';
			}
			else
			{
				$err = '<font color="green">������������ �����</font>';
	        }

	        }
	        else
	        {
	        	$err = '<font color="green">�������� ��� � �����. ����� <a href="#" onclick="$.post(\'ajax/cl.php\', { page: \'request\', act: \'del\', uname: \''.$uname.'\' }, function(data){ add_msg(data, \'#id'.$uname.'\' ); } );">�������</a></font>';
	        }



		}
		elseif( $_POST['act'] == 'del' )
		{
			$demands->delClanDemandByUsername( $uname );
		}
    }
?>
