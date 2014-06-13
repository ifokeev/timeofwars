<?php
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

session_start();

header('Content-type: text/html; charset=windows-1251');

include_once ('../db_config.php');
include_once ('../db.php');
include_once ('../classes/PlayerInfo.php');
include_once ('../includes/conf/conf_chat.php');
include_once ('../includes/lib/php2js.php');

$player = new PlayerInfo();



if ( isset($player->ChatRoom) ){

if ( $_val = split('::', @$_ROOM[''.$player->ChatRoom.'']) ){

if ( @$_val[1] == 'S' ) {
if ( $player->Sex != $_val[2] ){

$_SESSION['userroom'] = 'newby';
$db->update( SQL_PREFIX.'players', Array( 'Room' => 'main', 'ChatRoom' => 'newby' ), Array( 'Username' => $player->username ) );
die('<script> top.Room = "newby"; top.frames["ONLINE"].reload();</script>');

}
}


if ( @$_val[1] == 'С' ) {
if ( $player->id_clan != $_val[2] ){

$_SESSION['userroom'] = 'pl';
$db->update( SQL_PREFIX.'players', Array( 'Room' => 'pl', 'ChatRoom' => 'pl' ), Array( 'Username' => $player->username ) );
die('<script> top.Room = "pl"; top.frames["ONLINE"].reload();</script>');

}
}


if ( @$_val[1] == 'L' ) {
if ( $player->Level < $_val[2] ){

$_SESSION['userroom'] = 'newby';
$db->update( SQL_PREFIX.'players', Array( 'Room' => 'main', 'ChatRoom' => 'newby' ), Array( 'Username' => $player->username ) );
die('<script> top.Room = "newby"; top.frames["ONLINE"].reload();</script>');

}
}


} else { die('Ошибка ввода данных. Комнаты '.$player->ChatRoom.' не существует.');  }
}



if( $db->numrows("SELECT Username FROM ".SQL_PREFIX."stopped WHERE Username = '$player->username'") ){ $no = 1; } else { $no = 0; }
if( $db->numrows("SELECT Username FROM ".SQL_PREFIX."inv WHERE Username = '$player->username'") ){     $nn = 1; } else { $nn = 0; }


$db->execQuery("INSERT INTO ".SQL_PREFIX."online (Username, Time, Room, ClanID, Level, Align, Stop, Inv, SId) VALUES ('$player->username', '".time()."', '$player->ChatRoom', '$player->id_clan', '$player->Level', '$player->Align', '$no', '$nn', '".$_SESSION['SId']."') ON DUPLICATE KEY UPDATE Time = '".time()."', Room = '$player->ChatRoom', Stop = '$no', Inv = '$nn', ClanID = '$player->id_clan', Align = '$player->Align'");

function dchat($Id, $name, $level, $align, $clan, $stopped, $trauma, $glava, $sex, $b_id ){
global $db_config, $db, $player;
$s      = '';
$rank   = 0;
$alpict = '';

if( $align < 10 ){
switch($align){
case 0: $alpict = '#5A5AA1'; break;
case 1: $alpict = '#D9A7A7'; break;
case 2: $alpict = '#A7D9A7'; break;
case 3: $alpict = '#A7D9D2'; break;
case 4: $alpict = '#5A5AA1'; break;
case 5: $alpict = '#5A5AA1'; break;
}

} else if( $clan > 0 ){

$rank = ($align - $clan*10);
$rank = ($rank > 0) ? $rank : 0;
$align = 0;

} else {

$align = 0;

}


$s .= '<a href="javascript:top.AddToPrivate(\''.$name.'\', true)"><img src="http://'.$db_config[DREAM_IMAGES]['server'].'/private.gif" border="0" title="Private" /></a>';

if( $clan > 0 ){
$s .= '<a href="http://'.$db_config[DREAM]['server'].'/top5.php?show='.$clan.'" target="_blank">';
$s .= '<img src="http://'.$db_config[DREAM_IMAGES]['server'].'/clan/'.$clan.'.gif" width="24px" height="15px" alt="" /></a>';
} else {
$s .= '<img src="http://'.$db_config[DREAM_IMAGES]['server'].'/1pix.gif" width="24px" height="15" alt="" />';
}

if( $align == 0 ){
if( !empty($glava) && $glava == 1 ){ $s .= '<a href="javascript:void(0);" onclick="top.AddTo(\''.$name.'\');"><u>'.$name.'</u></a>['.$level.']'; }
else{              $s .= '<a href="javascript:void(0);" onclick="top.AddTo(\''.$name.'\');">'.$name.'</a>['.$level.']';        }
} else {
$s .= '<a href="javascript:void(0)" onclick="top.AddTo(\''.$name.'\');"><font style="BACKGROUND-COLOR: '.$alpict.'">'.$name.'</font></a>['.$level.']';
}

if( $glava == 1 ){
$s .= '<a href="/inf.php?uname='.$name.'" target="_blank"><img src="http://'.$db_config[DREAM_IMAGES]['server'].'/inf'.$sex.'.gif" width="12px" height="12px" title="info '.$name.' [Clan`s Lider]" /></a>';
} else {
$s .= '<a href="/inf.php?uname='.$name.'" target="_blank"><img src="http://'.$db_config[DREAM_IMAGES]['server'].'/inf'.$sex.'.gif" width="12px" height="12px" title="info '.$name.'" /></a>';
}

if ($stopped == 1){ $s .= '&nbsp;<img src="http://'.$db_config[DREAM_IMAGES]['server'].'/jopa.gif" title="shut up" />'; }
if ($trauma == 1){  $s .= '&nbsp;<img src="http://'.$db_config[DREAM_IMAGES]['server'].'/tr.gif" title="travma" />'; }


	if( !empty($clan) && $clan != 99 && empty($b_id) && empty($player->battle_id) )
	{		if(
			$db->queryRow( "SELECT id_clan_from FROM ".SQL_PREFIX."clan_relations
							WHERE id_clan_from = '".$clan."' AND id_clan_to = '".$player->id_clan."' AND relation_type = 'WAR'" )
		   )
		   if(
		   		$db->queryRow( "SELECT id_clan_from FROM ".SQL_PREFIX."clan_relations
		   						WHERE id_clan_from = '".$player->id_clan."' AND id_clan_to = '".$clan."' AND relation_type = 'WAR'" )
             )
           		$s .= '&nbsp;<img src="http://'.$db_config[DREAM_IMAGES]['server'].'/turnir/war.gif" style="cursor:pointer" onclick="top.frames[\'CHAT_RELOADED\'].do_it(\''.$Id.'\')" title="Нападение на врага" />';

	}


$s .= '<br />';

return $s;
}


$cnt_o = 0;
$cnt   = 0;

//$spisok  = $db->queryArray("SELECT o.*, cu.admin FROM ".SQL_PREFIX."online as o INNER JOIN ".SQL_PREFIX."clan_user as cu ON(cu.Username = o.Username) INNER JOIN ".SQL_PREFIX."players as p ON(o.Username = p.Username) WHERE o.Room = '$player->ChatRoom' AND ( (p.Reg_IP != '".iconv("UTF-8", "WINDOWS-1251", 'бот')."' AND p.ClanID != '99') OR p.Username = '".iconv("UTF-8", "WINDOWS-1251", 'ЛамоБот')."' OR p.Username = '".iconv("UTF-8", "WINDOWS-1251", 'Тренер')."' ) ORDER BY o.ClanID DESC, o.Username DESC");

$admins_clans = '1, 2, 3, 4, 50, 53, 55, 255';
/*
$spisok  = $db->queryArray("
							(SELECT p.Id, o.*, p.Sex, cu.admin, p.BattleID FROM ".SQL_PREFIX."online as o LEFT OUTER JOIN ".SQL_PREFIX."clan_user as cu ON(cu.Username = o.Username) INNER JOIN ".SQL_PREFIX."players as p ON(o.Username = p.Username) WHERE p.ClanID IN (".$admins_clans.")  ORDER BY o.ClanID ASC, o.Username DESC LIMIT 100)
							UNION
							(SELECT p.Id, o.*, p.Sex, cu.admin, p.BattleID FROM ".SQL_PREFIX."online as o LEFT OUTER JOIN ".SQL_PREFIX."clan_user as cu ON(cu.Username = o.Username) INNER JOIN ".SQL_PREFIX."players as p ON(o.Username = p.Username) WHERE (( (p.Reg_IP != 'бот' AND p.ClanID != '99') OR p.Username = 'ЛамоБот' OR p.Username = 'Тренер' )) AND p.ClanID NOT IN ( ".$admins_clans." ) ORDER BY o.ClanID DESC, o.Username DESC LIMIT 100)

							");
 */

$spisok  = $db->queryArray("SELECT o.*, p.Sex, cu.admin FROM ".SQL_PREFIX."online as o LEFT OUTER JOIN ".SQL_PREFIX."clan_user as cu ON(cu.Username = o.Username) INNER JOIN ".SQL_PREFIX."players as p ON(o.Username = p.Username) WHERE ( (p.Reg_IP != '".iconv("UTF-8", "WINDOWS-1251", 'бот')."' AND p.ClanID != '99') OR p.Username = '".iconv("UTF-8", "WINDOWS-1251", 'ЛамоБот')."' OR p.Username = '".iconv("UTF-8", "WINDOWS-1251", 'Тренер')."' ) ORDER BY o.ClanID DESC, o.Username DESC");


$cnt_o = $db->SQL_result($db->query("SELECT COUNT( o.Username ) FROM ".SQL_PREFIX."online as o INNER JOIN ".SQL_PREFIX."players as p ON(p.Username = o.Username) WHERE o.Room = '$player->ChatRoom' AND ( (p.Reg_IP != 'бот' AND p.ClanID != '99') OR p.Username = 'ЛамоБот' OR p.Username = 'Тренер' )"),0);
$cnt   = $db->SQL_result($db->query("SELECT COUNT( o.Username ) FROM ".SQL_PREFIX."online as o INNER JOIN ".SQL_PREFIX."players as p ON(p.Username = o.Username) WHERE (p.Reg_IP != 'бот' AND p.ClanID != '99') OR p.Username = 'ЛамоБот' OR p.Username = 'Тренер'"),0);


function okon4 ($number, $titles){
$cases = array (2, 0, 1, 1, 1, 2);
return $number.' '.$titles[ ($number%100>4 && $number%100<20)? 2 : $cases[min($number%10, 5)] ];
}


$online = '';
if(!empty($spisok)):
 foreach($spisok as $v):
  $online .= dchat($v['Id'], $v['Username'], $v['Level'], $v['Align'], $v['ClanID'], $v['Stop'], $v['Inv'], $v['admin'], $v['Sex'], $v['BattleID']);
 endforeach;
endif;


$arr = array(
  'txt' => $_val[0].' ('.$cnt_o.')<br />всего '.okon4($cnt, array('игрок', 'игрока', 'игроков')),
  'txt_online' => $online
);

echo php2js( $arr );
?>