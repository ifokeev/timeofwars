<?
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

session_start();
if (empty($_SESSION['login'])) { include_once('includes/bag_log_in.php'); exit; }

function make_password($length, $strength = 0) {
$vowels     = 'aeiouy';
$consonants = 'bdghjlmnpqrstvwxzBDGHJLMNPQRSTVWXZ0123456789';
$password   = '';
$alt        = time() % 2;
srand(time());

for ($i = 0; $i < $length; $i++) {
if ($alt == 1) { $password .= $consonants[(rand() % strlen($consonants))]; $alt = 0; }
else { $password .= $vowels[(rand() % strlen($vowels))]; $alt = 1; }
}

return $password;
}

include_once ('db_config.php');
include_once ('db.php');

include_once ('classes/PlayerInfo.php');

$player = new PlayerInfo();

$player->is_blocked();
$player->checkBattle();
$player->checkRoom('zamok');

if( !$zamok = $db->queryRow("SELECT zamok, own_locations, title, balance FROM ".SQL_PREFIX."castles WHERE zamok = '".$player->ChatRoom."'") ){$player->gotoRoom( 'land', 'land' );
}

$player->heal();
$player->checklevelup();

$msg   = '';
$buy   = Array();
$admin = 0;

$cl    = split( '_', $player->ChatRoom );
$clan  = $db->queryRow("SELECT id_clan, title FROM ".SQL_PREFIX."clan WHERE id_clan = '".$cl[1]."'");
if( $player->admin == 1 && $player->id_clan == $cl[1] ){ $admin = 1; }
unset($cl);

list($none, $train, $flower, $pict) = split( ';', $zamok['own_locations'] );

if(!empty($_GET['goto']) && ($_GET['goto'] == 'land' ||
/*($_GET['goto'] == $player->ChatRoom.'_shop' && $shop == '1') || ($_GET['goto'] == $player->ChatRoom.'_euroshop' && $euro == '1')*/
($_GET['goto'] == $player->ChatRoom.'_train' && $train == '1') ||
($_GET['goto'] == $player->ChatRoom.'_Pict' && $pict == '1') ||
($_GET['goto'] == $player->ChatRoom.'_flower' && $flower == '1') ) ){

if( !empty($_GET['goto']) && ($_GET['goto'] == $player->ChatRoom.'_train' && $train == '1') && $player->clanid != $clan['id_clan'] )
{	die("<script>alert('Для вас ворота закрыты.');window.location.href='zamok.php';</script>");
}

switch($_GET['goto']){
//case $player->ChatRoom.'_shop':     $room = 'zamok_shop';   $chatroom = $player->ChatRoom.'__shop';     break;
//case $player->ChatRoom.'_euroshop': $room = 'zamok_euro';   $chatroom = $player->ChatRoom.'__euroshop'; break;
case $player->ChatRoom.'_train':    $room = 'zamok_train';  $chatroom = $player->ChatRoom.'__train';    break;
case $player->ChatRoom.'_Pict':     $room = 'zamok_pict';   $chatroom = $player->ChatRoom.'__Pict';     break;
case $player->ChatRoom.'_flower':   $room = 'zamok_flower'; $chatroom = $player->ChatRoom.'__flower';   break;
case 'land':                        $room = 'land';         $chatroom = 'land';                         break;
default:                            $room = 'land';         $chatroom = 'land';                         break;
}

$player->gotoRoom( $room, $chatroom );
}


if( !empty($_GET['buy']) && (/*$_GET['buy'] == 'shop' || $_GET['buy'] == 'euroshop' ||*/$_GET['buy'] == 'train' || $_GET['buy'] == 'flower' || $_GET['buy'] == 'pict') && $admin == '1' ){

switch($_GET['buy']){

/*case 'shop':

$buy['price'] = 1200; $shop   = 1; $buy['title'] = 'Магазин вещей';
$buy['query'] =
"CREATE TABLE IF NOT EXISTS `".SQL_PREFIX."things_shop_".$player->ChatRoom."`  (
  `Amount` bigint(20) unsigned NOT NULL default '0',
  `Otdel` tinyint(4) NOT NULL default '0',
  `Id` char(16) NOT NULL default '',
  `Thing_Name` char(80) NOT NULL default '',
  `Slot` tinyint(3) unsigned NOT NULL default '0',
  `Cost` mediumint(3) unsigned default NULL,
  `Level_need` tinyint(3) unsigned default NULL,
  `Stre_need` smallint(5) unsigned default NULL,
  `Agil_need` smallint(5) unsigned default NULL,
  `Intu_need` smallint(5) unsigned default NULL,
  `Endu_need` smallint(5) unsigned default NULL,
  `Clan_need` tinyint(3) unsigned default NULL,
  `Level_add` smallint(6) default NULL,
  `Stre_add` smallint(6) default NULL,
  `Agil_add` smallint(6) default NULL,
  `Intu_add` smallint(6) default NULL,
  `Endu_add` smallint(6) default NULL,
  `MINdamage` smallint(5) unsigned default NULL,
  `MAXdamage` smallint(5) unsigned default NULL,
  `Crit` smallint(6) default NULL,
  `AntiCrit` smallint(6) default NULL,
  `Uv` smallint(6) default NULL,
  `AntiUv` smallint(6) default NULL,
  `Armor1` smallint(6) default NULL,
  `Armor2` smallint(6) default NULL,
  `Armor3` smallint(6) default NULL,
  `Armor4` smallint(6) default NULL,
  `MagicID` char(20) default NULL,
  `NOWwear` char(6) default NULL,
  `MAXwear` char(6) default NULL,
  `Srab` int(11) NOT NULL default '0',
  KEY `otd_ind` (`Otdel`,`Cost`),
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;
";

break;
case 'euroshop':

$buy['price'] = 700;  $euro   = 1; $buy['title'] = 'ЕвроМагазин вещей';
$buy['query'] =
"CREATE TABLE IF NOT EXISTS `".SQL_PREFIX."things_euroshop_".$player->ChatRoom."` (
  `Amount` bigint(20) unsigned NOT NULL default '0',
  `Otdel` tinyint(4) NOT NULL default '0',
  `Id` char(40) NOT NULL default '',
  `Thing_Name` char(80) NOT NULL default '',
  `Slot` tinyint(3) unsigned NOT NULL default '0',
  `Eurocost` bigint(20) NOT NULL default '0',
  `Cost` mediumint(3) unsigned default NULL,
  `Level_need` tinyint(3) unsigned default NULL,
  `Stre_need` smallint(5) unsigned default NULL,
  `Agil_need` smallint(5) unsigned default NULL,
  `Intu_need` smallint(5) unsigned default NULL,
  `Endu_need` smallint(5) unsigned default NULL,
  `Clan_need` tinyint(3) unsigned default NULL,
  `Level_add` smallint(6) default NULL,
  `Stre_add` smallint(6) default NULL,
  `Agil_add` smallint(6) default NULL,
  `Intu_add` smallint(6) default NULL,
  `Endu_add` smallint(6) default NULL,
  `MINdamage` smallint(5) unsigned default NULL,
  `MAXdamage` smallint(5) unsigned default NULL,
  `Crit` smallint(6) default NULL,
  `AntiCrit` smallint(6) default NULL,
  `Uv` smallint(6) default NULL,
  `AntiUv` smallint(6) default NULL,
  `Armor1` smallint(6) default NULL,
  `Armor2` smallint(6) default NULL,
  `Armor3` smallint(6) default NULL,
  `Armor4` smallint(6) default NULL,
  `MagicID` char(30) default NULL,
  `NOWwear` char(6) default NULL,
  `MAXwear` char(6) default NULL,
  `Srab` int(11) NOT NULL default '0',
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;
";

break;
*/
case 'train':

$buy['price'] = 1000;  $train = 1; $buy['title'] = 'Татами';
$buy['query'] = "INSERT INTO ".SQL_PREFIX."players
( Username, Password, Level, Stre, Agil, Intu, Endu, HPnow, HPall, ClanID, Pict, Room, ChatRoom, Sex, Reg_IP, map_id ) VALUES
( 'Бот_".$clan['id_clan']."', '".make_password(mt_rand(5,10), 0)."', '0', '3', '3', '3', '3', '18', '18', '".$clan['id_clan']."', '0', 'zamok_train', '".$player->ChatRoom.'__train'."',  'M', 'бот', '588' )";


break;
case 'flower':

$buy['price'] = 400;  $flower = 1; $buy['title'] = 'Магазин подарков';
$buy['query'] =
"CREATE TABLE IF NOT EXISTS `".SQL_PREFIX."things_presentshop_".$player->ChatRoom."` (
  `id` int(11) NOT NULL auto_increment,
  `presentNAME` char(30) NOT NULL,
  `presentIMG` char(30) NOT NULL,
  `presentABOUT` char(200) NOT NULL,
  `presentPRICE` int(11) NOT NULL,
  `presentCOUNT` int(5) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;
";

break;
case 'pict':

$buy['price'] = 600;  $pict   = 1; $buy['title'] = 'Магазин образов';
$buy['query'] =
"CREATE TABLE IF NOT EXISTS `".SQL_PREFIX."pict_".$player->ChatRoom."` (
  `Id` varchar(30) NOT NULL,
  `Author` varchar(30) NOT NULL,
  `date` varchar(30) NOT NULL,
  `price` smallint(5) NOT NULL default '0',
  `otdel` enum('F','M') NOT NULL default 'M',
  PRIMARY KEY  (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

";

break;


}

if( $player->Money < $buy['price'] ){ $msg = 'Недостаточно денег для покупки'; }
else{
if( $db->query($buy['query']) ) {$db->update( SQL_PREFIX.'castles', Array( 'own_locations' => $none.';'.$train.';'.$flower.';'.$pict ), Array( 'zamok' => $player->ChatRoom ) );
$db->update( SQL_PREFIX.'players', Array( 'Money' => '[-]'.$buy['price'] ), Array( 'Username' => $player->username ), 'maths' );

$msg = $buy['title'].' успешно построен за '.$buy['price'].' кр.';
} else {die( 'ошибка' );
}

}

}


require_once('_loader.php');

$tow_tpl->assignGlobal('db_config', $db_config);

$temp =& $tow_tpl->getDisplay('content', true);

//$temp->assign( 'shop',   $shop   );
//$temp->assign( 'euro',   $euro   );
$temp->assign( 'flower', $flower  );
$temp->assign( 'pict',   $pict    );
$temp->assign( 'train',  $train   );

$temp->assign( 'msg',    $msg    );

$temp->assign( 'ChatRoom', $player->ChatRoom );
$temp->assign( 'admin',    $admin            );
$temp->assign( 'clan',     $clan             );
$temp->assign( 'zamok',    $zamok            );

//$temp->setCache('castle', 86400);

//if (!$temp->isCached()) {
$temp->addTemplate('castle', 'timeofwars_loc_castle.html');
//}

$show =& $tow_tpl->getDisplay('index');


$show->assign('title', 'Time Of Wars - замок. внутренний двор.');
$show->assign('Content', $temp);


$show->addTemplate('header', 'header.html');
$show->addTemplate('index' , 'index.html' );
$show->addTemplate('footer', 'footer.html');


$tow_tpl->display();
?>
