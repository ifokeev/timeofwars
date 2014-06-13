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
$player->checkRoom('euroshop');

if(!empty($_GET['goto']) && $_GET['goto'] == 'pl' ){
$player->gotoRoom();
}

$player->heal();

if ($player->clanid == 200) { die(_chaosERR); }

$err                  = '';
@$buy                 = speek_to_view($_GET['buy']);
@$otdel               = intval($_GET['otdel']);
@$_POST['wanttoconv'] = floatval($_POST['wanttoconv']);

if(empty($otdel)){ $otdel = 1; }

$Money = $db->SQL_result($db->query("SELECT Euro FROM `".SQL_PREFIX."bank_acc` WHERE Username = '$player->username'"));
if( empty($Money) )
{	$Money = '0.00';
}


if( !empty($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] == 'du' )
{	if( $Money < 0.7 ) { $err = _SHOP_ERR2; }
	elseif( $db->queryCheck( "SELECT Time, for_time FROM ".SQL_PREFIX."sms_3uron WHERE Username = '".$player->username."';" ) ) { $err = 'Для вас уже установлен "Тройной урон"'; }
	else{	$db->execQuery("INSERT INTO ".SQL_PREFIX."sms_2uron ( Username, Time, for_time ) VALUES ('".$player->username."', '".time()."', '1') ON DUPLICATE KEY UPDATE Time = '".time()."';");

	$db->insert( SQL_PREFIX.'transfer', Array( 'Date' => date('Y-m-d'), 'From' => '(ability)', 'To' => $player->username, 'What' => 'установлен 2ой урон на 1 час через заморскую лавку за 0.7 екр ('.date('H:i').')' ) );
	$txt = '<i>Почта от <b> (ability) </b> (послано '.date('d.m.y H:i').'):</i> Теперь ровно 1 час для вас работает двойной урон.';
	$db->insert( SQL_PREFIX.'messages', Array( 'Username' => $player->username, 'Text' => mysql_escape_string($txt) ) );

	$db->update( SQL_PREFIX.'bank_acc', Array( 'Euro' => '[-]0.7' ), Array( 'Username' => $player->username ), 'maths' );
	$Money -= 0.7;
	}
}
elseif( !empty($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] == 'tu' )
{	if( $Money < 2 ) { $err = _SHOP_ERR2; }
	elseif( $db->queryCheck( "SELECT Time, for_time FROM ".SQL_PREFIX."sms_2uron WHERE Username = '".$player->username."';" ) ) { $err = 'Для вас уже установлен "Двойной урон"'; }
	else{	$db->execQuery("INSERT INTO ".SQL_PREFIX."sms_3uron ( Username, Time, for_time ) VALUES ('".$player->username."', '".time()."', '1') ON DUPLICATE KEY UPDATE Time = '".time()."';");

	$db->insert( SQL_PREFIX.'transfer', Array( 'Date' => date('Y-m-d'), 'From' => '(ability)', 'To' => $player->username, 'What' => 'установлен 3ой урон на 1 час через заморскую лавку за 2 екр ('.date('H:i').')' ) );
	$txt = '<i>Почта от <b> (ability) </b> (послано '.date('d.m.y H:i').'):</i> Теперь ровно 1 час для вас работает тройной урон.';
	$db->insert( SQL_PREFIX.'messages', Array( 'Username' => $player->username, 'Text' => mysql_escape_string($txt) ) );

	$db->update( SQL_PREFIX.'bank_acc', Array( 'Euro' => '[-]2' ), Array( 'Username' => $player->username ), 'maths' );
	$Money -= 2;
	}}
elseif( !empty($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] == 'fullhp' )
{	if( $Money < 0.05 ) { $err = _SHOP_ERR2; }
	else{	$db->execQuery( "UPDATE ".SQL_PREFIX."players SET hpnow = hpall WHERE Username = '".$player->username."';" );
	$db->insert( SQL_PREFIX.'transfer', Array( 'Date' => date('Y-m-d'), 'From' => '(ability)', 'To' => $player->username, 'What' => 'пополнил здоровье за 0.05 екр ('.date('H:i').')' ) );
	$txt = '<i>Почта от <b> (ability) </b> (послано '.date('d.m.y H:i').'):</i> Теперь у вас полное здоровье.';
	$db->insert( SQL_PREFIX.'messages', Array( 'Username' => $player->username, 'Text' => mysql_escape_string($txt) ) );
	$db->update( SQL_PREFIX.'bank_acc', Array( 'Euro' => '[-]0.05' ), Array( 'Username' => $player->username ), 'maths' );
	$Money -= 0.05;
	}
}

if( !empty($_GET['upgrade']) && is_numeric($_GET['upgrade']) )
{	$dat = $db->queryRow("SELECT * FROM `".SQL_PREFIX."things` WHERE Thing_Name LIKE '%(артефакт)%' AND Owner = '".$player->username."' AND Wear_ON = '0' AND Un_Id = '".intval($_GET['upgrade'])."'");
    if (!$dat) { $err = _SHOP_ERR1; }
    elseif ( sprintf ("%.2f", ($dat['Cost']/15*0.05) ) > $Money) { $err = _SHOP_ERR2; }
    else
    {    	$db->update( SQL_PREFIX.'things',
    	Array(
    	'Level_need' => '[+]1',
    	'Endu_add' => ceil($dat['Endu_add']+$dat['Endu_add']*0.05),
    	'Cost' => ceil($dat['Cost']+$dat['Cost']*0.05),
    	'MINdamage' => ceil($dat['MINdamage']+$dat['MINdamage']*0.05),
    	'MAXdamage' => ceil($dat['MAXdamage']+$dat['MAXdamage']*0.05),
    	'Crit' => ceil($dat['Crit']+$dat['Crit']*0.05),
    	'AntiCrit' => ceil($dat['AntiCrit']+$dat['AntiCrit']*0.05),
    	'Uv' => ceil($dat['Uv']+$dat['Uv']*0.05),
    	'AntiUv' => ceil($dat['AntiUv']+$dat['AntiUv']*0.05),
    	'Armor1' => ceil($dat['Armor1']+$dat['Armor1']*0.05),
    	'Armor2' => ceil($dat['Armor2']+$dat['Armor2']*0.05),
    	'Armor3' => ceil($dat['Armor3']+$dat['Armor3']*0.05),
    	'Armor4' => ceil($dat['Armor4']+$dat['Armor4']*0.05),
    	),
    	Array(
    	'Owner'   => $player->username,
    	'Un_Id'   => $dat['Un_Id'],
    	'Wear_ON' => 0,
    	),
    	'maths'
    	);

    	$db->update( SQL_PREFIX.'bank_acc', Array( 'Euro' => '[-]'.sprintf ("%.2f", ($dat['Cost']/15*0.05) ) ), Array( 'Username' => $player->username ), 'maths' );

    	$err = 'Вещь '.$dat['Thing_Name'].' улучшена';    	$Money -= sprintf ("%.2f", ($dat['Cost']/15*0.05) );
    }
}


if (!empty($buy)) {
$dat = $db->queryRow("SELECT * FROM ".SQL_PREFIX."things_euroshop WHERE Amount != '0' AND Id = '$buy'");
if (!$dat) { $err = _SHOP_ERR1; }
elseif ($dat['Eurocost'] > $Money) { $err = _SHOP_ERR2; }
else {

$db->insert( SQL_PREFIX.'things',
Array(
'Owner' => $player->username, 'Id' => $dat['Id'], 'Thing_Name' => $dat['Thing_Name'],
'Slot' => $dat['Slot'], 'Cost' => $dat['Cost'], 'Level_need' => $dat['Level_need'], 'Stre_need' => $dat['Stre_need'],
'Agil_need' => $dat['Agil_need'], 'Intu_need' => $dat['Intu_need'], 'Endu_need' => $dat['Endu_need'],
'Clan_need' => $dat['Clan_need'], 'Level_add' => $dat['Level_add'],  'Stre_add' => $dat['Stre_add'],
'Agil_add' => $dat['Agil_add'], 'Intu_add' => $dat['Intu_add'], 'Endu_add' => $dat['Endu_add'],
'MINdamage' => $dat['MINdamage'], 'MAXdamage' => $dat['MAXdamage'], 'Crit' => $dat['Crit'],
'AntiCrit' => $dat['AntiCrit'], 'Uv' => $dat['Uv'], 'AntiUv' => $dat['AntiUv'], 'Armor1' => $dat['Armor1'],
'Armor2' => $dat['Armor2'], 'Armor3' => $dat['Armor3'], 'Armor4' => $dat['Armor4'], 'MagicID' => $dat['MagicID'],
'NOWwear' => $dat['NOWwear'], 'MAXwear' => $dat['MAXwear'], 'Wear_ON' => '0', 'Srab' => $dat['Srab']
)
);

$db->update( SQL_PREFIX.'things_euroshop', Array( 'Amount' => '[-]1' ), Array( 'Id' => $buy ), 'maths' );
$db->update( SQL_PREFIX.'bank_acc', Array( 'Euro' => '[-]'.$dat['Eurocost'] ), Array( 'Username' => $player->username ), 'maths' );

$err = sprintf(_SHOP_MSG1, $dat['Thing_Name'], $dat['Eurocost'], 'Euro.');
$Money -= $dat['Eurocost'];

}


}

unset($buy);

if(!empty($_POST['wanttoconv']) && is_numeric($_POST['wanttoconv'])){
if($_POST['wanttoconv'] > 0){

if($Money >= $_POST['wanttoconv']){

$db->update( SQL_PREFIX.'bank_acc', Array( 'Euro' => '[-]'.$_POST['wanttoconv'] ), Array( 'Username' => $player->username ), 'maths' );
$db->update( SQL_PREFIX.'players', Array( 'Money' => '[+]'.($_POST['wanttoconv']*15) ), Array( 'Username' => $player->username ), 'maths' );

$err            = sprintf(_EUROSHOP_MSG1, $_POST['wanttoconv'], ($_POST['wanttoconv']*15));
$Money         -= $_POST['wanttoconv'];
$player->Money += $_POST['wanttoconv']*15;

} else { $err = _EUROSHOP_ERR1; }
} else { $err = _EUROSHOP_ERR2; }

}


require_once('_loader.php');

$tow_tpl->assignGlobal('db_config', $db_config);

$temp = & $tow_tpl->getDisplay('content', true);

$temp->assign( 'tdcolor', '#D5D5D5' );
$temp->assign( 'money_kr', $player->Money);
$temp->assign( 'Money',    $Money   );
$temp->assign( 'otdel',    $otdel   );
$temp->assign( 'err',      $err     );

$temp->addTemplate('euroshop', 'timeofwars_loc_euroshop.html');


$show = & $tow_tpl->getDisplay('index');


$show->assign('title', 'Time Of Wars - заморская лавка');
$show->assign('Content', $temp);


$show->addTemplate('header', 'header.html');
$show->addTemplate('index' , 'index.html' );
$show->addTemplate('footer', 'footer.html');


$tow_tpl->display();
?>
