<?
function inet_aton($ip){
  $ip = ip2long($ip);
  ($ip < 0) ? $ip+=4294967296 : true;
  return $ip;
}

function inet_ntoa($int){
  // long2ip ��������� �� ���� ����� �����������
  // INT, �.�. ��������� ��������� inet_ntoa
  return long2ip($int);
}
?>