<?php
class OldAdminAbils {

function __construct( ){ }
	

function createAbil( $name = '', $title = '' ){
global $db;
		
$name = strtoupper( $name );
$name = preg_replace('/[^A-Z\\_]/', '', $name);
		
if( $name == '' ){ $msgError = '������ ���� ������ ��� ��������.'; }
elseif( $title == '' ){ $msgError = '������ ���� ������ ��������/�������� ��������.'; }
else{
		
$query = sprintf("INSERT INTO ".SQL_PREFIX."admin_abils ( `Name`, `Title` ) VALUES ( '%s', '%s' );", $name, $title );
$db->execQuery( $query, "AdminAbils_createAbil_1" );

$msgError = '�������� ���������';

}
		
return $msgError;
}
	
	

function saveAbil( $id_admin_abils=0, $name="", $title="" ){
global $db;
		
$id_admin_abils = intval($id_admin_abils);
$name = strtoupper( $name );
$name = preg_replace('/[^A-Z\\_]/', '', $name);
		
if( $id_admin_abils < 1 ){ $msgError = '�������� ID ��������.'; }
elseif( !self::getAbilById( $id_admin_abils ) ){ $msgError = '������ ���� ������ ��� ��������.'; }
elseif( $name == '' ){ $msgError = '������ ���� ������ ��� ��������.'; }
elseif( $title == '' ){ $msgError = '������ ���� ������ ��������/�������� ��������.'; }
else{
			
$query = sprintf("UPDATE ".SQL_PREFIX."admin_abils SET Name = '%s', Title = '%s' WHERE id_admin_abils = '%d';", $name, $title, $id_admin_abils );
$db->execQuery( $query, "AdminAbils_saveAbil_1" );
		
		$msgError = '�������� ��������.';
		
}
		
return $msgError;
}
	
	
	
function destroyAbil( $id_admin_abils=0 ){
global $db;
		
$id_admin_abils = intval( $id_admin_abils );
		
if( $id_admin_abils < 1 ){ $msgError = '�������� ID ��������.'; }
else{
			
$query = sprintf("DELETE ar, car, uar FROM ".SQL_PREFIX."admin_abils ar, ".SQL_PREFIX."clan_has_admin_abils car, ".SQL_PREFIX."user_has_admin_abils uar WHERE car.id_admin_abils = ar.id_admin_abils AND uar.id_admin_abils = ar.id_admin_abils ar.id_admin_abils = '%d';", $id_admin_abils );
$db->execQuery( $query, "AdminAbils_destroyAbil_1" );
			
$msgError = '�������� �������.';

}
		
return $msgError;
}
	
	

function addAbilClan( $id_clan=0, $id_admin_abils=0 ){
global $db;
		
$id_clan = intval( $id_clan );
$id_admin_abils = intval( $id_admin_abils );
		
if( $id_clan < 1 ){ $msgError = '�������� ����� �����.'; }
elseif( $id_admin_abils < 1 ){ $msgError = '�������� ����� ��������.'; }
elseif( self::hasClanAbil( $id_clan, $id_admin_abils ) ){ $msgError = '� ����� ��� ���� ����� ��������.'; }
else{
		
$query = sprintf("INSERT INTO ".SQL_PREFIX."clan_has_admin_abils ( `id_clan`, `id_admin_abils` ) VALUES ( '%d', '%d' );", $id_clan, $id_admin_abils );
$db->execQuery( $query, "AdminAbils_addAbilClan_1" );

$msgError = '����� '.$id_clan.' ��������� ����� ��������.';

}
		
return $msgError;
}
	
	
	
function delAbilClan( $id_clan=0, $id_admin_abils=0 ){
global $db;
		
$id_clan = intval( $id_clan );
$id_admin_abils = intval( $id_admin_abils );
		
if( $id_clan < 1 ){ $msgError = '�������� ����� �����.'; }
elseif( $id_admin_abils < 1 ){ $msgError = '�������� ����� ��������.'; }
elseif( !self::hasClanAbil( $id_clan, $id_admin_abils ) ){ $msgError = '� ����� ��� ������ ��������.'; }
else{
			
$query = sprintf("DELETE FROM ".SQL_PREFIX."clan_has_admin_abils WHERE id_clan = '%d' AND id_admin_abils = '%d';", $id_clan, $id_admin_abils );
$db->execQuery( $query, "AdminAbils_delAbilClan_1" );
			
$msgError = '�������� ��� ����� '.$id_clan.' ������� �������.';

}
		
return $msgError;
}
	
	
	
function hasClanAbil( $id_clan=0, $id_admin_abils=0 ){
global $db;
		
$id_clan = intval( $id_clan );
$id_admin_abils = intval( $id_admin_abils );
		
if( $id_clan < 1 ){ $msgError = false; }
elseif( $id_admin_abils < 1 ){ $msgError = false; }
else{
			
$query = sprintf("SELECT id_admin_abils FROM ".SQL_PREFIX."clan_has_admin_abils WHERE id_clan = '%d' AND id_admin_abils = '%d';", $id_clan, $id_admin_abils );
$msgError = $db->queryCheck( $query, "AdminAbils_hasClanAbil_1" );

}
		
return $msgError;
}
	
	
	
function getAbilClanAll( ){
global $db;
		
$out = array();
		
$query = sprintf("SELECT c.title, car.id_clan, car.id_admin_abils, ar.Title FROM ".SQL_PREFIX."clan_has_admin_abils car LEFT JOIN ".SQL_PREFIX."admin_abils ar ON (ar.id_admin_abils = car.id_admin_abils) LEFT JOIN ".SQL_PREFIX."clan c ON (c.id_clan = car.id_clan) ORDER BY car.id_clan, ar.Title;");
$res = $db->query( $query, "AdminAbils_getAbilClanAll_1" );
		
while( ($array = mysql_fetch_assoc($res)) ){
$out[$array['id_clan']][] = $array;
}
		
return $out;
}
	
	
	
function addAbilUser( $username="", $id_admin_abils=0 ){
global $db;
		
$id_admin_abils = intval( $id_admin_abils );
		
if( $username == '' ){ $msgError = '�������������� ������������.'; }
elseif( $id_admin_abils < 1 ){ $msgError = '�������� ����� ��������.'; }
elseif( self::hasUserAbil( $username, $id_admin_abils ) ){ $msgError = '� ������������ ��� ���� ����� ��������.'; }
else{
		
$query = sprintf("INSERT INTO ".SQL_PREFIX."user_has_admin_abils ( `Username`, `id_admin_abils` ) VALUES ( '%s', '%d' );", $username, $id_admin_abils );
$db->execQuery( $query, "AdminAbils_addAbilUser_1" );
			
$msgError = '������������ '.$username.' ��������� ����� ��������.';

}
		
return $msgError;
}
	

	
function delAbilUser( $username="", $id_admin_abils=0 ){
global $db;
		
$id_admin_abils = intval( $id_admin_abils );
		
if( $username == '' ){ $msgError = '�������� ������������.'; }
elseif( $id_admin_abils < 1 ){ $msgError = '�������� ����� ��������.'; }
elseif( !self::hasUserAbil( $username, $id_admin_abils ) ){ $msgError = '� ������������ ��� ������ ��������.'; }
else{
			
$query = sprintf("DELETE FROM ".SQL_PREFIX."user_has_admin_abils WHERE Username = '%s' AND id_admin_abils = '%d';", $username, $id_admin_abils );
$db->execQuery( $query, "AdminAbils_delAbilUser_1" );
			
$msgError = '�������� ��� ������������ '.$username.' ������� �������.';

}
		
return $msgError;
}
	

	
function hasUserAbil( $username="", $id_admin_abils=0 ){
global $db;
		
$id_admin_abils = intval( $id_admin_abils );
		
if( $username == '' ){ $msgError = false; }
elseif( $id_admin_abils < 1 ){ $msgError = false; }
else{
			
$query = sprintf("SELECT id_admin_abils FROM ".SQL_PREFIX."user_has_admin_abils WHERE Username = '%s' AND id_admin_abils = '%d';", $username, $id_admin_abils );
$msgError = $db->queryCheck( $query, "AdminAbils_hasUserAbil_1" );

}
		
return $msgError;
}
	
	
	
function getAbilById( $id_admin_abils ){
global $db;
		
$id_admin_abils = intval($id_admin_abils);
		
if( $id_admin_abils < 1 ){ return false; }
		
$query = sprintf("SELECT * FROM ".SQL_PREFIX."admin_abils WHERE id_admin_abils = '%d';", $id_admin_abils );
return $db->queryRow( $query, "AdminAbils_getAbilById_1" );
}
	
	
function getAbilUserAll( ){
global $db;
		
$out = array();
		
$query = sprintf("SELECT uar.Username, uar.id_admin_abils, ar.Title FROM ".SQL_PREFIX."user_has_admin_abils uar LEFT JOIN ".SQL_PREFIX."admin_abils ar ON (ar.id_admin_abils = uar.id_admin_abils) ORDER BY uar.Username, ar.Title;" );
$res = $db->query( $query, "AdminAbils_getAbilUserAll_1" );
		
while( ($array = mysql_fetch_assoc($res)) ){
$out[$array['Username']][] = $array;
}
		
return $out;
}
	


function getAbilAll( ){
global $db;
		
$out = array();
		
$query = sprintf("SELECT * FROM ".SQL_PREFIX."admin_abils ORDER BY Title;");
return $db->queryArray( $query, "AdminAbils_getAbilAll_1" );
}
	

	
function getAbilReady( ){
global $db;
		
$query = sprintf("SELECT id_admin_abils, Name, Title FROM ".SQL_PREFIX."admin_abils WHERE Title IS NOT NULL ORDER BY Title;");
return $db->queryArray( $query, "AdminAbils_getAbilReady_1" );
}


}
?>
