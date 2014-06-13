<?php
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

include_once('../db_config.php');
include_once('../db.php');

$res = $db->queryArray("SELECT i.Type2, i.Type3, p.Username, i.Time FROM ".SQL_PREFIX."inv as i INNER JOIN ".SQL_PREFIX."players as p ON(p.Username = i.Username)");

if(!empty($res))
{	foreach($res as $v)
	{		if( time() > $v['Time'] )
		{			$type3 = $v['Type3'];
			$type2 = $v['Type2'];
			switch( $type2 )
			{				case 1: $db->update( SQL_PREFIX.'players', Array( 'Stre' => '[+]'.$type3 ), Array( 'Username' => $v['Username'] ), 'maths' ); break;
				case 2: $db->update( SQL_PREFIX.'players', Array( 'Agil' => '[+]'.$type3 ), Array( 'Username' => $v['Username'] ), 'maths' ); break;
				case 3: $db->update( SQL_PREFIX.'players', Array( 'Intu' => '[+]'.$type3 ), Array( 'Username' => $v['Username'] ), 'maths' ); break;
			}

			$query = sprintf("DELETE FROM ".SQL_PREFIX."inv WHERE Username = '%s';", $v['Username'] );
			$db->execQuery($query, "User_healTrauma_2");	     }
    }

}

?>
