<?
class ClanHeal{

var $id_clan;
var $username;
var $id_rank;
var $maxSize;
var $currentSize;
var $rateExchange;
var $userWater;
var $date;
var $hpNow;
var $hpAll;
var $userPil;
var $userLil;



function __construct( $id_clan, $username, $id_rank ){
		
$this->id_clan  = $id_clan;
$this->username = $username;
$this->id_rank = $id_rank;
		
$this->date	= date('Y-m-d H:i:s');

$this->getPoilkaParams();
$this->getUserHp();

}
	
	
	
function getPoilkaParams( ){
global $db;
		
$query = sprintf("SELECT max_size, current_size, rate_exchange FROM ".SQL_PREFIX."clan_heal WHERE id_clan = '%d';", $this->id_clan );
$res = $db->queryRow( $query, "ClanHeal_getPoilkaParams_1" );
		
$this->maxSize		= $res['max_size'];
$this->currentSize	= $res['current_size'];
$this->rateExchange	= $res['rate_exchange'];
}
	
	
	
function getUserHp( ){
global $db;
		
$query = sprintf("SELECT HPnow, HPall FROM ".SQL_PREFIX."players WHERE Username = '%s';", $this->username );
$res = $db->queryRow( $query, "ClanHeal_getUserHp_1" );

$this->hpNow = $res['HPnow'];
$this->hpAll = $res['HPall'];
}

	
	
function convertUserHp( $userWater ){
return floor($userWater / $this->rateExchange);
}



function modifyPoilkaCurrentSize( $offset ){
global $db;
		
$query = sprintf("UPDATE ".SQL_PREFIX."clan_heal SET current_size = current_size + '%d'	WHERE id_clan = '%d';", $offset, $this->id_clan );
		
if( $offset < 0 ){ $inOut = 'OUT'; }
else{ $inOut = 'IN'; }

$this->addToLog( $inOut, abs($offset) );
return $db->execQuery( $query, "ClanHeal_modifyPoilkaCurrentSize_1" );
}
	
	
	
function modifyUserHp( $offset ){
global $db;
		
$query = sprintf("UPDATE ".SQL_PREFIX."players SET HPnow = HPnow + '%d' WHERE Username = '%s';", $offset, $this->username );

return $db->execQuery( $query, "ClanHeal_modifyUserHp_1" );
}
	
	

function addToLog( $inOut, $amount ){
global $db;
		
$query = sprintf("INSERT INTO ".SQL_PREFIX."clan_heal_log (`id_clan`, `Username`, `id_rank`, `user_water`, `in_out`, `Date`) VALUES ( '%d',		'%s',		'%d',		'%d',			'%s',	'%d' );", $this->id_clan, $this->username, $this->id_rank, $amount, $inOut, $this->date );
return $db->execQuery( $query, "ClanHeal_addToLog_1" );
}
	


function userLiot( $HPamount ){
$this->modifyUserHp( -$HPamount ) ;
$this->modifyPoilkaCurrentSize( $this->convertUserHp( $HPamount ) ) ;
}



function userPiot( $HPamount ){
$this->modifyPoilkaCurrentSize( -$HPamount );
$this->modifyUserHp( $HPamount );
}



function getPoilkaInfo( $id_clan, $username ){
global $db;
		
$query = sprintf("SELECT rate_exchange, max_size, current_size FROM ".SQL_PREFIX."clan_heal WHERE id_clan = '%d';", $id_clan );
$poilkaInfo = $db->queryRow( $query, "ClanHeal_getPoilkaInfo_1" );
		
$query = sprintf("SELECT COUNT(id_clan) as cnt FROM ".SQL_PREFIX."clan_heal_log WHERE username = '%s' AND `in_out` = 'IN';", $username );
$poilkaInfo2 = $db->queryRow( $query, "ClanHeal_getPoilkaInfo_2" );
		
$query = sprintf("SELECT COUNT(id_clan) as cnt FROM ".SQL_PREFIX."clan_heal_log WHERE username = '%s' AND `in_out` = 'OUT';", $username );
$poilkaInfo3 = $db->queryRow( $query, "ClanHeal_getPoilkaInfo_1" );
		
$query = sprintf("SELECT HPnow FROM ".SQL_PREFIX."players WHERE Username = '%s';", $username );
$hpNow = $db->queryRow( $query, "ClanHeal_getPoilkaInfo_1" );


return array('userPil' 		=> $poilkaInfo3['cnt'], 'userLil' => $poilkaInfo2['cnt'], 'currentSize' => $poilkaInfo['current_size'], 'maxSize' => $poilkaInfo['max_size'], 'rateExchange' => $poilkaInfo['rate_exchange'], 'hpNow' => $hpNow['HPnow'] );
}



}
?>
