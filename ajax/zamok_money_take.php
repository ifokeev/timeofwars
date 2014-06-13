<?
header( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' );
header( 'Last-Modified: '.gmdate( 'D, d M Y H:i:s' ).'GMT' );
header( 'Cache-Control: no-cache, must-revalidate' );
header( 'Pragma: no-cache' );
header( 'Content-type: text/html; charset=windows-1251;' );

DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

session_start();

include_once ('../db_config.php');
include_once ('../db.php');
include_once ('../classes/PlayerInfo.php');
include_once ('../includes/to_view.php');

$player = new PlayerInfo();
$player->is_blocked();

if( !$id  = @$db->SQL_result($db->query("SELECT id_clan, title FROM ".SQL_PREFIX."clan WHERE id_clan = '".intval($_POST['kazna_clan_id'])."'"),0,0) )
{
	$err = '<p class="errmsg">Такого клана не существует</p';
}
elseif( !$zamok = $db->queryRow("SELECT zamok, balance FROM ".SQL_PREFIX."castles WHERE zamok = 'zamok_".$id."'") )
{	$err = '<p class="errmsg">Такого замка не существуе</p>';
}
elseif( !is_numeric($_POST['howmany_take']) || $_POST['howmany_take'] <= 0 )
{	$err = '<p class="errmsg">Попытка обмана занесена в логи</p>';
	$db->insert( SQL_PREFIX.'castles_logs', Array( 'zamok' => $id, 'Username' => 'Обман '.$player->username, 'date' => 'now()' ) );
}
elseif( $_POST['howmany_take'] > $zamok['balance'] )
{	$err = '<p class="errmsg">В казне нет столько денег</p>';
}
else
{
	$db->update( SQL_PREFIX.'castles', Array( 'balance' => '[-]'.floatval($_POST['howmany_take']) ), Array( 'zamok' => $zamok['zamok'] ), 'maths' );
	$db->insert( SQL_PREFIX.'castles_logs', Array( 'zamok' => $id, 'Username' => $player->username, 'howmuch' => floatval($_POST['howmany_take']), 'date' => 'now()' ) );
	$db->update( SQL_PREFIX.'players', Array( 'Money'   => '[+]'.floatval($_POST['howmany_take']) ), Array( 'Username' => $player->username ), 'maths' );	$err = '<p>Вы успешно забрали из казны '.floatval($_POST['howmany_take']).' кр. Ваши действия занесены в логи сервера. Обновите страницу.</p>';
	$zamok['balance'] -= floatval($_POST['howmany_take']);
}
?>
<div id="mb-send-link">
  <?=$err;?>
  <p><input type="button" value="Закрыть" onclick="Modalbox.hide();" class="oo" ONMOUSEOVER="this.className = 'on';" ONMOUSEOUT="this.className = 'oo';" /></p>
</div>
