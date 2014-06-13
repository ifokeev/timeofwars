<?php
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

include_once('../db_config.php');
include_once('../db.php');
include_once('../classes/ChatSendMessages.php');



$msg = Array(
'Онлайн Игра - Time Of Wars',
'Ведется набор в клан Messengers Of God , подробности в приват: Templar',
'Уважаемые пользователи! Свежие Новости Time Of Wars , можно прочитать тут: <a href="http://www.timeofwars.lv/forum/index.php?viewtopic=36" target="_blank">Новости</a> ',
'Уважаемые пользователи! Администрация проекта всегда доступна по ICQ: 611867459 , Skype: albanchix , Приват Албано !',
'Уважаемые пользователи! При возникновении каких либо неясностей , обращайтесь к Администрации , или задайте интересующий вас вопрос на Форуме. Мы с радостью поможем вам !',
);

shuffle($msg);

$files = scandir($db_config[DREAM]['web_root'].'/chat');
foreach($files as $file){


if (preg_match("/.txt/i", $file)) {

$file = str_replace( '.txt', '', $file );


$chat = new ChatSendMessages('Информация', $file);
$chat->sendMessage( 'Информация', '<b> '.current($msg).' </b>' );


}



}

?>
