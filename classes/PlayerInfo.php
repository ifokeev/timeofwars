<?php

function filter($s){
$str = $s;
$str = trim($str);
$str = htmlspecialchars($str, ENT_NOQUOTES);
$str = str_replace( '&lt;', '<', $str );
$str = str_replace( '&gt;', '>', $str );
$str = str_replace( '&quot;', '"', $str );
$str = str_replace( '&', '&#38', $str );
$str = str_replace( '"', '&#34', $str );
$str = str_replace( "'", '&#39', $str );
$str = str_replace( '<', '&#60', $str );
$str = str_replace( '>', '&#62', $str );
$str = str_replace( '\0', '', $str );
$str = str_replace( '', '', $str );
$str = str_replace( '\t', '', $str );
$str = str_replace( '../', '. . / ', $str );
$str = str_replace( '..', '. . ', $str );
$str = str_replace( ';', '&#59', $str );
$str = str_replace( '/*', '', $str );
$str = str_replace( '%00', '', $str );
$str = stripslashes( $str );
$str = str_replace( '\\', '&#92', $str );
return $str;
}

class PlayerInfo{

public  $username;
public  $user_id;
public  $clanid;
public  $Expa;
public  $sid;
public  $id_picture;
public  $id_battle;
public  $id_battle2;
public  $Room;
public  $ChatRoom;
public  $Money;
public  $Stre;
public  $Agil;
public  $Win;
public  $Lost;
public  $Intu;
public  $Endu;
public  $Intl;
public  $Level;
public  $Align;
public  $Sex;
public  $Ups;
public  $HPnow;
public  $HPall;
public  $isOnline = false;
public  $id_clan;
public  $id_rank;
public  $admin;
public  $map_id;
private $HPtime;
private $infoArray;


function __construct( $username = '' ){

if( !empty($username) )
{
	$this->username = filter($username);
	$this->isOnline( $this->username, 'targetOFF' );
}
elseif ( empty($username) )
{
	$this->username	= filter($_SESSION['login']);
	$this->isOnline( $this->username, intval($_SESSION['SId']) );
}

$this->loadUser();

}

function is_blocked(){
global $db;

if ( $why = @$db->SQL_result($db->query("SELECT Why FROM ".SQL_PREFIX."blocked WHERE Username = '".$this->username."'"),0,0) )
{
	return die( sprintf(playerblocked, $why) );
}

unset($why);

return ;
}


function add_anket( $from, $wtf )
{
	global $db;
	$multstr1 = '';
	$multstr2 = '';
	if ( $ip = $db->SQL_result($db->query("SELECT Ip FROM `".SQL_PREFIX."ip` WHERE Username = '".$from."'"),0,0) )   $targetip = $ip;

	if ( $targetip == $this->ip )
	{
		$multstr1 = '<font color="red">';
		$multstr2 = '</font>';
	}


	$db->insert( SQL_PREFIX.'transfer', Array( 'Date' => date('Y-m-d'), 'From' => $from, 'To' => $this->username, 'What' => $multstr1.$wtf.$multstr2 ) );
}

function checkBattle(){
if ( !empty($this->id_battle) ) die( header ('location: battle.php') );
if ( !empty($this->id_battle2) ) die( header ('location: battle2.php') );

return ;
}



function checkRoom($room){
if($this->Room != $room){ die( Header('Location: '.$this->Room.'.php') ); }
return ;
}

function gotoRoom( $room = 'pl', $chatroom = 'pl' ){
global $db;

$db->update( SQL_PREFIX.'players', Array( 'Room' => $room, 'ChatRoom' => $chatroom ), Array( 'Username' => $this->username ) );
$_SESSION['userroom'] = $room.'.php'; header('Location: '.$room.'.php'); die;

}

function checklevelup( $pers = '' ){
global $db;

$Ladd = 0;

$item = $this->getItemsInfo($this->username);

for($i=0; $i<11; $i++){
if ($item['Slot'][$i] != 'empt'.$i){

$lev = @$db->SQL_result($db->query("SELECT Level_add FROM ".SQL_PREFIX."things WHERE Owner = '$this->username' AND Wear_ON = '1' AND Slot = '$i'"),0);
$Ladd += $lev;

}
}

unset($item, $lev, $i);

$RealL    = $this->Level - $Ladd;

$defexp   = 5;
$exp      = 0;

$exp_need = 10;
$ten      = 10;

for($i=0; $i<101; $i++){

$i1 = $i*3 + 15;
$defexp = round(($i1/4)*3);
$win_need = round($exp_need / $defexp);


$money_1 = round($win_need*2);


$exp_need += $ten;
$exp_need = round($exp_need);

$exp += $exp_need;

if ($RealL == $i)
{
	if ($exp <= $this->Expa)
	{
		if( !empty($this->tax) )
		{
			$nalog    = $money_1/100 * $this->tax;
			$money_1 -= $nalog;
			$db->update( SQL_PREFIX.'clan', Array( 'kazna' => '[+]'.$nalog ), Array( 'id_clan' => $this->id_clan ), 'maths' );
		    $db->insert( SQL_PREFIX.'messages',Array( 'Username' => $this->username, 'Text' => '<font color="red">Внимание!</font> Вы достигли следующего уровня. Уплачен налог с уровня в размере '.$this->tax.'%' ) );
        }
        else
        {
        	$db->insert( SQL_PREFIX.'messages',Array( 'Username' => $this->username, 'Text' => '<font color="red">Внимание!</font> Вы достигли следующего уровня' ) );
        }

		$db->update( SQL_PREFIX.'players', Array( 'Level' => '[+]1', 'Endu' => '[+]1', 'HPall' => '[+]3', 'Ups' => '[+]3', 'Money' => '[+]'.$money_1 ), Array( 'Username' => $this->username ), 'maths' );
		$RealL++;
		$db->update( SQL_PREFIX.'online',  Array( 'Level' => $RealL ), Array( 'Username' => $this->username ) );
	}
	else
	{
		$next_exp = $exp;
	}

}

if($i <= 10){               $ten += 25;  }
if($i > 10 && $i <= 50){	$ten += 60;  }
if($i > 50 && $i <= 85){	$ten += 310; }
if($i > 85 && $i <= 100){   $ten *= 2;   }

}

return $next_exp;
}

function isOnline( $username = '', $sid ){
global $db;

if( empty($username) || empty($sid) ) die;


$query = sprintf("SELECT Username FROM ".SQL_PREFIX."online WHERE Username = '%s';", $username );
$res = $db->queryRow( $query, "UserLoader_isOnline_1" );

    if( !empty($res) )
	{
		if( $sid == 'targetOFF' )
		{
			$query = "SELECT Username FROM ".SQL_PREFIX."players WHERE Username = '".$username."';";
        }
        else
        {
        	$query = "SELECT Username FROM ".SQL_PREFIX."players WHERE Username = '".$username."' AND SId = '".$sid."';";
        }

		if( $db->queryRow($query) )
		{
			$this->isOnline = true;
        }
        else
        {
        	die('Для правильной работы необходимо <a href="#" onclick="javascript:top.window.location.href=\'http://'.$_SERVER['HTTP_HOST'].'/exit.php\'">перезайти в игру</a>');
        }
	}
	else
	{
		$this->isOnline = false;
	}

return $this->isOnline;
}


function loadUser( ){
global $db;$db->checklevelup($this->username);$this->loadFromStaticTables();
}

function setVars( &$array ){

$this->infoArray  =& $array;
$this->username   =& $array['Username'];
$this->user_id    =& $array['Id'];
$this->clanid     =& $array['ClanID'];
$this->id_picture =& $array['Pict'];
$this->id_battle  =& $array['BattleID'];
$this->id_battle2 =& $array['BattleID2'];
$this->id_clan    =& $array['id_clan'];
$this->id_rank    =& $array['id_rank'];
$this->admin      =& $array['admin'];
$this->tax        =& $array['tax'];
$this->Room       =& $array['Room'];
$this->ChatRoom   =& $array['ChatRoom'];
$this->Money      =& $array['Money'];
$this->Stre       =& $array['Stre'];
$this->Agil       =& $array['Agil'];
$this->Intu       =& $array['Intu'];
$this->Endu       =& $array['Endu'];
$this->Intl       =& $array['Intl'];
$this->Level      =& $array['Level'];
$this->Align      =& $array['Align'];
$this->Sex        =& $array['Sex'];
$this->HPnow      =& $array['HPnow'];
$this->HPall      =& $array['HPall'];
$this->HPtime     =& $array['HPtime'];
$this->Expa       =& $array['Expa'];
$this->Ups        =& $array['Ups'];
$this->map_id     =& $array['map_id'];
$this->Win        =& $array['Won'];
$this->Lost       =& $array['Lost'];
$this->next_exp   =& $array['next_exp'];
$this->ip         =& $array['Reg_IP'];

}


function loadFromStaticTables(){
$userInfo = $this->getUserInfo( $this->username );
$this->setVars( $userInfo );
}



function getUserInfo( $username = '' ){
global $db;

if( $username == '' ){ return array(); }

$out = array();

$query = sprintf("SELECT Username, Level, ClanID, Align, Room, ChatRoom, HPnow, HPall, Sex, Pict, Money, Id, Stre, Agil, Intu, Endu, Intl, BattleID, BattleID2, Won, Lost, Expa, Ups, map_id, Reg_IP FROM `".SQL_PREFIX."players` WHERE Username = '%s';", $username );
$res = $db->queryRow( $query, 'User_getUserInfo_1' );

$clan = $this->getUserClan( $res['Username'] );

$out = array_merge( $out, $res, $clan );

$query = sprintf("SELECT `Time` as HPtime FROM ".SQL_PREFIX."hp WHERE Username = '%s';", $username );
$res = $db->queryRow( $query, "User_getUserInfo_4" );

if( !$res ){ $res = array( 'HPtime' => time() ); }

$out = array_merge( $out, $res );

return $out;
}


function heal(){
global $db;

if( !$db->queryRow("SELECT * FROM ".SQL_PREFIX."hp WHERE Username = '$this->username'") ){
$db->insert( SQL_PREFIX.'hp', Array( 'Username' => $this->username, 'Time' => time() ) );
}

$healTime = time();

if( (($healTime - $this->HPtime) * $this->HPall * 0.009) < 1 ){ return ; }
if( $this->id_battle > 0 ){ return ; }

$HPadd = 0;
$HPadd = round( $this->HPall * ( $healTime - $this->HPtime ) * 0.009 );

if (preg_match("/living__/i", $this->ChatRoom)) {
$HPadd *= 2;
}

$this->HPtime = $healTime;
$this->setHP( $HPadd );
}


function setHPOffline( $offset ){
global $db;

$offset = round( $offset );

$this->HPtime = time();

$db->update( SQL_PREFIX.'hp', Array( 'Time' => $this->HPtime ), Array( 'Username' => $this->username ) );

if( $offset == 0 ){ return; }


$this->HPnow += $offset;

if( $this->HPnow > $this->HPall ){ $this->HPnow = $this->HPall; }
elseif( $this->HPnow < 0 ){ $this->HPnow = 0; }

$db->update( SQL_PREFIX.'players', Array( 'HPnow' => $this->HPnow ), Array( 'Username' => $this->username ) );
}


function setHP( $offset ){
$this->setHPOffline( $offset );
}

function getUserClan( $username ){
global $db;

$query = sprintf("SELECT id_clan, id_rank, admin, tax FROM ".SQL_PREFIX."clan_user WHERE Username = '%s';", $username );
$res = $db->queryRow( $query, "User_getUserInfo_3" );

if( !$res ){ $res = array('id_clan' => 0, 'id_rank' => 0, 'admin' => 0, 'tax' => 0); }

return $res;
}


function updateUserClan( $username ){
global $db;

$query = sprintf("UPDATE ".SQL_PREFIX."players p LEFT JOIN ".SQL_PREFIX."clan_user cu ON( cu.Username = p.Username ) LEFT JOIN ".SQL_PREFIX."online o ON( o.Username = p.Username ) SET p.ClanID = IFNULL( cu.id_clan, 0 ), o.ClanID = IFNULL( cu.id_clan, 0 ) WHERE p.Username = '%s';", $username );
return $db->execQuery( $query, "OldUser_setUserClan_1" );
}


function getItemsInfo( $username ){
global $db;

$out['Slot_name'] = array( 'Пустой слот серьги', 'Пустой слот ожерелье', 'Пустой слот оружие', 'Пустой слот броня', 'Пустой слот кольцо', 'Пустой слот кольцо', 'Пустой слот кольцо', 'Пустой слот шапка', 'Пустой слот перчатки', 'Пустой слот щит', 'Пустой слот обувь', );
$out['Slot_id']   = array();

for( $i=0; $i<11; $i++ )
{
    $out['Slot_id'][$i] = 0;
    $out['Slot'][$i]    = 'empt'.$i;
}



$query = sprintf("SELECT Slot, Un_Id, Id, Thing_Name, NOWwear, MAXwear FROM ".SQL_PREFIX."things WHERE Slot < '11' AND Wear_ON = '1' AND Owner = '%s';", $username );
$res = $db->queryArray( $query, "User_getItemsInfo_1" );

if( !empty($res) ){
foreach( $res as $item ){
$out['Slot_id'][$item['Slot']]    = $item['Un_Id'];
$out['Slot'][$item['Slot']]       = $item['Id'];
$out['Slot_name'][$item['Slot']]  = $item['Thing_Name']."\n(долговечность ".$item['NOWwear']."/".$item['MAXwear'].")";
}
}

return $out;
}


function healTrauma(){
global $db;

$query = sprintf("SELECT * FROM ".SQL_PREFIX."inv WHERE Username = '%s';", $this->username );
$kr = $db->queryRow($query, "User_healTrauma_1 ");

if( !$kr ){ $healed = 0; }
else {

$type3 = $kr['Type3'];
$type2 = $kr['Type2'];

switch( $type2 ){
case 1: $db->update( SQL_PREFIX.'players', Array( 'Stre' => '[+]'.$type3 ), Array( 'Username' => $this->username ), 'maths' ); break;
case 2: $db->update( SQL_PREFIX.'players', Array( 'Agil' => '[+]'.$type3 ), Array( 'Username' => $this->username ), 'maths' ); break;
case 3: $db->update( SQL_PREFIX.'players', Array( 'Intu' => '[+]'.$type3 ), Array( 'Username' => $this->username ), 'maths' ); break;
}

$query = sprintf("DELETE FROM ".SQL_PREFIX."inv WHERE Username = '%s';", $this->username );
$db->execQuery($query, "User_healTrauma_2");
$healed = 1;
}

return $healed;
}



function wear($id){
global $db;

$item = $this->getItemsInfo( $this->username );

if( $db->queryRow("SELECT * FROM `".SQL_PREFIX."wood_g` WHERE persid = '$this->user_id'") ){ $err = 'Вы слишком заняты поиском трав'; }
else{

if( $db->queryCheck("SELECT * FROM ".SQL_PREFIX."demands WHERE Username = '$this->username' OR Name_pr = '$this->username'") ){ $err = 'Нельзя что-либо одеть, находясь в заявке на бой'; }
elseif( $db->queryCheck("SELECT * FROM ".SQL_PREFIX."group_demands WHERE (Team1 LIKE '%".$this->username."%') OR (Team2 LIKE '%".$this->username."%')") ){ $err = 'Нельзя что-либо одеть, находясь в заявке на бой'; }
else{


if ( $thing = $db->fetch_array("SELECT Un_Id, Clan_need, Slot, Stre_need, Endu_need, Agil_need, Intu_need, Level_need, Stre_add, Agil_add, Intu_add, Endu_add, Level_add, Id, Thing_Name, Wear_ON FROM ".SQL_PREFIX."things WHERE Owner = '$this->username' AND Un_Id = '$id'") ) {

if( $thing['Wear_ON'] == '0' ){

if ( ($thing['Clan_need'] != '' && $thing['Clan_need'] != 0) && ($thing['Clan_need'] != $this->clanid) ) { $err = 'Вы не можете одеть вещь "'.$thing['Thing_Name'].'".'; }
elseif (($thing['Stre_need'] > $this->Stre) || ($thing['Agil_need'] > $this->Agil) || ($thing['Intu_need'] > $this->Intu) || ($thing['Endu_need'] > $this->Endu) || ($thing['Level_need'] > $this->Level)) { $err = 'Вы не можете одеть вещь "'.$thing['Thing_Name'].'".'; }
else{

switch( $thing['Slot'] )
{
	case 0:  $SlotXX = 'empt0';   $emptXX = $item['Slot'][0];  break;
	case 1:  $SlotXX = 'empt1';   $emptXX = $item['Slot'][1];  break;
	case 2:  $SlotXX = 'empt2';   $emptXX = $item['Slot'][2];  break;
	case 3:  $SlotXX = 'empt3';   $emptXX = $item['Slot'][3];  break;
	case 4:  $SlotXX = 'empt4';   $emptXX = $item['Slot'][4];  break;
	case 5:  $SlotXX = 'empt5';   $emptXX = $item['Slot'][5];  break;
	case 6:  $SlotXX = 'empt6';   $emptXX = $item['Slot'][6];  break;
	case 7:  $SlotXX = 'empt7';   $emptXX = $item['Slot'][7];  break;
	case 8:  $SlotXX = 'empt8';   $emptXX = $item['Slot'][8];  break;
	case 9:  $SlotXX = 'empt9';   $emptXX = $item['Slot'][9];  break;
	case 10: $SlotXX = 'empt10';  $emptXX = $item['Slot'][10]; break;
}

if ($thing['Slot'] == 4 && ($item['Slot'][4] == 'empt4' || $item['Slot'][5] == 'empt5' || $item['Slot'][6] == 'empt6') ) {

$slot_456 = array( 'Wear_ON' => 1 );

if ($item['Slot'][6] == 'empt6') { $slot_456['Slot'] = 6; }
if ($item['Slot'][5] == 'empt5') { $slot_456['Slot'] = 5; }
if ($item['Slot'][4] == 'empt4') { $slot_456['Slot'] = 4; }

$db->update( SQL_PREFIX.'things', $slot_456, Array( 'Owner' => $this->username, 'Un_Id' => $id ) );

}



if ($thing['Slot'] == 4 && $item['Slot'][4] != 'empt4' && $item['Slot'][5] != 'empt5' && $item['Slot'][6] != 'empt6') {
$ring_on = $db->queryRow("SELECT Stre_add, Intu_add, Agil_add, Endu_add, Level_add FROM ".SQL_PREFIX."things WHERE Owner = '$this->username' AND Wear_ON = '1' AND Slot = '4'");

$slot_456 = Array();

if ($this->HPnow > ($this->HPall - $ring_on['Endu_add']) )
{
                             $slot_456['HPnow'] = ($this->HPall - $ring_on['Endu_add']);
}
if ($ring_on['Stre_add']) {  $slot_456['Stre'] = '[-]'.$ring_on['Stre_add'];     }
if ($ring_on['Agil_add']) {  $slot_456['Agil'] = '[-]'.$ring_on['Agil_add'];     }
if ($ring_on['Intu_add']) {  $slot_456['Intu'] = '[-]'.$ring_on['Intu_add'];     }
if ($ring_on['Endu_add']) {  $slot_456['HPall'] = '[-]'.$ring_on['Endu_add'];    }
if ($ring_on['Level_add']) { $slot_456['Level'] = '[-]'.$ring_on['Level_add'];   }


if( !empty($slot_456) )
{
	$db->update( SQL_PREFIX.'players', $slot_456, Array( 'Username' => $this->username ), 'maths' );
}
$db->update( SQL_PREFIX.'things', Array( 'Wear_ON' => '0' ), Array( 'Owner' => $this->username, 'Wear_ON' => '1', 'Slot' => 4 ) );
$db->update( SQL_PREFIX.'things', Array( 'Wear_ON' => '1', 'Slot' => 4 ), Array( 'Owner' => $this->username, 'Un_Id' => $id ) );

}


if ($SlotXX != $emptXX && $thing['Slot'] != 4) {

$t_on = $db->queryRow("SELECT Un_Id, Stre_add, Agil_add, Intu_add, Endu_add, Level_add, Slot FROM ".SQL_PREFIX."things WHERE Owner = '$this->username' AND Id = '$emptXX' AND Wear_ON = '1' AND (Slot != '4' OR Slot != '5' OR Slot != '6')");

$slot_456 = Array();

if ($this->HPnow > ($this->HPall - $t_on['Endu_add']) )
{
	                      $slot_456['HPnow'] = ($this->HPall - $t_on['Endu_add']);
}
if ($t_on['Stre_add']) {  $slot_456['Stre'] = '[-]'.$t_on['Stre_add'];     }
if ($t_on['Agil_add']) {  $slot_456['Agil'] = '[-]'.$t_on['Agil_add'];     }
if ($t_on['Intu_add']) {  $slot_456['Intu'] = '[-]'.$t_on['Intu_add'];     }
if ($t_on['Endu_add']) {  $slot_456['HPall'] = '[-]'.$t_on['Endu_add'];    }
if ($t_on['Level_add']) { $slot_456['Level'] = '[-]'.$t_on['Level_add'];   }

if( !empty($slot_456) )
{
	$db->update( SQL_PREFIX.'players', $slot_456, Array( 'Username' => $this->username ), 'maths' );
}
$db->update( SQL_PREFIX.'things', Array( 'Wear_ON' => '0' ), Array( 'Owner' => $this->username, 'Un_Id' => $t_on['Un_Id'], 'Wear_ON' => '1' ) );
}


$upd = Array();

if ($thing['Stre_add']) {  $upd['Stre'] = '[+]'.$thing['Stre_add'];     }
if ($thing['Agil_add']) {  $upd['Agil'] = '[+]'.$thing['Agil_add'];     }
if ($thing['Intu_add']) {  $upd['Intu'] = '[+]'.$thing['Intu_add'];     }
if ($thing['Endu_add']) {  $upd['HPall'] = '[+]'.$thing['Endu_add'];    }
if ($thing['Level_add']) { $upd['Level'] = '[+]'.$thing['Level_add'];   }

if( !empty($upd) )
{
	$db->update( SQL_PREFIX.'players', $upd, Array( 'Username' => $this->username ), 'maths' );
}
$db->update( SQL_PREFIX.'things', Array( 'Wear_ON' => '1' ), Array( 'Owner' => $this->username, 'Un_Id' => $id ) );




if( $this->HPnow > $this->HPall ){ $db->execQuery("UPDATE ".SQL_PREFIX."players SET HPnow = HPall WHERE Username = '$this->username' LIMIT 1"); }

$err = 'Вещь "'.$thing['Thing_Name'].'" одета';

}

} else { $err = 'Вещь "'.$thing['Thing_Name'].'" УЖЕ одета'; }
} else { $err = 'Предмет "'.$thing['Thing_Name'].'" не найден в инвентаре'; }

//проверка на заявку
}
//проверка на лес
}
//проверка на лес

return $err;
}


function unwear($id){
global $db;


$query = '';

if( $db->queryRow("SELECT * FROM `".SQL_PREFIX."wood_g` WHERE persid = '$this->user_id'") ){ $err = 'Вы слишком заняты поиском трав'; }
elseif( $db->queryCheck("SELECT * FROM ".SQL_PREFIX."demands WHERE Username = '$this->username' OR Name_pr = '$this->username'") ){ $err = 'Нельзя что-либо снять, находясь в заявке на бой'; }
elseif( $db->queryCheck("SELECT * FROM ".SQL_PREFIX."group_demands WHERE (Team1 LIKE '%".$this->username."%') OR (Team2 LIKE '%".$this->username."%')") ){ $err = 'Нельзя что-либо снять, находясь в заявке на бой'; }
elseif( !$thing_on = $db->queryRow("SELECT Un_Id, Endu_add, Slot, Stre_add, Agil_add, Intu_add, Level_add, Thing_Name FROM ".SQL_PREFIX."things WHERE Owner = '$this->username' AND Un_Id = '$id' AND Wear_ON = '1'") ){ $err = 'Вещи не найдено'; }
else
{


$upd = Array();

if ($this->HPnow > ($this->HPall - $thing_on['Endu_add']) )
{
	                      $upd['HPnow'] = ($this->HPall - $thing_on['Endu_add']);
}
if ($thing_on['Stre_add']) {  $upd['Stre'] = '[-]'.$thing_on['Stre_add'];     }
if ($thing_on['Agil_add']) {  $upd['Agil'] = '[-]'.$thing_on['Agil_add'];     }
if ($thing_on['Intu_add']) {  $upd['Intu'] = '[-]'.$thing_on['Intu_add'];     }
if ($thing_on['Endu_add']) {  $upd['HPall'] = '[-]'.$thing_on['Endu_add'];    }
if ($thing_on['Level_add']) { $upd['Level'] = '[-]'.$thing_on['Level_add'];   }
if ($thing_on['Slot'] == 4 || $thing_on['Slot'] == 5 || $thing_on['Slot'] == 6)
{
	                      $query = ", Slot = '4'";
}


if( !empty($upd) )
{
	$db->update( SQL_PREFIX.'players', $upd, Array( 'Username' => $this->username ), 'maths' );
}

$db->execQuery("UPDATE ".SQL_PREFIX."things SET Wear_ON = '0' ".$query." WHERE Owner = '$this->username' AND Un_Id = '".$id."' AND Wear_ON = '1'");


$err = 'Вещи сняты';


}

// end
return $err;
}


function goBattle( $enemy )

{
	global $db, $db_config;

	$db->insert( SQL_PREFIX.'2battle', Array( 'team1' => $this->username.';', 'team2' => $enemy.';', 'start_time' => time() ) );
	$id = $db->insertId();

	$db->insert( SQL_PREFIX.'2battle_action', Array( 'battle_id' => $id, 'Username' => $this->username, 'Enemy' => $enemy, 'team' => 1 ) );
    $db->insert( SQL_PREFIX.'2battle_action', Array( 'battle_id' => $id, 'Username' => $enemy, 'Enemy' => $this->username, 'team' => 2 ) );

    $time = date( 'm, j, Y, H:i', time() );

    $xmlstr =
    "<?xml version=\"1.0\" encoding=\"windows-1251\"?>
    <battle id=\"$id\">
    	<team1>$this->username</team1>
 		<team2>$enemy</team2>
 		<log>
   			<str>Было $time когда $this->username и $enemy начали битву.</str>
 		</log>
	</battle>
	";

	file_put_contents( $db_config[DREAM]['web_root'] . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'battles' . DIRECTORY_SEPARATOR . $id . '.xml', $xmlstr );

	$db->update( SQL_PREFIX.'players', Array( 'BattleID2' => $id ), Array( 'Username' => $this->username ) );
	$db->update( SQL_PREFIX.'players', Array( 'BattleID2' => $id ), Array( 'Username' => $enemy ) );

	return $id;
}

	public function slogin( $user = '', $lvl = '', $clanid = '', $team = 0 )
	{
		global $db_config;

		if( empty($user) && empty($lvl) && empty($clanid) )
		{
			$user = $this->username;
			$lvl = $this->Level;
			$clanid = $this->id_clan;
		}

		$r = '';

		if( !empty($clanid) ) $r .= '<a href="http://'.$db_config[DREAM]['server'].'/top5.php?show='.$clanid.'" target="_blank"><img src="http://'.$db_config[DREAM_IMAGES]['server'].'/clan/'.$clanid.'.gif" /></a>';

		if( !empty($team) )
		{
		  if( $team == 1 ) $r .= '<a href="javascript:top.AddToPrivate(\''.$user.'\', true)" class="team1">'.$user.'</a>';
		  else $r .= '<a href="javascript:top.AddToPrivate(\''.$user.'\', true)" class="team2">'.$user.'</a>';
	    }
		else $r .= '<a href="javascript:top.AddToPrivate(\''.$user.'\', true)">'.$user.'</a>';

		$r .= ' ['.$lvl.']';
		return $r;
	}

function to_interfere( $us_str, $battle_id, $team )
{
	global $db_config, $db;

	 if( !is_numeric($battle_id) || !is_numeric($team) ) die;

	 if ( $data = $db->queryRow("SELECT team1, team2, step FROM ".SQL_PREFIX."2battle WHERE id = '".$battle_id."' AND status = 'during'")  )
	 {
		    include ( $db_config[DREAM]['web_root'] . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'battle2' . DIRECTORY_SEPARATOR . 'write_to_xml.php');
			$battle_log = new write_to_log($battle_id);
            $battle_log->add_user_to_team( $this->username, $team );

            $enemies = split( ';', $data['team'.$team] );
            array_pop($enemies);

            shuffle($enemies);
			$db->insert( SQL_PREFIX.'2battle_action', Array( 'Username' => $this->username, 'Enemy' => $enemies[0], 'team' => intval($team), 'battle_id' => $battle_id ) );

            $log_team = $team == 2 ? '<font color="#6666ff">синих.</font>' : '<font color="#ff6666">красных.</font>';

			$Add_log = '<span>'.date( 'H:i' ).'.</span>&nbsp;'.$us_str.' вмешался в поединок за команду '.$log_team;
			$battle_log->add_log($Add_log, $data['step']);

			$db->execQuery("UPDATE ".SQL_PREFIX."2battle SET `team".$team."` = concat(team".$team.", '".$this->username.";') WHERE id = '".$battle_id."' LIMIT 1");

			$db->update( SQL_PREFIX.'players', Array( 'BattleID2' => $battle_id ), Array( 'Username' => $this->username ) );


	}
	else
		die( 'Такого боя не существует либо он уже закончился.' );


}

function __destruct(){
$this->infoArray;
$this->username;
$this->user_id;
$this->clanid;
$this->id_picture;
$this->id_battle;
$this->id_clan;
$this->id_rank;
$this->admin;
$this->Room;
$this->ChatRoom;
$this->Money;
$this->Stre;
$this->Agil;
$this->Intu;
$this->Endu;
$this->Intl;
$this->Level;
$this->Align;
$this->Sex;
$this->HPnow;
$this->HPall;
$this->HPtime;
$this->Expa;
$this->Ups;
$this->map_id;
$this->Win;
$this->Lost;
}

}
?>
