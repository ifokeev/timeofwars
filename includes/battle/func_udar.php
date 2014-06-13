<?
function udar(&$Player, &$Enemy, $my_kick, $enemy_block){//Рассчёт удара и блока
GLOBAL $inv1, $inv2, $db, $db_config;

$Add_log   = '';
$koef      = 20;
$abilstype = 0;


for ($i=1; $i<=100; $i++){
$str_mindamage[$i] = 0;
$str_maxdamage[$i] = 0;
}

$res = $db->queryArray('SELECT * FROM '.SQL_PREFIX.'damage_strength');
if(!empty($res)){
foreach($res as $v){
$str_mindamage[$v['Stringth']] = $v['MINdamage'];
$str_maxdamage[$v['Stringth']] = $v['MAXdamage'];
}
}

$inv2           = 0;
$uv             = 0;
$kr             = 0;
$blocked        = 0;
$damage1        = 0;
$my_kick        = intval($my_kick);
$enemy_block    = intval($enemy_block);
$kick           = $my_kick;
$block          = $enemy_block;
$result         = $enemy_block & $my_kick;

$maxdamage_stre = $str_maxdamage[$Player->strength];
$mindamage_stre = $str_mindamage[$Player->strength];
$maxdamage1     = $Player->SumMAXdamage + $maxdamage_stre;
$mindamage1     = $Player->SumMINdamage + $mindamage_stre;

$crit1          = $Player->Crit;
$uv2            = $Enemy->Uvorot;

include_once 'includes/battle/battleabils.php';

if (($Player->level != 0) && ($Player->level != '')){ $temp1 = ($Player->intuition/$Player->level)*$koef;    $temp1 = round($temp1); }
else { $temp1 = $koef; }


if (($Enemy->level != 0) && ($Enemy->level != '')){   $temp2 = ($Enemy->agility/$Enemy->level)*$koef;          $temp2 = round($temp2); }
else { $temp2 = $koef; }

$crit1 += $temp1;
$uv2   += $temp2;

$damage1   = rand($mindamage1, $maxdamage1);
$BattleID  = $Player->battle_id;

$whitecrit = 0;



$res = $db->queryFetchArray("SELECT Level_need, Stre_need, Agil_need, Intu_need, Intl_need, max(Crit) as mCrit, max(MAXdamage) as mMAXdamage, MagicID FROM `".SQL_PREFIX."things` WHERE `Owner` = '$Player->login' AND `Slot` = '15' AND (Crit+MAXdamage > '0') GROUP BY MagicID");
if(!empty($res) && !$db->SQL_result($db->query( "SELECT turnir_id FROM ".SQL_PREFIX."turnir_users WHERE user = '".$Player->login."';" ),0) )
{	foreach($res as $v)
	{		if( ($Player->strength < $v['Stre_need']) || ($Player->agility < $v['Agil_need']) || ($Player->intuition < $v['Intu_need']) || ($Player->intellect < $v['Intl_need']) || ($Player->level < $v['Level_need']) ){ //echo $v['MagicID'].' Не подходит';
		}else {			if ($v['mCrit'] > 0 && $v['MagicID'] != 'Чистый крит') { $crit1     += $v['mCrit'];        }
			if ($v['mCrit'] > 0 && $v['MagicID'] == 'Чистый крит') { $whitecrit  = $v['mCrit'];        }
			if ($v['mMAXdamage'] > 0) {                              $damage1   += $v['mMAXdamage'];   }
		}
	}

}


////
if($damage1 > 0){                                                                                                       $abilstype = 1; }
if(($Player->clanID == 1 || $Player->clanID == 2 || $Player->clanID == 3 || $Player->clanID == 4) || ($Enemy->clanID == 1 || $Enemy->clanID == 2 || $Enemy->clanID == 3 || $Enemy->clanID == 4)){                         $abilstype = 0; }
if($Enemy->Reg_IP == 'бот' || $Player->Reg_IP == 'бот'){                                                                $abilstype = 0; }

$Add_log .= ClanAbils($Player, $Enemy, $damage1, $crit1, $abilstype, $BattleID);
////

$res = $db->queryFetchArray("SELECT max(Uv) as mUv FROM `".SQL_PREFIX."things` WHERE `Owner` = '$Enemy->login' AND `Slot` = '15' AND `Uv` > '0' GROUP BY MagicID");
if( !empty($res) && !$db->SQL_result($db->query( "SELECT turnir_id FROM ".SQL_PREFIX."turnir_users WHERE user = '".$Enemy->login."';" ),0) ){
foreach($res as $v){
if ($v['mUv'] > 0){ $uv2 += $v['mUv']; }
}
}

$crit1 -= $Enemy->ACrit;
$uv2   -= $Player->AUvorot;


if ($whitecrit > 0){
if ($crit1 <= 0){ $crit1  = $whitecrit; }
else {            $crit1 += $whitecrit; }
}

if ($crit1 < 0){ $crit1 = 0; }
if ($uv2 < 0){   $uv2   = 0; }


$crit1 = $crit1/1.75;
$uv2   = $uv2/3;

if ($Player->Uvorot != 0){
$delta_uv = $Enemy->Uvorot/$Player->Uvorot;
if ($delta_uv>2){ $delta_uv = 2; }
if ($delta_uv<1){ $delta_uv = 1; }
} else { $delta_uv = 1; }


$delta_uv = $delta_uv*15 + 50;

$armor1 = rand( round($Enemy->Armor1 / 2), $Enemy->Armor1 );
$armor2 = rand( round($Enemy->Armor2 / 2), $Enemy->Armor2 );
$armor3 = rand( round($Enemy->Armor3 / 2), $Enemy->Armor3 );
$armor4 = rand( round($Enemy->Armor4 / 2), $Enemy->Armor4 );

srand((double)microtime()*1000000);
$has_uv  = ($uv2 > rand(1,100))&&($delta_uv > rand(1,100));
$hascrit = ($crit1 > rand(1,100));


if( $Player->login == 'ЛамоБот' && list($uron_time, $for) = $db->queryCheck( "SELECT Time, for_time FROM ".SQL_PREFIX."sms_2uron WHERE Username = '".$Enemy->login."';" ) )
{	if( time() - $uron_time < $for*3600 )
	{
		$damage1 *= 1.5;
		$damage1 = round($damage1);
    }
}
elseif ( $Player->login == 'ЛамоБот' && list($uron_time, $for) = $db->queryCheck( "SELECT Time, for_time FROM ".SQL_PREFIX."sms_3uron WHERE Username = '".$Enemy->login."';" ) )
{
	if( time() - $uron_time < $for*3600 )
	{		$damage1 *= 2;
		$damage1 = round($damage1);
    }
}
if ( list($uron_time, $for) = $db->queryCheck( "SELECT Time, for_time FROM ".SQL_PREFIX."sms_2uron WHERE Username = '".$Player->login."';" ) )
{	if( time() - $uron_time < $for*3600 )
	{		$damage1 *= 2;
    }
}
elseif ( list($uron_time, $for) = $db->queryCheck( "SELECT Time, for_time FROM ".SQL_PREFIX."sms_3uron WHERE Username = '".$Player->login."';" ) )
{
	if( time() - $uron_time < $for*3600 )
	{
		$damage1 *= 3;
    }
}
else
{	if ( $db->queryRow("SELECT * FROM ".SQL_PREFIX."things WHERE (Owner = '$Player->login') AND ((Id = 'ring_dd') OR (Id = 'a_bt06')) AND (Wear_ON = '1')")){ $damage1 *= 2; }
}

if ($has_uv){ $enemy_damage = 0; $uv_type2 = 1; $uv = 1; $damage1 = 0; }
else{
if ($result == $my_kick){ $blocked = 1;

if ($hascrit) { $kr=1; $kreslo2 = $Enemy->hpnow - $damage1; $inv2=($kreslo2 < -($Enemy->hpall * 0.75));

$Enemy->SetHealth($Enemy->hpnow - $damage1);
$Player->AddDamage($damage1, $BattleID);
$enemy_damage = 1;
$crit_type2 = 1;


} else { $enemy_damage = 0; $damage1 = 0; }

} else {
if ($hascrit){

$kr = 1;
$damage1 *= 2;
$kreslo2 = $Enemy->hpnow - $damage1;
$inv2 = ($kreslo2 < -($Enemy->hpall * 0.75 ));

$Enemy->SetHealth($Enemy->hpnow - $damage1);
$Player->AddDamage($damage1, $BattleID);
$enemy_damage = 1;
$crit_type2 = 2;


} else {

if ($my_kick == 1) { $damage1 = $damage1 - $armor1; }
if ($my_kick == 2) { $damage1 = $damage1 - $armor2; }
if ($my_kick == 4) { $damage1 = $damage1 - $armor3; }
if ($my_kick == 8) { $damage1 = $damage1 - $armor4; }
if ($damage1 < 1) { $damage1 = 0; }
$Enemy->SetHealth($Enemy->hpnow - $damage1);
$Player->AddDamage($damage1, $BattleID);
$enemy_damage = 1;
}

}

}

if ($Enemy->hpnow < 0){ $Enemy->SetHealth(0); }

$rez = $enemy_block & $my_kick;
$Add_log .= WriteLog($Player, $Enemy, $uv, $kr, $blocked, $kick, $block, $damage1, $BattleID);
return $Add_log;

}
?>
