<?
function get_drop( $user, $battles )
{
	global $db;
	if( $battles%3 == 0 )
	{
		$drop = Array(
		'kr', 'items/grass1', 'items/grass2', 'items/jen-shen', 'items/kalendula', 'items/vasilek', 'items/vetrenica', 'items/sumka',
		'items/hmel', 'items/devatisil', 'items/mak', 'items/shalf', 'items/veresk', 'items/sandal', 'items/valer',
		'items/vanil', 'items/durman', 'items/pustir', 'items/muhomor', 'items/lisichka', 'items/siroezka', 'items/opata', 'items/krasnyi',
		'items/maslenok', 'fish/beluga', 'fish/ersh', 'fish/karas', 'fish/lesh', 'fish/okun', 'fish/plotva',
		);


		$give = $drop[mt_rand( 0, count($drop)-1 )];
		if( $give == 'kr' )
		{
			$give = rand(1, 10);
			$db->update( SQL_PREFIX.'players', Array( 'Money' => '[+]'.$give ), Array( 'Username' => $user ), 'maths' );
			$msg = 'Вау! Вы только что нашли <b>'.okon4( $give, Array( 'кредит', 'кредита', 'кредитов' )).'.</b>';
			$db->execQuery("INSERT INTO `".SQL_PREFIX."messages` VALUES ('".$user."', '".mysql_escape_string($msg)."');");
			$db->execQuery("INSERT INTO `".SQL_PREFIX."transfer` (`Date`, `From`, `To`, `What`) VALUES ('".date('Y-m-d')."', 'Дроп', '".$user."', 'Нашел ".$give." кр.');");

		}
		else
		{
			$const = str_replace( 'items/', '', $give );
			$const = str_replace( 'fish/', '', $const );

        	if (!$db->numrows("SELECT * FROM `".SQL_PREFIX."things` WHERE Owner = '".$user."' AND Id = '".$give."';"))
        	{
        		$db->insert( SQL_PREFIX.'things', Array( 'Owner' => $user, 'Id' => $give, 'Thing_Name' => constant("_FOREST_".$const.""), 'Slot' => 15, 'Cost' => '1', 'Count' => '1', 'NOWwear' => '0', 'MAXwear' => '1' ) );
        	}
        	else
        	{
        		$db->execQuery("UPDATE `".SQL_PREFIX."things` SET Count = Count + '1' WHERE Owner = '".$user."' AND Id = '".$give."'");
       	 	}

			$msg = 'Что это? <b>'.constant("_FOREST_".$const."").'!</b> Вот это да! *Помещено в инвентарь*.';
			$db->execQuery("INSERT INTO `".SQL_PREFIX."messages` VALUES ('".$user."', '".mysql_escape_string($msg)."');");
			$db->execQuery("INSERT INTO `".SQL_PREFIX."transfer` (`Date`, `From`, `To`, `What`) VALUES ('".date('Y-m-d')."', 'Дроп', '".$user."', 'Нашел ".constant("_FOREST_".$const."")."');");


		}

	}
}

function test_turnir( $id )
{ global $db;

	$data = $db->queryRow( "SELECT COUNT(DISTINCT tu.user) as cnt FROM ".SQL_PREFIX."turnir as t LEFT JOIN ".SQL_PREFIX."turnir_users as tu ON ( t.id = tu.turnir_id ) WHERE tu.turnir_id = '".intval($id)."' AND t.status = '2' GROUP BY tu.turnir_id;" );

	if( $data['cnt'] <= 1 )
	{
		    $db->update( SQL_PREFIX.'turnir', Array( 'status' => 3 ), Array( 'id' => $id, 'status' => '2' ) );
	        turnir_log( $id, 'В '.date('H:i:s').' турнир <b>закончился.</b> Победителя нет.' );
            turnir_msg( 'Турнир №'.$id.' <b>закончился.</b> Победителя нет.' );
    }

}


?>