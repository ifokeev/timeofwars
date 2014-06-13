<?
if( list($ip) = $db->queryCheck("SELECT Ip FROM `".SQL_PREFIX."ip` WHERE Username = '$player->username'") ){ $LastIP = $ip; }

if (!empty($_POST['TRANSFER_CR']) && !empty($_POST['TRANSFERSUM']) && !empty($_POST['CRRECIVIER']) ) {

if($woodc){ $err = 'Вы слишком заняты поиском трав'; }
elseif($turnir_id){ $err = 'Вы слишком заняты турниром.'; }
else{

@$_POST['TRANSFERSUM'] = floatval($_POST['TRANSFERSUM']);

if($_POST["TRRULE1"] != '1'){ $err = 'Необходимо согласиться с условиями блокировки и поставить галочку'; }
elseif( trim(strtolower($_POST['CRRECIVIER'])) == strtolower($player->username) ){ $err = 'Оригинально =)'; }
elseif($player->Level < 5){ $err = 'Передачи доступны только с 5-го уровня'; }
elseif( !list($to, $to_money, $level_to) = $db->queryCheck("SELECT Username, Money, Level FROM ".SQL_PREFIX."players WHERE Username = '".speek_to_view($_POST['CRRECIVIER'])."'") ){ $err = 'Игрока с данным логином не существует'; }
elseif($_POST['TRANSFERSUM'] < '0.01'){ $err = 'Минимальная сумма для передачи - 0.01 кр'; }
elseif($_POST['TRANSFERSUM'] > $player->Money){ $err = 'Вы не имеете достаточной суммы'; }
elseif($level_to < 3 && $player->clanid != 255 && $player->clanid != 50){ $err = 'Вы не можете передать что-либо к персонажам младше 3-го уровня'; }
elseif($player->clanid == 200){ $err = 'Нельзя ничего передавать, если на Вас проклятие'; }
else{

if ( list($ip) = $db->queryCheck("SELECT Ip FROM `".SQL_PREFIX."ip` WHERE Username = '$to'") ){  $targetip = $ip; }
$multstr1 = ''; $multstr2 = '';

if ($targetip == $LastIP){ $multstr1 = '<font color="red">'; $multstr2 = '</font>'; }

if (is_numeric($_POST['TRANSFERSUM'])) {

@$_POST['TRANSFERSUM'] = floatval($_POST['TRANSFERSUM']);
@$_POST['CMNT'] = speek_to_view($_POST['CMNT']);

$player->Money = round($player->Money,2);
$to_money = round($to_money,2);

$player->Money -= $_POST['TRANSFERSUM'];
$to_money += $_POST['TRANSFERSUM'];

$player->Money = round($player->Money,2);
$to_money = round($to_money,2);

$db->update( SQL_PREFIX.'players', Array( 'Money' => $player->Money ), Array( 'Username' => $player->username ) );
$db->update( SQL_PREFIX.'players', Array( 'Money' => $to_money ), Array( 'Username' => $to ) );

$db->insert( SQL_PREFIX.'transfer', Array( 'Date' => date('Y-m-d'), 'From' => $player->username, 'To' => $to, 'What' => $multstr1.$_POST['TRANSFERSUM'].' кредитов с пояснением: '.$_POST['CMNT'].' ('.date('H:i').')'.$multstr2 ) );
$db->insert( SQL_PREFIX.'messages', Array( 'Username' => $to, 'Text' => '<b> '.$player->username.' </b> передал вам <b> '.$_POST['TRANSFERSUM'].' кр. </b> c пояснением: '.$_POST['CMNT'] ) );

$err = 'Удачно передано '.$_POST['TRANSFERSUM'].' кр к '.$to;

}else{
$db->insert( SQL_PREFIX.'transfer', Array( 'Date' => date('Y-m-d'), 'From' => $player->username, 'To' => $_POST['CRRECIVIER'], 'What' => 'Попытка передачи неправельного значения с целью взлома. Значение <i>'.$_POST['TRANSFERSUM'].'</i> кредитов ('.date('H:i').')' ) );
$err = 'Попытка обмана игры сохранена в логах';
}

}


//проверка на лес
}
//конец
}
?>
