<?php
include_once ('includes/to_view.php');

function __dlogin($ar){
return "<script>dlogin(".sprintf( "'%s', %d, %d, %d", $ar['Username'], $ar['Level'], $ar['Align'], $ar['ClanID'] ).")</script>";
}


function WriteBattleLog($log, $BattleID){
global $db;
$db->execQuery("UPDATE ".SQL_PREFIX."logs SET Log = concat(Log, '".mysql_escape_string($log)."') WHERE Id = '$BattleID'");
}


class Player{
public $login = '';
public $array;
public $strength = '';
public $agility = '';
public $endurance = '';
public $intuition = '';
public $intellect = '';
public $exp = '';
public $free_ups = '';
public $money = '';
public $align = '';
public $won = '';
public $lost = '';
public $hpall = '';
public $hpnow = '';
public $level = '';
public $clanID = 0;
public $clanRank = '';
public $picture = '';
public $Sex = '';
public $birth = '';
public $realname = '';
public $info = '';
public $battle_id = '';
public $icq = '';
public $city = '';
public $Slot;
public $NOWwear;
public $MAXwear;
public $MINdamage;
public $Crit = 0;
public $ACrit = 0;
public $Uvorot = 0;
public $AUvorot = 0;
public $Armor1 = 0;
public $Armor2 = 0;
public $Armor3 = 0;
public $Armor4 = 0;
public $MAXdamage;
public $SumMAXdamage;
public $SumMINdamage;
public $Slot_name;
public $Slot_id;
public $FullCost;
public $Image;
public $status = '';
public $Reg_IP = '';
private $PlusHP;

function __construct($name){
global $db;

$Result = $db->queryRow("SELECT p.Username, p.Align, p.Stre, p.Agil, p.Intu, p.Endu, p.Intl, p.Expa, p.Ups, p.Room, p.Money, p.Won, p.Lost, p.HPnow, p.HPall, p.Level, cu.id_clan as ClanID, p.ClanRank, p.Pict, p.Sex, p.PersBirthdate, p.RealName, p.Info, p.BattleID, p.City, p.Reg_IP FROM ".SQL_PREFIX."players p LEFT JOIN ".SQL_PREFIX."clan_user cu ON (cu.Username = p.Username) WHERE p.Username = '".speek_to_view($name)."'");

$this->array	 = $Result;
$this->login     = $Result['Username'];
$this->Image	 = $Result['Pict'];
$this->strength	 = $Result['Stre'];
$this->agility	 = $Result['Agil'];
$this->intuition = $Result['Intu'];
$this->endurance = $Result['Endu'];
$this->intellect = $Result['Intl'];
$this->exp		 = $Result['Expa'];
$this->free_ups	 = $Result['Ups'];
$this->money	 = $Result['Money'];
$this->align	 = $Result['Align'];
$this->won		 = $Result['Won'];
$this->lost		 = $Result['Lost'];
$this->hpnow	 = $Result['HPnow'];
$this->hpall	 = $Result['HPall'];
$this->level	 = $Result['Level'];
$this->clanID	 = $Result['ClanID'];
$this->clanRank	 = $Result['ClanRank'];
$this->picture	 = $Result['Pict'];
$this->sex		 = $Result['Sex'];
$this->birth	 = $Result['PersBirthdate'];
$this->realname	 = $Result['RealName'];
$this->info		 = $Result['Info'];
$this->battle_id = $Result['BattleID'];
$this->city		 = $Result['City'];
$this->Reg_IP	 = $Result['Reg_IP'];
$this->room		 = $Result['Room'];

for( $i=0; $i<11; $i++ ){ $this->Slot[$i] = 'empt'; }

$result = $db->queryArray("SELECT * FROM ".SQL_PREFIX."things WHERE Owner = '$name' AND Wear_ON = '1' AND Slot BETWEEN '0' AND '10';");

if(!empty($result)){
foreach($result as $v){

$this->Slot_id[$v['Slot']]   =  $v['Un_Id'];
$this->Slot[$v['Slot']]      =  $v['Id'];
$this->NOWwear[$v['Slot']]   =  $v['NOWwear'];
$this->MAXwear[$v['Slot']]   =  $v['MAXwear'];
$this->MINdamage[$v['Slot']] =  $v['MINdamage'];
$this->MAXdamage[$v['Slot']] =  $v['MAXdamage'];
$this->SumMINdamage +=  $v['MINdamage'];
$this->SumMAXdamage +=  $v['MAXdamage'];

$this->PlusHP[$i]    =  $v['Endu_add'];
$this->Slot_name[$i] =  $v['Thing_Name'];
$this->Crit         +=  $v['Crit'];
$this->FullCost     +=  $v['Cost'];
$this->ACrit        +=  $v['AntiCrit'];
$this->Uvorot       +=  $v['Uv'];
$this->AUvorot      +=  $v['AntiUv'];
$this->Armor1       +=  $v['Armor1'];
$this->Armor2       +=  $v['Armor2'];
$this->Armor3       +=  $v['Armor3'];
$this->Armor4       +=  $v['Armor4'];

}
}

}



function unwear_all()
{	for( $i = 0; $i < 11; $i++ )
	{		if( $this->Slot[$i] != 'empt'.$i )
		{		    $this->unwear( $this->Slot_id[$i] );
		}
	}
}

function unwear($id){
global $db;

$query = '';

if( $thing_on = $db->queryRow("SELECT Un_Id, Endu_add, Slot, Stre_add, Agil_add, Intu_add, Level_add, Thing_Name FROM ".SQL_PREFIX."things WHERE Owner = '$this->login' AND Un_Id = '$id' AND Wear_ON = '1'") )
{	if ($this->hpnow > ($this->hpall - $thing_on['Endu_add']) ){ $db->execQuery("UPDATE ".SQL_PREFIX."players SET HPnow = HPall - '".$thing_on['Endu_add']."' WHERE Username = '$this->login'"); }
	if ($thing_on['Stre_add']) { $db->execQuery("UPDATE ".SQL_PREFIX."players SET Stre = Stre - '".$thing_on['Stre_add']."' WHERE Username = '$this->login'"); }
	if ($thing_on['Agil_add']) { $db->execQuery("UPDATE ".SQL_PREFIX."players SET Agil = Agil - '".$thing_on['Agil_add']."' WHERE Username = '$this->login'"); }
	if ($thing_on['Intu_add']) { $db->execQuery("UPDATE ".SQL_PREFIX."players SET Intu = Intu - '".$thing_on['Intu_add']."' WHERE Username = '$this->login'"); }
	if ($thing_on['Endu_add']) { $db->execQuery("UPDATE ".SQL_PREFIX."players SET HPall = HPall - '".$thing_on['Endu_add']."' WHERE Username = '$this->login'"); }
	if ($thing_on['Level_add']) {$db->execQuery("UPDATE ".SQL_PREFIX."players SET Level = Level - '".$thing_on['Level_add']."' WHERE Username = '$this->login'"); }
	if ($thing_on['Slot'] == 4 || $thing_on['Slot'] == 5 || $thing_on['Slot'] == 6) { $query = ", Slot = '4'"; }

	$db->execQuery("UPDATE ".SQL_PREFIX."things SET Wear_ON = '0' ".$query." WHERE Owner = '$this->login' AND Un_Id = '".$id."' AND Wear_ON = '1'");

}

}


function GetStats(){
$str  = 'Сила: '.$this->strength.'<br />';
$str .= 'Ловкость: '.$this->agility.'<br />';
$str .= 'Интуиция: '.$this->intuition.'<br />';
$str .= 'Выносливость: '.$this->endurance.'<br />';
if ($this->level >= 10){
$str .= 'Интеллект: '.$this->intellect.'<br />';
}

return $str;
}

function SetHealth($hp){
global $db;
$db->update( SQL_PREFIX.'players', Array( 'HPnow' => intval($hp) ), Array( 'Username' => $this->login ) );
$this->hpnow = $hp;
}


function CheckThing($th_id){
global $db;
$rez = 0;
$thing = $db->queryRow("SELECT * FROM ".SQL_PREFIX."things WHERE (Owner = '$this->login') AND (Un_Id = '".intval($th_id)."')");
$rez = (($thing['Stre_need'] <= $this->strength) && ($thing['Agil_need'] <= $this->agility) && ($thing['Intu_need'] <= $this->intuition) && ($thing['Endu_need'] <= $this->endurance) && ($thing['Intl_need'] <= $this->intellect) && ($thing['Level_need'] <= $this->level));
return $rez;
}


function HealTrauma(){
global $db;

if ( !$kr = $db->queryRow("SELECT * FROM ".SQL_PREFIX."inv WHERE Username = '$this->login'") ){ $healed = 0; }
else{

$type3 = $kr['Type3'];
$type2 = $kr['Type2'];
$type  = $kr['Type'];

if ($type2 == 1) {
$db->update( SQL_PREFIX.'players', Array( 'Stre' => '[+]'.$type3 ), Array( 'Username' => $this->login ), 'maths' );
$this->strength += $type3;
}

if ($type2 == 2) {
$db->update( SQL_PREFIX.'players', Array( 'Agil' => '[+]'.$type3 ), Array( 'Username' => $this->login ), 'maths' );
$this->agility += $type3;
}

if ($type2 == 3) {
$db->update( SQL_PREFIX.'players', Array( 'Intu' => '[+]'.$type3 ), Array( 'Username' => $this->login ), 'maths' );
$this->intuition += $type3;
}

$db->execQuery("DELETE FROM ".SQL_PREFIX."inv WHERE Username = '$this->login'");
$db->update( SQL_PREFIX.'online', Array( 'Inv' => '0' ), Array( 'Username' => $this->login ) );
$healed = 1;
}

return $healed;
}


function MakeTrauma($BattleID){
global $db;
if ( !$kr = $db->queryRow("SELECT * FROM ".SQL_PREFIX."inv WHERE Username = '$this->login'") ){

$type      = 1;
$type2     = rand(1,3);
$time_heal = rand(3600,14400);
$time_free = time() + $time_heal;
$tr_rand   = rand(1,6);

if ($tr_rand == 1) {$tr   = 'растяжение <ВЦ>';    }
if ($tr_rand == 2) {$tr   = 'ушиб пятой точки';   }
if ($tr_rand == 3) {$tr   = 'моральное унижение'; }
if ($tr_rand == 4) {$tr   = 'глубокая дипрессия'; }
if ($tr_rand == 5) {$tr   = 'перелом руки';       }
if ($tr_rand == 6) {$tr   = 'растяжение ноги';    }

if ($type2 == 1) {
$type3 = rand(1, round($this->strength / 2) );
$db->update( SQL_PREFIX.'players', Array( 'Stre' => '[-]'.$type3 ), Array( 'Username' => $this->login ), 'maths' );
$db->insert( SQL_PREFIX.'inv', Array( 'Username' => $this->login, 'Type' => '1', 'Type2' => '1', 'Type3' => $type3, 'Time' => $time_free ) );
$this->strength -= $type3;
}

if ($type2 == 2) {
$type3 = rand(1, round($this->agility / 2) );
$db->update( SQL_PREFIX.'players', Array( 'Agil' => '[-]'.$type3 ), Array( 'Username' => $this->login ), 'maths' );
$db->insert( SQL_PREFIX.'inv', Array( 'Username' => $this->login, 'Type' => '1', 'Type2' => '2', 'Type3' => $type3, 'Time' => $time_free ) );
$this->agility -= $type3;
}

if ($type2 == 3) {
$type3=rand(1, round($this->intuition / 2));
$db->update( SQL_PREFIX.'players', Array( 'Intu' => '[-]'.$type3 ), Array( 'Username' => $this->login ), 'maths' );
$db->insert( SQL_PREFIX.'inv', Array( 'Username' => $this->login, 'Type' => '1', 'Type2' => '3', 'Type3' => $type3, 'Time' => $time_free ) );
$this->intuition -= $type3;
}

$Add_die = '<font class="date">'.$time_now.'</font> '.$this->Getdlogin().' получает травму <font color="red"><b>"'.$tr.'"</b></font><BR>';
$db->update( SQL_PREFIX.'online', Array( 'Inv' => '1' ), Array( 'Username' => $this->login ) );
WriteBattleLog($Add_die, $BattleID);

} else {

if ( $kr['Type'] == 1 ){

$type      = 2;
$type3     = $kr['Type3'];
$type2     = $kr['Type2'];
$time      = rand(4*3600, 24*3600);
$time_free = time() + $time;
$Add_die   = '<font class=date>'.$time_now.'</font>'.$this->Getdlogin().' получает инвалидность <BR>';

if ($type2 == 1) {$db->update( SQL_PREFIX.'players', Array( 'Stre' => '[-]'.$type3 ), Array( 'Username' => $this->login ), 'maths' );
$this->strength -= $type3;
}

if ($type2 == 2) {$db->update( SQL_PREFIX.'players', Array( 'Agil' => '[-]'.$type3 ), Array( 'Username' => $this->login ), 'maths' );
$this->agility -= $type3;
}

if ($type2 == 3) {$db->update( SQL_PREFIX.'players', Array( 'Intu' => '[-]'.$type3 ), Array( 'Username' => $this->login ), 'maths' );
$this->intuition -= $type3;
}

$type3 *= 2;
$db->update( SQL_PREFIX.'inv', Array( 'Type3' => $type3, 'Type' => '2', 'Time' => $time_free ), Array( 'Username' => $this->login ) );
$db->update( SQL_PREFIX.'online', Array( 'Inv' => '1' ), Array( 'Username' => $this->login ) );
WriteBattleLog($Add_die, $BattleID);

}

}
}


function SetDead($BattleID){global $db;
$db->update( SQL_PREFIX.'battle_list', Array( 'Dead' => '1' ), Array( 'Player' => $this->login, 'Id' => $BattleID ) );
}


function AddDamage($damage, $BattleID){
global $db;
$db->update( SQL_PREFIX.'battle_list', Array( 'Damage' => '[+]'.$damage ), Array( 'Player' => $this->login, 'Id' => $BattleID ), 'maths' );
}

function Getdlogin(){
return __dlogin($this->array);
}


function __destruct(){
$this->login;
$this->array;
$this->strength;
$this->agility;
$this->endurance;
$this->intuition;
$this->intellect;
$this->exp;
$this->free_ups;
$this->money;
$this->align;
$this->won;
$this->lost;
$this->hpall;
$this->hpnow;
$this->level;
$this->clanID;
$this->clanRank;
$this->picture;
$this->Sex;
$this->birth;
$this->realname;
$this->info;
$this->battle_id;
$this->icq;
$this->city;
$this->Slot;
$this->NOWwear;
$this->MAXwear;
$this->MINdamage;
$this->Crit;
$this->ACrit;
$this->Uvorot;
$this->AUvorot;
$this->Armor1;
$this->Armor2;
$this->Armor3;
$this->Armor4;
$this->MAXdamage;
$this->SumMAXdamage;
$this->SumMINdamage;
$this->Slot_name;
$this->Slot_id;
$this->FullCost;
$this->Image;
$this->status;
$this->Reg_IP;
$this->PlusHP;
}


}
?>