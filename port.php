<?
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

session_start();
if (empty($_SESSION['login'])) { include_once('includes/bag_log_in.php'); exit; }

include_once ('includes/to_view.php');
include_once ('db_config.php');
include_once ('db.php');

include_once ('classes/PlayerInfo.php');

$player = new PlayerInfo();

$player->is_blocked();
$player->checkBattle();
$player->checkRoom('port');

$msg = '';
$_SESSION['msg'] = '';

if(!empty($_GET['goto']) && $_GET['goto'] == 'pl' ){
$player->gotoRoom();
}


$data = $db->queryRow( "SELECT * FROM ".SQL_PREFIX."more_players WHERE user_id = '".$player->user_id."';" );

if(!empty($_GET['goto']) && $_GET['goto'] == 'more' ){

if( !empty($data['lodka']) )
{	$player->gotoRoom( 'more', 'more' );
}
else
{	$msg = 'Нельзя выйти в море без лодки :)';
}

}



if( !empty($_GET['udochkabuy']) )
{	switch($_GET['udochkabuy']){
	case 4: $cost = 100; $nlevel = 5;  $name = 'удочку новичка'; break;
	case 3: $cost = 200; $nlevel = 25; $name = 'простую удочку'; break;
	case 2: $cost = 300; $nlevel = 50; $name = 'спиннинг'; break;
	case 1: $cost = 400; $nlevel = 80; $name = 'адронный уловитель'; break;
	default: die; break;
	}

    if( $player->Money < $cost ){ $msg = 'У вас недостаточно денег. Нужно '.$cost.' кр.';}
    elseif( $player->Level < $nlevel ){ $msg = 'Уровень маловат. Нужен '.$nlevel.'. Не подойдет.'; }
    else{
    $db->update( SQL_PREFIX.'players', Array( 'Money' => '[-]'.$cost ), Array( 'Id' => $player->user_id ), 'maths' );
	$db->execQuery( "INSERT INTO ".SQL_PREFIX."more_players (user_id, udochka) VALUES ('".$player->user_id."', '".intval($_GET['udochkabuy'])."') ON DUPLICATE KEY UPDATE udochka = '".intval($_GET['udochkabuy'])."';" );
    $msg = 'Вы успешно купили '.$name;
    $data['udochka'] = $_GET['udochkabuy'];
    }

}

if( !empty($_GET['buy']) )
{
	switch($_GET['buy']){
	case 4: $cost = 100; $name = 'старую лодка'; break;
	case 3: $cost = 200; $name = 'легкую лодка'; break;
	case 2: $cost = 300; $name = 'лодку'; break;
	case 1: $cost = 400; $name = 'улучшенную лодку'; break;
	default: die; break;
	}

    if( $player->Money < $cost ){ $msg = 'У вас недостаточно денег. Нужно '.$cost.' кр.';}
    else{    $db->update( SQL_PREFIX.'players', Array( 'Money' => '[-]'.$cost ), Array( 'Id' => $player->user_id ), 'maths' );
	$db->execQuery( "INSERT INTO ".SQL_PREFIX."more_players (user_id, lodka) VALUES ('".$player->user_id."', '".intval($_GET['buy'])."') ON DUPLICATE KEY UPDATE lodka = '".intval($_GET['buy'])."';" );
    $msg = 'Вы успешно купили '.$name;
    $data['lodka'] = $_GET['buy'];
    }


}

$player->heal();




require_once('_loader.php');

$tow_tpl->assignGlobal('db_config', $db_config);

$temp = & $tow_tpl->getDisplay('content', true);


$temp->assign( 'msg', $msg  );
$temp->assign( 'data', $data  );

if( file_exists( $db_config[DREAM]['web_root'] . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'elka.dat' ) )
{
	$file = file_get_contents( $db_config[DREAM]['web_root'] . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'elka.dat' );
	if( $file == $player->Room ) $temp->assign( 'elka', true  );
}

$temp->addTemplate('port', 'timeofwars_loc_port.html');


$show = & $tow_tpl->getDisplay('index');


$show->assign('title', 'Time Of Wars - Порт');
$show->assign('Content', $temp);


$show->addTemplate('header', 'header.html');
$show->addTemplate('index' , 'index.html' );
$show->addTemplate('footer', 'footer.html');


$tow_tpl->display();
?>
