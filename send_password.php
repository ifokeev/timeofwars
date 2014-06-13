<?
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

include ('includes/to_view.php');
include ('db.php');

if( !empty($_POST['email']) )
{


if ( strlen($_POST['email']) < 5 )
	$msg = 'Заведомо неверный Email';
elseif ( strlen($_POST['email']) > 40 )
	$msg = 'Слишком длинный Email';
elseif ( $_POST['email'] != addslashes(strip_tags($_POST['email'])) )
	$msg = 'Email содержит недопустимые символы';
elseif ( !preg_match("/.+\@.+\..+/", $_POST['email']) )
	$msg = 'Заведомо неверный Email';
else
{


	$mail = speek_to_view(mysql_real_escape_string($_POST['email']));

	if( !$res = $db->queryCheck("SELECT Username, Email FROM ".SQL_PREFIX."players WHERE Email = '".$mail."'") )
  		$msg  = 'Такого e-mail`a не найдено.';
	else
	{		$pass = make_password(5, 0);

		$ip  =  getenv('HTTP_X_FORWARDED_FOR') ? getenv('HTTP_X_FORWARDED_FOR') : getenv('REMOTE_ADDR') ;

		$m = 'Здраствуйте!';
		$m .= "\n";
		$m .= 'Кто-то с ip-адреса '.$ip.' запросил пароль к персонажу '.$res[0].' он-лайн игры Time OF Wars.';
		$m .= "\n";
		$m .= 'Так как в анкете персонажа '.$res[0].' указан этот e-mail, система выслала ваш новый пароль.';
		$m .= "\n";
		$m .= 'Ваш новый пароль: '.$pass; $m .= "\n\n\n\n";
		$m .= 'Это письмо сгенерировано автоматически , не надо на него отвечать ;)'; $m .= "\n";
		$m .= 'Администрация Time OF Wars.';

		if( @mail($res[1], 'Time OF Wars || http://timeofwars.lv/ . Пароль для персонажа '.$res[0], $m) )
		{			$msg = 'Пароль отправлен.';

			$db->insert( SQL_PREFIX.'remind', Array( 'Username' => $res[0], 'Time' => 'now()' ) );
			$db->update( SQL_PREFIX.'players', Array( 'Password' => $pass ), Array( 'Username' => $res[0] ) );
		}
		else
	    	$msg = 'Пароль отправить не удалось. Обратитесь к администрации (ICQ 611867459).';

	}

}


}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru">
<head>
	<meta http-equiv="content-type" content="text/html; charset=windows-1251" />
	<title>Главная</title>
    <script language="JavaScript" type="text/JavaScript" src="http://<?=$db_config[DREAM]['other'];?>/js/preloader.js"></script>
    <link href="http://<?=$db_config[DREAM]['other'];?>/css/send_password.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body onLoad="MM_preloadImages( 'http://<?=$db_config[DREAM_IMAGES]['server'];?>/pass_send/button_next2.png', 'http://<?=$db_config[DREAM_IMAGES]['server'];?>/pass_send/button_close2.png' )">

  <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr  style="height: 33">
    <td width="19" valign="bottom" align="right"><img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/pass_send/top_left_corner.png" width="44px" height="44px" /></td>
    <td class="tbl-sts_top" align="center" valign="top">&nbsp;</td>
    <td width="19" valign="bottom"><img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/pass_send/top_right_corner.png" width="44px" height="44px" /></td>
    </tr>
    <tr height="100%">
    <td class="left_bg" valign="top">&nbsp;</td>
    <td align="center" valign="middle" >

	       <form method="post">
	         <table>
	          <tr>
	           <td><img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/pass_send/txt.png" width="200px" height="40px" /></td>
	          </tr>
	          <? if( !empty($msg) ): ?>
	          <tr>
	           <td><font color="#cccccc"> <?=$msg;?> </font></td>
	          </tr>
	          <? endif; ?>
	         </table>
	         <table align=center>
	          <col><col width="200">
	          <tr>
	           <td align=center><img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/pass_send/email_txt_button.png" width="330px" height="40px" /><div class="txt_button"><input type="text" value="Введите ваш e-mail" name="email" id="email" onBlur="if (value == '') {value='Введите ваш e-mail'}" onFocus="if (value == 'Введите ваш e-mail') {value = ''}" maxLength="50" /></div></td>
	          </tr>
	          <tr>
	           <td align=center><input type="image" src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/pass_send/button_next.png" id="but_nxt" width="150px" height="36px" onMouseOut="MM_swapImgRestore2()" onMouseOver="MM_swapImage2('but_nxt', '', 'http://<?=$db_config[DREAM_IMAGES]['server'];?>/pass_send/button_next2.png', 1)" onClick="if(document._submit)return false;document._submit=true;" /></td>
	          </tr>
	          <tr>
	           <td align=center><img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/pass_send/button_close.png" id="but_close" onClick="try{top.close()}catch(e){};" width="150px" height="36px" onMouseOut="MM_swapImgRestore2()" onMouseOver="MM_swapImage2('but_close', '', 'http://<?=$db_config[DREAM_IMAGES]['server'];?>/pass_send/button_close2.png', 1)" /></td>
	          </tr>
	         </table>
	       </form>


    </td>
      <td  valign="top"  class="right_bg">&nbsp;</td>
    </tr>
    <tr style="height: 20">
    <td align="right"><img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/pass_send/bottom_left_corner.png" width="44px" height="44px" /></td>
    <td class="tbl-sts_bottom">&nbsp;</td>
    <td><img src="http://<?=$db_config[DREAM_IMAGES]['server'];?>/pass_send/bottom_right_corner.png" width="44px" height="44px" /></td>
    </tr>
  </table>

</body>
</html>