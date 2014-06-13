<?
function ClanAbils(&$owner, &$target, &$damage1, &$crit1, $abilstype, $battleid){
GLOBAL $BattleID, $db;

$log = '';

if ($owner->login == 's!.'){ $otr_clan_persent = 50; }
else { $otr_clan_persent = 40; }

$random = rand(0,100);

if ( $owner->login == 's!.' && 30 > $random && $abilstype == '1' ){
$damage1 *= 5;
$damage1  = round($damage1);
$crit1   += 9999999;
$log .= '<font class=date>'.date('H:i').'</font> <font class=E1><b>'.$owner->login.'</b></font> плюнул в лоб <font class=M2><b>'.$target->login.'</b></font> :) <BR />';
}

$random = rand(0,100);

if ( $target->clanID == '255' && 30 > $random && $abilstype == '1' ){
$damage1 *= 2;
$damage_otr = round($damage1);
$damage1 = 0;
$owner->SetHealth($owner->hpnow - $damage_otr);
$target->AddDamage($damage_otr, $battleid);
$log .= '<font class=date>'.date('H:i').'</font> <font class=E1><b>'.$target->login.'</b></font> воспользовался силой моска одмина и отразил часть удара (<FONT COLOR=RED>-<B>'.$damage_otr.'</B> HP </FONT>) на <font class=M2><b>'.$owner->login.'</b></font> ['.$owner->hpnow.'/'.$owner->hpall.'] <BR />';
}

$random = rand(0,100);
//40 - скидка
if ( $owner->clanID == '8' && 30 > $random && $abilstype == '1' ) {
$vamp_hp = $damage1 * 0.5;
$vamp_hp = round($vamp_hp);
$owner->SetHealth($owner->hpnow + $vamp_hp);
$db->execQuery("UPDATE ".SQL_PREFIX."battle_list SET Dead = '0' WHERE Player = '$owner->login' AND Id = '$BattleID'");
$log .= '<font class=date>'.date('H:i').'</font> Медведь <font class=E1><b>'.$owner->login.'</b></font> слопал баночку мёда, и его состояние улучшилось на <FONT COLOR=GREEN><B>'.$vamp_hp.'</B> HP </FONT> ['.$owner->hpnow.'/'.$owner->hpall.']<BR />';
}

$random = rand(0,100);
//25+20 $
if ( $owner->clanID == '10' && 30 > $random && $abilstype == '1' ) {
$vamp_hp = $damage1 * 0.5;
$vamp_hp = round($vamp_hp);
$owner->SetHealth($owner->hpnow + $vamp_hp);
$db->execQuery("UPDATE ".SQL_PREFIX."battle_list SET Dead = '0' WHERE Player = '$owner->login' AND Id = '$BattleID'");
$log .= '<font class=date>'.date('H:i').'</font> Сила Избранных помогла <font class=E1><b>'.$owner->login.'</b></font> восстоновить <FONT COLOR=GREEN><B>'.$vamp_hp.'</B> HP </FONT> ['.$owner->hpnow.'/'.$owner->hpall.']<BR />';
}

/*
$random = rand(0,100);
//50
if ( $owner->login == 'NAVUHODONOSOR' && 30 > $random && $abilstype == 1 ) {
$vamp_hp = $damage1 * 0.5;
$vamp_hp = round($vamp_hp);
$owner->SetHealth($owner->hpnow + $vamp_hp);
$db->execQuery("UPDATE ".SQL_PREFIX."battle_list SET Dead = '0' WHERE Player = '$owner->login' AND Id = '$BattleID'");
$log .= '<font class=date>'.date('H:i').'</font> Сила Святого Напильника наполнила бойца <font class=E1><b>'.$owner->login.'</b></font>, и он восстановил <FONT COLOR=GREEN><B>'.$vamp_hp.'</B> HP </FONT> ['.$owner->hpnow.'/'.$owner->hpall.']<BR />';
}
*/
$random = rand(0,100);

if ( $owner->clanID == '6' && 30 > $random && $abilstype == '1' ) {
$vamp_hp = $damage1 * 0.5;
$vamp_hp = round($vamp_hp);
$owner->SetHealth($owner->hpnow + $vamp_hp);
$db->execQuery("UPDATE ".SQL_PREFIX."battle_list SET Dead = '0' WHERE Player = '$owner->login' AND Id = '$BattleID'");
$log .= '<font class=date>'.date('H:i').'</font> Сатана помог <font class=E1><b>'.$owner->login.'</b></font>, и он восстанавливает <FONT COLOR=GREEN><B>'.$vamp_hp.'</B> HP </FONT> ['.$owner->hpnow.'/'.$owner->hpall.']<BR />';
}

$random = rand(0,100);
//50$
if ( $owner->clanID == '12' && 30 > $random && $abilstype == '1' ) {
$vamp_hp = $damage1 * 0.5;
$vamp_hp = round($vamp_hp);
$owner->SetHealth($owner->hpnow + $vamp_hp);
$db->execQuery("UPDATE ".SQL_PREFIX."battle_list SET Dead = '0' WHERE Player = '$owner->login' AND Id = '$BattleID'");
$log .= '<font class=date>'.date('H:i').'</font> Неожиданно вспыхнул яркий свет, ослепив противника <font class=E1><b>'.$target->login.'</b></font>, тем самым предупреждая, что не стоит связываться с Неповторимыми и даровал <FONT COLOR=GREEN><B>'.$vamp_hp.'</B> HP </FONT> ['.$owner->hpnow.'/'.$owner->hpall.'] персонажу <font class=E1><b>'.$owner->login.'</b></font>.<BR />';
}

//крит 20% - 50 $
if ( $owner->clanID == 13 && $abilstype == 1 ) {
$crit1 += 20;
}

$random = rand(0,100);
//120$
if ( $owner->clanID == '11' && 15 > $random && $abilstype == '1' ) {
$damage1 *= 2;
$damage1  = round($damage1);
$crit1   += 9999999;
$log     .= '<font class=date>'.date('H:i').'</font> <font class=E1><b>'.$owner->login.'</b></font> применил Божественную Силу и нанес сокрушительный удар <font class=E1><b>'.$target->login.'</b></font><BR />';
}

$random = rand(0,100);
//50$
if ( $owner->clanID == '11' && 30 > $random && $abilstype == '1' ) {
$vamp_hp = $damage1 * 0.5;
$vamp_hp = round($vamp_hp);
$owner->SetHealth($owner->hpnow + $vamp_hp);
$db->execQuery("UPDATE ".SQL_PREFIX."battle_list SET Dead = '0' WHERE Player = '$owner->login' AND Id = '$BattleID'");
$log .= '<font class=date>'.date('H:i').'</font> <font class=E1><b>'.$owner->login.'</b></font> применил Божественную Магию и поправил свое здоровье на <FONT COLOR=GREEN><B>'.$vamp_hp.'</B> HP </FONT> ['.$owner->hpnow.'/'.$owner->hpall.']<BR />';
}

$random = rand(0,100);
//100$
if ( $owner->clanID == '8' && 15 > $random && $abilstype == '1' ) {
$damage1 *= 3;
$damage1  = round($damage1);
$crit1   += 9999999;
$log     .= '<font class=date>'.date('H:i').'</font> Медведь <font class=E1><b>'.$owner->login.'</b></font> разозлился и отвесил оплеуху <font class=E1><b>'.$target->login.'</b></font><BR />';
}


//$random = rand(0,100);
//200$
//if ( $owner->clanID == 12 && 15 > $random && $abilstype == 1 ) {
//$damage1 *= 2;
//$damage1  = round($damage1);
//$crit1   += 9999999;
//$log     .= '<font class=date>'.date('H:i').'</font> Неожиданно вспыхнул яркий свет, ослепив противника <font class=E1><b>'.$target->login.'</b></font>, тем самым предупреждая, что не стоит связываться с Неповторимыми и <font class=E1><b>'.$owner->login.'</b></font> наносит страшнейший удар.<BR />';
//}

$random = rand(0,100);
//200$
if ( $target->clanID == '13' && 15 > $random && $abilstype == '1' ){
$damage_otr = round($damage1);
$damage1 = 0;
$owner->SetHealth($owner->hpnow - $damage_otr);
$target->AddDamage($damage_otr, $battleid);
$log .= '<font class=date>'.date('H:i').'</font> Боги защитили ТИТАНА <font class=E1><b>'.$target->login.'</b></font> зеркальной броней и отразили удар (<FONT COLOR=RED>-<B>'.$damage_otr.'</B> HP </FONT>) на <font class=M2><b>'.$owner->login.'</b></font> ['.$owner->hpnow.'/'.$owner->hpall.'] <BR />';
}

if ( ($target->login == 'ЛамоБот') || ($target->Reg_IP == 'бот') ){
$target->Armor1 = 0;
$target->Armor2 = 0;
$target->Armor3 = 0;
$target->Armor4 = 0;
$owner->Armor1  = 0;
$owner->Armor2  = 0;
$owner->Armor3  = 0;
$owner->Armor4  = 0;

if( $target->login != 'ЛамоБот' && $target->login != 'Тренер' && !preg_match( '/Бот_/i', $target->login ) ){
$owner->Uvorot  = 0;
$owner->ACrit  *= 0.5;
}

}



if ( ($owner->login == 'ЛамоБот') || ($owner->Reg_IP == 'бот') ){
$target->Armor1 = 0;
$target->Armor2 = 0;
$target->Armor3 = 0;
$target->Armor4 = 0;
$owner->Armor1  = 0;
$owner->Armor2  = 0;
$owner->Armor3  = 0;
$owner->Armor4  = 0;

if( $owner->login != 'ЛамоБот' && $owner->login != 'Тренер' && !preg_match( '/Бот_/i', $owner->login ) ){
$target->Uvorot = 0;
$target->ACrit *= 0.5;
}

}

return $log;
}
?>
