<?
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

session_start();

include_once ('db_config.php');
include_once ('db.php');


include_once ('classes/PlayerInfo.php');

$player = new PlayerInfo();
$player->is_blocked();
$player->checkBattle();


@$m          = '';
@$r          = intval($_GET['r']);
@$h          = intval($_GET['h']);
@$enefriend  = filter( $_POST['enefriend'] );
@$persName   = filter ( $_POST['persName'] );
@$enfrReason = filter( $_POST['enfrReason'] );
@$delenemy   = $_POST['delenemy'];
@$delfriend  = $_POST['delfriend'];
@$_POST['enfrType'] = filter( $_POST['enfrType'] );


function filter_info($s){
$str = $s;
$str = trim($str);
$str = htmlspecialchars($str, ENT_NOQUOTES);
$str = str_replace( '&lt;', '<', $str );
$str = str_replace( '&gt;', '>', $str );
$str = str_replace( '&quot;', '"', $str );
$str = str_replace( '"', '&#34;', $str );
$str = str_replace( "'", '&#39;', $str );
$str = str_replace( '<', '&#60;', $str );
$str = str_replace( '>', '&#62;', $str );
$str = str_replace( '\0', '', $str );
$str = str_replace( '', '', $str );
$str = str_replace( '\t', '', $str );
$str = str_replace( '../', '. . / ', $str );
$str = str_replace( '..', '. . ', $str );
$str = str_replace( '/*', '', $str );
$str = str_replace( '%00', '', $str );
$str = stripslashes( $str );
$str = str_replace( '\\', '&#92', $str );
return $str;
}

$msg = array();

if(!empty($_POST['change'])){

if(!empty($_POST['new_town']) && !ereg("[a-zA-Zа-яА-Я]{2,15}$", $_POST['new_town'])){ $msg[] = _ANKET_errtown; }
if(!empty($_POST['new_RealName']) && !ereg("[a-zA-Zа-яА-Я]{1,15}$", $_POST['new_RealName'])){ $msg[] = _ANKET_errname; }
if(!empty($_POST['new_ICQ']) && !ereg("[0-9]{4,15}$", $_POST['new_ICQ'])){ $msg[] = _ANKET_errICQ; }
if(!empty($_POST['new_Info']) && strlen($_POST['new_Info']) > 1024){ $msg[] = _ANKET_errBody; }

if(empty($msg)){

$_POST['new_realName'] = filter($_POST['new_RealName']);
$_POST['new_ICQ']      = filter($_POST['new_ICQ']);
$_POST['new_town']     = filter($_POST['new_town']);
$_POST['new_Info']     = filter_info($_POST['new_Info']);


$db->update( SQL_PREFIX.'players', Array( 'RealName' => $_POST['new_RealName'], 'ICQ' => $_POST['new_ICQ'], 'town' => $_POST['new_town'], 'Info' => $_POST['new_Info'] ), Array( 'Username' => $player->username ) );
$msg[1] = _ANKET_msg1;

}



}



if(!empty($enefriend) && !empty($persName)){

if( !$data = $db->queryRow("SELECT loginof, username FROM ".SQL_PREFIX."friendsofuser WHERE (loginof = '$persName' OR loginof like '$persName') && username = '".$player->username."'") ){
if( $res = $db->queryRow("SELECT Username FROM ".SQL_PREFIX."players where Username = '$persName'") ){

if($res['Username'] != $player->username){

$db->insert( SQL_PREFIX.'friendsofuser', Array( 'username' => $player->username, 'loginof' => $res['Username'], 'is_what' => $_POST['enfrType'], 'reason' => $enfrReason, 'dateoflogin' => 'now()' ) );
$txt = $player->username.' добавил вас в свой список '.($_POST['enfrType'] == 'f' ? 'друзей' : 'врагов').' (причина: '.($enfrReason != '' ? $enfrReason : 'без причины').')';
$db->insert( SQL_PREFIX.'messages', Array( 'Username' => $res['Username'], 'Text' => $txt ) );
$msg[1] = _ANKET_msg1;

} else { $msg[1] = _ANKET_errfriend1; }

} else { $msg[] = _ANKET_errfriend2; }
} else { $msg[] = _ANKET_errfriend3; }

}



if(!empty($delenemy)){
$db->execQuery("DELETE FROM ".SQL_PREFIX."friendsofuser WHERE loginof = '$persName' AND username = '".$player->username."'");
$txt = $player->username.' удалил вас из своего списка врагов.';
$db->insert( SQL_PREFIX.'messages', Array( 'Username' => $persName, 'Text' => $txt ) );
$msg[1] = _ANKET_msg1;
}

if(!empty($delfriend)){
$db->execQuery("DELETE FROM ".SQL_PREFIX."friendsofuser WHERE loginof = '$persName' AND username = '".$player->username."'");
$txt = $player->username.' удалил вас из своего списка друзей.';
$db->insert( SQL_PREFIX.'messages', Array( 'Username' => $persName, 'Text' => $txt ) );
$msg[1] = _ANKET_msg1;
}


list($Password, $Info, $ICQ, $Email, $town, $RealName) = $db->queryCheck("SELECT Password, Info, ICQ, Email, town, RealName FROM ".SQL_PREFIX."players WHERE Username = '".$player->username."'");

if(!empty($_POST['change_pass']) && !empty($_POST['old_pass_user']) && !empty($_POST['new_pass_first']) && !empty($_POST['new_pass_second'])){

if($_POST['old_pass_user'] != $Password){ $msg[] = _ANKET_errPASS1; }
if($_POST['new_pass_first'] != $_POST['new_pass_second']){ $msg[] = _ANKET_errPASS2; }
if(strlen($_POST['new_pass_first']) < 4 || strlen($_POST['new_pass_first']) > 25 || strlen($_POST['new_pass_second']) < 4 || strlen($_POST['new_pass_second']) > 25){ $msg[] = _ANKET_errPASS3; }

if(empty($msg)){

$_POST['new_pass_second'] = filter($_POST['new_pass_second']);


$m .= 'Здраствуйте!'; $m .= "\n";
$m .= date('d.m.Y H:i').' был сменен пароль к персонажу '.$player->username.' он-лайн игры Time OF Wars.'; $m .= "\n";
$m .= 'Новый пароль: '.$_POST['new_pass_second']; $m .= "\n\n\n\n";
$m .= 'С уважением. администрация Time OF Wars.';
@mail($Email, 'TimeOFwars.ru :: Смена пароля у персонажа '.$player->username, $m);

$db->update( SQL_PREFIX.'players', Array( 'Password' => $_POST['new_pass_second'] ), Array( 'Username' => $player->username ) );
$msg[1] = _ANKET_msg2;

session_destroy();
}

}



if(!empty($_POST['change_emailuser']) && !empty($_POST['old_email_user']) && !empty($_POST['new_email_first']) && !empty($_POST['new_email_second'])){

if($_POST['old_email_user'] != $Email){ $msg[] = _ANKET_errMAIL1; }
if($_POST['new_email_first'] != $_POST['new_email_second']){ $msg[] = _ANKET_errMAIL2; }
if ( !ereg("^[a-zA-Z0-9_\.-]+@([a-z0-9][a-z0-9-]+\.)+[a-z]{2,4}$", $_POST['new_email_second']) && trim($_POST['new_email_second'] != '')){ $msg[1] = _ANKET_errMAIL3; }
if ( !ereg("^[a-zA-Z0-9_\.-]+@([a-z0-9][a-z0-9-]+\.)+[a-z]{2,4}$", $_POST['new_email_first']) && trim($_POST['new_email_first'] != '')){   $msg[1] = _ANKET_errMAIL3; }
if ( !ereg("^[a-zA-Z0-9_\.-]+@([a-z0-9][a-z0-9-]+\.)+[a-z]{2,4}$", $_POST['old_email_user']) && trim($_POST['old_email_user'] != '')){     $msg[1] = _ANKET_errMAIL3; }

if(empty($msg)){
$_POST['new_email_second'] = filter($_POST['new_email_second']);
$db->update( SQL_PREFIX.'players', Array( 'Email' => $_POST['new_email_second'] ), Array( 'Username' => $player->username ) );
$msg[1] = _ANKET_msg3;
}

}


if( !empty($_GET['r']) && $_GET['r'] == 5 && !empty($_GET['zayavka']) && is_numeric($_GET['zayavka']) && $_GET['zayavka'] > 0 )
{
	if( !$dat = $db->queryRow( "SELECT ref.un, p.Id, ref.status, ref.refer_id, p.Username, p.Level FROM ".SQL_PREFIX."referal as ref INNER JOIN ".SQL_PREFIX."players as p ON( p.Username = ref.login )  WHERE ref.un = '".intval($_GET['zayavka'])."' AND ref.refer_id = '".$player->user_id."';" ) ) $msg[1] = 'Такого реферала не найдено';
	elseif( $dat['status'] != 'none' ) $msg[1] = 'Заявка уже подтверждена';
	elseif( $dat['Level'] < 10 ) $msg[1] = 'Нельзя получить деньги с персонажа, меньше 10-го уровня.';
	else
	{
		$db->insert( SQL_PREFIX.'admin_referal', Array( 'from_userid' => $dat['refer_id'], 'referal_id' => $dat['Id'], 'add_time' => time() ) );
		$db->update( SQL_PREFIX.'referal', Array( 'status' => 'inprogress' ), Array( 'un' => $dat['un'] ) );
		$msg[1] = 'Заявка на получение денег с персонажа '.$dat['Username'].' добавлена.';
	}


}




function slogin( $user, $lvl, $clanid )
{
	global $db_config;

		$r = '';

		if( !empty($clanid) ) $r .= '<a href="http://'.$db_config[DREAM]['server'].'/top5.php?show='.$clanid.'" target="_blank"><img src="http://'.$db_config[DREAM_IMAGES]['server'].'/clan/'.$clanid.'.gif" /></a>';

		$r .= '<a href="javascript:top.AddToPrivate(\''.$user.'\', true)">'.$user.'</a> ['.$lvl.'] <a href="http://'.$db_config[DREAM]['server'].'/inf.php?uname='.$user.'" target="_blank"><img src="http://'.$db_config[DREAM_IMAGES]['server'].'/inf.gif" /></a>';
		return $r;
}

function getmonth($F)
{
	switch($F)
	{
		case 'January':  $str = 'января'; break;
		case 'February':  $str = 'февраля'; break;
		case 'March':  $str = 'марта'; break;
		case 'April':  $str = 'апреля'; break;
		case 'May':  $str = 'мая'; break;
		case 'June':  $str = 'июня'; break;
		case 'July':  $str = 'июля'; break;
		case 'August':  $str = 'августа'; break;
		case 'September':  $str = 'сентября'; break;
		case 'October':  $str = 'октября'; break;
		case 'November':  $str = 'ноября'; break;
		case 'December':  $str = 'декабря'; break;
    }

    return $str;
}



@$p = intval($_GET['page']);


$ref_num = $db->numrows( "SELECT refer_id FROM ".SQL_PREFIX."referal WHERE refer_id = '".$player->user_id."';" );

$num   = 10;
$total = @ceil($ref_num/$num);

if(empty($p) || $p < 0)
    $p = 1;
if($p > $total)
    $p = $total;

$start = max( 0, ($p * $num - $num) );


$referals = $db->queryArray( "SELECT p.Id, p.Username, p.Level, p.ClanID, p.Expa, (p.Won + p.Lost) as sum_b, ref.un, ref.http_referer, ref.status, ref.add_time FROM ".SQL_PREFIX."referal as ref INNER JOIN ".SQL_PREFIX."players as p ON(p.Username = ref.login) WHERE ref.refer_id = '".$player->user_id."' ORDER BY ref.add_time DESC LIMIT ".$start.", ".$num );


$pages = array();
$s     = 0;
$out   = '';

for($i = 1; $i <= $total; $i++)
   if( ($i <= 2  || ($i >= $p-2 && $i <= $p+2)  ||  $i > $total-2 ) && !in_array($i, $pages))
     $pages[] = $i;


$p > 1 ? $out .= ' <a href="?r=5&page='.($p-1).'">предыдущая</a> ' : $out .= '';

for($i = 0; $i < count($pages); $i++)
{
	$s++;
	$pages[$i] != $s ? $out .= ' ... ' : $out .= '';
	$pages[$i] == $p ? $out .= ' <span>'.$pages[$i].'</span> ' : $out .= ' <a href="?r=5&page='.$pages[$i].'">'.$pages[$i].'</a> ';
	$s = $pages[$i];
}

$p < $total && $total > 1 ? $out .= ' <a href="?r=5&page='.($p+1).'">следующая</a> ' : $out .= '';




$err = implode( "\n<br>\n", $msg );

include('_loader.php');

$tow_tpl->assignGlobal( 'db_config', $db_config );
$tow_tpl->assignGlobal( 'db',        $db        );

$temp = & $tow_tpl->getDisplay('content', true);

$temp->assign( 'err', implode( "\n<br>\n", $msg ) );
$temp->assign( 'r',        $r                     );
$temp->assign( 'RealName', $RealName              );
$temp->assign( 'ICQ',      $ICQ                   );
$temp->assign( 'town',     $town                  );
$temp->assign( 'Info',     $Info                  );
$temp->assign( 'p',        $p                     );
$temp->assign( 'h',        $h                     );
$temp->assign( 'user_id',  $player->user_id       );

$temp->assign( 'out',   $out );
$temp->assign( 'referals', $referals );

$temp->assign( 'friends', $db->queryArray("SELECT p.Username, p.ClanID, p.Level FROM ".SQL_PREFIX."friendsofuser as fu INNER JOIN ".SQL_PREFIX."players as p ON( fu.loginof = p.Username ) WHERE fu.is_what = 'f' AND fu.username = '".$player->username."'" ) );
$temp->assign( 'enemies', $db->queryArray("SELECT p.Username, p.ClanID, p.Level FROM ".SQL_PREFIX."friendsofuser as fu INNER JOIN ".SQL_PREFIX."players as p ON( fu.loginof = p.Username ) WHERE fu.is_what = 'e' AND fu.username = '".$player->username."'" ) );

$temp->assign( 'f_cnt', $db->numrows( "SELECT username FROM ".SQL_PREFIX."friendsofuser WHERE loginof = '".$player->username."' AND is_what = 'f'" ) );
$temp->assign( 'e_cnt', $db->numrows( "SELECT username FROM ".SQL_PREFIX."friendsofuser WHERE loginof = '".$player->username."' AND is_what = 'e'" ) );


//if (!$temp->isCached()) {
$temp->addTemplate('anketa', 'timeofwars_func_anketa.html');
//}

$show = & $tow_tpl->getDisplay('index');


$show->assign('title', 'Time Of Wars - анкета пользователя');
$show->assign('Content', $temp);


$show->addTemplate('header', 'header.html');
$show->addTemplate('index' , 'index.html' );
$show->addTemplate('footer', 'footer.html');


$tow_tpl->display();
?>