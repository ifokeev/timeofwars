<?
if( !empty($wear_down) ){

if($woodc){ $err = 'Вы слишком заняты поиском трав'; }
elseif( $db->SQL_result($db->query( "SELECT tu.turnir_id FROM ".SQL_PREFIX."turnir_users as tu LEFT JOIN ".SQL_PREFIX."turnir as t ON( t.id = tu.turnir_id ) WHERE tu.user = '".$player->username."' AND t.status = '1';"),0) ){ $err = 'Нельзя что-либо снять, находясь в турнире.'; }
elseif( $db->queryCheck("SELECT * FROM ".SQL_PREFIX."demands WHERE Username = '$player->username' OR Name_pr = '$player->username'") ){ $err = 'Нельзя что-либо снять, находясь в заявке на бой'; }
elseif( $db->queryCheck("SELECT * FROM ".SQL_PREFIX."group_demands WHERE (Team1 LIKE '%".$player->username."%') OR (Team2 LIKE '%".$player->username."%')") ){ $err = 'Нельзя что-либо снять, находясь в заявке на бой'; }
elseif( !$thing_on = $db->fetch_array("SELECT Un_Id, Endu_add, Slot, Stre_add, Agil_add, Intu_add, Level_add FROM ".SQL_PREFIX."things WHERE Owner = '$player->username' AND Id = '$wear_down' AND Wear_ON = '1'") ){ $err = 'Вещь не найдена'; }
else
{	if( empty($ring_slot) )
	{		if ($thing_on[2] != 4 && $thing_on[2] != 5 && $thing_on[2] != 6)
		{			if ($player->HPnow > ($player->HPall - $thing_on['Endu_add']) )
			{
	                      $upd['HPnow'] = ($player->HPall - $thing_on['Endu_add']);
	        }
	        if ($thing_on['Stre_add']) {  $upd['Stre'] = '[-]'.$thing_on['Stre_add'];     }
	        if ($thing_on['Agil_add']) {  $upd['Agil'] = '[-]'.$thing_on['Agil_add'];     }
	        if ($thing_on['Intu_add']) {  $upd['Intu'] = '[-]'.$thing_on['Intu_add'];     }
	        if ($thing_on['Endu_add']) {  $upd['HPall'] = '[-]'.$thing_on['Endu_add'];    }
	        if ($thing_on['Level_add']) { $upd['Level'] = '[-]'.$thing_on['Level_add'];   }

	        if( !empty($upd) )
	        {	        	$db->update( SQL_PREFIX.'players', $upd, Array( 'Username' => $player->username ), 'maths' );
	        }

	        $db->update( SQL_PREFIX.'things', Array( 'Wear_ON' => '0' ), Array( 'Owner' => $player->username, 'Id' => $wear_down, 'Wear_ON' => '1' ) );
	    }
	}
	else
	{		if ( ($thing_on[2] == 4 || $thing_on[2] == 5 || $thing_on[2] == 6) && ($ring_slot == 4 || $ring_slot == 5 || $ring_slot == 6) )
		{

			if ($player->HPnow > ($player->HPall - $thing_on['Endu_add']) )
			{
	                      $upd['HPnow'] = ($player->HPall - $thing_on['Endu_add']);
	        }
	        if ($thing_on['Stre_add']) {  $upd['Stre'] = '[-]'.$thing_on['Stre_add'];     }
	        if ($thing_on['Agil_add']) {  $upd['Agil'] = '[-]'.$thing_on['Agil_add'];     }
	        if ($thing_on['Intu_add']) {  $upd['Intu'] = '[-]'.$thing_on['Intu_add'];     }
	        if ($thing_on['Endu_add']) {  $upd['HPall'] = '[-]'.$thing_on['Endu_add'];    }
	        if ($thing_on['Level_add']) { $upd['Level'] = '[-]'.$thing_on['Level_add'];   }

	        if( !empty($upd) )
	        {
	        	$db->update( SQL_PREFIX.'players', $upd, Array( 'Username' => $player->username ), 'maths' );
	        }

	        $db->update( SQL_PREFIX.'things', Array( 'Wear_ON' => '0', 'Slot' => 4 ), Array( 'Owner' => $player->username, 'Id' => $wear_down, 'Wear_ON' => '1', 'Slot' => $ring_slot ) );
	    }
	 }

$err = 'Вещь снята';

}
// end
}
?>
