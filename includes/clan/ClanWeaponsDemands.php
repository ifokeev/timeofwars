<?
	if( !empty($_POST['item']) && is_numeric($_POST['item']) )
	{
		$demand	= new ClanWeaponDemands( intval($_POST['item']) );
		$items  = new ClanWeaponItems( $player->id_clan );
		$isitem = $items->getItem($demand->id_item);

    }

	if( !empty($_POST['act']) && $_POST['act'] == 'add' )
	{
		if( !empty($_SESSION['lastacttime']) &&  time() - $_SESSION['lastacttime'] <= 5 ){ echo '������� ����� ��������� ��� � 5 ������'; }
		elseif( empty($isitem) ){ echo '����� ���� �� ����������'; }
		elseif( $demand->getItemDemandByUsername( $player->username ) ){ echo '�� ��� ������ ������ �� ��� ����'; }
		else
		{
			$demand->addItemDemand( $player->username );
			echo '������ ���������';
			$_SESSION['lastacttime'] = time();

		}

	}
	elseif( $_POST['act'] == 'del' )
	{
		if( !empty($_SESSION['lastacttime']) &&  time() - $_SESSION['lastacttime'] <= 5 ){ echo '������� ����� ��������� ��� � 5 ������'; }
		elseif( empty($isitem) ){ echo '����� ���� �� ����������'; }
		elseif( !$demand->getItemDemandByUsername( $player->username ) ){ echo '�� �� �������� ������ �� ��� ����'; }
		else
		{
			$demand->delItemDemand( $player->username );
			echo '������ �������';
			$_SESSION['lastacttime'] = time();

		}
	}
	elseif( $_POST['act'] == 'get_item' )
	{
		if( empty($isitem) ){ echo '����� ���� �� ����������'; }
		elseif( !$get_item = $demand->getItemDemandByUsername( $player->username ) ){ echo '�� �� �������� ������ �� ��� ����'; }
		elseif( $get_item['status'] != 'ACCEPT' ){ echo '���� ������ ���������.'; }
		else
		{
			$items->setItemOwner( $demand->id_item, $player->username );
			$db->update( SQL_PREFIX.'clan_weapon_items', Array( 'timeINuse' => time() ), Array( 'id_item' => $demand->id_item ) );
			echo '���� ��������� � ���������';


		}

	}
	elseif( $_POST['act'] == 'accept_demand' )
	{
		if( empty($isitem) ){ echo '����� ���� �� ����������'; }
		elseif( !$get_item = $demand->getItemDemandByUsername( $uname ) ){ echo '������ �� ����������'; }
		elseif( $get_item['status'] == 'ACCEPT' ){ echo '������ ��� ������������.'; }
		elseif( $get_item['status'] == 'REJECT' ){ echo '������ ��� ���������.'; }
		elseif( $db->SQL_result($db->query( "SELECT ClanID FROM ".SQL_PREFIX."players WHERE Username = '".$uname."';")) != $player->id_clan ){ echo '� ����� ����� ��� ������ ���������'; }
		else
		{
			$demand->setItemDemand( $uname, 'ACCEPT' );
			echo '������ ������������';

		}

	}
	elseif( $_POST['act'] == 'reject_demand' )
	{
		if( empty($isitem) ){ echo '����� ���� �� ����������'; }
		elseif( !$get_item = $demand->getItemDemandByUsername( $uname ) ){ echo '������ �� ����������'; }
		elseif( $get_item['status'] == 'ACCEPT' ){ echo '������ ��� ������������.'; }
		elseif( $get_item['status'] == 'REJECT' ){ echo '������ ��� ���������.'; }
		elseif( $db->SQL_result($db->query( "SELECT ClanID FROM ".SQL_PREFIX."players WHERE Username = '".$uname."';")) != $player->id_clan ){ echo '� ����� ����� ��� ������ ���������'; }
		else
		{
			$demand->setItemDemand( $uname, 'REJECT' );
			echo '������ �����������';

		}

	}
?>