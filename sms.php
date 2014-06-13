<?
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

session_start();
if (empty($_SESSION['login'])) { include_once('includes/bag_log_in.php'); exit; }

include_once ('includes/to_view.php');
include_once ('db_config.php');
include_once ('db.php');

if ( list($why) = $db->queryCheck("SELECT Why FROM ".SQL_PREFIX."blocked WHERE Username = '{$_SESSION['login']}'") ) { die( sprintf(playerblocked, $why) ); } unset($why);

$msg = array();
$i   = 0;
$db->checklevelup( $_SESSION['login'] );

list($money) = $db->queryCheck("SELECT Money FROM ".SQL_PREFIX."players WHERE Username = '{$_SESSION['login']}'");

if (!empty($_POST['send'])) {

foreach($_POST['username'] as $uname){

$uname = speek_to_view($uname);
$i++;

if ($uname == $_SESSION['login']) { $msg[1] = 'Оригинально :)'; }
elseif ( empty($uname) ){ $msg[1] = 'Необходимо вести имя персонажа'; }
elseif ( !$db->queryCheck("SELECT * FROM ".SQL_PREFIX."players WHERE Username = '$uname'") ){ $msg[] = 'Игрока с логином "'.$uname.'" не существует'; $i--; }
elseif ( $money < 0.1 * $i ) { $msg[1] = 'У вас нет достаточной суммы'; }
else {

$db->update( SQL_PREFIX.'players', Array( 'Money' => '[-]0.1' ), Array( 'Username' => $_SESSION['login'] ), 'maths' );

$txt = '<i>Почта от <b> '.$_SESSION['login'].' </b> (послано '.date('d.m.y H:i').'):</i> '.mysql_escape_string($_POST['Msg']);
$db->insert( SQL_PREFIX.'messages', Array( 'Username' => $uname, 'Text' => $txt ) );


$msg[1] = 'Отправлено '.okon4($i, array('сообщение', 'сообщения', 'сообщений')).'.';

}

}

}

require_once('_loader.php');

$tow_tpl->assignGlobal('db_config', $db_config);

$temp = & $tow_tpl->getDisplay('content', true);

$temp->assign( 'err', implode( "\n<br>\n", $msg ) );

//$temp->setCache('sms', 60);

if (!$temp->isCached()) {
$temp->addTemplate('sms', 'timeofwars_func_sms.html');
}

$show = & $tow_tpl->getDisplay('index');

$show->assign('title', 'Time Of Wars - отправка сообщений');
$show->assign('Content', $temp);


$show->addTemplate('header', 'header_noframes.html');
$show->addTemplate('index' , 'index.html' );
$show->addTemplate('footer', 'footer.html');


$tow_tpl->display();
?>
