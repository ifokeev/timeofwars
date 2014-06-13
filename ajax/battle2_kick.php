<?php
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);
session_start();


header('Content-type: text/html; charset=windows-1251');


include('../db.php');
include('../includes/lib/php2js.php');

include('../classes/PlayerBattle.php');


$player = new battle($_SESSION['login']);
$player->is_blocked();

$enemy  = new battle($player->Enemy);


$data = $db->queryRow( "SELECT team1, team2, step FROM ".SQL_PREFIX."2battle WHERE (team1 LIKE '%".$player->Username.";%' OR team2 LIKE '%".$player->Username.";%') AND id = '".$player->battle_id."' AND (status = 'during' OR status = 'completed') LIMIT 1;" );
if( !$data )  die( "<script>window.location.href='".$player->Room.".php';</script>" );




if( !empty($_GET['act']) && $_GET['act'] == 'kick' )
{	$my_kicks  = array( 1 => 0, 2 => 0 );
	$my_blocks = array( 1 => 0, 2 => 0 );	if( !empty($_GET['kick']) )
	{		foreach( $_GET['kick'] as $k => $v )
		{			$my_kicks[($k+1)] = $v;
		}
    }

	if( !empty($_GET['block']) )
	{		if( count($_GET['block']) == 1 )
		{		    switch( $_GET['block'][0] )
			{
				case 1:  $block1 = 1; $block2 = 2; break;
				case 2:  $block1 = 2; $block2 = 3; break;
				case 3:  $block1 = 3; $block2 = 4; break;
				case 4:  $block1 = 4; $block2 = 1; break;
				default: $block1 = 0; $block2 = 0; break;
	        }

	        $my_blocks = array( 1 => $block1, 2 => $block2 );
	    }
	    else
	    {	   	    $i = 1;	   	    foreach( $_GET['block'] as $v )
		    {			   switch( $v )
			   {
				   case 5:  $block = 1; break;
				   case 6:  $block = 2; break;
				   case 7:  $block = 3; break;
				   case 8:  $block = 4; break;
				   default: $block = 0; break;
			   }
			   $my_blocks[$i] = $block;
			   $i++;
	        }
		}
    }
    if( !empty($player->battle_id) )
    {
      	$db->execQuery("INSERT INTO ".SQL_PREFIX."2battle_kicks ( user_id, target_id, battle_id, kick1, kick2, block1, block2, hit_time, step ) VALUES ('".$player->Id."', '".$enemy->Id."', '".$player->battle_id."', '".$my_kicks[1]."', '".$my_kicks[2]."', '".$my_blocks[1]."', '".$my_blocks[2]."', '".time()."', '".$data['step']."') ON DUPLICATE KEY UPDATE battle_id = '".$player->battle_id."', target_id = '".$enemy->Id."', kick1 = '".$my_kicks[1]."', kick2 = '".$my_kicks[2]."', block1 = '".$my_blocks[1]."', block2 = '".$my_blocks[2]."', step = '".$data['step']."';");


        $team = $player->team == 1 ? 2 : 1;
    	$enemies = split( ';', $data['team'.$team] );
        array_pop($enemies);

        $key = array_search($enemy->Username, $enemies);

        $next = $enemies[($key+1)];
        if( $next == false )        	$next = $enemies[0];

      $db->update( SQL_PREFIX.'2battle_action', Array( 'Enemy' => $next ), Array( 'Username' => $player->Username, 'battle_id' => $player->battle_id ) );


    }

    if( !empty($enemy->Reg_IP) && $enemy->Reg_IP == 'бот' )
    {
    	if( !empty($enemy->out['Slot_id'][9]) )
    	{    		$block1 = mt_rand( 1, 4 );

    		while( $block2 == $block1 )
    		 	$block2 = mt_rand( 1, 4 );

        }
        else
        {        	$block = mt_rand( 1, 4 );
        	switch( $block )
			{
				case 1:  $block1 = 1; $block2 = 2; break;
				case 2:  $block1 = 2; $block2 = 3; break;
				case 3:  $block1 = 3; $block2 = 4; break;
				case 4:  $block1 = 4; $block2 = 1; break;
				default: $block1 = 0; $block2 = 0; break;
	        }
        }


        $kick1 = mt_rand( 1, 4 );
        $kick2 = 0;
    if( !empty($player->battle_id) )
      $db->execQuery("INSERT INTO ".SQL_PREFIX."2battle_kicks ( user_id, target_id, battle_id, kick1, kick2, block1, block2, hit_time, step ) VALUES ('".$enemy->Id."', '".$player->Id."', '".$player->battle_id."', '".$kick1."', '".$kick2."', '".$block1."', '".$block2."', '".time()."', '".$data['step']."') ON DUPLICATE KEY UPDATE battle_id = '".$player->battle_id."', target_id = '".$player->Id."', kick1 = '".$kick1."', kick2 = '".$kick2."', block1 = '".$block1."', block2 = '".$block2."', step = '".$data['step']."';");

    }

    die;
}

?>