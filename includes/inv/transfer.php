<?
if (!empty($_GET['give']) && is_numeric($_GET['give']) && !empty($_GET['whom'])) {

if($woodc){ $err = '�� ������� ������ ������� ����'; }
elseif($turnir_id){ $err = '�� ������� ������ ��������.'; }
else{

list($locktime) = $db->queryCheck("SELECT locktime FROM `".SQL_PREFIX."lock` WHERE Username = '$player->username'");
if($locktime > time()){ $err = '�� ������������� ���� �������� ����. �������� �����.'; }
else{

if(!empty($locktime) && (time() >= $locktime) ){ $db->execQuery("DELETE FROM `".SQL_PREFIX."lock` WHERE Username = '$player->username'"); }

@$whom_to         = speek_to_view($_GET['whom']);
@$_GET['give']    = intval($_GET['give']);
@$_GET['surtext'] = speek_to_view($_GET['surtext']);

if ( trim(strtolower($whom_to)) == strtolower($player->username) ) { $err = '����������� =)'; }
elseif( !list($to, $level) = $db->queryCheck("SELECT Username, Level FROM ".SQL_PREFIX."players WHERE Username = '$whom_to'") ) { $err = '������ � ������ ������� �� ����������';  }
elseif( !list($Thing_Name, $Un_Id) = $db->queryCheck("SELECT Thing_Name, Un_Id FROM ".SQL_PREFIX."things WHERE (Owner = '$player->username') AND (Un_Id = '{$_GET['give']}') AND (Slot < '50')") ){ $err = '�� �� ������ ������ ����'; }
elseif($player->Money < 0.5){ $err = '� ��� ������������ �������� ��� ��������'; }
elseif($level < 5 && $player->clanid != 255 && $player->clanid != 50) { $err = '�� �� ������ �������� ���-���� � ���������� ������ 5-�� ������'; }
elseif($player->clanid == 200) { $err = '������ ������ ����������, ���� �� ��� ���������'; }
elseif (preg_match ('/�������/i', $Thing_Name) ) { $err = '������� ���� ������ ��������'; }
else {

if ( list($ip) = $db->queryCheck("SELECT Ip FROM `".SQL_PREFIX."ip` WHERE Username = '$whom_to' ") ) { $targetip = $ip; }

$multstr1 = ''; $multstr2 = '';

if ($targetip == $LastIP){ $multstr1 = '<font color="red">'; $multstr2 = '</font>'; }

$db->update( SQL_PREFIX.'players',  Array( 'Money' => '[-]0.5' ), Array( 'Username' => $player->username ), 'maths' );
$db->update( SQL_PREFIX.'things',   Array( 'Owner' => $whom_to ), Array( 'Un_Id' => $Un_Id ) );
$db->insert( SQL_PREFIX.'transfer', Array( 'Date' => date('Y-m-d'), 'From' => $player->username, 'To' => $whom_to, 'What' => $multstr1.'������� '.$Thing_Name.', ���������� ID '.$Un_Id.' ('.date('H:i').'). ��������� � ��������: '.$_GET['surtext'].$multstr2 ) );
$db->insert( SQL_PREFIX.'messages', Array( 'Username' => $whom_to, 'Text' => '<b>'.$player->username.'</b> ������� ��� <b>'.$Thing_Name.'</b> � ����������: '.$_GET['surtext'] ) );

$err = '������ ������� ������� � '.$whom_to;

}

}

//�������� �� ���
}
//�����
}
?>
