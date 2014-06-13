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
$player->checkRoom('handmade');

if(!empty($_GET['goto']) && $_GET['goto'] == 'land' ){
$player->gotoRoom( 'land', 'land' );
}

$player->heal();


$msg                  = '';
@$_GET['sale_thing']  = intval($_GET['sale_thing']);

if(!empty($_GET['sale_thing']) && (!empty($_GET['price']) && is_numeric($_GET['price'])) ){

if( $dat = $db->queryRow("SELECT * FROM ".SQL_PREFIX."things WHERE Owner = '".$player->username."' AND Un_Id = '".$_GET['sale_thing']."' AND Id LIKE 'smith_%'") ){
if($_GET['price'] < 1){ $msg = 'Минимальная цена этого предмета - 1 кр'; }
elseif($_GET['price'] > 200){ $msg = 'Цена этой вещи не может быть больше 200 кр.'; }
else{

switch( $dat['Id'] )
{
	case 'smith_sw1':
	case 'smith_sw2':
	case 'smith_sw3':    $otdel = 1; $slot = 2; break;

	case 'smith_sh1':
	case 'smith_sh2':
	case 'smith_sh3':    $otdel = 1; $slot = 9; break;

	case 'smith_shoes1':
	case 'smith_shoes2':
	case 'smith_shoes3': $otdel = 2; $slot = 10; break;

	case 'smith_helm1':
	case 'smith_helm2':
	case 'smith_helm3':  $otdel = 2; $slot = 7; break;

	case 'smith_kulon1':
	case 'smith_kulon2':
	case 'smith_kulon3': $otdel = 3; $slot = 1; break;

	case 'smith_ring1':
	case 'smith_ring2':
	case 'smith_ring3':  $otdel = 3; $slot = 4; break;
}



$db->insert( SQL_PREFIX.'things_samodel',
Array(
'Owner' => $player->username, 'Un_Id' => $dat['Un_Id'], 'Id' => $dat['Id'], 'Thing_Name' => $dat['Thing_Name'],
'Otdel' => $otdel, 'Slot' => $slot, 'Cost' => $_GET['price'], 'Level_need' => $dat['Level_need'], 'Stre_need' => $dat['Stre_need'],
'Agil_need' => $dat['Agil_need'], 'Intu_need' => $dat['Intu_need'], 'Endu_need' => $dat['Endu_need'],
'Stre_add' => $dat['Stre_add'], 'Agil_add' => $dat['Agil_add'], 'Intu_add' => $dat['Intu_add'], 'Endu_add' => $dat['Endu_add'],
'MINdamage' => $dat['MINdamage'], 'MAXdamage' => $dat['MAXdamage'], 'Crit' => $dat['Crit'],
'AntiCrit' => $dat['AntiCrit'], 'Uv' => $dat['Uv'], 'AntiUv' => $dat['AntiUv'],
'Armor1' => $dat['Armor1'], 'Armor2' => $dat['Armor2'], 'Armor3' => $dat['Armor3'], 'Armor4' => $dat['Armor4'],
'NOWwear' => $dat['NOWwear'], 'MAXwear' => $dat['MAXwear'], 'add_time' => time(),
)
);


$db->execQuery("DELETE FROM ".SQL_PREFIX."things WHERE (Un_Id = '".$dat['Un_Id']."') AND (Owner = '".$player->username."') AND Id LIKE 'smith_%'");
$msg = 'Вещь '.$dat['Thing_Name'].' успешно выставлена на продажу с ценой в '.$_GET['price'].' кр. на 30 дней';

}

}


}

unset($_GET['sale_thing']);


$sell = $db->queryArray("SELECT * FROM ".SQL_PREFIX."things WHERE (Owner = '".$player->username."') AND (Wear_ON = '0') AND Id LIKE 'smith_%' ORDER by Cost ASC", 'sell' );


require_once('_loader.php');

$tow_tpl->assignGlobal('db_config', $db_config);

$temp = & $tow_tpl->getDisplay('content', true);

$temp->assign( 'bgcolor', '#D5D5D5'      );
$temp->assign( 'Money',   $player->Money );
$temp->assign( 'Level',   $player->Level );
$temp->assign( 'Stre',    $player->Stre  );
$temp->assign( 'Agil',    $player->Agil  );
$temp->assign( 'Intu',    $player->Intu  );
$temp->assign( 'Endu',    $player->Endu  );
$temp->assign( 'msg',     $msg           );
$temp->assign( 'sell',    $sell          );

$temp->addTemplate('euroshop', 'timeofwars_loc_shop_samodelsale.html');


$show = & $tow_tpl->getDisplay('index');


$show->assign('title', 'Time Of Wars - заморская лавка');
$show->assign('Content', $temp);


$show->addTemplate('header', 'header.html');
$show->addTemplate('index' , 'index.html' );
$show->addTemplate('footer', 'footer.html');


$tow_tpl->display();
?>
