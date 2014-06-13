<?
header( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' );
header( 'Last-Modified: '.gmdate( 'D, d M Y H:i:s' ).'GMT' );
header( 'Cache-Control: no-cache, must-revalidate' );
header( 'Pragma: no-cache' );
header( 'Content-type: text/html; charset=windows-1251;' );

if( empty($_POST['metall']) || empty($_POST['act']) ) die;
?>
<div id="take_money">
  <form method="POST" action="ajax/_smith_shop3.php" id="myform" onsubmit="return false;">
   <fieldset>
    <center>
     Сколько? <input type="text" name="howmany" value="" /><input type="hidden" name="metall" value="<?=$_POST['metall'];?>" /><br />
     <input type="submit" onclick="Modalbox.show('ajax/_smith_shop3.php', {title: 'Сообщение', method: 'post', params: {howmany: ($(howmany).value), metall: ($(metall).value), act: '<?=$_POST['act'];?>' }, overlayClose: false }); return false;" value="<?=($_POST['act'] == 'sell' ? 'Продать' : 'Купить');?>" class="oo" onmouseover="this.className = 'on';" onmouseout="this.className = 'oo';" /> или <input type="button" value="Закрыть" class="oo" onmouseover="this.className = 'on';" onmouseout="this.className = 'oo';" onclick="Modalbox.hide()" />
    </center>
   </fieldset>
  </form>
</div>