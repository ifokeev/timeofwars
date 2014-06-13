<?php
class OldAdminRules {

function OldAdminRules( ){ }
	
	
function createRule( $name = '', $title = '', $time = 0 ){
global $db;
		
$name = strtolower( $name );
$name = preg_replace('/[^a-z\\_]/', '', $name);
		
if( $name == '' ){ $msgError = 'Должно быть задано имя действия.'; }
elseif( $title == '' ){ $msgError = 'Должно быть задано название/описание правила.'; }
elseif( $time < 1 ){ $msgError = 'Должно быть задано время больше 0.'; }
else{
		
$query = sprintf("INSERT INTO ".SQL_PREFIX."admin_rules ( `Name`, `Title`, `Time` ) VALUES ( '%s', '%s', '%d' );", $name, $title, $time );
$db->execQuery( $query, "AdminRules_createRule_1" );
			
$msgError = 'Правило добавлено';

}
		
return $msgError;
}
	
	
	
function destroyRule( $id_admin_rules=0 ){
global $db;
		
$id_admin_rules = intval( $id_admin_rules );
		
if( $id_admin_rules < 1 ){ $msgError = 'Неверный ID правила.'; }
else{
			
$query = sprintf("DELETE ar, car, uar FROM ".SQL_PREFIX."admin_rules ar, ".SQL_PREFIX."clan_has_admin_rules car, ".SQL_PREFIX."user_has_admin_rules uar WHERE car.id_admin_rules = ar.id_admin_rules AND uar.id_admin_rules = ar.id_admin_rules ar.id_admin_rules = '%d';", $id_admin_rules );
$db->execQuery( $query, "AdminRules_destroyRule_1" );
			
$msgError = 'Правило удалено.';

}
		
return $msgError;
}


	
function updateRules( $id_admin_rules, $title, $time ){ }
	
	

function addRuleClan( $id_clan=0, $id_admin_rules=0 ){
global $db;
		
$id_clan = intval( $id_clan );
$id_admin_rules = intval( $id_admin_rules );
		
if( $id_clan < 1 ){ $msgError = 'Неверный номер клана.'; }
elseif( $id_admin_rules < 1 ){ $msgError = 'Неверный номер правила.'; }
elseif( self::hasClanRule( $id_clan, $id_admin_rules ) ){ $msgError = 'У клана уже есть такое правило.'; }
else{
		
$query = sprintf("INSERT INTO ".SQL_PREFIX."clan_has_admin_rules ( `id_clan`, `id_admin_rules` ) VALUES ( '%d', '%d' );", $id_clan, $id_admin_rules );
$db->execQuery( $query, "AdminRules_addRuleClan_1" );
			
$msgError = 'Клану '.$id_clan.' добавлено новое правило.';

}
		
return $msgError;
}
	
	

function delRuleClan( $id_clan=0, $id_admin_rules=0 ){
global $db;
		
$id_clan = intval( $id_clan );
$id_admin_rules = intval( $id_admin_rules );
		
if( $id_clan < 1 ){ $msgError = 'Неверный номер клана.'; }
elseif( $id_admin_rules < 1 ){ $msgError = 'Неверный номер правила.'; }
elseif( !self::hasClanRule( $id_clan, $id_admin_rules ) ){ $msgError = 'У клана нет такого правила.'; }
else{
			
$query = sprintf("DELETE FROM ".SQL_PREFIX."clan_has_admin_rules WHERE id_clan = '%d' AND id_admin_rules = '%d';", $id_clan, $id_admin_rules );
$db->execQuery( $query, "AdminRules_delRuleClan_1" );
			
$msgError = 'Правило для клана '.$id_clan.' успешно удалено.';

}
		
return $msgError;
}
	
	
	
function addRuleClanRank( $id_rank=0, $id_admin_rules=0 ){
global $db;
		
$id_rank = intval( $id_rank );
$id_admin_rules = intval( $id_admin_rules );
		
if( $id_rank < 1 ){ $msgError = 'Неверный номер ранга.'; }
elseif( $id_admin_rules < 1 ){ $msgError = 'Неверный номер правила.'; }
elseif( self::hasClanRankRule( $id_rank, $id_admin_rules ) ){ $msgError = 'У ранга уже есть такое правило.'; }
else{
		
$query = sprintf("INSERT INTO ".SQL_PREFIX."clan_ranks_has_admin_rules ( `id_rank`, `id_admin_rules` ) VALUES ( '%d', '%d' );", $id_rank, $id_admin_rules );
$db->execQuery( $query, "AdminRules_addRuleClanRank_1" );
			
$msgError = 'Рангу '.$id_rank.' добавлено новое правило.';

}
		
return $msgError;
}
	

	
function delRuleClanRank( $id_rank=0, $id_admin_rules=0 ){
global $db;
		
$id_rank = intval( $id_rank );
$id_admin_rules = intval( $id_admin_rules );
		
if( $id_rank < 1 ){ $msgError = 'Неверный номер ранга.'; }
elseif( $id_admin_rules < 1 ){ $msgError = 'Неверный номер правила.'; }
elseif( !self::hasClanRankRule( $id_rank, $id_admin_rules ) ){ $msgError = 'У ранга нет такого правила.'; }
else{
			
$query = sprintf("DELETE FROM ".SQL_PREFIX."clan_ranks_has_admin_rules WHERE id_rank = '%d' AND id_admin_rules = '%d';", $id_rank, $id_admin_rules );
$db->execQuery( $query, "AdminRules_delRuleClanRank_1" );
			
$msgError = 'Правило для ранга '.$id_rank.' успешно удалено.';

}
		
return $msgError;
}
	
	

function hasClanRule( $id_clan = 0, $id_admin_rules = 0 ){
global $db;
		
$id_clan = intval( $id_clan );
$id_admin_rules = intval( $id_admin_rules );
		
if( $id_clan < 1 ){ $msgError = false; }
elseif( $id_admin_rules < 1 ){ $msgError = false; }
else{
			
$query = sprintf("SELECT id_admin_rules FROM ".SQL_PREFIX."clan_has_admin_rules WHERE id_clan = '%d' AND id_admin_rules = '%d';", $id_clan, $id_admin_rules );
$msgError = $db->queryCheck( $query, "AdminRules_hasClanRule_1" );

}
		
return $msgError;
}

	

function hasClanRankRule( $id_rank=0, $id_admin_rules=0 ){
global $db;
		
$id_rank = intval( $id_rank );
$id_admin_rules = intval( $id_admin_rules );
		
if( $id_rank < 1 ){ $msgError = false; }
elseif( $id_admin_rules < 1 ){ $msgError = false; }
else{

$query = sprintf("SELECT id_admin_rules FROM ".SQL_PREFIX."clan_ranks_has_admin_rules WHERE id_rank = '%d' AND id_admin_rules = '%d';", $id_rank, $id_admin_rules );
$msgError = $db->queryCheck( $query, "AdminRules_hasClanRankRule_1" );

}
		
return $msgError;
}
	
	
	
function getRuleClanAll( ){
global $db;
		
$out = array();
		
$query = sprintf("SELECT c.title, car.id_clan, car.id_admin_rules, ar.Title, ar.Time FROM ".SQL_PREFIX."clan_has_admin_rules car LEFT JOIN ".SQL_PREFIX."admin_rules ar ON (ar.id_admin_rules = car.id_admin_rules) LEFT JOIN ".SQL_PREFIX."clan c ON (c.id_clan = car.id_clan) ORDER BY car.id_clan;");
$res = $db->query( $query, "AdminRules_getRuleClanAll_1" );
		
while( ($array = mysql_fetch_assoc($res)) ){
$out[$array['id_clan']][] = $array;
}
		
return $out;
}

	

function getClanRules( $id_clan ){
global $db;
		
$query = sprintf("SELECT car.id_admin_rules, ar.Name, ar.Title, ar.Time FROM ".SQL_PREFIX."clan_has_admin_rules car LEFT JOIN ".SQL_PREFIX."admin_rules ar ON (ar.id_admin_rules = car.id_admin_rules) WHERE car.id_clan = '%d';", $id_clan );
return  $db->queryArray( $query, "AdminRules_getRuleClanAll_1" );
}
	

	
function addRuleUser( $username = '', $id_admin_rules = 0 ){
global $db;
		
$id_admin_rules = intval( $id_admin_rules );
		
if( $username == '' ){ $msgError = 'Несуществующий пользователь.'; }
elseif( $id_admin_rules < 1 ){ $msgError = 'Неверный номер правила.'; }
elseif( self::hasUserRule( $username, $id_admin_rules ) ){ $msgError = 'У пользователя уже есть такое правило.'; }
else{
		
$query = sprintf("INSERT INTO ".SQL_PREFIX."user_has_admin_rules ( `Username`, `id_admin_rules` ) VALUES ( '%s', '%d' );", $username, $id_admin_rules );
$db->execQuery( $query, "AdminRules_addRuleUser_1" );
			
$msgError = 'Пользователю '.$username.' добавлено новое правило.';
}
		
return $msgError;
}
	
	

function delRuleUser( $username = '', $id_admin_rules = 0 ){
global $db;
		
$id_admin_rules = intval( $id_admin_rules );
		
if( $username == '' ){ $msgError = 'Неверный пользователь.'; }
elseif( $id_admin_rules < 1 ){ $msgError = 'Неверный номер правила.'; }
elseif( !self::hasUserRule( $username, $id_admin_rules ) ){ $msgError = 'У пользователя нет такого правила.'; }
else{
			
$query = sprintf("DELETE FROM ".SQL_PREFIX."user_has_admin_rules WHERE Username = '%s' AND id_admin_rules = '%d';", $username, $id_admin_rules );
$db->execQuery( $query, "AdminRules_delRuleUser_1" );
			
$msgError = 'Правило для пользователя '.$id_user.' успешно удалено.';

}
		
return $msgError;
}
	
	

function hasUserRule( $username = '', $id_admin_rules = 0 ){
global $db;
		
$id_admin_rules = intval( $id_admin_rules );
		
if( $username == '' ){ $msgError = false; }
elseif( $id_admin_rules < 1 ){ $msgError = false; }
else{
			
$query = sprintf("SELECT id_admin_rules FROM ".SQL_PREFIX."user_has_admin_rules WHERE Username = '%s' AND id_admin_rules = '%d';", $username, $id_admin_rules );
$msgError = $db->queryCheck( $query, "AdminRules_hasUserRule_1" );

}
		
return $msgError;
}
	
	

function getRuleUserAll( ){
global $db;
		
$out = array();
		
$query = sprintf("SELECT uar.Username, uar.id_admin_rules, ar.Title, ar.Time FROM ".SQL_PREFIX."user_has_admin_rules uar LEFT JOIN ".SQL_PREFIX."admin_rules ar ON (ar.id_admin_rules = uar.id_admin_rules) ORDER BY uar.Username;");
$res = $db->query( $query, "AdminRules_getRuleUserAll_1" );
		
while( ($array = mysql_fetch_assoc($res)) ){
$out[$array['Username']][] = $array;
}
		
return $out;
}
	
	
	
function getRuleAll( ){
global $db;
		
$query = sprintf("SELECT * FROM ".SQL_PREFIX."admin_rules ORDER BY Title;");
return $db->queryArray( $query, "AdminRules_getRuleAll_1" );
}


}
?>
