<?
if( list($ip) = $db->queryCheck("SELECT Ip FROM `".SQL_PREFIX."ip` WHERE Username = '$player->username'") ){ $LastIP = $ip; }

if (!empty($_POST['TRANSFER_CR']) && !empty($_POST['TRANSFERSUM']) && !empty($_POST['CRRECIVIER']) ) {

if($woodc){ $err = '�� ������� ������ ������� ����'; }
elseif($turnir_id){ $err = '�� ������� ������ ��������.'; }
else{

@$_POST['TRANSFERSUM'] = floatval($_POST['TRANSFERSUM']);

if($_POST["TRRULE1"] != '1'){ $err = '���������� ����������� � ��������� ���������� � ��������� �������'; }
elseif( trim(strtolower($_POST['CRRECIVIER'])) == strtolower($player->username) ){ $err = '����������� =)'; }
elseif($player->Level < 5){ $err = '�������� �������� ������ � 5-�� ������'; }
elseif( !list($to, $to_money, $level_to) = $db->queryCheck("SELECT Username, Money, Level FROM ".SQL_PREFIX."players WHERE Username = '".speek_to_view($_POST['CRRECIVIER'])."'") ){ $err = '������ � ������ ������� �� ����������'; }
elseif($_POST['TRANSFERSUM'] < '0.01'){ $err = '����������� ����� ��� �������� - 0.01 ��'; }
elseif($_POST['TRANSFERSUM'] > $player->Money){ $err = '�� �� ������ ����������� �����'; }
elseif($level_to < 3 && $player->clanid != 255 && $player->clanid != 50){ $err = '�� �� ������ �������� ���-���� � ���������� ������ 3-�� ������'; }
elseif($player->clanid == 200){ $err = '������ ������ ����������, ���� �� ��� ���������'; }
else{

if ( list($ip) = $db->queryCheck("SELECT Ip FROM `".SQL_PREFIX."ip` WHERE Username = '$to'") ){  $targetip = $ip; }
$multstr1 = ''; $multstr2 = '';

if ($targetip == $LastIP){ $multstr1 = '<font color="red">'; $multstr2 = '</font>'; }

if (is_numeric($_POST['TRANSFERSUM'])) {

@$_POST['TRANSFERSUM'] = floatval($_POST['TRANSFERSUM']);
@$_POST['CMNT'] = speek_to_view($_POST['CMNT']);

$player->Money = round($player->Money,2);
$to_money = round($to_money,2);

$player->Money -= $_POST['TRANSFERSUM'];
$to_money += $_POST['TRANSFERSUM'];

$player->Money = round($player->Money,2);
$to_money = round($to_money,2);

$db->update( SQL_PREFIX.'players', Array( 'Money' => $player->Money ), Array( 'Username' => $player->username ) );
$db->update( SQL_PREFIX.'players', Array( 'Money' => $to_money ), Array( 'Username' => $to ) );

$db->insert( SQL_PREFIX.'transfer', Array( 'Date' => date('Y-m-d'), 'From' => $player->username, 'To' => $to, 'What' => $multstr1.$_POST['TRANSFERSUM'].' �������� � ����������: '.$_POST['CMNT'].' ('.date('H:i').')'.$multstr2 ) );
$db->insert( SQL_PREFIX.'messages', Array( 'Username' => $to, 'Text' => '<b> '.$player->username.' </b> ������� ��� <b> '.$_POST['TRANSFERSUM'].' ��. </b> c ����������: '.$_POST['CMNT'] ) );

$err = '������ �������� '.$_POST['TRANSFERSUM'].' �� � '.$to;

}else{
$db->insert( SQL_PREFIX.'transfer', Array( 'Date' => date('Y-m-d'), 'From' => $player->username, 'To' => $_POST['CRRECIVIER'], 'What' => '������� �������� ������������� �������� � ����� ������. �������� <i>'.$_POST['TRANSFERSUM'].'</i> �������� ('.date('H:i').')' ) );
$err = '������� ������ ���� ��������� � �����';
}

}


//�������� �� ���
}
//�����
}
?>
