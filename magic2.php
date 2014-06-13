<?
include_once('db_config.php');
include_once('db.php');

function magic($itemid, $target, $BattleID){
global $db;

$ar = $db->queryRow("SELECT * FROM ".SQL_PREFIX."things WHERE Un_Id = '$itemid'");

if ($itemid != 10){ $login = $ar['Owner']; }
else { $login = $target; }

$owner     = new Player($login);
$Add_log   = '';
$descr     = $ar['Thing_Name'];
$name      = $ar['MagicID'];
$used      = (rand(1,100) < $ar['Srab']);
$maxdamage = $ar['MAXdamage'];
$mindamage = $ar['MINdamage'];

$antimag = 1;

if ($name == 'Подчинение' || $name == 'Fireball' || $name == 'Ледяной удар') {


if ( $dat = $db->queryRow("SELECT * FROM ".SQL_PREFIX."things WHERE (Id = 'antimag1') AND (Owner = '$target')") ){

$used = (rand(1,200) < $ar['Srab']);
if (!$used) { $antimag = 0; $antimagname = $target; }

}


}



if ($used && $antimag == 1){
if ($name == '+ 20 HP'  || $name == '+ 30 HP' || $name == '+ 50 HP' || $name == '+ 100 HP'  || $name == '+ 500 HP' || $name == 'Вкусняшка' ) {
switch ($name) {

case '+ 20 HP':
$heal_hm = 20;
break;

case '+ 30 HP':
$heal_hm = 30;
break;

case '+ 50 HP':
$heal_hm = 50;
break;

case '+ 100 HP':
$heal_hm = 100;
break;

case '+ 500 HP':
$heal_hm = 500;
break;

case 'Вкусняшка':
$heal_hm = $ar['Level_need']*2;
break;

}

if ($owner->hpnow == $owner->hpall) {

$newhp = $owner->hpnow - $heal_hm;
$err = 'Вас стошнило';
$Add_log .= '<font class=date>'.date('H:i').'</font> <font class=B1>'.$login.'</font> неудачно использовал "<b><i>'.$ar['Thing_Name'].'</i></b>", потеряв <B>'.$heal_hm.'</B> HP ['.$newhp.'/'.$owner->hpall.']<BR>';

} else {
$err = 'Удачно восстановлено '.$heal_hm.' HP';
$newhp = $owner->hpnow + $heal_hm;
if ($newhp > $owner->hpall) { $newhp = $owner->hpall; }
$Add_log .= '<font class=date>'.date('H:i').'</font> <font class=B1>'.$login.'</font> использовал "<b><i>'.$ar['Thing_Name'].'</i></b>", восстановив тем самым <B>'.$heal_hm.'</B> HP ['.$newhp.'/'.$owner->hpall.']<BR>';
}

$owner->SetHealth($newhp);

}


if ($name == 'Лекарь 10' || $name == 'Лекарь 20' || $name == 'Лекарь 50' || $name == 'Лекарь 100') {

switch ($name) {

case 'Лекарь 10':
$heal_hm = 10;
break;

case 'Лекарь 20':
$heal_hm = 20;
break;

case 'Лекарь 50':
$heal_hm = 50;
break;

case 'Лекарь 100':
$heal_hm = 100;
break;

}

if ( $temp = $db->queryRow("SELECT * FROM ".SQL_PREFIX."players WHERE (BattleID = '$BattleID') AND (Username = '$target') AND (HPnow > '0')") ) {

$target =  new Player($target);

$newhp = $target->hpnow + $heal_hm;
if ($newhp > $target->hpall) { $newhp = $target->hpall; }

$target->SetHealth($newhp);

$Add_log .= '<font class=date>'.date('H:i').'</font> <font class=B1>'.$login.'</font> использовал "<b><i>'.$ar['Thing_Name'].'</i></b>" на <B>'.$target->login.'</B>  восстановив ему тем самым <B>'.$heal_hm.'</B> HP ['.$newhp.'/'.$target->hpall.']<BR>';
}

}


switch ($name){

case 'note':
$target = htmlspecialchars($target);
$Add_log .= '<font class=date>'.date('H:i').'</font> <B><font class=B1>'.$login.'</font> подумал и сказал: <i>'.$target.'</i></B><BR>';
break;


case 'Подчинение':
if ( $temp = $db->queryRow("SELECT * FROM ".SQL_PREFIX."battle_list WHERE Id = '$BattleID' AND Player = '$target'") ){

if ($temp['Team'] == 1){ $temp_team = 2; }else{ $temp_team = 1; }

$db->update( SQL_PREFIX.'battle_list', Array( 'Team' => $temp_team ), Array( 'Id' => $BattleID, 'Player' => $target ) );

$Add_log .= '<font class=date>'.date('H:i').'</font> <font class=B1>'.$login.'</font> подчинил "<b><i>'.$target.'</i></b>"на свою сторону<BR>';
} else { $err = 'Такого противника нет'; }
break;


case 'Воскрешение':
if ( $db->queryRow("SELECT * FROM ".SQL_PREFIX."battle_list WHERE Id = '$BattleID' AND Player = '$target->login' AND Dead = '1'") ){

$db->update( SQL_PREFIX.'battle_list', Array( 'Dead' => '0' ), Array( 'Id' => $BattleID, 'Player' => $target->login ) );
$target->SetHealth($target->hpall);

$Add_log .= '<font class=date>'.date('H:i').'</font> <font class=B1>'.$login.'</font> воскресил "<b><i>'.$target->login.'</i></b>" <BR>';
} else { $err = 'Такого мёртвого персонажа нет в вашем бою'; }
break;


case 'Уход':
if ( $db->queryRow("SELECT * FROM ".SQL_PREFIX."battle_list WHERE Id = '$BattleID' AND Player = '$login' AND Dead = '0'") ){

$db->update( SQL_PREFIX.'players', Array( 'BattleID' => '' ), Array( 'Username' => $login ) );
$db->execQuery("DELETE FROM ".SQL_PREFIX."battle_list WHERE Id = '$BattleID' AND Player = '$login'");

$Add_log .= '<font class=date>'.date('H:i').'</font> <font class=B1>'.$login.'</font> покинул этот бой <BR>';
} else { $err = 'Ошибко :('; }
break;


case 'Оживление':

$heal_hm = $owner->hpall / 2;
$heal_hm = round($heal_hm);
$newhp = $owner->hpnow + $heal_hm;

if ($newhp > $owner->hpall) { $newhp = $owner->hpall; }

$Add_log .= '<font class=date>'.date('H:i').'</font> <b><i>'.$ar['Thing_Name'].'</i></b>, восстановил <font class=B1>'.$login.'</font> <B>'.$heal_hm.'</B> HP ['.$newhp.'/'.$owner->hpall.']<BR>';
$owner->SetHealth($newhp);
break;


case 'Fireball':
case 'Ледяной удар':

if ( $temp = $db->queryRow("SELECT * FROM ".SQL_PREFIX."players WHERE (BattleID = '$BattleID') AND (Username = '$target') AND (HPnow > '0')") ) {

$target = new Player($target);

$firedamage = rand($maxdamage, $mindamage);

$newhp = $target->hpnow - $firedamage;
$target->SetHealth($newhp);

$db->update( SQL_PREFIX.'battle_list', Array( 'Damage' => '[+]'.$firedamage ), Array( 'Player' => $login, 'Id' => $BattleID ), 'maths' );
$Add_log .= '<font class=date>'.date('H:i').'</font> <font class=B1>'.$login.'</font> использовал "<b><i>'.$ar['Thing_Name'].'</i></b>" на <B>'.$target->login.'</B>  <font color=RED><B>- '.$firedamage.'</B></FONT> HP<BR>';

if ($newhp < 1) {
$db->update( SQL_PREFIX.'battle_list', Array( 'Dead' => '1' ), Array( 'Player' => $target->login, 'Id' => $BattleID ) );
$Add_log .= "<font class=date>".date('H:i')."</font> <script>dlogin(".sprintf("'%s', %d, %d, %d", $target->login, $target->level, $target->align, $target->clanID ).")</script> повержен<BR>";
}

}
break;

case 'Камнепад':
case 'Разряды молний':

$kolvo = 0;

if($name == 'Камнепад'){ $maxkolvo = 25; }
elseif($name == 'Разряды молний'){ $maxkolvo = 3; }
else{ $maxkolvo = 1; }

list($team) = $db->queryCheck("SELECT Team FROM ".SQL_PREFIX."battle_list WHERE Player = '$login' AND Id = '$BattleID'");

$Add_log .= '<font class=date>'.date('H:i').'</font> <font class=B1>'.$login.'</font> обрушил "<b><i>'.$ar['Thing_Name'].'</i></b>" на команду противника<BR>';

$mgel = $db->query("SELECT * FROM ".SQL_PREFIX."battle_list WHERE (Team <> '$team') && (Dead = '0') AND (Id = '$BattleID')");
while(($dat = mysql_fetch_array($mgel)) && ($kolvo < $maxkolvo)) {
$kolvo++;

$firedamage = rand($mindamage, $maxdamage);

list($Uname, $Level, $Align, $ClanID, $HPnow) = $db->queryCheck("SELECT Username, Level, Align, ClanID, HPnow FROM ".SQL_PREFIX."players WHERE (BattleID = '$BattleID') AND (Username = '{$dat['Player']}') AND (HPnow > 0)");

$newhp = $HPnow - $firedamage;

$antimag = 1;

if ( $db->queryRow("SELECT * FROM ".SQL_PREFIX."things WHERE (Id = 'antimag1') AND (Owner = '$Uname')") ){
if (rand(0,100) < $ar['Srab']) { $antimag = 0; }
}

if ($antimag == 1){

$target = new Player($Uname);
$target->SetHealth($newhp);

$db->update( SQL_PREFIX.'battle_list', Array( 'Damage' => '[+]'.$firedamage ), Array( 'Player' => $login, 'Id' => $BattleID ), 'maths' );
$Add_log .= '<font class=date>'.date('H:i').'</font> <B>'.$Uname.'</B> получает урон <FONT COLOR=RED><B>- '.$firedamage.'</B></FONT> HP<BR>';

if ($newhp < 1) {
$db->update( SQL_PREFIX.'battle_list', Array( 'Dead' => '1' ), Array( 'Player' => $Uname, 'Id' => $BattleID ) );
$Add_log .= "<font class=date>".date('H:i')."</font> <script>dlogin(".sprintf("'%s', %d, %d, %d", $Uname, $Level, $Align, $ClanID).")</script> повержен<BR>";
}

} else { $Add_log .= '<font class=date>'.date('H:i').'</font> <B>'.$Uname.'</B> защитился от магии<BR>'; }
}
break;


default:
break;
}

} else {

if ($antimag == 1){ $Add_log .= "<font class=date>".date('H:i')."</font> <script>dlogin(".sprintf("'%s', %d, %d, %d", $owner->login, $owner->level, $owner->align, $owner->clanID ).")</script> пытался использовать магию <b>\"".$ar['Thing_Name']."\"</b>, но неудачно <BR>"; }
else { $Add_log .= "<font class=date>".date('H:i')."</font> <script>dlogin(".sprintf("'%s', %d, %d, %d", $owner->login, $owner->level, $owner->align, $owner->clanID ).")</script> пытался использовать магию <b>\"".$ar['Thing_Name']."\"</b>, но <B>$antimagname</B> защитился от магии <BR>"; }

}

if($name != 'Принуждение' && $name != 'Нападение' && $name != 'Сброс статов' && $name != 'Сброс своих статов'){
$db->update( SQL_PREFIX.'things', Array( 'NOWwear' => '[+]1' ), Array( 'Un_Id' => $itemid, 'Owner' => $login ), 'maths' );
}
if($itemid != 10){ $db->execQuery('DELETE FROM '.SQL_PREFIX.'things WHERE NOWwear = MAXwear'); }

return $Add_log;
}
?>
