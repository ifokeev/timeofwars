<?php
include_once ('../checker.php');

session_start();
checkSessionAuth();

$dbClassAdded = true;
require_once('../db_config.php');
require_once('db.php');
require_once('classes/Clan/ClanWeaponDemands.php');
require_once('classes/Clan/ClanWeaponItems.php');
require_once('classes/Old/OldUserAdmin.php');

$User = new OldUserAdmin( $_SESSION['login'], '', $emptyObj );


$action     = strtoupper($_REQUEST['action']);
$show       = strtoupper( isset($_REQUEST['show'])? $_REQUEST['show'] : 'WEAPON');
$id_item    = $_POST['id_item'];
$demandUser = $_POST['demandUser'];


$cwDemands	= new ClanWeaponDemands( $id_item );
$cwItems	= new ClanWeaponItems( $User->id_clan );


if( $action == 'CREATE_DEMAND' ){
	
if( $cwDemands->id_item < 1 ){ $msgError = 'Надо выбрать вещь.'; }
elseif( ($item=$cwItems->getItem( $cwDemands->id_item ))==false || empty($item) == true ){ $msgError = 'Вещь не найдена.'; }
elseif( ($demand=$cwDemands->getItemDemandByUsername( $User->username ))==true || empty($demand) == false ){ $msgError = 'Вы уже подали заявку на эту вещь.'; }
else{
		
$cwDemands->addItemDemand( $User->username );
$msgError = 'Заявка успешно подана.';

}
	
}elseif( $action == 'REMOVE_DEMAND' ){
	
if( $cwDemands->id_item < 1 ){ $msgError = 'Надо выбрать вещь.'; }
elseif( ($demand=$cwDemands->getItemDemandByUsername( $User->username ))==false || empty($demand) == true ){ $msgError = 'Вы не подавали заявку на эту вещь.'; }
else{
		
$cwDemands->delItemDemand( $User->username );
$msgError = 'Заявка успешно отозвана.';

}

}elseif( $action == 'ACCEPT_DEMAND' ){
	
if( $cwDemands->id_item < 1 ){ $msgError = 'Надо выбрать вещь.'; }
elseif( ($item=$cwItems->getItem( $cwDemands->id_item ))==false || empty($item) == true ){ $msgError = 'Вещь не найдена.'; }
elseif( $demandUser == '' || ($dUser = new OldUser($demandUser, ''))==false ){ $msgError = 'Персонаж не найден.'; }
elseif( $dUser->id_clan != $User->id_clan ){ $msgError = 'Персонаж не состоит в вашем клане.'; }
elseif( $User->hasAdminAbil("CLAN_MANAGE_WEAPONS") == false ){ $msgError = 'У вас нет прав доступа.'; }
else{
		
$cwDemands->setItemDemand( $dUser->username, 'ACCEPT' );
$msgError = 'Заявка успешно одобрена';

}

}elseif( $action == 'REJECT_DEMAND' ){
	
if( $cwDemands->id_item < 1 ){ $msgError = 'Надо выбрать вещь.'; }
elseif( ($item=$cwItems->getItem( $cwDemands->id_item ))==false || empty($item) == true ){ $msgError = 'Вещь не найдена.'; }
elseif( $demandUser == '' || ($dUser = new OldUser($demandUser, ''))==false ){ $msgError = 'Персонаж не найден.'; }
elseif( $dUser->id_clan != $User->id_clan ){ $msgError = 'Персонаж не состоит в вашем клане.'; }
elseif( $User->hasAdminAbil("CLAN_MANAGE_WEAPONS") == false ){ $msgError = 'У вас нет прав доступа.'; }
else{
		
$cwDemands->setItemDemand( $dUser->username, 'REJECT' );
$msgError = 'Заявка успешно отклонена';

}

}elseif( $action == 'ADD_ITEM' ){
	
if( $cwDemands->id_item < 1 ){ $msgError = 'Надо выбрать вещь.'; }
elseif( $User->hasAdminAbil('CLAN_MANAGE_WEAPONS') == false ){ $msgError = 'У вас нет прав доступа.'; }
else{
		
$cwItems->addClanWeaponItem( $cwDemands->id_item, $User->username );
$msgError = 'Вещь успешно добавлена в оружейную.';

}

}elseif( $action == 'DEL_ITEM' ){
	
if( $cwDemands->id_item < 1 ){ $msgError = 'Надо выбрать вещь.'; }
elseif( ($item=$cwItems->getItem( $cwDemands->id_item ))==false || empty($item) == true ){ $msgError = 'Вещь не найдена.'; }
elseif( $User->hasAdminAbil('CLAN_MANAGE_WEAPONS') == false ){ $msgError = 'У вас нет прав доступа.'; }
else{
		
$cwItems->delClanWeaponItem( $cwDemands->id_item, $User->username );
$msgError = 'Вещь успешно изъята из оружейной.';

}

}elseif( $action == 'GET_ITEM' ){
	
if( $cwDemands->id_item < 1 ){ $msgError = 'Надо выбрать вещь.'; }
elseif( ($item=$cwItems->getItem( $cwDemands->id_item ))==false || empty($item) == true ){ $msgError = 'Вещь не найдена.'; }
elseif( ($itemDemand = $cwDemands->getItemDemandByUsername( $User->username )) == false ){ $msgError = 'Заявка на вещь не найдена.'; }
elseif( $itemDemand['status'] != 'ACCEPT' ){ $msgError = 'Ваша заявка отклонена.'; }
else{
		
$cwItems->setItemOwner( $cwDemands->id_item, $User->username );
$msgError = 'Вещь успешно получена.';

}
	
}elseif( $action == 'SET_ITEM' ){
	
if( $cwDemands->id_item < 1 ){ $msgError = 'Надо выбрать вещь.'; }
elseif( ($item=$cwItems->getItem( $cwDemands->id_item ))==false || empty($item) == true ){ $msgError = 'Вещь не найдена.'; }
else{
		
$cwItems->setItemOwner( $cwDemands->id_item, '' );
$msgError = 'Вещь успешно сдана.';
}

}

$itemList = array();
$demandList = array();

if( $show == 'DEMANDS' ){ $demandList = $cwDemands->getItemDemandsList(); $isShowItemList = false; }
elseif( $show == 'BACKPACK' ){ $itemList = $cwItems->getUserBackpackItemList($User->username); $isShowItemList = true; }
else{
	
$itemList = $cwItems->getClanWeaponItemList( $User->username );
$isShowItemList = true;

}


$tpl->set( 'itemList', $itemList );
$tpl->set( 'demandList', $demandList );
$tpl->set( 'show', $show );
$tpl->set( 'userInfo', $User->getTepmlatePatterns() );
$tpl->set( 'id_item', $id_item );
$tpl->set( 'isManager', $User->hasAdminAbil('CLAN_MANAGE_WEAPONS') );
$tpl->set( 'isShowItemList', $isShowItemList );
$tpl->set( 'id_clan', $User->id_clan );
$tpl->set( 'msgError', $msgError );
$tpl->set( 'clanBody', $tpl->fetch('bodyClanWeapon.html') );
echo $tpl->fetch('pageClanBlank.html');
?>
