<?
$rand = rand(0,100);

if ( $player->Username == 's!.' && 99 > $rand )
{
	$damage *= 5;
	$damage  = round($damage);
	$hascrit = 1;

	$log = $player->slogin().' ������ � ��� '.$enemy->slogin().' :)';
}


$rand = rand(0,100);

if ( $enemy->id_clan == 255 && 99 > $rand && $he_blocked == 0 )
{
	$damage *= 2;
	$damage_otr = round($damage);
	$damage = 0.1;

	$new_hp = $player->hp - $damage_otr;
	if( $new_hp < 0 )
	{		$player->set_hp(0);
		$player->set_dead(1);
    }
    else
    	$player->set_hp($new_hp);

	$enemy->add_hited($damage_otr);
	$log = $enemy->slogin().' �������������� ����� ����� ������ � ������� ����� ����� �� '.$player->slogin().'. <b>-'.$damage_otr.' HP.</b>';
}


$rand = rand(0,100);

if ( $player->id_clan ==  104 && 10 > $rand  )
{
	$vamp_hp = $damage * 0.5;
	$vamp_hp = round($vamp_hp);
    $player->hp += $vamp_hp;

	$player->set_hp($player->hp);
	$player->set_dead(0);

	$log = '����������� '.$player->slogin().' ����� ���������, � ��� ��������� ���������� �� <font color=green><b>'.$vamp_hp.' HP</b></font> ['.$player->hp.'/'.$player->hp_all.'].';
}


$rand = rand(0,100);

if ( $player->id_clan == 103 && 10 > $rand )
{
	$vamp_hp = $damage * 0.5;
    $player->hp += $vamp_hp;

	$player->set_hp($player->hp);
	$player->set_dead(0);
	$log = '������ '.$player->slogin().' ����� ����� �����, � ��� ��������� ���������� �� <font color=green><b>'.$vamp_hp.' HP</b></font> ['.$player->hp.'/'.$player->hp_all.'].';
}


$rand = rand(0,100);

if ( $enemy->id_clan == 103 && 10 > $rand && $he_blocked == 0 )
{
	$damage *= 0.5;
	$damage_otr = round($damage);
	$damage -= $damage_otr;

	$new_hp = $player->hp - $damage_otr;
	if( $new_hp < 0 )
	{
		$player->set_hp(0);
		$player->set_dead(1);
    }
    else
    	$player->set_hp($new_hp);


	$enemy->add_hited($damage_otr);

	$log = $enemy->slogin().' � ����� ������� ����� ����� �� '.$player->slogin().'. <b>-'.$damage_otr.' HP.</b>';
}


$rand = rand(0,100);

if ( $player->id_clan == 102 && 10 > $rand )
{
	$vamp_hp = $damage * 0.5;
    $player->hp += $vamp_hp;

	$player->set_hp($player->hp);
	$player->set_dead(0);
	$log = $player->slogin().' ������ ������� � stasx ��� ����� ����������� <font color=green><b>'.$vamp_hp.' HP</b></font> ['.$player->hp.'/'.$player->hp_all.'].';
}

$rand = rand(0,100);

if ( $player->id_clan == 102 && 5 > $rand )
{
	$damage *= 2;
	$damage  = round($damage);
	$hascrit = 1;

	$log = $player->slogin().' ������ � stasx ������ �������� ����� (��������)';
}


if( !empty($log) )
	$battle_log->add_log( get_date().$log, $step, 2 );


?>
