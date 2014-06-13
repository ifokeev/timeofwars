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
    if( strlen($uname) > 15 ) die( '������� ������.' );

	if( (!empty($_SESSION['cneg_time']) && time() - $_SESSION['cneg_time'] >= 30) || empty($_SESSION['cneg_time']) )
	{
		if( $_name = $db->SQL_result( $db->query( "SELECT Username FROM ".SQL_PREFIX."players WHERE Username = '".speek_to_view($uname)."';" ),0) )
		{
			if( $player->Sex == 'F' ) $pr = '�'; else $pr = '';

/*
			$text =
			Array(
			0 => '<b>'.$player->username.'</b> ����� �����'.$pr.' ������� ����� � ��� <b>'.$_name.'.</b>',
			1 => '�����������, <b>'.$player->username.'</b> ���������'.$pr.' ������ � <b>'.$_name.'.</b>',
			2 => '���������� <b>'.$player->username.'</b> ��������'.$pr.' ������� � <b>'.$_name.'.</b>',
			3 => '������������, <b>'.$player->username.'</b> ��������'.$pr.' ������ ����� � ������� <b>'.$_name.'.</b>',
			4 => '������, <b>'.$player->username.'</b> �����'.$pr.' ������� � ��� <b>'.$_name.'.</b>',
			5 => '��������� <b>'.$player->username.'</b> �������'.$pr.' � ���� <b>'.$_name.'.</b>',
			6 => '��������, <b>'.$player->username.'</b> ������'.$pr.' ������ <b>'.$_name.'.</b>',
			7 => '� ������ <b>'.$player->username.'</b> �������'.$pr.' � ������ <b>'.$_name.'.</b>',
			8 => '�� ����������, <b>'.$player->username.'</b> �������'.$pr.' � ���� <b>'.$_name.'.</b>',
			);
*/

			$text =
			Array(
			0 => '<b>'.$player->username.'</b> ������'.$pr.' ���� ����� <b>'.$_name.'.</b>',
			1 => '<b>'.$player->username.'</b> �������'.$pr.' ���� ������ ������ � <b>'.$_name.'.</b>',
			2 => '<b>'.$player->username.'</b> ���������'.$pr.' <b>'.$_name.'</b> �� ��������',
			3 => '<b>'.$player->username.'</b> ����������'.$pr.' � ������ <b>'.$_name.'.</b>',
			4 => '<b>'.$player->username.'</b> ��������'.$pr.' ����������� <b>'.$_name.'</b> ���� � ������',
			5 => '<b>'.$player->username.'</b> �������'.$pr.' <b>'.$_name.'</b> � �����',
			6 => '<b>'.$player->username.'</b> ������'.$pr.' ������ � ����� ���������� ��� <b>'.$_name.'.</b>',
			7 => '<b>'.$player->username.'</b> ������'.$pr.' ��������� <b>'.$_name.'</b> ������� ��������',
			8 => '<b>'.$player->username.'</b> ���������'.$pr.' ��� <b>'.$_name.'</b> "�������"',
			9 => '<b>'.$player->username.'</b> ������'.$pr.' <b>'.$_name.'</b> ������ ���������',
			10 => '<b>'.$player->username.'</b> ������'.$pr.' <b>'.$_name.'</b> �� ����� ����������',
			11 => '<b>'.$player->username.'</b> ������'.$pr.' <b>'.$_name.'</b> �� ������ ����������',
			12 => '<b>'.$player->username.'</b> �������'.$pr.' �������� ������������� <b>'.$_name.'.</b>',
			13 => '<b>'.$player->username.'</b> �������'.$pr.' <b>'.$_name.'</b> ����� � <a href="http://'.$db_config[DREAM]['server'].'/inf.php?uname=�������" target="_blank">�������.</a>',
			14 => '<b>'.$player->username.'</b> �������'.$pr.' � ����� ����� ��� <b>'.$_name.'.</b>',
			15 => '<b>'.$player->username.'</b> ������ "����������". ���������',
			16 => '<b>��������</b>',
			17 => '<b>'.$player->username.'</b> ����-���-���, ����-���-���, ����-����-����-���� ���� ���-���-���!',
			17 => '<b>'.$player->username.'</b> �������'.$pr.': "������-�������� ������-�������" � ��������� <b>'.$_name.'</b> � *���*.',
			);

			shuffle($text);

            //if( rand(0,100) <= 40 ){ $text[0] .= ' �� ������ �� ����������. ������'; }

			if( $player->username == $_name ){ $text[0] = '<b>'.$player->username.'</b> '.($player->Sex == 'F' ? '������ � ����� � ����' : '������������ ����'); }


			$chat->sendMessage( '<font color="red">��������</font>', $text[0] );
			$_SESSION['cneg_time'] = time();

		}
		else
		{
			echo '������ ��������� �� ����������';
        }
    }
    else
    {
    	echo '������� ����� ��������� ��� � 30 ������';
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