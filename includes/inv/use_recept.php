<?
if (!empty($_GET['use_recept'])) {

if($woodc){ $err = 'Вы слишком заняты поиском трав'; }
elseif($turnir_id){ $err = 'Вы слишком заняты турниром.'; }
else{

$rec = intval($_GET['use_recept']);

if( $id = @$db->SQL_result($db->query("SELECT Id FROM ".SQL_PREFIX."things WHERE Owner = '$player->username' AND Un_Id = '$rec' AND Slot = '16' AND Id LIKE '%recept_%'"),0) ){

switch($id){
case 'recept_1'; $_RECEPT['durman']    = 1; $_NAME['durman']    = _FOREST_durman;    $_NEW[0] = 'Эликсир силы';
                 $_RECEPT['devatisil'] = 2; $_NAME['devatisil'] = _FOREST_devatisil; $_NEW[1] = 'elix_sila';
                 $_RECEPT['muhomor']   = 2; $_NAME['muhomor']   = _FOREST_muhomor;   $_NEW[2] = 6;
                 $type = 'items';                                                    $_NEW[3] = 2;
                                                                                     $_NEW['slot'] = 16;
                                                                                     $_NEW['MagicID'] = 'Доп. возможности';
break;

case 'recept_2'; $_RECEPT['jen-shen']  = 1; $_NAME['jen-shen']  = _FOREST_jen-shen;  $_NEW[0] = 'Эликсир ловкости';
                 $_RECEPT['sumka']     = 1; $_NAME['sumka']     = _FOREST_sumka;     $_NEW[1] = 'elix_lovkost';
                 $_RECEPT['hmel']      = 1; $_NAME['hmel']      = _FOREST_hmel;      $_NEW[2] = 9;
                 $_RECEPT['maslenok']  = 3; $_NAME['maslenok']  = _FOREST_maslenok;  $_NEW[3] = 2;
                 $type = 'items';                                                    $_NEW['slot'] = 16;
                                                                                     $_NEW['MagicID'] = 'Доп. возможности';
break;

case 'recept_3'; $_RECEPT['muhomor']   = 3; $_NAME['muhomor']   = _FOREST_muhomor;   $_NEW[0] = 'Эликсир великого разума';
                 $_RECEPT['valer']     = 4; $_NAME['valer']     = _FOREST_valer;     $_NEW[1] = 'elix_intl';
                 $_RECEPT['mak']       = 5; $_NAME['mak']       = _FOREST_mak;       $_NEW[2] = 11;
                 $_RECEPT['durman']    = 6; $_NAME['durman']    = _FOREST_durman;    $_NEW[3] = 2;
                 $_RECEPT['opata']     = 3; $_NAME['opata']     = _FOREST_opata;     $_NEW['slot'] = 16;
                 $type = 'items';                                                    $_NEW['MagicID'] = 'Доп. возможности';
break;

case 'recept_4'; $_RECEPT['beluga']    = 1; $_NAME['beluga']    = 'Белуга';   $_NEW[0] = 'Вкусняшка '.round($player->Level*4).' хп.';
                 $_RECEPT['ersh']      = 1; $_NAME['ersh']      = 'Ёрш';      $_NEW[1] = 'elix_hertz';
                 $_RECEPT['karas']     = 1; $_NAME['karas']     = 'Карась';   $_NEW[3] = $player->Level;
                 $_RECEPT['lesh']      = 1; $_NAME['lesh']      = 'Лещ';      $_NEW[2] = 5;
                 $_RECEPT['okun']      = 1; $_NAME['okun']      = 'Окунь';    $_NEW['slot'] = 16;
                 $_RECEPT['plotva']    = 1; $_NAME['plotva']    = 'Плотва';   $_NEW['MagicID'] = 'Доп. возможности';
                 $type = 'fish';
break;

case 'recept_5'; $_RECEPT['beluga']    = 1; $_NAME['beluga']    = 'Белуга';   $_NEW[0] = 'Вкусняшка боевая '.round($player->Level*2).' хп.';
                 $_RECEPT['ersh']      = 1; $_NAME['ersh']      = 'Ёрш';      $_NEW[1] = 'elix_hertz';
                 $_RECEPT['karas']     = 1; $_NAME['karas']     = 'Карась';   $_NEW[3] = $player->Level;
                 $_RECEPT['lesh']      = 1; $_NAME['lesh']      = 'Лещ';      $_NEW[2] = 5;
                 $_RECEPT['okun']      = 1; $_NAME['okun']      = 'Окунь';    $_NEW['slot'] = 11;
                 $_RECEPT['plotva']    = 1; $_NAME['plotva']    = 'Плотва';   $_NEW['MagicID'] = 'Вкусняшка';
                 $type = 'fish';
break;
}

foreach($_RECEPT as $var => $num){
if( !$db->queryCheck("SELECT Id FROM ".SQL_PREFIX."things WHERE Id = '".$type."/$var' AND Count >= '$num' AND Owner = '$player->username'") ){ $msg[] = 'Недостаточное количество "'.$_NAME[$var].'". Необходимо '.$num.' шт.'; }
}

if(empty($msg)){

foreach($_RECEPT as $var => $num){
$db->execQuery("UPDATE ".SQL_PREFIX."things SET Count = Count - '$num' WHERE Id = '".$type."/$var' AND Count >= '$num' AND Owner = '$player->username'");
$db->execQuery("DELETE FROM ".SQL_PREFIX."things WHERE Id = '".$type."/$var' AND Count = '0'");
}

$db->insert( SQL_PREFIX.'things', Array( 'Owner' => $player->username, 'Id' => $_NEW[1], 'Thing_Name' => $_NEW[0], 'Cost' => $_NEW[2], 'Slot' => $_NEW['slot'], 'Level_need' => $_NEW[3], 'MagicID' => $_NEW['MagicID'], 'Srab' => 100 ) );
$err = 'Изготовлено.';
}

}


}
//проверка на лес

}
?>
