<?php
class OldUserStats {

function getAbilities( $username ){
global $db;

$query = sprintf("SELECT p.`Stre`, p.`Agil`, p.`Intu`, p.`Endu`, p.`Intl`, p.`Level`, p.`HPnow`, p.`HPall` FROM `".SQL_PREFIX."players` p WHERE p.Username = '%s';", $username );
return $db->queryRow( $query, 'UserStats_getAbilities_1' );
}
	
	
function setAbilities( $username, $params ){
global $db;
		
$newParams = array();
		
if( empty($params) ){ return false; }
		

foreach ($params as $key => $val) {
			
switch (strtoupper($key)){
case 'LEVEL': $_SESSION['Level'] = $newParams['Level'] = $val;  break;
case 'STRE':  $_SESSION['Stre']  =  $newParams['Stre']  = $val; break;
case 'AGIL':  $_SESSION['Agil']  =  $newParams['Agil']  = $val; break;
case 'INTU':  $_SESSION['Intu']  =  $newParams['Intu']  = $val; break;
case 'INTL':  $_SESSION['Intl']  =  $newParams['Intl']  = $val; break;
case 'ENDU':  $_SESSION['Endu']  =  $newParams['Endu']  = $val; break;
case 'HPALL': $_SESSION['HPall'] = $newParams['HPall'] = $val; if( $_SESSION['HPall'] >= $_SESSION['HPnow'] ){ break; }
case 'HPNOW': $_SESSION['HPnow'] = $newParams['HPnow'] = $val;  break;
}

}
		

$db->update( "session_data", $newParams, array('Username'=>$username), "UserStats_setAbilities_1" );
return true;
}
	
	
function getSkills( $username ){
global $db;

$query = sprintf("SELECT SUM(t.`MINdamage`) as minDamage, SUM(t.`MAXdamage`) as maxDamage, SUM(t.`Crit`) as critical, SUM(t.`AntiCrit`) as antiCritical, SUM(t.`Uv`) as dodge, SUM(t.`AntiUv`) as antiDodge, SUM(t.`Armor1`) as armor1, SUM(t.`Armor2`) as armor2, SUM(t.`Armor3`) as armor3, SUM(t.`Armor4`) as armor4 FROM `".SQL_PREFIX."things` t WHERE t.Wear_ON = '1' AND t.Owner = '%s';", $username );
return $db->queryRow( $query, 'OldUserStats_getSkills_1' );
}


}
?>
