<? if( (!empty($_GET['act']) && $_GET['act'] == 'razdel') && $ClanID == 255){ ?>
<? if( !empty($_POST['addrazdel']) && !empty($_POST['Name']) && ($_POST['type'] == 'razdel' || $_POST['type'] == 'topic') ){ addNEWrazdel( $_POST['type'], speek_to_view($_POST['Name']), speek_to_view($_POST['About']) ); } ?>
<? if( !empty($_POST['redactrazdel']) && !empty($_POST['Name']) && ($_POST['type'] == 'razdel' || $_POST['type'] == 'topic') ){ UPDATErazdel( $_POST['type'], speek_to_view($_POST['Name']), speek_to_view($_POST['About']), intval($_POST['id']) ); } ?>
<? if( ( !empty($_GET['do']) && $_GET['do'] == 'delit' ) && ( !empty($_GET['id']) && is_numeric($_GET['id']) ) ){  DelRazdel( intval($_GET['id']) ); } ?>
<table width="800px" cellspacing="1" cellpadding="3" border="0" align="center">
    <tr>
      <td class="small">
       &gt;&gt;&nbsp;&nbsp;<a class="norm" href="?adminpanel=1">Админпанель</A>
       ->
       <A class="norm" href="?adminpanel=1&act=razdel">Добавление разделов</A>
      </td>
    </tr>
  </table>

<table class="g" cellspacing="1" cellpadding="3" border="0" align="center" width="800px">
<TR><TD class="bg6 medium">
<br /> <br />
<table cellSpacing="0" cellPadding="0" align="center">
<? if( $_GET['do'] != 'redact' ){ ?>
<? $main = $db->queryArray('SELECT * FROM '.SQL_PREFIX.'mainforum'); ?>
<? if(!empty($main)){ ?>
<? foreach($main as $v){ ?>
  <tr>
    <td align="center" width="150px" nowrap="nowrap">&nbsp;Id: <b><?=$v['id'];?></b>&nbsp; Название: <b><?=$v['name'];?></b></td>
    <td align="center" width="150px">&nbsp;Тип: <b><?=($v['type'] == 'razdel' ? 'Раздел' : 'Форум');?></b></td>
    <td align="center" width="150px"><a href="?adminpanel=1&act=razdel&do=redact&id=<?=$v['id'];?>">Редактировать</a>/<a href="?adminpanel=1&act=razdel&do=delit&id=<?=$v['id'];?>">Удалить</a></td>
  </tr>
<? } ?>
<? } ?>
</table>

<br />

<table cellSpacing="0" cellPadding="0" align="center">
<form method="POST" action="<?=$_SERVER['REQUEST_URI'];?>">
  <tr>
    <td>&nbsp;<select name="type" class="smallb" style="width:150px;"> <option value="razdel">    Раздел    </option> <option value="topic">    Форум     </option> </select>  </td>
    <td>&nbsp;<input type="text" name="Name" style="TEXT-ALIGN: Center" onBlur="if (value == '') {value='Название'}" onFocus="if (value == 'Название') {value =''}" value="Название" class="smallb" style="width:150px;" /> </td>
    <td>&nbsp;<input type="text" name="About" style="TEXT-ALIGN: Center" onBlur="if (value == '') {value='О разделе/форуме'}" onFocus="if (value == 'О разделе/форуме') {value =''}" value="О разделе/форуме" class="smallb" style="width:150px;" /> </td>
  </tr>

  <tr>
    <td></td>
    <td>&nbsp;<input type="submit" name="addrazdel" value="Добавить" class="smallb" style="width:150px;" /></td>
    <td></td>
  </tr>
</form>
</table>

<? } else { ?>
<? if( !$redact = $db->queryRow("SELECT * FROM ".SQL_PREFIX."mainforum WHERE id = '".intval($_GET['id'])."'") ){ die('не найдено'); } ?>

<table cellSpacing="0" cellPadding="0" align="center">
<form method="POST" action="<?=$_SERVER['REQUEST_URI'];?>">
<input type="hidden" name="id" value="<?=$redact['id'];?>">
  <tr>
    <td>&nbsp;<select name="type" class="smallb" style="width:150px;"> <option value="razdel" <?   if($redact['type'] == 'razdel'){    echo 'selected'; }?>>    Раздел    </option> <option value="topic" <?   if($redact['type'] == 'topic'){    echo 'selected="selected"'; }?>>    Форум     </option> </select>  </td>
    <td>&nbsp;<input type="text" name="Name" style="TEXT-ALIGN: Center" onBlur="if (value == '') {value='<?=$redact['name'];?>'}" onFocus="if (value == '<?=$redact['name'];?>') {value =''}" value="<?=$redact['name'];?>" class="smallb" style="width:150px;" /> </td>
    <td>&nbsp;<input type="text" name="About" style="TEXT-ALIGN: Center" onBlur="if (value == '') {value='<?=$redact['about'];?>'}" onFocus="if (value == '<?=$redact['about'];?>') {value =''}" value="<?=$redact['about'];?>" class="smallb" style="width:150px;" /> </td>
  </tr>
  <tr>
    <td></td>
    <td>&nbsp;<input type="submit" name="redactrazdel" value="Редактировать" class="smallb" style="width:150px;" /></td>
    <td></td>
  </tr>
</form>
</table>

<? } ?>
<br /> <br />
</TD>
</TR>
</TABLE>
<br />
<? } elseif( !empty($_GET['redacttopid']) ) { ?>
<? if( !$redact = $db->queryRow("SELECT * FROM ".SQL_PREFIX."topics WHERE id = '".intval($_GET['redacttopid'])."'") ){ die('Не найдено'); }   ?>
<? $name = $db->queryArray("SELECT id, name FROM ".SQL_PREFIX."mainforum WHERE type = 'topic'"); ?>
<? if( !empty($_POST['redacttheme']) && !empty($_POST['type']) && !empty($_POST['Name']) ){ UPDATEtop( $redact['id'], speek_to_view($_POST['Name']), $_POST['type'], (intval($_POST['fix']) != '1' ? '0' : '1'), (intval($_POST['closed']) != '1' ? 'thread.gif' : 'thread_closed.gif') ); } ?>
<table width="800px" cellspacing="1" cellpadding="3" border="0" align="center">
    <tr>
      <td class="small">
       &gt;&gt;&nbsp;&nbsp;<a class="norm" href="?adminpanel=1">Админпанель</A>
       ->
       <a class="norm" href="#">Редактирование тем форума</A>
      </td>
    </tr>
  </table>

<table class="g" cellspacing="1" cellpadding="3" border="0" align="center" width="800px">
<TR><TD class="bg6 medium">
<br /> <br />

<form method="POST" action="<?=$_SERVER['REQUEST_URI'];?>">
<table cellSpacing="0" cellPadding="0" align="center">
  <tr>
    <td align="center" width="150px">Форум:</td>
    <td align="center" width="150px">Название:</td>
    <td align="center" width="150px">Прикреплен?</td>
    <td align="center" width="150px">Закрыт?</td>
  </tr>
  <tr>
    <td align="center">&nbsp;<select name="type" class="smallb" style="width:150px;"><? if(!empty($name)){ ?> <? foreach($name as $v){ ?> <option value="<?=$v['id'];?>" <? if($v['id'] == $redact['id_forum']){    echo 'selected'; }?>>    <?=$v['name'];?>    </option> <? } ?> <? } ?> </select> </td>
    <td align="center">&nbsp;<input type="text" name="Name" style="TEXT-ALIGN: Center" value="<?=$redact['name'];?>" class="smallb" style="width:150px;" /> </td>
    <td align="center">&nbsp;<input name="fix" type="checkbox" value="1" <?=($redact['isfixed'] == 1 ? 'checked="checked"' : '');?> /> </td>
    <td align="center">&nbsp;<input name="closed" type="checkbox" value="1" <?=($redact['type'] == 'thread_closed.gif' ? 'checked="checked"' : '');?> /> </td>
  </tr>
</table>

<table cellSpacing="0" cellPadding="0" align="center">
  <tr>
    <td width="150px"></td>
    <td>&nbsp;<input type="submit" name="redacttheme" value="Редактировать" class="smallb" style="width:150px;" /></td>
    <td width="150px"></td>
  </tr>
</table>
</form>

<br /> <br />
</TD>
</TR>
</TABLE>
<br />
<? } elseif( !empty($_GET['redactPOST']) ) { ?>
<? list($post, $p) = split('/', $_GET['redactPOST']); intval($post); intval($p); ?>
<? if( !$redact = $db->queryRow("SELECT * FROM ".SQL_PREFIX."posts WHERE id = '$post'") ){ die('Не найдено'); }   ?>
<? $dat = $db->queryArray("SELECT id_clan, title FROM ".SQL_PREFIX."clan"); ?>
<? if( !empty($_POST['Post']) && !empty($_POST['submitnew']) ){ UPDATEpost( $redact['topicid'], $p, $redact['id'], $_POST['Post'] ); die;  } ?>
<? $redact['msgtext'] = preg_replace("!(\<small>)(.*?)(\<\/small>)!si", '', $redact['msgtext']); ?>
<table width="800px" cellspacing="1" cellpadding="3" border="0" align="center">
    <tr>
      <td class="small">
       &gt;&gt;&nbsp;&nbsp;<A class="norm" href="?adminpanel=1">Админпанель</A>
       ->
       <A class="norm" href="#">Редактирование ответов пользователей</A>
      </td>
    </tr>
  </table>

<table class="g" cellspacing="1" cellpadding="3" border="0" align="center" width="800px">
<TR><TD class="bg6 medium">
<br /> <br />

<form method="POST" action="<?=$_SERVER['REQUEST_URI'];?>">
     <table class="g" cellspacing="1" cellpadding="3" border="0" align="center" width="800px">
        <tr>
		      <td class="bg4 medium">Отправитель</td>
		    </tr>
		    <tr>
		      <td class="bg6 medium" align="center"><b><?=$redact['Author'];?></b></td>
		    <tr>

		    <tr>
		      <td class="bg4 medium">Кнопки кодов</td>
		    </tr>
		   <tr>
		      <td class="bg6 medium" align="center">

<script type="text/javascript" src="http://<?=$db_config[DREAM]['other'];?>/js/ubbc_ru.js"></script>
<script type="text/javascript" src="http://<?=$db_config[DREAM]['other'];?>/js/translit_only.js"></script>
<script type="text/javascript">
<!--
k=[
<? if(!empty($dat)){ ?>
<? foreach($dat as $v){ ?>
['<?=$v['id_clan'];?>','<?=$v['title'];?>'],
<? } ?>
<? } ?>
]
<? unset($dat, $v); ?>
var flash_w = '200'; var flash_h = '400';
var ubbc_dir = 'http://<?=$db_config[DREAM_IMAGES][server];?>/forum/bbcode';
var use_graphics = 0; // 1 = Graphical, 0 = Form based (buttons)
makeInterface(1,1,use_graphics, 'sql',2,2);
//-->
</script>
<script language="javascript">
<!--
ubbcInit(1,1,use_graphics);
//-->
</script>
		  </td>
		   <tr>
		     <td  class="bg4 medium">Введите сообщение</td>
		   </tr>
		   <tr class="bg6 medium">
		     <td valign="top"  align="center">
		     <textarea id="Post" style="width: 100%; height: 200px" wrap="soft" name="Post" tabindex="3" class="textinput" style="width: 95%" onClick="storeCaret(this); storeBuffer(this);" onkeydown="onescapebutton(event);" onkeypress="encodeCharacter(event);" onKeyup="storeCaret(this); doTranslit(event);" onChange="storeCaret(this);" onFocus="storeCaret(this);"><?=$redact['msgtext'];?></textarea>
</td>
		   </tr>
		 <tr class="bg5 medium">
		  <td align="center" style="text-align:center">

						        <input type="button" name="clear" onclick="res()" value="Очистить" tabindex="5" class="btn" style="width:250px;" />
		        <input type="submit" name="submitnew" value="Редактировать" tabindex="4" class="btn" accesskey="s" style="width:250px;" />
		  </td>
	</tr>
	</table>
	</form>

<br /> <br />
</TD>
</TR>
</TABLE>
<br />
<? } else { ?>
<table width="800px" cellspacing="1" cellpadding="3" border="0" align="center">
    <tr>
      <td class="small">
       &gt;&gt;&nbsp;&nbsp;<A class="norm" href="?adminpanel=1">Админпанель</A>
      </td>
    </tr>
  </table>

<table class="g" cellspacing="1" cellpadding="3" border="0" align="center" width="800px">
<tr><td class="bg6 medium">
<br /> <br /> <h3>Администраторская панель</h3>
  <table cellSpacing="0" cellPadding="0" align="center">
     <tr><td>
      <li><a href="?adminpanel=1&act=razdel">Добавление разделов</a>
     </td></tr>
  </table>
<br /> <br />
</td>
</tr>
</table>
<br />
<? } ?>
