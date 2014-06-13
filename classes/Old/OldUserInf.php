<?php
class OldUserInf extends OldUser {

var $City;
var $Birthdate;
var $Email;
var $ICQ;
var $Info;
var $karma;
var $PersBirthdate;
var $RealName;
var $Reg_IP;
var $Won;
var $Lost;
var $Expa;
var $Ups;
var $Money;
var $Euro;
var $ClanRank;
var $ClanTitle;
var $presents;
var $socStatus;
	
	
	
function __construct( $username='', $id_user='', &$fromObj ){
global $db, $registerCity, $currentcity;
		
		
if( is_a( $fromObj, 'OldUser' ) == true ){
			
$this->initByObject( $fromObj );
$this->loadPlayersInfo();
$this->loadPlayersData();
			
} elseif ( $username != '' || $id_user != '' ){
$this->checkCity( $username, $id_user );
if( $this->id_user < 1 ){ return ; }
$this->loadPlayersInfo();
$this->User( $this->username, $this->id_user );
$this->loadPlayersData();
} else {
$this->User( $username, $id_user );
$this->loadPlayersInfo();
$this->loadPlayersData();
}
		
$db->setDbId( $currentcity );
}

	
function checkCity( $username='', $id_user='' ){
global $db;

$query = sprintf("SELECT pa.`City`, pa.`Username` FROM ".SQL_PREFIX."players pa WHERE pa.`Username` = '%s' LIMIT 1;", mysql_escape_string($username) );
$res = $db->queryRow( $query, "UserInf_checkCity_1" );

$this->City = $res['City'];
$this->id_user = $res['Username'];
$this->username = $res['Username'];
}


function loadPlayersInfo( ){
global $db;
		
$query = sprintf("SELECT pi.`Birthdate`, pi.`Email`, pi.`ICQ`, pi.`Info`, pi.`PersBirthdate`, pi.`Reg_IP`, pi.`RealName` FROM `".SQL_PREFIX."players` pi WHERE pi.`Username` = '%s';", $this->username );
$res = $db->queryRow( $query, "UserInf_loadInf_1" );

$this->Birthdate	   = $res['Birthdate'];
$this->Email		     = $res['Email'];
$this->ICQ			     = $res['ICQ'];
$this->Info			     = $res['Info'];
$this->karma		     = $res['karma'];
$this->PersBirthdate = $res['PersBirthdate'];
$this->RealName	 	   = $res['RealName'];
$this->Reg_IP		     = $res['Reg_IP'];

		
$this->isVip = $this->checkVip( $this->username );
}


function loadPlayersData( ){
global $db;

$query = sprintf("SELECT p.`Won`, p.`Lost`, p.`Expa`, p.`Ups`, p.`Money` FROM `".SQL_PREFIX."players` p WHERE p.`Username` = '%s';", $this->username );
$res = $db->queryRow( $query, "UserInf_loadPlayersData_1" );

$this->Won	= $res['Won'];
$this->Lost	= $res['Lost'];
$this->Expa	= $res['Expa'];
$this->Ups	= $res['Ups'];
$this->Money= $res['Money'];
		
$query = sprintf ("SELECT Euro FROM ".SQL_PREFIX."bank_acc WHERE Username = '%s';", $this->username );
$res = $db->queryRow($query, "UserInf_loadPlayersData_1 ");
$this->Euro = $res['Euro'];
}


	
function loadAdditionalInfo( ){ }
	

function loadSocialStatus( ){
global $db;
		
$query = sprintf("SELECT Text FROM ".SQL_PREFIX."as_notes WHERE id_user = '%d' AND Status = 'brak';", $this->id_user );
$res = $db->queryRow( $query, "UserInf_loadSocialStatus_1" );
		
$this->socStatus = $res['Text'];
}
	
	
function loadPresents( ){
global $db;
		
$query = sprintf("SELECT * FROM ".SQL_PREFIX."things WHERE id_user = '%d' AND Slot = '%d';", $this->id_user, 13 );
$this->presents = $db->queryArray( $query, "UserInf_loadPresents_1" );
}
	

function setNewPassword( $newPassword ){
global $db, $registerCity, $currentcity;

$db->setDbId( $registerCity );

$query = sprintf("UPDATE ".SQL_PREFIX."players_all SET Password = Password('%s') WHERE id_user = '%d';", mysql_escape_string($newPassword), $this->id_user );
$db->execQuery( $query, "UserInf_setNewPassword_1" );

$db->setDbId( $currentcity );
}


function modifyMoney( $offset ){
global $db;
		
if( $this->Money + $offset < 0 ){ return false; }
		
$query = sprintf("UPDATE ".SQL_PREFIX."players SET Money = Money + '%.2f' WHERE Username = '%s';", $offset, $this->username );
$db->execQuery($query, "UserInf_modifyMoney_1 ");
$this->Money += $offset;
return true;
}
	
	
function modifyMoneyByUsername( $username, $offset ){
global $db;
		
$query = sprintf("UPDATE ".SQL_PREFIX."players SET Money = Money + '%.2f' WHERE Username = '%s';", $offset, $username );
$db->execQuery($query, "OldUserInf_modifyMoneyByUsername_1 ");
return true;
}

	
function modifyEuroByIdUser( $username, $offset){
global $db;

$query = sprintf("INSERT INTO ".SQL_PREFIX."bank_acc ( Username, Euro ) VALUES ( '%s', '%.2f' ) ON DUPLICATE KEY UPDATE Euro = Euro + '%.2f';", mysql_escape_string($username), $offset, $offset );
$db->execQuery($query, "OldUserInf_modifyEuroByUsername_1 ");
return true;
}
	
	
function transferMoney( $toUsername, $amount ){
global $db;
		
$query = sprintf("UPDATE ".SQL_PREFIX."players SET Money = Money + '%d' WHERE Username = '%d';", $amount, $toUsername );
$db->execQuery( $query, "UserInf_transferMoney_1" );
		
$this->modifyMoney( -$amount );
}


function modifyEuro( $offset ){
global $db;
		
if( $this->Euro + $offset < 0 ){ return false; }
		
$query = sprintf ("INSERT INTO ".SQL_PREFIX."bank_acc ( Username, Euro ) VALUES ( '%s', '%.2f' ) ON DUPLICATE KEY UPDATE Euro = Euro + '%.2f';", $this->username, $offset, $offset );
$db->execQuery($query, "UserInf_modifyEuro_1 ");
$this->Euro += $offset;
return true;
}
	

function addToClan ($id_clan, $status='',$rank=''){
global $db;
		
$query = sprintf("SELECT * FROM ".SQL_PREFIX."clan_user WHERE id_user = '%d' AND id_clan = '%d';", $this->id_user, $id_clan );

if (!($db->queryCheck($query, "UserInf_addToClan_1 "))){
$query = sprintf("INSERT INTO ".SQL_PREFIX."clan_user (id_clan, id_user, rank, status ) VALUES ('%d', '%d', '%s', '%s');", $id_clan, $this->id_user, $rank, strtoupper($status) );
$db->execQuery($query, "UserInf_addToClan_2");
}

if ($this->id_clan == '0'){
$this->id_clan = $id_clan;

$query = sprintf("UPDATE ".SQL_PREFIX."online SET ClanID = '%d' WHERE id_user = '%d';", $id_clan, $this->id_user );
$db->execQuery($query, "UserInf_addToClan_3");

$query = sprintf("UPDATE ".SQL_PREFIX."session_data SET id_clan = '%d' WHERE id_user = '%d';", $id_clan, $this->id_user );
$db->execQuery($query, "UserInf_addToClan_4 ");
}

}
	

function changeClan ($id_clan){
global $db;

if ($this->id_clan == 0){ $this->addToClan($id_clan); }

$query = sprintf("UPDATE ".SQL_PREFIX."clan_user SET id_clan = '%d' WHERE id_user = '%d' AND id_clan = '%d';", $id_clan, $this->id_user, $this->id_clan );
$db->execQuery($query, "UserInf_changeClan_1 ");
}
	

function inClan ($id_clan){
global $db;

$query = sprintf("SELECT id_user FROM ".SQL_PREFIX."clan_user WHERE id_clan = '%d' AND id_user = '%d';", $id_clan, $this->id_user );
return ($db->queryCheck($query, "UserInf_inClan_1 "));
}
	

function isClanAdmin ($id_clan){
global $db;

$query = sprintf("SELECT id_user FROM ".SQL_PREFIX."clan_user WHERE id_clan = '%d' AND id_user = '%d' AND status = '%s';", $id_clan, $this->id_user, 'ADMIN' );
return ($db->queryCheck($query, "UserInf_isClanAdmin_1 "));
}
	
	
function modifyClanRank( $id_clan, $newClanRank ){
global $db;
		
$query = sprintf("UPDATE ".SQL_PREFIX."clan_user SET  rank = '%s' WHERE id_user = '%d' AND id_clan = '%d';", $newClanRank, $this->id_user, $id_clan );
$db->execQuery( $query, "UserInf_updateClanRank_1" );
}
	
	
function setKarma( $offset, $id_user ){ }
	


}
?>
