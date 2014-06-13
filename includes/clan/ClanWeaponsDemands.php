<?
	if( !empty($_POST['item']) && is_numeric($_POST['item']) )
	{
		$demand	= new ClanWeaponDemands( intval($_POST['item']) );
		$items  = new ClanWeaponItems( $player->id_clan );
		$isitem = $items->getItem($demand->id_item);

    }

	if( !empty($_POST['act']) && $_POST['act'] == 'add' )
	{
		if( !empty($_SESSION['lastacttime']) &&  time() - $_SESSION['lastacttime'] <= 5 ){ echo 'Запросы можно выполнять раз в 5 секунд'; }
		elseif( empty($isitem) ){ echo 'Такой вещи не существует'; }
		elseif( $demand->getItemDemandByUsername( $player->username ) ){ echo 'Вы уже подали заявку на эту вещь'; }
		else
		{
			$demand->addItemDemand( $player->username );
			echo 'Заявка добавлена';
			$_SESSION['lastacttime'] = time();

		}

	}
	elseif( $_POST['act'] == 'del' )
	{
		if( !empty($_SESSION['lastacttime']) &&  time() - $_SESSION['lastacttime'] <= 5 ){ echo 'Запросы можно выполнять раз в 5 секунд'; }
		elseif( empty($isitem) ){ echo 'Такой вещи не существует'; }
		elseif( !$demand->getItemDemandByUsername( $player->username ) ){ echo 'Вы не подавали заявку на эту вещь'; }
		else
		{
			$demand->delItemDemand( $player->username );
			echo 'Заявка удалена';
			$_SESSION['lastacttime'] = time();

		}
	}
	elseif( $_POST['act'] == 'get_item' )
	{
		if( empty($isitem) ){ echo 'Такой вещи не существует'; }
		elseif( !$get_item = $demand->getItemDemandByUsername( $player->username ) ){ echo 'Вы не подавали заявку на эту вещь'; }
		elseif( $get_item['status'] != 'ACCEPT' ){ echo 'Ваша заявка отклонена.'; }
		else
		{
			$items->setItemOwner( $demand->id_item, $player->username );
			$db->update( SQL_PREFIX.'clan_weapon_items', Array( 'timeINuse' => time() ), Array( 'id_item' => $demand->id_item ) );
			echo 'Вещь добавлена в инвентарь';


		}

	}
	elseif( $_POST['act'] == 'accept_demand' )
	{
		if( empty($isitem) ){ echo 'Такой вещи не существует'; }
		elseif( !$get_item = $demand->getItemDemandByUsername( $uname ) ){ echo 'Заявки не обнаружено'; }
		elseif( $get_item['status'] == 'ACCEPT' ){ echo 'Заявка уже подтверждена.'; }
		elseif( $get_item['status'] == 'REJECT' ){ echo 'Заявка уже отклонена.'; }
		elseif( $db->SQL_result($db->query( "SELECT ClanID FROM ".SQL_PREFIX."players WHERE Username = '".$uname."';")) != $player->id_clan ){ echo 'В вашем клане нет такого персонажа'; }
		else
		{
			$demand->setItemDemand( $uname, 'ACCEPT' );
			echo 'Заявка подтверждена';

		}

	}
	elseif( $_POST['act'] == 'reject_demand' )
	{
		if( empty($isitem) ){ echo 'Такой вещи не существует'; }
		elseif( !$get_item = $demand->getItemDemandByUsername( $uname ) ){ echo 'Заявки не обнаружено'; }
		elseif( $get_item['status'] == 'ACCEPT' ){ echo 'Заявка уже подтверждена.'; }
		elseif( $get_item['status'] == 'REJECT' ){ echo 'Заявка уже отклонена.'; }
		elseif( $db->SQL_result($db->query( "SELECT ClanID FROM ".SQL_PREFIX."players WHERE Username = '".$uname."';")) != $player->id_clan ){ echo 'В вашем клане нет такого персонажа'; }
		else
		{
			$demand->setItemDemand( $uname, 'REJECT' );
			echo 'Заявка анулирована';

		}

	}
?>