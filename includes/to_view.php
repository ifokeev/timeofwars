<?
function speek_to_view($s){
$str = $s;
$str = trim($str);
$str = htmlspecialchars($str, ENT_NOQUOTES);
$str = str_replace( '&lt;', '<', $str );
$str = str_replace( '&gt;', '>', $str );
$str = str_replace( '&quot;', '"', $str );
$str = str_replace( '&', '&#38', $str );
$str = str_replace( '"', '&#34', $str );
$str = str_replace( "'", '&#39', $str );
$str = str_replace( '<', '&#60', $str );
$str = str_replace( '>', '&#62', $str );
$str = str_replace( '\0', '', $str );
$str = str_replace( '', '', $str );
$str = str_replace( '\t', '', $str );
$str = str_replace( '../', '. . / ', $str );
$str = str_replace( '..', '. . ', $str );
$str = str_replace( ';', '&#59', $str );
$str = str_replace( '/*', '', $str );
$str = str_replace( '%00', '', $str );
$str = stripslashes( $str );
$str = str_replace( '\\', '&#92', $str );
return $str;
}

function string_words($str,$len){
$counter=0;
$str_ret = '';
for($f=0;$f<strlen($str);$f++){
$counter++;
$str_ret .= $str[$f];
if($counter == $len){
$counter = 0;
$str_ret .= ' ';
}
}
return $str_ret;
}

function string_cut($str,$len){
$str_ret = '';
$word=strtok($str,' ');
while($word !== false){
if(strlen($word) >= $len)
$word = string_words($word,$len);
if($str_ret == '') $str_ret = $word;
else $str_ret = $str_ret.' '.$word;
$word = strtok(' ');
}
return $str_ret;
}


function check_inject(){

$badchars = array(";","'","*","/"," \ ","DROP", "SELECT", "UPDATE", "DELETE", "drop", "select", "update", "delete", "WHERE", "where", "-1", "-2", "-3","-4", "-5", "-6", "-7", "-8", "-9",);

foreach($_POST as $value){

$value = clean_variable($value);

if(in_array($value, $badchars)){
die("Обнаружена SQL Injection - Используйте только символы алфавита!\n<br />\nIP: ".$_SERVER['REMOTE_ADDR']);
} else {

$check = preg_split("//", $value, -1, PREG_SPLIT_OFFSET_CAPTURE);

foreach($check as $char){
if(in_array($char, $badchars)){ die("Обнаружена SQL Injection - Используйте только символы алфавита!\n<br />\nIP: ".$_SERVER['REMOTE_ADDR']); }
}

}
}
}


function clean_variable($var){
$newvar = preg_replace('/[^a-zA-Z0-9\_\-\!\.]/', '', $var);
return $newvar;
}


function make_password($length, $strength = 0) {
$vowels     = 'aeiouy';
$consonants = 'bdghjlmnpqrstvwxzBDGHJLMNPQRSTVWXZ0123456789';
$password   = '';
$alt        = time() % 2;
srand(time());

for ($i = 0; $i < $length; $i++) {
if ($alt == 1) { $password .= $consonants[(rand() % strlen($consonants))]; $alt = 0; }
else { $password .= $vowels[(rand() % strlen($vowels))]; $alt = 1; }
}

return $password;
}

function okon4 ($number, $titles){
$cases = array (2, 0, 1, 1, 1, 2);
return $number.' '.$titles[ ($number%100>4 && $number%100<20)? 2 : $cases[min($number%10, 5)] ];
}

function bbcodeINF($str = ''){
$str = ereg_replace("\r\n", '<br />', $str);
$str = preg_replace("!(\[color=)(.*?)(\])(.*?)(\[\/])!si", '<font color="\\2">\\4</font>', $str);
$str = preg_replace("!(\[t])(.*?)(\[\/t])!si", '<CENTER>\\2</CENTER>', $str);
$str = preg_replace("!(\[b])(.*?)(\[\/b])!si", '<B>\\2</B>', $str);
$str = preg_replace("!(\[i])(.*?)(\[\/i])!si", '<I>\\2</I>', $str);
$str = preg_replace("!(\[u])(.*?)(\[\/u])!si", '<U>\\2</U>', $str);
$str = preg_replace("!(\[q])(.*?)(\[\/q])!si", '<marquee>\\2</marquee>', $str);
$str = preg_replace("!(\[sm])(.*?)(\[\/sm])!si", '<SMALL>\\2</SMALL>', $str);
$str = preg_replace("!(\[\+1])(.*?)(\[\/])!si", '<font size="+1">\\2</font>', $str);
$str = preg_replace("!(\[\+2])(.*?)(\[\/])!si", '<font size="+2">\\2</font>', $str);
return $str;
}

if(!defined('SCRIPTED BY s!.')){ die('<script>top.location.href=\'index.php\'</script>'); }
?>
