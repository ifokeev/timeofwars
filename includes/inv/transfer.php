<?
if (!empty($_GET['give']) && is_numeric($_GET['give']) && !empty($_GET['whom'])) {

if($woodc){ $err = 'Вы слишком заняты поиском трав'; }
elseif($turnir_id){ $err = 'Вы слишком заняты турниром.'; }
else{

list($locktime) = $db->queryCheck("SELECT locktime FROM `".SQL_PREFIX."lock` WHERE Username = '$player->username'");
if($locktime > time()){ $err = 'Вы заблокировали свои передачи сами. Извините ждите.'; }
else{

if(!empty($locktime) && (time() >= $locktime) ){ $db->execQuery("DELETE FROM `".SQL_PREFIX."lock` WHERE Username = '$player->username'"); }

@$whom_to         = speek_to_view($_GET['whom']);
@$_GET['give']    = intval($_GET['give']);
@$_GET['surtext'] = speek_to_view($_GET['surtext']);

if ( trim(strtolower($whom_to)) == strtolower($player->username) ) { $err = 'Оригинально =)'; }
elseif( !list($to, $level) = $db->queryCheck("SELECT Username, Level FROM ".SQL_PREFIX."players WHERE Username = '$whom_to'") ) { $err = 'Игрока с данным логином не существует';  }
elseif( !list($Thing_Name, $Un_Id) = $db->queryCheck("SELECT Thing_Name, Un_Id FROM ".SQL_PREFIX."things WHERE (Owner = '$player->username') AND (Un_Id = '{$_GET['give']}') AND (Slot < '50')") ){ $err = 'Вы не имеете данной вещи'; }
elseif($player->Money < 0.5){ $err = 'У Вас недостаточно кредитов для передачи'; }
elseif($level < 5 && $player->clanid != 255 && $player->clanid != 50) { $err = 'Вы не можете передать что-либо к персонажам младше 5-го уровня'; }
elseif($player->clanid == 200) { $err = 'Нельзя ничего передавать, если на Вас проклятие'; }
elseif (preg_match ('/именная/i', $Thing_Name) ) { $err = 'Именную вещь нельзя передать'; }
else {

if ( list($ip) = $db->queryCheck("SELECT Ip FROM `".SQL_PREFIX."ip` WHERE Username = '$whom_to' ") ) { $targetip = $ip; }

$multstr1 = ''; $multstr2 = '';

if ($targetip == $LastIP){ $multstr1 = '<font color="red">'; $multstr2 = '</font>'; }

$db->update( SQL_PREFIX.'players',  Array( 'Money' => '[-]0.5' ), Array( 'Username' => $player->username ), 'maths' );
$db->update( SQL_PREFIX.'things',   Array( 'Owner' => $whom_to ), Array( 'Un_Id' => $Un_Id ) );
$db->insert( SQL_PREFIX.'transfer', Array( 'Date' => date('Y-m-d'), 'From' => $player->username, 'To' => $whom_to, 'What' => $multstr1.'Предмет '.$Thing_Name.', уникальный ID '.$Un_Id.' ('.date('H:i').'). Пояснение к передаче: '.$_GET['surtext'].$multstr2 ) );
$db->insert( SQL_PREFIX.'messages', Array( 'Username' => $whom_to, 'Text' => '<b>'.$player->username.'</b> передал вам <b>'.$Thing_Name.'</b> с пояснением: '.$_GET['surtext'] ) );

$err = 'Удачно передан предмет к '.$whom_to;

}

}

//проверка на лес
}
//конец
}
?>
