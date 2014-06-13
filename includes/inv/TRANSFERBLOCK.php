<?
if(!empty($_POST['TRANSFERBLOCK'])){

if($woodc){ $err = 'Вы слишком заняты поиском трав'; }
elseif($turnir_id){ $err = 'Вы слишком заняты турниром.'; }
else{

if(empty($_POST['BLOCKTIME'])){ $err = 'Необходимо выбрать время на которое нужно блокировать передачи'; }
elseif($_POST['TRBLOCKOK'] != '1'){ $err = 'Необходимо согласиться с условиями блокировки и поставить галочку'; }
else{

$db->execQuery("INSERT INTO `".SQL_PREFIX."lock` VALUES ('$player->username', '".(time()+$_POST['BLOCKTIME'])."') ON DUPLICATE KEY UPDATE locktime = '".(time()+$_POST['BLOCKTIME'])."'");
$err = 'Заблокировано успешно.';

}


//проверка на лес
}

//конец
}
?>
