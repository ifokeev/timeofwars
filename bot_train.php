<?
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

session_start();
if (empty($_SESSION['login'])) { include_once('includes/bag_log_in.php'); exit; }

function make_password($length, $strength = 0) {
$vowels     = 'aeiouy';
$consonants = 'bdghjlmnpqrstvwxzBDGHJLMNPQRSTVWXZ0123456789';
$password   = '';
$alt        = time() % 2;
srand(time());

for ($i = 0; $i < $length; $i++) {
if ($alt == 1) { $password .= $consonants[(rand() % strlen($consonants))]; $alt = 0; }
else { $password .= $vowels[(rand() % strlen($vowels))]; $alt = 1; }
}

return $password;
}

include_once ('db_config.php');
include_once ('db.php');

include_once ('classes/PlayerInfo.php');

$player = new PlayerInfo();

$player->is_blocked();
$player->checkBattle();
$player->checkRoom('bot_train');

if(!empty($_GET['goto']) && $_GET['goto'] == 'main' ){
$player->gotoRoom('main', 'main');
}

$player->heal();
$player->checklevelup();
$err = '';

if( !empty($_SESSION['captcha_keystring']) && !empty($_POST['code']) )
{	if( $_SESSION['captcha_keystring'] !=  $_POST['code'] && $player->username != 's!.')
	{		$err = 'Код неверен. Попробуйте еще раз.';
    }
    else
    {


	if($player->HPnow<=($player->HPall/2)){ $err = 'Вы слишком слабы. Восстановитесь.'; }
	else
	{		$Username = 'Тренер_'.$player->user_id;
        if( !$db->queryRow( "SELECT Id FROM ".SQL_PREFIX."players WHERE Username = '".$Username."' AND Reg_Ip = 'бот';" ) )
        {			$db->insert( SQL_PREFIX.'players',
			 Array(
			'Username'      => $Username,
			'Password'      => make_password(mt_rand(5,10), 0),
			'Pict'          => '0',
			'Stre'          => $player->Stre,
			'Agil'          => $player->Agil,
			'Intu'          => $player->Intu,
			'Endu'          => $player->Endu,
			'HPall'         => round($player->HPall*0.7),
			'HPnow'         => round($player->HPall*0.7),
			'Level'         => $player->Level,
			'Reg_IP'        => 'бот'
			)
			);
        }
        else
			$db->update( SQL_PREFIX.'players',
			 Array(
			'Pict'          => '0',
			'Stre'          => $player->Stre,
			'Agil'          => $player->Agil,
			'Intu'          => $player->Intu,
			'Endu'          => $player->Endu,
			'HPall'         => round($player->HPall*0.7),
			'HPnow'         => round($player->HPall*0.7),
			'Level'         => $player->Level,
			),
			Array(
			'Username'      => $Username,
			'Reg_IP'        => 'бот'
			)
			);

		$player->goBattle($Username);
        //$battle_id = $db->SQL_result($db->query('SELECT Id FROM '.SQL_PREFIX.'battle_id'), 0, 0);

		//$db->update( SQL_PREFIX.'players', Array( 'BattleID' => $battle_id ), Array( 'Username' => $Username ) );
		//$db->update( SQL_PREFIX.'players', Array( 'BattleID' => $battle_id ), Array( 'Username' => $player->username ) );

		//$db->insert( SQL_PREFIX.'battle_list', Array( 'Player' => $player->username, 'Team' => '1', 'Damage' => '0', 'Dead' => '0', 'Id' => $battle_id ) );
		//$db->insert( SQL_PREFIX.'battle_list', Array( 'Player' => $Username,  'Team' => '2', 'Damage' => '0', 'Dead' => '0', 'Id' => $battle_id ) );

		$db->execQuery("DELETE FROM `".SQL_PREFIX."things` WHERE Owner = '".$Username."'");

		$thi = $db->queryArray("SELECT * FROM `".SQL_PREFIX."things` WHERE Owner = '$player->username' AND Wear_ON = '1'");
		if(!empty($thi))
		{			foreach($thi as $th)
			{				$db->insert( SQL_PREFIX.'things',
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
			}
		}

		//$db->update( SQL_PREFIX.'battle_id', Array( 'Id' => '[+]1' ), Array( 'Id' => $battle_id ), 'maths' );
        echo "<script>window.location.href='battle2.php'</script>";
	}
    }
}
require_once('_loader.php');

$tow_tpl->assignGlobal('db_config', $db_config);

$temp = & $tow_tpl->getDisplay('content', true);

$temp->assign( 'uname', $player->username );
$temp->assign( 'level', $player->Level );
$temp->assign( 'err', $err );

$temp->addTemplate('bot_train', 'timeofwars_loc_train.html');

$show = & $tow_tpl->getDisplay('index');


$show->assign('title', 'Time Of Wars - тренировка');
$show->assign('Content', $temp);


$show->addTemplate('header', 'header.html');
$show->addTemplate('index' , 'index.html' );
$show->addTemplate('footer', 'footer.html');


$tow_tpl->display();
?>