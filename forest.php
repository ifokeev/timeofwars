<?
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

session_start();
if (empty($_SESSION['login'])) { include_once('includes/bag_log_in.php'); exit; }

include_once ('db_config.php');
include_once ('db.php');

include_once ('classes/PlayerInfo.php');

$player = new PlayerInfo();

$player->is_blocked();
$player->checkBattle();
$player->checkRoom('forest');

if(!empty($_GET['goto']) && $_GET['goto'] == 'pl' ){
$player->gotoRoom();
}

$player->heal();

$pic    = 0;
$err    = '';
$persid = $_SESSION['id_user'];
$woodc  = $db->queryRow("SELECT * FROM `".SQL_PREFIX."wood_g` WHERE persid = '$persid'");

if ($woodc) {

$nextt = $woodc['time'] + 58;
$i     = 1;
$num   = 0;
$pic   = $woodc['pict'];

if ($nextt < time('void')) {

//if (rand(0,100000) < 10000) {$gid[$i]   = 'vetka';     $gname[$i] = _FOREST_vetka;     $num++; $i++; }
if (rand(0,100000) < 500) { $gid[$i]   = 'grass1';    $gname[$i] = _FOREST_grass1;    $num++; $i++; }
if (rand(0,100000) < 500) { $gid[$i]   = 'grass2';    $gname[$i] = _FOREST_grass2;    $num++; $i++; }
if (rand(0,100000) < 100) { $gid[$i]   = 'jen-shen';  $gname[$i] = constant("_FOREST_jen-shen");  $num++; $i++; }
if (rand(0,100000) < 200) { $gid[$i]   = 'kalendula'; $gname[$i] = _FOREST_kalendula; $num++; $i++; }
if (rand(0,100000) < 400) { $gid[$i]   = 'vasilek';   $gname[$i] = _FOREST_vasilek;   $num++; $i++; }
if (rand(0,100000) < 100) { $gid[$i]   = 'vetrenica'; $gname[$i] = _FOREST_vetrenica; $num++; $i++; }
if (rand(0,100000) < 100) { $gid[$i]   = 'sumka';     $gname[$i] = _FOREST_sumka;     $num++; $i++; }
if (rand(0,100000) < 100) { $gid[$i]   = 'hmel';      $gname[$i] = _FOREST_hmel;      $num++; $i++; }
if (rand(0,100000) < 400) { $gid[$i]   = 'devatisil'; $gname[$i] = _FOREST_devatisil; $num++; $i++; }
if (rand(0,100000) < 500) { $gid[$i]   = 'mak';       $gname[$i] = _FOREST_mak;       $num++; $i++; }
if (rand(0,100000) < 100) { $gid[$i]   = 'shalf';     $gname[$i] = _FOREST_shalf;     $num++; $i++; }
if (rand(0,100000) < 5) {   $gid[$i]   = 'shalf_r';   $gname[$i] = _FOREST_shalf_r;   $num++; $i++; }
if (rand(0,100000) < 500) { $gid[$i]   = 'veresk';    $gname[$i] = _FOREST_veresk;    $num++; $i++; }
if (rand(0,100000) < 100) { $gid[$i]   = 'sandal';    $gname[$i] = _FOREST_sandal;    $num++; $i++; }
if (rand(0,100000) < 200) { $gid[$i]   = 'valer';     $gname[$i] = _FOREST_valer;     $num++; $i++; }
if (rand(0,100000) < 200) { $gid[$i]   = 'vanil';     $gname[$i] = _FOREST_vanil;     $num++; $i++; }
if (rand(0,100000) < 500) { $gid[$i]   = 'durman';    $gname[$i] = _FOREST_durman;    $num++; $i++; }
if (rand(0,100000) < 400) { $gid[$i]   = 'pustir';    $gname[$i] = _FOREST_pustir;    $num++; $i++; }
if (rand(0,100000) < 500) { $gid[$i]   = 'muhomor';   $gname[$i] = _FOREST_muhomor;   $num++; $i++; }
if (rand(0,100000) < 500) { $gid[$i]   = 'lisichka';  $gname[$i] = _FOREST_lisichka;  $num++; $i++; }
if (rand(0,100000) < 500) { $gid[$i]   = 'siroezka';  $gname[$i] = _FOREST_siroezka;  $num++; $i++; }
if (rand(0,100000) < 500) { $gid[$i]   = 'opata';     $gname[$i] = _FOREST_opata;     $num++; $i++; }
if (rand(0,100000) < 500) { $gid[$i]   = 'krasnyi';   $gname[$i] = _FOREST_krasnyi;   $num++; $i++; }
if (rand(0,100000) < 500) { $gid[$i]   = 'maslenok';  $gname[$i] = _FOREST_maslenok;  $num++; $i++; }
if (rand(0,100000) < 2) {   $gid[$i]   = 'rose_g';    $gname[$i] = _FOREST_rose_g;    $num++; $i++; }


if ($num > 0) {


$sel = rand(1, $num);

if (!$db->numrows("SELECT * FROM `".SQL_PREFIX."things` WHERE Owner = '$player->username' AND Id = 'items/$gid[$sel]'")) { $db->insert( SQL_PREFIX.'things', Array( 'Owner' => $player->username, 'Id' => 'items/'.$gid[$sel], 'Thing_Name' => $gname[$sel], 'Slot' => '15', 'Cost' => '1', 'Count' => '1', 'NOWwear' => '0', 'MAXwear' => '1' ) ); }
else{                                                                                                       $db->execQuery("UPDATE `".SQL_PREFIX."things` SET Count = Count + '1' WHERE Owner = '$player->username' AND Id = 'items/$gid[$sel]'"); }


$err = sprintf(_FOREST_err1, $gid[$sel], $gname[$sel]);
$db->insert( SQL_PREFIX.'messages', Array( 'Username' => $_SESSION['login'], 'Text' => 'Вы нашли <b>'.$gname[$sel].'</b>' ) );

} else { $err = _FOREST_err2; }

if ($woodc['pict'] > 9) { $db->update( SQL_PREFIX.'wood_g', Array( 'pict' => '1' ), Array( 'persid' => $persid ) );         }
else {                    $db->update( SQL_PREFIX.'wood_g', Array( 'pict' => '[+]1' ), Array( 'persid' => $persid ), 'maths' ); }
                          $db->update( SQL_PREFIX.'wood_g', Array( 'time' => time('void') ), Array( 'persid' => $persid ) );
}

}

if (!empty($_GET['act']) && $_GET['act'] == 'stop') { $db->execQuery("DELETE FROM `".SQL_PREFIX."wood_g` WHERE persid = '$persid'"); $woodc = false; }

if (!empty($_GET['act']) && $_GET['act'] == 'start') {

if (!$woodc) {
$sapc = $db->queryRow("SELECT * FROM `".SQL_PREFIX."things` WHERE (Owner = '$player->username') AND (Id = 'lessapogi') AND (Wear_ON = '1')");
if ($sapc) { $db->insert( SQL_PREFIX.'wood_g', Array( 'persid' => $persid, 'time' => time('void'), 'pict' => '1' ) ); $woodc = true; $pic = 1; } else { $err = _FOREST_err3; }
}

}


require_once('_loader.php');

$tow_tpl->assignGlobal('db_config', $db_config);

$temp = & $tow_tpl->getDisplay('content', true);

$temp->assign( 'woodc', $woodc );
$temp->assign( 'err',   $err   );
$temp->assign( 'pic',   $pic   );

if( file_exists( $db_config[DREAM]['web_root'] . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'elka.dat' ) )
{
	$file = file_get_contents( $db_config[DREAM]['web_root'] . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'elka.dat' );
	if( $file == $player->Room ) $temp->assign( 'elka', true  );
}

//$temp->setCache('forest', 60);

if (!$temp->isCached()) {
$temp->addTemplate('forest', 'timeofwars_loc_forest.html');
}

$show = & $tow_tpl->getDisplay('index');


$show->assign('title', 'Time Of Wars - волшебный лес');
$show->assign('Content', $temp);


$show->addTemplate('header', 'header.html');
$show->addTemplate('index' , 'index.html' );
$show->addTemplate('footer', 'footer.html');


$tow_tpl->display();
?>
