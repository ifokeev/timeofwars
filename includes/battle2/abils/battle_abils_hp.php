<?
/*
 array(
   	ид_клана/имя персонажа = array(
   	'percent' => шанс срабатывания,
   	'stake' => доля от урона для восстановления,
   	'log' => лог для добавления
   	),
 );
*/
$hp = array(

	104 => array(
	'percent' => 10,
	'stake' => 0.5,
	'log' => 'Спецназовец '.$player->slogin().' выпил стеройдов, и его состояние улучшилось на <font color=green><b>%d HP</b></font> [%d/'.$player->hp_all.'].'
	),

	103 => array(
	'percent' => 10,
	'stake' => 0.5,
	'log' => 'Убийца '.$player->slogin().' выпил кровь врага, и его состояние улучшилось на <font color=green><b>%d HP</b></font> [%d/'.$player->hp_all.'].'
	),

	102 => array(
	'percent' => 10,
	'stake' => 0.5,
	'log' => $player->slogin().' забрал пирожок у stasx тем самым восстановив <font color=green><b>%d HP</b></font> [%d/'.$player->hp_all.'].'
	),

);

$rand = rand(0,100);

if ( !empty($hp) && ( isset( $hp[$player->id_clan] ) || isset( $hp[$player->Username] )) )
{	    if( isset( $hp[$player->id_clan] ) )
			$wtf = $player->id_clan;
	    else
	    	$wtf = $player->Username;
	if( $rand < $hp[$wtf]['percent'] && $damage > 0 )
	{

		$vamp_hp = $damage * $hp[$wtf]['stake'];
		$vamp_hp = round($vamp_hp);
    	$player->hp += $vamp_hp;

		$player->set_hp($player->hp);
		$player->set_dead(0);


		$battle_log->add_log( get_date().sprintf($hp[$wtf]['log'], $vamp_hp, $player->hp), $step, 2 );
    }
}
?>