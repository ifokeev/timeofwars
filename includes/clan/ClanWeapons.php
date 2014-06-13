<?
    $items = new ClanWeaponItems( $player->id_clan );
    //print_r($items);
	if( !empty($_POST['act']) && $_POST['act'] == 'dataload' )
	{
		$bgcolor = '#D4D2D2';

		if( @$_POST['slot'] == '' )
		{
			$data = $items->getItemsAll();
        }
        elseif( is_numeric($_POST['slot']) )
        {
        	$data = $items->getItemsAll( $_POST['slot'] );
        }
        else
        {
        	die;
        }


			if( !empty($data) ){
			?>
			<table width="100%" border="0" cellpadding="2" cellspacing="2" align="left" valign="bottom">
			<?
            foreach($data as $weap){
            if ($bgcolor == '#D4D2D2'): $bgcolor = '#E2E0E0'; elseif($bgcolor == '#E2E0E0'): $bgcolor = '#D4D2D2'; endif;
            $isdemand = $db->queryRow("SELECT Username, status FROM ".SQL_PREFIX."clan_weapon_demands WHERE id_item = '".$weap['id_item']."' AND Username = '".$player->username."';" );
			//$slot = $db->SQL_result($db->query( "SELECT Slot FROM ".SQL_PREFIX."clan_weapon_items cwi INNER JOIN `".SQL_PREFIX."things` t ON(t.Un_Id=cwi.id_item) LEFT JOIN ".SQL_PREFIX."clan_weapon_demands cwd ON(cwd.id_item=cwi.id_item) WHERE cwi.id_clan = '".$player->id_clan."';" ));
			@$slot = $_POST['slot'];
			?>
			 <tr bgcolor="<?=$bgcolor;?>" id="id<?=$weap['id_item'];?>">
			  <td><a href="thing.php?thing=<?=$weap['id_item'];?>" target="_blank"><?=$weap['Thing_Name'];?></a></td>
			  <td>Цена за неделю: <?=$weap['cost'];?> кр.</td>
			  <td><? if( empty($isdemand) ): ?> <? if( $weap['location'] == 'STORE' ): ?> <a href="#" onclick="$.post('ajax/cl.php', { page: 'weapons_demands', act: 'add', item: '<?=$weap['id_item'];?>' }, function(data){ jAlert(data, 'Сообщение'); update('<?=$slot;?>'); } );">Хочу!</a> <? endif; else: if( $weap['location'] == 'STORE' ):  ?> <a href="#" onclick="$.post('ajax/cl.php', { page: 'weapons_demands', act: 'del', item: '<?=$weap['id_item'];?>' }, function(data){ jAlert(data, 'Сообщение'); update('<?=$slot;?>'); } );">[ Удалить ]</a> <? else: echo 'Нельзя'; endif; endif;?> </td>
			  <td>Статус: <?=$weap['location'] == 'STORE' ? 'В оружейке' : 'На руках'; ?></td>

	          <? if( ((!empty($acclev) && in_array( 'weapon', $acclev )) || $player->admin == 1 ) && empty($isdemand) && $weap['location'] == 'STORE' ): ?>
	          <td> <a href="#" onclick="jPrompt('Новая цена:', 'за неделю', 'Админка оружейника', function(cost) { if( cost ) $.post('ajax/cl.php', { page: 'weapons', act: 'new_cost', item: '<?=$weap['id_item'];?>', cost: cost }, function(data){ jAlert(data, 'Сообщение'); update('<?=$slot;?>'); } ); });">$</a> </td>
	          <td> <input type="button" value=" X "  onclick="jConfirm('Вы точно хотите удалить вещь из оружейки?', 'Админка оружейника', function(ok) { if( ok ) $.post('ajax/cl.php', { page: 'weapons', act: 'del_weapon', item: '<?=$weap['id_item'];?>' }, function(data){ jAlert(data, 'Сообщение'); $('#id<?=$weap['id_item'];?>').empty(); } ); });"> </td>

	          <? endif; ?>
	         </tr>
			<?
			}
			?>
			</table>
			<?
			} else {
				echo 'П У С Т О';
	        }

	}
	elseif( $_POST['act'] == 'new_cost' )
	{
		if( !empty($_SESSION['lastacttime']) &&  time() - $_SESSION['lastacttime'] <= 5 ){ echo 'Запросы можно выполнять раз в 5 секунд'; }
		elseif( empty($_POST['cost']) || $_POST['cost'] <= 0 || !is_numeric($_POST['cost']) ){ echo 'Неправильная сумма'; }
		elseif( empty($_POST['item']) || !is_numeric($_POST['item']) || $_POST['item'] < 0 ){ echo 'Какая-то хуйня...'; }
		elseif( !$item = $items->getItem($_POST['item']) ){ echo 'Такой вещи не найдено'; }
		else
		{
			$db->update( SQL_PREFIX.'clan_weapon_items', Array( 'cost' => floatval($_POST['cost']) ), Array( 'id_item' => $item['id_item'] ) );
			$db->insert( SQL_PREFIX.'clan_history', Array( 'id_clan' => $player->id_clan, 'time' => time(), 'type' => 'weapons', 'text' => '<b>'.$player->username.'</b> <i>обновил</i> цену вещи <a href="thing.php?thing='.$item['id_item'].'" target="_blank">'.$item['id_item'].'</a> на '.floatval($_POST['cost']).' кр.' ) );
			$_SESSION['lastacttime'] = time();
			echo 'Цена обновлена';

		}

	}
	elseif( $_POST['act'] == 'del_weapon' )
	{
		if( !is_numeric($_POST['item']) || $_POST['item'] <= 0 ){ echo 'Что-то тут не так'; }
		elseif( !$items->getItem($_POST['item']) ){ echo 'Такой вещи не найдено'; }
		else
		{
			$items->delClanWeaponItem( intval($_POST['item']), $player->username );
			$db->insert( SQL_PREFIX.'clan_history', Array( 'id_clan' => $player->id_clan, 'time' => time(), 'type' => 'weapons', 'text' => '<b>'.$player->username.'</b> <font color="blue"><b>забрал</b></font> вещь <a href="thing.php?thing='.intval($_POST['item']).'" target="_blank">'.intval($_POST['item']).'</a> из оружейки' ) );
			echo 'Вещь удалена из оружейки и помещена к вам в инвентарь';

		}

	}
	elseif( $_POST['act'] == 'mythings' )
	{
		$bgcolor = '#D4D2D2';
		$data = $items->getUserBackpackItemList($player->username);


			if( !empty($data) ){            ?>
            <table width="100%" border="0" cellpadding="2" cellspacing="2" align="left" valign="bottom">
            <?
            foreach($data as $weap){
            if ($bgcolor == '#D4D2D2'): $bgcolor = '#E2E0E0'; elseif($bgcolor == '#E2E0E0'): $bgcolor = '#D4D2D2'; endif;
            $cost = sprintf ( "%.2f", $weap['cost'] * ( (time() - $weap['timeINuse']) / 604800  ) );
            ?>
			 <tr bgcolor="<?=$bgcolor;?>" id="id<?=$weap['id_item'];?>">
			  <td><a href="thing.php?thing=<?=$weap['id_item'];?>" target="_blank"><?=$weap['Thing_Name'];?></a></td>
			  <td>Вы должны: <?=$cost;?> кр.</td>
			  <td> <input type="button" value="Вернуть" onclick="$.post('ajax/cl.php', { page: 'weapons', act: 'return_things', item: '<?=$weap['id_item'];?>' }, function(data){ jAlert(data, 'Сообщение'); $('#id<?=$weap['id_item'];?>').empty(); } );" /> </td>
	         </tr>
			<?
			}
			?>
			</table>
			<?
			} else {
				echo 'П У С Т О';
	        }

	}
	elseif( $_POST['act'] == 'izyat' )
	{
		$bgcolor = '#D4D2D2';
		$data = $items->getClanWeaponItemList();


			if( !empty($data) ){
			?>
			<table width="100%" border="0" cellpadding="2" cellspacing="2" align="left" valign="bottom">
			<?
            foreach($data as $weap){
            if ($bgcolor == '#D4D2D2'): $bgcolor = '#E2E0E0'; elseif($bgcolor == '#E2E0E0'): $bgcolor = '#D4D2D2'; endif;
            if( !$user = $db->queryRow( "SELECT Username, Level, ClanID FROM ".SQL_PREFIX."players WHERE Username = '".$weap['Owner']."';" ) ) die;

            $cost = sprintf ( "%.2f", $weap['cost'] * ( (time() - $weap['timeINuse']) / 604800  ) );
            ?>
			 <tr bgcolor="<?=$bgcolor;?>" id="id<?=$weap['id_item'];?>">
			  <td><a href="thing.php?thing=<?=$weap['id_item'];?>" target="_blank"><?=$weap['Thing_Name'];?></a></td>
			  <td>У персонажа <? if( !empty( $user['ClanID'] ) ): ?> <a href="top5.php?show=<?=$user['ClanID'];?>"><img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/clan/<?=$user['ClanID'];?>.gif" /></a> <? endif; ?><a href="javascript:top.AddToPrivate('<?=$user['Username'];?>', true)"><?=$user['Username'];?></a> [<?=$user['Level'];?>] <a href="inf.php?uname=<?=$user['Username'];?>" target="_blank"><img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/inf.gif" width="12px" height="12px" title="info <?=$user['Username'];?>" /></a>. Должен <b><?=$cost;?></b> кр.</td>
			  <td> <input type="button" value="Забрать" onclick="$.post('ajax/cl.php', { page: 'weapons', act: 'izyat_ok', item: '<?=$weap['id_item'];?>' }, function(data){ jAlert(data, 'Сообщение'); $('#id<?=$weap['id_item'];?>').empty(); } );" /> </td>
	         </tr>
			<?
			}
			?>
			</table>
			<?
			} else {
				echo 'П У С Т О';
	        }

	}
	elseif( $_POST['act'] == 'izyat_ok' )
	{
		if( !is_numeric($_POST['item']) || $_POST['item'] <= 0 )  echo 'Что-то тут не так';
		elseif( !$weap = $items->getItem($_POST['item']) )  echo 'Такой вещи не найдено';
		else
		{
			if( $weap['Wear_ON'] == 1 )
			{
				if( !$user = $db->queryRow( "SELECT HPnow, HPall, Level, ClanID FROM ".SQL_PREFIX."players WHERE Username = '".$weap['Owner']."';" ) ) die;

				$upd = Array();
                $query = '';

				if ($user['HPnow'] > ($user['HPall'] - $weap['Endu_add']) )
 					$upd['HPnow'] = $user['HPall'] - $weap['Endu_add'];

 				if ($weap['Stre_add'])
 					$upd['Stre'] = '[-]'.$weap['Stre_add'];

				if ($weap['Agil_add'])
					$upd['Agil'] = '[-]'.$weap['Agil_add'];

				if ($weap['Intu_add'])
					$upd['Intu'] = '[-]'.$weap['Intu_add'];

				if ($weap['Endu_add'])
					$upd['HPall'] = '[-]'.$weap['Endu_add'];

				if ($weap['Level_add'])
					$upd['Level'] = '[-]'.$weap['Level_add'];

				if ($weap['Slot'] == 4 || $weap['Slot'] == 5 || $weap['Slot'] == 6)
 					$query = ", Slot = '4'";



				if( !empty($upd) )
 					$db->update( SQL_PREFIX.'players', $upd, Array( 'Username' => $weap['Owner'] ), 'maths' );


				$db->execQuery("UPDATE ".SQL_PREFIX."things SET Wear_ON = '0' ".$query." WHERE Owner = '".$weap['Owner']."' AND Un_Id = '".$weap['id_item']."' AND Wear_ON = '1'");
            }

			$items->setItemOwner( $_POST['item'], '' );

			$query = sprintf("DELETE FROM ".SQL_PREFIX."clan_weapon_demands WHERE id_item = '%d' AND Username = '%s';", $weap['id_item'], $weap['Owner']  );
			$db->execQuery( $query, "ClanWeaponDemands_delItemDemand_1" );
            $db->insert( SQL_PREFIX.'clan_history', Array( 'id_clan' => $player->id_clan, 'time' => time(), 'type' => 'weapons', 'text' => '<b>'.$player->username.'</b> <font color="red"><b>изъял</b></font> вещь <a href="thing.php?thing='.$weap['id_item'].'" target="_blank">'.$weap['id_item'].'</a> у персонажа <b>'.$weap['Owner'].'</b>' ) );


			echo 'Вещь успешно добавлена в оружейку';

		}

	}

    elseif( $_POST['act'] == 'addthings' )
	{
		$bgcolor = '#D4D2D2';
		$data = $db->queryArray( "SELECT Un_Id, Thing_Name FROM ".SQL_PREFIX."things WHERE Owner = '".$player->username."' AND Wear_ON = '0' AND Slot <= '10' AND Thing_Name NOT LIKE '%именная%';" );


			if( !empty($data) ){            ?>
            <table width="100%" border="0" cellpadding="2" cellspacing="2" align="left" valign="top">
            <?
            foreach($data as $weap){
            if ($bgcolor == '#D4D2D2'): $bgcolor = '#E2E0E0'; elseif($bgcolor == '#E2E0E0'): $bgcolor = '#D4D2D2'; endif;
            ?>
			 <tr bgcolor="<?=$bgcolor;?>" id="id<?=$weap['Un_Id'];?>">
			  <td><a href="thing.php?thing=<?=$weap['Un_Id'];?>" target="_blank"><?=$weap['Thing_Name'];?></a></td>
			  <td>Цена за неделю: <input type="text" value="" size="5" maxlength="3" id="cost<?=$weap['Un_Id'];?>" /> кр.</td>
			  <td> <input type="button" value="Добавить" onclick="$.post('ajax/cl.php', { page: 'weapons', act: 'addthings_ok', item: '<?=$weap['Un_Id'];?>', cost: $('#cost<?=$weap['Un_Id'];?>').val() }, function(data){ jAlert(data, 'Сообщение'); $('#id<?=$weap['Un_Id'];?>').empty(); } );" /> </td>
	         </tr>
			<?
			}
			?>
			</table>
			<?
			} else {
				echo 'П У С Т О';
	        }

	}
	elseif( $_POST['act'] == 'addthings_ok' )
	{
		if( !is_numeric($_POST['item']) || $_POST['item'] <= 0 ){ echo 'Что-то тут не так'; }
		elseif( empty($_POST['cost']) || $_POST['cost'] <= 0 || !is_numeric($_POST['cost']) ){ echo 'Неправильная цена'; }
		elseif(  !$id = @$db->SQL_result($db->query( "SELECT Un_Id FROM ".SQL_PREFIX."things WHERE Un_Id = '".intval($_POST['item'])."' AND Owner = '".$player->username."' AND Wear_ON = '0';" ) )  ){ echo 'Такой вещи не найдено'; }
		else
		{
			$items->addClanWeaponItem($id, $player->username, floatval($_POST['cost']) );
			$db->insert( SQL_PREFIX.'clan_history', Array( 'id_clan' => $player->id_clan, 'time' => time(), 'type' => 'weapons', 'text' => '<b>'.$player->username.'</b> <font color="green"><b>добавил</b></font> вещь <a href="thing.php?thing='.$id.'" target="_blank">'.$id.'</a> в оружейку с ценой '.floatval($_POST['cost']).' кр.' ) );
			echo 'Вещь успешно добавлена в оружейку';

		}

	}

	elseif( $_POST['act'] == 'return_things' )
	{
		if( !is_numeric($_POST['item']) || $_POST['item'] <= 0 ){ echo 'Что-то тут не так'; }
		elseif( !$weap = $items->getItem($_POST['item']) ){ echo 'Такой вещи не существует'; }
		elseif( $player->Money < $cost = sprintf ( "%.2f", $weap['cost'] * ( (time() - $weap['timeINuse']) / 604800  ) ) ){ echo 'Недостаточно денег'; }
		elseif( $weap['NOWwear'] != 0 ){ echo 'Для того, чтобы сдать вещь, нужно ее починить'; }
		else
		{
			$items->setItemOwner( $weap['id_item'], '' );
			$db->update( SQL_PREFIX.'players', Array( 'Money' => '[-]'.$cost ), Array( 'Username' => $player->username ), 'maths' );
			$db->update( SQL_PREFIX.'clan', Array( 'kazna' => '[+]'.$cost ), Array( 'id_clan' => $player->id_clan ), 'maths' );
			$db->execQuery( "DELETE FROM ".SQL_PREFIX."clan_weapon_demands WHERE Username = '".$player->username."' AND id_item = '".$weap['id_item']."';" );

            $db->insert( SQL_PREFIX.'clan_history', Array( 'id_clan' => $player->id_clan, 'time' => time(), 'type' => 'weapons', 'text' => '<b>'.$player->username.'</b> <u>вернул</u> вещь <a href="thing.php?thing='.$weap['id_item'].'" target="_blank">'.$weap['id_item'].'</a> в оружейку и заплатил '.$cost.' кр.' ) );

			echo 'Вы вернули вещь и заплатили '.$cost.' кр.';


		}

	}

?>