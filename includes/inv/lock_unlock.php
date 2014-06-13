<?
if(!empty($_GET['lock']) && is_numeric($_GET['lock']) ){

if($woodc){ $err = 'Вы слишком заняты поиском трав'; }
elseif($turnir_id){ $err = 'Вы слишком заняты турниром.'; }
else {

if( $data = $db->queryCheck("SELECT Un_Id, Slot FROM ".SQL_PREFIX."things WHERE Un_Id = '".intval($_GET['lock'])."' AND Wear_ON = '0' AND Owner = '$player->username'") ){
if( $data[1] != '15' ){

$db->execQuery("INSERT INTO ".SQL_PREFIX."things_lock SELECT * FROM ".SQL_PREFIX."things WHERE Un_Id = '$data[0]' AND Owner = '".$player->username."'") or die('Невозможно перенести.Обратитесь к администрации');
$db->execQuery("DELETE FROM ".SQL_PREFIX."things WHERE Un_Id = '$data[0]' AND Owner = '$player->username'");
$err = 'Предмет добавлен в рюкзак';

} else { $err = 'Этот предмет нельзя положить в рюкзак'; }
} else { exit; }

//проверка на лес
}

}



if(!empty($_GET['unlock']) && is_numeric($_GET['unlock']) ){

if($woodc){ $err = 'Вы слишком заняты поиском трав'; }
elseif($turnir_id){ $err = 'Вы слишком заняты турниром.'; }
else{

if( $id = $db->SQL_result($db->query("SELECT Un_Id FROM ".SQL_PREFIX."things_lock WHERE Un_Id = '".intval($_GET['unlock'])."' AND Wear_ON = '0' AND Owner = '$player->username'"),0,0) ){

$db->execQuery("INSERT INTO ".SQL_PREFIX."things SELECT * FROM ".SQL_PREFIX."things_lock WHERE Un_Id = '".$id."' AND Wear_ON = '0' AND Owner = '$player->username'") or die('Невозможно перенести.Обратитесь к администрации');
$db->execQuery("DELETE FROM ".SQL_PREFIX."things_lock WHERE Un_Id = '".$id."' AND Owner = '$player->username'");
$err = 'Предмет вынут из рюкзака';

} else { exit; }

//поверка на лес
}

}
?>
