<? if(!empty($part3)): ?>
<? foreach($part3 as $v): ?>
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
		 <table height="5px"  border="0" cellpadding="0" cellspacing="0" title="�������������" width="<?=$vesh;?>%">
		  <tr>
		   <td background="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/fbis.jpg"></td>
          </tr>
         </table>
	    </td>
	   </tr>
	   <tr>
<? if ($v['MagicID'] == '����� ������'): ?>
        <td><a href="JavaScript:usestats('<?=$v['Un_Id'];?>')"><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/use.gif" title="������������ ����" /></a></td>
<? elseif ($v['MagicID'] == '����� ����� ������'): ?>
        <td><a href="JavaScript:usestats2('<?=$v['Un_Id'];?>')"><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/use.gif" title="������������ ����" /></a></td>
<? elseif ($v['MagicID'] == '�������'): ?>
        <td><a href="JavaScript:uselech('<?=$v['Un_Id'];?>')"><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/use.gif" title="������������ ����" /></a></td>
<? elseif ($v['MagicID'] == '�����������'): ?>
        <td><a href="JavaScript:usesvitok1('<?=$v['Un_Id'];?>')"><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/use.gif" title="������������ ����" /></a></td>
<? elseif ($v['MagicID'] == '���������'): ?>
        <td><a href="JavaScript:usesvitok2('<?=$v['Un_Id'];?>')"><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/use.gif" title="������������ ����" /></a></td>
<? elseif ($v['MagicID'] == '�������'): ?>
        <td><a href="inv.php?use=<?=$v['Un_Id'];?>&part=<?=$part;?>"><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/use.gif" title="������������ ����" /></a></td>
<? elseif ($v['MagicID'] == '������ ������������ ��������'): ?>
       <td><a href="inv.php?use_recept=<?=$v['Un_Id'];?>&part=<?=$part;?>"><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/use.gif" title="������������ ����" /></a></td>
<? elseif ($v['MagicID'] == '���. �����������'): ?>
       <td><a href="inv.php?use_elik=<?=$v['Un_Id'];?>&part=<?=$part;?>"><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/use.gif" title="������������ ����" /></a></td>
<? else:  ?>
        <td><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/unuse.gif" title="���������� ������������" /></td>
<? endif; ?>
	    <td><a href="?lock=<?=$v['Un_Id'];?>&part=<?=$part;?>"><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/lock.gif" title="������ � ������" /></a></td>
<? if( $v['Slot'] == '15' && $v['Id'] != 'room_key' && !preg_match ('/�������/i', $v['Thing_Name']) ): ?>
	    <td><a href="JavaScript:givetravu('<?=$v['Un_Id'];?>')"><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/give.gif" title="�������� ����" /></a></td>
<? else:  ?>
	    <td><a href="JavaScript:give('<?=$v['Un_Id'];?>')"><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/give.gif" title="�������� ����" /></a></td>
<? endif; ?>
		<td><a style="cursor:hand" onclick="if (confirm('��������! ������� <?=$v['Thing_Name'];?> ����� ������������ ������. ������� ����������?')) window.navigate('?drop=<?=$v['Un_Id'];?>&part=<?=$part;?>')"><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/drop.gif" title="��������� ����" /></a></td>
	   </tr>
	  </table>
	 </td>
	 <td align="center">
	  <center>
	   <a href="thing.php?thing=<?=$v['Un_Id'];?>" target="_blank"><?=$v['Thing_Name'];?></a> <? if ($v['Clan_need']): ?> <img src="http://<?=$db_config[DREAM_IMAGES][server];?>/clan/<?=$v['Clan_need'];?>.gif" /> <? endif; ?><br />
	   ����: <?=$v['Cost'];?> ��. �����: <?=$v['NOWwear'];?>/<?=$v['MAXwear'];?>. ����� <?=$v['Un_Id'];?> <? if ($v['Count']): print '<br />����������: '.$v['Count']; endif;?>
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
<? if ($v['MagicID'] == '����� ������'): ?>
        <td><a href="JavaScript:usestats('<?=$v['Un_Id'];?>')"><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/use.gif" title="������������ ����" /></a></td>
<? elseif ($v['MagicID'] == '����� ����� ������'): ?>
        <td><a href="JavaScript:usestats2('<?=$v['Un_Id'];?>')"><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/use.gif" title="������������ ����" /></a></td>
<? elseif ($v['MagicID'] == '�������'): ?>
        <td><a href="JavaScript:uselech('<?=$v['Un_Id'];?>')"><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/use.gif" title="������������ ����" /></a></td>
<? elseif ($v['MagicID'] == '�����������'): ?>
        <td><a href="JavaScript:usesvitok1('<?=$v['Un_Id'];?>')"><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/use.gif" title="������������ ����" /></a></td>
<? elseif ($v['MagicID'] == '���������'): ?>
        <td><a href="JavaScript:usesvitok2('<?=$v['Un_Id'];?>')"><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/use.gif" title="������������ ����" /></a></td>
<? elseif ($v['MagicID'] == '�������'): ?>
        <td><a href="inv.php?use=<?=$v['Un_Id'];?>&part=<?=$part;?>"><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/use.gif" title="������������ ����" /></a></td>
<? elseif ($v['MagicID'] == '������ ������������ ��������'): ?>
       <td><a href="inv.php?use_recept=<?=$v['Un_Id'];?>&part=<?=$part;?>"><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/use.gif" title="������������ ����" /></a></td>
<? elseif ($v['MagicID'] == '���. �����������'): ?>
       <td><a href="inv.php?use_elik=<?=$v['Un_Id'];?>&part=<?=$part;?>"><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/use.gif" title="������������ ����" /></a></td>
<? else:  ?>
        <td><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/unuse.gif" title="���������� ������������" /></td>
<? endif; ?>
	    <td><a href="?lock=<?=$v['Un_Id'];?>&part=<?=$part;?>"><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/lock.gif" title="������ � ������" /></a></td>
<? if( $v['Slot'] == '15' && $v['Id'] != 'room_key' && !preg_match ('/�������/i', $v['Thing_Name']) ): ?>
	    <td><a href="JavaScript:givetravu('<?=$v['Un_Id'];?>')"><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/give.gif" title="�������� ����" /></a></td>
<? else:  ?>
	    <td><a href="JavaScript:give('<?=$v['Un_Id'];?>')"><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/give.gif" title="�������� ����" /></a></td>
<? endif; ?>
        <td><a style="cursor:hand" onclick="if (confirm('��������! ������� <?=$v['Thing_Name'];?> ����� ������������ ������. ������� ����������?')) window.navigate('?drop=<?=$v['Un_Id'];?>&part=<?=$part;?>')"><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/drop.gif" title="��������� ����" /></a></td>
	   </tr>
	  </table>
	 </td>
<? if($a%6 == 0): echo '</tr><tr>'; endif; ?>
<? endif; ?>
<? endforeach; ?>
  </td>
 </tr>
<? else: ?>
 <tr>
  <td align="center"><b>������ ������ ����</b></td>
 </tr>
</table>
<? endif; ?>
