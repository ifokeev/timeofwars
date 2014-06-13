<?
$Relations = new ClanRelations( $player->id_clan );

	if( !empty($_POST['act']) && $_POST['act'] == 'update' )
	{
		$reason = iconv('UTF-8', 'windows-1251', $_POST['reason']);

		if( preg_match('/[^a-z,A-Z,0-9,а-я,А-Я,\-,\_]/', $reason) || strlen($reason) > 30 ){ echo 'Недопустимое значение причины'; }
		elseif( !is_numeric($_POST['clan']) || ($_POST['align'] != 'WAR' && $_POST['align'] != 'PEACE' && $_POST['align'] != 'ALLIANCE' && $_POST['align'] != 'NEUTRAL') ){ echo 'Нихуйа!!!'; }
		else{

		$_POST['clan'] = intval($_POST['clan']);

		$Relations->setRelation( $_POST['clan'], $_POST['align'], $reason );


	    $fromUser = '<b style="color:red;">Объявление</b>';
	    $msgChat  = 'Клан <a href="http://'.$db_config[DREAM]['server'].'/top5.php?show='.$player->id_clan.'" target="_blank"><img src="http://'.$db_config[DREAM_IMAGES]['server'].'/clan/'.$player->id_clan.'.gif" width="24px" height="15" alt="" /></a> '.$Relations->getRelationActionTitle($_POST['align']).' <a href="http://'.$db_config[DREAM]['server'].'/top5.php?show='.$_POST['clan'].'" target="_blank"><img src="http://'.$db_config[DREAM_IMAGES]['server'].'/clan/'.$_POST['clan'].'.gif" width="24px" height="15px" alt="" /></a>';
	    if( !empty($reason) ) $msgChat .= ' по причине: '.$reason;


        $db->insert( SQL_PREFIX.'clan_history', Array( 'id_clan' => $player->id_clan, 'time' => time(), 'type' => 'relations', 'text' => '<b>'.$player->username.'</b> '.$Relations->getRelationActionTitle($_POST['align']).' <a href="http://'.$db_config[DREAM]['server'].'/top5.php?show='.$_POST['clan'].'" target="_blank"><img src="http://'.$db_config[DREAM_IMAGES]['server'].'/clan/'.$_POST['clan'].'.gif" width="24px" height="15px" alt="" /></a>' ) );


		$files = scandir($db_config[DREAM]['web_root'].'/chat');
		if( !empty($files) ){
		foreach($files as $file)
		{
			if (preg_match("/.txt/i", $file))
			{
				$file = str_replace( '.txt', '', $file );
				$chat = new ChatSendMessages( '', $file );
				$chat->sendMessage( $fromUser, $msgChat );
	        }
	    }
	    }

	    echo 'Отношения обновлены';

        }

		die;
    }
    ?>
    <table border="0" cellpadding="2" cellspacing="1" width="100%" align="center">
     <tr align="center" bgcolor="#D4D2D2">
      <td nowrap="nowrap">Клан</td>
      <td>Война</td>
      <td>Мир</td>
      <td>Союз</td>
      <td>Нейтрал</td>
      <td>Наша причина </td>
      <td>От них </td>
      <td>Их причина </td>
      <td>Действие</td>
     </tr>

     <? foreach( $Relations->getRelationList() as $row ): ?>
     <tr align="center" bgcolor="#E2E0E0">
	  <td nowrap="nowrap"><img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/clan/<?=$row['id_clan'];?>.gif" title="<?=$row['title'];?>" /><?=$row['title'];?></td>
	  <td <?=($row['relationTo'] == 'WAR' ? 'bgcolor="#ff7171"><input checked="checked"' : "><input")?> name="align<?=$row['id_clan'];?>" type="radio" value="WAR"></td>
	  <td <?=($row['relationTo'] == 'PEACE' ? 'bgcolor="#99cc00"><input checked="checked"' : "><input")?> name="align<?=$row['id_clan'];?>" type="radio" value="PEACE"></td>
	  <td <?=($row['relationTo'] == 'ALLIANCE' ? 'bgcolor="#0099cc"><input checked="checked"' : "><input")?> name="align<?=$row['id_clan'];?>" type="radio" value="ALLIANCE"></td>
	  <td <?=($row['relationTo'] == 'NEUTRAL' ? '><input checked="checked"' : "><input")?> name="align<?=$row['id_clan'];?>" type="radio" value="NEUTRAL"></td>
	  <td><input type="text" id="reasonTo<?=$row['id_clan'];?>" value="<?=$row['reasonTo']?>"></td>
	  <td <?=$Relations->getRelationTitle($row['relationFrom']);?></td>
	  <td><?=$row['reasonFrom']?></td>
	  <td> <input type="button" onclick="$.post('ajax/cl.php', { page: 'align', act: 'update', clan: '<?=$row['id_clan'];?>', align: $('input[name=align<?=$row['id_clan'];?>]:checked').val(), reason: $('#reasonTo<?=$row['id_clan'];?>').val()}, function(data){ jAlert(data, 'Сообщение'); $('#body').load('ajax/cl.php', {page: 'align'} );  } );" value="Сохранить" class="oo" onmouseover="this.className = 'on';" onmouseout="this.className = 'oo';" /> </td>
     </tr>
     <? endforeach; ?>
    </table>