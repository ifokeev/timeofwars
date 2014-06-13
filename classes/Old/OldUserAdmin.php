<?php
class OldUserAdmin extends OldUser {

var $adminAbilsAll = array();
var $adminAbils = array();
var $adminRules = array();
var $clanInfo = array();


function OldUserAdmin( $username='', $id_user='', &$fromObj ){

if( is_a( $fromObj, 'OldUser' ) == true ){ $this->initByObject( $fromObj ); }
else{ $this->OldUser( $username, $id_user ); }

$this->adminAbils = $this->getAdminAbils( );
$this->adminRules = $this->getAdminRules( );

if( $this->id_clan != 0 ){ $this->clanInfo = $this->getClanInfo( $this->id_clan ); }
if( isset($this->adminAbils['ALL']) && $this->adminAbils['ALL']==true  ){ $this->adminAbilsAll = self::getAdminAbilsAll(); }

}


function getAdminAbilsAll( ){
global $db;

$allAdminAbils = array();

$query = sprintf("SELECT Name FROM ".SQL_PREFIX."admin_abils;");
$res = $db->query( $query, "UserAdmin_getAllAdminAbils_1" );

while( ($array = mysql_fetch_assoc($res)) ){
$allAdminAbils[$array['Name']] = true;
}

return $allAdminAbils;
}


function getAdminRulesAll( ){
global $db;


$query = sprintf("SELECT ar.id_admin_rules, ar.Name, ar.Title, ar.Time FROM `".SQL_PREFIX."admin_rules` ar ORDER BY ar.Name DESC, ar.Title;");
$res = $db->queryArray( $query, "UserAdmin_getAdminRulesAll_1" );

return $res;
}


function getAdminAbils( ){
/*global $db;

$adminAbils = array();

$query = sprintf("
SELECT aa.Name FROM `".SQL_PREFIX."user_has_admin_abils` uhaa LEFT JOIN `".SQL_PREFIX."admin_abils` aa ON (aa.`id_admin_abils` = uhaa.`id_admin_abils`) WHERE uhaa.`Username` = '%s' UNION
SELECT aa.Name FROM `".SQL_PREFIX."clan_has_admin_abils` chaa LEFT JOIN `".SQL_PREFIX."admin_abils` aa ON (aa.`id_admin_abils` = chaa.`id_admin_abils`) WHERE chaa.`id_clan` = '%d' AND '1' = '%d' UNION
SELECT aa.Name FROM `".SQL_PREFIX."clan_ranks_has_admin_abils` crhaa LEFT JOIN `".SQL_PREFIX."admin_abils` aa ON (aa.id_admin_abils = crhaa.id_admin_abils) WHERE crhaa.`id_rank` = '%d' AND aa.id_admin_abils IS NOT NULL;",
$this->username, $this->id_clan, $this->clanAdmin, $this->id_rank );

$res = $db->query( $query, "UserAdmin_getAccessLevel_1" );

while ( ($array = mysql_fetch_assoc($res)) ) {
$adminAbils[$array['Name']] = true;
}


return $adminAbils;     */
}



function getAdminRules( ){
/*global $db;

if( isset($this->adminAbils['ALL']) && $this->adminAbils['ALL']==true  ){ return self::getAdminRulesAll(); }

$query = sprintf("
SELECT ar.id_admin_rules, ar.Name, ar.Title, ar.Time FROM `".SQL_PREFIX."user_has_admin_rules` uha LEFT JOIN `".SQL_PREFIX."admin_rules` ar ON (ar.id_admin_rules = uha.id_admin_rules) WHERE uha.`Username` = '%s' AND ar.id_admin_rules IS NOT NULL UNION
SELECT ar.id_admin_rules, ar.Name, ar.Title, ar.Time FROM `".SQL_PREFIX."clan_has_admin_rules` cha LEFT JOIN `".SQL_PREFIX."admin_rules` ar ON (ar.id_admin_rules = cha.id_admin_rules) WHERE cha.`id_clan` = '%d' AND '1' = '%d' AND ar.id_admin_rules IS NOT NULL UNION
SELECT ar.id_admin_rules, ar.Name, ar.Title, ar.Time FROM `".SQL_PREFIX."clan_ranks_has_admin_rules` crha LEFT JOIN `".SQL_PREFIX."admin_rules` ar ON (ar.id_admin_rules = crha.id_admin_rules) WHERE crha.`id_rank` = '%d' AND ar.id_admin_rules IS NOT NULL ORDER BY Name DESC, Title;",
$this->username, $this->id_clan, $this->clanAdmin, $this->id_rank
);

return $db->queryArray( $query, "UserAdmin_getAdminRules_1" );  */
}


function getAdminRuleActive( $id_admin_rules = 0 ){

if( $id_admin_rules < 1 ){ return false; }

if( isset($this->adminAbils['ALL']) && $this->adminAbils['ALL']==true ){

for( $i=0; $i < count($this->adminRules); $i++ ){
if( $this->adminRules[$i]['id_admin_rules'] == $id_admin_rules ){ return $this->adminRules[$i]; }
}

}


for( $i=0; $i < count($this->adminRules); $i++ ){
if( $this->adminRules[$i]['id_admin_rules'] == $id_admin_rules ){ return $this->adminRules[$i]; }
}

return false;
}



function hasAdminAbil( $name='' ){

if( $name == '' ){ return false; }

if( isset($this->adminAbils['ALL']) && $this->adminAbils['ALL']==true  ){
if( !isset($this->adminAbilsAll[$name]) || $this->adminAbilsAll[$name]!=true ){
self::addAdminAbil($name);
}
return true;
}


if( isset($this->adminAbils[$name]) ){
return $this->adminAbils[$name];

}

return false;
}


function hasAnyAccess( ){
global $db;

if( count($this->adminAbils) > 0 ){ return true; }
else{ return false; }
}


function addAdminAbil( $name='' ){
global $db;

if( $name == '' ){ return ; }

$query = sprintf("INSERT INTO ".SQL_PREFIX."admin_abils ( Name ) VALUES ( '%s' );", strtoupper( $name ) );
$db->execQuery( $query, "UserAdmin_addAdminAbil_1" );
}


function clearUserAbils( ){
global $db;

$query = sprintf("DELETE FROM ".SQL_PREFIX."user_has_admin_abils WHERE Username = '%s';", $this->username );
return $db->execQuery( $query, "OldUserAdmin_cleanUserAbils_1" );
}


function addUserAbil( $id_abil ){
global $db;

$query = sprintf("INSERT INTO ".SQL_PREFIX."user_has_admin_abils ( `Username`, `id_admin_abils` ) VALUES ( '%s', '%d' );", $this->username, $id_abil );
return $db->execQuery( $query, "OldUserAdmin_addUserAbil_1" );
}


function getUserAbilList( ){
global $db;

$query = sprintf("SELECT uar.id_admin_abils, ar.Name, ar.Title FROM ".SQL_PREFIX."user_has_admin_abils uar LEFT JOIN ".SQL_PREFIX."admin_abils ar ON (ar.id_admin_abils = uar.id_admin_abils) WHERE uar.Username = '%s' ORDER BY ar.Title;", $this->username );
return  $db->queryArray( $query, "OldUserAdmin_getUserAbilList_1" );
}


function clearUserRules( ){
global $db;

$query = sprintf("DELETE FROM ".SQL_PREFIX."user_has_admin_rules WHERE Username = '%s';", $this->username );
return $db->execQuery( $query, "OldUserAdmin_cleanUserRules_1" );
}


function addUserRule( $id_rule ){
global $db;

$query = sprintf("INSERT INTO ".SQL_PREFIX."user_has_admin_rules ( `Username`, `id_admin_rules` ) VALUES ( '%s', '%d' );", $this->username, $id_rule );
return $db->execQuery( $query, "OldUserAdmin_addUserRule_1" );
}


function getUserRuleList( ){
global $db;

$query = sprintf("SELECT uar.id_admin_rules, ar.Name, ar.Title, ar.Time FROM ".SQL_PREFIX."user_has_admin_rules uar LEFT JOIN ".SQL_PREFIX."admin_rules ar ON (ar.id_admin_rules = uar.id_admin_rules) WHERE uar.Username = '%s' ORDER BY ar.Title ;", $this->username );
return  $db->queryArray( $query, "OldUserAdmin_getUserRuleList_1" );
}


}
?>
