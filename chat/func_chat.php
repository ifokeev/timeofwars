<?
function GetMicroTime(){
$t_mtime = split(" ",microtime());
$t_time2 = $t_mtime[1] - floor($t_mtime[1]/1000000)*1000000 + $t_mtime[0];
$t_time2 *= 1000000;
return($t_time2);
}

function TestStroka($in_line){
setlocale(LC_ALL, "ru_RU.CP1251");

$cens_line[1] = "���:::0::: ";
$cens_line[2] = "����:::0::: ";
$cens_line[3] = "���:::0::: ";
$cens_line[4] = "�����:::0::: ";
$cens_line[5] = "����:::0::: ";
$cens_line[6] = "�����:::0::: ";
$cens_line[7] = "���:::0::: ";
$cens_line[8] = "�����:::0::: ";
$cens_line[9] = "���:::0::: ";
$cens_line[10] = "����:::0::: ";
$cens_line[11] = "narod.ru:::1:::���";
$cens_line[12] = "nm.ru:::1:::���";
$cens_line[13] = "chat.ru:::1:::���";
$cens_line[14] = "eliit.com:::1:::���";
$cens_line[15] = "h14.ru:::1:::���";
$cens_line[16] = "combats:::2:::TimeOfWars :)";
$cens_line[17] = "carnage:::2:::TimeOfWars  :)";
$cens_line[18] = "gladiators:::2:::TimeOfWars  :)";
$cens_line[19] = "instincts:::2:::TimeOfWars :)";
$cens_line[20] = "neverlands:::2:::TimeOfWars :)";
$cens_line[21] = "hyperborea:::2:::TimeOfWars :)";
$cens_line[22] = "apeha:::2:::TimeOfWars :)";
$cens_line[23] = "neverfate:::2:::TimeOfWars :)";
$cens_line[24] = "icedland:::2:::TimeOfWars :)";
$cens_line[25] = "nextworld:::1:::���";
$cens_line[26] = "dnbaddict:::2:::TimeOfWars :)";
$cens_line[27] = "otherworlds:::2:::TimeOfWars :)";
$cens_line[28] = "iow:::2:::TimeOfWars :)";
$cens_line[29] = "������:::0::: ";
$cens_line[30] = "�����:::0::: ";
$cens_line[31] = "�����:::0::: ";

$out_line = $in_line;

for($i = 1; $i < count($cens_line); $i++){
list($cens, $type, $str) = explode(':::', $cens_line[$i]);
if ($type == 0){      $out_line = preg_replace("/$cens/i", '<font color="red"><b>[��]</b></font>', $out_line); }
elseif ($type == 2){  $out_line = preg_replace("/$cens/i", $str, $out_line);                                 }
else{                 if ( eregi($cens, $out_line) ){ $out_line = $str; }                                    }
}

return $out_line;
}
?>
