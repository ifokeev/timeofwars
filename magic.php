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

if ($name == '����������' || $name == 'Fireball' || $name == '������� ����') {


if ( $dat = $db->queryRow("SELECT * FROM ".SQL_PREFIX."things WHERE (Id = 'antimag1') AND (Owner = '$target')") ){

$used = (rand(1,200) < $ar['Srab']);
if (!$used) { $antimag = 0; $antimagname = $target; }

}


}



if ($used && $antimag == 1){
if ($name == '+ 20 HP'  || $name == '+ 30 HP' || $name == '+ 50 HP' || $name == '+ 100 HP'  || $name == '+ 500 HP' || $name == '���������' ) {
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

case '���������':
$heal_hm = $ar['Level_need']*2;
break;

}

if ($owner->hpnow == $owner->hpall) {

$newhp = $owner->hpnow - $heal_hm;
$err = '��� ��������';
$Add_log .= '<font class=date>'.date('H:i').'</font> <font class=B1>'.$login.'</font> �������� ����������� "<b><i>'.$ar['Thing_Name'].'</i></b>", ������� <B>'.$heal_hm.'</B> HP ['.$newhp.'/'.$owner->hpall.']<BR>';

} else {
$err = '������ ������������� '.$heal_hm.' HP';
$newhp = $owner->hpnow + $heal_hm;
if ($newhp > $owner->hpall) { $newhp = $owner->hpall; }
$Add_log .= '<font class=date>'.date('H:i').'</font> <font class=B1>'.$login.'</font> ����������� "<b><i>'.$ar['Thing_Name'].'</i></b>", ����������� ��� ����� <B>'.$heal_hm.'</B> HP ['.$newhp.'/'.$owner->hpall.']<BR>';
}

$owner->SetHealth($newhp);

}


if ($name == '������ 10' || $name == '������ 20' || $name == '������ 50' || $name == '������ 100') {

switch ($name) {

case '������ 10':
$heal_hm = 10;
break;

case '������ 20':
$heal_hm = 20;
break;

case '������ 50':
$heal_hm = 50;
break;

case '������ 100':
$heal_hm = 100;
break;

}

if ( $temp = $db->queryRow("SELECT * FROM ".SQL_PREFIX."players WHERE (BattleID = '$BattleID') AND (Username = '$target') AND (HPnow > '0')") ) {

$target =  new Player($target);

$newhp = $target->hpnow + $heal_hm;
if ($newhp > $target->hpall) { $newhp = $target->hpall; }

$target->SetHealth($newhp);

$Add_log .= '<font class=date>'.date('H:i').'</font> <font class=B1>'.$login.'</font> ����������� "<b><i>'.$ar['Thing_Name'].'</i></b>" �� <B>'.$target->login.'</B>  ����������� ��� ��� ����� <B>'.$heal_hm.'</B> HP ['.$newhp.'/'.$target->hpall.']<BR>';
}

}


switch ($name){

case 'note':
$target = htmlspecialchars($target);
$Add_log .= '<font class=date>'.date('H:i').'</font> <B><font class=B1>'.$login.'</font> ������� � ������: <i>'.$target.'</i></B><BR>';
break;


case '����������':
if ( $temp = $db->queryRow("SELECT * FROM ".SQL_PREFIX."battle_list WHERE Id = '$BattleID' AND Player = '$target'") ){

if ($temp['Team'] == 1){ $temp_team = 2; }else{ $temp_team = 1; }

$db->update( SQL_PREFIX.'battle_list', Array( 'Team' => $temp_team ), Array( 'Id' => $BattleID, 'Player' => $target ) );

$Add_log .= '<font class=date>'.date('H:i').'</font> <font class=B1>'.$login.'</font> �������� "<b><i>'.$target.'</i></b>"�� ���� �������<BR>';
} else { $err = '������ ���������� ���'; }
break;


case '�����������':
if ( $db->queryRow("SELECT * FROM ".SQL_PREFIX."battle_list WHERE Id = '$BattleID' AND Player = '$target->login' AND Dead = '1'") ){

$db->update( SQL_PREFIX.'battle_list', Array( 'Dead' => '0' ), Array( 'Id' => $BattleID, 'Player' => $target->login ) );
$target->SetHealth($target->hpall);

$Add_log .= '<font class=date>'.date('H:i').'</font> <font class=B1>'.$login.'</font> ��������� "<b><i>'.$target->login.'</i></b>" <BR>';
} else { $err = '������ ������� ��������� ��� � ����� ���'; }
break;


case '����':
if ( $db->queryRow("SELECT * FROM ".SQL_PREFIX."battle_list WHERE Id = '$BattleID' AND Player = '$login' AND Dead = '0'") ){

$db->update( SQL_PREFIX.'players', Array( 'BattleID' => '' ), Array( 'Username' => $login ) );
$db->execQuery("DELETE FROM ".SQL_PREFIX."battle_list WHERE Id = '$BattleID' AND Player = '$login'");

$Add_log .= '<font class=date>'.date('H:i').'</font> <font class=B1>'.$login.'</font> ������� ���� ��� <BR>';
} else { $err = '������ :('; }
break;


case '���������':

$heal_hm = $owner->hpall / 2;
$heal_hm = round($heal_hm);
$newhp = $owner->hpnow + $heal_hm;

if ($newhp > $owner->hpall) { $newhp = $owner->hpall; }

$Add_log .= '<font class=date>'.date('H:i').'</font> <b><i>'.$ar['Thing_Name'].'</i></b>, ����������� <font class=B1>'.$login.'</font> <B>'.$heal_hm.'</B> HP ['.$newhp.'/'.$owner->hpall.']<BR>';
$owner->SetHealth($newhp);
break;


case 'Fireball':
case '������� ����':

if ( $temp = $db->queryRow("SELECT * FROM ".SQL_PREFIX."players WHERE (BattleID = '$BattleID') AND (Username = '$target') AND (HPnow > '0')") ) {

$target = new Player($target);

$firedamage = rand($maxdamage, $mindamage);

$newhp = $target->hpnow - $firedamage;
$target->SetHealth($newhp);

$db->update( SQL_PREFIX.'battle_list', Array( 'Damage' => '[+]'.$firedamage ), Array( 'Player' => $login, 'Id' => $BattleID ), 'maths' );
$Add_log .= '<font class=date>'.date('H:i').'</font> <font class=B1>'.$login.'</font> ����������� "<b><i>'.$ar['Thing_Name'].'</i></b>" �� <B>'.$target->login.'</B>  <font color=RED><B>- '.$firedamage.'</B></FONT> HP<BR>';

if ($newhp < 1) {
$db->update( SQL_PREFIX.'battle_list', Array( 'Dead' => '1' ), Array( 'Player' => $target->login, 'Id' => $BattleID ) );
$Add_log .= "<font class=date>".date('H:i')."</font> <script>dlogin(".sprintf("'%s', %d, %d, %d", $target->login, $target->level, $target->align, $target->clanID ).")</script> ��������<BR>";
}

}
break;

case '��������':
case '������� ������':

$kolvo = 0;

if($name == '��������'){ $maxkolvo = 25; }
elseif($name == '������� ������'){ $maxkolvo = 3; }
else{ $maxkolvo = 1; }

list($team) = $db->queryCheck("SELECT Team FROM ".SQL_PREFIX."battle_list WHERE Player = '$login' AND Id = '$BattleID'");

$Add_log .= '<font class=date>'.date('H:i').'</font> <font class=B1>'.$login.'</font> ������� "<b><i>'.$ar['Thing_Name'].'</i></b>" �� ������� ����������<BR>';

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
$Add_log .= '<font class=date>'.date('H:i').'</font> <B>'.$Uname.'</B> �������� ���� <FONT COLOR=RED><B>- '.$firedamage.'</B></FONT> HP<BR>';

if ($newhp < 1) {
$db->update( SQL_PREFIX.'battle_list', Array( 'Dead' => '1' ), Array( 'Player' => $Uname, 'Id' => $BattleID ) );
$Add_log .= "<font class=date>".date('H:i')."</font> <script>dlogin(".sprintf("'%s', %d, %d, %d", $Uname, $Level, $Align, $ClanID).")</script> ��������<BR>";
}

} else { $Add_log .= '<font class=date>'.date('H:i').'</font> <B>'.$Uname.'</B> ��������� �� �����<BR>'; }
}
break;


default:
break;
}

} else {

if ($antimag == 1){ $Add_log .= "<font class=date>".date('H:i')."</font> <script>dlogin(".sprintf("'%s', %d, %d, %d", $owner->login, $owner->level, $owner->align, $owner->clanID ).")</script> ������� ������������ ����� <b>\"".$ar['Thing_Name']."\"</b>, �� �������� <BR>"; }
else { $Add_log .= "<font class=date>".date('H:i')."</font> <script>dlogin(".sprintf("'%s', %d, %d, %d", $owner->login, $owner->level, $owner->align, $owner->clanID ).")</script> ������� ������������ ����� <b>\"".$ar['Thing_Name']."\"</b>, �� <B>$antimagname</B> ��������� �� ����� <BR>"; }

}

if($name != '�����������' && $name != '���������' && $name != '����� ������' && $name != '����� ����� ������'){
$db->update( SQL_PREFIX.'things', Array( 'NOWwear' => '[+]1' ), Array( 'Un_Id' => $itemid, 'Owner' => $login ), 'maths' );
}
if($itemid != 10){ $db->execQuery('DELETE FROM '.SQL_PREFIX.'things WHERE NOWwear = MAXwear'); }

return $Add_log;
}
?>
