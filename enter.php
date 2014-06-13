<?
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

session_start();


include ('includes/to_view.php');
include ('db.php');
include ('includes/lib/aton_ntoa.php');

$ip  = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
$msg = '';


if(empty($_POST['login_auth']) || empty($_POST['password']) )   $msg = 'Ошибка. Вы не ввели логин либо пароль';
//elseif( !empty($_SESSION['login']) || !empty($_SESSION['id_user']) ) $msg = 'Вы уже авторизовались.';
else
{	@$login_auth = speek_to_view(mysql_escape_string($_POST['login_auth']));
	@$pass   = speek_to_view(mysql_escape_string($_POST['password']));

	if( !$player = $db->queryRow("SELECT Id, Username, Level, ClanID, Align, Password, Room, ChatRoom FROM `".SQL_PREFIX."players` WHERE Username = '".$login_auth."';") )  $msg = 'Такого персонажа не существует. <a href="http://'.$db_config[DREAM]['server'].'/register.php">Зарегистрировать</a>';
	elseif( $why = @$db->SQL_result($db->query("SELECT Why FROM ".SQL_PREFIX."blocked WHERE Username = '".$player['Username']."';"),0,0) ) $msg = 'Персонаж заблокирован. Причина блокировки: '.$why;
	elseif( $player['Password'] != $pass ){ $msg = 'Неверный пароль для персонажа '.$player['Username']; }
	elseif( $db->queryRow("SELECT ip FROM ".SQL_PREFIX."banned WHERE Ip = '".$ip."' OR Ip LIKE '%".$ip."%'") ){ $msg = 'Вам запрещен вход в игру.Обратитесь к Администрации проекта.'; }
	//elseif( !preg_match('/MSIE/i', getenv('HTTP_USER_AGENT')) && !preg_match('/Opera/', getenv('HTTP_USER_AGENT')) ){ $msg = 'Для корректной работы необходим браузер<br /> <a href="http://tow.su/progs/ie6.exe">MS Internet Explorer 6.0 </a> или выше'; }
	else
	{
		$_SESSION['login']       = $player['Username'];
		$_SESSION['id_user']     = $player['Id'];


		if( empty($player['ChatRoom']) )			$_SESSION['chat_room'] = $player['Room'];
		else
		    $_SESSION['chat_room'] = $player['ChatRoom'];


		if( empty($player['Room']) )
		    $_SESSION['userroom'] = '/pl.php';
		else
		    $_SESSION['userroom'] = '/'.$player['Room'].'.php';

		if ( $player['ClanID'] == 1 || $player['ClanID'] == 2 || $player['ClanID'] == 3 || $player['ClanID'] == 4 || $_SESSION['login'] == 's!.' )			$_SESSION['moder'] = 1;


		$_SESSION['SId'] = rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
		$_SESSION['battles'] = 0;

		if( !$db->queryRow("SELECT * FROM ".SQL_PREFIX."hp WHERE Username = '".$player['Username']."'") )
		    $db->insert( SQL_PREFIX.'hp', Array( 'Username' => $player['Username'], 'Time' => time() ) );


		$db->update( SQL_PREFIX.'players', Array( 'SId' => $_SESSION['SId'] ), Array( 'Username' => $player['Username'] ) );
		$db->insert( SQL_PREFIX.'enter_logs', Array( 'add_time' => time(), 'user_id' => $player['Id'], 'ip' => inet_aton($ip) ) );

		if( !$db->execQuery("INSERT INTO ".SQL_PREFIX."ip ( Username, Ip ) VALUES ('".$player['Username']."', '".$ip."') ON DUPLICATE KEY UPDATE Ip = '".$ip."';") )
		   die ('обратитесь к администратору по icq 1334315 по поводу ip адреса');


        if( $db->numrows("SELECT Username FROM ".SQL_PREFIX."stopped WHERE Username = '".$player['Username']."'") ) $no = 1;  else  $no = 0;
        if( $db->numrows("SELECT Username FROM ".SQL_PREFIX."inv WHERE Username = '".$player['Username']."'") )   $nn = 1;  else $nn = 0;

        $db->execQuery("INSERT INTO ".SQL_PREFIX."online (Username, Time, Room, ClanID, Level, Align, Stop, Inv) VALUES ('".$player['Username']."', '".time()."', '".$_SESSION['chat_room']."', '".$player['ClanID']."', '".$player['Level']."', '".$player['Align']."', '$no', '$nn') ON DUPLICATE KEY UPDATE Time = '".time()."', Stop = '$no', Inv = '$nn', ClanID = '".$player['ClanID']."', Align = '".$player['Align']."', Room = '".$_SESSION['chat_room']."'");
        setcookie( 'login_auth', $player['Username'], 0x6FFFFFFF);

        header( 'Location: tow.php', 302 );
    }

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru">
<head>
	<meta http-equiv="content-type" content="text/html; charset=windows-1251" />
	<title>Авторизация</title>
<style>
body{	margin:50px;background: #000 url("http://admin.dnlab.ru/images/-index/bg.png") repeat;
	font-family:Tahoma,Arial,Helvetica,sans-serif;font-size:9pt;color:#fff;
	}
</style>
</head>
<body>
<? if( !empty($msg) ) echo $msg; ?>
<br /><a href="/">Вернуться.</a>
</body>
</html>