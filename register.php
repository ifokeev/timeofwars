<?
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

        session_start();

include ('includes/to_view.php');
include ('db.php');

$ip  =  getenv('HTTP_X_FORWARDED_FOR') ? getenv('HTTP_X_FORWARDED_FOR') : getenv('REMOTE_ADDR') ;
$host = isset ($_SERVER['HTTP_X_FORWARDED_FOR']) ? gethostbyaddr($_SERVER['HTTP_X_FORWARDED_FOR']): gethostbyaddr($_SERVER['REMOTE_ADDR']);

$err = '';

if( !empty($_GET['join']) && is_numeric($_GET['join']) && $_GET['join'] > 0 )
{
    $Id  = @$db->SQL_result($db->query("SELECT Id FROM ".SQL_PREFIX."players WHERE Id = '".intval($_GET['join'])."'"),0,0);
	if( !empty($Id) )
		if( !$db->queryRow("SELECT ip FROM ".SQL_PREFIX."referal WHERE ip = '".$ip."' LIMIT 1;") && !$db->queryRow("SELECT Reg_IP FROM ".SQL_PREFIX."players WHERE Reg_IP = '".$ip."' LIMIT 1;" ) )
		 	setcookie( 'ref', $Id, time()+600 );

}


function parseGoogleAnalyticsCookies(){
$returnMap = array();
$cookieVal = @$_COOKIE["__utmz"];
//now split cookie value by |
$arrPairs = explode('|', $cookieVal);
foreach($arrPairs as $pair){
$pair = explode('=', $pair);
if (sizeof($pair) == 2){
$key = $pair[0];//look for "."
if (strpos($key, ".")){
$key = substr($key, strrpos($key, ".")+1 );
}

$returnMap[$key] = $pair[1];
}
}
return $returnMap;
}

$google = parseGoogleAnalyticsCookies();



if (isset($google['utmcsr'])){
$source = $google['utmcsr'];
}

include("includes/captcha/fsbb.php");

$blocker=new formSpamBotBlocker();

if( !empty($_POST['login_auth'])  )
{

	$nospam = false;
	$nospam = $blocker->checkTags($_POST);
	 if ( !$nospam ) die("Есть подозрение что вы СПАМ-бот. Попробуйте снова.");
	 if( preg_match("/[^a-z,A-Z,0-9,а-я,А-Я,\-,\_]/", $_POST['login_auth']) ) $err = 'Неправильный логин.';
	 elseif( strlen($_POST['login_auth']) < 3 || strlen($_POST['login_auth']) > 12 ) $err = 'Неправильный логин.';
	 elseif( (strlen($_POST['upwd']) < 6 || strlen($_POST['upwd']) > 25) || (strlen($_POST['upwd2']) < 6 || strlen($_POST['upwd2']) > 25) || $_POST['upwd'] != $_POST['upwd2'] ) $err = 'Неправильный пароль.';
	 elseif( strlen($_POST['umail']) < 8 || strlen($_POST['umail']) > 40 || !filter_var($_POST['umail'], FILTER_VALIDATE_EMAIL) ) $err = 'Неправильный емейл.';
	 elseif( $_POST['day'] > 31 || $_POST['day'] <= 0 || $_POST['month'] > 12 || $_POST['month'] <= 0 || $_POST['year'] > 2010 || $_POST['year'] <= 1900 ) $err = 'Неправильная дата.';
	 else
	 {	 	$login    = speek_to_view($_POST['login_auth']);
	 	$email    = speek_to_view($_POST['umail']);
	 	$pass     = speek_to_view($_POST['upwd']);
	 	$oo_sex   = intval($_POST['sex']);
	 	$day      = intval($_POST['day']);
	 	$month    = intval($_POST['month']);
	 	$year     = intval($_POST['year']);

	 	if( $db->queryRow("SELECT Username FROM ".SQL_PREFIX."players WHERE Username = '".$login."'") ){  $err = 'Персонаж с таким логином уже существует'; }
	 	elseif( $db->queryRow("SELECT Email FROM ".SQL_PREFIX."players WHERE Email = '".$email."'") ){  $err = 'Персонаж с таким E-mail адрессом уже существует'; }
	 	//elseif( $db->queryRow("SELECT Id FROM ".SQL_PREFIX."players WHERE Reg_IP = '".$ip."' AND PersBirthdate <= (NOW()-INTERVAL 1 HOUR) LIMIT 1")  ){  $err = 'Регистрация нового персонажа доступна раз в час '; }
	 	else
	 	{	 		if( $oo_sex == 1 )     $sex = 'M';
	 		elseif( $oo_sex == 2 ) $sex = 'F';
	 		if( isset($_COOKIE['ref']) )
	 		{
	 			$ref_id = intval($_COOKIE['ref']);
	 			$db->insert( SQL_PREFIX.'referal',  Array( 'refer_id' => $ref_id, 'ip' => $ip, 'add_time' => time(), 'http_referer' => $source, 'login' => $login  ) );

	 			$Username = @$db->SQL_result($db->query("SELECT Username FROM ".SQL_PREFIX."players WHERE Id = '".$ref_id."'"),0,0);

	 			$db->update( SQL_PREFIX.'players',  Array( 'Money' => '[+]10' ), Array( 'Username' => $Username ), 'maths' );
	 			$db->insert( SQL_PREFIX.'messages', Array( 'Username' => $Username, 'Text' => 'За персонажа, зарегистрировавшегося по вашей ссылке, Вы получаете 10 кр. Продолжайте в том же духе!' ) );
	 			setcookie( 'ref', '' );
	 		}

	 		$sid = rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);

	 		$db->insert( SQL_PREFIX.'players',
	 		Array(
	 		'Username'      => $login,
	 		'Password'      => $pass,
	 		'Email'         => $email,
	 		'Sex'           => $sex,
	 		'Birthdate'     => $day.'.'.$month.'.'.$year,
	 		'PersBirthdate' => 'now()',
	 		'Pict'          => '0',
	 		'Stre'          => '3',
	 		'Agil'          => '3',
	 		'Intu'          => '3',
	 		'Endu'          => '3',
	 		'HPnow'         => '18',
	 		'HPall'         => '18',
	 		'Ups'           => '3',
	 		'Reg_IP'        => $ip,
	 		'Money'         => '50',
	 		'SId'           => $sid
	 		)
	 		);

$db->insert( SQL_PREFIX.'things',
Array(
'Owner'      => $login,
'Thing_Name' => 'Майка новичка (подарок)',
'Id'         => 'foot1',
'Stre_need'  => '3',
'Agil_need'  => '3',
'Intu_need'  => '3',
'Endu_add'   => '3',
'Slot'       => '3',
'Cost'       => '1',
'NOWwear'    => '0',
'MAXwear'    => '25'
)
);


$db->insert( SQL_PREFIX.'messages', Array( 'Username' => $login, 'Text' => '<font color="red">Внимание!</font> Мудрый <a href="http://www.timeofwars.lv/inf.php?uname=Албано" target="_blank"> Admin </a> подарил вам предмет <b> Майка новичка </b>.' ) );
$db->insert( SQL_PREFIX.'messages', Array( 'Username' => $login, 'Text' => '<font color="red">Внимание!</font> Частично ознакомиться с игрой можно <a href="http://timeofwars.lv/encicl/" target="_blank"> тут </a>' ) );
$db->insert( SQL_PREFIX.'messages', Array( 'Username' => $login, 'Text' => '<font color="red">Внимание!</font> За помощью по игровым вопросам обращайтесь к <a href="http://timeofwars.lv/top5.php?show=2" target="_blank"> сотрудникам власти </a>' ) );
$db->insert( SQL_PREFIX.'messages', Array( 'Username' => $login, 'Text' => '<font color="red">Внимание!</font> Вам начислено <b> 50 кр. </b>' ) );
$db->insert( SQL_PREFIX.'messages', Array( 'Username' => $login, 'Text' => '<font color="green">Подсказка:</font> Если вы не нашли соперников на арене, выйдите из города и раскидайте парочку ужасных горгов :) ( <b>Центральная площадь</b> -> <b>Пригород</b> -> <b>Выйти из города</b> )' ) );


            setcookie( 'login_auth', $login, 0x6FFFFFFF);
	 		$err = 'Спасибо за регистрацию. Теперь вы можете <a href="/">авторизоваться.</a>';


	 	}

	 }




}


$blocker->setTimeWindow(2,30); // Called for test reasons. It must be actually set on the target page!
$blocker->setTrap(true,"mail", "Васька такой наркоман"); // if set here (to change the defaults), then set it again with the same name on the target page!
$hiddenTags=$blocker->makeTags(); // create the xhtml string containing the required form elements




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru">
<head>
	<meta http-equiv="content-type" content="text/html; charset=windows-1251" />
	<title>Регистрация</title>
    <script src="http://www.google.com/jsapi"></script>
    <script type="text/javascript">google.load("jquery", "1.3.2");google.setOnLoadCallback(function(){
    	$.getScript("http://<?=$db_config[DREAM]['other'];?>/js/register2.js");


    	});</script>
    <link href="http://<?=$db_config[DREAM]['other'];?>/css/register.css" rel="stylesheet" type="text/css" media="screen" />

</head>
<body>
<form method="POST" id="myform"><?=$hiddenTags; ?>
 <table width="*" height="100%" cellpadding="0" cellspacing="0" align="center">
  <tr>
   <td><img src="http://admin.dnlab.ru/images/register/_reg_01.jpg" /></td>
   <td><img src="http://admin.dnlab.ru/images/register/_reg_02.jpg" /></td>
   <td><img src="http://admin.dnlab.ru/images/register/_reg_03.jpg" /></td>
  </tr>
 </table>
 <table width="*" height="100%" cellpadding="0" cellspacing="0" align="center">
  <tr>
   <td valign="top"><img src="http://admin.dnlab.ru/images/register/_reg_04.jpg" /></td>
   <td align="left" background="http://admin.dnlab.ru/images/register/_reg_05.jpg" width="611px" height="514px" valign="top">
     <table cellpadding="0" cellspacing="0" class="register_table">
      <tr>
       <td align="left" valign="top"><? if( !empty($err) ) echo '<b>'.$err.'</b>';?></td>
       <td width="10px" height="6px" align="left" valign="top"><img src="http://admin.dnlab.ru/images/pix.gif" width="1px" height="1px" /></td>
      </tr>
      <tr>
       <td align="left" valign="top"></td>
       <td width="10px" height="6px" align="left" valign="top"><img src="http://admin.dnlab.ru/images/pix.gif" width="1px" height="1px" /></td>
      </tr>
      <tr>
       <td align="left" valign="top"><span class="style1">E-mail:</span>&nbsp;<div id="umail_err" style="margin:3px;"></div></td>
       <td width="10px" height="6px" align="left" valign="top"><input name="umail" id="umail" class="txt" type="text" maxlength="30" value="" /></td>
      </tr>
      <tr>
       <td align="right" valign="top"></td>
       <td width="10px" height="6px" align="left" valign="top"><img src="http://admin.dnlab.ru/images/pix.gif" width="1px" height="1px" /></td>
      </tr>
      <tr>
       <td colspan="2" align="left" valign="top">
        <table width="430">
         <tr>
          <td>
           <span style="font-size: 7pt;">
            Укажите Ваш адрес электронной почты, который будет необходим для авторизации в игре.<br>Также по этому адресу мы будем связываться с Вами.
           </span>
          </td>
         </tr>
        </table>
       </td>
      </tr>
      <tr>
       <td></td>
       <td width="10px" height="6px" align="left" valign="top"><img src="http://admin.dnlab.ru/images/pix.gif" width="1px" height="1px" /></td>
      </tr>
      <tr>
       <td align="left" valign="top"><span class="style1">Логин:</span>&nbsp;<div id="login_auth_err" style="margin:3px;"></div></td>
       <td width="10px" height="6px" align="left" valign="top"><input name="login_auth" id="login_auth" class="txt" type="text" maxlength="20" value="" />
       </td>
      </tr>
      <tr>
       <td align="right" valign="top"></td>
       <td width="10px" height="6px" align="left" valign="top"><img src="http://admin.dnlab.ru/images/pix.gif" width="1px" height="1px" /></td>
      </tr>
      <tr>
       <td align="right" valign="top"></td>
       <td width="10px" height="6px" align="left" valign="top"><img src="http://admin.dnlab.ru/images/pix.gif" width="1px" height="1px" /></td>
      </tr>
      <tr>
       <td align="left" valign="top"><span class="style1">Пароль:</span>&nbsp;<div id="upwd_err" style="margin:3px;"></div></td>
       <td width="10px" height="6px" align="left" valign="top"><input name="upwd" class="txt" id="upwd" type="password" maxlength="20" value="" />
        </td>
      </tr>
      <tr>
       <td align="right" valign="top"></td>
       <td width="10px" height="6px" align="left" valign="top"><img src="http://admin.dnlab.ru/images/pix.gif" width="1px" height="1px" /></td>
      </tr>
       <tr>
        <td align="right" valign="top"></td>
        <td width="10px" height="6px" align="left" valign="top"><img src="http://admin.dnlab.ru/images/pix.gif" width="1px" height="1px" /></td>
       </tr>
       <tr>
        <td align="left" valign="top"><span class="style1">Повторите пароль:</span>&nbsp;<div id="upwd2_err" style="margin:3px;"></div></td>
        <td width="10px" height="6px" align="left" valign="top"><input name="upwd2" class="txt" id="upwd2" type="password" maxlength="20" value="" />
       </td>
      <tr>
       <td align="right" valign="top"></td>
       <td width="10px" height="6px" align="left" valign="top"><img src="http://admin.dnlab.ru/images/pix.gif" width="1px" height="1px" /></td>
      </tr>
       </tr>
       <tr>
        <td colspan="2" align="left" valign="top">
         <table width="300">
          <tr>
           <td>
            <span style="font-size: 7pt;">
              Не используйте простых паролей.
            </span>
           </td>
          </tr>
         </table>
        </td>
       </tr>
       <tr>
        <td align="right" valign="top"></td>
        <td width="10px" height="6px" align="left" valign="top"><img src="http://admin.dnlab.ru/images/pix.gif" width="1px" height="1px" /></td>
       </tr>
       <tr>
        <td align="left" valign="top"><span class="style1">Ваш пол:</span>&nbsp;<div id="sex_err" style="margin:3px;"></div></td>
        <td width="10px" height="6px" align="left" valign="top"><select name="sex" id="sex" class="txt" onkeyup="check_correct('sex');" onchange="check_correct('sex');" onblue="check_correct('sex');"> <option value="0" selected="selected">-</option><option value="1">мужской</option><option value="2">женский</option></select>
       </td>
       </tr>
       <tr>
        <td align="right" valign="top"></td>
        <td width="10px" height="6px" align="left" valign="top"><img src="http://admin.dnlab.ru/images/pix.gif" width="1px" height="1px" /></td>
       </tr>
       <tr>
        <td align="right" valign="top"></td>
        <td width="10px" height="6px" align="left" valign="top"><img src="http://admin.dnlab.ru/images/pix.gif" width="1px" height="1px" /></td>
       </tr>
       <tr>
        <td align="left" valign="top"><span class="style1">Дата рождения:</span>&nbsp;</td>
        <td width="10px" height="6px" align="left" valign="top">
         <select name="day" id="day" class="txt" style="width:57px;" onkeyup="check_correct('day');" onchange="check_correct('day');" onblue="check_correct('day');">
          <option value="0" selected="selected">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          <option value="7">7</option>
          <option value="8">8</option>
          <option value="9">9</option>
          <option value="10">10</option>
          <option value="11">11</option>
          <option value="12">12</option>
          <option value="13">13</option>
          <option value="14">14</option>
          <option value="15">15</option>
          <option value="16">16</option>
          <option value="17">17</option>
          <option value="18">18</option>
          <option value="19">19</option>
          <option value="20">20</option>
          <option value="21">21</option>
          <option value="22">22</option>
          <option value="23">23</option>
          <option value="24">24</option>
          <option value="25">25</option>
          <option value="26">26</option>
          <option value="27">27</option>
          <option value="28">28</option>
          <option value="29">29</option>
          <option value="30">30</option>
          <option value="31">31</option>
         </select>

         <select name="month" id="month" class="txt" style="width:57px;" onkeyup="check_correct('month');" onchange="check_correct('month');" onblue="check_correct('month');">
          <option value="0" selected="selected">-</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          <option value="7">7</option>
          <option value="8">8</option>
          <option value="9">9</option>
          <option value="10">10</option>
          <option value="11">11</option>
          <option value="12">12</option>
         </select>
         <select name="year" id="year" class="txt" style="width:57px;" onkeyup="check_correct('year');" onchange="check_correct('year');" onblue="check_correct('year');">
          <option value="0" selected="selected">-</option>
          <option value="2005" >2005</option>
          <option value="2004" >2004</option>
          <option value="2003" >2003</option>
          <option value="2002" >2002</option>
          <option value="2001" >2001</option>
          <option value="2000" >2000</option>
          <option value="1999" >1999</option>
          <option value="1998" >1998</option>
          <option value="1997" >1997</option>
          <option value="1996" >1996</option>
          <option value="1995" >1995</option>
          <option value="1994" >1994</option>
          <option value="1993" >1993</option>
          <option value="1992" >1992</option>
          <option value="1991" >1991</option>
          <option value="1990" >1990</option>
          <option value="1989" >1989</option>
          <option value="1988" >1988</option>
          <option value="1987" >1987</option>
          <option value="1986" >1986</option>
          <option value="1985" >1985</option>
          <option value="1984" >1984</option>
          <option value="1983" >1983</option>
          <option value="1982" >1982</option>
          <option value="1981" >1981</option>
          <option value="1980" >1980</option>
          <option value="1979" >1979</option>
          <option value="1978" >1978</option>
          <option value="1977" >1977</option>
          <option value="1976" >1976</option>
          <option value="1975" >1975</option>
          <option value="1974" >1974</option>
          <option value="1973" >1973</option>
          <option value="1972" >1972</option>
          <option value="1971" >1971</option>
          <option value="1970" >1970</option>
          <option value="1969" >1969</option>
          <option value="1968" >1968</option>
          <option value="1967" >1967</option>
          <option value="1966" >1966</option>
          <option value="1965" >1965</option>
          <option value="1964" >1964</option>
          <option value="1963" >1963</option>
          <option value="1962" >1962</option>
          <option value="1961" >1961</option>
          <option value="1960" >1960</option>
          <option value="1959" >1959</option>
          <option value="1958" >1958</option>
          <option value="1957" >1957</option>
          <option value="1956" >1956</option>
          <option value="1955" >1955</option>
          <option value="1954" >1954</option>
          <option value="1953" >1953</option>
          <option value="1952" >1952</option>
          <option value="1951" >1951</option>
          <option value="1950" >1950</option>
         </select>
         <div id="day_err" style="margin:3px;"></div>
         <div id="month_err" style="margin:3px;"></div>
         <div id="year_err" style="margin:3px;"></div>
        </td>
       </tr>

       <tr>
        <td align="right" valign="top"></td>
        <td width="10px" height="6px" align="left" valign="top"><img src="http://admin.dnlab.ru/images/pix.gif" width="1px" height="1px" /></td>
       </tr>
       <tr>
        <td align="right" valign="top"></td>
        <td width="10px" height="6px" align="left" valign="top"><img src="http://admin.dnlab.ru/images/pix.gif" width="1px" height="1px" /></td>
       </tr>
      <tr>
       <td colspan="2" align="left" valign="top">
        <table width="430">
         <tr>
          <td>
           <span style="font-size: 7pt;">
            Нажимая кнопку "Далее", вы полностью соглашаетесь с <a href="encicl/rules.html" target="_blank">законами</a> игры.
           </span>
          </td>
         </tr>
        </table>
       </td>
      </tr>
     <tr>
      <td></td>
      <td width="10px" height="6px" align="left" valign="top"><img src="http://admin.dnlab.ru/images/pix.gif" width="1px" height="1px" /></td>
     </tr>
    </table>
   </td>
   <td valign="top"><img src="http://admin.dnlab.ru/images/register/_reg_06.jpg" /></td>
  </tr>
  <tr>
   <td valign="top"><img src="http://admin.dnlab.ru/images/register/_reg_07.jpg" /></td>
   <td align="center" valign="top" background="http://admin.dnlab.ru/images/register/_reg_08.jpg"><img src="http://admin.dnlab.ru/images/register/button.png" name="register_pls" id="register_pls" width="127px" height="26px" /></td>
   <td valign="top"><img src="http://admin.dnlab.ru/images/register/_reg_09.jpg" /></td>
  </tr>
 </table>
</form>
<? include ('tow_templates/index/footer.html'); ?>