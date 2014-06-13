<?php
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);
session_start();


header('Content-type: text/html; charset=windows-1251');

include_once ('../db_config.php');
include_once ('../db.php');
include_once ('../classes/PlayerInfo.php');



$player = new PlayerInfo();
$player->is_blocked();

include_once ('../chat/func_chat.php');
include_once ('../includes/to_view.php');
include_once ('../classes/ChatSendMessages.php');


$_COOKIE['last_time_send'] = 0;
$adm = 0;
if( ($player->clanid > 0 && $player->clanid < 5 ) || $player->clanid == 53 || $player->clanid == 50|| $player->clanid == 255 || $player->username == 's!.' || $player->username == 'stasx' ){
$adm = 1;
}

$chat = new ChatSendMessages($player->username, $player->ChatRoom, $adm);


function refresh()
{
	global $chat, $player, $db_config;

$smile = Array(
'face1', 'face2', 'face3', 'face4', 'face5', 'fingal', 'evil', 'batman', 'adolf', 'am', 'angel', 'cool', 'coolman',
'crazy', 'devil', 'aplause', 'ha', 'help', 'happy', 'hello', 'ill', 'hummer2', 'music', 'newyear', 'ogo', 'police',
'police2', 'prise', 'punk', 'ravvin', 'ravvin2', 'rupor', 'scare', 'king', 'sleep', 'song', 'strong',
'student', 'goodnigth', 'fuu', 'girl', 'inlove', 'kiss1', 'lick', 'lips', 'two', 'pare', 'fuck', 'dinner', 'friday', 'drink', 'beer', 'cola', 'killed', 'throwout', 'boxing',
'duel', 'gun1', 'gun2', 'gun_1', 'hummer', 'jack', 'knut', 'matrix', 'med', 'ninja', 'nunchak', 't2', 'terminator',
'training', 'trio', 'user', 'censored', 'compkill', 'helloween', 'lock', 'lol', 'loo', 'mol', 'nuclear', 'yo',
'dollar', 'heart', 'luck', 'mac', 'win', 'rip', 'bye', 'baby', 'man_hat'
);


$chat->writePrivate();

$log = '';

$msg_live_time = $chat->GetMicroTime() - 900000000;

$msg = file($chat->room_file);

if( !empty($msg) )
{
	foreach ($msg as $v)
	{
		list($msg_time, $msg_text) = split('>>', $v);

		if ( $msg_time > $msg_live_time && $msg_time > $_COOKIE['last_time_send'] )
		{

			$msg_text = eregi_replace("[\n\r]", "", $msg_text);
			$msg_text = nl2br($msg_text);

			$msg_text = eregi_replace('<span>\[<font color="red">([^\]+)</font>\]</span>', '<span><font color="red">[\\1]</font></span>', $msg_text);
            $msg_text = eregi_replace('<span>\[<b style="color:red;">([^\]+)</b>\]</span>', '<span><b><font color="red">[\\1]</font></b></span>', $msg_text);

			$msg_text = eregi_replace('</a> <font size="2"> <span>\[([^\]+)\]</span>', '</a><font size="2"> [<span class="mes" onclick="a_click(\'\\1\', event);" oncontextmenu="return menu(\'\\1\',event);" id="login">\\1</span>]', $msg_text);

			foreach($smile as $sm){ if(strpos($msg_text, ':'.$sm.':')){ $msg_text = str_replace(':'.$sm.':', '<img border="0" src="http://'.$db_config[DREAM_IMAGES]['server'].'/smiles/'.$sm.'.gif">', $msg_text); } }

			if ( strpos($msg_text, 'private ['.$player->username.']') === false )
			{
				if ( strpos($msg_text, 'private [') === false )
				{
					if ( strpos($msg_text, 'to ['.$player->username.']') === false )
					$log .= $msg_text.'<br />';
					else
					{
						$msg_text = eregi_replace('<a class="date">', '<a class="date2">', $msg_text);
						$log .= $msg_text.'<br />';
					}
				}
				else
				{
					if ( strpos($msg_text, '>'.$player->username.'<') )
					{
						$msg_text = eregi_replace('private \[([^\]+)\]', '<a class="private">private [\\1]</a>', $msg_text);
						$msg_text = eregi_replace('<a class="date">', '<a class="date2">', $msg_text);
						$log .= $msg_text.'<br />';
					}
				}
			}
			else
			{
				$msg_text = eregi_replace('private \['.$player->username.'\]', '<a class="private">private ['.$player->username.']</a>', $msg_text);
				$msg_text = eregi_replace('<a class="date">', '<a class="date2">', $msg_text);
				$log .= $msg_text.'<br />';
			}

		}
	}

	return $log;

}
}


if( !empty($_POST['uname']) )
{
	$uname = iconv('UTF-8', 'windows-1251', $_POST['uname']);
    if( strlen($uname) > 15 ) die( 'Слишком длинно.' );

	if( (!empty($_SESSION['cneg_time']) && time() - $_SESSION['cneg_time'] >= 30) || empty($_SESSION['cneg_time']) )
	{
		if( $_name = $db->SQL_result( $db->query( "SELECT Username FROM ".SQL_PREFIX."players WHERE Username = '".speek_to_view($uname)."';" ),0) )
		{
			if( $player->Sex == 'F' ) $pr = 'а'; else $pr = '';

/*
			$text =
			Array(
			0 => '<b>'.$player->username.'</b> хитро попал'.$pr.' снежком прямо в лоб <b>'.$_name.'.</b>',
			1 => 'Оглянувшись, <b>'.$player->username.'</b> запульнул'.$pr.' снежок в <b>'.$_name.'.</b>',
			2 => 'Неожиданно <b>'.$player->username.'</b> запустил'.$pr.' снежком в <b>'.$_name.'.</b>',
			3 => 'Прицелившись, <b>'.$player->username.'</b> отправил'.$pr.' снежок прямо в темечко <b>'.$_name.'.</b>',
			4 => 'Присев, <b>'.$player->username.'</b> попал'.$pr.' снежком в ухо <b>'.$_name.'.</b>',
			5 => 'Неожидано <b>'.$player->username.'</b> толкнул'.$pr.' в снег <b>'.$_name.'.</b>',
			6 => 'Подбежав, <b>'.$player->username.'</b> окатил'.$pr.' снегом <b>'.$_name.'.</b>',
			7 => 'В прыжке <b>'.$player->username.'</b> повалил'.$pr.' в сугроб <b>'.$_name.'.</b>',
			8 => 'Не раздумывая, <b>'.$player->username.'</b> толкнул'.$pr.' в снег <b>'.$_name.'.</b>',
			);
*/

			$text =
			Array(
			0 => '<b>'.$player->username.'</b> послал'.$pr.' лучи добра <b>'.$_name.'.</b>',
			1 => '<b>'.$player->username.'</b> признал'.$pr.' свою аццкую любовь к <b>'.$_name.'.</b>',
			2 => '<b>'.$player->username.'</b> пригласил'.$pr.' <b>'.$_name.'</b> на свидание',
			3 => '<b>'.$player->username.'</b> расцеловал'.$pr.' в прыжке <b>'.$_name.'.</b>',
			4 => '<b>'.$player->username.'</b> утвердил'.$pr.' предложение <b>'.$_name.'</b> руки и сердца',
			5 => '<b>'.$player->username.'</b> чмокнул'.$pr.' <b>'.$_name.'</b> в пупок',
			6 => '<b>'.$player->username.'</b> сорвал'.$pr.' кактус с древа Дазрапермы для <b>'.$_name.'.</b>',
			7 => '<b>'.$player->username.'</b> уважил'.$pr.' родителей <b>'.$_name.'</b> веселой песенкой',
			8 => '<b>'.$player->username.'</b> станцевал'.$pr.' для <b>'.$_name.'</b> "яблочко"',
			9 => '<b>'.$player->username.'</b> научил'.$pr.' <b>'.$_name.'</b> какать бабочками',
			10 => '<b>'.$player->username.'</b> укусил'.$pr.' <b>'.$_name.'</b> за левую полупопицу',
			11 => '<b>'.$player->username.'</b> укусил'.$pr.' <b>'.$_name.'</b> за правую полупопицу',
			12 => '<b>'.$player->username.'</b> подарил'.$pr.' весеннюю неожиданность <b>'.$_name.'.</b>',
			13 => '<b>'.$player->username.'</b> улыбнул'.$pr.' <b>'.$_name.'</b> речью о <a href="http://'.$db_config[DREAM]['server'].'/inf.php?uname=Красный" target="_blank">Красном.</a>',
			14 => '<b>'.$player->username.'</b> крикнул'.$pr.' в пятку через ухо <b>'.$_name.'.</b>',
			15 => '<b>'.$player->username.'</b> скушал "настроение". Няяяяяяяя',
			16 => '<b>Бгаааааа</b>',
			17 => '<b>'.$player->username.'</b> Арам-зам-зам, арам-зам-зам, гули-гули-гули-гули гули зам-зам-зам!',
			17 => '<b>'.$player->username.'</b> крикнул'.$pr.': "Ляськи-масяськи ахалай-махалай" и растворил <b>'.$_name.'</b> в *там*.',
			);

			shuffle($text);

            //if( rand(0,100) <= 40 ){ $text[0] .= ' Но нифига не получилось. Бебебе'; }

			if( $player->username == $_name ){ $text[0] = '<b>'.$player->username.'</b> '.($player->Sex == 'F' ? 'увязла в любви к себе' : 'зашпиливилил себя'); }


			$chat->sendMessage( '<font color="red">Цветочки</font>', $text[0] );
			$_SESSION['cneg_time'] = time();

		}
		else
		{
			echo 'Такого персонажа не существует';
        }
    }
    else
    {
    	echo 'Запросы можно выполнять раз в 30 секунд';
    }
    die;
}


if( !empty($_GET['act']) && $_GET['act'] == 'add_line' )
{
	if( preg_match( '/private \[/i', $_GET['msg_text'] ) )
	{
		 $chat->add_line($_GET['msg_text'], true);
	}
	else
	{
		 $chat->add_line($_GET['msg_text']);
	}

	setcookie("last_time_send", $chat->GetMicroTime() );
	die;
}

if( !empty($_GET['act']) && $_GET['act'] == 'clear_msgs' )
{	setcookie("last_time_send", $chat->GetMicroTime() );
	$_COOKIE['last_time_send'] = $chat->GetMicroTime();	echo refresh();
	die;
}




if( !empty($_GET['act']) && $_GET['act'] == 'refresh' )
{	echo refresh();
}
?>