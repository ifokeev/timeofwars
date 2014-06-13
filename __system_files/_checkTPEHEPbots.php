<?php
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

include_once('../db_config.php');
include_once('../db.php');

$res = $db->queryArray("SELECT Username, BattleID FROM ".SQL_PREFIX."players WHERE Username LIKE 'Тренер_%' AND BattleID != '' AND Reg_Ip = 'бот'");
if( !empty($res) ){
foreach($res as $v)
{	if( $b_list = $db->queryArray("SELECT Player FROM ".SQL_PREFIX."battle_list WHERE Id = '".$v['BattleID']."' AND is_finished = '0';") )
	{		if( !$action = $db->queryRow( "SELECT Player, Enemy, Time FROM ".SQL_PREFIX."battle_action WHERE Id = '".$v['BattleID']."';" ) )
		{			if( !empty($b_list) ){			foreach( $b_list as $list )
			{				if( preg_match( '/Тренер_/i', $list['Player'] ) )
				{					$db->execQuery( "DELETE FROM ".SQL_PREFIX."players WHERE Username = '".$list['Player']."' AND Reg_Ip = 'бот' AND Username LIKE 'Тренер_%';" );
				}
				else
				{					$db->update( Array( 'BattleID' => '' ), Array( 'Username' => $list['Player'], 'BattleID' => $v['BattleID'] ) );
	            }
            }

            $db->update( SQL_PREFIX.'battle_list', Array( 'is_finished' => 1, 'Dead' => 1 ), Array( 'Id' => $v['BattleID'] ) );
            }
	    }
	    else
	    {	    	if( time('void') - $action['Time'] >= 10800 )
	    	{	    		if( preg_match( '/Тренер_/i', $action['Player'] ) )
	    		{	    			$db->execQuery( "DELETE FROM ".SQL_PREFIX."players WHERE Username = '".$action['Player']."' AND Reg_Ip = 'бот' AND Username LIKE 'Тренер_%';" );
	    			$db->update( Array( 'BattleID' => '' ), Array( 'Username' => $action['Enemy'], 'BattleID' => $v['BattleID'] ) );
	    			$db->execQuery( "DELETE FROM ".SQL_PREFIX."battle_action WHERE Id = '".$v['BattleID']."';" );
	    		}
	    		elseif( preg_match( '/Тренер_/i', $action['Enemy'] ) )
	    		{	    			$db->execQuery( "DELETE FROM ".SQL_PREFIX."players WHERE Username = '".$action['Enemy']."' AND Reg_Ip = 'бот' AND Username LIKE 'Тренер_%';" );
	    			$db->update( Array( 'BattleID' => '' ), Array( 'Username' => $action['Player'], 'BattleID' => $v['BattleID'] ) );
	    			$db->execQuery( "DELETE FROM ".SQL_PREFIX."battle_action WHERE Id = '".$v['BattleID']."';" );
	    		}

	    		$db->update( SQL_PREFIX.'battle_list', Array( 'is_finished' => 1, 'Dead' => 1 ), Array( 'Id' => $v['BattleID'] ) );
	        }
	     }


	}
}
}
?>