<?php
class ClanRanks {

private $id_clan;


function __construct( $id_clan ){ $this->id_clan = $id_clan; }


function getClanRankAll( ){
global $db;

$query = sprintf("SELECT id_rank, icon as rankIcon, rank_name FROM ".SQL_PREFIX."clan_ranks WHERE id_clan = '%d';", $this->id_clan );
$res = $db->query( $query, "OldAdminClan_getClanRankAll_1" );

$out = array();
while( ($array = mysql_fetch_assoc($res)) ){
$out[ $array['id_rank'] ]['id_rank']= $array['id_rank'];
$out[ $array['id_rank'] ]['Name']	= $array['rank_name'];
$out[ $array['id_rank'] ]['rankIcon']= $array['rankIcon'];
$out[ $array['id_rank'] ]['rules']	= $this->getClanRankRules( $array['id_rank'] );
$out[ $array['id_rank'] ]['abils']	= $this->getClanRankAbils( $array['id_rank'] );
}

return $out;
}



function createClanRank( $rankName ){
global $db;

$query = sprintf("INSERT INTO ".SQL_PREFIX."clan_ranks ( `id_clan`, `rank_name` ) VALUES ( '%d', '%s' );", $this->id_clan, mysql_escape_string($rankName));
$db->execQuery( $query, "ClanRanks_createClanRank_1" );

return $db->insertId();
}



function destroyClanRank( $id_rank ){
global $db;

$this->clearClanRankAbils( $id_rank );
$this->clearClanRankRules( $id_rank );
$this->clearClanRankUsers( $id_rank );

$query = sprintf("DELETE FROM ".SQL_PREFIX."clan_ranks WHERE id_clan = '%d' AND id_rank = '%d';", $this->id_clan, $id_rank );
return $db->execQuery( $query, "ClanRanks_destroyClanRank_1" );
}


function clearClanRankAbils( $id_rank ){
global $db;

//$query = sprintf("DELETE cra FROM ".SQL_PREFIX."clan_ranks_has_admin_abils cra LEFT JOIN ".SQL_PREFIX."clan_ranks cr ON( cr.id_rank = cra.id_rank ) WHERE cr.id_clan = '%d' AND cr.id_rank = '%d';", $this->id_clan, $id_rank );
$query = sprintf("UPDATE ".SQL_PREFIX."clan_ranks SET perm_demands = '0', perm_weapons = '0', perm_align = '0', perm_rank = '0', perm_members = '0', perm_setup = '0' WHERE id_clan = '%d' AND id_rank = '%d';", $this->id_clan, $id_rank );
return $db->execQuery( $query, "ClanRanks_clearClanRankAbils_1" );
}


function clearClanRankRules( $id_rank ){
global $db;


$query = sprintf("DELETE crr FROM ".SQL_PREFIX."clan_ranks_has_admin_rules crr LEFT JOIN ".SQL_PREFIX."clan_ranks cr ON( cr.id_rank = crr.id_rank ) WHERE cr.id_clan = '%d' AND cr.id_rank = '%d';", $this->id_clan, $id_rank );
return $db->execQuery( $query, "ClanRanks_clearClanRankRules_1" );
}


function clearClanRankUsers( $id_rank ){
global $db;

$query = sprintf("UPDATE ".SQL_PREFIX."clan_user SET id_rank = '0' WHERE id_clan = '%d' AND id_rank = '%d';", $this->id_clan, $id_rank );
return $db->execQuery( $query, "ClanRanks_clearClanRankUsers_1" );
}


function getClanRankRules( $id_rank ){
global $db;

$query = sprintf("SELECT ar.id_admin_rules, ar.Name, ar.Title, ar.Time FROM ".SQL_PREFIX."clan_ranks_has_admin_rules crar LEFT JOIN ".SQL_PREFIX."admin_rules ar ON ( ar.id_admin_rules = crar.id_admin_rules ) WHERE crar.id_rank = '%d';", $id_rank );
return  $db->queryArray( $query, "ClanRanks_getClanRankRules_1" );
}


function getClanRankAbils( $id_rank ){
global $db;

$query = sprintf("SELECT ar.id_admin_abils, ar.Name, ar.Title FROM ".SQL_PREFIX."clan_ranks_has_admin_abils crar LEFT JOIN ".SQL_PREFIX."admin_abils ar ON ( ar.id_admin_abils = crar.id_admin_abils ) WHERE crar.id_rank = '%d';", $id_rank );
return $db->queryArray( $query, "ClanRanks_getClanRankAbils_1" );
}


function getClanRankRule( $id_rank, $id_rule ){
global $db;

$query = sprintf("SELECT id_admin_rules FROM ".SQL_PREFIX."clan_ranks_has_admin_rules WHERE id_rank = '%d' AND id_admin_rules = '%d';", $id_rank, $id_rule );
return $db->queryRow( $query, "ClanRanks_getClanRankRule_1" );
}


function getClanRankAbil( $id_rank, $id_abil ){
global $db;

$query = sprintf("SELECT id_admin_abils FROM ".SQL_PREFIX."clan_ranks_has_admin_abils WHERE id_rank = '%d' AND id_admin_abils = '%d';", $id_rank, $id_abil );
return $db->queryRow( $query, "ClanRanks_getClanRankAbil_1" );
}



function addClanRankRule( $id_rank, $id_rule ){
global $db;

$query = sprintf("INSERT INTO ".SQL_PREFIX."clan_ranks_has_admin_rules ( `id_rank`, `id_admin_rules` ) VALUES ( '%d', '%d' );", $id_rank, $id_rule );
return $db->execQuery( $query, "ClanRanks_addClanRankRule_1" );
}


function addClanRankAbil( $id_rank, $id_abil ){
global $db;

$query = sprintf("INSERT INTO ".SQL_PREFIX."clan_ranks_has_admin_abils ( `id_rank`, `id_admin_abils` ) VALUES ( '%d', '%d' );", $id_rank, $id_abil );
return $db->execQuery( $query, "ClanRanks_addClanRankAbil_1" );
}


function delClanRankRule( $id_rank, $id_rule ){
global $db;

$query = sprintf("DELETE FROM ".SQL_PREFIX."clan_ranks_has_admin_rules WHERE id_rank = '%d' AND id_admin_rules = '%d';", $id_rank, $id_rule );
return $db->execQuery( $query, "ClanRanks_delClanRankRule_1" );
}


function delClanRankAbil( $id_rank, $id_abil ){
global $db;

$query = sprintf("DELETE FROM ".SQL_PREFIX."clan_ranks_has_admin_abils WHERE id_rank = '%d' AND id_admin_abils = '%d';", $id_rank, $id_abil );
return $db->execQuery( $query, "ClanRanks_delClanRankAbil_1" );
}


function SetRankAbil( $id_rank, $value ){
global $db;

$query = sprintf("UPDATE ".SQL_PREFIX."clan_ranks SET ".$value." = '1' WHERE id_rank = '%d';", $id_rank );
return $db->execQuery( $query, "ClanRanks_SETClanRankAbil_1" );
}

function setClanRankIcon( $id_rank, $id_icon ){
global $db;

$query = sprintf("UPDATE ".SQL_PREFIX."clan_ranks SET icon = '%d' WHERE id_rank = '%d' AND id_clan = '%d';", $id_icon, $id_rank, $this->id_clan );
return $db->execQuery( $query, "ClanRanks_setClanRankIcon_1" );
}


}
?>
