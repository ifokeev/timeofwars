<?php
require_once ('OldUserStats.php');

class OldUser{

var $currentUser = false;
var $isOnline = false;
var $infoArray;
var $id_user;
var $username;
var $id_clan;
var $id_rank;
var $clanAdmin;
var $id_picture;
var $id_battle;
var $hasStatus;
var $chatStatus;
var $Time;
var $room;
var $Stre;
var $Agil;
var $Intu;
var $Endu;
var $Intl;
var $Level;
var $Align;
var $Sex;
var $Room;
var $Money;
var $HPnow;
var $HPtime;
var $HPall;
var $minDamage;
var $maxDamage;
var $critical;
var $antiCritical;
var $dodge;
var $antiDodge;
var $armor1;
var $armor2;
var $armor3;
var $armor4;
var $items;
var $slotItem;
var $isVip;


function OldUser( $username='', $id_user=''  ){

if( $username != '' ){
$this->username = $username;
$this->id_user = $id_user;
$this->isOnline( $this->id_user, $this->username );
} elseif ( $username == '' && $id_user == '' ){
$this->username	= $_SESSION['login'];
$this->id_user	= $_SESSION['id_user'];
$this->isOnline = true;
$this->currentUser = true;
}

$this->loadUser();

}
	
	

function initByObject( $obj ){
foreach( $this as $key => $value ){
$this->$key =& $obj->$key;
}
}


function isOnline( $id_user='', $username='' ){
global $db;

$query = sprintf("SELECT Username FROM ".SQL_PREFIX."online WHERE Username = '%s';", $username );
$res = $db->queryRow( $query, "UserLoader_isOnline_1" );

if( !empty($res) ){ $this->isOnline = true; }
else{ $this->isOnline = false; }

return $this->isOnline;
}


function loadUser( ){
$this->loadFromStaticTables();
}


function isCurrentUser( ){

if( $this->id_user == $_SESSION['id_user'] ){ $this->currentUser = true; }
else{ $this->currentUser = false; }

return $this->currentUser;
}


function setVars( &$array ){

$this->infoArray =& $array;
$this->username =& $array['Username'];
$this->id_clan =& $array['id_clan'];
$this->id_rank =& $array['id_rank'];
$this->clanAdmin =& $array['admin'];
$this->id_picture =& $array['id_picture'];
$this->id_battle =& $array['id_battle'];
$this->Room =& $array['Room'];
$this->Time =& $array['Time'];
$this->Money =& $array['Money'];
$this->Stre =& $array['Stre'];
$this->Agil =& $array['Agil'];
$this->Intu =& $array['Intu'];
$this->Endu =& $array['Endu'];
$this->Intl =& $array['Intl'];
$this->Level =& $array['Level'];
$this->Align = 0;
$this->Sex =& $array['Sex'];
$this->HPnow =& $array['HPnow'];
$this->HPall =& $array['HPall'];
$this->HPtime =& $array['HPtime'];
$this->minDamage =& $array['minDamage'];
$this->maxDamage =& $array['maxDamage'];
$this->critical =& $array['critical'];
$this->antiCritical =& $array['antiCritical'];
$this->dodge =& $array['dodge'];
$this->antiDodge =& $array['antiDodge'];
$this->armor1 =& $array['armor1'];
$this->armor2 =& $array['armor2'];
$this->armor3 =& $array['armor3'];
$this->armor4 =& $array['armor4'];

}


function loadFromSession( ){
$this->setVars( $_SESSION );
}


function loadFromSessionData( ){
global $db;

$query = sprintf("SELECT * FROM ".SQL_PREFIX."session_data WHERE id_user = '%d';", $this->id_user );
$res = $db->queryRow( $query, "UserLoader_loadFromSessionData_1" );
		
if( !$res['hasStatus'] ){ $res['hasStatus'] = array(); }
else{ $res['hasStatus'] = explode( ',' , $res['hasStatus'] ); }
		

$query = sprintf("SELECT Sex FROM ".SQL_PREFIX."players WHERE id_user = '%d';", $this->id_user );
$sex = $db->queryRow( $query, "UserLoader_loadFromSessionData_1" );

$res['Sex'] = $sex['Sex'];
$this->setVars( $res );
}



function loadFromStaticTables( ){
$userInfo = $this->getUserInfo( $this->username );
$this->setVars( $userInfo );
}
	


function getUserInfo( $username = '' ){
global $db;
		
if( $username == '' ){ return array(); }

$out = array();
		
$query = sprintf("SELECT p.`Username` as id_user, p.`Username`, p.`Pict` as id_picture, p.`Stre`, p.`Agil`, p.`Intu`, p.`Endu`, p.`Intl`, p.`Level`, p.`HPnow`, p.`HPall`, p.`Sex`, p.`Room`, p.`Money` FROM `".SQL_PREFIX."players` p WHERE p.Username = '%s';", $username );
$res = $db->queryRow( $query, 'User_getUserInfo_1' );

$out = array_merge( $out, $res );
$res = OldUserStats::getSkills( $username );
$out = array_merge( $out, $res );
$res = self::getUserClan( $username );
$out = array_merge( $out, $res );

$query = sprintf("SELECT `Time` as HPtime FROM ".SQL_PREFIX."hp WHERE Username = '%s';", $username );
$res = $db->queryRow( $query, "User_getUserInfo_4" );
		
if( !$res ){ $res = array( 'HPtime' => time() ); }
		
$res['chatStatus'] = 'offline';
$res['room']       = 'offline';


$out = array_merge( $out, $res );

return $out;
}


function getClanInfo( $id_clan ){
global $db;
		
$query = sprintf("SELECT * FROM ".SQL_PREFIX."clan WHERE id_clan = '%d';", $id_clan );
return $db->queryRow( $query, "OldUser_loadClanInfo_1" );
}
	


function heal( ){
		
$healTime = time();
		
if( (($healTime - $this->HPtime) * $this->HPall * 0.0005) < 1 ){ return ; }
if( $this->id_battle > 0 ){ return ; }
		
$HPadd = 0;
$HPadd = round( $this->HPall * ( $healTime - $this->HPtime ) * 0.0005 );
		
if( strpos($this->room, "living__") ){
$params = explode( "__", $this->room );
if( $params[1] > 90 ){ $HPadd *= 2; }
}
		
$this->HPtime = $healTime;
$this->setHP( $HPadd );
$_SESSION['HPnow'] = $this->HPnow;
}


function setHPOffline( $offset ){
global $db;
		
$offset = round( $offset );
		
$this->HPtime = time();
		
$query = sprintf("UPDATE ".SQL_PREFIX."hp SET Time = '%d' WHERE Username = '%s';", $this->HPtime, $this->username );
$db->execQuery( $query, "User_setHPtime_1" );
		
if( $offset == 0 ){ return; }

		
$this->HPnow += $offset;

if( $this->HPnow > $this->HPall ){ $this->HPnow = $this->HPall; }
elseif( $this->HPnow < 0 ){ $this->HPnow = 0; }

$query = sprintf("UPDATE ".SQL_PREFIX."players SET HPnow = '%d' WHERE Username = '%s';", $this->HPnow, $this->username );
$db->execQuery( $query, "User_setHP_1" );
}


function setHP( $offset ){
$this->setHPOffline( $offset );
}


function checkVip( $username ){
global $db;

$query = sprintf("SELECT Username FROM ".SQL_PREFIX."vip WHERE Username = '%s';", $username );
return $db->queryCheck( $query, "User_checkVip_1" );
}
	
	
function isVip( ){
return $this->isVip;
}
	

function isDead( ){
return ($this->HPnow < 1 );
}


function getTepmlatePatterns( ){
$this->loadItemsInfo();
return get_object_vars( $this );
}


function getIdUser( $username = '' ){
global $db;
		
if( $username == '' ){ return false; }
		
$query = sprintf("SELECT Username as id_user FROM ".SQL_PREFIX."players WHERE Username = '%s';", mysql_escape_string( $username ) );
$result = $db->queryRow( $query, 'User_getIdUser_1' );

return ( !isset( $result['id_user'] ) || empty($result['id_user']) ) ? false : $result['id_user'];
}
	
	
function getUserCity( $username ){
global $db;
		
$query = sprintf("SELECT City FROM ".SQL_PREFIX."players WHERE Username = '%s';", mysql_escape_string( $username ) );
$res = $db->queryRow( $query, "OldUser_getUserCity_1" );
		
return $res['City'];
}
	
	
function getUserClan( $username ){
global $db;
		
$query = sprintf("SELECT id_clan, id_rank, admin FROM ".SQL_PREFIX."clan_user WHERE Username = '%s';", $username );
$res = $db->queryRow( $query, "User_getUserInfo_3" );

if( !$res ){ $res = array('id_clan' => 0, 'id_rank' => 0, 'admin' => 0); }

return $res;
}
	

function updateUserClan( $username ){
global $db;
		
$query = sprintf("UPDATE ".SQL_PREFIX."players p LEFT JOIN ".SQL_PREFIX."clan_user cu ON( cu.Username = p.Username ) LEFT JOIN ".SQL_PREFIX."online o ON( o.Username = p.Username ) SET p.ClanID = IFNULL( cu.id_clan, 0 ), o.ClanID = IFNULL( cu.id_clan, 0 ) WHERE p.Username = '%s';", $username );
return $db->execQuery( $query, "OldUser_setUserClan_1" );
}


function getUserName( $id_user ){
global $db;
return $id_user;
}


function getItemsInfo( $id_user ){
global $db;

$out['Slot_name']=array( 'Пустой слот серьги', 'Пустой слот ожерелье', 'Пустой слот оружие', 'Пустой слот броня', 'Пустой слот кольцо', 'Пустой слот кольцо', 'Пустой слот кольцо', 'Пустой слот шапка', 'Пустой слот перчатки', 'Пустой слот щит', 'Пустой слот обувь', );


for( $i=0; $i<11; $i++ ){ $out['Slot'][$i] = 'empt'.$i; }

$out['Slot_id'] = array();

$query = sprintf("SELECT * FROM ".SQL_PREFIX."things WHERE Slot < '11' AND Wear_ON = '1' AND Username = '%s';", $id_user );
$res = $db->query( $query, "User_getItemsInfo_1" );

while( ($item = mysql_fetch_assoc($res)) ){
$out['Slot_id'	][ $item['Slot'] ] = $item['Un_Id'];
$out['Slot'		][ $item['Slot'] ] = $item['Id'];
$out['Slot_name'][ $item['Slot'] ] =
$item['Thing_Name']."\n(долговечность ".$item['NOWwear']."/".$item['MAXwear'].")";
}

return $out;
}


function loadItemsInfo( ){
global $db;

$this->items = array();

$this->slotItem = array(
// Левая
array( 'id_item' => '', 'width' => 60, 'height' => 20, 'itemName' =>'empt0',  'Name' => 'Пустой слот серьги'),
array( 'id_item' => '', 'width' => 60, 'height' => 20, 'itemName' =>'empt1',  'Name' => 'Пустой слот ожерелье'),
array( 'id_item' => '', 'width' => 60, 'height' => 60, 'itemName' =>'empt2',  'Name' => 'Пустой слот оружие'),
array( 'id_item' => '', 'width' => 60, 'height' => 80, 'itemName' =>'empt3',  'Name' => 'Пустой слот броня'),
// Кольца
array( 'id_item' => '', 'width' => 20, 'height' => 20, 'itemName' =>'empt4',  'Name' => 'Пустой слот кольцо'),
array( 'id_item' => '', 'width' => 20, 'height' => 20, 'itemName' =>'empt5',  'Name' => 'Пустой слот кольцо'),
array( 'id_item' => '', 'width' => 20, 'height' => 20, 'itemName' =>'empt6',  'Name' => 'Пустой слот кольцо'),
// Правая
array( 'id_item' => '', 'width' => 60, 'height' => 60, 'itemName' =>'empt7',  'Name' => 'Пустой слот шапка'),
array( 'id_item' => '', 'width' => 60, 'height' => 40, 'itemName' =>'empt8',  'Name' => 'Пустой слот перчатки'),
array( 'id_item' => '', 'width' => 60, 'height' => 60, 'itemName' =>'empt9',  'Name' => 'Пустой слот щит'),
array( 'id_item' => '', 'width' => 60, 'height' => 40, 'itemName' =>'empt10', 'Name' => 'Пустой слот обувь'),
);


$query = sprintf("SELECT * FROM ".SQL_PREFIX."things WHERE Slot < '11' AND Wear_ON = '1' AND Owner = '%s';", $this->id_user );
$res = $db->query( $query, "User_loadItemsInfo_1" );

while( ($item = mysql_fetch_assoc($res)) ){
$this->items[ $item['Un_Id'] ] = $item;
$this->slotItem[ $item['Slot'] ]['id_item'] = $item['Un_Id'];
$this->slotItem[ $item['Slot'] ]['itemName'] = $item['Id'];
$this->slotItem[ $item['Slot'] ]['Name'] = $item['Thing_Name']."\n(долговечность ".$item['NOWwear']."/".$item['MAXwear'].")";
}

}


function isEmptySlot( &$id_slot ){


if( $id_slot == 4 || $id_slot == 5 || $id_slot == 6 ){

for( $i=4; $i < 7; $i++ ){
if( empty($this->slotItem[$i]['id_item']) ){ $id_slot = $i; return true; }
}

} elseif ( empty($this->slotItem[$id_slot]['id_item']) ){ return true; }

return false;
}


function isItemWearOn( $id_item ){
return ( isset($this->items[ $id_item ]) && !empty($this->items[ $id_item ]) );
}


function healTrauma(){
global $db;
		
$query = sprintf("SELECT * FROM ".SQL_PREFIX."inv WHERE Username = '%s';", $this->id_user );
$kr = $db->queryRow($query, "User_healTrauma_1 ");

if( !$kr ){ $healed = 0; }
else {
			
$type3 = $kr['Type3'];
$type2 = $kr['Type2'];
			
switch( $type2 ){
case 1: OldUserStats::setAbilities($this->id_user,array("Stre"=>$this->Stre + $type3)); break;
case 2: OldUserStats::setAbilities($this->id_user,array("Agil"=>$this->Agil + $type3)); break;
case 3: OldUserStats::setAbilities($this->id_user,array("Intu"=>$this->Intu + $type3)); break;
}
			
$query = sprintf("DELETE FROM ".SQL_PREFIX."inv WHERE Username = '%s';", $this->id_user );
$db->execQuery($query, "User_healTrauma_2");
$healed = 1;
}

return $healed;
}




}
?>
