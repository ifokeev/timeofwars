<?php
class ClanMembers {
	

private $id_clan;

function __construct( $id_clan ){ $this->id_clan = $id_clan; }
	

function removeClanMemberByUsername( $username ){
global $db;
		
$query = sprintf("DELETE FROM ".SQL_PREFIX."clan_user WHERE Username = '%s' AND id_clan = '%d';", mysql_escape_string($username), $this->id_clan );
return $db->execQuery( $query, "ClanMembers_removeClanMemberByUsername_1" );
}

	
function setClanMemberRankByUsername( $username, $id_rank ){
global $db;

$query = sprintf("UPDATE ".SQL_PREFIX."clan_user SET id_rank = '%d' WHERE Username = '%s' AND id_clan = '%d';", $id_rank, mysql_escape_string($username), $this->id_clan );
return $db->execQuery( $query, "ClanMembers_setClanMemberRankByUsername_1" );
}
	
	
function getClanMemberList( ){
global $db;
		
$query = sprintf("SELECT cu.Username, cu.id_rank, cr.rank_name FROM ".SQL_PREFIX."clan_user cu LEFT JOIN ".SQL_PREFIX."clan_ranks cr ON (cr.id_rank=cu.id_rank) WHERE cu.id_clan = '%d';", $this->id_clan );
return $db->queryArray( $query, "ClanMembers_getClanMemberList_1" );
}


function getClanMemberCount( ){
global $db;
		
$query = sprintf("SELECT COUNT(Username) as cnt FROM ".SQL_PREFIX."clan_user WHERE id_clan = '%d';", $this->id_clan );
$res = $db->queryRow( $query, "ClanMembers_getClanMemberCount_1" );
		
return $res['cnt'];
}


}
?>
