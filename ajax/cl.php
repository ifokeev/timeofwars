<?php
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);
session_start();


header('Content-type: text/html; charset=windows-1251');

include_once ('../db_config.php');
include_once ('../db.php');
include_once ('../classes/PlayerInfo.php');
include_once ('../classes/ChatSendMessages.php');


$player = new PlayerInfo();


$err = '';

if( !empty($_POST['uname']) && !is_array($_POST['uname'])  ){
$uname = iconv('UTF-8', 'windows-1251', $_POST['uname']);
$uname = filter($uname);
}


if( !empty($_POST['item']) && !is_numeric($_POST['item']) ) die;


if( !empty($player->id_rank) ) $acclev = @split( ',', $db->SQL_result($db->query( "SELECT perms FROM ".SQL_PREFIX."clan_ranks WHERE id_clan = '".$player->id_clan."' AND id_rank = '".$player->id_rank."';" )) );


switch( $_POST['page'] )
{	case 'clan_demand':

	if( !empty($_POST['act']) && $_POST['act'] == 'new' )
	{		if( empty($_POST['id_clan']) || !is_numeric($_POST['id_clan']) ) die;
        elseif( !empty($_SESSION['lastacttime']) &&  time() - $_SESSION['lastacttime'] <= 10 ){ echo 'Запросы можно выполнять раз в 10 секунд.'; }
		elseif( $db->queryRow( "SELECT id_clan FROM ".SQL_PREFIX."clan_demands WHERE Username = '".$player->username."';" ) ){ echo 'Вы уже подали заявку в клан'; }
		else
		{
		$text = iconv('UTF-8', 'windows-1251', $_POST['text']);
		$text = preg_replace( '/[^a-zA-Z0-9\_\-\!.,]/', '', $text );		$query = sprintf("INSERT INTO ".SQL_PREFIX."clan_demands ( Username, id_clan, text ) VALUES ( '%s', '%d', '%s');", $player->username, intval($_POST['id_clan']), $text );
		$db->execQuery( $query, "cl_addClanDemand_1" );
		$_SESSION['lastacttime'] = time();
		echo 'Заявка добавлена';

		}
	}
	elseif( $_POST['act'] == 'del' )
	{
        if( !empty($_SESSION['lastacttime']) &&  time() - $_SESSION['lastacttime'] <= 10 ){ echo 'Запросы можно выполнять раз в 10 секунд.'; }
		elseif( !$db->queryRow( "SELECT id_clan FROM ".SQL_PREFIX."clan_demands WHERE Username = '".$player->username."';" ) ){ echo 'Вы не подавали заявок в клан'; }
		else
		{			$db->execQuery( "DELETE FROM ".SQL_PREFIX."clan_demands WHERE Username = '".$player->username."';" );
			$_SESSION['lastacttime'] = time();
			echo 'Заявка удалена';
		}
	}

	break;

	case 'request':
	include_once ($db_config[DREAM]['web_root'] . '/classes/Clan/ClanDemands.php');
    include_once ($db_config[DREAM]['web_root'] . '/includes/clan/ClanRequest.php');
	break;


	case 'align':
	include_once ($db_config[DREAM]['web_root'] . '/classes/Clan/ClanRelations.php');
    include_once ($db_config[DREAM]['web_root'] . '/includes/clan/ClanAlign.php');
	break;


	case 'rank';
    include_once ($db_config[DREAM]['web_root'] . '/includes/clan/ClanRank.php');
	break;


	case 'members':
    include_once ($db_config[DREAM]['web_root'] . '/includes/clan/ClanMembers.php');
	break;


	case 'setup':
	if( !empty($_POST['act']) && $_POST['act'] == 'update' )
	{
		$link = iconv('UTF-8', 'windows-1251', $_POST['link']);
		$slogan = iconv('UTF-8', 'windows-1251', $_POST['slogan']);
		$reklama = iconv('UTF-8', 'windows-1251', $_POST['reklama']);
		if( !filter_var($link, FILTER_VALIDATE_URL, FILTER_FLAG_SCHEME_REQUIRED)  ){ echo 'Неверный формат ссылки. Вписывайте c http://'; }
		elseif( preg_match('/[^a-z,A-Z,а-я,А-Я,\-,\,\.]/', $slogan) ){ echo 'Недопустимый дивиз'; }
		elseif( preg_match("/[^А-ЯA-Za-zа-я0-9 \!?,:.]/i", $reklama) ){ echo 'Некорректная реклама'; }
		else
		{
			$db->update( SQL_PREFIX.'clan', Array( 'link' => $link, 'slogan' => $slogan, 'advert' => $reklama ), Array( 'id_clan' => $player->id_clan ) );
			echo 'Обновлено';


		}
	}
	break;

	case 'kazna':
    include_once ($db_config[DREAM]['web_root'] . '/includes/clan/ClanSetup.php');
	break;


	case 'weapons':
	//require_once('../classes/Clan/ClanWeaponDemands.php');
	include_once ($db_config[DREAM]['web_root'] . '/classes/Clan/ClanWeaponItems.php');
    include_once ($db_config[DREAM]['web_root'] . '/includes/clan/ClanWeapons.php');
	break;



	case 'weapons_demands':
	include_once ($db_config[DREAM]['web_root'] . '/classes/Clan/ClanWeaponDemands.php');
	include_once ($db_config[DREAM]['web_root'] . '/classes/Clan/ClanWeaponItems.php');
    include_once ($db_config[DREAM]['web_root'] . '/includes/clan/ClanWeaponsDemands.php');
	break;

	case 'history':
    if( !empty($_POST['act']) && $_POST['act'] == 'dataload' )
	{		switch($_POST['slot'])
		{			case 1: $load = 'members'; break;
			case 2: $load = 'weapons'; break;
			case 3: $load = 'kazna';   break;
			case 4: $load = 'relations'; break;
			default: die('оооо генацвали'); break;
        }

			$data = $db->queryArray( "SELECT * FROM ".SQL_PREFIX."clan_history WHERE type = '".$load."' AND id_clan = '".$player->id_clan."' ORDER BY time DESC LIMIT 100;" );

			if( empty($data) ) die('Пусто');


			foreach( $data as $v )
			{				echo 'id: '.$v['id'].'.&nbsp;<a class="date">'.date( 'F j, Y, H:i', $v['time']).'</a> : '.$v['text'].' <br />';
			}

	}
	break;
}


if( !empty($err) ) echo $err;
?>