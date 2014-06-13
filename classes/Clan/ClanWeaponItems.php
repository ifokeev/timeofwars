<?php
class ClanWeaponItems {

private $id_clan;

public function __construct( $id_clan ){ $this->id_clan = $id_clan; }


public function getItem( $id_item ){
global $db;

$query = sprintf("SELECT cwi.id_item, cwi.cost, cwi.timeINuse, t.Owner, t.Endu_add, t.Stre_add, t.Agil_add, t.Intu_add, t.Level_add, t.Slot, t.NOWwear, t.Wear_ON FROM ".SQL_PREFIX."clan_weapon_items cwi INNER JOIN ".SQL_PREFIX."things t ON(t.Un_Id=cwi.id_item) WHERE cwi.id_clan = '%d' AND cwi.id_item = '%d';", $this->id_clan, $id_item );
return $db->queryRow( $query, "ClanWeaponItems_getItem_1" );
}


public function getItemsAll( $slot = '' ){
global $db;

if( $slot == '' ){
$query = sprintf("SELECT * FROM ".SQL_PREFIX."clan_weapon_items ci LEFT JOIN ".SQL_PREFIX."things t ON(t.Un_Id = ci.id_item) WHERE id_clan = '%d'", $this->id_clan );
}else{$query = sprintf("SELECT * FROM ".SQL_PREFIX."clan_weapon_items ci LEFT JOIN ".SQL_PREFIX."things t ON(t.Un_Id = ci.id_item) WHERE id_clan = '%d' AND t.Slot = '%d';", $this->id_clan, $slot);
}

return $db->queryArray( $query, "ClanItems_getItemsAll_1" );
}




private function setItemLocation( $id_item, $location ){
global $db;

if( $location == 'STORE' )
{	$query = sprintf("UPDATE ".SQL_PREFIX."clan_weapon_items SET location = '%s' WHERE id_item = '%d' AND id_clan = '%d';", mysql_escape_string(strtoupper($location)), $id_item, $this->id_clan );
}
else
{	$query = sprintf("UPDATE ".SQL_PREFIX."clan_weapon_items SET location = '%s', timeINuse = '%s' WHERE id_item = '%d' AND id_clan = '%d';", mysql_escape_string(strtoupper($location)), time(), $id_item, $this->id_clan );
}

return $db->execQuery( $query, "ClanWeaponItems_setItemLocation_1" );
}


public function setItemOwner( $id_item, $username="" ){
global $db;

if( $username == '' ){ $this->setItemLocation( $id_item, 'STORE' ); }
else{ $this->setItemLocation( $id_item, 'INUSE' ); }


$query = sprintf("UPDATE ".SQL_PREFIX."things SET Owner = '%s' WHERE Un_Id = '%d';", $username, $id_item );
return $db->execQuery( $query, "ClanWeaponItems_setItemOwner_1" );
}


public function addClanWeaponItem( $id_item, $username, $cost = 1 ){
global $db;

$query = sprintf("INSERT INTO `".SQL_PREFIX."clan_weapon_items` ( `id_item`, `id_clan`, `Owner`, `cost` ) SELECT Un_Id, '%d', Owner, '%.2f' FROM ".SQL_PREFIX."things WHERE Owner = '%s' AND Un_Id = '%d' ON DUPLICATE KEY UPDATE id_clan = '%d', location = 'STORE';", $this->id_clan, $cost, $username, $id_item, $this->id_clan );
$db->execQuery( $query, "ClanWeaponItems_addClanWeaponItem_1" );
return $this->setItemOwner( $id_item, '' );
}


public function delClanWeaponItem( $id_item, $username ){
global $db;

$query = sprintf("DELETE FROM ".SQL_PREFIX."clan_weapon_items WHERE id_clan = '%d' AND id_item = '%d';", $this->id_clan, $id_item );
$db->execQuery( $query, "ClanWeaponItems_delClanWeaponItem_1" );

return $this->setItemOwner( $id_item, $username );
}



public function getClanWeaponItemList(){
global $db;

$query = sprintf("SELECT cwi.cost, cwi.timeINuse, t.Un_Id as id_item, t.Thing_Name, t.Owner FROM ".SQL_PREFIX."clan_weapon_items cwi INNER JOIN `".SQL_PREFIX."things` t ON(t.Un_Id=cwi.id_item) LEFT JOIN ".SQL_PREFIX."clan_weapon_demands cwd ON(cwd.id_item=cwi.id_item) WHERE cwi.id_clan = '%d' AND cwi.location = 'INUSE';", $this->id_clan );
return $db->queryArray( $query, "ClanWeaponItems_getClanWeaponItemList_1" );
}


public function getUserBackpackItemList( $username ){
global $db;

$query = sprintf("SELECT cwi.location, cwi.cost, cwi.id_item, cwi.timeINuse, t.Thing_Name FROM ".SQL_PREFIX."clan_weapon_items cwi LEFT JOIN `".SQL_PREFIX."things` t ON(cwi.id_item=t.Un_Id) WHERE t.Owner = '%s' AND t.Wear_ON = '0';", $username );
return $db->queryArray( $query, "ClanWeaponItems_getUserBackpackItemList_1" );
}


}
?>
