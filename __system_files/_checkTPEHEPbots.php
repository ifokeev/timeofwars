<?php
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

include_once('../db_config.php');
include_once('../db.php');

$res = $db->queryArray("SELECT Username, BattleID FROM ".SQL_PREFIX."players WHERE Username LIKE '������_%' AND BattleID != '' AND Reg_Ip = '���'");
if( !empty($res) ){
foreach($res as $v)
{
	{
		{
			{
				{
				}
				else
				{
	            }
            }

            $db->update( SQL_PREFIX.'battle_list', Array( 'is_finished' => 1, 'Dead' => 1 ), Array( 'Id' => $v['BattleID'] ) );
            }
	    }
	    else
	    {
	    	{
	    		{
	    			$db->update( Array( 'BattleID' => '' ), Array( 'Username' => $action['Enemy'], 'BattleID' => $v['BattleID'] ) );
	    			$db->execQuery( "DELETE FROM ".SQL_PREFIX."battle_action WHERE Id = '".$v['BattleID']."';" );
	    		}
	    		elseif( preg_match( '/������_/i', $action['Enemy'] ) )
	    		{
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