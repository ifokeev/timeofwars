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
		 <table height="5px"  border="0" cellpadding="0" cellspacing="0" title="Долговечность" width="<?=$vesh;?>%">
		  <tr>
		   <td background="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/fbis.jpg"></td>
          </tr>
         </table>
	    </td>
	   </tr>
	   <tr>
<? if ($v['MagicID'] == 'Сброс статов'): ?>
        <td><a href="JavaScript:usestats('<?=$v['Un_Id'];?>')"><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/use.gif" title="Использовать Вещь" /></a></td>
<? elseif ($v['MagicID'] == 'Сброс своих статов'): ?>
        <td><a href="JavaScript:usestats2('<?=$v['Un_Id'];?>')"><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/use.gif" title="Использовать Вещь" /></a></td>
<? elseif ($v['MagicID'] == 'Лечение'): ?>
        <td><a href="JavaScript:uselech('<?=$v['Un_Id'];?>')"><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/use.gif" title="Использовать Вещь" /></a></td>
<? elseif ($v['MagicID'] == 'Принуждение'): ?>
        <td><a href="JavaScript:usesvitok1('<?=$v['Un_Id'];?>')"><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/use.gif" title="Использовать Вещь" /></a></td>
<? elseif ($v['MagicID'] == 'Нападение'): ?>
        <td><a href="JavaScript:usesvitok2('<?=$v['Un_Id'];?>')"><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/use.gif" title="Использовать Вещь" /></a></td>
<? elseif ($v['MagicID'] == 'Лечение'): ?>
        <td><a href="inv.php?use=<?=$v['Un_Id'];?>&part=<?=$part;?>"><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/use.gif" title="Использовать Вещь" /></a></td>
<? elseif ($v['MagicID'] == 'Рецепт изготовления эликсира'): ?>
       <td><a href="inv.php?use_recept=<?=$v['Un_Id'];?>&part=<?=$part;?>"><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/use.gif" title="Использовать Вещь" /></a></td>
<? elseif ($v['MagicID'] == 'Доп. возможности'): ?>
       <td><a href="inv.php?use_elik=<?=$v['Un_Id'];?>&part=<?=$part;?>"><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/use.gif" title="Использовать Вещь" /></a></td>
<? else:  ?>
        <td><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/unuse.gif" title="Невозможно использовать" /></td>
<? endif; ?>
	    <td><a href="?lock=<?=$v['Un_Id'];?>&part=<?=$part;?>"><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/lock.gif" title="Убрать в рюкзак" /></a></td>
<? if( $v['Slot'] == '15' && $v['Id'] != 'room_key' && !preg_match ('/именная/i', $v['Thing_Name']) ): ?>
	    <td><a href="JavaScript:givetravu('<?=$v['Un_Id'];?>')"><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/give.gif" title="Передать вещь" /></a></td>
<? else:  ?>
	    <td><a href="JavaScript:give('<?=$v['Un_Id'];?>')"><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/give.gif" title="Передать вещь" /></a></td>
<? endif; ?>
		<td><a style="cursor:hand" onclick="if (confirm('ВНИМАНИЕ! Предмет <?=$v['Thing_Name'];?> будет безвозвратно утерян. Желаете продолжить?')) window.navigate('?drop=<?=$v['Un_Id'];?>&part=<?=$part;?>')"><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/drop.gif" title="Выбросить вещь" /></a></td>
	   </tr>
	  </table>
	 </td>
	 <td align="center">
	  <center>
	   <a href="thing.php?thing=<?=$v['Un_Id'];?>" target="_blank"><?=$v['Thing_Name'];?></a> <? if ($v['Clan_need']): ?> <img src="http://<?=$db_config[DREAM_IMAGES][server];?>/clan/<?=$v['Clan_need'];?>.gif" /> <? endif; ?><br />
	   Цена: <?=$v['Cost'];?> кр. Износ: <?=$v['NOWwear'];?>/<?=$v['MAXwear'];?>. Номер <?=$v['Un_Id'];?> <? if ($v['Count']): print '<br />Количество: '.$v['Count']; endif;?>
	  </center>
	  <table width="100%" border="0" cellpadding="1" cellspacing="1">
	   <tr>
	    <td width="50%" valign="top" align="left">
	     <center><b>Требует:</b></center>
	      <small>
           <?
            if ($v['Stre_need']): print '&bull; Сила: '.$v['Stre_need'].'<br />'; endif;
            if ($v['Agil_need']): print '&bull; Ловкость: '.$v['Agil_need'].'<br />'; endif;
            if ($v['Intu_need']): print '&bull; Интуиция: '.$v['Intu_need'].'<br />'; endif;
            if ($v['Endu_need']): print '&bull; Выносливость: '.$v['Endu_need'].'<br />'; endif;
            if ($v['Level_need']): print '&bull; Уровень: '.$v['Level_need'].'<br />'; endif;
           ?>
          </small>
        </td>
	    <td width="50%" valign="top" align="left">
	     <center><b>Дает:</b></center>
	      <small>
           <?
            if ($v['Level_add']): print '&bull; Уровень: +'.$v['Level_add'].'<br />'; endif;
            if ($v['MAXdamage']): print '&bull; Повреждение: '.$v['MINdamage'].' - '.$v['MAXdamage'].'<br />'; endif;
            if ($v['Armor1']): print '&bull; Броня головы: '.$v['Armor1'].'<br />'; endif;
            if ($v['Armor2']): print '&bull; Броня корпуса: '.$v['Armor2'].'<br />'; endif;
            if ($v['Armor3']): print '&bull; Броня пояса: '.$v['Armor3'].'<br />'; endif;
            if ($v['Armor4']): print '&bull; Броня ног: '.$v['Armor4'].'<br />'; endif;
            if ($v['Crit']): print '&bull; Вероятность крита: +'.$v['Crit'].'%<br />'; endif;
            if ($v['Uv']): print '&bull; Вероятность уворота: +'.$v['Uv'].'%<br />'; endif;
            if ($v['AntiCrit']): print '&bull; АнтиКрит: +'.$v['AntiCrit'].'%<br />'; endif;
            if ($v['AntiUv']): print '&bull; АнтиУворот: +'.$v['AntiUv'].'%<br />'; endif;
            if ($v['Stre_add']): print '&bull; Сила: +'.$v['Stre_add'].'<br />'; endif;
            if ($v['Agil_add']): print '&bull; Ловкость: +'.$v['Agil_add'].'<br />'; endif;
            if ($v['Intu_add']): print '&bull; Интуиция: +'.$v['Intu_add'].'<br />'; endif;
            if ($v['Endu_add']): print '&bull; HP: +'.$v['Endu_add'].'<br />'; endif;
            if ($v['MagicID']): print '<br />&bull; <i>Встроена магия</i>: '.$v['MagicID'].'<br />'; endif;
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
	    <td colspan="4" align="center" height="90px"><a href="thing.php?thing=<?=$v['Un_Id'];?>" target="_blank"><img title="<?=$v['Thing_Name'];?> номер <?=$v['Un_Id']."\n";?>
Дает:
<?
if ($v['Count']):     print 'Количество: '.$v['Count']."\n";   endif;
if ($v['Level_add']): print 'Уровень: +'.$v['Level_add']."\n"; endif;
if ($v['MAXdamage']): print 'Повреждение: '.$v['MINdamage'].' - '.$v['MAXdamage']."\n"; endif;
if ($v['Armor1']):    print 'Броня головы: '.$v['Armor1']."\n"; endif;
if ($v['Armor2']):    print 'Броня корпуса: '.$v['Armor2']."\n"; endif;
if ($v['Armor3']):    print 'Броня пояса: '.$v['Armor3']."\n"; endif;
if ($v['Armor4']):    print 'Броня ног: '.$v['Armor4']."\n"; endif;
if ($v['Crit']):      print 'Вероятность крита: +'.$v['Crit'].'%'."\n"; endif;
if ($v['Uv']):        print 'Вероятность уворота: +'.$v['Uv'].'%'."\n"; endif;
if ($v['AntiCrit']):  print 'АнтиКрит: +'.$v['AntiCrit'].'%'."\n"; endif;
if ($v['AntiUv']):    print 'АнтиУворот: +'.$v['AntiUv'].'%'."\n"; endif;
if ($v['Stre_add']):  print 'Сила: +'.$v['Stre_add']."\n"; endif;
if ($v['Agil_add']):  print 'Ловкость: +'.$v['Agil_add']."\n"; endif;
if ($v['Intu_add']):  print 'Интуиция: +'.$v['Intu_add']."\n"; endif;
if ($v['Endu_add']):  print 'HP: +'.$v['Endu_add']."\n"; endif;
if ($v['MagicID']):   print "\n".'Встроена магия: '.$v['MagicID']; endif;
?>
" src="http://<?=$db_config[DREAM_IMAGES][server];?>/<?=$v['Id'];?>.gif" /></a>
        </td>
       </tr>
	   <tr>
	    <td colspan="4">
		 <table height="5px" border="0" cellpadding="0" cellspacing="0" title="Износ <?=$v['NOWwear'];?>/<?=$v['MAXwear'];?>" width="<?=$vesh;?>%">
		  <tr>
		   <td background="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/fbis.jpg"></td>
		  </tr>
		 </table>
		</td>
	   </tr>
	   <tr>
<? if ($v['MagicID'] == 'Сброс статов'): ?>
        <td><a href="JavaScript:usestats('<?=$v['Un_Id'];?>')"><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/use.gif" title="Использовать Вещь" /></a></td>
<? elseif ($v['MagicID'] == 'Сброс своих статов'): ?>
        <td><a href="JavaScript:usestats2('<?=$v['Un_Id'];?>')"><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/use.gif" title="Использовать Вещь" /></a></td>
<? elseif ($v['MagicID'] == 'Лечение'): ?>
        <td><a href="JavaScript:uselech('<?=$v['Un_Id'];?>')"><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/use.gif" title="Использовать Вещь" /></a></td>
<? elseif ($v['MagicID'] == 'Принуждение'): ?>
        <td><a href="JavaScript:usesvitok1('<?=$v['Un_Id'];?>')"><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/use.gif" title="Использовать Вещь" /></a></td>
<? elseif ($v['MagicID'] == 'Нападение'): ?>
        <td><a href="JavaScript:usesvitok2('<?=$v['Un_Id'];?>')"><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/use.gif" title="Использовать Вещь" /></a></td>
<? elseif ($v['MagicID'] == 'Лечение'): ?>
        <td><a href="inv.php?use=<?=$v['Un_Id'];?>&part=<?=$part;?>"><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/use.gif" title="Использовать Вещь" /></a></td>
<? elseif ($v['MagicID'] == 'Рецепт изготовления эликсира'): ?>
       <td><a href="inv.php?use_recept=<?=$v['Un_Id'];?>&part=<?=$part;?>"><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/use.gif" title="Использовать Вещь" /></a></td>
<? elseif ($v['MagicID'] == 'Доп. возможности'): ?>
       <td><a href="inv.php?use_elik=<?=$v['Un_Id'];?>&part=<?=$part;?>"><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/use.gif" title="Использовать Вещь" /></a></td>
<? else:  ?>
        <td><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/unuse.gif" title="Невозможно использовать" /></td>
<? endif; ?>
	    <td><a href="?lock=<?=$v['Un_Id'];?>&part=<?=$part;?>"><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/lock.gif" title="Убрать в рюкзак" /></a></td>
<? if( $v['Slot'] == '15' && $v['Id'] != 'room_key' && !preg_match ('/именная/i', $v['Thing_Name']) ): ?>
	    <td><a href="JavaScript:givetravu('<?=$v['Un_Id'];?>')"><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/give.gif" title="Передать вещь" /></a></td>
<? else:  ?>
	    <td><a href="JavaScript:give('<?=$v['Un_Id'];?>')"><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/give.gif" title="Передать вещь" /></a></td>
<? endif; ?>
        <td><a style="cursor:hand" onclick="if (confirm('ВНИМАНИЕ! Предмет <?=$v['Thing_Name'];?> будет безвозвратно утерян. Желаете продолжить?')) window.navigate('?drop=<?=$v['Un_Id'];?>&part=<?=$part;?>')"><img src="http://<?=$db_config[DREAM_IMAGES][server];?>/adm/drop.gif" title="Выбросить вещь" /></a></td>
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
  <td align="center"><b>Данный раздел пуст</b></td>
 </tr>
</table>
<? endif; ?>
