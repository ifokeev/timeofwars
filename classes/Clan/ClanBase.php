<?php
class ClanBase {

function __construct( ){ }
	

function getClanInfoById( $id_clan ){
global $db;
		
$query = sprintf("SELECT id_clan, title FROM ".SQL_PREFIX."clan WHERE id_clan = '%d';", $id_clan );
return $db->queryRow( $query, "ClanBase_getClanInfoById_1" );
}
	

	
function getClanInfoExtendedById( $id_clan ){
global $db;
		
$query = sprintf("SELECT c.id_clan, c.title, IFNULL( c.join_price, 0) as join_price, IFNULL( c.left_price, 0) as left_price FROM ".SQL_PREFIX."clan c WHERE c.id_clan = '%d';", $id_clan );
return $db->queryRow( $query, "ClanBase_getClanInfoExtendedById_1" );
}
	
	
	
function getClanInfoFullById( $id_clan ){
global $db;
		
$query = sprintf("SELECT c.id_clan, c.title, c.type, IFNULL( c.join_price, 0) as join_price, IFNULL( c.left_price, 0) as left_price, c.slogan, c.advert, c.link, IFNULL( cu.Username, '') as Username FROM ".SQL_PREFIX."clan c LEFT JOIN ".SQL_PREFIX."clan_user cu ON( cu.id_clan = c.id_clan AND cu.admin = '1' ) WHERE c.id_clan = '%d';", $id_clan );
return $db->queryRow( $query, "ClanBase_getClanInfoFullById_1" );
}
	


function getClanList(){
global $db;
		
$query = sprintf("SELECT id_clan, title, type, join_price, left_price, slogan, advert, link FROM ".SQL_PREFIX."clan ORDER BY type DESC, title;");
return $db->queryArray( $query, 'ClanBase_getClanList_1');

}
	


function createNewClan( $id_clan, $title, $type='CLAN', $joinPrice=0, $leftPrice=0 ){
global $db;
		
$query = sprintf("INSERT INTO ".SQL_PREFIX."clan ( `id_clan`, `title`, `type`, `join_price`, `left_price` ) VALUES ( '%d', '%s', '%s', '%d', '%d' );", $id_clan, $title, $type, $joinPrice, $leftPrice );
return $db->execQuery( $query, "ClanBase_createNewClan_1" );
}
	

function kickClanUser( $username ){ }


}
?>
