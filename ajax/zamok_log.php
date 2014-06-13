<?
header( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' );
header( 'Last-Modified: '.gmdate( 'D, d M Y H:i:s' ).'GMT' );
header( 'Cache-Control: no-cache, must-revalidate' );
header( 'Pragma: no-cache' );
header( 'Content-type: text/html; charset=windows-1251;' );

DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

if( empty($_GET['clan_id']) ) die;


session_start();

include_once ('../db_config.php');
include_once ('../db.php');
include_once ('../classes/PlayerInfo.php');

$player = new PlayerInfo();
$player->is_blocked();

$log = $db->queryArray( "SELECT * FROM ".SQL_PREFIX."castles_logs WHERE zamok = '".intval($_GET['clan_id'])."';" );
?>
<div id="money_log">
<center>
<? if( !empty($log) ): ?>
<? foreach( $log as $v ): ?>
<font color="green"><?=$v['date'];?></font> Персонаж <b><?=$v['Username'];?></b> забрал из казны клана <b><i><?=$v['howmuch'];?></i></b> кр.<br />
<? endforeach; ?>
<? else: ?>
Логов замка не обнаружено.
<? endif; ?>
</center>
</div>