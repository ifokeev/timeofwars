<?
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

session_start();
if (empty($_SESSION['login'])): include_once('includes/bag_log_in.php'); exit; endif;

include_once ('db_config.php');
include_once ('db.php');

include_once ('classes/PlayerInfo.php');

$player = new PlayerInfo();

$player->is_blocked();
$player->checkBattle();
$player->checkRoom('tavern');

if(!empty($_GET['goto']) && $_GET['goto'] == 'pl' ):
$player->gotoRoom();
endif;

$msg = '';

$player->heal();

$alco = Array( 'Alco' => 0, 'Stre_add' => 0, 'Agil_add' => 0, 'Intu_add' => 0 );
$txt  = Array( 'Stre_add_txt' => '', 'Agil_add_txt' => '', 'Intu_add_txt' => '' );


$res = $db->queryFetchArray("SELECT id, Time, Num, Alco FROM ".SQL_PREFIX."drunk WHERE Username = '$player->username'");

if(!empty($res)):
foreach($res as $v):

list($Stre_add, $Agil_add, $Intu_add) = split (';', $v[2]);

$alco['Stre_add']  += $Stre_add;
$alco['Agil_add']  += $Agil_add;
$alco['Intu_add']  += $Intu_add;
$alco['Alco']      += $v[3];

$del = Array( 'Id' => $_SESSION['id_user'] );

if( !empty($Stre_add) ){ $del['Stre'] = '[-]'.$Stre_add; }
if( !empty($Agil_add) ){ $del['Agil'] = '[-]'.$Agil_add; }
if( !empty($Intu_add) ){ $del['Intu'] = '[-]'.$Intu_add; }

if(time() >= $v[1]):
$db->update( SQL_PREFIX.'players', $del, Array( 'Username' => $player->username ), 'maths' );
$db->execQuery("DELETE FROM ".SQL_PREFIX."drunk WHERE id = '$v[0]' AND Username = '$player->username' AND Time <= '".time()."'");
$db->insert( SQL_PREFIX.'messages', Array( 'Username' => $player->username, 'Text' => '<font color="red">Внимание!</font> Действие эликсира закончилось.' ) );
endif;

endforeach;
endif;

unset($res);

if($alco['Stre_add'] > 0): $txt['Stre_add_txt'] = '<font color=green>(+'.$alco['Stre_add'].')</font>'; elseif($alco['Stre_add'] < 0): $txt['Stre_add_txt'] = '<font color=red>('.$alco['Stre_add'].')</font>'; endif;
if($alco['Agil_add'] > 0): $txt['Agil_add_txt'] = '<font color=green>(+'.$alco['Agil_add'].')</font>'; elseif($alco['Agil_add'] < 0): $txt['Agil_add_txt'] = '<font color=red>('.$alco['Agil_add'].')</font>'; endif;
if($alco['Intu_add'] > 0): $txt['Intu_add_txt'] = '<font color=green>(+'.$alco['Intu_add'].')</font>'; elseif($alco['Intu_add'] < 0): $txt['Intu_add_txt'] = '<font color=red>('.$alco['Intu_add'].')</font>'; endif;

////////

if(!empty($_GET['buyelik']) && is_numeric($_GET['buyelik']) && (!empty($_GET['tmp']) && $_GET['tmp'] <= time()+60 && $_GET['tmp'] >= time()-60) ):

if( $dat = $db->queryRow("SELECT * FROM ".SQL_PREFIX."drinks WHERE drinkid = '".intval($_GET['buyelik'])."'") ):
if( (100-$alco['Alco']) >= $dat['Alco'] ):
if( $player->Money >= $dat['Cost'] ):


$add = '';
if(!empty($dat['Stre'])): $add .= ", Stre = Stre + '".$dat['Stre']."' "; endif;
if(!empty($dat['Agil'])): $add .= ", Agil = Agil + '".$dat['Agil']."' "; endif;
if(!empty($dat['Intu'])): $add .= ", Intu = Intu + '".$dat['Intu']."' "; endif;

$db->execQuery("UPDATE ".SQL_PREFIX."players SET Money = Money - '".$dat['Cost']."' $add WHERE Username = '$player->username'");
$db->insert( SQL_PREFIX.'drunk', Array( 'Username' => $player->username, 'Stat' => 'Stre;Agil;Intu', 'Num' => $dat['Stre'].';'.$dat['Agil'].';'.$dat['Intu'], 'Time' => (time()+($dat['Time']*60)), 'Alco' => $dat['Alco'] ) );

$player->Stre     += $dat['Stre'];
$player->Agil     += $dat['Agil'];
$player->Intu     += $dat['Intu'];
$player->Money    -= $dat['Cost'];

$alco['Alco']     += $dat['Alco'];
$alco['Stre_add'] += $dat['Stre'];
$alco['Agil_add'] += $dat['Agil'];
$alco['Intu_add'] += $dat['Intu'];


if($alco['Stre_add'] > 0): $txt['Stre_add_txt'] = '<font color=green>(+'.$alco['Stre_add'].')</font>'; elseif($alco['Stre_add'] < 0): $txt['Stre_add_txt'] = '<font color=red>('.$alco['Stre_add'].')</font>'; endif;
if($alco['Agil_add'] > 0): $txt['Agil_add_txt'] = '<font color=green>(+'.$alco['Agil_add'].')</font>'; elseif($alco['Agil_add'] < 0): $txt['Agil_add_txt'] = '<font color=red>('.$alco['Agil_add'].')</font>'; endif;
if($alco['Intu_add'] > 0): $txt['Intu_add_txt'] = '<font color=green>(+'.$alco['Intu_add'].')</font>'; elseif($alco['Intu_add'] < 0): $txt['Intu_add_txt'] = '<font color=red>('.$alco['Intu_add'].')</font>'; endif;

$msg = $dat['name'].' удачно выпит :)';


else: $msg = 'Недостаточно денег'; endif;
else: $msg = 'Нельзя выпить больше,<br /> чем позволяет процент опьянения.'; endif;
else: $msg = 'Такого эликсира не существует'; endif;

endif;



$r = $db->queryArray('SELECT * FROM '.SQL_PREFIX.'drinks ORDER by Cost');

require_once('_loader.php');

$tow_tpl->assignGlobal('db_config', $db_config);

$temp = & $tow_tpl->getDisplay('content', true);

$temp->assign( 'r',      $r       );
$temp->assign( 'msg',    $msg     );
$temp->assign( 'player', $player  );
$temp->assign( 'item',   $player->getItemsInfo( $player->username ) );

$temp->assign( 'txt',    $txt );
$temp->assign( 'Alco',   $alco['Alco']    );

//$temp->setCache('tavern', 60);

//if (!$temp->isCached()) {
$temp->addTemplate('tavern', 'timeofwars_loc_tavern.html');
//}

$show = & $tow_tpl->getDisplay('index');


$show->assign('title', 'Time Of Wars - таверна');
$show->assign('Content', $temp);


$show->addTemplate('header', 'header.html');
$show->addTemplate('index' , 'index.html' );
$show->addTemplate('footer', 'footer.html');


$tow_tpl->display();
?>
