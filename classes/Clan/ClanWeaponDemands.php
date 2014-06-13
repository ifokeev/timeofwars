<?php
class ClanWeaponDemands {

public $id_item;


public function __construct( $id_item ){ $this->id_item = $id_item; }


public function addItemDemand( $username ){
global $db;

$query = sprintf("INSERT INTO `".SQL_PREFIX."clan_weapon_demands` (id_item, Username, addTime) VALUES ( '%d', '%s', '%d');", $this->id_item, $username, time() );
$db->execQuery( $query, "ClanWeaponDemands_addDemand_1" );

return $db->insertId();
}


public function getItemDemandByUsername( $username ){
global $db;

$query = sprintf("SELECT id_item, Username, addTime, status FROM ".SQL_PREFIX."clan_weapon_demands WHERE id_item = '%d' AND Username = '%s';", $this->id_item, $username );

return $db->queryRow( $query, "ClanWeaponDemands_getItemDemandByUsername_1" );
}


public function delItemDemand( $username ){
global $db;

$query = sprintf("DELETE FROM ".SQL_PREFIX."clan_weapon_demands WHERE id_item = '%d' AND Username = '%s';", $this->id_item, $username  );
return $db->execQuery( $query, "ClanWeaponDemands_delItemDemand_1" );
}


public function setItemDemand( $username, $status ){
global $db;

$query = sprintf("UPDATE ".SQL_PREFIX."clan_weapon_demands SET status = '%s' WHERE id_item = '%d' AND Username = '%s';", mysql_escape_string(strtoupper($status)), $this->id_item, $username );
return $db->execQuery( $query, "ClanWeaponDemands_setItemDemand_1" );
}


public function getItemDemandsList( ){
global $db;

$query = sprintf("SELECT id_item, Username, addTime, status FROM ".SQL_PREFIX."clan_weapon_demands WHERE id_item = '%d';", $this->id_item );
return $db->queryArray( $query, "ClanWeaponDemands_getItemDemandsList_1" );
}



}
?>
