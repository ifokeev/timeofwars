<?
header( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' );
header( 'Last-Modified: '.gmdate( 'D, d M Y H:i:s' ).'GMT' );
header( 'Cache-Control: no-cache, must-revalidate' );
header( 'Pragma: no-cache' );
header( 'Content-type: text/html; charset=windows-1251;' );
?>
<div id="take_money">
  <form method="POST" action="ajax/zamok_money_take.php" id="myform" onsubmit="return false;">
   <fieldset>
    <center>
     ������� �������? <input type="text" name="howmany_take" value="" /><input type="hidden" name="kazna_clan_id" value="<?=$_POST['kazna_clan_id'];?>" /><br />
     <input type="submit" onclick="Modalbox.show('ajax/zamok_money_take.php', {title: '���������', method: 'post', params: {howmany_take: ($(howmany_take).value), kazna_clan_id: ($(kazna_clan_id).value) }, overlayClose: false }); return false;" value="�������" class="oo" onmouseover="this.className = 'on';" onmouseout="this.className = 'oo';" /> ��� <input type="button" value="�������" class="oo" onmouseover="this.className = 'on';" onmouseout="this.className = 'oo';" onclick="Modalbox.hide()" />
    </center>
   </fieldset>
  </form>
</div>