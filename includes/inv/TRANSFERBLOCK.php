<?
if(!empty($_POST['TRANSFERBLOCK'])){

if($woodc){ $err = '�� ������� ������ ������� ����'; }
elseif($turnir_id){ $err = '�� ������� ������ ��������.'; }
else{

if(empty($_POST['BLOCKTIME'])){ $err = '���������� ������� ����� �� ������� ����� ����������� ��������'; }
elseif($_POST['TRBLOCKOK'] != '1'){ $err = '���������� ����������� � ��������� ���������� � ��������� �������'; }
else{

$db->execQuery("INSERT INTO `".SQL_PREFIX."lock` VALUES ('$player->username', '".(time()+$_POST['BLOCKTIME'])."') ON DUPLICATE KEY UPDATE locktime = '".(time()+$_POST['BLOCKTIME'])."'");
$err = '������������� �������.';

}


//�������� �� ���
}

//�����
}
?>
