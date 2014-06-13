<?
header( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' );
header( 'Last-Modified: '.gmdate( 'D, d M Y H:i:s' ).'GMT' );
header( 'Cache-Control: no-cache, must-revalidate' );
header( 'Pragma: no-cache' );
header( 'Content-type: text/html; charset=windows-1251;' );
?>
<div id="take_money">
  <form method="POST" action="ajax/_smith1.php" id="myform" onsubmit="return false;">
     <fieldset>
   <table cellpadding="0" cellspacing="0" width="100%" height="100%" align="center" valign="top">
    <tr>
     <td align="center"><b>СОЗДАТЬ ИЗ:</b></td>
    </tr>
   </table>
   <table cellpadding="0" cellspacing="0" width="100%" height="100%" align="center" valign="top">
    <tr>
     <td align="center">Золота</td>
     <td align="center">Железа</td>
     <td align="center">Мусора</td>
    </tr>
    <tr>
     <td align="center"><input type="text" name="met_2" value="" maxlength="4" style="width:30px" /></td>
     <td align="center"><input type="text" name="met_1" value="" maxlength="4" style="width:30px" /></td>
     <td align="center"><input type="text" name="met_0" value="" maxlength="4" style="width:30px" /></td>
    </tr>
   </table><br />
   <table cellpadding="0" cellspacing="0" width="100%" height="100%">
    <tr>
     <td align="center"><i>Название:</i> <input type="text" name="weap_name" value="" maxlength="20" style="width:70px" /></td>
    </tr>
   </table>
   <table cellpadding="0" cellspacing="0" width="100%" height="100%" align="center" valign="top">
    <tr>
     <td align="center"><b>Выбираем модификаторы:</b></td>
    </tr>
    <tr>
     <td align="center"><input type="submit" style="width:150px" onclick="Modalbox.show('ajax/_smith1.php', {title: 'Сообщение', method: 'post', params: {met_0: ($(met_0).value),met_1: ($(met_1).value),met_2: ($(met_2).value),need_lvl: ($(need_lvl).value),need_str: ($(need_str).value),need_agil: ($(need_agil).value),need_intu: ($(need_intu).value),need_endu: ($(need_endu).value),give_str: ($(give_str).value),give_mindmg: ($(give_mindmg).value),give_agil: ($(give_agil).value),give_maxdmg: ($(give_maxdmg).value),give_intu: ($(give_intu).value),give_endu: ($(give_endu).value),give_arm1: ($(give_arm1).value),give_arm2: ($(give_arm2).value),give_arm3: ($(give_arm3).value),give_arm4: ($(give_arm4).value),give_crit: ($(give_crit).value),give_acrit: ($(give_acrit).value),give_uv: ($(give_uv).value),give_auv: ($(give_auv).value),weap_name: ($(weap_name).value),tpl_num: '<?=$_GET['smith_id'];?>', mode: 'make' }, overlayClose: false }); return false;" value="Сделать" class="oo" onmouseover="this.className = 'on';" onmouseout="this.className = 'oo';" /></td>
    </tr>
   </table>
   <table cellpadding="0" cellspacing="0" width="100%" height="100%" align="center" valign="top">
    <tr>
     <td align="center">Сила</td>
     <td align="left"><input type="text" name="give_str" value="" maxlength="2" style="width:50px" /></td>
     <td width="10px">&nbsp;</td>
     <td align="center">Min урон</td>
     <td align="left"><input type="text" name="give_mindmg" value="" maxlength="2" style="width:50px" /></td>
    </tr>
    <tr>
     <td align="center">Ловкость</td>
     <td align="left"><input type="text" name="give_agil" value="" maxlength="2" style="width:50px" /></td>
     <td width="10px">&nbsp;</td>
     <td align="center">Max урон</td>
     <td align="left"><input type="text" name="give_maxdmg" value="" maxlength="2" style="width:50px" /></td>
    </tr>
    <tr>
     <td align="center">Интуиция</td>
     <td align="left"><input type="text" name="give_intu" value="" maxlength="2" style="width:50px" /></td>
     <td width="10px">&nbsp;</td>
     <td align="center">+HP</td>
     <td align="left"><input type="text" name="give_endu" value="" maxlength="2" style="width:50px" /></td>
    </tr>

    <tr>
     <td align="center">Броня головы</td>
     <td align="left"><input type="text" name="give_arm1" value="" maxlength="2" style="width:50px" /></td>
     <td width="10px">&nbsp;</td>
     <td align="center">Крит</td>
     <td align="left"><input type="text" name="give_crit" value="" maxlength="2" style="width:50px" /></td>
    </tr>
    <tr>
     <td align="center">Броня корпуса</td>
     <td align="left"><input type="text" name="give_arm2" value="" maxlength="2" style="width:50px" /></td>
     <td width="10px">&nbsp;</td>
     <td align="center">АнтиКрит</td>
     <td align="left"><input type="text" name="give_acrit" value="" maxlength="2" style="width:50px" /></td>
    </tr>
    <tr>
     <td align="center">Броня пояса</td>
     <td align="left"><input type="text" name="give_arm3" value="" maxlength="2" style="width:50px" /></td>
     <td width="10px">&nbsp;</td>
     <td align="center">Уворот</td>
     <td align="left"><input type="text" name="give_uv" value="" maxlength="2" style="width:50px" /></td>
    </tr>
    <tr>
     <td align="center">Броня ног</td>
     <td align="left"><input type="text" name="give_arm4" value="" maxlength="2" style="width:50px" /></td>
     <td width="10px">&nbsp;</td>
     <td align="center">АнтиУворот</td>
     <td align="left"><input type="text" name="give_auv" value="" maxlength="2" style="width:50px" /></td>
    </tr>
   </table>
   <table cellpadding="0" cellspacing="0" width="100%" height="100%" align="center" valign="top">
    <tr>
     <td align="center"><b>Требуется:<font color="red">*</font></b></td>
     <td align="center"><input type="text" value="level" onBlur="if (value == '') {value='level'}" onFocus="if (value == 'level') {value = ''}" name="need_lvl" maxlength="10" style="width:45px" /></td>
     <td align="center"><input type="text" value="сила" onBlur="if (value == '') {value='сила'}" onFocus="if (value == 'сила') {value = ''}" name="need_str" maxlength="10" style="width:45px" /></td>
     <td align="center"><input type="text" value="ловк." onBlur="if (value == '') {value='ловк.'}" onFocus="if (value == 'ловк.') {value = ''}" name="need_agil" maxlength="10" style="width:45px" /></td>
     <td align="center"><input type="text" value="инта" onBlur="if (value == '') {value='инта'}" onFocus="if (value == 'инта') {value = ''}" name="need_intu" maxlength="10" style="width:45px" /></td>
     <td align="center"><input type="text" value="выносливость" onBlur="if (value == '') {value='выносливость'}" onFocus="if (value == 'выносливость') {value = ''}" name="need_endu" maxlength="10" style="width:45px" /></td>
    </tr>
   </table>
      </fieldset>
  </form>
</div>