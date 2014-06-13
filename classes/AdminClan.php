<?php
class OldAdminClan {

function AdminClan() {	}

function getClanAll( ){
global $db;

$query = sprintf("SELECT * FROM ".SQL_PREFIX."clan;");
return $db->queryArray( $query, "AdminClan_getClanAll_1" );
}


function getClanRank( $id_clan, $id_rank ){
global $db;

$query = sprintf("SELECT id_rank, rank_name as Title FROM ".SQL_PREFIX."clan_ranks cr WHERE cr.id_clan = '%d' AND cr.id_rank = '%d';", $id_clan, $id_rank);
return $db->queryRow( $query, "OldAdminClan_getClanRank_1" );
}


function getClanRankAll( $id_clan ){
global $db;

$query = sprintf("SELECT id_rank, icon as rankIcon, rank_name FROM ".SQL_PREFIX."clan_ranks cr WHERE cr.id_clan = '%d';", $id_clan);
$res = $db->query( $query, "OldAdminClan_getClanRankAll_1" );

$out = array();

while( ($array = mysql_fetch_assoc($res)) ){
$out[ $array['id_rank'] ]['id_rank']= $array['id_rank'];
$out[ $array['id_rank'] ]['Name']	= $array['rank_name'];
$out[ $array['id_rank'] ]['rankIcon']= $array['rankIcon'];
$out[ $array['id_rank'] ]['rules']	= self::getClanRankRules( $array['id_rank'] );
}

return $out;
}


function getClanRankRules( $id_rank=0 ){
global $db;

if( $id_rank < 1 ){ return array(); }

$query = sprintf("SELECT ar.id_admin_rules, ar.Name, ar.Title, ar.Time FROM ".SQL_PREFIX."clan_ranks_has_admin_rules crar LEFT JOIN ".SQL_PREFIX."admin_rules ar ON ( ar.id_admin_rules = crar.id_admin_rules ) WHERE crar.id_rank = '%d';", $id_rank);
return  $db->queryArray( $query, "OldAdminClan_getClanRankRules_1" );
}


function addClanRank( $id_clan=0, $rankName=0 ){
global $db;

$query = sprintf("INSERT INTO ".SQL_PREFIX."clan_ranks ( `id_clan`, `rank_name` ) VALUES ( '%d', '%s' );", $id_clan, mysql_escape_string( $rankName ));
$db->execQuery( $query, "OldAdminClan_addClanRank_1" );

if( $db->insertId() > 0 ){ $msgError = 'Создано новый ранг "'.$rankName.'" создан успешно.'; }
else{ $msgError = 'В процессе создания произошла ошибка. Попробуйте повторить позднее.'; }

}



function delClanRank( $id_clan=0, $id_rank=0 ){
global $db;

if( $id_clan < 1 ){ $msgError = 'Неверный клан.'; }
elseif( $id_rank < 1 ){ $msgError = 'Неверный ранг.'; }
else{


$res = $db->query( $query, "OldAdminClan_delClanRank_1" );

$query = sprintf("DELETE crr FROM ".SQL_PREFIX."clan_ranks_has_admin_rules crr LEFT JOIN clan_ranks cr ON( cr.id_rank = crr.id_rank ) WHERE cr.id_clan = '%d' AND cr.id_rank = '%d';", $id_clan, $id_rank);
$res = $db->query( $query, "OldAdminClan_delClanRank_2" );

$query = sprintf("DELETE cr FROM ".SQL_PREFIX."clan_ranks cr WHERE cr.id_clan = '%d' AND cr.id_rank = '%d';",$id_clan, $id_rank);
$db->execQuery( $query, "OldAdminClan_delClanRank_3" );

$msgError = 'Заданный ранг уничтожен.';

}

return $msgError;
}

}
?>
