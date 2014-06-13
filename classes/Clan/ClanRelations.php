<?php
class ClanRelations {

private $id_clan;

function __construct( $id_clan ){ $this->id_clan = $id_clan; }


function setRelation( $id_clan, $relation='', $reason='' ){
global $db;

$id_clan = intval($id_clan);
$relation = mysql_escape_string($relation);
$reason = mysql_escape_string($reason);

$query = sprintf("INSERT INTO ".SQL_PREFIX."clan_relations (id_clan_from, id_clan_to, relation_type, reason) VALUES ('%d', '%d', '%s', '%s') ON DUPLICATE KEY UPDATE relation_type = '%s', reason = '%s';", $this->id_clan, $id_clan, $relation, $reason, $relation, $reason );
$db->execQuery( $query, "cl_addClanRelation_1" );

}


function getRelationList( ){
global $db;

$query = sprintf("SELECT c.id_clan, c.title, IFNULL( cr1.relation_type, 'NEUTRAL' ) as relationFrom, IFNULL( cr1.reason, '' ) as reasonFrom, IFNULL( cr2.relation_type, 'NEUTRAL' ) as relationTo, IFNULL( cr2.reason, '' )as reasonTo FROM ".SQL_PREFIX."clan c LEFT JOIN ".SQL_PREFIX."clan_relations cr1 ON (cr1.id_clan_from = c.id_clan	AND cr1.id_clan_to = '%d' ) LEFT JOIN ".SQL_PREFIX."clan_relations cr2 ON (cr2.id_clan_from = '%d' AND cr2.id_clan_to=c.id_clan) WHERE c.id_clan != '%d' ORDER BY c.type, c.title;", $this->id_clan, $this->id_clan, $this->id_clan );
return $db->queryArray( $query, "ClanRelations_getRelationList_1" );
}



function getRelationActionTitle( $relation ){

switch( $relation ){
case 'WAR': $relationTxt      = ' ������� ����� ����� ';                    break;
case 'PEACE': $relationTxt    = ' �������� ��� � ������ ';                  break;
case 'ALLIANCE': $relationTxt = ' �������� ���� � ������';                  break;
case 'NEUTRAL': $relationTxt  = ' ������ ����������� �� ��������� � �����'; break;
}

return $relationTxt;
}



function getRelationTitle( $relation ){

switch( $relation ){
case 'WAR':       $align_txt = 'bgcolor="#ff7171">�����';    break;
case 'PEACE':     $align_txt = 'bgcolor="#99cc00">���';      break;
case 'ALLIANCE':  $align_txt = 'bgcolor="#0099cc">����';     break;
case 'NEUTRAL':   $align_txt = '>�������';  break;
}

return $align_txt;
}



}
?>
