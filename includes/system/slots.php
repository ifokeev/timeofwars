<?
include_once('db_config.php');
include_once('db.php');

$Slot_name = array('������ ���� ������', '������ ���� ��������', '������ ���� ������', '������ ���� �����', '������ ���� ������', '������ ���� ������', '������ ���� ������', '������ ���� �����', '������ ���� ��������', '������ ���� ���', '������ ���� �����');

for($i=0; $i<11; $i++): $Slot[$i] = 'empt'.$i; endfor;

$Slot_id = $Slot;

/////////////////////////

$thing = $db->queryArray("SELECT Slot, Un_Id, Id, Thing_Name, NOWwear, MAXwear FROM ".SQL_PREFIX."things WHERE (Owner = '$result[0]') AND (Wear_ON = '1') AND (Slot < '11')");

if(!empty($thing)):

foreach($thing as $v):

$i = $v['Slot'];
$Slot_id[$i] = $v['Un_Id'];
$Slot[$i] =  $v['Id'];
$Slot_name[$i] = $v['Thing_Name']."\n(������������� ".$v['NOWwear']."/".$v['MAXwear'].")";

endforeach;

endif;
?>
