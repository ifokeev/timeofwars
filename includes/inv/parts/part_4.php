<tr bgcolor="#D5D5D5">
 <td align="center" colspan="5"><b>����� ������� �� ����������</b></td>
</tr>
<? if(!empty($part4)): ?>
<? foreach($part4 as $v): ?>
<? if ($color == '#C7C7C7'): $color = '#D5D5D5'; elseif($color == '#D5D5D5'): $color = '#C7C7C7'; endif; ?>
<? $vesh = (100 - ($v['NOWwear']/$v['MAXwear']) * 100); ?>
<? if($view == 1): ?>
	<tr bgcolor="<?=$color;?>">
	 <td width="100px" valign="bottom">
	  <table width="100%">
	   <tr>
	    <td align="center" colspan="4" height="100px"><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/<?=$v['Id'];?>.gif" /></td>
       </tr>
	   <tr>
	    <td colspan="4">
		 <table height="5px" border="0" cellpadding="0" cellspacing="0" title="�������������" width="<?=$vesh;?>%">
		  <tr>
		   <td background="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/fbis.jpg"></td>
          </tr>
         </table>
	    </td>
	   </tr>
	   <tr>
        <td><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/unuse.gif" title="���������� ������������" /></td>
		<td><a href="?unlock=<?=$v['Un_Id']?>&part=4"><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/unlock.gif" title="������ ���� �� �������" /></a></td>
		<td><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/ungive.gif" title="���������� ��������" /></td>
		<td><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/undrop.gif" title="���������� ���������" /></td>
	   </tr>
	  </table>
	 </td>
	 <td align="center">
	  <center>
	   <a href="thing.php?thing=<?=$v['Un_Id'];?>" target="_blank"><?=$v['Thing_Name'];?></a> <? if ($v['Clan_need']): ?> <img src="http://<?=$db_config[DREAM_IMAGES][server];?>/clan/<?=$v['Clan_need'];?>.gif" /> <? endif; ?><br />
	   ����: <?=$v['Cost'];?> ��. �����: <?=$v['NOWwear'];?>/<?=$v['MAXwear'];?>. ����� <?=$v['Un_Id'];?>
	  </center>
	  <table width="100%" border="0" cellpadding="1" cellspacing="1">
	   <tr>
	    <td width="50%" valign="top" align="left">
	     <center><b>�������:</b></center>
	      <small>
           <?
            if ($v['Stre_need']): print '&bull; ����: '.$v['Stre_need'].'<br />'; endif;
            if ($v['Agil_need']): print '&bull; ��������: '.$v['Agil_need'].'<br />'; endif;
            if ($v['Intu_need']): print '&bull; ��������: '.$v['Intu_need'].'<br />'; endif;
            if ($v['Endu_need']): print '&bull; ������������: '.$v['Endu_need'].'<br />'; endif;
            if ($v['Level_need']): print '&bull; �������: '.$v['Level_need'].'<br />'; endif;
           ?>
          </small>
        </td>
	    <td width="50%" valign="top" align="left">
	     <center><b>����:</b></center>
	      <small>
           <?
            if ($v['Level_add']): print '&bull; �������: +'.$v['Level_add'].'<br />'; endif;
            if ($v['MAXdamage']): print '&bull; �����������: '.$v['MINdamage'].' - '.$v['MAXdamage'].'<br />'; endif;
            if ($v['Armor1']): print '&bull; ����� ������: '.$v['Armor1'].'<br />'; endif;
            if ($v['Armor2']): print '&bull; ����� �������: '.$v['Armor2'].'<br />'; endif;
            if ($v['Armor3']): print '&bull; ����� �����: '.$v['Armor3'].'<br />'; endif;
            if ($v['Armor4']): print '&bull; ����� ���: '.$v['Armor4'].'<br />'; endif;
            if ($v['Crit']): print '&bull; ����������� �����: +'.$v['Crit'].'%<br />'; endif;
            if ($v['Uv']): print '&bull; ����������� �������: +'.$v['Uv'].'%<br />'; endif;
            if ($v['AntiCrit']): print '&bull; ��������: +'.$v['AntiCrit'].'%<br />'; endif;
            if ($v['AntiUv']): print '&bull; ����������: +'.$v['AntiUv'].'%<br />'; endif;
            if ($v['Stre_add']): print '&bull; ����: +'.$v['Stre_add'].'<br />'; endif;
            if ($v['Agil_add']): print '&bull; ��������: +'.$v['Agil_add'].'<br />'; endif;
            if ($v['Intu_add']): print '&bull; ��������: +'.$v['Intu_add'].'<br />'; endif;
            if ($v['Endu_add']): print '&bull; HP: +'.$v['Endu_add'].'<br />'; endif;
            if ($v['MagicID']): print '<br />&bull; <i>�������� �����</i>: '.$v['MagicID'].'<br />'; endif;
           ?>
	      </small>
	    </td>
	   </tr>
	  </table>
	 </td>
	 <? elseif($view == 2): ?>
     <? $a+=1; ?>
	 <td bgcolor="<?=$color;?>" align="center">
	  <table width="100px">
	   <tr>
	    <td colspan="4" align="center" height="90px"><a href="thing.php?thing=<?=$v['Un_Id'];?>" target="_blank"><img title="<?=$v['Thing_Name'];?> ����� <?=$v['Un_Id']."\n";?>
����:
<?
if ($v['Count']):     print '����������: '.$v['Count']."\n";   endif;
if ($v['Level_add']): print '�������: +'.$v['Level_add']."\n"; endif;
if ($v['MAXdamage']): print '�����������: '.$v['MINdamage'].' - '.$v['MAXdamage']."\n"; endif;
if ($v['Armor1']):    print '����� ������: '.$v['Armor1']."\n"; endif;
if ($v['Armor2']):    print '����� �������: '.$v['Armor2']."\n"; endif;
if ($v['Armor3']):    print '����� �����: '.$v['Armor3']."\n"; endif;
if ($v['Armor4']):    print '����� ���: '.$v['Armor4']."\n"; endif;
if ($v['Crit']):      print '����������� �����: +'.$v['Crit'].'%'."\n"; endif;
if ($v['Uv']):        print '����������� �������: +'.$v['Uv'].'%'."\n"; endif;
if ($v['AntiCrit']):  print '��������: +'.$v['AntiCrit'].'%'."\n"; endif;
if ($v['AntiUv']):    print '����������: +'.$v['AntiUv'].'%'."\n"; endif;
if ($v['Stre_add']):  print '����: +'.$v['Stre_add']."\n"; endif;
if ($v['Agil_add']):  print '��������: +'.$v['Agil_add']."\n"; endif;
if ($v['Intu_add']):  print '��������: +'.$v['Intu_add']."\n"; endif;
if ($v['Endu_add']):  print 'HP: +'.$v['Endu_add']."\n"; endif;
if ($v['MagicID']):   print "\n".'�������� �����: '.$v['MagicID']; endif;
?>
" src="http://<?=$db_config[DREAM_IMAGES][server];?>/<?=$v['Id'];?>.gif" /></a>
        </td>
       </tr>
	   <tr>
	    <td colspan="4">
		 <table height="5px" border="0" cellpadding="0" cellspacing="0" title="����� <?=$v['NOWwear'];?>/<?=$v['MAXwear'];?>" width="<?=$vesh;?>%">
		  <tr>
		   <td background="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/fbis.jpg"></td>
		  </tr>
		 </table>
		</td>
	   </tr>
	   <tr>
        <td><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/unuse.gif" title="���������� ������������" /></td>
		<td><a href="?unlock=<?=$v['Un_Id']?>&part=4"><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/unlock.gif" title="������ ���� �� �������" /></a></td>
		<td><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/ungive.gif" title="���������� ��������" /></td>
		<td><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/undrop.gif" title="���������� ���������" /></td>
	   </tr>
	  </table>
	 </td>
<? if($a%6 == 0): echo '</tr><tr>'; endif; ?>
<? endif; ?>
<? endforeach; ?>
  </td>
 </tr>
<? endif; ?>
</table>
<tr>
 <td>
  <table border="1" height="100%" bgcolor="#D5D5D5">
   <tr>
   <form method="POST" id="moneytrans">
	<td align="center">
	 <b>�������� �������:</b>
	</td>
   </tr>
   <tr>
    <td>
     <table>
      <tr>
       <td align="right">�����:</td>
	   <td align="center"><input type="text" maxlength="5" name="TRANSFERSUM" size="30" id="MonTrans" onkeypress="return isNum(event)" onchange="ostmoney()" /></td>
	   <td align="left" nowrap="nowrap"><small>��. (� ��� ���� <?=$player->Money;?>, <b id="EndMon">��������� <?=$player->Money;?></b>)</small></td>
	  </tr>
	  <tr>
	   <td align="right">����������:</td>
	   <td align="center"><input type="text" maxlength="30" name="CRRECIVIER" size="30" /></td>
	   <td align="left"><small>(��� ���������)</small></td>
	  </tr>
	  <tr>
	   <td align="right">��������� �������: </td>
	   <td align="center"><input type="text" maxlength="256" name="CMNT" size="30" /></td>
	   <td align="left"><small>�������� ���������� ��������</small></td>
	  </tr>
	 </table>
	</td>
   </tr>
   <tr>
	<td>
	 <table>
	  <tr>
	   <td><small>�, <?=$player->username;?>, ���������� � �������� ����, �������, ��� ������������� �������� ����� ���� ��������� ��� ��������� ������� ����, �������� � ������. �������, ��� ������ ��� �������� ����� ���� ��������� � ������ ���� ����� �������� ����������. </small> </td>
	   <td><input name="TRRULE1" type="checkbox" value="1" /><br /></td>
	  </tr>
	 </table>
    </td>
   </tr>
   <tr>
	<td align="center"><input type="submit" name="TRANSFER_CR" id="TRANSGO" value="��������!" class="oo" onmouseover="this.className = 'on';" onmouseout="this.className = 'oo';" /></td>
   </tr>
   </form>
  </table>
 </td>
</tr>
<tr>
 <td>
  <table border="1" bgcolor="#D5D5D5">
   <tr>
    <form method="POST">
	<td align="center"><b>�������� ������������� ���� ��������:</b></td>
   </tr>
   <tr>
    <td align="center"><small>�� ������ �������� ������������� ���� �������� �� ������������ ����� ��� �������������� ������ ����� � �������� � ������ ������.<br />�� ��������� ����� ������� <font color="Red"> ��� �������� </font> �� ������ ������ ��������.<br /><br /></td>
   </tr>
   <tr>
    <td>
     <table width="100%" border="1">
	  <tr align="center">
	   <td width="16%"><input type="radio" name="BLOCKTIME" value="43200" /><br /><small>12 �����</small></td>
	   <td width="16%"><input type="radio" name="BLOCKTIME" value="86400" /><br /><small>1 ����</small></td>
	   <td width="16%"><input type="radio" name="BLOCKTIME" value="260000" /><br /><small>3 ���</small></td>
	   <td width="16%"><input type="radio" name="BLOCKTIME" value="604800" /><br /><small>7 ����</small></td>
	   <td width="16%"><input type="radio" name="BLOCKTIME" value="1296000" /><br /><small>15 ����</small></td>
	   <td width="16%"><input type="radio" name="BLOCKTIME" value="2592000" /><br /><small>30 ����</small></td>
	  </tr>
	 </table>
    </td>
   </tr>
   <tr>
    <td>
     <table>
      <tr>
       <td><small>�, <?=$player->username;?>, �������, ��� �� ����� ������������ ���������� �� ��������� ���������� �������, �������� �� ���������� � �������� ��� ������������� �� ������ ����� ������� ������ ����������� �������.</small></td>
       <td><input name="TRBLOCKOK" type="checkbox" value="1" /><br /></td>
      </tr>
	 </table>
	</td>
   </tr>
   <tr>
    <td align="center"><input type="submit" name="TRANSFERBLOCK" value="�������������!" class="oo" onmouseover="this.className = 'on';" onmouseout="this.className = 'oo';" /></td>
   </tr>
   </form>
  </table>
 </td>
</tr>
