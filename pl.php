<?
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

session_start();
if (empty($_SESSION['login'])) { include_once('includes/bag_log_in.php'); exit; }

include_once ('db_config.php');
include_once ('db.php');

include_once ('classes/PlayerInfo.php');
include_once ('classes/ChatSendMessages.php');

$player = new PlayerInfo();

$player->is_blocked();
$player->checkBattle();
$player->checkRoom('pl');

if(!empty($_GET['goto']) && ($_GET['goto'] == 'turnir' || $_GET['goto'] == 'port' || $_GET['goto'] == 'main' || $_GET['goto'] == 'shop' || $_GET['goto'] == 'euroshop' || $_GET['goto'] == 'comission' || $_GET['goto'] == 'repair' || $_GET['goto'] == 'temple' || $_GET['goto'] == 'forest' || $_GET['goto'] == 'casino' || $_GET['goto'] == 'mount' || $_GET['goto'] == 'tavern' || $_GET['goto'] == 'hospital' || $_GET['goto'] == 'flower' || $_GET['goto'] == 'cl' || $_GET['goto'] == 'apteka' || $_GET['goto'] == 'land') ){
$player->gotoRoom( $_GET['goto'], $_GET['goto'] );
}

$player->heal();
$player->checklevelup();


function add_msg ( $msg )
{
	global $db_config;

	$files = scandir($db_config[DREAM]['web_root'].'/chat');
	foreach($files as $file)
	{
		if (preg_match("/.txt/i", $file))
		{
			$file = str_replace( '.txt', '', $file );

			$chat = new ChatSendMessages('Подарки', $file);
			$chat->sendMessage( '<font color="red">Подарки</font>', $msg );
		}
	}


}

function slogin( $user, $lvl, $clanid )
{   global $db_config;
    $r = '';
	if( !empty($clanid) ) $r .= '<a href="http://'.$db_config[DREAM]['server'].'/top5.php?show='.$clanid.'" target="_blank"><img src="http://'.$db_config[DREAM_IMAGES]['server'].'/clan/'.$clanid.'.gif" /></a>';

	$r .= '<a href="http://'.$db_config[DREAM]['server'].'/inf.php?uname='.$user.'" target="_blank">'.$user.'</a> ['.$lvl.']';
	return $r;
}

$present = $db->queryArray( "SELECT erp.id, erp.podarok_from_user, erp.podarok_comment, t.Un_Id, t.Thing_Name FROM ".SQL_PREFIX."elka_reit_presents as erp INNER JOIN ".SQL_PREFIX."things as t ON (t.Un_Id = erp.podarok_id) WHERE erp.podarok_for_user = '".$player->username."';");

if( !empty($_GET['act']) && $_GET['act'] == 'podarok' )
{
   if( !empty($present) )
   {   	  foreach($present as $v)
   	  {   	  	  list( $user, $lvl, $clanid ) = $db->queryCheck( "SELECT Username, Level, ClanID FROM ".SQL_PREFIX."players WHERE Username = '".$v['podarok_from_user']."';" );   	  	  add_msg( slogin($player->username, $player->Level, $player->id_clan).' получил от '.slogin($user, $lvl, $clanid).' <a href="http://'.$db_config[DREAM]['server'].'/thing.php?thing='.$v['Un_Id'].'" target="_blank">'.$v['Thing_Name'].'.</a> '.(!empty($v['podarok_comment']) ? 'На подарке записка: '.$v['podarok_comment'].'.' : '') );          $player->add_anket( $user, 'получил <a href="http://'.$db_config[DREAM]['server'].'/thing.php?thing='.$v['Un_Id'].'" target="_blank">'.$v['Thing_Name'].'.</a> на новый год.' );
          $db->update( SQL_PREFIX.'things', Array( 'Owner' => $player->username ), Array( 'Un_Id' => $v['Un_Id'], 'Owner' => 'Ёлка' ) );
          $db->execQuery( "DELETE FROM ".SQL_PREFIX."elka_reit_presents WHERE podarok_for_user = '".$player->username."' AND id = '".$v['id']."';" );
   	  }
   }
   $present = false;
}
//if(!empty($_GET['act']) && $_GET['act'] == 'present'){
//echo "<script>alert('Дед мороз уехал в Великий Устюг, забрав с собой все подарки :(');</script>";//include_once('includes/system/elka.php');
//}


require_once('_loader.php');

$tow_tpl->assignGlobal('db_config', $db_config);

$temp =& $tow_tpl->getDisplay('content', true);

//$temp->assign( 'clanid', $player->id_clan  );
if( file_exists( $db_config[DREAM]['web_root'] . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'elka.dat' ) )
{
	$file = file_get_contents( $db_config[DREAM]['web_root'] . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'elka.dat' );
	if( $file == $player->Room ) $temp->assign( 'elka', true  );
}

$temp->assign( 'user', $player->username  );
$temp->assign( 'present', $present  );



//$temp->assign( 'vetka_cnt', $db->SQL_result($db->query( "SELECT SUM(vetki) FROM ".SQL_PREFIX."elka_reit" ),0)  );
//$temp->assign( 'toys_cnt', $db->SQL_result($db->query( "SELECT SUM(toys) FROM ".SQL_PREFIX."elka_reit" ),0)  );
//$temp->setCache('pl', 86400);

//if (!$temp->isCached()) {
$temp->addTemplate('pl', '_timeofwars_main_pl.html');
//}

$show =& $tow_tpl->getDisplay('index');


$show->assign('title', 'Time Of Wars - главная площадь');
$show->assign('Content', $temp);


$show->addTemplate('header', 'header.html');
$show->addTemplate('index' , 'index.html' );
$show->addTemplate('footer', 'footer.html');


$tow_tpl->display();
?>
