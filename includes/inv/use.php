<?
if (!empty($use)) {

if($woodc){ $err = '�� ������� ������ ������� ����'; }
else{

if( !$thing = $db->queryRow("SELECT * FROM ".SQL_PREFIX."things WHERE Owner = '$player->username' AND Un_Id = '$use'") ){ $err = '������� �� ������ � ���������'; }
elseif ($thing['Stre_need'] > $player->Stre && $thing['Agil_need'] > $player->Agil && $thing['Intu_need'] > $player->Intu && $thing['Endu_need'] > $player->Endu && $thing['Level_need'] > $player->Level) { $err = '�� �� ������ ����� ��� ����'; }
elseif (!$thing['MagicID']){ $err = '������� �� ������ � ��������� ���� �� ����� ��������� ������������'; }
else{



if ( ($thing['MagicID'] == '�����������') && ($_GET['side'] == 1 || $_GET['side'] == 2) && !empty($_GET['battleid']) )
{	$team = intval($_GET['side']);

	$dat = $db->queryRow( "SELECT id, team1, team2 FROM ".SQL_PREFIX."2battle WHERE id = '".intval($_GET['battleid'])."';" );
	if( !empty($dat) )
	{		$team__1 = split( ';', $dat['team1'] ); array_pop($team__1);
		$team__2 = split( ';', $dat['team2'] ); array_pop($team__2);
		$users = $team__1 + $team__2;
		foreach( $users as $user )
		{			if( in_array($user, $tow_bots) || in_array($user, $botAll) || $db->SQL_result($db->query("SELECT tu.turnir_id FROM ".SQL_PREFIX."turnir_users as tu LEFT JOIN ".SQL_PREFIX."turnir as t ON( t.id = tu.turnir_id ) WHERE tu.user = '".$user."';"),0) )
			{				$ebot = 1;
				break;
	        }
	    }
		if ($ebot == 1)			$err = '�� �� ������ ��������� � ���� ���';
		elseif (rand(0,100) > $thing['Srab'])
		{			$err = '� ��������� ������ �� �������� :(';
			$db->update( SQL_PREFIX.'things', Array( 'NOWwear' => '[+]1' ), Array( 'Un_Id' => $thing['Un_Id'], 'Owner' => $player->username ), 'maths' );
			$db->execQuery("DELETE FROM ".SQL_PREFIX."things WHERE NOWwear = MAXwear AND Owner = '$player->username'");
		}
		else
		{			$player->to_interfere( $player->slogin( '', '', '', $team ), $dat['id'],  $team );
			$db->update( SQL_PREFIX.'things', Array( 'NOWwear' => '[+]1' ), Array( 'Un_Id' => $thing['Un_Id'], 'Owner' => $player->username ), 'maths' );
			$db->execQuery("DELETE FROM ".SQL_PREFIX."things WHERE NOWwear = MAXwear AND Owner = '$player->username'");
    	    @header('Location: battle2.php');
    	}
    }
    else    	$err = '������ ��� �� ���������� ���� �� ����������.';


}




if (!empty($target) && trim(strtolower($target)) != trim(strtolower($player->username)) && $thing['MagicID'] == '���������') {

if( !list($Username, $Level, $HPnow, $BattleID) = $db->queryCheck("SELECT players.Username, players.Level, players.HPnow, players.BattleID2 FROM ".SQL_PREFIX."players as players, ".SQL_PREFIX."online as online WHERE players.Username = '$target' AND players.Username = online.Username") ){ $err = '������ ��������� �� ����������, ���� �� �� ��������� � ����'; }
elseif( in_array($Username, $tow_bots) && $player->username != 's!.' ) { $err = '��������� �� ����� ���� � ������� ������ ����������'; }
elseif( @$db->SQL_result($db->query("SELECT tu.turnir_id FROM ".SQL_PREFIX."turnir_users as tu INNER JOIN ".SQL_PREFIX."turnir as t ON( t.id = tu.turnir_id ) WHERE tu.user = '".$Username."';"),0) ) $err = '������ ������� �� ��������� � �������.';
elseif( !in_array($Username, $botAll) && $HPnow <= 0){ $err = '�������� ������� ����'; }
elseif($BattleID){ $err = '�������� � ���'; }
elseif($player->HPnow<=($player->HPall/2)){ $err = '�� ������� �����. ��������������.'; }
elseif( (( (($player->Level-$Level) >= 5) || $Level < 8) && in_array($Username, $botAll) == false) && $player->username != 's!.'){  $err = '���������� ������������ �����. ������� � ������� ������ ���� �� ����� 5. ��������� �� ������ ������ 8-�� ���������'; }
else{


$battle_id = $player->goBattle($Username);


if( in_array($Username, $botAll) == true ){

$db->update( SQL_PREFIX.'players', Array( 'Stre' => $player->Stre, 'Agil' => $player->Agil, 'Intu' => $player->Intu, 'Endu' => $player->Endu, 'HPall' => round($player->HPall*1.5), 'HPnow' => round($player->HPall*1.5), 'Level' => $player->Level ), Array( 'Username' => $Username ) );
$db->update( SQL_PREFIX.'online', Array( 'Level' => $player->Level ), Array( 'Username' => $Username ) );

$db->execQuery("DELETE FROM `".SQL_PREFIX."things` WHERE Un_Id >= '600' AND Un_Id <= '611'");

$un_id_t = 600;

$thi = $db->queryArray("SELECT * FROM `".SQL_PREFIX."things` WHERE Owner = '$player->username' AND Wear_ON = '1'");
if(!empty($thi)){
foreach($thi as $th){
$db->insert( SQL_PREFIX.'things',
Array(
'Owner' => $Username, 'Un_Id' => $un_id_t, 'Id' => $th['Id'], 'Thing_Name' => $th['Thing_Name'],
'Slot' => $th['Slot'], 'Cost' => $th['Cost'], 'Level_need' => $th['Level_need'], 'Stre_need' => $th['Stre_need'],
'Agil_need' => $th['Agil_need'], 'Intu_need' => $th['Intu_need'], 'Endu_need' => $th['Endu_need'],
'Clan_need' => $th['Clan_need'], 'Level_add' => $th['Level_add'],  'Stre_add' => $th['Stre_add'],
'Agil_add' => $th['Agil_add'], 'Intu_add' => $th['Intu_add'], 'Endu_add' => $th['Endu_add'],
'MINdamage' => $th['MINdamage'], 'MAXdamage' => $th['MAXdamage'], 'Crit' => $th['Crit'],
'AntiCrit' => $th['AntiCrit'], 'Uv' => $th['Uv'], 'AntiUv' => $th['AntiUv'], 'Armor1' => $th['Armor1'],
'Armor2' => $th['Armor2'], 'Armor3' => $th['Armor3'], 'Armor4' => $th['Armor4'], 'MagicID' => $th['MagicID'],
'NOWwear' => $th['NOWwear'], 'MAXwear' => $th['MAXwear'], 'Wear_ON' => '1', 'Srab' => $th['Srab']
)
);
$un_id_t++;
}
}

}


$new_msg = GetMicroTime().'>><a class="date">'.date('H:i').'</a> ��������� <b>'.$player->username.'</b> ���� ������, � �� ������� �������� �� <b>'.$Username.'</b>. <a href="../logs2.php?id='.$battle_id.'" target="_blank">��� ���</a>';
$new_msg = trim($new_msg)."\n";
$chat->writeNew( $new_msg );

$db->update( SQL_PREFIX.'things', Array( 'NOWwear' => '[+]1' ), Array( 'Un_Id' => $thing['Un_Id'], 'Owner' => $player->username ), 'maths' );
$db->execQuery("DELETE FROM ".SQL_PREFIX."things WHERE NOWwear = MAXwear AND Owner = '$player->username'");


@header('Location: battle2.php');

exit;

//   ������ else
}

}


if ($thing['MagicID'] == '�������' && !empty($target) ){

if( !$db->numrows("SELECT Username FROM ".SQL_PREFIX."inv WHERE username = '$target'") ){ $err = $target.' �� ����� ������'; }
elseif (rand(0,100) > $thing['Srab']){
$err = '��������� �������';
$db->update( SQL_PREFIX.'things', Array( 'NOWwear' => '[+]1' ), Array( 'Un_Id' => $thing['Un_Id'], 'Owner' => $player->username ), 'maths' );
$db->execQuery("DELETE FROM ".SQL_PREFIX."things WHERE NOWwear = MAXwear AND Owner = '$player->username'"); }
else{

$trg = new PlayerInfo($target);
$rezult = $trg->HealTrauma();

if ($rezult){ $err = $target.' ������� ������� �� �����'; }
else { $err = '���������� �������� '.$target; }

$db->update( SQL_PREFIX.'things', Array( 'NOWwear' => '[+]1' ), Array( 'Un_Id' => $thing['Un_Id'], 'Owner' => $player->username ), 'maths' );
$db->execQuery("DELETE FROM ".SQL_PREFIX."things WHERE NOWwear = MAXwear AND Owner = '$player->username'");

}

}


if ($thing['MagicID'] == '����� ������' && !empty($target) ){

list($Level, $Reg_IP) = $db->queryCheck("SELECT Level, Reg_IP FROM ".SQL_PREFIX."players WHERE Username = '".$target."' AND BattleID2 = '0' ");

if( $Level == ''){ $err = '������ ��������� �� ����������'; }
elseif($Reg_IP == '���'){ $err = '������ �������� ����� ����'; }
else{

$sumstats = $Level*4 + 15;

list($str, $agl, $int, $lvl, $endu) = $db->fetch_array("SELECT sum(Stre_add), sum(Agil_add), sum(Intu_add), sum(Level_add), sum(Endu_add) FROM ".SQL_PREFIX."things	WHERE Owner = '$target' AND Wear_ON = '1'");

if ($lvl == 0){

if ( !$db->numrows("SELECT * FROM ".SQL_PREFIX."inv WHERE Username = '$target'") ){

$endustats = $Level + 3; $enduadd = $endustats*3; $enduall = $endu + $enduadd + 9;

$freestats = $sumstats - $endustats - 9;

$str_new = $str + 3; $agl_new = $agl + 3; $int_new = $int + 3;

$db->update( SQL_PREFIX.'players', Array( 'Stre' => $str_new, 'Agil' => $agl_new, 'Intu' => $int_new, 'Endu' => $endustats, 'Intl' => '0', 'HPall' => $enduall, 'HPnow' => $enduall, 'Ups' => $freestats ), Array( 'Username' => $target ) );

$db->update( SQL_PREFIX.'things', Array( 'NOWwear' => '[+]1' ), Array( 'Un_Id' => $thing['Un_Id'], 'Owner' => $player->username ), 'maths' );
$db->execQuery("DELETE FROM ".SQL_PREFIX."things WHERE NOWwear = MAXwear AND Owner = '$player->username'");

$tr_msg = '<B>'.$player->username.'</B> ������� ��� �����';
$db->insert( SQL_PREFIX.'messages', Array( 'Username' => $target, 'Text' => $tr_msg ) );
$err = '������� �������� ����� ��������� '.$target;

} else { $err = '��� ������ ����� �������� ������'; }

} else { $err = '���������� �������� ����� � ������ ��������'; }

}

}



if ($thing['MagicID'] == '����� ����� ������'){

list($Level, $Reg_IP) = $db->queryCheck("SELECT Level, Reg_IP FROM ".SQL_PREFIX."players WHERE Username = '$player->username' AND BattleID2 = '0'");

if($Reg_IP == '���'){ $err = '������ �������� ����� ����'; }
else{

$sumstats = $Level*4 + 15;

list($str, $agl, $int, $lvl, $endu) = $db->fetch_array("SELECT sum(Stre_add), sum(Agil_add), sum(Intu_add), sum(Level_add), sum(Endu_add) FROM ".SQL_PREFIX."things	WHERE Owner = '$player->username' AND Wear_ON = '1'");

if ($lvl == 0){

if ( !$db->numrows("SELECT * FROM ".SQL_PREFIX."inv WHERE Username = '$player->username'") ){

$endustats = $Level + 3; $enduadd = $endustats*3; $enduall = $endu + $enduadd + 9;

$freestats = $sumstats - $endustats - 9;

$str_new = $str + 3; $agl_new = $agl + 3; $int_new = $int + 3;

$db->update( SQL_PREFIX.'players', Array( 'Stre' => $str_new, 'Agil' => $agl_new, 'Intu' => $int_new, 'Endu' => $endustats, 'Intl' => '0', 'HPall' => $enduall, 'HPnow' => $enduall, 'Ups' => $freestats ), Array( 'Username' => $player->username ) );

$db->update( SQL_PREFIX.'things', Array( 'NOWwear' => '[+]1' ), Array( 'Un_Id' => $thing['Un_Id'], 'Owner' => $player->username ), 'maths' );
$db->execQuery("DELETE FROM ".SQL_PREFIX."things WHERE NOWwear = MAXwear AND Owner = '$player->username'");

$err = '����� ������� ��������';

} else { $err = '��� ������ ����� �������� ������'; }

} else { $err = '���������� �������� ����� � ������ ��������'; }

}


}


			//----- �������������� HP -----
if ($thing['MagicID'] == '+ 20 HP'  || $thing['MagicID'] == '+ 30 HP' || $thing['MagicID'] == '+ 50 HP' || $thing['MagicID'] == '+ 100 HP'  || $thing['MagicID'] == '+ 500 HP' || $thing['MagicID'] == '+ 1000 HP') {

switch ($thing['MagicID']) {

case '+ 20 HP': $heal_hm = 20; break;
case '+ 30 HP': $heal_hm = 30; break;
case '+ 50 HP': $heal_hm = 50; break;
case '+ 100 HP': $heal_hm = 100; break;
case '+ 500 HP': $heal_hm = 500; break;
case '+ 1000 HP': $heal_hm = 1000; break;

}

if ($player->HPnow == $player->HPall || rand(0,100) > $thing['Srab']) { $newhp = $player->HPnow - $heal_hm; $err = '��� ��������'; }
else { if ($newhp > $player->HPall) { $newhp = $player->HPall; $player->HPnow = $player->HPall; } else{ $newhp = $player->HPnow + $heal_hm;  } $err = '������ ������������� '.$heal_hm.' HP'; }

$db->update( SQL_PREFIX.'players', Array( 'HPnow' => $newhp ), Array( 'Username' => $player->username ) );

$db->update( SQL_PREFIX.'things', Array( 'NOWwear' => '[+]1' ), Array( 'Un_Id' => $thing['Un_Id'], 'Owner' => $player->username ), 'maths' );
$db->execQuery("DELETE FROM ".SQL_PREFIX."things WHERE NOWwear = MAXwear AND Owner = '$player->username'");

$player->HPnow = $newhp;
}

// ������ else
}

// �������� �� ���
}
//�����
}
?>
