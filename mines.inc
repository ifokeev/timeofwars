<?
$maxcheats=200;//����� ������ ���������� ����� �� ������� �� � �������, �� � ������
$needintel=0;//��������� ��� ����� � ������� � �����
$needsmithagil=10;//�������� ��� ����� � �������
$needminesint=10;//�������� ��� ����� � ������
$needlevel=5;//������� ����������� ��� ����� � ����� � �������
//��� �������� �����
//�����
$allcount=100;
$winpercent=10;
$diepercent=50;
$magicName="�����";

//����
$baseexp = 450;//��� ������� ������
$multexp = 2.3;//������������ ��� ������ ������
$smithFailureFactor = 10; // ������� ���������� ��� �������
$multsmith=700;//������������ ��� ���������� ������������� � �����������
//$multsmith=rand(50, 300);//������������ ��� ���������� ������������� � �����������
$levelpercent[0][0]=75;
$levelpercent[0][1]=24;
$levelpercent[0][2]=1;
$levelpercent[1][0]=74;
$levelpercent[1][1]=25;
$levelpercent[1][2]=1;
$levelpercent[2][0]=73;
$levelpercent[2][1]=26;
$levelpercent[2][2]=1;
$levelpercent[3][0]=72;
$levelpercent[3][1]=27;
$levelpercent[3][2]=1;
$levelpercent[4][0]=71;
$levelpercent[4][1]=28;
$levelpercent[4][2]=1;
$levelpercent[5][0]=70;
$levelpercent[5][1]=29;
$levelpercent[5][2]=1;
$levelpercent[6][0]=69;
$levelpercent[6][1]=29;
$levelpercent[6][2]=2;
$levelpercent[7][0]=68;
$levelpercent[7][1]=30;
$levelpercent[7][2]=2;
$levelpercent[8][0]=67;
$levelpercent[8][1]=31;
$levelpercent[8][2]=2;
$levelpercent[9][0]=66;
$levelpercent[9][1]=32;
$levelpercent[9][2]=2;
$levelpercent[10][0]=66;
$levelpercent[10][1]=33;
$levelpercent[10][2]=2;
$levelpercent[11][0]=65;
$levelpercent[11][1]=33;
$levelpercent[11][2]=2;
//����
$rudacount=3;
$ruda_id[0]='trash';
$ruda_name[0]='�����';
$ruda_exp[0]=1;

$ruda_id[1]='iron';
$ruda_name[1]='������';
$ruda_exp[1]=10;

$ruda_id[2]='gold';
$ruda_name[2]='������';
$ruda_exp[2]=20;

//////////////
$ruda_give[0]=0;
$ruda_get[0]=5;
$ruda_repair[0]=1;

$ruda_give[1]=5;
$ruda_get[1]=10;
$ruda_repair[1]=10;

$ruda_give[2]=10;
$ruda_get[2]=15;
$ruda_repair[2]=100;
///////////////////

$ruda_baseprice=0.05;

//��������
$losepercent=100-$diepercent-$winpercent;

$wincount=(int) $winpercent*$allcount/100;
if( !($wincount) ){
	$wincount=1;
}

$diecount=(int) $diepercent*$allcount/100;
if( !($diecount) ){
	$diecount=1;
}
$losecount=$allcount-$diecount-$wincount;
//������� �� ���������� ��� ��� �����
$price["str"]=50;
$price["agil"]=50;
$price["intu"]=50;
$price["endu"]=20;
$price["level"]=50;
$price["crit"]=30;
$price["acrit"]=30;
$price["uv"]=30;
$price["auv"]=30;
$price["arm1"]=10;
$price["arm2"]=10;
$price["arm3"]=10;
$price["arm4"]=10;
$price["maxdmg"]=10;
$price["mindmg"]=10;
//
$thing_tpl[1]["name"]="��� �������";
$thing_tpl[1]["level"]=0;
$thing_tpl[1]["image"]="smith_sw1";
$thing_tpl[1]["slot"]=2;
$thing_tpl[2]["name"]="��� �����";
$thing_tpl[2]["level"]=3;
$thing_tpl[2]["image"]="smith_sw2";
$thing_tpl[2]["slot"]=2;
$thing_tpl[3]["name"]="��� ��������";
$thing_tpl[3]["level"]=5;
$thing_tpl[3]["image"]="smith_sw3";
$thing_tpl[3]["slot"]=2;
$thing_tpl[4]["name"]="��� �������";
$thing_tpl[4]["level"]=1;
$thing_tpl[4]["image"]="smith_sh1";
$thing_tpl[4]["slot"]=9;
$thing_tpl[5]["name"]="��� �����";
$thing_tpl[5]["level"]=2;
$thing_tpl[5]["image"]="smith_sh2";
$thing_tpl[5]["slot"]=9;
$thing_tpl[6]["name"]="��� ��������";
$thing_tpl[6]["level"]=6;
$thing_tpl[6]["image"]="smith_sh3";
$thing_tpl[6]["slot"]=9;
$thing_tpl[7]["name"]="������ �������";
$thing_tpl[7]["level"]=1;
$thing_tpl[7]["image"]="smith_shoes1";
$thing_tpl[7]["slot"]=10;
$thing_tpl[8]["name"]="������ �����";
$thing_tpl[8]["level"]=2;
$thing_tpl[8]["image"]="smith_shoes2";
$thing_tpl[8]["slot"]=10;
$thing_tpl[9]["name"]="������ ��������";
$thing_tpl[9]["level"]=6;
$thing_tpl[9]["image"]="smith_shoes3";
$thing_tpl[9]["slot"]=10;
$thing_tpl[10]["name"]="���� �������";
$thing_tpl[10]["level"]=1;
$thing_tpl[10]["image"]="smith_helm1";
$thing_tpl[10]["slot"]=7;
$thing_tpl[11]["name"]="���� �����";
$thing_tpl[11]["level"]=3;
$thing_tpl[11]["image"]="smith_helm2";
$thing_tpl[11]["slot"]=7;
$thing_tpl[12]["name"]="���� ��������";
$thing_tpl[12]["level"]=7;
$thing_tpl[12]["image"]="smith_helm3";
$thing_tpl[12]["slot"]=7;
$thing_tpl[13]["name"]="������ �������";
$thing_tpl[13]["level"]=2;
$thing_tpl[13]["image"]="smith_kulon1";
$thing_tpl[13]["slot"]=1;
$thing_tpl[14]["name"]="������ �����";
$thing_tpl[14]["level"]=4;
$thing_tpl[14]["image"]="smith_kulon2";
$thing_tpl[14]["slot"]=1;
$thing_tpl[15]["name"]="�������� ��������";
$thing_tpl[15]["level"]=5;
$thing_tpl[15]["image"]="smith_kulon3";
$thing_tpl[15]["slot"]=1;
$thing_tpl[16]["name"]="������ �������";
$thing_tpl[16]["level"]=2;
$thing_tpl[16]["image"]="smith_ring1";
$thing_tpl[16]["slot"]=4;
$thing_tpl[17]["name"]="������ �����";
$thing_tpl[17]["level"]=4;
$thing_tpl[17]["image"]="smith_ring2";
$thing_tpl[17]["slot"]=4;
$thing_tpl[18]["name"]="������ ��������";
$thing_tpl[18]["level"]=5;
$thing_tpl[18]["image"]="smith_ring3";
$thing_tpl[18]["slot"]=4;
?>