<?php
DEFINE('SCRIPTED BY s!.', 0);
DEFINE('UIN: 1334315', 0);

include_once('../db_config.php');
include_once('../db.php');
include_once('../classes/ChatSendMessages.php');



$msg = Array(
'������ ���� - Time Of Wars',
'������� ����� � ���� Messengers Of God , ����������� � ������: Templar',
'��������� ������������! ������ ������� Time Of Wars , ����� ��������� ���: <a href="http://www.timeofwars.lv/forum/index.php?viewtopic=36" target="_blank">�������</a> ',
'��������� ������������! ������������� ������� ������ �������� �� ICQ: 611867459 , Skype: albanchix , ������ ������ !',
'��������� ������������! ��� ������������� ����� ���� ���������� , ����������� � ������������� , ��� ������� ������������ ��� ������ �� ������. �� � �������� ������� ��� !',
);

shuffle($msg);

$files = scandir($db_config[DREAM]['web_root'].'/chat');
foreach($files as $file){


if (preg_match("/.txt/i", $file)) {

$file = str_replace( '.txt', '', $file );


$chat = new ChatSendMessages('����������', $file);
$chat->sendMessage( '����������', '<b> '.current($msg).' </b>' );


}



}

?>
