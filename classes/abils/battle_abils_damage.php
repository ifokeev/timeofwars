<?
/*
 array(
   	ид_клана/им€ персонажа = array(
   	'percent' => шанс срабатывани€,
   	'stake' => во сколько раз увеличиваем урон,
   	'log' => лог дл€ добавлени€
   	),
 );
*/

$d = array(

	255 => array(
	'percent' => 99,
	'stake' => 5,
	'log' => $player->slogin().' плюнул в лоб '.$enemy->slogin().' :)'
	),

	102 => array(
	'percent' => 5,
	'stake' => 2,
	'log' => $player->slogin().' забрал у stasx кольцо двойного урона (артефакт)'
	),

);

$rand = rand(0,100);

if ( !empty($d) && ( isset( $d[$player->id_clan] ) || isset( $d[$player->Username] )) )
{
	    if( isset( $d[$player->id_clan] ) )
			$wtf = $player->id_clan;
	    else
	    	$wtf = $player->Username;


		if( $rand < $d[$wtf]['percent'] && $damage > 0 )
		{			$damage *= $d[$wtf]['stake'];
			$damage  = round($damage);
			$hascrit = 1;

			$battle_log->add_log( get_date().$d[$wtf]['log'], $step, 2 );
    	}
}
?>
