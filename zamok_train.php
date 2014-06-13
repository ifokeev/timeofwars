<?
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

session_start();
if (empty($_SESSION['login'])) { include_once('includes/bag_log_in.php'); exit; }

include_once ('includes/to_view.php');
include_once ('db_config.php');
include_once ('db.php');

include_once ('classes/PlayerInfo.php');

$player = new PlayerInfo();

$player->is_blocked();
$player->checkBattle();
$player->checkRoom('zamok_train');

$room = split( '__', $player->ChatRoom );

if( $room[0] != 'zamok_'.$player->clanid )
{	$player->gotoRoom( 'zamok', 'zamok' );	die('нас не наебешь :)');
}

if(!empty($_GET['goto']) && $_GET['goto'] == 'zamok' ){
$player->gotoRoom( 'zamok', $room[0] );
}

$player->heal();
$player->checklevelup();

$clan  = $db->queryRow("SELECT id_clan, title FROM ".SQL_PREFIX."clan WHERE id_clan = '".$player->clanid."'");
$err = '';

if( !empty($_SESSION['captcha_keystring']) && !empty($_POST['code']) )
{
	if( $_SESSION['captcha_keystring'] !=  $_POST['code'] )
	{
		$err = 'Код неверен. Попробуйте еще раз.';
    }
    else
    {


	if( !list($Username, $Level, $HPnow, $BattleID) = $db->queryCheck("SELECT players.Username, players.Level, players.HPnow, players.BattleID2 FROM ".SQL_PREFIX."players as players, ".SQL_PREFIX."online as online WHERE players.Username = 'Бот_".$player->clanid."' AND players.Username = online.Username") ){ $err = 'Такого персонажа не существует, либо он не находится в игре'; }
	elseif($HPnow <= 0){ $err = 'Персонаж слишком слаб'; }
	elseif($BattleID){ $err = 'Персонаж в бою'; }
	elseif($player->HPnow<=($player->HPall/2)){ $err = 'Вы слишком слабы. Восстановитесь.'; }
	else
	{

        $player->goBattle($Username);

		$db->update( SQL_PREFIX.'players', Array( 'Stre' => $player->Stre, 'Agil' => $player->Agil, 'Intu' => $player->Intu, 'Endu' => $player->Endu, 'HPall' => round($player->HPall*1.5), 'HPnow' => round($player->HPall*1.5), 'Level' => $player->Level ), Array( 'Username' => $Username ) );
		$db->update( SQL_PREFIX.'online', Array( 'Level' => $player->Level ), Array( 'Username' => $Username ) );

		$db->execQuery("DELETE FROM `".SQL_PREFIX."things` WHERE Owner = '".$Username."'");

		$thi = $db->queryArray("SELECT * FROM `".SQL_PREFIX."things` WHERE Owner = '$player->username' AND Wear_ON = '1'");
		if(!empty($thi))
		{
			foreach($thi as $th)
			{
				$db->insert( SQL_PREFIX.'things',
				Array(
				'Owner' => $Username, 'Id' => $th['Id'], 'Thing_Name' => $th['Thing_Name'],
				'Slot' => $th['Slot'], 'Cost' => $th['Cost'], 'Level_need' => $th['Level_need'], 'Stre_need' => $th['Stre_need'],
				'Agil_need' => $th['Agil_need'], 'Intu_need' => $th['Intu_need'], 'Endu_need' => $th['Endu_need'],
				'Clan_need' => $th['Clan_need'], 'Level_add' => $th['Level_add'],  'Stre_add' => $th['Stre_add'],
				'Agil_add' => $th['Agil_add'], 'Intu_add' => $th['Intu_add'], 'Endu_add' => $th['Endu_add'],
				'MINdamage' => $th['MINdamage'], 'MAXdamage' => $th['MAXdamage'], 'Crit' => $th['Crit'],
				'AntiCrit' => $th['AntiCrit'], 'Uv' => $th['Uv'], 'AntiUv' => $th['AntiUv'], 'Armor1' => $th['Armor1'],
				'Armor2' => $th['Armor2'], 'Armor3' => $th['Armor3'], 'Armor4' => $th['Armor4'], 'MagicID' => $th['MagicID'],
				'NOWwear' => $th['NOWwear'], 'MAXwear' => $th['MAXwear'], 'Wear_ON' => '1', 'Srab' => $th['Srab']
				));
				//$un_id_t++;

			}
		}

		@header( 'Location: battle2.php', 301 );

	}
    }
}

include('_loader.php');

$tow_tpl->assignGlobal('db_config', $db_config);

$temp = & $tow_tpl->getDisplay('content', true);

$temp->assign( 'level', $player->Level );
$temp->assign( 'clan',  $clan          );
$temp->assign( 'err',   $err           );

$temp->addTemplate('bot_train', 'timeofwars_loc_train_zamok.html');

$show = & $tow_tpl->getDisplay('index');


$show->assign('title', 'Time Of Wars - тренировка');
$show->assign('Content', $temp);


$show->addTemplate('header', 'header.html');
$show->addTemplate('index' , 'index.html' );
$show->addTemplate('footer', 'footer.html');


$tow_tpl->display();
?>