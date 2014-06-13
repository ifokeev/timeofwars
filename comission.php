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
$player->checkRoom('comission');

if(!empty($_GET['goto']) && $_GET['goto'] == 'pl' ){
$player->gotoRoom();
}

$player->heal();

if ($player->clanid == 200) { die( _chaosERR ); }

if(!isset($_GET['otdel'])){ $_GET['otdel'] = 0; }

if($_GET['otdel'] != '' && ($_GET['otdel'] < 0 || $_GET['otdel'] > 15)){ die('<script>top.location.href=\'index.php\';</script>'); session_destroy(); }


$msg                    = '';
@$_GET['item_id']       = intval($_GET['item_id']);
@$_GET['otdel']         = intval($_GET['otdel']);
@$_GET['sale_thing']    = intval($_GET['sale_thing']);
@$_GET['price']         = floatval($_GET['price']);
@$_GET['id']            = intval($_GET['id']);
@$_GET['smenit_thing']  = intval($_GET['smenit_thing']);
@$_GET['itemid']        = speek_to_view($_GET['itemid']);

if(isset($_GET['otdel']) && !empty($_GET['item_id']) && (!empty($_GET['action']) && $_GET['action'] == 'buy') ){
if( $dat = $db->queryRow("SELECT * FROM ".SQL_PREFIX."comission WHERE Un_Id = '".$_GET['item_id']."' AND Slot = '".$_GET['otdel']."' AND (Slot <> '13')  AND (Slot <> '15') AND (Slot <> '16')") ){
if($dat['Owner'] == $player->username){ $msg = 'Невозможно купить вещь у самого себя'; }
elseif($dat['Cost'] > $player->Money){ $msg = 'Недостаточно денег для покупки этой вещи';  }
else{

if(empty($dat['Shop_Price'])){ $money = $dat['Cost']; }
else{ $money = $dat['Shop_Price']; }

$db->insert( SQL_PREFIX.'things',
Array(
'Owner' => $player->username, 'Id' => $dat['Id'], 'Thing_Name' => $dat['Thing_Name'],
'Slot' => $dat['Slot'], 'Cost' => $money, 'Level_need' => $dat['Level_need'], 'Stre_need' => $dat['Stre_need'],
'Agil_need' => $dat['Agil_need'], 'Intu_need' => $dat['Intu_need'], 'Endu_need' => $dat['Endu_need'],
'Clan_need' => $dat['Clan_need'], 'Level_add' => $dat['Level_add'],  'Stre_add' => $dat['Stre_add'],
'Agil_add' => $dat['Agil_add'], 'Intu_add' => $dat['Intu_add'], 'Endu_add' => $dat['Endu_add'],
'MINdamage' => $dat['MINdamage'], 'MAXdamage' => $dat['MAXdamage'], 'Crit' => $dat['Crit'],
'AntiCrit' => $dat['AntiCrit'], 'Uv' => $dat['Uv'], 'AntiUv' => $dat['AntiUv'], 'Armor1' => $dat['Armor1'],
'Armor2' => $dat['Armor2'], 'Armor3' => $dat['Armor3'], 'Armor4' => $dat['Armor4'], 'MagicID' => $dat['MagicID'],
'NOWwear' => $dat['NOWwear'], 'MAXwear' => $dat['MAXwear'], 'Wear_ON' => '0', 'Srab' => $dat['Srab']
)
);

$db->update( SQL_PREFIX.'players', Array( 'Money' => '[-]'.$dat['Cost'] ), Array( 'Username' => $player->username ), 'maths' );

$money_give = $dat['Cost'] - ($dat['Cost'] * 0.1);

$db->update( SQL_PREFIX.'players', Array( 'Money' => '[+]'.$money_give ), Array( 'Username' => $dat['Owner'] ), 'maths' );
$db->execQuery("DELETE FROM ".SQL_PREFIX."comission WHERE Un_Id = '".$_GET['item_id']."'");
$msg = 'Предмет "'.$dat['Thing_Name'].'" куплен успешно за  '.$dat['Cost'].' кр';

$tr_msg = 'Предмет <b> '.$dat['Thing_Name'].' </b> был куплен в комиссионном магазине. За вычетом <b>10%</b> комиссионных Вам переведено <B>'.$money_give.' кр.</B>';
$db->insert( SQL_PREFIX.'messages', Array( 'Username' => $dat['Owner'], 'Text' => $tr_msg ) );
$db->insert( SQL_PREFIX.'transfer', Array( 'Date' => date('Y-m-d'), 'From' => $player->username, 'To' => $dat['Owner'], 'What' => $money_give.' за вещь '.$dat['Thing_Name'].' (ID = '.$dat['Un_Id'].'; Владелец - '.$dat['Owner'].'; ком. магазин)' ) );
$db->insert( SQL_PREFIX.'transfer', Array( 'Date' => date('Y-m-d'), 'From' => $dat['Owner'], 'To' => $player->username, 'What' => $player->username.' Купил вещь '.$dat['Thing_Name'].' за '.$dat['Cost'].' (ком. магазин)' ) );
$player->Money -= $dat['Cost'];

}

$_GET['otdel']  = $dat['Slot'];
$_GET['itemid'] = $dat['Id'];
$_GET['do']     = 2;

}else{
$msg = 'Такой вещи не существует в магазине';
}
//The End

}

if(!empty($_GET['sale_thing']) && (!empty($_GET['price']) && is_numeric($_GET['price'])) ){

if( $dat = $db->queryRow("SELECT * FROM ".SQL_PREFIX."things WHERE Owner = '".$player->username."' AND Un_Id = '".$_GET['sale_thing']."' AND (Slot <> '13')  AND (Slot <> '15') AND (Slot <> '16')") ){
if (preg_match('/клановая|артефакт|именная|Освящено элитно|made|ability|квартиры/i', $dat['Thing_Name'])  ) {  $msg = 'Эту вещь нельзя продать'; }
elseif($_GET['price'] < $dat['Cost'] * 0.4){ $msg = 'Цена этой вещи не может быть меньше 40% от ее реальной стоимости'; }
elseif($_GET['price'] < 1){ $msg = 'Минимальная цена этого предмета - 1 кр'; }
elseif($_GET['price'] > $dat['Cost']){ $msg = 'Цена этой вещи не может быть больше ее реальной стоимости'; }
else{

$db->insert( SQL_PREFIX.'comission',
Array(
'Owner' => $player->username, 'Un_Id' => $dat['Un_Id'], 'Id' => $dat['Id'], 'Thing_Name' => $dat['Thing_Name'],
'Slot' => $dat['Slot'], 'Cost' => $_GET['price'], 'Level_need' => $dat['Level_need'], 'Stre_need' => $dat['Stre_need'],
'Agil_need' => $dat['Agil_need'], 'Intu_need' => $dat['Intu_need'], 'Endu_need' => $dat['Endu_need'],
'Clan_need' => $dat['Clan_need'], 'Level_add' => $dat['Level_add'],  'Stre_add' => $dat['Stre_add'],
'Agil_add' => $dat['Agil_add'], 'Intu_add' => $dat['Intu_add'], 'Endu_add' => $dat['Endu_add'],
'MINdamage' => $dat['MINdamage'], 'MAXdamage' => $dat['MAXdamage'], 'Crit' => $dat['Crit'],
'AntiCrit' => $dat['AntiCrit'], 'Uv' => $dat['Uv'], 'AntiUv' => $dat['AntiUv'], 'Armor1' => $dat['Armor1'],
'Armor2' => $dat['Armor2'], 'Armor3' => $dat['Armor3'], 'Armor4' => $dat['Armor4'], 'MagicID' => $dat['MagicID'],
'NOWwear' => $dat['NOWwear'], 'MAXwear' => $dat['MAXwear'], 'Wear_ON' => '0', 'Srab' => $dat['Srab'],
'Shop_Price' => $dat['Cost']
)
);

$db->execQuery("DELETE FROM ".SQL_PREFIX."things WHERE (Un_Id = '".$_GET['sale_thing']."') AND (Owner = '".$player->username."') ");
$msg = 'Вещь '.$dat['Thing_Name'].' успешно посталена на продажу с ценой в '.$_GET['price'].' кр';

}

}
// конец
//$_GET['sale_thing'] = false;
$_POST['sale'] = 1;
}

unset($_GET['sale_thing']);

if((!empty($_GET['do']) && $_GET['do'] == 'zabrat') && !empty($_GET['id']) ){

if( $dat = $db->queryRow("SELECT * FROM ".SQL_PREFIX."comission WHERE Owner = '".$player->username."' AND Un_Id = '".$_GET['id']."' AND (Slot <> '13')  AND (Slot <> '15') AND (Slot <> '16')") ){

$db->insert( SQL_PREFIX.'things',
Array(
'Owner' => $player->username, 'Id' => $dat['Id'], 'Thing_Name' => $dat['Thing_Name'],
'Slot' => $dat['Slot'], 'Cost' => $dat['Shop_Price'], 'Level_need' => $dat['Level_need'], 'Stre_need' => $dat['Stre_need'],
'Agil_need' => $dat['Agil_need'], 'Intu_need' => $dat['Intu_need'], 'Endu_need' => $dat['Endu_need'],
'Clan_need' => $dat['Clan_need'], 'Level_add' => $dat['Level_add'],  'Stre_add' => $dat['Stre_add'],
'Agil_add' => $dat['Agil_add'], 'Intu_add' => $dat['Intu_add'], 'Endu_add' => $dat['Endu_add'],
'MINdamage' => $dat['MINdamage'], 'MAXdamage' => $dat['MAXdamage'], 'Crit' => $dat['Crit'],
'AntiCrit' => $dat['AntiCrit'], 'Uv' => $dat['Uv'], 'AntiUv' => $dat['AntiUv'], 'Armor1' => $dat['Armor1'],
'Armor2' => $dat['Armor2'], 'Armor3' => $dat['Armor3'], 'Armor4' => $dat['Armor4'], 'MagicID' => $dat['MagicID'],
'NOWwear' => $dat['NOWwear'], 'MAXwear' => $dat['MAXwear'], 'Wear_ON' => '0', 'Srab' => $dat['Srab']
)
);

$db->execQuery("DELETE FROM ".SQL_PREFIX."comission WHERE Un_Id = '".$_GET['id']."'");
$db->update( SQL_PREFIX.'players', Array( 'Money' => '[-]1' ), Array( 'Username' => $player->username ), 'maths' );
$msg = 'Предмет '.$dat['Thing_Name'].' успешно забран из комиссионного магазина';
$player->Money -= 1;

}

}

if(!empty($_GET['smenit_thing']) && !empty($_GET['price']) && is_numeric($_GET['price']) ){

if( $dat = $db->queryRow("SELECT Shop_Price, Thing_Name FROM ".SQL_PREFIX."comission WHERE Owner = '".$player->username."' AND Un_Id = '".$_GET['smenit_thing']."' AND (Slot <> '13')  AND (Slot <> '15') AND (Slot <> '16')") ){
if($_GET['price'] < $dat['Shop_Price'] * 0.4){ $msg = 'Цена этой вещи не может быть меньше 40% от ее реальной стоимости'; }
elseif($_GET['price'] < 1){ $msg = 'Минимальная цена этого предмета - 1 кр'; }
elseif($_GET['price'] > $dat['Shop_Price']){ $msg = 'Цена этой вещи не может быть больше ее реальной стоимости'; }
else{

$db->update( SQL_PREFIX.'players', Array( 'Money' => '[-]1' ), Array( 'Username' => $player->username ), 'maths' );
$db->update( SQL_PREFIX.'comission', Array( 'Cost' => $_GET['price'] ), Array( 'Owner' => $player->username, 'Un_Id' => $_GET['smenit_thing'] ) );

$msg = 'Цена '.$dat['Thing_Name'].' успешно изменена на '.$_GET['price'].' кр';
$player->Money -= 1;
}

}
$_GET['smenit_thing'] = false;
}

$a = $db->queryArray("SELECT * FROM ".SQL_PREFIX."things WHERE (Owner = '".$player->username."') AND (Wear_ON = '0') AND (Slot <> '13') AND (Slot <> '15') AND (Slot <> '16') ORDER by Cost ASC", 'sale' );
$b = $db->queryArray("SELECT * FROM ".SQL_PREFIX."comission WHERE (Owner = '".$player->username."') AND (Wear_ON = '0') AND (Slot <> '13') AND (Slot <> '15') AND (Slot <> '16') ORDER by Cost ASC", 'zabrat' );

require_once('_loader.php');

$tow_tpl->assignGlobal('db_config', $db_config);
$tow_tpl->assignGlobal('db', $db);

$temp = & $tow_tpl->getDisplay('content', true);

$temp->assign( 'bgcolor', '#D5D5D5');
$temp->assign( 'player',  $player  );
$temp->assign( 'msg',     $msg     );
$temp->assign( 'a',       $a       );
$temp->assign( 'b',       $b       );



//if (!$temp->isCached()) {
$temp->addTemplate('comission', 'timeofwars_loc_com.html');
//}

$show = & $tow_tpl->getDisplay('index');


$show->assign('title', 'Time Of Wars - комиссионный магазин');
$show->assign('Content', $temp);


$show->addTemplate('header', 'header.html');
$show->addTemplate('index' , 'index.html' );
$show->addTemplate('footer', 'footer.html');


$tow_tpl->display();
?>
