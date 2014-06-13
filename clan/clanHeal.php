<?php
require_once ('classes/Clan/ClanHeal.php');
require_once ('classes/Old/OldUserAdmin.php');

$User      =& new OldUserAdmin( '', '', $User );
$action    = $_POST['action'];
$userWater = intval($_POST['userwater']);

if( isset($action) && !empty($action) ){
$cHeal = new ClanHeal($User->id_clan, $User->username, $User->id_rank );
}


if($action == 'LIOT'){

if( is_numeric($userWater) == false ){ $msgError = 'А можно вводить только цифры!'; }
elseif( $userWater < 1 ){ $msgError = 'Отсыпь побольше! У тебя их '.$cHeal->hpNow.'HP'; }
elseif( $cHeal->hpNow < $userWater ){ $msgError = 'Маловато жизнненой силы для того чтобы делиться.'.$cHeal->hpNow.'HP'; }
elseif( ($cHeal->currentSize + $cHeal->convertUserHp($userWater)) > $cHeal->maxSize  ){ $msgError = 'Ваша поилка слишком мала для такого количества жизненной силы.'; }
else{

$cHeal->userLiot($userWater);
$msgError = 'Вы успешно поделились жизненной силой с кланом.';

}


} elseif ( $action == 'PIOT' ){

if (is_numeric($userWater)== false) { $msgError = 'А можно вводить только цифры!'; }
elseif( $userWater < 1 ){ $msgError = 'Бери, нежалей! Там аж '.$cHeal->currentSize.'HP"'; }
elseif ($cHeal->currentSize < $userWater) { $msgError = 'В вашей поилке нету столько жизненной силы.'; }
elseif (($cHeal->hpNow+$userWater) > $cHeal->hpAll){ $msgError = 'Не надо пытаться выпить больше чем в вас влезет.'; }
else{

$cHeal->userPiot($userWater);
$msgError = 'Вы успешно наполнились жизненной силой от клана.';

}

}

$poilkaInfo = ClanHeal::getPoilkaInfo( $User->id_clan, $_SESSION['login'] );
$tow_tpl->assignGlobal( 'poilkaInfo', $poilkaInfo );
?>
