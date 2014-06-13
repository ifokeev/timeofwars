<?php
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);
session_start();


header('Content-type: text/html; charset=windows-1251');


include ('../db.php');
include ('../classes/PlayerBattle.php');
include ('../includes/battle2/func_write_to_log.php');
include ('../includes/battle2/write_to_xml.php');
include ('../includes/lib/php2js.php');



function okon4 ($number, $titles){
$cases = array (2, 0, 1, 1, 1, 2);
return $number.' '.$titles[ ($number%100>4 && $number%100<20)? 2 : $cases[min($number%10, 5)] ];
}


if( !empty($_GET['act']) && $_GET['act'] == 'get_log' && !empty($_GET['battle_id']) && is_numeric($_GET['battle_id']) )
{ // грузим логи бо€

  $battle_log = new write_to_log($_GET['battle_id']);

  $log = $battle_log->read_log();

  $return = '';
  $i = 0;
  if( !empty($log['log']) )
  {  	krsort($log['log']);

     foreach( $log['log'] as $k => $v )
     {     	$i++;
     	if( $i <= 5 )
     	{     	   $return .= '<br />’од номер '.$k.': <br />';

           if( !empty($log['death'][$k]) )
           {           		foreach( $log['death'][$k] as $d_str )
           		 $return .= $battle_log->from_xml($d_str).'<br />';           }

     	   if( !empty($v) )
     	   {     		  krsort($v);     		  foreach( $v as $str )     			  $return .= $battle_log->from_xml($str).'<br />';
           }
           else
              $return .= 'ƒействи€ не обнаружены';

           if( !empty($log['abil'][$k]) )
           {           	    $return .= '<hr color=#ebebeb />';
           		foreach( $log['abil'][$k] as $d_str )
           		 $return .= '<font color=green>'.$battle_log->from_xml($d_str).'</font><br />';
           	     $return .= '<hr color=#ebebeb />';
           }
        }
     }

      $hited = @$db->SQL_result($db->query("SELECT hited FROM ".SQL_PREFIX."2battle_action WHERE Username = '".mysql_real_escape_string($_SESSION['login'])."' AND battle_id = '".intval($_GET['battle_id'])."';"),0,0);

      $return .= '<br /><br />Ќабито '.$hited.' поинтов. <a href="logs2.php?id='.$_GET['battle_id'].'" target="_blank">ѕолный лог.</a>';

  }

 die(php2js( array( 'team1' => $log['team1'], 'team2' => $log['team2'], 'log' => $return ) )); // отсылаем посредством магического json'a
}

if( !empty($_POST['act']) && $_POST['act'] == 'check' )
{	$player = new battle($_SESSION['login']);
	$player->is_blocked();

	$battle = $db->queryRow( "SELECT step, id, status, team1, team2 FROM ".SQL_PREFIX."2battle WHERE (team1 LIKE '%".$player->Username.";%' OR team2 LIKE '%".$player->Username.";%') AND id = '".$player->battle_id."' AND (status = 'during' OR status = 'completed') LIMIT 1;" );
	if( !$battle )  die( "<script>window.location.href='".$player->Room.".php';</script>" );

	$battle_log = new write_to_log($battle['id']);

    if( $battle['status'] == 'during' )
    {        //$team = $player->team == 1 ? 2 : 1;    	//$enemies = split( ';', $battle['team'.$team] );
        //array_pop($enemies);

        //if( !empty($enemies) )
        //{        	//foreach( $enemies as $k => $en )
        	//{
        		$enemy  = new battle($player->Enemy);               //print_r($enemies); echo '<br /><br />'; echo $en; echo '<br /><br />';




                //echo $next;

				$dead = @$db->SQL_result($db->query( "SELECT is_dead FROM ".SQL_PREFIX."2battle_action WHERE Username = '".$player->Username."' AND battle_id = '".$battle['id']."' LIMIT 1;" ),0,0);

    			if( $dead == 0 )
    			{    				if(
    				$Iam =
    				$db->queryRow( "
    				SELECT
    				   kick1, kick2, block1, block2, hit_time
    				FROM ".SQL_PREFIX."2battle_kicks
    				WHERE
    				   user_id = '".$player->Id."' AND target_id = '".$enemy->Id."' AND battle_id = '".$battle['id']."' LIMIT 1;" )
    				)
    				{  /// если € уже ударил
    	    			if(
    	    			$he =
	      	    		$db->queryRow( "
	       	    		SELECT
	       	    		   kick1, kick2, block1, block2 FROM ".SQL_PREFIX."2battle_kicks
	       	    		WHERE
	       	    		   user_id = '".$enemy->Id."' AND target_id = '".$player->Id."' AND battle_id = '".$battle['id']."' LIMIT 1;" )
         	    		)
         	    		{     	        	    	/// если противник ударил мен€

     	    	    	 	do_udar( $player, $enemy, Array( 1 => $Iam['kick1'], 2 => $Iam['kick2']), Array( 1 => $he['block1'], 2 => $he['block2'] ), $battle['step'] );
            	         	do_udar( $enemy, $player, Array( 1 => $he['kick1'], 2 => $he['kick2']), Array( 1 => $Iam['block1'], 2 => $Iam['block2'] ), $battle['step'] );

            	    		// уларили и грузим оп€ть kick_table
            	    		$db->execQuery( "DELETE FROM ".SQL_PREFIX."2battle_kicks WHERE user_id = '".$player->Id."' AND target_id = '".$enemy->Id."' AND battle_id = '".$player->battle_id."';" );
            	    		$db->execQuery( "DELETE FROM ".SQL_PREFIX."2battle_kicks WHERE user_id = '".$enemy->Id."' AND target_id = '".$player->Id."' AND battle_id = '".$player->battle_id."';" );
            	    		$db->update( SQL_PREFIX.'2battle', Array( 'step' => '[+]1' ), Array( 'id' => $player->battle_id, 'step' => $battle['step'], 'status' => 'during' ), 'maths' );
                            //$db->update( SQL_PREFIX.'2battle_action', Array( 'Enemy' => $next ), Array( 'Username' => $player->Username, 'battle_id' => $player->battle_id ) );


             	    		die( $player->load_pers_buttons() );


	     	   	 		}

       					///	если € бл€ть ударил а он не ударил и сидит пиздит по телефону целых мать их 45 секунд!
                		$rest_time = $Iam['hit_time'] + 45 - time();

                		if($rest_time >= 0) $echo = okon4( $rest_time, array( 'секунду.', 'секунды.', 'секунд.' ) );

	            		if( $rest_time <= 0 )
	            		{ // если пропиздел 45 секунд	 	             		$battle_log->add_log( get_date().$enemy->slogin( $enemy->Username, $enemy->Level, $enemy->id_clan ).' пропустил ход.', $battle['step'] );
                     		do_udar( $player, $enemy, Array( 1 => $Iam['kick1'], 2 => $Iam['kick2']), Array( 1 => '', 2 => '' ), $battle['step'] );
                    		//do_udar( $enemy, $player, Array( 1 => $he['kick1'], 2 => $he['kick2']), Array( 1 => $Iam['block1'], 2 => $Iam['block2'] ), $battle['step'] );


                    		$db->execQuery( "DELETE FROM ".SQL_PREFIX."2battle_kicks WHERE user_id = '".$player->Id."' AND target_id = '".$enemy->Id."' AND battle_id = '".$player->battle_id."';" );
                    		$db->execQuery( "DELETE FROM ".SQL_PREFIX."2battle_kicks WHERE user_id = '".$enemy->Id."' AND target_id = '".$player->Id."' AND battle_id = '".$player->battle_id."';" );
                    		$db->update( SQL_PREFIX.'2battle', Array( 'step' => '[+]1' ), Array( 'id' => $player->battle_id, 'step' => $battle['step'], 'status' => 'during' ), 'maths' );
                           // $db->update( SQL_PREFIX.'2battle_action', Array( 'Enemy' => $next ), Array( 'Username' => $player->Username, 'battle_id' => $player->battle_id ) );

 	                		//$db->execQuery( "DELETE FROM ".SQL_PREFIX."2battle_kicks WHERE user_id = '".$player->Id."' AND battle_id = '".$battle['id']."' AND step = '".$battle['step']."';" );                    		die( $player->load_pers_buttons() );

	            		}
	            		else  // если пропиздел меньше 45 секунд	 	            		include('../includes/system/waiting_kick.html');


        			}
        			else   //если € не ударил вообще  	       			  	$player->load_pers_buttons();


    			} // персонаж убит
    			else
    			{    				echo 'ƒл€ вас бой окончен. ќжидайте окончани€ поединка.';   					$win_team = completed_or_not_completed( $battle['id'], $battle['step'] );

 					switch( $win_team )
 					{
 						case 3: $battle_log->add_log( get_date().'<b>Ќичь€.</b>', $battle['step']+1 ); break;
 						case 2: $battle_log->add_log( get_date().'<b> оманда <font color="#6666ff">синих</font> победила.</b>', $battle['step']+1 ); break;
 						case 1: $battle_log->add_log( get_date().'<b> оманда <font color="#ff6666">красных</font> победила.</b>', $battle['step']+1 ); break;
 					}
    			}


            //}
        //}

  	}
  	else
  	{  		$db->update( SQL_PREFIX.'hp', Array( 'Time' => time() ), Array( 'Username' => $player->Username ) );  		$db->update( SQL_PREFIX.'players', Array( 'BattleID2' => 0 ), Array( 'Username' => $player->Username, 'BattleID2' => $player->battle_id ) ); 		$db->execQuery ( "DELETE FROM ".SQL_PREFIX."2battle_action WHERE Username = '".$player->Username."' AND battle_id = '".$player->battle_id."';" );

 		$db->update( SQL_PREFIX.'players', Array( 'BattleID2' => 0 ), Array( 'Reg_IP' => 'бот', 'BattleID2' => $player->battle_id ) );

 		$db->execQuery ( "DELETE 2ba FROM ".SQL_PREFIX."2battle_action as 2ba INNER JOIN ".SQL_PREFIX."players as p ON (p.Username = 2ba.Username) WHERE p.Reg_IP = 'бот' AND 2ba.battle_id = '".$player->battle_id."';" );
 		include( 'includes/battle2/battle_end.html' );
  	}




}




?>