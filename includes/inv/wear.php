<?
if ( !empty($wear) ) {
if( $db->SQL_result($db->query( "SELECT tu.turnir_id FROM ".SQL_PREFIX."turnir_users as tu LEFT JOIN ".SQL_PREFIX."turnir as t ON( t.id = tu.turnir_id ) WHERE tu.user = '".$player->username."' AND t.status = '1';"),0) ){ $err = '������ ���-���� �����, �������� � �������.'; }
else{ $err = $player->wear($wear); }
}
?>
