<?php
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" id="vkontakte">
<head>

<meta http-equiv="content-type" content="text/html; charset=windows-1251" />
<title>Timeofwars | Переход по внешней ссылке</title>
</head>
<body  style="padding:20px 180px; font-size:12px; font-family:Tahoma; line-height:200%">
<h2>Timeofwars | Переход по внешней ссылке</h2>

Вы покидаете сайт "Время войн" по внешней ссылке <b><?=$_GET['to'];?></b>, предоставленной одним из игроков. <br/>
Администрация "Время войн" не несет ответственности за содержимое сайта <b></b> и настоятельно рекомендует <b>не указывать</b> никаких своих данных, имеющих отношение к "Время войн" (особенно <b>e-mail</b>, <b>пароль</b> и <b>cookies</b>), на сторонних сайтах. <br/><br/>
Кроме того, сайт <b></b> может содержать вирусы, трояны и другие вредоносные программы, опасные для Вашего компьютера. <br/>
Если у Вас нет серьезных оснований доверять этому сайту, лучше всего на него не переходить, даже если Вы якобы получили эту ссылку от одного из Ваших друзей. <br/><br/>
Если Вы еще не передумали, нажмите на <a href="<?=$_GET['to'];?>" id="page"><?=$_GET['to'];?></a>. <br/>
Если Вы не хотите рисковать безопасностью Вашего аккаунта и компьютера, нажмите <a href="javascript:window.close()">отмена</a>.
</body>
</html>