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
$player->checkRoom('flower');

if(!empty($_GET['goto']) && $_GET['goto'] == 'pl' ){
$player->gotoRoom();
}

$player->heal();

@$_POST['user']     = speek_to_view($_POST['user']);
@$_POST['usersmsg'] = speek_to_view($_POST['usersmsg']);
$msg                = Array();

$dat = $db->queryArray("SELECT * FROM ".SQL_PREFIX."things_presentshop WHERE presentCOUNT > '0' ORDER BY presentPRICE ASC");

if( !empty($_POST) && !empty($_POST['user']) ){

foreach($_POST as $k => $v){


if($k == 'user'){ if( !$res = $db->queryCheck("SELECT Username FROM ".SQL_PREFIX."players WHERE Username = '".$_POST[$k]."'") ){ $msg[] = 'Такого персонажа не существует.'; } }
elseif($res && $k != 'usersmsg'){

list($var, $id, $cnt) = split('_', $v); $id = str_replace('i', '', $id);

if( !$data = $db->queryCheck("SELECT * FROM ".SQL_PREFIX."things_presentshop WHERE id = '$id'") ){ $msg[] = 'Такой вещи нет на складе'; }
elseif($data[5] < $cnt){ $msg[] = 'Такого количества "'.$data[1].'" нет на складе'; }
elseif($data[4]*$cnt > $player->Money){ $msg[] = 'Недостаточно денег для покупки "'.$data[1].'"'; }
else{

for($i = 1; $i <= $cnt; $i++){
$db->insert( SQL_PREFIX.'presents', Array( 'Player' => $res[0], 'presentName' => $data[1], 'presentIMG' => $data[2], 'presentDATE' => time(), 'presentMSG' => $_POST['usersmsg'], 'presentFROM' => $player->username ) );
$db->update( SQL_PREFIX.'players', Array( 'Money' => '[-]'.$data[4] ), Array( 'Username' => $player->username ), 'maths' );
$db->update( SQL_PREFIX.'things_presentshop', Array( 'presentCOUNT' => '[-]1' ), Array( 'id' => $id ), 'maths' );
$txt = '<i>Персонаж <b> '.$player->username.' </b> подарил вам <b> '.$data[1].' </b>(послано '.date('d.m.y H:i').')</i>';
$db->insert( SQL_PREFIX.'messages', Array( 'Username' => $res[0], 'Text' => $txt ) );
$player->Money -= $data[4];
}

$msg[1] = 'Подарки успешно доставлены';
}

}

}

}

require_once('_loader.php');

$tow_tpl->assignGlobal('db_config', $db_config);

$temp = & $tow_tpl->getDisplay('content', true);

$temp->assign( 'err',   implode( "\n<br />\n", $msg )   );
$temp->assign( 'Money', $player->Money                  );
$temp->assign( 'dat',   $dat                            );


//$temp->setCache('flower', 60);

//if (!$temp->isCached()) {
$temp->addTemplate('flower', 'timeofwars_loc_flower.html');
//}

$show = & $tow_tpl->getDisplay('index');


$show->assign('title', 'Time Of Wars - магазин подарков');
$show->assign('Content', $temp);


$show->addTemplate('header', 'header.html');
$show->addTemplate('index' , 'index.html' );
$show->addTemplate('footer', 'footer.html');


$tow_tpl->display();
?>
