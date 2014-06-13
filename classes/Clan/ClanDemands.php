<?php
class ClanDemands {

private $id_clan;


function __construct( $id_clan ){ $this->id_clan = $id_clan; }


function getClanDemandsList( ){
global $db;

$query = sprintf("SELECT cd.Username, p.Level, cu.id_clan as ClanID, c.id_clan, c.join_price FROM ".SQL_PREFIX."clan_demands cd LEFT JOIN ".SQL_PREFIX."players p ON (p.Username=cd.Username) LEFT JOIN ".SQL_PREFIX."clan c ON (c.id_clan = cd.id_clan) LEFT JOIN ".SQL_PREFIX."clan_user cu ON (cu.Username = cd.Username) WHERE cd.id_clan = '%d';", $this->id_clan );
return $db->queryArray( $query, "ClanDemands_getClanDemandsList_1" );
}



function getClanDemandsByUsername( $username ){
global $db;

$query = sprintf("SELECT p.ClanID, c.id_clan, c.join_price FROM ".SQL_PREFIX."clan_demands cd LEFT JOIN ".SQL_PREFIX."clan c ON( c.id_clan = cd.id_clan ) LEFT JOIN ".SQL_PREFIX."players p ON(p.Username = cd.Username) WHERE cd.Username = '%s';", $username );
return $db->queryCheck( $query, "ClanDemands_getDemandsByUsername_1" );
}



function addClanDemandByUsername( $username, $id_clan, $txt ){
global $db;

$query = sprintf("INSERT INTO ".SQL_PREFIX."clan_demands ( Username, id_clan, text ) VALUES ( '%s', '%d', '%s');", $username, $id_clan, $txt );
return $db->execQuery( $query, "cl_addClanDemand_1" );
}



function delClanDemandByUsername( $username ){
global $db;

$query = sprintf("DELETE FROM ".SQL_PREFIX."clan_demands WHERE Username = '%s';", $username );
return $db->execQuery( $query, "ClanDemands_delClanDemandByUsername_1" );
}



function acceptClanDemandByUsername( $username ){
global $db;

$query = sprintf("INSERT INTO ".SQL_PREFIX."clan_user (id_clan, Username) SELECT cd.id_clan, cd.Username FROM ".SQL_PREFIX."clan_demands cd WHERE cd.Username = '%s' AND cd.id_clan = '%d' ON DUPLICATE KEY UPDATE id_clan = cd.id_clan, id_rank = 0, admin = 0;", $username, $this->id_clan );
return $db->execQuery( $query, "ClanDemands_acceptClanDemandByUsername_1" );
}



function rejectClanDemandByUsername( $username ){
global $db;

$query = sprintf("DELETE FROM ".SQL_PREFIX."clan_demands WHERE Username = '%s' AND id_clan  = '%d';", $username, $this->id_clan );
return $db->execQuery( $query, "ClanDemands_rejectClanDemandByUsername_1" );
}



}
?>
