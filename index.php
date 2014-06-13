<?
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

require 'db.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru">
<head>
	<meta http-equiv="content-type" content="text/html; charset=windows-1251" />
	<title>Онлайн игра Time Of Wars</title>
    <link rel="stylesheet" type="text/css" href="http://admin.dnlab.ru/css/index2.css" />
	<!--[if IE 6 or 7]>
	  <link rel="stylesheet" href="iepngfix/ie6.css" media="all" />
	  <script type="text/javascript" src="iepngfix/iepngfix_tilebg.js"></script>
	<![endif]-->
    <script language="JavaScript" type="text/JavaScript" src="http://admin.dnlab.ru/js/preloader.js"></script>
</head>
<body onLoad="MM_preloadImages( 'http://admin.dnlab.ru/images/-index/buttons/register_2.png', 'http://admin.dnlab.ru/images/-index/buttons/vosstan_2.png', 'http://admin.dnlab.ru/images/-index/buttons/log_in_2.png', 'http://admin.dnlab.ru/images/-index/buttons/reit_2.png', 'http://admin.dnlab.ru/images/-index/buttons/forum_2.png',  'http://admin.dnlab.ru/images/-index/buttons/faq_2.png' )">


 <div id="header">
 <table width="*" height="100%" cellpadding="0" cellspacing="0" align="center">
  <tr>
   <td><img src="http://admin.dnlab.ru/images/-index/header/_header_01.jpg" /></td>
   <td><img src="http://admin.dnlab.ru/images/-index/header/_header_02.jpg" /></td>
   <td><img src="http://admin.dnlab.ru/images/-index/header/_header_03.jpg" /></td>
  </tr>
  <tr>
   <td><img src="http://admin.dnlab.ru/images/-index/header/_header_04.jpg" /></td>
   <td><img src="http://admin.dnlab.ru/images/-index/header/_header_05.jpg" /></td>
   <td><img src="http://admin.dnlab.ru/images/-index/header/_header_06.jpg" /></td>
  </tr>
  <tr>
   <td align="right"><img src="http://admin.dnlab.ru/images/-index/header/_header_08.jpg" /></td>
   <td><img src="http://admin.dnlab.ru/images/-index/header/_header_09.jpg" /></td>
   <td><img src="http://admin.dnlab.ru/images/-index/header/_header_10.jpg" /></td>
  </tr>
 </table>
</div>
<form method="POST" action="enter.php" id="myform">
 <div class="red">
     <div class="buttons">
       <a href="top5.html" title="top5" target="_blank" onMouseOut="MM_swapImgRestore2()" onMouseOver="MM_swapImage2('img4', '', 'http://admin.dnlab.ru/images/-index/buttons/reit_2.png', 1)"><img src="http://admin.dnlab.ru/images/-index/buttons/reit.png" id="img4" class="png" /></a><a href="forum/" title="forum" target="_blank" onMouseOut="MM_swapImgRestore2()" onMouseOver="MM_swapImage2('img5', '', 'http://admin.dnlab.ru/images/-index/buttons/forum_2.png', 1)"><img src="http://admin.dnlab.ru/images/-index/buttons/forum.png" id="img5" /></a><a href="encicl/index.html" title="FAQ" target="_blank" onMouseOut="MM_swapImgRestore2()" onMouseOver="MM_swapImage2('img6', '', 'http://admin.dnlab.ru/images/-index/buttons/faq_2.png', 1)"><img src="http://admin.dnlab.ru/images/-index/buttons/faq.png" id="img6" /></a>
     </div>
 </div>

 <div class="red_content">
   <div class="logo">&nbsp;</div>
 </div>

 <div class="red_content">
   <div class="login"><input type="text" title="user login" value="<?=$_COOKIE['login_auth'];?>" name="login_auth" maxlength="30" class="login_btn" /></div>
   <div class="password"><input type="password" title="user password" value="" name="password" class="pass_btn" /></div>
 </div>

 <div class="brown">&nbsp;</div>
 <div class="timeofwars">&nbsp;</div>
 <div class="log_reg" onclick="javascript:document.forms[0].submit();" id="img3" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('img3', 'http://admin.dnlab.ru/images/-index/buttons/log_in.png', 'http://admin.dnlab.ru/images/-index/buttons/log_in_2.png', 1)">&nbsp;</div>
</form>
 <div class="register" title="register" onclick="window.location.href='register.php'" id="img1" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('img1', 'http://admin.dnlab.ru/images/-index/buttons/register.png', 'http://admin.dnlab.ru/images/-index/buttons/register_2.png', 1)">&nbsp;</div>
 <div class="remind" _href="send_password.php" onClick="showMsg(this.getAttribute('_href'),'Напоминание пароля', 480, 280);return false;" title="have forgotten password" id="img2" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('img2', 'http://admin.dnlab.ru/images/-index/buttons/vosstan.png', 'http://admin.dnlab.ru/images/-index/buttons/vosstan_2.png', 1)">&nbsp;</div>
 <div id="content">
<h1>Онлайн игра Time Of Wars</h1>
<br>
&nbsp;&nbsp;&nbsp;&nbsp;Развлечения. Как большое количество изредка приятных мгновений и мемуаров встает у нас при одном данном слове. Развлекаются все: слишком взрослые и ребята, мужика и представительницы хилого пола, изредка серьезные бизнесмены и вчерашние подростки. Погремушки и конструкторы, шахматы и домино, преферанс и бильярд – времена и облики имеют все шансы иметься иногда разными, хотя высокий результат 1, полученное потрясающе огромное большое удовольствие . Развлекаясь, совершенный ребенок познает безграничный мир , подросток обучается жизни и отношениям, а иногда взрослый отдыхает и расслабляется. Поход в кинотеатр, вечер в театре или же ночном клубе – труднодостижимое, по сегодняшним временам, невероятное событие . А вот встреча с приятелями в сети, выработка великолепно совместных намерений и практически успешное активное взаимодействие в магических мирах – труда не составят!<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;И но великолепно любые достаточно виртуальные миры – не более чем забава, громадное удовольствие они навевают, будто реальное невероятное приключение . Ощущения, испытываемые людьми во жаркое время (и в последствии ), не на удивление просто сравнимы с чувствами, вызываемыми реалом. Это такие же почти самые треволнения. Помогая двухкомнатной квартире торопливо разобраться в хитросплетении фермерских премудростей (и мимоходом обучаясь им собственноручно, в ходе несколько последовательного преодоления значений ), вы получите массу удовольствия не столько от прохождения всех рубежей, ведь и от осознания собственной полезности.<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;Никто не будет в настоящее время своевременно читать при свечах, имея электричество, так как большой прогресс не надо на пространстве, все-таки отчего б не равнодушно использовать его достижения, играя в <strong>игры в Интернете</strong>. Только появившись, в том количестве и немного самые блестяще примитивные иногда <strong>компьютерные игрушки</strong> незамедлительно заинтересовали исключительное внимание людей блестяще разных возрастов. И но сражения категорически против компьютера увлекательна и очень интересная, разрешает хорошенько уйти от повседневности и погрузиться в достаточно новый идеально фантастический безграничный мир , так практически настоящий прорыв в индустрии развлечений случился, если были замечены <strong>браузерные игры.</strong><br><br>
&nbsp;&nbsp;&nbsp;&nbsp;В чем же  эта   неотразимая привлекательность  <strong>онлайн игры</strong>? В  этом  ты  играешь  не с роботом, чьи действия и  действия  подчиняются строго разработанной программе. Ты  играешь  с живым человеком, сидящим за  настолько же  компьютером,  хотя  в  ином   жилище,  ином   мегаполисе   или же  стране. Он  имеет возможность   иметься   абсолютно   совершенно юным   подростком   или же  практически серьезным  бизнесменом, <strong>бесплатная  интернет  игра</strong>  проделывает  предельно равным  всех. Здесь не  исключительно важно , кто ты и сколько тебе лет,  практически главное, что ты умеешь и   будто   играешь. Большинство <strong>online games</strong> - бесплатны и доступны довольно любому   юзеру  Всемирной Паутины, что  разрешает демонстративно играть  в них людям иногда разного  достатка и возраста. Единственные несколько финансовые   солидные затраты ,  коие  ты несешь, играя в <strong>бесплатные игры</strong>, - это подлинно обычная  абонентская  приличная плата   за  неограниченный доступ  в сеть.  <br><br>
&nbsp;&nbsp;&nbsp;&nbsp;На довольно начальном рубеже <strong>игры онлайн</strong> все равны, все приходят с весьма минимальным числом навыков и обмундирования. Абсолютно предельно любой азартный игрок имеет возможность своевременно добиться удачи в <strong>mmorpg</strong>, чтобы достичь желаемого результата до зарезу нужно исключительно максимальное время , сообразительность, сноровка и достаточно стабильный интернет-канал. Ты – безмерно уставший от учебы учащийся ВУза или же замученный работой менеджер? В Других Мирах у тебя появится возможность хорошенько стать варваром или же монахом, рыцарем или же мистиком. Тебе охота примитивно просто совсем расслабиться и подраться? Time Of Wars предоставят эту великая возможность . Ты пытаешься заработать денег, оперативно приобрести грозное оружие и обмундирование? Выполняй квесты, овладевай ремеслом, покоряй особенно новые земли!<br><br>
<br>
<h2 align="right">MMORPG - Time Of Wars</h2>
<div align="center">
<small>Всего жителей: <?=$db->SQL_result($db->query("SELECT COUNT(Id) FROM ".SQL_PREFIX."players;"),0);?>; Новых жителей за сегодня: <?=$db->SQL_result($db->query("SELECT COUNT(Id) FROM ".SQL_PREFIX."players WHERE PersBirthdate LIKE '".date('Y-m-d')."%';"),0);?>; Жителей online: <B><?=$db->SQL_result($db->query("SELECT COUNT(Username) FROM ".SQL_PREFIX."online;"),0);?></B></small>
</div>
 </div>

<? include ('tow_templates/index/footer.html'); ?>
