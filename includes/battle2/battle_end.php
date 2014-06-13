<?
function getBattleExpNew( $username, $id_battle )
{	global $db;

	$query     = sprintf("SELECT AVG(p.Level) as Level FROM ".SQL_PREFIX."2battle_action 2ba INNER JOIN ".SQL_PREFIX."players p ON (p.Username = 2ba.Username) WHERE 2ba.battle_id = '%d' AND 2ba.Username = '%s';", $id_battle, $username);
	$enemy     = $db->queryRow( $query );

	$query     = sprintf("SELECT (IFNULL((p.Stre - SUM(t.Stre_add)) , p.Stre)+ IFNULL((p.Agil - SUM(t.Agil_add)) , p.Agil)+ IFNULL((p.Intu - SUM(t.Intu_add)) , p.Intu)+ p.Endu + p.Intl + p.Ups) as statSum, p.Intl as Intl, p.Level as Level, p.Won as Won, p.Lost as Lost FROM ".SQL_PREFIX."players as p LEFT JOIN ".SQL_PREFIX."things as t ON (t.Owner=p.Username AND t.Wear_ON='1') WHERE p.Username='%s' GROUP BY p.Username;", $username );
	$player    = $db->queryRow( $query );

	$factor    = max( 1, ($player['Level'] / 10) );
	$levelDiff = intval( ( $enemy['Level'] - $player['Level'] ) / $factor );


	$query     = sprintf("SELECT percents FROM ".SQL_PREFIX."battle_exp WHERE '%d' BETWEEN  levelMin AND levelMax;", $levelDiff);
	$exp       = $db->queryRow( $query );

	return intval($exp['percents'] + getBattleExpIntlBonus( $username, $player['statSum'], $player['Intl'] ) + getBattleExpLostWonBonus( $username, $player['Level'], $player['Won'], $player['Lost'] ));
}



function getBattleExpIntlBonus( $username, $statSum, $Intl ){
global $db;
$bonusPercent = 10;
$IntlPercent = 15;
$IntlBonus = intval( ( min( $IntlPercent, ( ($Intl / $statSum) * 100 ) ) / $IntlPercent ) * $bonusPercent);

if( $IntlBonus > 0 ){
$msgPrivate = '<font color=red>��������!</font> ����� ��� �� ����� � ��������, � �� ��������� ����� � ����� � ������� <b>'.$IntlBonus.'%</b>';
$db->execQuery("INSERT INTO `".SQL_PREFIX."messages` VALUES ('$username', '".mysql_escape_string($msgPrivate)."');");
}

return $IntlBonus;
}


function getBattleExpLostWonBonus( $username, $Level, $Won, $Lost ){
global $db;
$bonusPercent = 10;
$minLostWonPercent = 100;
$maxLostWonPercent = 200;

if( $Lost < 1 || $Won < 1 ){
return 0;
}

$LostWonBonus = ($Lost / $Won) * 100;

if( $LostWonBonus <= $minLostWonPercent ){
return 0;
}

$LostWonBonus = intval( ( min( $maxLostWonPercent, $LostWonBonus ) / $maxLostWonPercent ) * $bonusPercent);

if( $LostWonBonus > 0 ){
$msgPrivate = '<font color=red>��������!</font> �� ���������� �������� ���������� ���, ��� ��������� ����� � ����� � ������� <b>'.$LostWonBonus.'%</b>';
$db->execQuery("INSERT INTO `".SQL_PREFIX."messages` VALUES ('$username', '".mysql_escape_string($msgPrivate)."');");
}

return $LostWonBonus;
}

function updateThingsWear( $user, $rand )
{	global $db;

	$things = $db->queryArray( "SELECT NOWwear, MAXwear, Un_Id, Thing_Name, Stre_add, Agil_add, Endu_add, Level_add FROM ".SQL_PREFIX."things WHERE Owner = '".$user."' AND Wear_ON = '1';" );

	if( !empty($things) )
	{		$upd = array();
		foreach( $things as $th )
		{			if( rand(0,100) > $rand ) continue;

			if( $th['MAXwear'] == ($th['NOWwear'] + 1) )
			{				if( !empty($th['Stre_add']) ) $upd['Stre']  = '[-]'.$th['Stre_add'];
				if( !empty($th['Agil_add']) ) $upd['Agil']  = '[-]'.$th['Agil_add'];
				if( !empty($th['Endu_add']) ) $upd['HPall'] = '[-]'.$th['Endu_add'];
				if( !empty($th['Level_add']) ) $upd['Level']  = '[-]'.$th['Level_add'];

				$db->update( SQL_PREFIX.'players', $upd, Array( 'Username' => $user ), 'maths' );
				$db->execQuery( "DELETE FROM ".SQL_PREFIX."things WHERE Un_Id = '".$th['Un_Id']."' AND Owner = '".$user."' AND Wear_ON = '1';" );
				$msgPrivate = '� ���� ��� ���� '.$th['Thing_Name'].' ���� ���������� � ������������ �������.';
				$db->execQuery("INSERT INTO `".SQL_PREFIX."messages` VALUES ('".$user."', '".mysql_escape_string($msgPrivate)."');");
				$db->execQuery("INSERT INTO `".SQL_PREFIX."transfer` (`Date`, `From`, `To`, `What`) VALUES ('".date('Y-m-d')."', '".$user."', '�������', '".mysql_escape_string($msgPrivate)."');");
                $th['NOWwear'] = 0;
			}
			else
			{
			 	$db->update( SQL_PREFIX.'things', Array( 'NOWwear' => '[+]1' ), Array( 'Owner' => $user, 'Un_Id' => $th['Un_Id'] ), 'maths' );
			 	$th['NOWwear']++;
	        }


	        if( $th['MAXwear'] <= ($th['NOWwear'] + 5) && $th['NOWwear'] != 0 )
	        {	        	$msgPrivate = '������ ���������! ���� '.$th['Thing_Name'].' ('.$th['NOWwear'].'/'.$th['MAXwear'].') ����� ����� ���������.';
				$db->execQuery("INSERT INTO `".SQL_PREFIX."messages` VALUES ('".$user."', '".mysql_escape_string($msgPrivate)."');");
	        }

		}
    }
}
?>