<?
/*
 array(
   	��_�����/��� ��������� = array(
   	'percent' => ���� ������������,
   	'stake' => ���� �� ����� ��� ���������,
   	'log' => ��� ��� ����������
   	),
 );
*/
$o = array(

	255 => array(
	'percent' => 99,
	'stake' => 1,
	'log' => $enemy->slogin().' �������������� ����� ����� ������ � ������� ����� ����� �� '.$player->slogin().'. <b>-%d HP.</b>'
	),

	103 => array(
	'percent' => 5,
	'stake' => 0.5,
	'log' => $enemy->slogin().' � ����� ������� ����� ����� �� '.$player->slogin().'. <b>-%d HP.</b>'
	),

);

$rand = rand(0,100);

if ( !empty($o) && ( isset( $o[$enemy->id_clan] ) || isset( $o[$enemy->Username] )) )
{
	    if( isset( $o[$enemy->id_clan] ) )
			$wtf = $enemy->id_clan;
	    else
	    	$wtf = $enemy->Username;

		if( $rand < $o[$wtf]['percent'] && $damage > 0 )
		{			$damage *= $o[$wtf]['stake'];
			$damage_otr = round($damage);
			$damage -= $damage_otr;

			$new_hp = $player->hp - $damage_otr;
			if( $new_hp < 0 )
			{
				$player->set_hp(0);
				$player->set_dead(1);

   				$win_team = completed_or_not_completed( $player->battle_id, $step );

 				switch( $win_team )
 				{
 					case 3: $battle_log->add_log( get_date().'<b>�����.</b>', $step+1 ); break;
 					case 2: $battle_log->add_log( get_date().'<b>������� <font color="#6666ff">�����</font> ��������.</b>', $step+1 ); break;
 					case 1: $battle_log->add_log( get_date().'<b>������� <font color="#ff6666">�������</font> ��������.</b>', $step+1 ); break;
 				}

   	 		}
    		else
    			$player->set_hp($new_hp);


			$enemy->add_hited($damage_otr);
			$battle_log->add_log( get_date().sprintf( $o[$wtf]['log'], $damage_otr ), $step, 2 );
		}

}
?>