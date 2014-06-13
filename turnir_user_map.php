<?
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

session_start();
if (empty($_SESSION['login'])) { include_once('includes/bag_log_in.php'); exit; }
//header( 'Content-type: text/html; charset=windows-1251;' );
include_once ('includes/to_view.php');
include_once ('db_config.php');
include_once ('db.php');

include_once ('classes/PlayerInfo.php');

$player = new PlayerInfo();

/*
$fold = array( 3 => 'броня', 8 => 'перчи', 10 => 'сапоги', 7 => 'шлемы', 2 => 'оружие', 9 => 'щиты' );

foreach( $fold as $key => $folder  ){
$i = 0;
	$files = scandir($db_config[DREAM_IMAGES]['web_root'].'/turnir/'.$folder);
	foreach($files as $file)
	{
		if (preg_match("/.gif/i", $file))
		{			$i++;
			$file = str_replace( '.gif', '', $file );

			for( $n=1; $n <= 5; $n++ ){
			$uvorot  = rand( 0,100 ) >= rand( 0, 100 ) ? rand( 1, mt_rand( 2, 70 ) ) : 0;
			$auvorot = rand( 0,100 ) >= rand( 0, 100 ) ? rand( 1, mt_rand( 2, 70 ) ) : 0;
			$krit    = rand( 0,100 ) >= rand( 0, 100 ) ? rand( 1, mt_rand( 2, 70 ) ) : 0;
			$akrit   = rand( 0,100 ) >= rand( 0, 100 ) ? rand( 1, mt_rand( 2, 70 ) ) : 0;
			$arm1    = rand( 0,100 ) >= rand( 0, 100 ) ? rand( 1,10 ) : 0;
			$arm2    = rand( 0,100 ) >= rand( 0, 100 ) ? rand( 1,10 ) : 0;
			$arm3    = rand( 0,100 ) >= rand( 0, 100 ) ? rand( 1,10 ) : 0;
			$arm4    = rand( 0,100 ) >= rand( 0, 100 ) ? rand( 1,10 ) : 0;
			}
			$min_dmg = 0;
			$max_dmg = 0;
			$slot    = $key;

			switch( $slot )
			{				case 9: $name = 'Щит'; break;
				case 2:

				$name = 'Оружие';
				$min_dmg = mt_rand( 0, mt_rand(1, 30) );
				$max_dmg = mt_rand( $min_dmg, mt_rand( $min_dmg, 100 ) );
				$arm1 = 0;
				$arm2 = 0;
				$arm3 = 0;
				$arm4 = 0;


				break;				case 3: $name = 'Броня'; break;
				case 8:  $name = 'Перчи'; break;
				case 10:  $name = 'Сапоги'; break;
				case 7:  $name = 'Шлем'; break;
	        }


	$file1 = fopen( $db_config[DREAM]['web_root'] . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'turnir' . DIRECTORY_SEPARATOR . 'things.dat', 'a' );
	fwrite( $file1, ''.$name.' для турнира №'.$i.';'.$file.';'.$slot.';'.$uvorot.';'.$auvorot.';'.$krit.';'.$akrit.';'.$arm1.';'.$arm2.';'.$arm3.';'.$arm4.';'.$min_dmg.';'.$max_dmg.';'."\n" );
	fclose( $file1 );


          echo $file . ' - '.$key.' OK<br />';


		}
	}
	next($fold);
}




die;
*/

$player->is_blocked();
$player->checkBattle();
$player->checkRoom('turnir_map');


$player->heal();

$us_data = $db->queryRow( "SELECT tu.* FROM ".SQL_PREFIX."turnir as t LEFT JOIN ".SQL_PREFIX."turnir_users as tu ON ( t.id = tu.turnir_id ) WHERE tu.user = '".$player->username."' AND t.status = '2';" );
if( !$us_data )
{	die( $player->gotoRoom( 'turnir', 'turnir' ) );
}

$emptys = $db->queryArray( "SELECT tu.coord, tu.user FROM ".SQL_PREFIX."turnir as t LEFT JOIN ".SQL_PREFIX."turnir_users as tu ON ( t.id = tu.turnir_id ) WHERE tu.turnir_id = '".$us_data['turnir_id']."' AND tu.user <> '".$player->username."' AND t.status = '2';" );

$map     = file_get_contents( $db_config[DREAM]['web_root'] . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'turnir' . DIRECTORY_SEPARATOR . 'map.txt' );
$n_cages = split( "\n", $map );
$n_cages = split( ';', $n_cages[0] );

$map = str_replace("\n", ";", $map);
$map = split( ';', $map );

$rows = file( $db_config[DREAM]['web_root'] . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'turnir' . DIRECTORY_SEPARATOR . 'map.txt' );


require_once('_loader.php');

$tow_tpl->assignGlobal('db_config', $db_config);

$temp = & $tow_tpl->getDisplay('content', true);


$temp->assign( 'map', $map  );
$temp->assign( 'rows', $rows  );
$temp->assign( 'data', $us_data  );
$temp->assign( 'emptys', $emptys  );
$temp->assign( 'n_cages', count($n_cages) );


$temp->addTemplate('port', 'timeofwars_loc_turnir_map_foruser.html');


$show = & $tow_tpl->getDisplay('index');


$show->assign('title', 'Time Of Wars - Сердце леса');
$show->assign('Content', $temp);


$show->addTemplate('header', 'header_noframes.html');
$show->addTemplate('index' , 'index.html' );
$show->addTemplate('footer', 'footer.html');


$tow_tpl->display();
?>
