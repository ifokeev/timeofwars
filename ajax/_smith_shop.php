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


$gold = @$db->SQL_result($db->query( "SELECT num FROM ".SQL_PREFIX."smith_shop WHERE metall = 'gold';" ) );
$iron = @$db->SQL_result($db->query( "SELECT num FROM ".SQL_PREFIX."smith_shop WHERE metall = 'iron';" ) );
?>
<div id="take_money">
   <fieldset>
    <div align="center">
    <p>
    У вас денег: <?=$player->Money;?> кр.<br />
    <table>
    <tr>
     <td><input type="button" style="width:180px" onclick="Modalbox.show('ajax/_smith_shop2.php', {title: 'Купить золото', method: 'post', params: {metall: 'gold', act: 'buy' }, overlayClose: false }); return false;" value="Купить золото за 4 кр." class="oo" onmouseover="this.className = 'on';" onmouseout="this.className = 'oo';" /></td>
     <td>Осталось: <font color="green"><?=empty($gold) ? 0 : $gold;?></font> шт.</td>
    </tr>
    <tr>
     <td><input type="button" style="width:180px" onclick="Modalbox.show('ajax/_smith_shop2.php', {title: 'Купить железо', method: 'post', params: {metall: 'iron', act: 'buy' }, overlayClose: false }); return false;" value="Купить железо за 1 кр." class="oo" onmouseover="this.className = 'on';" onmouseout="this.className = 'oo';" /></td>
     <td>Осталось: <font color="green"><?=empty($iron) ? 0 : $iron;?></font> шт.</td>
    </tr>
    </table>

    <br /><br />
    <input type="button" style="width:180px" onclick="Modalbox.show('ajax/_smith_shop2.php', {title: 'Продать золото', method: 'post', params: {metall: 'gold', act: 'sell' }, overlayClose: false }); return false;" value="Продать золото за 0.5 кр." class="oo" onmouseover="this.className = 'on';" onmouseout="this.className = 'oo';" />
    <br />
    <input type="button" style="width:180px" onclick="Modalbox.show('ajax/_smith_shop2.php', {title: 'Продать жезело', method: 'post', params: {metall: 'iron', act: 'sell' }, overlayClose: false }); return false;" value="Продать железо за 0.2 кр." class="oo" onmouseover="this.className = 'on';" onmouseout="this.className = 'oo';" />
    <br />
    <input type="button" style="width:180px" onclick="Modalbox.show('ajax/_smith_shop2.php', {title: 'Продать мусор', method: 'post', params: {metall: 'trash', act: 'sell' }, overlayClose: false }); return false;" value="Продать мусор за 0.05 кр." class="oo" onmouseover="this.className = 'on';" onmouseout="this.className = 'oo';" />

    </p>
    </div>
   </fieldset>
</div>