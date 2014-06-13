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
    � ��� �����: <?=$player->Money;?> ��.<br />
    <table>
    <tr>
     <td><input type="button" style="width:180px" onclick="Modalbox.show('ajax/_smith_shop2.php', {title: '������ ������', method: 'post', params: {metall: 'gold', act: 'buy' }, overlayClose: false }); return false;" value="������ ������ �� 4 ��." class="oo" onmouseover="this.className = 'on';" onmouseout="this.className = 'oo';" /></td>
     <td>��������: <font color="green"><?=empty($gold) ? 0 : $gold;?></font> ��.</td>
    </tr>
    <tr>
     <td><input type="button" style="width:180px" onclick="Modalbox.show('ajax/_smith_shop2.php', {title: '������ ������', method: 'post', params: {metall: 'iron', act: 'buy' }, overlayClose: false }); return false;" value="������ ������ �� 1 ��." class="oo" onmouseover="this.className = 'on';" onmouseout="this.className = 'oo';" /></td>
     <td>��������: <font color="green"><?=empty($iron) ? 0 : $iron;?></font> ��.</td>
    </tr>
    </table>

    <br /><br />
    <input type="button" style="width:180px" onclick="Modalbox.show('ajax/_smith_shop2.php', {title: '������� ������', method: 'post', params: {metall: 'gold', act: 'sell' }, overlayClose: false }); return false;" value="������� ������ �� 0.5 ��." class="oo" onmouseover="this.className = 'on';" onmouseout="this.className = 'oo';" />
    <br />
    <input type="button" style="width:180px" onclick="Modalbox.show('ajax/_smith_shop2.php', {title: '������� ������', method: 'post', params: {metall: 'iron', act: 'sell' }, overlayClose: false }); return false;" value="������� ������ �� 0.2 ��." class="oo" onmouseover="this.className = 'on';" onmouseout="this.className = 'oo';" />
    <br />
    <input type="button" style="width:180px" onclick="Modalbox.show('ajax/_smith_shop2.php', {title: '������� �����', method: 'post', params: {metall: 'trash', act: 'sell' }, overlayClose: false }); return false;" value="������� ����� �� 0.05 ��." class="oo" onmouseover="this.className = 'on';" onmouseout="this.className = 'oo';" />

    </p>
    </div>
   </fieldset>
</div>