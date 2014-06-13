<?
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

session_start();
if (empty($_SESSION['login'])) { include_once('includes/bag_log_in.php'); exit; }
//header( 'Content-type: text/html; charset=windows-1251;' );
include_once ('includes/to_view.php');
include_once ('db_config.php');
include_once ('db.php');
include_once ('classes/ChatSendMessages.php');

include_once ('classes/PlayerInfo.php');
include_once ('includes/turnir/func.php');

$player = new PlayerInfo();

$player->is_blocked();
$player->checkBattle();
$player->checkRoom('turnir');


//$player->heal();

$un_w = false;

$err = '';

$turnir_id = @$db->SQL_result($db->query( "SELECT turnir_id FROM ".SQL_PREFIX."turnir_users WHERE user = '".$player->username."';"),0);

function wear($id){
global $db, $turnir_id, $player;

$item = $player->getItemsInfo( $player->username );

if( $turnir_id ){ $err = 'Нельзя что-либо одеть, находясь в заявке на турнир.'; }
elseif ( !$thing = $db->fetch_array("SELECT Un_Id, Clan_need, Slot, Stre_add, Agil_add, Intu_add, Endu_add, Level_add, Id, Thing_Name, Wear_ON FROM ".SQL_PREFIX."things WHERE Owner = '$player->username' AND Un_Id = '".$id."' AND Wear_ON = '0';") ) { $err = 'Одна из вещей не найдена'; }
else
{

switch( $thing['Slot'] )
{	case 0:  $SlotXX = 'empt0';   $emptXX = $item['Slot'][0];  break;
	case 1:  $SlotXX = 'empt1';   $emptXX = $item['Slot'][1];  break;
	case 2:  $SlotXX = 'empt2';   $emptXX = $item['Slot'][2];  break;
	case 3:  $SlotXX = 'empt3';   $emptXX = $item['Slot'][3];  break;
	case 4:  $SlotXX = 'empt4';   $emptXX = $item['Slot'][4];  break;
	case 5:  $SlotXX = 'empt5';   $emptXX = $item['Slot'][5];  break;
	case 6:  $SlotXX = 'empt6';   $emptXX = $item['Slot'][6];  break;
	case 7:  $SlotXX = 'empt7';   $emptXX = $item['Slot'][7];  break;
	case 8:  $SlotXX = 'empt8';   $emptXX = $item['Slot'][8];  break;
	case 9:  $SlotXX = 'empt9';   $emptXX = $item['Slot'][9];  break;
	case 10: $SlotXX = 'empt10';  $emptXX = $item['Slot'][10]; break;
}


if ($thing['Slot'] == 4 && ($item['Slot'][4] == 'empt4' || $item['Slot'][5] == 'empt5' || $item['Slot'][6] == 'empt6') )
{	$slot_456 = array( 'Wear_ON' => 1 );

	if ($item['Slot'][6] == 'empt6') { $slot_456['Slot'] = 6; }
	if ($item['Slot'][5] == 'empt5') { $slot_456['Slot'] = 5; }
	if ($item['Slot'][4] == 'empt4') { $slot_456['Slot'] = 4; }

	$db->update( SQL_PREFIX.'things', $slot_456, Array( 'Owner' => $player->username, 'Un_Id' => $id ) );
}



if ($thing['Slot'] == 4 && $item['Slot'][4] != 'empt4' && $item['Slot'][5] != 'empt5' && $item['Slot'][6] != 'empt6')
{	$ring_on = $db->queryRow("SELECT Stre_add, Intu_add, Agil_add, Endu_add, Level_add FROM ".SQL_PREFIX."things WHERE Owner = '$player->username' AND Wear_ON = '1' AND Slot = '4'");

	$slot_456 = Array();

	if ($player->HPnow > ($player->HPall - $ring_on['Endu_add']) )
	{
                             $slot_456['HPnow'] = ($player->HPall - $ring_on['Endu_add']);
    }

    if ($ring_on['Stre_add']) {  $slot_456['Stre'] = '[-]'.$ring_on['Stre_add'];     }
    if ($ring_on['Agil_add']) {  $slot_456['Agil'] = '[-]'.$ring_on['Agil_add'];     }
    if ($ring_on['Intu_add']) {  $slot_456['Intu'] = '[-]'.$ring_on['Intu_add'];     }
    if ($ring_on['Endu_add']) {  $slot_456['HPall'] = '[-]'.$ring_on['Endu_add'];    }
    if ($ring_on['Level_add']) { $slot_456['Level'] = '[-]'.$ring_on['Level_add'];   }

    if( !empty($slot_456) )
    {    	$db->update( SQL_PREFIX.'players', $slot_456, Array( 'Username' => $player->username ), 'maths' );
    }

    $db->update( SQL_PREFIX.'things', Array( 'Wear_ON' => '0' ), Array( 'Owner' => $player->username, 'Wear_ON' => '1', 'Slot' => 4 ) );
    $db->update( SQL_PREFIX.'things', Array( 'Wear_ON' => '1', 'Slot' => 4 ), Array( 'Owner' => $player->username, 'Un_Id' => $id ) );
}


if ($SlotXX != $emptXX && $thing['Slot'] != 4)
{	$t_on = $db->queryRow("SELECT Un_Id, Stre_add, Agil_add, Intu_add, Endu_add, Level_add, Slot FROM ".SQL_PREFIX."things WHERE Owner = '$player->username' AND Id = '$emptXX' AND Wear_ON = '1' AND (Slot != '4' OR Slot != '5' OR Slot != '6')");

	$slot_456 = Array();

	if ($player->HPnow > ($player->HPall - $t_on['Endu_add']) )
	{	                      $slot_456['HPnow'] = ($player->HPall - $t_on['Endu_add']);
	}

	if ($t_on['Stre_add']) {  $slot_456['Stre'] = '[-]'.$t_on['Stre_add'];     }
	if ($t_on['Agil_add']) {  $slot_456['Agil'] = '[-]'.$t_on['Agil_add'];     }
	if ($t_on['Intu_add']) {  $slot_456['Intu'] = '[-]'.$t_on['Intu_add'];     }
	if ($t_on['Endu_add']) {  $slot_456['HPall'] = '[-]'.$t_on['Endu_add'];    }
	if ($t_on['Level_add']) { $slot_456['Level'] = '[-]'.$t_on['Level_add'];   }

	if( !empty($slot_456) )
	{		$db->update( SQL_PREFIX.'players', $slot_456, Array( 'Username' => $player->username ), 'maths' );
	}

	$db->update( SQL_PREFIX.'things', Array( 'Wear_ON' => '0' ), Array( 'Owner' => $this->username, 'Un_Id' => $t_on['Un_Id'], 'Wear_ON' => '1' ) );
}


$upd = Array();

if ($thing['Stre_add']) {  $upd['Stre'] = '[+]'.$thing['Stre_add'];     }
if ($thing['Agil_add']) {  $upd['Agil'] = '[+]'.$thing['Agil_add'];     }
if ($thing['Intu_add']) {  $upd['Intu'] = '[+]'.$thing['Intu_add'];     }
if ($thing['Endu_add']) {  $upd['HPall'] = '[+]'.$thing['Endu_add'];    }
if ($thing['Level_add']) { $upd['Level'] = '[+]'.$thing['Level_add'];   }

if( !empty($upd) )
{	$db->update( SQL_PREFIX.'players', $upd, Array( 'Username' => $player->username ), 'maths' );
}
$db->update( SQL_PREFIX.'things', Array( 'Wear_ON' => '1' ), Array( 'Owner' => $player->username, 'Un_Id' => $id ) );



if( $player->HPnow > $player->HPall ){ $db->execQuery("UPDATE ".SQL_PREFIX."players SET HPnow = HPall WHERE Username = '$player->username' LIMIT 1"); }


}


}


/*
if($player->username == 's!.')
{	$data = $db->queryArray("SELECT * FROM ".SQL_PREFIX."things_komplekt_turnir");
	if( !empty($data) )
	{		foreach( $data as $v )
		{			echo $v['Username'] . ' - '. $v['slot_thing'].'<br />';
        }
    }
}
*/




if( !empty($_GET['complect']) && $_GET['complect'] == 'load' && !@$db->SQL_result($db->query( "SELECT turnir_id FROM ".SQL_PREFIX."turnir_users WHERE user = '".$player->username."';"),0) ){
$slot_th = @$db->SQL_result($db->query("SELECT slot_thing FROM ".SQL_PREFIX."things_komplekt_turnir WHERE Username = '".$player->username."'"),0,0);
$slot    = explode( ';', $slot_th );

if( !empty($slot) )
{	foreach( $slot as $sl )
	{		if( !empty($sl) )
		{			$msg = wear( $sl );
        }
    }

    if( !empty($msg) )
    {    	$err = $msg;
    }
    else
    {    	$db->execQuery( "DELETE FROM ".SQL_PREFIX."things_komplekt_turnir WHERE Username = '".$player->username."';" );
    	$err = 'Комплект одет.<br />Чтобы принять участие в турнире, необходимо <a href="?undress=all">снять все вещи.</a> Ну или <a href="?goto=land">вернуться.</a>';
    	$un_w = true;
    	$slot_th = '';
    }

}

}


$item = $player->getItemsInfo( $player->username );

for( $i = 0; $i < 11; $i++ ){
if( $item['Slot'][$i] != 'empt'.$i )
{	$un_w = true;}
}

$row = '';

if( !empty($_GET['undress']) && $_GET['undress'] == 'all' ){

$row =
$item['Slot_id'][0].';'.$item['Slot_id'][1].';'.$item['Slot_id'][2].';'.$item['Slot_id'][3].';'.$item['Slot_id'][4].';'.
$item['Slot_id'][5].';'.$item['Slot_id'][6].';'.$item['Slot_id'][7].';'.$item['Slot_id'][8].';'.$item['Slot_id'][9].';'.
$item['Slot_id'][10].';';

for( $i = 0; $i < 11; $i++ ){

if( $item['Slot'][$i] != 'empt'.$i )
{
	$player->unwear( $item['Slot_id'][$i] );
}

}

if( $row != '0;0;0;0;0;0;0;0;0;0;0;' )
{	$db->execQuery("INSERT INTO `".SQL_PREFIX."things_komplekt_turnir` (Username, slot_thing) VALUES ('".$player->username."', '".$row."') ON DUPLICATE KEY UPDATE slot_thing = '".$row."'");
	$err = 'Все вещи сняты. Комплект сохранен. Выйти отсюда, не одев комплект, нельзя.';
	$slot_th = true;
	$un_w = false;
	$_GET['undress'] = false;
}

}



$turnir = $db->queryRow( "SELECT t.id, t.date, t.wait, t.creator, t.stavka FROM ".SQL_PREFIX."turnir as t INNER JOIN ".SQL_PREFIX."turnir_users as tu ON ( t.id = tu.turnir_id ) WHERE tu.user = '".$player->username."' AND t.status = '1';" );

if( !empty($_GET['goto']) && $_GET['goto'] == 'land' ){
if( $turnir ){ $err = 'Вы подали заявку на участие в турнире. Нельзя уйти.'; }
elseif( !empty($slot_th) ){ $err = 'Нельзя уйти, не одев комплект.'; }
else{ $player->gotoRoom( 'land', 'land' ); }
}

if( $turnir )
{	if( $turnir['date']+$turnir['wait']-time() <= 0 )
	{		if(  ($cnt_us = count( $users = $db->queryArray( "SELECT tu.user, p.Level, p.Stre, p.Agil, p.Intu, p.Endu, p.Intl, p.HPall, p.Ups FROM ".SQL_PREFIX."turnir as t INNER JOIN ".SQL_PREFIX."turnir_users as tu ON ( t.id = tu.turnir_id ) INNER JOIN ".SQL_PREFIX."players as p ON( p.Username = tu.user ) WHERE t.id = '".$turnir['id']."' AND t.status = '1';" ) )) > 1 )
		{			if( !empty($users) )
			{				$all_levels = 0;				foreach( $users as $us )
				{					$all_levels += $us['Level'];					$db->update( SQL_PREFIX.'players', Array( 'Room' => 'turnir_map', 'ChatRoom' => 'turnir_map' ), Array( 'Username' => $us['user'] ) );
					$db->update( SQL_PREFIX.'turnir_users', Array( 'do_level' => $us['Level'], 'do_stre' => $us['Stre'], 'do_agil' => $us['Agil'], 'do_intu' => $us['Intu'], 'do_endu' => $us['Endu'], 'do_intl' => $us['Intl'], 'do_hpall' => $us['HPall'], 'do_ups' => $us['Ups']  ), Array( 'user' => $us['user'] ) );
				}

				$middle_lvl = round($all_levels/$cnt_us);

				if( !file_exists( $db_config[DREAM]['web_root'] . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'turnir' . DIRECTORY_SEPARATOR . 'middle_lvl_'.$turnir['id'].'.dat' ) )
				{
				    file_put_contents(
	                 $db_config[DREAM]['web_root'] . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'turnir' . DIRECTORY_SEPARATOR . 'middle_lvl_'.$turnir['id'].'.dat',
	                 $middle_lvl
	                );

				   if( $db->update( SQL_PREFIX.'turnir', Array( 'status' => '2' ), Array( 'id' => $turnir['id'] ) ) )
				   {					   turnir_log( $turnir['id'], 'В '.date('H:i:s').' турнир <b>стартовал.</b> Всем участникам даны характеристики <b>'.$middle_lvl.' уровня.</b>' );
					   turnir_msg( 'Турнир №'.$turnir['id'].' <b>начался.</b> Всем участникам даны характеристики <b>'.$middle_lvl.' уровня.</b>' );
	               }

	            }
	        }
        }
        else
        {        	list( $user, ) = explode( ';', $turnir['creator'] );
            $db->update( SQL_PREFIX.'players', Array( 'Money' => '[+]'.$turnir['stavka'] ), Array( 'Username' => $user ), 'maths' );        	$db->execQuery( "DELETE FROM ".SQL_PREFIX."turnir WHERE id = '".$turnir['id']."';" );
        	$db->execQuery( "DELETE FROM ".SQL_PREFIX."turnir_users WHERE turnir_id = '".$turnir['id']."';" );
        	turnir_log( $turnir['id'], 'В '.date('H:i:s').' турнир <b>закончился</b> из-за нехватки участников.' );
            turnir_msg( 'Турнир №'.$turnir['id'].' не состоялся из-за отсутствия участников. Обидно, однако...' );

        }

    }
}


if( $db->numrows( "SELECT t.status FROM ".SQL_PREFIX."turnir as t INNER JOIN ".SQL_PREFIX."turnir_users as tu ON ( t.id = tu.turnir_id ) WHERE tu.user = '".$player->username."' AND t.status = '2';" ) )
{
	header( 'Location: turnir_map.php' );
	die;
}

require_once('_loader.php');

$tow_tpl->assignGlobal('db_config', $db_config);

$temp = & $tow_tpl->getDisplay('content', true);


$temp->assign( 'err',  $err  );
$temp->assign( 'slot_th',  @$db->SQL_result($db->query("SELECT slot_thing FROM ".SQL_PREFIX."things_komplekt_turnir WHERE Username = '".$player->username."'"),0,0)  );
$temp->assign( 'turnir_id',  @$db->SQL_result($db->query( "SELECT turnir_id FROM ".SQL_PREFIX."turnir_users WHERE user = '".$player->username."';"),0)  );
$temp->assign( 'un_w', $un_w  );

$temp->addTemplate('port', 'timeofwars_loc_turnir.html');


$show = & $tow_tpl->getDisplay('index');


$show->assign('title', 'Time Of Wars - Сердце леса');
$show->assign('Content', $temp);


$show->addTemplate('header', 'header.html');
$show->addTemplate('index' , 'index.html' );
$show->addTemplate('footer', 'footer.html');


$tow_tpl->display();
?>